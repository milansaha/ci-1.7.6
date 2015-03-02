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
class Employee_promotion extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("employee_name", "asc");
        $this->db->select('employee_promotions.id,employees.id as employee_id,employees.code as employee_code,employee_new_designation.id as designation_id,employees.name as employee_name, employee_new_designation.name as employee_new_designation_name,employee_old_designation.name 
as employee_old_designation_name,employee_promotions.effective_date');
		$this->db->from('employee_promotions');
		$this->db->join('employees', 'employees.id = employee_promotions.employee_id');
		$this->db->join('employee_designations as employee_new_designation', 'employee_new_designation.id = employee_promotions.new_designation_id');	
		$this->db->join('employee_designations as employee_old_designation', 'employee_old_designation.id = employee_promotions.old_designation_id');	
		//$this->db->where('employee_histories.type_of_operation','Designation Change');
		$this->db->order_by("id"); 
		$this->db->limit($offset,$limit);	
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		//$this->db->where('employee_histories.type_of_operation','Designation Change');
		return $this->db->count_all_results('employee_promotions');
	}
	
    function add($data)
    {
		$this->db->trans_start();
		$data['id']=$this->get_new_id('employee_promotions', 'id');
		$this->db->query("UPDATE employees SET designation_id='{$data['new_designation_id']}' WHERE id={$data['employee_id']}");		
		$this->db->insert('employee_promotions', $data);
		$this->db->trans_complete();		
		return $this->db->trans_status();		
    }

    function edit($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE employees SET designation_id='{$data['new_designation_id']}' WHERE id={$data['employee_id']}");
		$this->db->update('employee_promotions', $data, array('id'=> $data['id']));
		$this->db->trans_complete();		
		return $this->db->trans_status();
    }
	
	function read($employee_promotion_id)
    {
        $query=$this->db->getwhere('employee_promotions', array('id' => $employee_promotion_id));
		return $query->row();
    }
	
	function delete($employee_promotion_id)
	{
		return $this->db->delete('employee_promotions', array('id'=> $employee_promotion_id));
	}
    
    
    function get_employee_list()
    {
		$this->db->select('id,name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('employees');  
		return $query->result();
    }
    function get_new_designation_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('employee_designations');  
		return $query->result();
    }	
    function get_old_designation_list_by_employee($employee_id)
    {
      	 
	//if(empty($employee_id)) return array();
        $designation = $this->db->query("SELECT employee_designations.id as designation_id,employee_designations.name as designation_name
				   FROM employees,employee_designations 
                                   WHERE employees.id=$employee_id and employees.designation_id=employee_designations.id  ORDER BY designation_name ASC");
	return $designation->result();  
    }    

	function get_new_designation_info($new_designation_id = -1)
    {
        $saving_id = empty($new_designation_id)?"-1":$new_designation_id;
		$designation_information = $this->db->query("SELECT ed.id as new_designation_id,ed.name AS new_designation_name
FROM employee_designations AS ed
WHERE ed.id=$new_designation_id");			
		return  $designation_information->result();  
    }	
	function get_max_transfer_info($employee_promotion_id)
    {
        $query=$this->db->query("SELECT * FROM employee_promotions WHERE id=$employee_promotion_id");
		$query=$query->result();
		if(!empty($query))
		{
	    	$employee_id=$query[0]->employee_id;
			$employee_max_transfer_id=$this->db->query("SELECT max(id) as id FROM employee_promotions WHERE employee_id=$employee_id");
			$employee_max_transfer_id=$employee_max_transfer_id->row()->id;
			if($employee_max_transfer_id!=$employee_promotion_id)
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
	function get_last_effective_date($employee_promotion_id,$employee_id)
    {
        $employee_id= empty($employee_id)?"-1":$employee_id;
        $employee_promotion_id= empty($employee_promotion_id)?"-1":$employee_promotion_id;        
		$designation_information = $this->db->query("SELECT MAX(effective_date) AS date_of_operation FROM employee_promotions WHERE employee_id=$employee_id 
		AND employee_promotions.id not in ($employee_promotion_id)");			
		if(!empty($designation_information))
		{
			return $designation_information->row()->date_of_operation; 
		} 
    }  
}
