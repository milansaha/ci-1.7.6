<?php
/** 
	* Employee Designation Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/user_access_logs.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.user_access_logs
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-03-06 $	 
*/ 
class User_access_log extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		$this->db->select('user_access_logs.id,user_access_logs.time_stamp,user_access_logs.ip_address,user_access_logs.is_data_submitted,user_access_logs.action,users.full_name as user_name, po_branches.name as branch_name');
		$this->db->from('user_access_logs');
		$this->db->join('users','users.id=user_access_logs.user_id','left');
		$this->db->join('po_branches','po_branches.id=user_access_logs.branch_id','left');
		 // search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( user_access_logs.time_stamp BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['user']) and !empty($cond['user']) and $cond['user'] != -1){	
				$this->db->where('user_access_logs.user_id', $cond['user']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('user_access_logs.branch_id', $cond['user_branch']);
				
			}
			if(isset($cond['action_type']) and !empty($cond['action_type'])and $cond['action_type'] != -1){	
				$this->db->like('user_access_logs.action', $cond['action_type']);	
			}	
			
			
		}
		// end search
		
		$this->db->order_by('time_stamp','desc');
		$this->db->limit($offset, $limit);		
        $query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond)
	{
		 // search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( user_access_logs.time_stamp BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['user']) and !empty($cond['user']) and $cond['user'] != -1){	
				$this->db->where('user_access_logs.user_id', $cond['user']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('user_access_logs.branch_id', $cond['user_branch']);
				
			}
			if(isset($cond['action_type']) and !empty($cond['action_type'])and $cond['action_type'] != -1){	
				$this->db->like('user_access_logs.action', $cond['action_type']);	
			}	
			
			
		}
		// end search
		return $this->db->count_all_results('user_access_logs');
	}
	
	function read($designation_id)
    {
        $query=$this->db->getwhere('employee_designations', array('id' => $designation_id));
		return $query->result();
    }
    
    function add($user_id,$ip_address,$branch_id,$branch_date,$action,$is_data_submitted)
    {
		$data['id'] = $this->get_new_id('user_access_logs', 'id');
		$data['time_stamp']=time();		
		$data['user_id']=$user_id;
		$data['ip_address']=$ip_address;
		$data['branch_id']=$branch_id;
		$data['branch_date']=$branch_date;
		$data['is_data_submitted']=$is_data_submitted;
		$data['action']=$action;
        return $this->db->insert('user_access_logs', $data);
	}
	
	function get_user_list()
    {
        $users = $this->db->query("SELECT id, full_name FROM users ORDER BY full_name ASC");			
		return $users->result();  
    }
    
    function get_branch_list()
    {
        $branches = $this->db->query("SELECT id, name FROM po_branches ORDER BY name ASC");			
		return $branches->result();  
    }
    
   

}
