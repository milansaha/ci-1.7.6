<?php
/** 
	* Employee Promotion Model Class. 
	* @pupose		Manage Employee promotion information
	*		
	* @filesource	\app\model\Employee_termination.php	
	* @package		microfin 
	* @subpackage	microfin.model.Employee_termination
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Employee_termination extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("employee_name", "asc");
        $this->db->select('employee_terminations.id,employees.name as employee_name,employees.code as employee_code,employee_terminations.effective_date,employee_designations.short_name AS designation_name,po_branches.name AS branch_name');
		$this->db->from('employee_terminations');
		$this->db->join('employees', 'employees.id = employee_terminations.employee_id');
        $this->db->join('employee_designations', 'employees.designation_id = employee_designations.id');
        $this->db->join('po_branches', 'employees.branch_id = po_branches.id');
		$this->db->limit($offset,$limit);	
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('employee_terminations');
	}
	
    function add($data)
    {
		$this->db->trans_start();
		$data['id']=$this->get_new_id('employee_terminations', 'id');
		$this->db->query("UPDATE employees SET date_of_discontinue='{$data['effective_date']}', status=0 WHERE id={$data['employee_id']}");		
		$this->db->insert('employee_terminations', $data);
		$this->db->trans_complete();		
		return $this->db->trans_status();		
    }

    function edit($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE employees SET date_of_discontinue='{$data['effective_date']}' WHERE id={$data['employee_id']}");
		$this->db->update('employee_terminations', $data, array('id'=> $data['id']));
		$this->db->trans_complete();		
		return $this->db->trans_status();			
    }
	
	function read($Employee_termination_id)
    {
        $query=$this->db->getwhere('employee_terminations', array('id' => $Employee_termination_id));
		return $query->result();
    }
	
	function delete($Employee_termination_id)
	{
		$this->db->trans_start();
		$query=$this->db->query("SELECT employee_id,effective_date FROM employee_terminations WHERE id=$Employee_termination_id");
		$query=$query->result();
		if(!empty($query))
		{
	    	$employee_id=$query[0]->employee_id;
	    	$effective_date=$query[0]->effective_date;
		}
		//$this->db->query("UPDATE employees SET date_of_discontinue='{$data['effective_date']}', status=1 WHERE id={$data['employee_id']}");
		$this->db->query("UPDATE employees SET date_of_discontinue=NULL,status=1 WHERE id='$employee_id'");
		$this->db->delete('employee_terminations', array('id'=> $Employee_termination_id));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}       
}
