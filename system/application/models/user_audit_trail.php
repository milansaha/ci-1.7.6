<?php
/** 
	* Model Class for User Audit Trail.
	* @pupose		Display User Audit Trail
	*		
	* @filesource	./system/application/models/User_audit_trail.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.User_audit_trail
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-03-07 $	 
*/ 
class User_audit_trail extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		$this->db->select('user_audit_trails.id,user_audit_trails.time_stamp,user_audit_trails.ip_address,user_audit_trails.table_name,user_audit_trails.action,users.full_name as user_name, po_branches.name as branch_name');
		$this->db->from('user_audit_trails');
		$this->db->join('users','users.id=user_audit_trails.user_id','left');
		$this->db->join('po_branches','po_branches.id=user_audit_trails.branch_id','left');
		
		 // search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( user_audit_trails.time_stamp BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['user']) and !empty($cond['user']) and $cond['user'] != -1){	
				$this->db->where('user_audit_trails.user_id', $cond['user']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('user_audit_trails.branch_id', $cond['user_branch']);
				
			}
			if(isset($cond['action_type']) and !empty($cond['action_type'])and $cond['action_type'] != -1){	
				$this->db->like('user_audit_trails.action', $cond['action_type']);	
			}	
			
			
		}
		// end search
		
		
		$this->db->order_by('time_stamp','desc');
		$this->db->limit($offset, $limit);
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond='')
	{
	
		 // search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( user_audit_trails.time_stamp BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['user']) and !empty($cond['user']) and $cond['user'] != -1){	
				$this->db->where('user_audit_trails.user_id', $cond['user']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('user_audit_trails.branch_id', $cond['user_branch']);
				
			}
			if(isset($cond['action_type']) and !empty($cond['action_type'])and $cond['action_type'] != -1){	
				$this->db->like('user_audit_trails.action', $cond['action_type']);	
			}	
			
			
		}
		// end search
		return $this->db->count_all_results('user_audit_trails');
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
    
    function get_detail($id)
    {
        $this->db->select('user_audit_trails.*,users.full_name as user_name, po_branches.name as branch_name');
        $this->db->from('user_audit_trails');
		//$this->db->getwhere('user_audit_trails', array('id' => $id));
		$this->db->where('user_audit_trails.id',$id);
		$this->db->join('users','users.id=user_audit_trails.user_id','left');
		$this->db->join('po_branches','po_branches.id=user_audit_trails.branch_id','left');		
		$query = $this->db->get();
        return $query->result_array();
    }
	
    
  
}
