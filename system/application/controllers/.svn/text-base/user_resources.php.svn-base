<?php
/** 
	* Employee Designation Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/employee_designation.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controller.user_resources
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy$	
	* @lastmodified $Date: 2011-03-05 $	 
*/ 
class User_resources extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('User_resource');		
	}

	function index()
	{
		$data['title']='User Resources';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->User_resource->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employee_designations/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = 1000;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['designations']=$this->User_resource->get_list(1000, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/user_resources/index',$data);
	}
	
	function add()
	{
		$data['title']='Add User Resource';	
		if($_POST)
		{
			$this->_prepare_validation();
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->User_resource->add($data))
				{
					$this->session->set_flashdata('message','User Resource has been added successfully');
					redirect('/user_resources/add/');
				}
			}
		}
		$data = $this->_load_combo_data();			
		$this->layout->view('/user_resources/add',$data);				
	}	
	
	function edit($id=null)
	{	
		$data['title']='Edit User Resource';
		//If ID is not provided, redirecting to index page
		if(empty($id) && !$_POST)
		{
			$this->session->set_flashdata('message','User Resource ID is not provided');
			redirect('/user_resources/index/');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$id=$this->input->post('id');
				$data['id']=$id;
				//Validation is OK. So, add this data and redirect to the index page
				if($this->User_resource->edit($data))
				{
					$this->session->set_flashdata('message','User Resource has been updated successfully');
					redirect('/user_resources/index/');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		
		$data['row']=$this->User_resource->read($id);
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('user_resources/edit',$data);		
	}
	
	function delete($designation_id=null)
	{	
		if($this->User_resource->delete($designation_id))
		{
			$this->session->set_flashdata('message','User Resource has been deleted successfully');
			redirect('/user_resources/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('designation_id');
		$data['title']=$this->input->post('txt_title');
		$data['user_resource_group_id']=$this->input->post('cbo_resource_group');
		$data['controller']=$this->input->post('cbo_controller');	
		$data['action']=$this->input->post('txt_action');
		$data['order']=$this->input->post('txt_order');
		if($this->input->post('chk_enabled'))
			$data['is_enabled']=TRUE;
		else
			$data['is_enabled']=FALSE;
		return $data;
		
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_title','Title','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_resource_group','Resource Group','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_controller','Controller Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_action','Action Name','trim|xss_clean|required');		
	}
	
	function _load_combo_data()
	{
		//This function is for listing of departments	
		$data['controller_list'] = $this->User_resource->get_controller_list();
		$data['resource_gruop_list'] = $this->User_resource->get_resource_group_list();
		return $data;
	}
}
