<?php
/** 
	* Loan Product Controller Class. 
	* @pupose		Manage Loan Product information
	*		
	* @filesource	\app\model\loan_products.php	
	* @package		microfin 
	* @subpackage	microfin.model.loan_products
	* @version      $Revision: 1 $
	* @author       $Author: Anis Alamgir $	
	* @lastmodified $Date: 2011-03-08 $	 
*/
class Loan_products extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Loan_product','Loan_product_category','Po_funding_organization'),'',TRUE);		
	}

	function index()
	{
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan_product->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/loan_products/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['loan_products']=$this->Loan_product->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Loan Products';
        $data['headline']='Loan Products';
		$this->layout->view('/loan_products/index',$data);
	}
	function view($loan_loan_product_id=null)
	{			
		$this->load->helper(array('date'));
		if(empty($loan_loan_product_id))
		{
			$this->session->set_flashdata('warning','Loan Product ID is not provided');
			redirect('/loan_products/index/', 'refresh');
		}
		$row=$this->Loan_product->get_product_detail_info($loan_loan_product_id);
		$data['row']=$row[0];	
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='View Loan Product Inoformation';
        $data['headline']='View Loan Product Inoformation';
		//echo "<pre>";print_r($data);die;
		$this->layout->view('loan_products/view',$data);		
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
				if($this->Loan_product->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/loan_products/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Loan Product';
        $data['headline']='Add New';
		$this->layout->view('/loan_products/save',$data);				
	}	
	
	function edit($loan_loan_product_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($loan_loan_product_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Loan Product ID is not provided');
			redirect('/loan_products/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$loan_loan_product_id = $_POST['loan_product_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('loan_product_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan_product->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/loan_products/index/', 'refresh');
				}
			}
		}		
		//Load data from database
		$data = $this->_load_combo_data();
		$data['row']=$this->Loan_product->read($loan_loan_product_id);
			
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Loan Product';
        $data['headline'] = 'Edit';
		$this->layout->view('loan_products/save',$data);		
	}
	/*
     * @Modified By: Matin
     * @Modification Date : 21-03-2011
     */
	function delete($loan_loan_product_id=null)
	{			
		if(empty($loan_loan_product_id))
		{
			$this->session->set_flashdata('warning','Loan Product ID is not provided');
			redirect('/loan_products/index/', 'refresh');
		}
        //Check wether the child data exists
        $has_loan_entry = $this->Loan_product->is_dependency_found('loans',  array('product_id' => $loan_loan_product_id));
        $has_member_entry = $this->Loan_product->is_dependency_found('members',  array('primary_product_id' => $loan_loan_product_id));
        $has_samity_entry = $this->Loan_product->is_dependency_found('samities',  array('product_id' => $loan_loan_product_id));
        if($has_loan_entry || $has_member_entry || $has_samity_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/loan_products/index/');
        }
		else
		{			
			//Validation is OK. So, add this data and redirect to the index page
			if($this->Loan_product->delete($loan_loan_product_id))
			{
					$this->session->set_flashdata('message',DELETE_MESSAGE);
					redirect('/loan_products/index/', 'refresh');
			}			
		}		
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		$data['short_name']=$this->input->post('txt_short_name');
		$data['code']=$this->input->post('txt_code');
		$data['loan_product_category_id']=$this->input->post('cbo_loan_product_category');	
		$data['start_date']=$this->input->post('txt_start_date');
		$data['end_date']=$this->input->post('txt_end_date');
        $data['end_date'] = (!empty ($data['end_date']))?$data['end_date']:NULL;
		$data['interest_calculation_method']=$this->input->post('cbo_interest_calculation_method');	
		$data['interest_rate']=$this->input->post('txt_interest_rate');	
		$data['minimum_loan_amount']=$this->input->post('txt_minimum_loan_amount');
		$data['maximum_loan_amount']=$this->input->post('txt_maximum_loan_amount');
		$data['default_loan_amount']=$this->input->post('txt_default_loan_amount');	
		$data['funding_organization_id']=$this->input->post('cbo_funding_organization');			
		$data['is_primary_product']=$this->input->post('cbo_is_primary_product');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean');			
		$this->form_validation->set_rules('txt_short_name','Short Name','trim|max_length[50]|xss_clean|required');
		$this->form_validation->set_rules('txt_code','Code','trim|max_length[20]|xss_clean|required|unique[loan_products.code.id.loan_product_id]');
		$this->form_validation->set_rules('cbo_loan_product_category','Product Category','trim|required|xss_clean|is_natural_no_zero');	
		$this->form_validation->set_rules('txt_start_date','Start Date','trim|is_date|required|xss_clean|max_length[10]');
		$this->form_validation->set_rules('txt_end_date','End Date','trim|is_date||max_length[10]xss_clean|callback_check_valid_end_date');
		$this->form_validation->set_rules('cbo_interest_calculation_method','Interest Calculation Method','trim|required|xss_clean');		
		$this->form_validation->set_rules('txt_interest_rate','Interest Rate','trim|max_length[5]|xss_clean|numeric');
		$this->form_validation->set_rules('txt_minimum_loan_amount','Min. Loan Amount','trim|max_length[10]|xss_clean|numeric');	
		$this->form_validation->set_rules('txt_maximum_loan_amount','Max. Loan Amount','trim|max_length[10]|xss_clean|numeric');
		$this->form_validation->set_rules('txt_default_loan_amount','Default Loan Amount','trim|max_length[10]|numeric|xss_clean');
		$this->form_validation->set_rules('cbo_funding_organization','Funding Organization','trim|required|xss_clean|is_natural_no_zero');	
		$this->form_validation->set_rules('cbo_is_primary_product','Is Primary Product','trim|required|max_length[1]|xss_clean');	
	}
	function check_valid_end_date($str)
	{
		$this->load->helper(array('date'));
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');
		
		if(!empty($end_date) ) {
			$end_date  = explode('-',$end_date);
			// check start date 
			if(!empty($start_date) ) {
				$start_date  = explode('-',$start_date);
				if(!isset($start_date[2]) or !is_numeric($start_date[0]) or !is_numeric($start_date[1]) or !is_numeric($start_date[2])) {
					$this->form_validation->set_message('check_valid_end_date', "At fist, you must be  a valid Start Date.");
			    return FALSE;
				}
				// end date
				if(isset($end_date[2]) and is_numeric($end_date[0]) and is_numeric($end_date[1]) and is_numeric($end_date[2])) {
					if(mysql_to_unix("{$end_date[0]}{$end_date[1]}{$end_date[2]}") < mysql_to_unix("{$start_date[0]}{$start_date[1]}{$start_date[2]}"))	{
						$this->form_validation->set_message('check_valid_end_date', "End date must be upper date then start date.");
			        return FALSE;
					}				
				} else {
					$this->form_validation->set_message('check_valid_end_date', "Must be enterd valid end date.");
			        return FALSE;
				}
			} else {
				$this->form_validation->set_message('check_valid_end_date', "At fist, you must be select a Start Date.");
			    return FALSE;
			}
		
		}
			
		return TRUE;
	}
	function _load_combo_data()
	{
		// loan product categpry
		$loan_product_category_list = array(''=>'---Select---');
		$loan_product_categories = $this->Loan_product_category->get_loan_product_category_list();
		foreach($loan_product_categories as $loan_product_category) {
			$loan_product_category_list[$loan_product_category->id] = $loan_product_category->short_name.'-'.$loan_product_category->name;
		}
		$data['loan_product_categories'] = 	$loan_product_category_list;
		
		//interest_calculation_method
		$data['interest_calculation_methods'] = array(''=>'---Select---','FLAT'=>'Flat','DECLINING_METHOD'=>'Declining Method');
		
		//Fundig Orgnization		
		$funding_organization_list = array(''=>'---Select---');
		$funding_organizations = $this->Po_funding_organization->get_funding_organization_list();
		foreach($funding_organizations as $funding_organization) {
			$funding_organization_list[$funding_organization->id] = $funding_organization->name;
		}
		$data['funding_organizations'] = 	$funding_organization_list;
		return $data;
	}
	/**
	 * Get loan product interest
	 *  @use saving_deposit(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 27-Mar-2011
	*/
	function ajax_for_get_product_info() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$product_id      = $this->input->post('product_id');
		if(empty($product_id))
        {
            $callback_message['status'] = 'failure';           
        }
		else
        {
			$callback_message['status'] = 'success';
			$product_interest = $this->Loan_product->get_loan_product_interest_rate($product_id);
					
			if(!empty($product_interest)) {
				foreach( $product_interest as $row) {				
				$callback_message['loan_products']['interest_rate'][] = $row->interest_rate;					
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }			  	
	} 
}
