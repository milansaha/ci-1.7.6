<?php
/** 
	* Employee product transfers Controller Class.
	* @pupose		Manage Employee product transfers information
	*		
	* @filesource	./system/application/controllers/employee_product_transfers.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.employee_product_transfers
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Employee_product_transfers extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database.If 3rd parameter is not used,you have to load the database manually
		$this->load->model(array('Employee_product_transfer','Employee','Loan_product'),'',TRUE);		
	}
	function ajax_for_get_product_list_by_employee() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$employee_id      = $this->input->post('employee_id');
		if(empty($employee_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select a Employee';
        }
		else
        {
			$callback_message['status'] = 'success';
			$callback_message['product_code'][] = '';
			$callback_message['product_name'][] = '--Select--';
			$products_info = $this->Employee_product_transfer->get_old_product_list_by_employee($employee_id);
	  		 foreach( $products_info as $row) {
				 $callback_message['product_code'][] = $row->product_code;
				 $callback_message['product_name'][] = $row->product_name;
				 $callback_message['short_name'][] = $row->short_name;	
	  		}
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}

	function index()
	{		
		$data = $this->_load_combo_data();
		
		$cond= "";
		$session_data = $this->session->userdata('employee_product_transfers.index');
		if(isset($_POST['cbo_emp']) || isset($_POST['cbo_products'])){			
					
			$cond['emp_id'] = $_POST['cbo_emp'];
			//$cond['emp_product'] = $_POST['cbo_products'];			
			$sessionArray = array( 'employee_product_transfers.index'=>array(												
										'emp_id'=>$cond['emp_id'],
										//,'emp_product'=>$cond['emp_product']
			));
			//print_r($session_data);
			$this->session->unset_userdata('employee_product_transfers.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);			
			$cond['emp_id'] = $session_data['emp_id'];
			//$cond['emp_product'] = $session_data['emp_product'];			
		} else {
			$this->session->unset_userdata('employee_product_transfers.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee_product_transfer->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employee_product_transfers/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['employee_product_transfer_info']=$this->Employee_product_transfer->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$data['title']='Employee Product Transfer';
		$this->layout->view('/employee_product_transfers/index',$data);
	}
	
	function add()
	{		
		$is_validate_error = false;		
		$this->_prepare_validation();
		//echo "<pre>";print_r($_POST);die;			
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			$employee_id=$this->input->post('cbo_employee');	
			$current_product="";
			if(!empty($_POST['chk_product'])):
			$c=count($_POST['chk_product']);		
			$temp_product=$_POST['chk_product'];
			//print_r($temp_product);die;
			foreach($temp_product as $p)
			{
				if(empty($current_product))	
				{		
					$current_product=$p;	
				}
				else
				{
					$current_product=$current_product.','.$p;	
				}	
			}			
			endif;	
			//print($current_product);die;			
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data['old_product']= $this->_find_old_product_code($data['employee_id']); 
				$data['new_product']=$current_product;	
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_product_transfer->add($data))
				{
				    
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employee_product_transfers/add/', 'refresh');
				} 
			}
			else {
				$is_validate_error = TRUE;
			}
		}
		$data = $this->_load_combo_data();		
		if($is_validate_error and isset($employee_id) and !empty($employee_id)){
			$employee_info=$this->Employee->read($employee_id);			
			$data['row']->employee_id = $employee_info->id;
			$data['row']->employee_info = $employee_info->name;	
			if(empty($current_product)):	
			$current_product = explode(',',$employee_info->product);
			else:
			$current_product = explode(',',$current_product);
			//print_r($current_product);die;
			foreach($current_product as $current_product){				
				$data['current_product'][$current_product] = $current_product;			
			}
			endif;							
		}
		//echo "<pre>";print_r($data);die;
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Employee product Transfer';
        $data['headline']='Add New';
		$this->layout->view('/employee_product_transfers/add',$data);				
	}	
	
	function edit($employee_product_transfer_id=null)
	{	
		$data['title']='Edit Employee product Transfer';
		$is_validate_error = false;
		$employee_id=$this->input->post('cbo_employee');	
		$current_product="";
		//If ID is not provided, redirecting to index page
		if(empty($employee_product_transfer_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Employee Product Transfer ID is not provided');
			redirect('/employee_product_transfers/index/', 'refresh');
		}
		if(!empty($employee_product_transfer_id) && !$_POST)
		{			
			$max_transfer_info=$this->Employee_product_transfer->get_max_transfer_info($employee_product_transfer_id);
			if($max_transfer_info==1)
			{
			$this->session->set_flashdata('warning','Employee Product Transfer information can not updated there is another latest information for this emplyee.');
			redirect('/employee_product_transfers/index/', 'refresh');
			}
			if($max_transfer_info==2)
			{
				$this->session->set_flashdata('warning','Invalid Employee Product Transfer ID');
				redirect('/employee_product_transfers/index/', 'refresh');
			}
		}		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{ 
			$employee_product_transfer_id=$this->input->post('employee_product_transfer_id');
			if(!empty($_POST['chk_product'])):
			$c=count($_POST['chk_product']);		
			$temp_product=$_POST['chk_product'];
			//print_r($temp_product);die;
			foreach($temp_product as $p)
			{
				if(empty($current_product))	
				{		
					$current_product=$p;	
				}
				else
				{
					$current_product=$current_product.','.$p;	
				}	
			}			
			endif;							
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();                
				$data['new_product']=$current_product;	
				$data['id']=$this->input->post('employee_product_transfer_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_product_transfer->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employee_product_transfers/index/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();		
		$row=$this->Employee_product_transfer->read($employee_product_transfer_id);	
		$data['row']=$row[0];
			
		if(!(empty($data['row']->new_product)) && empty($current_product))
		{
			$current_product = explode(',',$data['row']->new_product);
			foreach($current_product as $current_product){				
				$data['current_product'][$current_product] = $current_product;			
			}
		}		
        elseif($is_validate_error and isset($employee_id) and !empty($employee_id)){
			$employee_info=$this->Employee->read($employee_id);
			//echo "<pre>";print_r($employee_info);die;
			$data['row']->employee_id = $employee_info->id;
			$data['row']->employee_info = $employee_info->name;		
			if(empty($current_product)):	
			$current_product = explode(',',$employee_info->product);
			else:
			$current_product = explode(',',$current_product);
			//print_r($current_product);die;
			foreach($current_product as $current_product){				
				$data['current_product'][$current_product] = $current_product;			
			}
			endif;								
		}
		$data['headline']='Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employee_product_transfers/edit',$data);		
	}
	
	function delete($employee_product_transfer_id=null)
	{
        if(empty($employee_product_transfer_id))
		{
			$this->session->set_flashdata('warning','Employee product Transfer ID is not provided');
			redirect('/employee_product_transfers/index/');
		}
		if($this->Employee_product_transfer->delete($employee_product_transfer_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/employee_product_transfers/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('employee_product_transfer_id');
		$data['employee_id']=$this->input->post('cbo_employee');
		$date['is_product_transferred']=1;
		$data['type_of_operation']='product Change';			
		$data['date_of_operation']=$this->input->post('txt_effective_date');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_employee','Employee Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_effective_date','Effective Date','trim|xss_clean|is_date|required|callback_check_joining_date|callback_check_effective_date');	
	}
	function _load_combo_data()
	{       
        // Loading employee list which will be used in employee combo box
		$data['employee_list'] = $this->Employee->get_employee_list();			
		$data['loan_products'] = $this->Employee_product_transfer->get_loan_product_list();			
		return $data;
	}	
	function _find_old_product_code($employee_id)
	{
		$old_product_code='';
				$old_product_list = $this->Employee_product_transfer->get_old_product_list_by_employee($employee_id);
			    if(!empty($old_product_list)) {
			     
                	foreach($old_product_list as $product)
    				{	
    					$old_product_code .= $product->product_code . ',';
    				}
			    }
				$data['old_product'] = $old_product_code;
				$data['old_product'] = rtrim($data['old_product'], ",");
				return $data['old_product'];
		
	}
	function check_joining_date()
	{
		// check_transaction_date
		$effective_date=$this->input->post('txt_effective_date');		
		$employee_id=$this->input->post('cbo_employee');
		if(!empty($employee_id) && !empty($effective_date))
		{
			$employee_joining_date = $this->Employee->get_employee_joining_date($employee_id);						
			if($employee_joining_date>$effective_date) {
				$this->form_validation->set_message('check_joining_date', "Effective date must be greater than employee joining date.");
					return FALSE;
			}
		}
		return TRUE;					
	}
	function check_effective_date()
	{
		// check_transaction_date
		$effective_date=$this->input->post('txt_effective_date');		
		$employee_id=$this->input->post('cbo_employee');		
		//print($effective_date);
		if(!empty($employee_id) && !empty($effective_date))
		{			
			$last_effective_date = $this->Employee_product_transfer->get_last_effective_date($employee_id);						
			if($last_effective_date>$effective_date) {			
				$this->form_validation->set_message('check_effective_date', "Effective date must be greater than last effective date.");
					return FALSE;
			}
			
		}
		return TRUE;					
	}
}
