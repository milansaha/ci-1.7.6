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
class Samity_employee_change extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		//set samity_id from condition
		if(!empty($cond['samity_id'])){
			$samity_id=$cond['samity_id'];
		}else{
			$samity_id='';
		}
		//set emp_id from condition
		if((!empty($cond['emp_id']))&&($cond['emp_id']!=0)){
			$emp_id=$cond['emp_id'];
		}else{
			$emp_id='';
		}
		//handle samity_id & emp_id isset option and set where clause
		if(!empty($samity_id)&&!empty($emp_id))
		{
			$this->db->where(
							array('samity_employee_changes.new_employee_id'=>$emp_id,
								'samity_employee_changes.samity_id'=>$samity_id)
						);
		}elseif(!empty($samity_id)&&empty($emp_id))
		{
			$this->db->where('samity_employee_changes.samity_id',$samity_id);
		}
		elseif(empty($samity_id)&&!empty($emp_id))
		{
			$this->db->where('samity_employee_changes.new_employee_id',$emp_id);
		}
        $this->db->select('samity_employee_changes.id,samity_id,samities.name as samity_name,previous_employee_id,previous_employees.name as previous_employee_name,new_employee_id,new_employees.name as new_employee_name,effective_date,comment');
		$this->db->from('samity_employee_changes');
		$this->db->join('employees as previous_employees', 'previous_employees.id = samity_employee_changes.previous_employee_id');
		$this->db->join('employees as new_employees', 'new_employees.id = samity_employee_changes.new_employee_id');
		$this->db->join('samities', 'samities.id = samity_employee_changes.samity_id');
		$this->db->order_by('effective_date','desc'); 			
		$this->db->limit($offset,$limit);	
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		$this->db->from('samity_employee_changes');
		$this->db->join('samities', 'samities.id = samity_employee_changes.samity_id');
		return $this->db->count_all_results();
	}
	//check future dated entry of particular samity exsists or not
	function check_future_dated_entry_exsist($samity_employee_changes_id)
	{
		$this->db->from('samity_employee_changes');
		$this->db->join('samities', 'samities.id = samity_employee_changes.samity_id');
		return $this->db->count_all_results();
	}
	// check same samity have any entry in same date during new entry
	function samity_multiple_entry($samity_id,$effective_date)
	{
		$query = $this->db->query("SELECT COUNT(id) AS count_row FROM samity_employee_changes WHERE samity_id = '$samity_id' AND effective_date = '$effective_date'");
		$query = $query->result();
		$count_row = $query['0']->count_row;
		return $count_row;
	}
	// check any entry have of this samity on future date during new entry
	function samity_future_entry_exsist($samity_id,$effective_date)
	{
		$query = $this->db->query("SELECT COUNT(id) AS count_entry FROM samity_employee_changes WHERE samity_id = '$samity_id' AND effective_date > '$effective_date'");
		$query = $query->result();
		$count_entry = $query['0']->count_entry;
		return $count_entry;
	}
	
	function read($samity_id)
    {
		$this->db->where('samity_employee_changes.id',$samity_id);
		$this->db->select('samity_employee_changes.id,samity_id,samities.name as samity_name,previous_employee_id,previous_employees.name as previous_employee_name,new_employee_id,new_employees.name as new_employee_name,effective_date,comment');
		$this->db->from('samity_employee_changes');
		$this->db->join('employees as previous_employees', 'previous_employees.id = samity_employee_changes.previous_employee_id');
		$this->db->join('employees as new_employees', 'new_employees.id = samity_employee_changes.new_employee_id');
		$this->db->join('samities', 'samities.id = samity_employee_changes.samity_id');
		$this->db->order_by('effective_date','desc'); 			
		$query = $this->db->get();
		return $query->row();
    }
    
	function add($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE samities SET samities.field_officer_id = '{$data['new_employee_id']}' WHERE samities.id = {$data['samity_id']}");
		$this->db->insert('samity_employee_changes', $data);
		$this->db->trans_complete();		
		return $this->db->trans_status();
    }
	
    function edit($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE samities SET samities.field_officer_id = '{$data['new_employee_id']}' WHERE samities.id = {$data['samity_id']}");
		$this->db->update('samity_employee_changes', $data, array('id'=> $data['id']));
		$this->db->trans_complete();
		return $this->db->trans_status();
    }

	function delete($samity_employee_changes_id)
	{
		$this->db->where('samity_employee_changes.id',$samity_employee_changes_id);
		$this->db->select('samity_employee_changes.id,samity_id,previous_employee_id,new_employee_id,effective_date,comment');
		$this->db->from('samity_employee_changes');
		$this->db->order_by('effective_date','desc'); 			
		$query = $this->db->get();
		$read_samity_changes = $query->row();
		$field_officer_id = $read_samity_changes->new_employee_id;
		$samity_id = $read_samity_changes->samity_id;
		$this->db->trans_start();
		$this->db->query("UPDATE samities SET samities.field_officer_id = '{$field_officer_id}' WHERE samities.id = {$samity_id}");
		$this->db->delete('samity_employee_changes', array('id'=> $samity_employee_changes_id));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
    
	function get_new_branch_info($new_branch_id = -1)
    {
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
    
	function get_old_field_officer_list($samity_id)
    {
        $branch = $this->db->query("SELECT employees.name,employees.code,employees.id FROM samities JOIN employees ON samities.field_officer_id = employees.id WHERE samities.id = '$samity_id'");
		return $branch->result();  
    }   
	function get_max_transfer_info($employee_branch_transfer_id)
    {
        $query=$this->db->query("SELECT * FROM employee_histories WHERE id=$employee_branch_transfer_id AND type_of_operation='Branch Change'");
		$query=$query->result();		
		if(!empty($query))
		{
	    	$employee_id=$query[0]->employee_id;
			$employee_max_transfer_id=$this->db->query("SELECT max(id) as id FROM employee_histories WHERE employee_id=$employee_id AND type_of_operation='Branch Change'");
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
    
	function get_last_effective_date($employee_id)
    {
        $employee_id= empty($employee_id)?"-1":$employee_id;
		$information = $this->db->query("SELECT MAX(date_of_operation) AS date_of_operation FROM employee_histories WHERE employee_id=$employee_id 
		AND type_of_operation='Branch Change'");			
		if(!empty($information))
		{
			return $information->row()->date_of_operation; 
		} 
    }     
}
