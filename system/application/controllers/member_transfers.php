<?php
/** 
        * Member Transfer Controller Class.
        * @pupose               Manage member transfer information
        *               
        * @filesource   \app\controllers\member_transfer_controller.php    
        * @package              microfin 
        * @subpackage   microfin.controller.member_transfer_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $       
        * @lastmodified $Date: 2011-01-04 $      
*/ 
class Member_transfers extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','date'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Member_transfer','Member','Samity'),'',TRUE);		
	}

	function index()
	{		
		$cond= "";
		$session_data = $this->session->userdata('member_transfers.index');
		if(isset($_POST['txt_from_date']) || isset($_POST['txt_to_date']) || isset($_POST['txt_name'])){
			
			$cond['from_date'] = $_POST['txt_from_date'];
			$cond['to_date'] =  $_POST['txt_to_date'];			
			$cond['name'] = $_POST['txt_name'];			
			
			$sessionArray = array( 'member_transfers.index'=>array(
												'from_date'=>$cond['from_date'],
												'to_date'=>$cond['to_date'],
												'name'=>$cond['name']																						
												));
			//print_r($session_data);
			$this->session->unset_userdata('member_transfers.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['from_date'] = $session_data['from_date'];
			$cond['to_date'] = $session_data['to_date'];
			$cond['name'] = $session_data['name'];			
		} else {
			$this->session->unset_userdata('member_transfers.index');
		} 
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_transfer->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/member_transfers/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['member_transfers']=$this->Member_transfer->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Member Samity Transfer';
        $data['headline']='Member Samity Transfer';
		$this->layout->view('/member_transfers/index',$data);
	}
	
	function add()
	{
		//$this->output->enable_profiler(1);
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validaiton_fail = false;
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//$data['created_on']=date("Y-m-d");
			
					
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				
				if($this->Member_transfer->member_transfer_add($data))
				{
					
					$this->session->set_flashdata('message',ADD_MESSAGE);
					//die;
					redirect('/member_transfers/index/', 'refresh');
				}
			}
			else {
				$is_validaiton_fail = true;
				$exist_data = $data;
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		//$data = $this->_load_combo_data();
		if($is_validaiton_fail){
			$data = $exist_data;
			if(isset($exist_data['member_id']) and is_numeric($exist_data['member_id'])){
				$member_id = $exist_data['member_id'];
				$new_samity_id = $exist_data['new_samity_id'];
				$data['member_samity_info'] = $this->Member->get_member_samity_info($member_id);
				$data['member_loan_info'] = $this->Member->get_member_loan_info($member_id);
				$data['member_saving_info'] = $this->Member->get_member_saving_info($member_id);
				$data['new_saving_info'] = $this->Samity->get_branch_samity_field_officer_info_by_samity_id_report($new_samity_id);
			}
		}
		$data['title']='Add Member Samity Transfer';
        $data['headline']='Add New';
		$this->layout->view('/member_transfers/save',$data);				
	}	
	
	function edit($member_transfer_id=null)
	{	
		//If ID is not provided, redirecting to index page
		
		$is_validaiton_fail = false;
		if(empty($member_transfer_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Member Transfer ID is not provided');
			redirect('/member_transfers/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$member_transfer_id=$_POST['member_transfer_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{	
				$data=$this->_get_posted_data();			
				$data['id']=$this->input->post('member_transfer_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_transfer->member_transfer_edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/member_transfers/index/', 'refresh');
				}
			}
			else {
				$is_validaiton_fail = true;
				$exist_data = $data;
			}
		}
		//Load data from database
		$row=$this->Member_transfer->read($member_transfer_id);
		$row = $row[0];
		if(isset($row->member_id)) {
			$this->Member_transfer->get_all_transfer_data_by_transfer_id($row);
		//print_r($row);
		}
		$data['row']=$row;
		$data['title']='Edit Member Samity Transfer';
        $data['headline']='Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('member_transfers/save',$data);
	}
   
	function delete($member_transfer_id=null)
	{
        if(empty($member_transfer_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Member Transfer ID is not provided');
			redirect('/member_transfers/index/', 'refresh');
		}
		if($this->Member_transfer->delete($member_transfer_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/member_transfers/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();	
		$data['member_id']=$this->input->post('member_id');
		$data['old_branch_id']=$this->input->post('old_branch_id');
		$data['old_samity_id']=$this->input->post('old_samity_id');
		
		
		$data['new_branch_id']=$this->input->post('new_branch_id');
		$data['new_samity_id']=$this->input->post('new_samity_id');
		
		$total_loan = count($this->input->post('loan_id'));
		$loan_id = $this->input->post('loan_id');
		$loan_paid_amount = $this->input->post('loan_paid_amount');
		
		$total_saving = count($this->input->post('saving_id'));
		$saving_id = $this->input->post('saving_id');
		$saving_withdraw_amount = $this->input->post('saving_withdraw_amount');
		$data['loan']['total_row'] = $total_loan;
		$data['saving']['total_row'] = $total_saving;
		
		$data['saving']['member_primary_product_id'] = $this->input->post('primary_product_id');
		
		//echo $total_loan;
		for($i=0;$i<$total_loan;$i++) {
			$data['loan']['id'][] = $loan_id[$i];
			$data['loan']['amount'][] = $loan_paid_amount[$i];
			
			$data['loan']['transaction_date'][] = $this->input->post('txt_transfer_date');
			$data['loan']['entry_by'][] = $this->get_user_id();
			$data['loan']['entry_date'][] = $this->input->post('txt_transfer_date');
		}
		for($i=0;$i<$total_saving;$i++) {
			$data['saving']['id'][] = $saving_id[$i];
			$data['saving']['amount'][] = $saving_withdraw_amount[$i];
			$data['saving']['transaction_date'][] = $this->input->post('txt_transfer_date');
			$data['saving']['created_by'][] = $this->get_user_id();
			$data['saving']['created_on'][] = $this->input->post('txt_transfer_date');
			$data['saving']['updated_by'][] = $this->get_user_id();
			$data['saving']['updated_on'][] = $this->input->post('txt_transfer_date');	
		}
		$data['transfer_date']=$this->input->post('txt_transfer_date');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('member_id','Member','trim|xss_clean|required|callback_check_duplicate_transfer');
		$this->form_validation->set_rules('new_samity_id','New Samity','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_transfer_date','Transfer Date','trim|xss_clean|required|callback_check_transfer_date|max_length[15]');
	}
	function check_duplicate_transfer($str)
	{
		$member_id = $this->input->post('member_id');
		$member_transfer_id = $this->input->post('member_transfer_id');
		// check unauthorised transfer exists
		if(is_numeric($member_id) and (empty($member_transfer_id)) ){
			if($this->Member_transfer->get_unauthorised_transfer_by_member_id($member_id))
			{
				$this->form_validation->set_message('check_duplicate_transfer', "A transfer already pending.");
			        return FALSE;
			}	
		}
		return TRUE;
	}
	
	function check_transfer_date($str)
	{
		
		$transfer_date = $this->input->post('txt_transfer_date');
		$member_id = $this->input->post('member_id');
		if(!empty($transfer_date)) {
			$transfer_date  = explode('-',$transfer_date);
			if(isset($transfer_date[2])) {
				
				$transfer_year = (is_numeric($transfer_date[0]))?$transfer_date[0]:"";
				$transfer_month = (is_numeric($transfer_date[1]))?$transfer_date[1]:"";
				$transfer_day = (is_numeric($transfer_date[2]))?$transfer_date[2]:"";
				
				if(isset($member_id)){
					$member_registration_date = $this->Member->get_member_registration_date($member_id);
					$member_registration_date  = explode('-',$member_registration_date);
				
					if(isset($member_registration_date[2])) {
						$member_registration_year = (is_numeric($member_registration_date[0]))?$member_registration_date[0]:"";
						$member_registration_month = (is_numeric($member_registration_date[1]))?$member_registration_date[1]:"";
						$member_registration_day = (is_numeric($member_registration_date[0]))?$member_registration_date[2]:"";
					
						if(mysql_to_unix("{$member_registration_year}{$member_registration_month}{$member_registration_day}") > mysql_to_unix("{$transfer_year}{$transfer_month}{$transfer_day}"))	{
							$this->form_validation->set_message('check_transfer_date', " Member transfer date must be upper date then Member registration date.");
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
		//This function is for listing of Samity	
		$data['samity_infos'] = $this->Samity->get_samities();
		$data['member_infos'] = $this->Member->get_member_info();
		return $data;
	}
}
