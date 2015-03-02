<?php
/** 
	* Employee promotions Controller Class.
	* @pupose		Manage Employee promotion information
	*		
	* @filesource	\app\controllers\employee_promotions_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.employee_promotions_controller
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam  $	
	* @lastmodified $Date: 2011-01-19 $	 
*/ 
	
class Employee_promotions extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Employee_promotion','Employee','Employee_designation'),'',TRUE);		
		$this->output->enable_profiler(TRUE);
	}
	
	function ajax_for_get_old_designation_list() {
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
			//$callback_message['designation_name'][] = '--Select--';
			$designation_info = $this->Employee_promotion->get_old_designation_list_by_employee($employee_id);
	  		 foreach( $designation_info as $row) {
				 $callback_message['designation_name'][] = $row->designation_name;
				 $callback_message['designation_id'][] = $row->designation_id;		
	  		}
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}	

	function index()
	{
		$data['title']='Employee Promotions';
        $data['headline']='Employee Promotions';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee_promotion->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employee_promotions/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	         
		
		//Loading data by model function call
		$data['employee_promotions']=$this->Employee_promotion->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/employee_promotions/index',$data);				
	}
	
	
	function add()
	{		
		$is_validate_error = false;
		//echo "<pre>";print_r($_POST);die;
		$this->_prepare_validation();
		
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			$old_designation_id=$this->input->post('txt_old_designation_id');
			$employee_id = $this->input->post('cbo_employee');	
			//echo "<pre>";print($old_designation_id);die;
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_promotion->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employee_promotions/add/', 'refresh');
				}
			}
			else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		if($is_validate_error and isset($employee_id) and !empty($employee_id)){
			$employee_info=$this->Employee->read($employee_id);			
			$data['row']->employee_id = $employee_info->id;
			$data['row']->employee_name = $employee_info->name;			
			$data['row']->old_designation_id = isset($old_designation_id)?$old_designation_id:"";									
		}	
		//echo "<pre>";print_r($data['row']);die;	
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Employee Promotion';
        $data['headline'] = 'Add New';
		$this->layout->view('/employee_promotions/add',$data);				
	}	
	
	function edit($employee_promotion_id=null)
	{	
		$is_validate_error = false;
		//If ID is not provided, redirecting to index page
		if(empty($employee_promotion_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Employee Promotion ID is not provided');
			redirect('/employee_promotions/index/', 'refresh');
		}
		if(!empty($employee_promotion_id) && !$_POST)
		{			
			$max_transfer_info=$this->Employee_promotion->get_max_transfer_info($employee_promotion_id);
			if($max_transfer_info==1)
			{
			$this->session->set_flashdata('warning','Employee promotion information can not updated there is another latest information for this employee.');
			redirect('/employee_promotions/index/', 'refresh');
			}
			if($max_transfer_info==2)
			{
				$this->session->set_flashdata('warning','Invalid Employee Promotion ID');
				redirect('/employee_promotions/index/', 'refresh');
			}
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$employee_promotion_id=$_POST['employee_promotion_id'];
			$old_designation_id=$this->input->post('txt_old_designation_id');
			$new_designation_id=$this->input->post('cbo_new_designation');
			$employee_id = $this->input->post('cbo_employee');	
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('employee_promotion_id');
				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_promotion->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employee_promotions/index/', 'refresh');
				}
			}else {
					$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$data['row']=$this->Employee_promotion->read($employee_promotion_id);
		if($is_validate_error and isset($employee_id) and !empty($employee_id)){
			$employee_info=$this->Employee->read($employee_id);			
			$data['row']->employee_id = $employee_info->id;
			$data['row']->employee_name = $employee_info->name;			
			$data['row']->old_designation_id = $old_designation_id;	
			$data['row']->new_designation_id = $new_designation_id;										
		}			
		//$data['row']=$row[0];	
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Employee Promotion';	
        $data['headline'] = 'Edit';
		$this->layout->view('/employee_promotions/edit',$data);		
	}
	
	function delete($employee_promotion_id=null)
	{
		$max_transfer_info=$this->Employee_promotion->get_max_transfer_info($employee_promotion_id);
			if($max_transfer_info==1)
			{
			$this->session->set_flashdata('warning','Employee promotion information can not deleted there is another latest information for this employee.');
			redirect('/employee_promotions/index/', 'refresh');
			}
			if($max_transfer_info==2)
			{
				$this->session->set_flashdata('warning','Invalid Employee Promotion ID');
				redirect('/employee_promotions/index/', 'refresh');
			}
        if(empty($employee_promotion_id))
		{
			$this->session->set_flashdata('warning','Employee Promotion ID is not provided');
			redirect('/employee_promotions/index/');
		}
		
		if($this->Employee_promotion->delete($employee_promotion_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/employee_promotions/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['employee_id']=$this->input->post('cbo_employee');
		$data['old_designation_id']=$this->input->post('txt_old_designation_id');
		$data['new_designation_id']=$this->input->post('cbo_new_designation');
		$data['effective_date']=$this->input->post('txt_effective_date');
		//$data['type_of_operation']="Designation Change";
		//$data['is_designation_changed']="1";
		return $data;	
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_employee','Employee Name','trim|required');
		$this->form_validation->set_rules('txt_old_designation_id','old Designation id','trim|required');
		$this->form_validation->set_rules('cbo_new_designation','new Designation','trim|required|callback_check_same_designation');
		$this->form_validation->set_rules('txt_effective_date','Effective Date','trim|is_date|required|callback_check_joining_date|callback_check_effective_date');
	}
	function _load_combo_data($cond = array())
	{       
        // Loading employee list which will be used in employee combo box
		$data['employee_list'] = $this->Employee->get_employee_list();	
		$data['new_designation'] = $this->Employee_promotion->get_new_designation_list();	
		return $data;
	}
	function check_same_designation()
	{
		//check old branch
		$old_designation_id=$this->input->post('txt_old_designation_id');
		$new_designation_id=$this->input->post('cbo_new_designation');
		if ($old_designation_id==$new_designation_id)
		{
			$this->form_validation->set_message('check_same_designation', "Old Designation and New Designation should be different.");
			return FALSE;
		}
		return TRUE;
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
		$employee_promotion_id=(isset($_POST['employee_promotion_id']))?$_POST['employee_promotion_id']:'';
		$effective_date=$this->input->post('txt_effective_date');		
		$employee_id=$this->input->post('cbo_employee');
				
		//print($effective_date);
		if(!empty($employee_id) && !empty($effective_date))
		{			
			$last_effective_date = $this->Employee_promotion->get_last_effective_date($employee_promotion_id,$employee_id);						
			if($last_effective_date>=$effective_date) {			
				$this->form_validation->set_message('check_effective_date', "Effective date must be greater than last effective date.");
					return FALSE;
			}
			
		}
		return TRUE;					
	}
}
