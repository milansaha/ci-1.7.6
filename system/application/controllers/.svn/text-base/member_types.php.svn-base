<?php
/** 
        * Member Type Controller Class.
        * @pupose               Manage member type information
        *               
        * @filesource   \app\controllers\member_types_controller.php    
        * @package              microfin 
        * @subpackage   microfin.controller.member_types_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $       
        * @lastmodified $Date: 2011-01-04 $      
*/ 
class Member_types extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Member_type','',TRUE);		
	}

	function index()
	{
		$data['title']='Member Type';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_type->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/member_types/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['member_types']=$this->Member_type->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/member_types/index',$data);
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
				//The first param->Table Name, 2nd Param: id field
				$data['id'] = $this->Member_type->get_new_id('member_type', 'id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_type->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/member_types/add/', 'refresh');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Member Type';
		$this->layout->view('/member_types/add',$data);				
	}	
	
	function edit($member_id=null)
	{	
		$data['title']='Edit Member Type';
		//If ID is not provided, redirecting to index page
		if(empty($member_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Member Type ID is not provided');
			redirect('/member_types/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$member_id=$_POST['member_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('member_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_type->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/member_types/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$row=$this->Member_type->read($member_id);
		$data['row']=$row[0];	
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('member_types/edit',$data);		
	}
	
	function delete($member_id=null)
	{	
		if($this->Member_type->delete($member_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/member_types/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('member_id');
		$data['name']=$this->input->post('txt_name');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[200]|xss_clean');
	}
}
