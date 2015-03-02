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
class Employee_product_transfer extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		$this->db->order_by("employee_name", "asc");
		$this->db->select('employees.id,ept.id,NAME AS employee_name,ept.old_product as employee_old_product_name,ept.new_product as
                employee_new_product_name,ept.date_of_operation'); 
		$this->db->from('employee_histories AS ept'); 
		$this->db->join('employees','ept.employee_id=employees.id');
		$this->db->where('ept.type_of_operation','product Change');		
		// search
		if(is_array($cond)){
				
			if(isset($cond['emp_id']) and !empty($cond['emp_id']) and $cond['emp_id'] != -1){	
				$this->db->where('ept.employee_id', $cond['emp_id']);
				
			}
			if(isset($cond['emp_product']) and !empty($cond['emp_product']) and $cond['emp_product'] != -1){	
				$this->db->like('ept.old_product', $cond['emp_product']);				
			}			
		}
		// end search
		
		//$this->db->where('ept.employee_id','employees.id');
        $this->db->order_by("ept.id"); 
		$this->db->limit($offset,$limit); 	
		$query = $this->db->get();
	    return $query->result();
    }
	
	function row_count($cond)
	{
	  // search
		if(is_array($cond)){				
			if(isset($cond['emp_id']) and !empty($cond['emp_id']) and $cond['emp_id'] != -1){	
				$this->db->where('employee_histories.employee_id', $cond['emp_id']);
				
			}
			if(isset($cond['emp_product']) and !empty($cond['emp_product']) and $cond['emp_product'] != -1){	
				$this->db->like('employee_histories.old_product', $cond['emp_product']);				
			}			
		}
		// end search
		$this->db->where('employee_histories.type_of_operation','product Change');
		return $this->db->count_all_results('employee_histories');
	}
	
    function add($data)
    {
		$this->db->trans_start();
		$data['id']=$this->get_new_id('employee_histories', 'id');
		$this->db->query("UPDATE employees SET product='{$data['new_product']}' WHERE id={$data['employee_id']}");		
		$this->db->insert('employee_histories', $data);
		$this->db->trans_complete();		
		return $this->db->trans_status();			
    }

    function edit($data)
    {
		$this->db->trans_start();
		$this->db->query("UPDATE employees SET product='{$data['new_product']}' WHERE id={$data['employee_id']}");
		$this->db->update('employee_histories', $data, array('id'=> $data['id']));
		$this->db->trans_complete();		
		return $this->db->trans_status();	
    }
	
	function read($employee_product_transfer_id)
    {
        $query=$this->db->query("SELECT * FROM employee_histories WHERE id=$employee_product_transfer_id");
		return $query->result();	
    }
	function get_max_transfer_info($employee_product_transfer_id)
    {
        $query=$this->db->query("SELECT * FROM employee_histories WHERE id=$employee_product_transfer_id AND type_of_operation='product Change'");
		$query=$query->result();
		if(!empty($query))
		{
	    	$employee_id=$query[0]->employee_id;
			$employee_max_transfer_id=$this->db->query("SELECT max(id) as id FROM employee_histories WHERE employee_id=$employee_id AND type_of_operation='product Change'");
			$employee_max_transfer_id=$employee_max_transfer_id->row()->id;
			if($employee_max_transfer_id!=$employee_product_transfer_id)
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

	function delete($employee_product_transfer_id)
	{
		return $this->db->delete('employee_histories', array('id'=> $employee_product_transfer_id));
	}
    
    
    function get_new_product_list()
    {
		$this->db->select('code, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('products');  
		return $query->result();
    }	


	function get_employee_old_list_by_employee($employee_id)
    {
		 
		if(empty($employee_id)) return array();
	
        $product = $this->db->query("SELECT employees.id,loan_products.name FROM employees,loan_products where employees.id=$employee_id and
	employees.product_id=loan_products.id  ORDER BY name ASC");			
		return $product->result();  
    }    

	function get_old_product_list_by_employee($employee_id=null)
    {
        $product_list = $this->db->query("SELECT loan_products.code as product_code,loan_products.name as product_name,loan_products.short_name FROM employees,loan_products WHERE employees.product LIKE CONCAT('%', loan_products.code, '%') AND employees.id=$employee_id");
	return $product_list->result();  
    }
      
	function get_loan_product_list()
    {
        $branches = $this->db->query("SELECT * FROM loan_products ORDER BY name ASC");			
		return $branches->result();  
    }
  	function get_last_effective_date($employee_id)
    {
        $employee_id= empty($employee_id)?"-1":$employee_id;
		$information = $this->db->query("SELECT MAX(date_of_operation) AS date_of_operation FROM employee_histories WHERE employee_id=$employee_id 
		AND type_of_operation='product Change'");			
		if(!empty($information))
		{
			return $information->row()->date_of_operation; 
		} 
    } 
}
