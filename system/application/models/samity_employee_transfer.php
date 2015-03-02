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
class Samity_employee_transfer extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $this->db->select('samity_employee_transfers.id,samity_id,samities.name as samity_name,previous_employee_id,previous_employees.name as previous_employee_name,new_employee_id,new_employees.name as new_employee_name,effective_date,comment');
		$this->db->from('samity_employee_transfers');
		$this->db->join('employees as previous_employees', 'previous_employees.id = samity_employee_transfers.previous_employee_id');
		$this->db->join('employees as new_employees', 'new_employees.id = samity_employee_transfers.new_employee_id');
		$this->db->join('samities', 'samities.id = samity_employee_transfers.samity_id');
		$this->db->order_by('effective_date','desc'); 			
		$this->db->limit($offset,$limit);	
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		$this->db->from('samity_employee_transfers');
		$this->db->join('samities', 'samities.id = samity_employee_transfers.samity_id');
		return $this->db->count_all_results();
	}
	
    function add($data)
    {
		$this->db->trans_start();
		$data['id']=$this->get_new_id('employee_histories', 'id');
		$this->db->query("UPDATE employees SET branch_id='{$data['new_branch_id']}' WHERE id={$data['employee_id']}");		
		$this->db->insert('employee_histories', $data);
		$this->db->trans_complete();		
		return $this->db->trans_status();	
    }

    function edit($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE employees SET branch_id='{$data['new_branch_id']}' WHERE id={$data['employee_id']}");
		$this->db->update('employee_histories', $data, array('id'=> $data['id']));
		$this->db->trans_complete();		
		return $this->db->trans_status();		
    }
	
	function read($employee_branch_transfer_id)
    {
       $query=$this->db->getwhere('employee_histories', array('id' => $employee_branch_transfer_id));
		return $query->row();
    }
	
	function delete($employee_branch_transfer_id)
	{
		return $this->db->delete('employee_histories', array('id'=> $employee_branch_transfer_id));
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
