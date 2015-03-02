<?php
class Config_holiday extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }  
    
    function get_list($offset,$limit,$cond)
    {
		$this->db->select('config_holidays.id,config_holidays.branch_id,config_holidays.samity_id,po_branches.name as branch_name,samities.name as samity_name,config_holidays.holiday_date,config_holidays.holiday_type,config_holidays.description');
		$this->db->from('config_holidays');
		$this->db->join('samities','samities.id = config_holidays.samity_id','left');
		$this->db->join('po_branches','po_branches.id=config_holidays.branch_id','left');
		
		// search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( config_holidays.holiday_date BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['holiday_type']) and !empty($cond['holiday_type']) and $cond['holiday_type'] != -1){	
				$this->db->where('config_holidays.holiday_type', $cond['holiday_type']);				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('config_holidays.branch_id', $cond['user_branch']);				
			}			
		}
		// end search		
		$this->db->order_by('holiday_date','desc');
		$this->db->limit($offset, $limit);		
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_list2($offset,$limit)
	{
			#$query = $this->db->get('config_holidays', $offset, $limit);
			$query = $this->db->query("SELECT h.id,br.name as branch_name,s.name as samity_name,h.holiday_date,h.holiday_type,h.description
									from config_holidays as h
									LEFT JOIN samities as s                        
									ON s.id = h.samity_id
									LEFT JOIN po_branches as br
									ON br.id=h.branch_id
									LIMIT $offset OFFSET $limit");  

			return $query->result();
		}
    function holiday_unique($date,$branch_id = 0,$samity_id=0,$holiday_id) {
		
		$edit_cond = (empty($holiday_id))?"":" AND id<>$holiday_id ";
		$query = "SELECT id FROM config_holidays 
				WHERE holiday_date = '$date' 
				AND (branch_id = $branch_id OR branch_id IS NULL ) AND (samity_id = $samity_id OR branch_id IS NULL) $edit_cond LIMIT 1;";
		$result = $this->db->query($query);
		//echo $query;		
		return isset($result->row()->id)?true:false;
	}
	function row_count($cond)
	{
		// search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( config_holidays.holiday_date BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['holiday_type']) and !empty($cond['holiday_type']) and $cond['holiday_type'] != -1){	
				$this->db->where('config_holidays.holiday_type', $cond['holiday_type']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('config_holidays.branch_id', $cond['user_branch']);
				
			}				
			
			
		}
		// end search
		return $this->db->count_all_results('config_holidays');
	}
	
    function add($data)
    {
		$data['id']=$this->get_new_id('config_holidays', 'id');
        return $this->db->insert('config_holidays', $data);
    }

    function edit($data)
    {
        return $this->db->update('config_holidays', $data, array('id'=> $data['id']));
    }
	
	function read($config_holiday_id)
    {
        $query=$this->db->getwhere('config_holidays', array('id' => $config_holiday_id));
		return $query->row();
    }
	
	function delete($config_holiday_id)
	{
		return $this->db->delete('config_holidays', array('id'=> $config_holiday_id));
	}
	
	//This function is for listing of departments
	function get_branch()
	{		
		$branch_info = $this->db->query("SELECT id as branch_id,name as branch_name FROM po_branches ORDER BY branch_name ASC");			
		return $branch_info->result();  
	}
	//function get_samity()
//	{		
//		$samity_info = $this->db->query("SELECT id as samity_id,CONCAT('(',code,')',name)  as samity_name FROM samities ORDER BY samity_name ASC");			
//		return $samity_info->result();  
//    }
	function get_samity_by_branch($branch_id = -1)
	{		
		$branch_id = (empty($branch_id))?"-1":$branch_id;
		$samity_info = $this->db->query("SELECT id as samity_id,CONCAT('(',code,')',name)  as samity_name FROM samities where branch_id = $branch_id ORDER BY samity_name ASC");			
		return $samity_info->result();  
    }
/**
 * @return holiday array list
 */
	function get_samity_wise_monthly_holiday_list($samity_id,$branch_id,$year,$month){
		
		if(!is_numeric($samity_id) || !is_numeric($branch_id) || !is_numeric($year) || !is_numeric($month)) {
			return false;
		}
		
		$holiday_list = $this->db->query("SELECT holiday_date FROM config_holidays WHERE 
YEAR(holiday_date) = $year AND MONTH(holiday_date) = $month
AND ( (branch_id IS NULL AND samity_id IS NULL ) OR  branch_id = $branch_id OR samity_id = $samity_id)
ORDER BY holiday_date");

		$holiday_list = $holiday_list->result();  
		$holidays = array();
		if(!empty($holiday_list)){
			foreach($holiday_list as $holiday)	{
				$holidays[] = $holiday->holiday_date;
			}
		}
//print_r($holidays);
//die;			
		return $holidays;  
	}
	/** 	
	 * branch_manager_report_data Beginning of the week
	 * @Auth: Taposhi Rabeya
	 * @date: 31-Mar-2011   	
	 * @return branch wise holiday array list
 	*/
	function get_month_wise_holiday_list($branch_id,$year,$month){
		
		if(!is_numeric($branch_id) || !is_numeric($year) || !is_numeric($month)) {
			return false;
		}
		
		$holiday_list = $this->db->query("SELECT holiday_date FROM config_holidays WHERE 
				YEAR(holiday_date) = '$year'
				AND MONTH(holiday_date) = '$month'
				AND ( branch_id = $branch_id OR branch_id=0)
				ORDER BY holiday_date");

		$holiday_list = $holiday_list->result();  
		$holidays = array();
		if(!empty($holiday_list)){
			foreach($holiday_list as $holiday)	{
				$holidays[$holiday->holiday_date] = $holiday->holiday_date;
			}
		}		
		return $holidays;  
	}
}
