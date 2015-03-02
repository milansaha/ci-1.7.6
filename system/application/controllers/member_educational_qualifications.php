<?php
/** 
	* Member Educational Qualification Controller Class. 
	* @pupose		Manage Member Educational Qualification Information
	*		
	* @filesource	\app\controllers\member_educational_qualifications.php	
	* @package		microfin 
	* @subpackage	microfin.controllers.member_educational_qualifications
	* @version      $Revision: 1 $
	* @author       $Author: Sheikh Imtiaz Hossain $	
	* @lastmodified $Date: 2011-02-22 $	 
*/
class Member_educational_qualifications extends MY_Controller 
{
	function Member_educational_qualifications()
	{
		parent::MY_Controller();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Member_educational_qualification','',TRUE);
	}

	function index()
	{
		$data['title'] = 'Member Educational Qualification';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_educational_qualification->row_count();
		//Initializing Pagination
		$config['base_url'] = site_url('/member_educational_qualifications/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);
		//Loading data by model function call
		$data['member_educational_qualifications'] = $this->Member_educational_qualification->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/member_educational_qualifications/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data = $this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_educational_qualification->add($data))
				{
					$this->session->set_flashdata('message','Educational Qualification entry has been added successfully');
					redirect('/member_educational_qualifications/add/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed		
		$data['title'] = 'Add Qualification Exam Entry';
		$this->layout->view('/member_educational_qualifications/save',$data);				
	}	
	
	function edit($id = null)
	{	
		//redirect if no id provided
		if(empty($id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Educational Qualification ID is not provided');
			redirect('/member_educational_qualifications/index/');
		}
		if($_POST)
		{
			$id = $this->input->post('txt_id');
			$this->_prepare_validation();
			if ($this->form_validation->run() === TRUE)
			{				
				$data = $this->_get_posted_data();
				if($this->Member_educational_qualification->edit($data))
				{
					$this->session->set_flashdata('success','Educational Qualification entry has been updated successfully');
					redirect('/member_educational_qualifications/index/');
				}
			}
		}
		$data['row'] = $this->Member_educational_qualification->read($id);
		//If data is not posted or validation fails, the add view is displayed
		$data['title'] = 'Edit Member Education Qualification';
		$this->layout->view('/member_educational_qualifications/save',$data);		
	}	
	
	function delete($id=null)
	{	
		if($this->Member_educational_qualification->delete($id))
		{
			$this->session->set_flashdata('message','Educational Qualification entry has been deleted successfully');
			redirect('/member_educational_qualifications/index/');
		}
	}
	
	// retrive the posted data after submitting the form
	function _get_posted_data()
	{
		$data = array();
		if($this->input->post('txt_id'))
		{
			$data['id'] = $this->input->post('txt_id');
		}
		$data['name'] = $this->input->post('txt_name');		
		return $data;
	}
	
	// process of validation
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule			
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[200]|xss_clean');			
	}
}
