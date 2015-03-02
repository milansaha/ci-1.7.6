<?php
/** 
	* Employee Promotion Model Class. 
	* @pupose		Manage Employee promotion information
	*		
	* @filesource	\app\model\employee_promotion.php	
	* @package		microfin 
	* @subpackage	microfin.model.employee_promotion
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Employee_branch_transfer extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		$this->db->order_by("employee_name", "asc");
        $this->db->select('employee_branch_transfers.id as id,employees.id as employee_id,employees.code as employee_code,employees.name as employee_name,employee_new_branch.name as
	        employee_new_branch_name,employee_old_branch.name 
			as employee_old_branch_name,employee_branch_transfers.effective_date');
		$this->db->from('employee_branch_transfers');
		$this->db->join('employees', 'employees.id = employee_branch_transfers.employee_id');
		$this->db->join('po_branches as employee_new_branch', 'employee_new_branch.id = employee_branch_transfers.new_branch_id');	
		$this->db->join('po_branches as employee_old_branch', 'employee_old_branch.id = employee_branch_transfers.old_branch_id');
		$this->db->order_by("id"); 
		// search
		if(is_array($cond)){
				
			if(isset($cond['emp_id']) and !empty($cond['emp_id']) and $cond['emp_id'] != -1){	
				$this->db->where('employee_branch_transfers.employee_id', $cond['emp_id']);				
			}
			if(isset($cond['emp_branch']) and !empty($cond['emp_branch']) and $cond['emp_branch'] != -1){	
				//$this->db->like('employee_histories.old_branch_id', $cond['emp_branch']);				
				$where = "( employee_branch_transfers.old_branch_id LIKE '{$cond['emp_branch']}' OR employee_branch_transfers.new_branch_id LIKE '{$cond['emp_branch']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);			
			}			
		}
		// end search
			
		$this->db->limit($offset,$limit);	
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond)
	{
		//$this->db->where('employee_histories.type_of_operation','Branch Change');
		// search
		if(is_array($cond)){
				
			if(isset($cond['emp_id']) and !empty($cond['emp_id']) and $cond['emp_id'] != -1){	
				$this->db->where('employee_branch_transfers.employee_id', $cond['emp_id']);
				
			}
			if(isset($cond['emp_branch']) and !empty($cond['emp_branch']) and $cond['emp_branch'] != -1){	
				$this->db->like('employee_branch_transfers.old_branch_id', $cond['emp_branch']);				
			}		
		}
		// end search
		return $this->db->count_all_results('employee_branch_transfers');
	}
	
    function add($data)
    {
		$this->db->trans_start();
		$data['id']=$this->get_new_id('employee_branch_transfers', 'id');
		$this->db->query("UPDATE employees SET branch_id='{$data['new_branch_id']}' WHERE id={$data['employee_id']}");		
		$this->db->insert('employee_branch_transfers', $data);
		$this->db->trans_complete();		
		return $this->db->trans_status();	
    }

    function edit($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE employees SET branch_id='{$data['new_branch_id']}' WHERE id={$data['employee_id']}");
		$this->db->update('employee_branch_transfers', $data, array('id'=> $data['id']));
		$this->db->trans_complete();		
		return $this->db->trans_status();		
    }
	
	function read($employee_branch_transfer_id)
    {
       $query=$this->db->getwhere('employee_branch_transfers', array('id' => $employee_branch_transfer_id));
		return $query->row();
    }
	
	function delete($employee_branch_transfer_id)
	{
		return $this->db->delete('employee_branch_transfers', array('id'=> $employee_branch_transfer_id));
	}
    
	function get_new_branch_info($new_branch_id = -1)
    {
       // $saving_id = empty($old_branch_id)?"-1":$old_branch_id;
		$branch_information = $this->db->query("SELECT po.id as new_branch_id,po.name AS new_branch_name FROM po_branches AS po WHERE po.id=$new_branch_id");	
		return  $branch_information->result();  
    }	

    
    function get_new_branch_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_branches');  
		return $query->result();
    }
	function get_old_branch_list_by_employee($employee_id)
    {
      	 //if(empty($employee_id)) return array();
        $branch = $this->db->query("SELECT po_branches.id as branch_id,po_branches.name as branch_name FROM employees,po_branches where employees.id=$employee_id and employees.branch_id=po_branches.id  ORDER BY branch_name ASC");
		return $branch->result();  
    }   
	function get_max_transfer_info($employee_branch_transfer_id)
    {
        $query=$this->db->query("SELECT * FROM employee_branch_transfers WHERE id=$employee_branch_transfer_id");
		$query=$query->result();		
		if(!empty($query))
		{
	    	$employee_id=$query[0]->employee_id;
			$employee_max_transfer_id=$this->db->query("SELECT max(id) as id FROM employee_branch_transfers WHERE employee_id=$employee_id");
			$employee_max_transfer_id=$employee_max_transfer_id->row()->id;
			if($employee_max_transfer_id!=$employee_branch_transfer_id)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 2;
		}
    } 
	/*function get_last_effective_date($employee_id)
    {
        $employee_id= empty($employee_id)?"-1":$employee_id;
		$information = $this->db->query("SELECT MAX(date_of_operation) AS date_of_operation FROM employee_histories WHERE employee_id=$employee_id 
		AND type_of_operation='Branch Change'");			
		if(!empty($information))
		{
			return $information->row()->date_of_operation; 
		} 
    }  */
    function get_last_effective_date($employee_branch_transfer_id,$employee_id)
    {
        $employee_id= empty($employee_id)?"-1":$employee_id;
        $employee_branch_transfer_id= empty($employee_branch_transfer_id)?"-1":$employee_branch_transfer_id;        
		$designation_information = $this->db->query("SELECT MAX(effective_date) AS date_of_operation FROM employee_branch_transfers WHERE employee_id=$employee_id 
		AND employee_branch_transfers.id not in ($employee_branch_transfer_id)");			
		if(!empty($designation_information))
		{
			return $designation_information->row()->date_of_operation; 
		} 
    }     
}
