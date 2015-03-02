<?php
/** 
	* Loan Product Category Controller Class. 
	* @pupose		Manage Loan Product Category information
	*		
	* @filesource	\app\model\loan_product_categories.php	
	* @package		microfin 
	* @subpackage	microfin.model.loan_product_categories
	* @version      $Revision: 1 $
	* @author       Anis Alamgir		
 	* @updated		Anis Alamgir
	* @lastmodified $Date: 2011-03-08 $	 
*/
class Loan_product_categories extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Loan_product_category','',TRUE);		
	}

	function index()
	{
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan_product_category->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/loan_product_categories/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['loan_product_categories']=$this->Loan_product_category->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Loan Product Category';
        $data['headline'] = 'Loan Product Category';
		$this->layout->view('/loan_product_categories/index',$data);
	}
	
	function add()
	{
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan_product_category->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/loan_product_categories/index/', 'refresh');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Loan Product Category';
        $data['headline'] = 'Add New';
		$this->layout->view('/loan_product_categories/save',$data);				
	}	
	
	function edit($loan_product_category_id=null)
	{			
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($loan_product_category_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Loan Product Category ID is not provided');
			redirect('/loan_product_categories/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$loan_product_category_id=$_POST['loan_product_category_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('loan_product_category_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan_product_category->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/loan_product_categories/index/', 'refresh');
				}
			}
		}		
		$data['row']=$this->Loan_product_category->read($loan_product_category_id);
			
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Loan Product Category';
        $data['headline'] = 'Edit';
		$this->layout->view('loan_product_categories/save',$data);		
	}
	/*
     * @Modified By: Matin
     * @Modification Date : 21-03-2011
     */
	function delete($loan_product_category_id=null)
	{			
		if(empty($loan_product_category_id))
		{
			$this->session->set_flashdata('warning','Loan Product Category ID is not provided');
			redirect('/loan_product_categories/index/');
		}
        //Check wether the child data exists
        $has_product_entry = $this->Loan_product_category->is_dependency_found('loan_products',  array('loan_product_category_id' => $loan_product_category_id));
        if($has_product_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/loan_product_categories/index/');
        }
		else
		{	
			//Validation is OK. So, add this data and redirect to the index page
			if($this->Loan_product_category->delete($loan_product_category_id))
			{
					$this->session->set_flashdata('message',DELETE_MESSAGE);
					redirect('/loan_product_categories/index/');
			}		
		}		
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		$data['short_name']=$this->input->post('txt_short_name');
		//$data['is_primary_product']=$this->input->post('cbo_is_primary_product');			
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('txt_short_name','Short Name','trim|required|max_length[20]|xss_clean|unique[loan_product_categories.short_name.id.loan_product_category_id]');
	}
}
