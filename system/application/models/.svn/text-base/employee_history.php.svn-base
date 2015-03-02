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
class Employee_history extends MY_Model {

    
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
    
	
    function add($data)
    {
        return $this->db->insert('employee_histories', $data);
    }

    function edit($data)
    {
        return $this->db->update('employee_histories', $data, array('id'=> $data['id']));
    }
	
	function read($employee_id)
    {
        $query=$this->db->getwhere('employee_histories', array('id' => $employee_id));
		return $query->result();
    }
	
	function delete($employee_id)
	{
		return $this->db->delete('employee_histories', array('id'=> $employee_id));
	}
		

}
