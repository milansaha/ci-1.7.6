<?php
/** 
	* PO Areas Controller Class.
	* @pupose		Manage PO Areas information
	*		
	* @filesource	./system/application/controllers/Saving_products.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.Saving_products
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam $	
	* @lastmodified $Date: 2011-03-08 $	 
*/ 
class Saving_products extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Saving_product','',TRUE);		
	}

	function index()
	{
		$data['title']='Saving Products';
        $data['headline']='Saving Products';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Saving_product->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/saving_products/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		//if($total>0){
			//Loading data by model function call
			$data['Saving_products_info']=$this->Saving_product->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
			$data['counter'] = (int)$this->uri->segment(3);
			$this->layout->view('/saving_products/index',$data);
		
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
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_product->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/saving_products/add/', 'refresh');
				}
			}
		}
                $data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Saving Product';
        $data['headline']='Add New';

		$this->layout->view('/saving_products/save',$data);
	}	
	
	function edit($saving_product_id=null)
	{	
		$is_validate_error = false;
		//If ID is not provided, redirecting to index page
		if(empty($saving_product_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Savings Product ID is not provided');
			redirect('/saving_products/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$saving_product_id=$this->input->post('saving_product_id');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('saving_product_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_product->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/saving_products/index/', 'refresh');
				}
			}
			else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$data['row']=$this->Saving_product->read($saving_product_id);
        $data['title']='Edit Saving Product';
        $data['headline']='Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('saving_products/save',$data);
	}
	
	function delete($saving_product_id=null)
	{
        if(empty($saving_product_id))
		{
			$this->session->set_flashdata('warning','Savings Product ID is not provided');
			redirect('/saving_products/index/', 'refresh');
		}
        $has_savings_entry = $this->Saving_product->is_dependency_found('savings',  array('saving_products_id' => $saving_product_id));
        if($has_savings_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/saving_products/index/');
        }
        else
        {
            if($this->Saving_product->delete($saving_product_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/saving_products/index/');
            }
        }
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('Saving_product_id');
		$data['name']=$this->input->post('txt_name');
		$data['short_name']=$this->input->post('txt_short_name');
		$data['start_date']=$this->input->post('txt_start_date');
		$data['end_date']=$this->input->post('txt_end_date');
        $data['end_date'] = (!empty ($data['end_date']))?$data['end_date']:NULL;
		$data['type_of_deposit']=$this->input->post('cbo_type_of_deposit');
		$data['mandatory_amount_for_deposit']=$this->input->post('txt_mandatory_amount_for_deposit');
        $data['interest_rate']=$this->input->post('txt_interest_rate');
        return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]');
		$this->form_validation->set_rules('txt_short_name','Short Name','trim|xss_clean|required|max_length[100]|unique[saving_products.short_name.id.saving_product_id]');
		$this->form_validation->set_rules('txt_start_date','Start Date','trim|xss_clean|is_date|required');
		$this->form_validation->set_rules('txt_end_date','End Date','trim|xss_clean|is_date');
		$this->form_validation->set_rules('cbo_type_of_deposit','Type of Deposit','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_mandatory_amount_for_deposit','Mandatory Amount for Deposit','trim|xss_clean|numeric|required');
		$this->form_validation->set_rules('txt_interest_rate','Interest Rate','trim|xss_clean|required|numeric|max_length[5]');
	}   
        function _load_combo_data()
	{
		//Type of Deposit lists which will be used in type combo box
		$data['types_of_deposits'] = array('MANDATORY'=>'MANDATORY','VOLUNTARY'=>'VOLUNTARY');	
		//Balance Method list which will be used in Interest Calculation
		$data['balance_list_for_interest_calculations'] = array('MINIMUM BALANCE'=>'MINIMUM BALANCE','AVERAGE BALANCE'=>'AVERAGE BALANCE');
		$data['interest_calculation_time_unit_list'] = array('DAY(s)'=>'DAY(s)','MONTH(s)'=>'MONTH(s)');		
		return $data;
	}
}
