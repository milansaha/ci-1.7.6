<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees_lib{
	
	var $CI='';
	
	function Employees_lib()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->model('Employee','',TRUE);
		$this->CI->load->model('Employee_history','',TRUE);
			
	}
	
	function add($new_employee){
		
                $employee_id=$new_employee['id'];		
		$current_emp=$this->CI->Employee->read($employee_id);
		
		$current_emp=(array)$current_emp[0];
		
		
		$query="SELECT curr_date FROM curr_date";
		$query = $this->CI->db->query($query);
		$date = $query->result_array();
		
			if(empty($new_employee['branch_id'])){
				$new_employee['branch_id']=null;
			}
			if(empty($current_emp['branch_id'])){
				$current_emp['branch_id']=null;
			}
			
			if(empty($new_employee['product'])){
				$new_employee['product']=null;
			}
			if(empty($current_emp['product'])){
				$current_emp['product']=null;
			}
		
		
			
		$emp_hist=array('employee_id'=>$new_employee['id'],'new_branch_id'=>$new_employee['branch_id'],'new_product'=>$new_employee['product'],'new_designation_id'=>$new_employee['designation_id'],'is_added'=>1,'date_of_operation'=>$date[0]['curr_date']);
				
		$this->CI->Employee_history->add($emp_hist);
	}
	function update($new_employee){
		$current_emp=$this->CI->Employee->read($new_employee['id']);
		
		$current_emp=(array)$current_emp[0];
		
	
		
		$is_tra=0;
		$is_pro_tra=0;
		$is_des_chg=0;
		if($current_emp['designation_id']!=$new_employee['designation_id']){
			$is_des_chg=1;
		}
		if(!empty($current_emp['branch_id'])&&!empty($new_employee['branch_id'])){
			if($current_emp['branch_id']!=$new_employee['branch_id']){
				$is_tra=1;
			}
		}
		if(!empty($current_emp['product'])&&!empty($new_employee['product'])){
			$curr_emp_products=explode(',',$current_emp['product']);
			$emp_products=explode(',',$new_employee['product']);
			$flag=0;
			if(count($curr_emp_products)==count($emp_products)){
				foreach($curr_emp_products as $curr_emp_product){
					foreach($emp_products as $emp_product){
						if(strcmp(trim($curr_emp_product),trim($emp_product))==0){
							$flag++;
						}
					}
				}
			}else{
				$is_pro_tra=1;
			}
			if($flag==count($curr_emp_products)){
				$is_pro_tra=1;
			}
		}
		else if(empty($current_emp['product'])!=empty($new_employee['product'])){
			$is_pro_tra=1;
		}
		
		
		$query="SELECT curr_date FROM curr_date";
		$query = $this->CI->db->query($query);
		$date = $query->result_array();
		
		if($is_tra!=0||$is_pro_tra!=0||$is_des_chg!=0){
			if(empty($new_employee['branch_id'])){
				$new_employee['branch_id']=null;
			}
			if(empty($current_emp['branch_id'])){
				$current_emp['branch_id']=null;
			}
			
			if(empty($new_employee['product'])){
				$new_employee['product']=null;
			}
			if(empty($current_emp['product'])){
				$current_emp['product']=null;
			}
			
				$emp_hist=array('employee_id'=>$current_emp['id'],'new_branch_id'=>$new_employee['branch_id'],'old_branch_id'=>$current_emp['branch_id'],'new_product'=>$new_employee['product'],'old_product'=>$current_emp['product'],'new_designation_id'=>$new_employee['designation_id'],'old_designation_id'=>$current_emp['designation_id'],'is_transferred'=>$is_tra,'is_product_transferred'=>$is_pro_tra,'is_designation_changed'=>$is_des_chg,'date_of_operation'=>$date[0]['curr_date']);
			
			$this->CI->Employee_history->add($emp_hist);
		}
		
		//$this->Employee->update($new_employee);
		
		
	}
	
	
	function delete($employee_id){
		$current_emp=$this->CI->Employee->read($employee_id);
		
		$current_emp=(array)$current_emp[0];
		
		
		$query="SELECT curr_date FROM curr_date";
		$query = $this->CI->db->query($query);
		$date = $query->result_array();
		
		
			
		$emp_hist=array('employee_id'=>$current_emp['id'],'old_branch_id'=>$current_emp['branch_id'],'old_product'=>$current_emp['product'],'old_designation_id'=>$current_emp['designation_id'],'is_deleted'=>1,'date_of_operation'=>$date[0]['curr_date']);
			
			$this->CI->Employee_history->add($emp_hist);
		}
		
		
		
		//$this->Employee->update($new_employee);
		
		
	
	
}
