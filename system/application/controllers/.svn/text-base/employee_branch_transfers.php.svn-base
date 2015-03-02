<?php
/** 
	* Employee branch transfers Controller Class.
	* @pupose		Manage Employee branch transfers information
	*		
	* @filesource	./system/application/controllers/employee_branch_transfers.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.employee_branch_transfers
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Employee_branch_transfers extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Employee_branch_transfer','Employee'),'',TRUE);		
	}
		
	function ajax_for_get_old_branch_list() {
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
			//$callback_message['branch_name'][] = '--Select--';
			$branch_info = $this->Employee_branch_transfer->get_old_branch_list_by_employee($employee_id);
	  		 foreach( $branch_info as $row) {
				 $callback_message['branch_name'][] = $row->branch_name;
				 $callback_message['branch_id'][] = $row->branch_id;		
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
		$session_data = $this->session->userdata('employee_branch_transfers.index');
		if(isset($_POST['cbo_emp']) || isset($_POST['cbo_branch'])){					
			$cond['emp_id'] = $_POST['cbo_emp'];
			$cond['emp_branch'] = $_POST['cbo_branch'];				
			$sessionArray = array( 'employee_branch_transfers.index'=>array(												
				'emp_id'=>$cond['emp_id'],
				'emp_branch'=>$cond['emp_branch']));
			//print_r($session_data);
			$this->session->unset_userdata('employee_branch_transfers.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);			
			$cond['emp_id'] = $session_data['emp_id'];
			$cond['emp_branch'] = $session_data['emp_branch'];			
		} else {
			$this->session->unset_userdata('employee_branch_transfers.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee_branch_transfer->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employee_branch_transfers/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['employee_branch_transfer_info']=$this->Employee_branch_transfer->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$data['title']='Employee Branch Transfer';
        $data['headline']='Employee Branch Transfer';
		$this->layout->view('/employee_branch_transfers/index',$data);
	}
	
	function add()
	{
		$is_validate_error = false;
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//print_r($_POST);die;			
			$data=$this->_get_posted_data();
			$old_branch_id=$this->input->post('txt_old_branch_id');
			$employee_id = $this->input->post('cbo_employee');
			//echo "<pre>";print_r($data);die;
			//Perform the Validation			
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_branch_transfer->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employee_branch_transfers/add/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		$data = $this->_load_combo_data();
		if($is_validate_error and isset($employee_id) and !empty($employee_id)){
			$employee_info=$this->Employee->read($employee_id);
			//echo "<pre>";print_r($employee_info);die;
			$data['row']->employee_id = $employee_info->id;
			$data['row']->employee_name = $employee_info->name;			
			$data['row']->old_branch_id = isset($old_branch_id)?$old_branch_id:"";											
		}
		//If data is not posted or validation fails, the add view is displayed		
		//echo "<pre>";print_r($data);die;
		$data['title']='Add Employee Branch Transfer';
        $data['headline'] = 'Add New';
		$this->layout->view('/employee_branch_transfers/add',$data);				
	}	
	
	function edit($employee_branch_transfer_id=null)
	{			
		//If ID is not provided, redirecting to index page
		$is_validate_error = false;
		if(empty($employee_branch_transfer_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Employee Branch Transfer ID is not provided');
			redirect('/employee_branch_transfers/index/', 'refresh');
		}
		if(!empty($employee_branch_transfer_id) && !$_POST)
		{			
			$max_transfer_info=$this->Employee_branch_transfer->get_max_transfer_info($employee_branch_transfer_id);
			if($max_transfer_info==1)
			{
			$this->session->set_flashdata('warning','Employee Branch Transfer information can not updated there is another latest information for this employee.');
			redirect('/employee_branch_transfers/index/', 'refresh');
			}
			if($max_transfer_info==2)
			{
				$this->session->set_flashdata('warning','Invalid Employee Branch Transfer ID');
				redirect('/employee_branch_transfers/index/', 'refresh');
			}
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$employee_branch_transfer_id=$_POST['employee_branch_transfer_id'];
			$old_branch_id=$this->input->post('txt_old_branch_id');
			$new_branch_id=$this->input->post('cbo_new_branch');
			$employee_id = $this->input->post('cbo_employee');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('employee_branch_transfer_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_branch_transfer->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employee_branch_transfers/index/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$data['row']=$this->Employee_branch_transfer->read($employee_branch_transfer_id);
		if($is_validate_error and isset($employee_id) and !empty($employee_id)){
			$employee_info=$this->Employee->read($employee_id);
			//echo "<pre>";print_r($employee_info);die;
			$data['row']->employee_id = $employee_info->id;
			$data['row']->employee_name = $employee_info->name;			
			$data['row']->old_branch_id = isset($old_branch_id)?$old_branch_id:"";	
			$data['row']->new_branch_id = isset($new_branch_id)?$new_branch_id:"";							
		}	
		$data['title']='Edit Employee Branch Transfer';
        $data['headline'] = 'Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employee_branch_transfers/edit',$data);		
	}
	
	function delete($employee_branch_transfer_id=null)
	{
        if(empty($employee_branch_transfer_id))
		{
			$this->session->set_flashdata('warning','Employee Branch Transfer ID is not provided');
			redirect('/employee_branch_transfers/index/');
		}
		if(!empty($employee_branch_transfer_id) && !$_POST)
		{			
			$max_transfer_info=$this->Employee_branch_transfer->get_max_transfer_info($employee_branch_transfer_id);
			if($max_transfer_info==1)
			{
			$this->session->set_flashdata('warning','Employee Branch Transfer information can not deleted there is another latest information for this employee.');
			redirect('/employee_branch_transfers/index/', 'refresh');
			}
			if($max_transfer_info==2)
			{
				$this->session->set_flashdata('warning','Invalid Employee Branch Transfer ID');
				redirect('/employee_branch_transfers/index/', 'refresh');
			}
		}
		if($this->Employee_branch_transfer->delete($employee_branch_transfer_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/employee_branch_transfers/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('employee_branch_transfer_id');
		$data['employee_id']=$this->input->post('cbo_employee');
		//$data['type_of_operation']='Branch Change';
		//$data['is_transferred']='1';
		$data['old_branch_id']=$this->input->post('txt_old_branch_id');
		$data['new_branch_id']=$this->input->post('cbo_new_branch');
		$data['effective_date']=$this->input->post('txt_effective_date');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_employee','Employee Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_old_branch_id','Old Branch Id','trim|xss_clean|required');	
		$this->form_validation->set_rules('cbo_new_branch','New Branch Name','trim|xss_clean|required|callback_check_same_branch');
		$this->form_validation->set_rules('txt_effective_date','Effective Date','trim|xss_clean|is_date|required|callback_check_joining_date|callback_check_effective_date');	
	}
	function _load_combo_data()
	{       
        // Loading employee list which will be used in employee combo box
		$data['employee_list'] = $this->Employee->get_employee_list();		
		// Loading designation list which will be used in new designation combo box
		$data['new_branch'] = $this->Employee_branch_transfer->get_new_branch_list();	
		$data['branches'] = $this->Employee_branch_transfer->get_new_branch_list();
		return $data;
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
	function check_same_branch()
	{
		//check old branch
		$old_branch_id=$this->input->post('txt_old_branch_id');
		$new_branch_id=$this->input->post('cbo_new_branch');
		if ($old_branch_id==$new_branch_id)
		{
			$this->form_validation->set_message('check_same_branch', "Old Branch Name and New Branch Name should be different.");
			return FALSE;
		}
		return TRUE;
	}
		
	function check_effective_date()
	{
		// check_transaction_date
		$employee_branch_transfer_id=(isset($_POST['employee_branch_transfer_id']))?$_POST['employee_branch_transfer_id']:'';
		$effective_date=$this->input->post('txt_effective_date');		
		$employee_id=$this->input->post('cbo_employee');
				
		//print($effective_date);
		if(!empty($employee_id) && !empty($effective_date))
		{			
			$last_effective_date = $this->Employee_branch_transfer->get_last_effective_date($employee_branch_transfer_id,$employee_id);						
			if($last_effective_date>=$effective_date) {			
				$this->form_validation->set_message('check_effective_date', "Effective date must be greater than last effective date.");
					return FALSE;
			}
			
		}
		return TRUE;					
	}
}
