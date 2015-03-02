<?php
class Saving_attendance_registers extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Saving_attendance_register','',TRUE);		
	}

	function index()
	{
		$data['title']='Product Interest Rate';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Saving_attendance_register->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/saving_attendance_registers/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['saving_attendance_register']=$this->Saving_attendance_register->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/saving_attendance_registers/index',$data);
	}
	
	function add()
	{
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//echo "<pre>";print_r($data);die;
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_attendance_register->add($data))
				{
					$this->session->set_flashdata('message','Saving Attendance Register has been added successfully');
					redirect('/saving_attendance_registers/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Saving Attendance Register';
		$data['headline']='Add Saving Attendance Register';
		$this->layout->view('/saving_attendance_registers/add',$data);				
	}	
	
	function edit($saving_attendance_register_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($saving_attendance_register_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Saving Attendance Register ID is not provided');
			redirect('/saving_attendance_registers/index/', 'refresh');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//$saving_attendance_register_id=$_POST['saving_attendance_register_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('saving_attendance_register_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_attendance_register->edit($data))
				{
					$this->session->set_flashdata('message','Saving Attendance Register has been updated successfully');
					redirect('/saving_attendance_registers/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$row=$this->Saving_attendance_register->read($saving_attendance_register_id);
		$data['row']=$row[0];	
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('saving_attendance_registers/edit',$data);		
	}
	
	function delete($saving_attendance_register_id=null)
	{	
		if($this->Saving_attendance_register->delete($saving_attendance_register_id))
		{
			$this->session->set_flashdata('message','Saving Attendance Register has been deleted successfully');
			redirect('/saving_attendance_registers/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('saving_attendance_register_id');
		$data['branch_id']=$this->input->post('cbo_branch');	
		$data['samity_id']=$this->input->post('cbo_samity');	
		$data['member_id']=$this->input->post('cbo_member');	
		$data['product_id']=$this->input->post('cbo_product');	
		$data['attendance_status']=$this->input->post('txt_attendance_status');	
		$data['date']=$this->input->post('txt_date');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_branch','Branch Name','required');
		$this->form_validation->set_rules('cbo_samity','Samity Name','required');
		$this->form_validation->set_rules('cbo_member','Member Name','required');
		$this->form_validation->set_rules('cbo_product','Product Name','required');
		$this->form_validation->set_rules('txt_attendance_status','Attendance Status','required|integer|max_length[1]');
		$this->form_validation->set_rules('txt_date','Date','required');
	}
	
	function _load_combo_data()
	{
		//This function is for listing of Samity Group	
		$data['branch_infos'] = $this->Saving_attendance_register->get_branch();
		$data['samity_infos'] = $this->Saving_attendance_register->get_samity();
		$data['member_infos'] = $this->Saving_attendance_register->get_members();
		$data['product_infos'] = $this->Saving_attendance_register->get_products();
		return $data;
	}
}
