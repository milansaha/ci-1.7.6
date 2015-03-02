<?php
/** 
	* Employee Designation Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/Employee_designation.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.Employee_designation
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Employee_designation extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {       
        $this->db->select('employee_designations.*,employee_departments.name AS department_name');
		$this->db->from('employee_designations');
		$this->db->join('employee_departments', 'employee_departments.id = employee_designations.department_id');
		$this->db->limit($offset,$limit);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('employee_designations');
	}
	
    function add($data)
    {
        return $this->db->insert('employee_designations', $data);
    }

    function edit($data)
    {
        return $this->db->update('employee_designations', $data, array('id'=> $data['id']));
    }
	
	function read($designation_id)
    {
        $query=$this->db->getwhere('employee_designations', array('id' => $designation_id));
		return $query->row();
    }
	
	function delete($designation_id)
	{
		return $this->db->delete('employee_designations', array('id'=> $designation_id));
	}
	
	//This function is for listing of designations
	function get_employee_designations()
	{		
		$this->db->select('id AS designation_id, name AS designation_name');		
		$this->db->order_by('designation_name','ASC');		
		$department_info = $this->db->get('employee_designations');  
		return $department_info->result();
	}
	

}
