<?php
/** 
	* PO Branch Informatin Model Class.
	* @pupose		Manage Po Funding Organization information
	*		
	* @filesource	./system/application/models/po_branch.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_branch
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-05 $	 
*/ 
class Po_branch extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		// search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( po_branches.opening_date BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['name']) and !empty($cond['name']) and $cond['name'] != -1){	
				//$this->db->like('po_branches.name', $cond['name']);
				$where = "( po_branches.name LIKE '%{$cond['name']}%' OR po_branches.code LIKE '%{$cond['name']}%')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
				
			}
						
		}
		// end search
		
		$this->db->order_by("code", "asc");
        $query = $this->db->get('po_branches', $offset, $limit);        
        return $query->result();
    }
	
	function row_count($cond)
	{
		// search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( po_branches.opening_date BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['name']) and !empty($cond['name']) and $cond['name'] != -1){	
				//$this->db->where('po_branches.name', $cond['name']);
				$where = "( po_branches.name LIKE '%{$cond['name']}%' OR po_branches.code LIKE '%{$cond['name']}%')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
				
			}
						
		}
		// end search
		return $this->db->count_all_results('po_branches');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('po_branches', 'id');
        return $this->db->insert('po_branches', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_branches', $data, array('id'=> $data['id']));
    }
	
	function read($po_branch_id)
    {
        $query=$this->db->getwhere('po_branches', array('id' => $po_branch_id));
		return $query->row();
    }
	
	function delete($po_branch_id)
	{
		return $this->db->delete('po_branches', array('id'=> $po_branch_id));
	}
	
	//This function is for listing of branches
	function get_branches_info()
	{		
		$this->db->select('id AS branch_id,name AS branch_name,code AS branch_code');		
		$this->db->order_by('code','ASC');		
		$query = $this->db->get('po_branches');  
		return $query->result();
	}
	//This function is for geting selected branche information
	function get_selected_branches_info($branch_id=null)
    {       
		$sql = "SELECT po_branches.name as branch_name,po_branches.code,po_branches.address FROM po_branches WHERE id = ?";
		$sql=$this->db->query($sql, array($branch_id)); 
		$branch_info=array();
		foreach ($sql->result_array() as $row)
		{
		   	$branch_info['name']=$row['branch_name'];
			$branch_info['code']=$row['code'];
			$branch_info['address']=$row['address'];		   
		}
		return $branch_info;
    }
	/**
	 * @uses Regular_and_general_report(Field worker's report)
	 * @Author: Taposhi Rabeya
	 * @Date: 07-02-2011
	 */
	function get_field_officer_branches_info($employee_id=null,$from_date=null,$to_date=null)
	{		
		$this->db->select('id AS branch_id, name AS branch_name');		
		$this->db->order_by('branch_name','ASC');		
		$query = $this->db->get('po_branches');  
		return $query->result();
	}
	/**
	 * Get branch Code
	 *
	 * @return	string
	 */
	function get_branch_code()
	{
		$user=$this->session->userdata('system.user');
		$sql = "SELECT code FROM po_branches WHERE id = ? LIMIT 1;";
		$sql=$this->db->query($sql, array($user['branch_id'])); 
		return $sql->row()->code;
	}
    /*
     * @Author: Matin
     * @Modification Date : 06-04-2011
     * @Use : Check duplicate head office entry
     */
    function check_duplicate_head_office($branch_id=null)
    {
        if(isset ($branch_id) and !empty ($branch_id))
        {
            $this->db->where("id != $branch_id");
        }
        $this->db->where('is_head_office','1');
        return $this->db->count_all_results('po_branches');
    }
}
