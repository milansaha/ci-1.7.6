<?php
/** 
        * Member Discontinuous Controller Class.
        * @pupose               Manage member transfer information
        *               
        * @filesource   \app\controllers\member_transfer_controller.php    
        * @package              microfin 
        * @subpackage   microfin.controller.member_transfer_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $       
        * @lastmodified $Date: 2011-01-04 $      
*/ 
class Member_discontinues extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Member_discontinue','Member'),'',TRUE);		
	}

	function index()
	{
		$data['title']='Member Discontinue';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_discontinue->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/member_discontinues/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['member_discontinues']=$this->Member_discontinue->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/member_discontinues/index',$data);
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
				if($this->Member_discontinue->add($data))
				{
					$this->session->set_flashdata('message','Member Discontinuous has been added successfully');
					redirect('/member_discontinues/index/', 'refresh');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data = $this->_load_combo_data();
		$data['title']='Add Member Discontinue';		
		$this->layout->view('/member_discontinues/add',$data);				
	}	
	
	function edit($member_discontinue_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($member_discontinue_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Member Discontinuous ID is not provided');
			redirect('/member_discontinues/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$member_discontinue_id=$_POST['member_discontinue_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{	
				$data=$this->_get_posted_data();			
				$data['id']=$this->input->post('member_discontinue_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_discontinue->edit($data))
				{
					$this->session->set_flashdata('message','Member transfer has been updated successfully');
					redirect('/member_discontinues/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Member_discontinue->read($member_discontinue_id);
		$data['row']=$row[0];	
		$data['title']='Edit Member Discontinue';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('member_discontinues/edit',$data);		
	}
	
	function delete($member_discontinue_id=null)
	{	
		if($this->Member_discontinue->delete($member_discontinue_id))
		{
			$this->session->set_flashdata('message','Member transfer has been deleted successfully');
			redirect('/member_discontinues/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('member_discontinue_id');
		$data['member_id']=$this->input->post('cbo_member');
		$data['discontinue_date']=$this->input->post('txt_discontinue_date');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_member','Member Name','trim|xss_clean');
		$this->form_validation->set_rules('txt_discontinue_date','Discontinue Date','xss_clean');
	}

	function _load_combo_data()
	{
		//This function is for listing of Samity	
		$data['member_infos'] = $this->Member->get_member_info();
		return $data;
	}
}
