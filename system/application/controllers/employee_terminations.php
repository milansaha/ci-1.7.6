<?php
/** 
        * Employee Terminations Controller Class.
        * @pupose               Manage member transfer information
        *               
        * @filesource   \app\controllers\employee_terminations.php    
        * @package              microfin 
        * @subpackage   microfin.controller.employee_termination_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $       
        * @lastmodified $Date: 2011-01-04 $      
*/ 
class Employee_terminations extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Employee_termination','Employee'),'',TRUE);		
	}

	function index()
	{
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee_termination->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employee_terminations/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['employee_terminations']=$this->Employee_termination->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$data['title']='Employee termination';
        $data['headline']='Employee termination';
		$this->layout->view('/employee_terminations/index',$data);
	}
	
	function add()
	{
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_termination->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employee_terminations/index/', 'refresh');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['employee_info'] = $this->Employee->get_active_employee_list();
		$data['title']='Add Employee termination';
        $data['headline']= 'Add New';
		$this->layout->view('/employee_terminations/add',$data);				
	}	
	
	function edit($employee_termination_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($employee_termination_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Employee Terminations ID is not provided');
			redirect('/employee_terminations/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$employee_termination_id=$_POST['employee_termination_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{	
				$data=$this->_get_posted_data();			
				$data['id']=$this->input->post('employee_termination_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_termination->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employee_terminations/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data['employee_info'] = $this->Employee->get_employee_list();
		$row=$this->Employee_termination->read($employee_termination_id);
		$data['row']=$row[0];	
		$data['title']='Edit Employee termination';
        $data['headline']= 'Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employee_terminations/edit',$data);		
	}
	
	function delete($employee_termination_id=null)
	{
        if(empty($employee_termination_id))
		{
			$this->session->set_flashdata('warning','Employee termination ID is not provided');
			redirect('/employee_terminations/index/');
		}
		if($this->Employee_termination->delete($employee_termination_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/employee_terminations/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('employee_termination_id');
		$data['employee_id']=$this->input->post('cbo_employee');
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
		$this->form_validation->set_rules('txt_effective_date','Effective Date','trim|xss_clean|is_date|required|callback_check_joining_date');
	}
    /*
	function _load_combo_data()
	{
		//This function is for listing of Samity	
		$data['employee_info'] = $this->Employee->get_employee_list();
		return $data;
	}
     * *
     */
	function check_joining_date()
	{
		// check_transaction_date
		$effective_date=$this->input->post('txt_effective_date');		
		$employee_id=$this->input->post('cbo_employee');
		if(!empty($employee_id) && !empty($effective_date))
		{
			$employee_joining_date = $this->Employee->get_employee_joining_date($employee_id);						
			if($employee_joining_date>$effective_date) {
				$this->form_validation->set_message('check_joining_date', "Termination date must be greater than employee joining date.");
					return FALSE;
			}
		}
		return TRUE;					
	}
}
