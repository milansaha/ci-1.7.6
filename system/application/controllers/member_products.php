<?php
class Member_products extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','date'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Member_product','Samity','Member','Loan_product'),'',TRUE);
	}

	function index()
	{
		$data['title']='Member Primary Product Transfer';
		$data['headline']='Member Primary Product Transfer';
		
		$cond= "";
		$session_data = $this->session->userdata('member_products.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];
			$cond['cbo_samity'] = $_POST['cbo_samity'];
			$sessionArray = array( 'member_products.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['cbo_samity']));
			$this->session->unset_userdata('member_products.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_samity'] = $session_data['cbo_samity'];
		} else {
			$this->session->unset_userdata('member_products.index');
		} 
		$cond['cbo_branch'] = $this->get_branch_id();
		
		$data['samities'] = $this->Samity->get_samity_list($cond['cbo_branch']);
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_product->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/member_products/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['member_products']=$this->Member_product->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/member_products/index',$data);
	}
	
	function add()
	{
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_not_validated = false;
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page	
				if($this->Member_product->add($data))
				{
					$this->session->set_flashdata('message','Product of Member has been added successfully');
					redirect('/member_products/index/', 'refresh');
				}
			}
			else{
				$is_not_validated = true;
				$submitted_data = $data;
			}
		}
		$data = $this->_load_combo_data();
		if($is_not_validated){
			$data['row'] = 	$this->__array_to_object($submitted_data);
			$member_id = $submitted_data['member_id'];
			if(is_numeric($member_id)){
				$member_samity_info = $this->Member->get_member_samity_info($member_id);
				if(!empty($member_samity_info)) {
					$data['member_information'] = $member_samity_info[0];
				}
				
			}			
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Primary Product Transfer information of a Member';
		$data['headline']='Add New';
		$this->layout->view('/member_products/save',$data);				
	}	
	
	function edit($member_product_id=null)
	{
		//If ID is not provided, redirecting to index page
		$is_not_validated = false;
		if(empty($member_product_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Products of Member ID is not provided');
			redirect('/member_products/index/', 'refresh');
		}	
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$this->_prepare_validation();	
		if($_POST)
		{			
			$member_product_id=$_POST['member_product_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('member_product_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_product->edit($data))
				{
					$this->session->set_flashdata('message','Products of Member has been updated successfully');
					redirect('/member_products/index/', 'refresh');
				}
				else{
					$is_not_validated = true;
					$submitted_data = $data;
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$row=$this->Member_product->read($member_product_id);	
		$data['row']=$row[0];
		$member_id = $row[0]->member_id;
		
		$old_primary_product = $row[0]->old_primary_product_id;
		
		if(is_numeric($member_id)){
				$member_samity_info = $this->Member->get_member_samity_info($member_id);
				if(!empty($member_samity_info)) {
					$data['member_information'] = $member_samity_info[0];
				}
				
				if(is_numeric($old_primary_product)){
					$old_product_info = $this->Loan_product->get_primary_loan_product_list($old_primary_product);
					if(!empty($old_product_info)) {
					$old_product_info = $old_product_info[0];					
					$data['member_information']->old_product->name = $old_product_info->product_mnemonic;
					$data['member_information']->old_product->mnemonic = $old_product_info->funding_org_name;
					}
				}
		}			
		$data['title']='Edit Primary Product Transfer information of a Member';
		$data['headline']='Edit Primary Product Transfer information of a Member';
		$this->layout->view('member_products/save',$data);		
	}
	
	function delete($member_product_id=null)
	{
        if(empty($member_product_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Product Transfer ID is not provided');
			redirect('/member_products/index/', 'refresh');
		}
		if($this->Member_product->delete($member_product_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/member_products/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('member_product_id');
		$data['member_id']=$this->input->post('member_id');	
		
		$members_info = $this->Member->read($this->input->post('member_id'));
		
		$data['branch_id']=isset($members_info->branch_id)?$members_info->branch_id:"";
		$data['samity_id']=isset($members_info->samity_id)?$members_info->samity_id:"";		
		$data['old_primary_product_id']=isset($members_info->primary_product_id)?$members_info->primary_product_id:"";
		$data['new_primary_product_id']=$this->input->post('cbo_product');
		$data['transfer_date']=$this->input->post('txt_transfer_date');						
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		
		$this->form_validation->set_rules('member_id','Member Name','required|numeric|xss_clean');
		$this->form_validation->set_rules('cbo_product','New Product Name','required|numeric|xss_clean|callback_check_duplicate_product|max_length[100]');
		$this->form_validation->set_rules('txt_transfer_date','Transfer Date','required|xss_clean|callback_check_transfer_date|max_length[100]');
		
	}
	function check_duplicate_product($str){
		$members_info = $this->Member->read($this->input->post('member_id'));
		$old_product_id = isset($members_info->primary_product_id)?$members_info->primary_product_id:"";
		$new_product_id = $str;
		if( $old_product_id == $new_product_id) {
			$this->form_validation->set_message('check_duplicate_product', "Old Product and New Product can't be same.");
			return FALSE;
		}
		return TRUE;
	}
	function check_transfer_date($str)
	{
		
		$transfer_date = $this->input->post('txt_transfer_date');
		
		$member_id = $this->input->post('member_id');
		if(!empty($transfer_date) ) {
			$transfer_date  = explode('-',$transfer_date);
			if(isset($transfer_date[2])) {
				$transfer_year = (is_numeric($transfer_date[0]))?$transfer_date[0]:"";
				$transfer_month = (is_numeric($transfer_date[1]))?$transfer_date[1]:"";
				$transfer_day = (is_numeric($transfer_date[0]))?$transfer_date[2]:"";
				
				if(isset($member_id)){
					$member_registration_date = $this->Member->get_member_registration_date($member_id);
					$member_registration_date  = explode('-',$member_registration_date);
				
					if(isset($member_registration_date[2])) {
						$member_registration_year = (is_numeric($member_registration_date[0]))?$member_registration_date[0]:"";
						$member_registration_month = (is_numeric($member_registration_date[1]))?$member_registration_date[1]:"";
						$member_registration_day = (is_numeric($member_registration_date[0]))?$member_registration_date[2]:"";
					
						if(mysql_to_unix("{$member_registration_year}{$member_registration_month}{$member_registration_day}") > mysql_to_unix("{$transfer_year}{$transfer_month}{$transfer_day}"))	{
							$this->form_validation->set_message('check_transfer_date', " Member Product transfer date must be upper date then Member registration date.");
				        	return FALSE;
						}
					}	
				}
								
			} else {
				$this->form_validation->set_message('check_transfer_date', "Must be enterd transfer date properly.");
		        	return FALSE;
			}
		} else {
				$this->form_validation->set_message('check_transfer_date', "Must be enterd transfer date properly.");
		        	return FALSE;
			}
			
		return TRUE;
	}
	function _load_combo_data()
	{
        $data['product_infos'][''] = '---Select---';
		$loan_products = $this->Loan_product->get_primary_loan_product_list();
		foreach($loan_products as $loan_product){
			$data['product_infos'][$loan_product->product_id] = $loan_product->product_mnemonic.' - '.$loan_product->funding_org_name;
		}
		return $data;
	}
}
