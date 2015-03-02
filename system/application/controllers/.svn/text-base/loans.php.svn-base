<?php
/** 
	* Loan Controller Class. 
	* @pupose		Manage Loan information
	*		
	* @filesource	\app\model\loans.php	
	* @package		microfin 
	* @subpackage	microfin.model.loans
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
class Loans extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Loan','Member','Loan_product','Po_branch','Samity','Config_customized_id','Loan_purpose'),'',TRUE);
		
		//$this->load->library('schedule');
		//$this->schedule->get_schedule_details();
	}

	function authorization_index()
	{
		$cond= "";
		$session_data = $this->session->userdata('loans.index');
	
		if(isset($_POST['cbo_samity'])){
			$cond['samity'] = $_POST['cbo_samity'];	
			$sessionArray = array( 'loans.authorization_index'=>array('cbo_samity'=>$cond['samity']));			
			$this->session->unset_userdata('loans.authorization_index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['samity'] = $session_data['cbo_samity'];					
		} else {
			$this->session->unset_userdata('loans.authorization_index');
		} 
		
		if(isset($_POST['loandata']))
		{
			//echo "<pre>";print_r($_POST['loandata']);die;
			$user=$this->session->userdata('system.user');
			$i=1;
			if($this->input->post('submit_1'))
			{				
				foreach($_POST['loandata'] as $row)
				{				
					$data['loans'][$i]['id']=$row['id'];	
					$data['loans'][$i]['is_authorized']=0;
					if(!empty($row['is_authorized']))
					{
						$data['loans'][$i]['is_authorized']=$row['is_authorized'];
					}							
					$data['loans'][$i]['authorized_by']=$user['id'];	
					$data['loans'][$i]['authorization_date']=date('Y-m-d');	
					$i++;					
				}				
			}
			else
			{				
				foreach($_POST['loandata'] as $row)
				{				
					$data['loans'][$i]['id']=$row['id'];	
					$data['loans'][$i]['is_authorized']=1;							
					$data['loans'][$i]['authorized_by']=$user['id'];	
					$data['loans'][$i]['authorization_date']=date('Y-m-d');	
					$i++;					
				}
			}
			//echo "<pre>";print_r($data['loans']);die;
			if($this->Loan->authorized($data['loans']))
			{
				$this->session->set_flashdata('message','Loan information has been authorized successfully');
				redirect('/loans/authorization_index/');
			}
		}
		$data['title']='Loan Authorization';	
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan->get_unauthorized_loan_list_row_count($cond);		

		//Initializing Pagination
		$config['base_url'] = site_url('/loans/authorization_index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);			
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());
		//Loading data by model function call
		$data['loans']=$this->Loan->get_unauthorized_loan_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		$data['counter'] = (int)$this->uri->segment(3);
		// Loading samity list which will be used in combo box	
				
		$this->layout->view('/loans/authorization_index',$data);
	}

	function index()
	{
		$cond= "";        
		$session_data = $this->session->userdata('loans.index');
	
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity']) || isset($_POST['cbo_loan_status'])){
			$cond['name'] = $_POST['txt_name'];		
			$cond['samity'] = $_POST['cbo_samity'];	
			$cond['loan_status'] = $_POST['cbo_loan_status'];		
			$sessionArray = array( 'loans.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity'],'cbo_loan_status'=>$cond['loan_status']));			
			$this->session->unset_userdata('loans.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];	
			$cond['loan_status'] = $session_data['cbo_loan_status'];			
		} else {
			$this->session->unset_userdata('loans.index');
		} 

		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan->row_count($cond);

		//Initializing Pagination
		$config['base_url'] = site_url('/loans/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());	
		$data['current_status'] = array('0'=>'Active','1'=>'Inactive','2'=>'Closed');
		
		//Loading data by model function call
		$data['loans']=$this->Loan->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Loans';
		$data['headline']='Loans';
		$this->layout->view('/loans/index',$data);
	}
	
	function add()
	{
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{
			$this->load->model('Loan_schedule');
			$this->Loan->set_loan_scheduler($this->Loan_schedule);
			$data=$this->_get_posted_data();
			//load session data
			$user=$this->session->userdata('system.user');		
			$data['disbursed_by']=$user['id'];		
			$data['is_authorized']=0;
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			$cbo_product = $this->input->post('cbo_product'); 
			$cbo_mode_of_interest = $this->input->post('cbo_mode_of_interest');  
			$cbo_interest_calculation_method = $this->input->post('cbo_interest_calculation_method');  			 
			$cbo_loan_purpose = $this->input->post('cbo_loan_purpose'); 			  
			$cbo_po_funding_organization = $this->input->post('cbo_po_funding_organization');   
			$cbo_repayment_frequency = $this->input->post('cbo_repayment_frequency'); 
			$cbo_current_status = $this->input->post('cbo_current_status');   			
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan->add($data))
				{
                    $this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/loans/index/');
				}
			} 
			else {				
				$is_validate_error = true;				
			}
		}
		
		$data = $this->_load_combo_data();
		if(isset($member_id)){
			$load_combo_conditon['member_id'] = $member_id;
			$data = $this->_load_combo_data($load_combo_conditon);
		}
		//If data is not posted or validation fails, the add view is displayed
		if($is_validate_error and isset($member_id) and !empty($member_id)){
			$member_info=$this->Loan->get_member_info($member_id);
			$data['row']->member_id = $member_info->id;
			$data['row']->member_info = $member_info->name.' - '.$member_info->code;
			$data['row']->product_id = isset($cbo_product)?$cbo_product:"";
			$data['row']->mode_of_interest = isset($cbo_mode_of_interest)?$cbo_mode_of_interest:"";
			$data['row']->interest_calculation_method = isset($cbo_interest_calculation_method)?$cbo_interest_calculation_method:"";
			$data['row']->purpose_id = isset($cbo_loan_purpose)?$cbo_loan_purpose:"";			
			$data['row']->repayment_frequency = isset($cbo_repayment_frequency)?$cbo_repayment_frequency:"";	
			$data['row']->current_status = isset($cbo_current_status)?$cbo_current_status:"";
			$general_configurations = $this->Loan->get_general_configurations();
                        $multiloan_setting = null;
                        if(isset ($general_configurations->is_multiple_loan_allowed_for_primary_products)){$multiloan_setting = $general_configurations->is_multiple_loan_allowed_for_primary_products;}
                        $data['products'] = $this->Loan->get_loan_product_list_by_member($member_id,$multiloan_setting);	
			//echo "<pre>";print_r($data['row']);die;		
		}
		$data['title']='Add Loan';
		$data['headline'] = 'Add New';
		$this->layout->view('/loans/save',$data);				
	}	
	
	function edit($loan_id=null)
	{			
		//$this->load->library('auth');
		
		//$this->output->enable_profiler(TRUE);
		//If ID is not provided, redirecting to index page
		$is_validate_error = false;
		if(empty($loan_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Loan ID is not provided');
			redirect('/loans/index/');
		}
        /*
        if(!$this->Loan->is_valid_loan_id($loan_id))
        {
          $this->session->set_flashdata('warning','Loan ID is not provided');
			redirect('/loans/index/');
        }
        */
		if($this->Loan->is_authorized_loan($loan_id))
        {
            $this->session->set_flashdata('warning','Sorry! Loan can\'t be edit or delete after authorization.');
			redirect('/loans/index/');
        }
        
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$this->load->model('Loan_schedule');
			$this->Loan->set_loan_scheduler($this->Loan_schedule);
			//Perform the Validation
			$loan_id = $this->input->post('loan_id');
			$member_id = $this->input->post('member_id'); 
			$cbo_product = $this->input->post('cbo_product'); 
			$cbo_mode_of_interest = $this->input->post('cbo_mode_of_interest');  
			$cbo_interest_calculation_method = $this->input->post('cbo_interest_calculation_method');  			 
			$cbo_loan_purpose = $this->input->post('cbo_loan_purpose'); 			  
			$cbo_po_funding_organization = $this->input->post('cbo_po_funding_organization');   
			$cbo_repayment_frequency = $this->input->post('cbo_repayment_frequency'); 
			$cbo_current_status = $this->input->post('cbo_current_status');			
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();							
				$data['id']=$this->input->post('loan_id');				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/loans/index/');
				}
			} 
			else {				
				$is_validate_error = true;				
			}
		}
		
		$load_combo_conditon = array();	
				
		$row=$this->Loan->read($loan_id);
		//print_r($row);
		if(isset($row->member_id)){
			$load_combo_conditon['member_id'] = $row->member_id;
			$load_combo_conditon['current_product_id'] = $row->product_id;
		}
		//Load data from database
		$data = $this->_load_combo_data($load_combo_conditon);
		
		$data['row']=$row;
		
		if(isset($row->member_id)){
			$member_info=$this->Loan->get_member_info($row->member_id);
			$data['row']->member_info = $member_info->name.' - '.$member_info->code;
         }
		if($is_validate_error and isset($member_id) and !empty($member_id)){
			$member_info=$this->Loan->get_member_info($member_id);
			$data['row']->member_id = $member_info->id;
			$data['row']->member_info = $member_info->name.' - '.$member_info->code;
			$data['row']->product_id = isset($cbo_product)?$cbo_product:"";
			$data['row']->mode_of_interest = isset($cbo_mode_of_interest)?$cbo_mode_of_interest:"";
			$data['row']->interest_calculation_method = isset($cbo_interest_calculation_method)?$cbo_interest_calculation_method:"";
			$data['row']->purpose_id = isset($cbo_loan_purpose)?$cbo_loan_purpose:"";			
			$data['row']->repayment_frequency = isset($cbo_repayment_frequency)?$cbo_repayment_frequency:"";	
			$data['row']->current_status = isset($cbo_current_status)?$cbo_current_status:"";		
		}
        $data['title']='Edit Loan';
        $data['headline'] = 'Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('loans/save',$data);		
	}
	
	/*
     * @Modified By: Matin
     * @Modification Date : 22-03-2011
     */
	function delete($loan_id=null)
	{
		if(empty($loan_id))
		{
			$this->session->set_flashdata('warning','Loan ID is not provided');
			redirect('/loans/index/');
		}
        if($this->Loan->is_authorized_loan($loan_id))
        {
            $this->session->set_flashdata('warning','Sorry! Loan can\'t be edit or delete after authorization.');
			redirect('/loans/index/');
        }
        //Check wether the child data exists
        $has_loan_transaction_entry = $this->Loan->is_dependency_found('loan_transactions',  array('loan_id' => $loan_id));
        if($has_loan_transaction_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/loans/index/');
        }
		else
		{
			//Validation is OK. So, add this data and redirect to the index page
			if($this->Loan->delete($loan_id))
			{
					$this->session->set_flashdata('message',DELETE_MESSAGE);
					redirect('/loans/index/');
			}
		}
	}
	
	function _get_posted_data()
	{						
		$data=array();				
		
		$data['member_id']=$this->input->post('member_id');
		$members_info = $this->Member->read($this->input->post('member_id'));		
		
		$data['branch_id']=isset($members_info->branch_id)?$members_info->branch_id:"";
		$data['samity_id']=isset($members_info->samity_id)?$members_info->samity_id:"";
		
		$data['customized_loan_no']=$this->input->post('txt_customized_loan_no');
		$data['loan_application_no']=$this->input->post('txt_loan_application_no');
		$data['loan_amount']=$this->input->post('txt_loan_amount');	
		$data['product_id']=$this->input->post('cbo_product');
		
		$data['funding_org_id']=$this->Loan_product->get_funding_organization_id_by_product($this->input->post('cbo_product'));
		
		$data['disburse_date']=$this->input->post('txt_disburse_date');
		$data['first_repayment_date']=$this->input->post('txt_first_repayment_date');	
		$data['repayment_frequency']=$this->input->post('cbo_repayment_frequency');
		$data['number_of_installment']=$this->input->post('txt_number_of_installment');	
		$data['loan_period_in_month']=$this->input->post('txt_loan_period_in_month');
		$data['purpose_id']=$this->input->post('cbo_loan_purpose');	
		$data['insurance_amount']=$this->input->post('txt_insurance_amount');	
		$data['cycle']=$this->input->post('txt_cycle');	
		$data['mode_of_interest']=$this->input->post('cbo_mode_of_interest');
		$data['interest_calculation_method']=$this->input->post('cbo_interest_calculation_method');
		$data['interest_rate']=$this->input->post('txt_interest_rate');	
		$data['discount_interest_amount']=$this->input->post('txt_discount_interest_amount');
		$data['total_payable_amount']=$this->input->post('txt_total_payable_amount');
		$data['interest_amount']=$this->input->post('txt_interest_amount');	
		$data['installment_amount']=$this->input->post('txt_installment_amount');        
		$data['guarantor_name_1']=$this->input->post('txt_guarantor_name_1');
		$data['guarantor_relationship_1']=$this->input->post('txt_guarantor_relationship_1');
		$data['guarantor_address_1']=$this->input->post('txt_guarantor_address_1');	
		$data['guarantor_name_2']=$this->input->post('txt_guarantor_name_2');
		$data['guarantor_relationship_2']=$this->input->post('txt_guarantor_relationship_2');
		$data['guarantor_address_2']=$this->input->post('txt_guarantor_address_2');		
		$data['loan_type']="R";
	//	echo '<pre>';
	//	print_r($data);
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('member_id','Member','trim|xss_clean|required');	
		$this->form_validation->set_rules('txt_customized_loan_no','Customized Loan No','trim|xss_clean|required|unique[loans.customized_loan_no.id.loan_id]');	
		$this->form_validation->set_rules('txt_loan_application_no','Loan Application No','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_disburse_date','Disburse Date','trim|xss_clean|required|callback_check_disburse_date');	
		$this->form_validation->set_rules('cbo_product','Product','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_repayment_frequency','Repayment Frequency','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_mode_of_interest','Mode of Interest','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_interest_calculation_method','Interest Calculation Method','trim|xss_clean|required');
		//$this->form_validation->set_rules('cbo_po_funding_organization','Funding Organization','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_loan_purpose','Loan Purpose','trim|xss_clean|required');		
		$this->form_validation->set_rules('txt_loan_amount','Loan Amount','trim|xss_clean|required|numeric');	
		$this->form_validation->set_rules('txt_interest_rate','Interest Rate','trim|xss_clean|numeric|required|numeric');	
		$this->form_validation->set_rules('txt_interest_amount','Interest Amount','trim|xss_clean|numeric|required');	
		$this->form_validation->set_rules('txt_installment_amount','Installment Amount','trim|xss_clean|numeric|required');	
		$this->form_validation->set_rules('txt_discount_interest_amount','Discount Interest Amount','trim|xss_clean|numeric');
		$this->form_validation->set_rules('txt_number_of_installment','No. of Installment','trim|xss_clean|integer|required');	
		$this->form_validation->set_rules('txt_total_payable_amount','Total Payable Amount','trim|xss_clean|numeric|required');				
		$this->form_validation->set_rules('txt_cycle','Cycle','trim|xss_clean|numeric|required');	
		$this->form_validation->set_rules('txt_first_repayment_date','First Repayment Date','trim|xss_clean|required|is_date|callback_check_first_repayment_date');
		$this->form_validation->set_rules('txt_insurance_amount','Insurance Amount','trim|xss_clean|numeric');
		$this->form_validation->set_rules('txt_loan_period_in_month','Loan period in month','trim|xss_clean|numeric|required');
		$this->form_validation->set_rules('txt_installment_amount','Installment Amount','trim|xss_clean|required|numeric');		
	}
	function _load_combo_data($load_combo_conditon = array())
	{
		$member_id = isset($load_combo_conditon['member_id'])?$load_combo_conditon['member_id']:"-1";
		$current_product_id = isset($load_combo_conditon['current_product_id'])?$load_combo_conditon['current_product_id']:"-1";
		// loan_product
		$data['loan_products'] = array(""=>"--Select--");
        $general_configurations = $this->Loan->get_general_configurations();        
        $multiloan_setting = null;
        if(isset ($general_configurations->is_multiple_loan_allowed_for_primary_products)){$multiloan_setting = $general_configurations->is_multiple_loan_allowed_for_primary_products;}
		$products = $this->Loan->get_loan_product_list_by_member($member_id,$multiloan_setting);
		if(!empty($products)){
			foreach($products as $product){
				$data['loan_products'][$product->product_id] = $product->product_short_name.'-'.$product->funding_organization_name;
			}			
		}
		//Type list which will be used in combo box
		$data['loan_purposes'] = $this->Loan_purpose->get_loan_purpose_list();
		//Type list which will be used in combo box
		$data['po_funding_organizations'] = $this->Loan->get_po_funding_organizations_list();				
		$data['interest_calculation_methods'] = array('FLAT'=>'FLAT','REDUCING'=>'REDUCING');
		$data['repayment_frequencies'] = array('WEEKLY'=>'WEEKLY','MONTHLY'=>'MONTHLY','YEARLY'=>'YEARLY','ONE_TIME'=>'ONE_TIME');	
		$data['mode_of_interest'] = array('YEARLY_PER_HUNDRED'=>'PER_HUNDRED (YEARLY)','DAILY_PER_THOUSAND'=>'PER_THOUSAND (DAILY)');
		$data['current_status'] = array('0'=>'Active','1'=>'Inactive','2'=>'Closed');
		return $data;
	}	
	function getSchedule($loan_id){		
		$this->employees_lib->get_schedule($data);
	}
	function __loan_auto_id($product_id,$member_id)
	{
		
		$loan_code = '';
		$product_short_name = '';
		$product_code = '';		
		$member_code = '';
		$loan_cycle = '';
		$separator = '';
		// Auto ID		
		$loan_auto_id_config = $this->Config_customized_id->get_auto_id_config_info();
		//$loan_auto_id_config =$loan_auto_id_config[0];
		if(!is_numeric($product_id) || !is_numeric($member_id)) {
		    return FALSE;
		}
		if( isset($loan_auto_id_config->is_loan_code_need) AND $loan_auto_id_config->is_loan_code_need) {
			$separator = $loan_auto_id_config->loan_code_separator;
			 if($loan_auto_id_config->is_include_member_code_for_loan) {
				$member_code=$this->Member->get_member_code($member_id).$separator;
			}
			if($loan_auto_id_config->is_loan_product_short_name_need){
				$product_short_name=$this->Loan_product->get_loan_product_short_name($product_id).$separator;
			}
			if($loan_auto_id_config->is_loan_product_code_need){
				$product_code=$this->Loan_product->get_loan_product_code($product_id).$separator;
			}
			// separator not needed ; coz cycle will be last item 
			if($loan_auto_id_config->is_cycle_need){
				$loan_cycle=$this->Loan->get_max_loan_cycle_by_product_and_member($product_id,$member_id);
			}
			$loan_code = $product_code.$product_short_name.$member_code.$loan_cycle;
			return $loan_code;
		}
		 return false;	
	}
	function ajax_for_get_loan_auto_id_by_samity_id_and_member_id(){
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$product_id      = $this->input->post('product_id');		
		$member_id      = $this->input->post('member_id');
		$callback_message['loan_code'] = '';
		
		if(empty($product_id) || empty($member_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Please, Select Member/Product';
        }
		else
        {
			$callback_message['status'] = 'success';
			$callback_message['loan_code'] = $this->__loan_auto_id($product_id,$member_id);
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }
	}
	/**
	 * Get loan product list where member currently not loned.
	 *  @use loan(save)
	 *  @added Anis
	*/
	function ajax_for_get_loan_product_list_by_member() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$member_id = $this->input->post('member_id');
        $general_configurations = $this->Loan->get_general_configurations();
        $multiloan_setting = null;
        if(isset ($general_configurations->is_multiple_loan_allowed_for_primary_products)){$multiloan_setting = $general_configurations->is_multiple_loan_allowed_for_primary_products;}
		if(empty($member_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			$product_info = $this->Loan->get_loan_product_list_by_member($member_id,$multiloan_setting);
			//print_r($product_info);
			if(!empty($product_info)) {
				foreach( $product_info as $row) {
				$callback_message['product']['id'][] = $row->product_id;
				$callback_message['product']['name'][] = $row->product_short_name.' - ' .$row->funding_organization_name;
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
	/**
 	* Calculate loan cycle no by product and member.
 	*  @use loan(save)
 	*  @added Anis
 	*/
	function ajax_for_get_loan_cycle_by_product_and_member() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$product_id      = $this->input->post('product_id');
		$member_id      = $this->input->post('member_id');
		//print($product_id.'-'.$member_id.'-'.$disburse_date);die;
		if(!is_numeric($product_id) OR !is_numeric($member_id) )
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= $product_id.' member'.$member_id;
        }
		else
        {
			$callback_message['status'] = 'success';
			$loan_cycle_info = $this->Loan->get_loan_cycle_by_product_and_member($product_id,$member_id);
			//print_r($loan_cycle_info);die;
			if(!empty($loan_cycle_info)) {
				$callback_message['loan']['cycle_no'] = $loan_cycle_info->cycle;
				$callback_message['product']['interest_rate'] = $loan_cycle_info->interest_rate;
                $callback_message['product']['interest_calculation_method'] = $loan_cycle_info->interest_calculation_method;
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
	/**
	 * @name check_disburse_date
	 * @uses loan(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 15-Feb-2011
	 */
	function check_disburse_date()
	{
		// check_disburse_date
		$loan_disburse_date=$this->input->post('txt_disburse_date');
		$member_registration_date = $this->Member->get_member_registration_date($this->input->post('member_id'));		
		if($member_registration_date>$loan_disburse_date) {
			$this->form_validation->set_message('check_disburse_date', "Loan disburse date must be greater then member registration date.");
		        return FALSE;
		}		
		return TRUE;
	}
	/** @name first_repayment_date
	 * @uses loan(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 15-Feb-2011
	 */
	function check_first_repayment_date()
	{		
		// check_first_repayment_date
		$loan_disburse_date=$this->input->post('txt_disburse_date');
		$loan_first_repayment_date=$this->input->post('txt_first_repayment_date');		
		if($loan_first_repayment_date<$loan_disburse_date) {			
			$this->form_validation->set_message('check_first_repayment_date', "First repayment date must be grater then loan disbursement date.");
		        return FALSE;
		}		
		return TRUE;
	}
}
