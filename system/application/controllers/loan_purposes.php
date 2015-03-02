<?php
/** 
	* Loan Purposes Controller Class.
	* @pupose		Loan_purpose information
	*		
	* @filesource	./system/application/models/loan_purposes.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.loan_purposes
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Loan_purposes extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Loan_purpose','',TRUE);		
		//$this->load->library('MY_Form_validation');	
	}

	function index()
	{
		$data['title']='Loan Purposes';
		$data['headline'] = 'Loan Purposes';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan_purpose->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/loan_purposes/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['loan_purposes_infos']=$this->Loan_purpose->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/loan_purposes/index',$data);
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
				if($this->Loan_purpose->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/loan_purposes/add/');
				}
			}
		}		
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Loan Purpose';
        $data['headline'] = 'Add New';
		$this->layout->view('/loan_purposes/save',$data);				
	}	
	
	function edit($loan_purpose_id=null)
	{			
		//If ID is not provided, redirecting to index page
		if(empty($loan_purpose_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Loan Purpose ID is not provided');
			redirect('/loan_purposes/index/');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$loan_purpose_id=$_POST['loan_purpose_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('loan_purpose_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan_purpose->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/loan_purposes/index/');
				}
			}
		}			
		//Load data from database
		$data['row']=$this->Loan_purpose->read($loan_purpose_id);
		
		$data['title']='Edit Loan Purpose';
        $data['headline'] = 'Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('loan_purposes/save',$data);		
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 22-03-2011
     */
	function delete($loan_purpose_id=null)
	{
		if(empty($loan_purpose_id))
		{
			$this->session->set_flashdata('warning','Loan Purpose ID is not provided');
			redirect('/loan_purposes/index/');
		}
        //Check wether the child data exists
        $has_loan_entry = $this->Loan_purpose->is_dependency_found('loans',  array('purpose_id' => $loan_purpose_id));
        if($has_loan_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/loan_purposes/index/');
        }
		else
		{
			if($this->Loan_purpose->delete($loan_purpose_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/loan_purposes/index/');
            }
		}
	}

	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		//$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|unique[loan_purposes.name]');			
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]|unique[loan_purposes.name.id.loan_purpose_id]');			
	}
	
}
