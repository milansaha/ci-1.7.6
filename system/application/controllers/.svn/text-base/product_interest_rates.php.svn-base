<?php
class Product_interest_rates extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Product_interest_rate','',TRUE);		
	}

	function index()
	{
		$data['title']='Product Interest Rate';
		$data['headline'] = 'Product Interest Rate';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Product_interest_rate->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/product_interest_rates/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['product_interest_rate']=$this->Product_interest_rate->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/product_interest_rates/index',$data);
	}
	
	function add()
	{
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$product_id=$this->input->post('cbo_product');
		$is_validate_error = false;
		if($_POST)
		{
			$is_validate_error = false;
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Product_interest_rate->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/product_interest_rates/index/', 'refresh');
				}
			}
			else {
				$is_validate_error = TRUE;
			}			
		}		
		$data = $this->_load_combo_data();
		if($is_validate_error){
				$data['row']->product_id = isset($product_id)?$product_id:"";			
		}		
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Product Interest Rate';
		$data['headline']='Add New';
		//echo "<pre>";print_r($data);die;
		$this->layout->view('/product_interest_rates/add',$data);				
	}	
	
	function edit($product_interest_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($product_interest_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Product ID is not provided');
			redirect('/product_interest_rates/index/', 'refresh');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//$product_interest_id=$_POST['product_interest_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Product_interest_rate->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/product_interest_rates/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$row=$this->Product_interest_rate->read($product_interest_id);
		$data['row']=$row[0];
        $data['title']='Edit Product Interest Rate';
		$data['headline']='Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('product_interest_rates/edit',$data);		
	}
	
	function delete($product_interest_id=null)
	{
       if(empty($product_interest_id))
		{
			$this->session->set_flashdata('warning','Product Interest Rate ID is not provided');
			redirect('/product_interest_rates/index/');
		}
		if($this->Product_interest_rate->delete($product_interest_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/product_interest_rates/index/');
		}
	}	
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('product_interest_id');
		$data['interest_rate']=$this->input->post('txt_interest_rate');
		$data['interest_provision_rate']=$this->input->post('txt_interest_provision_rate');
		$data['effective_date']=$this->input->post('txt_effective_date');
		$data['end_date']=$this->input->post('txt_end_date');
		$data['product_id']=$this->input->post('cbo_product');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_interest_rate','Interest Rate','required|numeric');
		$this->form_validation->set_rules('txt_interest_provision_rate','Provision Interest Rate','required|numeric');
		$this->form_validation->set_rules('txt_effective_date','Effective Date','required');
		$this->form_validation->set_rules('txt_end_date','End Date','required');
		$this->form_validation->set_rules('cbo_product','Product Name','trim|required');
	}
	
	function _load_combo_data()
	{
		//This function is for listing of Samity Group	
		$data['product_infos'] = $this->Product_interest_rate->get_products();
		return $data;
	}
}
