<?php
/** 
	* Employee Informatin Model Class.
	* @pupose		Manage Employee information
	*		
	* @filesource	./system/application/models/employee.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.employee
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-05 $	 
*/ 
class Employee extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    /**
	 * @updated Anis Alamgir
	 * @date 18-Jan-2010
	 * Add new param $cond=""
	 */
    function get_list($offset,$limit,$cond='')
    {
        $this->db->select('employees.id,employees.code,employees.date_of_joining,employees.name,employees.status AS current_status,employee_designations.name AS designation_name');
		$this->db->from('employees');
		$this->db->join('employee_designations', 'employees.designation_id = employee_designations.id','left');
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$this->db->like('employees.name', $cond['name']);	
			}			
			if(isset($cond['employee_designation']) and !empty($cond['employee_designation']) and $cond['employee_designation'] != -1){	
				$this->db->where('employees.designation_id', $cond['employee_designation']);
				
			}
		}
		// end search       
		$this->db->limit($offset, $limit);
		$this->db->order_by('employees.name','ASC');
		$query = $this->db->get(); 
        return $query->result();    
    }
	
    /**
	 * @updated Anis Alamgir
	 * @date 18-Jan-2010
	 * Add new param $cond=""
	 */
	function row_count($cond='')
	{
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$this->db->like('employees.name', $cond['name']);	
			}			
			if(isset($cond['employee_designation']) and !empty($cond['employee_designation']) and $cond['employee_designation'] != -1){	
				$this->db->where('employees.designation_id', $cond['employee_designation']);
				
			}
		}
		// end search        
		return $this->db->count_all_results('employees');
	}
	
    function add($data)
    {
        $data['id'] = $this->get_new_id('employees','id');
        return $this->db->insert('employees', $data);
    }

    function edit($data)
    {
        return $this->db->update('employees', $data, array('id'=> $data['id']));
    }
	
	function read($employee_id)
    {
        $query=$this->db->getwhere('employees', array('id' => $employee_id));
		return $query->row();
    }
	
	function delete($employee_id)
	{
		return $this->db->delete('employees', array('id'=> $employee_id));
	}
	
	//This function is for listing of field officer
	function get_field_officer_info()
	{		
		$this->db->select('employees.id AS field_officer_id, employees.name AS field_officer_name');
		$this->db->from('employees');		
		$this->db->where(array('employees.is_field_officer' => '1'));
		$this->db->order_by('employees.name','ASC');
		$get_field_officer_info = $this->db->get(); 
        return $get_field_officer_info->result();          
	}
	function get_active_employee_list()
    {
		$this->db->select('id,name,code');		
		$this->db->where(array('employees.status' => '1'));
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('employees');  
		return $query->result();
    }
    function get_employee_list()
    {
		$this->db->select('id,name,code');
		$this->db->order_by('name','ASC');
		$query = $this->db->get('employees');
		return $query->result();
    }
	function get_employee_joining_date($employee_id=null)
	{		
		$this->db->select('employees.date_of_joining');
		$this->db->from('employees');		
		$this->db->where(array('employees.id' =>$employee_id));		
		$query = $this->db->get(); 
		$query=$query->row();
        return $query->date_of_joining;          
	}
    /*
     * @Author : Imtiaz
     */
    function read_view($employee_id)
    {
        $this->db->where('employees.id', $employee_id);
        $this->db->select('employees.*,
                        po_branches.name as branch_name,
                        po_branches.code as branch_code,
                        employee_designations.name as emp_designation,
                        educational_qualifications.name as edu_qualification');
        $this->db->from('employees');
        $this->db->join('po_branches', 'employees.branch_id = po_branches.id','left');
        $this->db->join('employee_designations', 'employees.designation_id = employee_designations.id','left');
        $this->db->join('educational_qualifications', 'employees.last_achieved_degree = educational_qualifications.id','left');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

}
