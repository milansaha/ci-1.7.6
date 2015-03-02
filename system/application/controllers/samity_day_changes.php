<?php
/** 
        * Samity Day Change Controller Class.
        * @pupose               Manage  information
        *               
        * @filesource   \app\controllers\Samity_day_changes.php    
        * @package              microfin 
        * @subpackage   microfin.controller.Samity_day_changes_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $       
        * @lastmodified $Date: 2011-01-04 $      
*/ 
class Samity_day_changes extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Samity_day_change','Samity','Report'),'',TRUE);		
	}

	function index()
	{
		$data['title']='Samity Day Change';
		$data['headline']='Samity Day Change';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Samity_day_change->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/samity_day_changes/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['samity_day_changes']=$this->Samity_day_change->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);	
		$this->layout->view('/samity_day_changes/index',$data);
	}
	
	function add()
	{
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//echo "<pre>";print_r($_POST);die;
			$data=$this->_get_posted_data();			
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{								
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity_day_change->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/samity_day_changes/add/');
				}
			}
		}	
		$data = $this->_load_combo_data();			
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Samity Day Change';
        $data['headline'] = 'Add New';
		$this->layout->view('/samity_day_changes/add',$data);				
	}	
	
	function edit($samity_day_change_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($samity_day_change_id) && !$_POST)
		{
			$this->session->set_flashdata('warining','Samity Day Change ID is not provided');
			redirect('/samity_day_changes/index/');
		}
		//echo "<pre>";print_r($_POST);die;
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$samity_day_change_id=$_POST['id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('id');				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity_day_change->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/samity_day_changes/index/');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$row=$this->Samity_day_change->read($samity_day_change_id);
		$data['row']=$row[0];	
		$data['title']='Edit Samity Day';
        $data['headline'] = 'Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('/samity_day_changes/edit',$data);		
	}
	
	function delete($samity_day_change_id=null)
	{
        if(empty($samity_day_change_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Samity Day Change ID is not provided');
			redirect('/samity_day_changes/index/');
		}
		if($this->Samity_day_change->delete($samity_day_change_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/samity_day_changes/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('samity_group_id');
		$data['samity_id']=$this->input->post('samity_id');
		$data['previous_samity_day']=$this->input->post('old_samity_day');
		$data['new_samity_day']=$this->input->post('cbo_samity_day');	
		$data['effective_date']=$this->input->post('txt_effective_date');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule	
		$this->form_validation->set_rules('samity_id','Code','trim|required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('cbo_samity_day','Samity Day','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_effective_date','Effective Date','trim|required|max_length[10]|is_date|xss_clean|callback_check_samity_effective_date');	
	}
	
	function _load_combo_data()
	{
		$branch_id = $this->get_branch_id();
		//This function is for listing of branches	
		$data['samities_info'] = $this->Samity->get_samity_list($branch_id);			
		//Type list which will be used in combo box		
		$data['samity_days'] = $this->Report->get_samity_days();
		return $data;
	}
	function check_samity_effective_date()
	{
		// check samity_effective_date
		$samity_info = $this->Samity->get_samity_opening_date($this->input->post('samity_id'),$this->input->post('txt_effective_date'));		
		if(empty($samity_info)) {
			$this->form_validation->set_message('check_samity_effective_date', " Effective date must be greater then Samity Opening Date.");
		        return FALSE;
		}		
		return TRUE;
	}
}
