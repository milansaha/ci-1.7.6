<?php
class Employee_department extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by('name','asc');
        $query = $this->db->get('employee_departments', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('employee_departments');
	}
	
    function add($data)
    {
        return $this->db->insert('employee_departments', $data);
    }

    function edit($data)
    {
        return $this->db->update('employee_departments', $data, array('id'=> $data['id']));
    }
	
	function read($department_id)
    {
        $query=$this->db->getwhere('employee_departments', array('id' => $department_id));
		return $query->row();
    }
	
	function delete($department_id)
	{
		return $this->db->delete('employee_departments', array('id'=> $department_id));
	}
	//This function is for listing of departments
	function get_employee_departments()
	{		
		$this->db->select('id AS department_id, name AS department_name');		
		$this->db->order_by('department_name','ASC');		
		$department_info = $this->db->get('employee_departments');  
		return $department_info->result();
	}
}
