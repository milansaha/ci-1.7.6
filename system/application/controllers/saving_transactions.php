<?php
/** 
	* Saving Transaction transactions Controller Class.
	* @pupose		Manage Saving Transaction information
	*		
	* @filesource	\app\controllers\saving_transactions.php	
	* @package		microfin 
	* @subpackage	microfin.controller.saving_transactions
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class saving_transactions extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Saving_transaction','',TRUE);
		$this->load->model('Saving','',TRUE);		
	}
/**
 * @use savings_transactions(save)
 */
	function ajax_for_get_savings_information() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$member_id      = $this->input->post('member_id');
		if(empty($member_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			$member_saving_info = $this->Saving_transaction->get_savings_information($member_id);
			if(!empty($member_saving_info)) {
				foreach( $member_saving_info as $row) {
				$callback_message['saving']['id'][] = $row->savings_id;
				$callback_message['saving']['code'][] = $row->savings_code;
				 $callback_message['product']['mnemonic'][] = $row->product_mnemonic;		
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
	function ajax_for_get_savings_information_by_savings_id() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$saving_id      = $this->input->post('saving_id');
		if(empty($saving_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			$saving_info = $this->Saving_transaction->get_savings_information_by_saving_id($saving_id);
			if(!empty($saving_info)) {
				foreach( $saving_info as $row) {
				$callback_message['saving']['weekly_savings'] = $row->weekly_savings;		
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
	
	function index()
	{
		$data['headline']='Saving Transaction List';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Saving_transaction->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/saving_transactions/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['saving_transactions']=$this->Saving_transaction->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/saving_transactions/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			
			$saving_id = $_POST['cbo_savings'];
			$member_id = $_POST['member_id'];
			//load session data
			$user=$this->session->userdata('system.user');		
			//$data['payment_received_by']=$user['id'];	
			$data['payment_received_by']=1;	
			//$data['transaction_date']=date("Y-m-d");	
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//echo "<pre>";print_r($data);die;
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_transaction->add($data))
				{
					$this->session->set_flashdata('message','Saving Transaction information has been added successfully');
					redirect('/saving_transactions/index/', 'refresh');
				}
			} else {
				
			$is_validate_error = true;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		
		
		if($is_validate_error and isset($saving_id) and !empty($saving_id)){
			$member_id=$this->Saving_transaction->get_member_id_by_saving_id($saving_id);
			//print_r($row);
			$members_info=$this->Saving->get_member_info($member_id[0]->member_id);
			$data['row']->member_id = $members_info[0]->id;
			$data['row']->member_info = $members_info[0]->name.' - '.$members_info[0]->code;
			$data['savings'] = $this->Saving_transaction->get_savings_information($member_id[0]->member_id);
			$data['row']->savings_id = $saving_id;
		} elseif($is_validate_error and isset($member_id) and !empty($member_id)){
			//print_r($row);
			$members_info=$this->Saving->get_member_info($member_id);
			$data['row']->member_id = $members_info[0]->id;
			$data['row']->member_info = $members_info[0]->name.' - '.$members_info[0]->code;
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['headline']='Add Saving Transaction';
		$this->layout->view('/saving_transactions/save',$data);				
	}	
	
	function edit($Saving_transaction_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($Saving_transaction_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Saving Transaction ID is not provided');
			redirect('/saving_transactions/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$Saving_transaction_id=$_POST['saving_transaction_id'];	
			//load session data		
			$user=$this->session->userdata('system.user');					
			$data['updated_by']=$user['id'];		
			$data['updated_on']=date("Y-m-d");
			//Perform the Validation	
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('saving_transaction_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_transaction->edit($data))
				{
					$this->session->set_flashdata('message','Saving Transaction information has been updated successfully');
					//die;
					redirect('/saving_transactions/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Saving_transaction->read($Saving_transaction_id);
		$data['row']=$row[0];
		if(isset($row[0]->savings_id)){
			$member_id=$this->Saving_transaction->get_member_id_by_saving_id($row[0]->savings_id);
			//print_r($row);
			$members_info=$this->Saving->get_member_info($member_id[0]->member_id);
			$data['row']->member_id = $members_info[0]->id;
			$data['row']->member_info = $members_info[0]->name.' - '.$members_info[0]->code;
			$data['savings'] = $this->Saving_transaction->get_savings_information($member_id[0]->member_id);
		}	
		//If data is not posted or validation fails, the add view is displayed
		$data['headline']='Edit Saving Transaction';
		$this->layout->view('/saving_transactions/save',$data);		
	}
	
	function is_delete($Saving_transaction_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($Saving_transaction_id))
		{
			$this->session->set_flashdata('message','Saving Transaction ID is not provided');
			redirect('/saving_transactions/index/', 'refresh');
		}
		else
		{
			$data['is_deleted']='1';
			$data['id']=$Saving_transaction_id;	
			//load session data
			$user=$this->session->userdata('system.user');					
			$data['deleted_by']=$user['id'];		
			$data['delete_date']=date("Y-m-d");							
			//Validation is OK. So, add this data and redirect to the index page
			if($this->Saving_transaction->edit($data))
			{
				$this->session->set_flashdata('message','Saving Transaction information has been updated successfully');
				redirect('/saving_transactions/index/', 'refresh');
			}				
		}	
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['transaction_code']=$this->input->post('txt_transaction_code');
		$data['savings_id']=$this->input->post('cbo_savings');	
		$data['transaction_type']=$this->input->post('cbo_transaction_type');
		$data['transaction_date']=$this->input->post('txt_transaction_date');
		$data['payment_type']=$this->input->post('cbo_payment_type');	
		$data['amount']=$this->input->post('txt_amount');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('member_id','Member Type','trim|xss_clean');
		$this->form_validation->set_rules('cbo_savings','Savings','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_transaction_code','Transaction Code','trim|required|max_length[50]|xss_clean');		
		$this->form_validation->set_rules('cbo_transaction_type','Transaction Type','trim|required|xss_clean');
		$this->form_validation->set_rules('cbo_payment_type','Payment Type','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_amount','Amount','trim|alphanumeric|xss_clean');		
	}
	function _load_combo_data()
	{
		// Loading savings list which will be used in combo box
		$data['savings'] = array();
		// Loading savings list which will be used in combo box
		//$data['members'] = $this->Saving_transaction->get_member_list();	
		// Transaction type list which will be used in combo box
		$data['payments'] = array('CASH'=>'CASH','CHQ'=>'CHQ');
		// Payment type list which will be used in combo box
		$data['transactions'] = array('DEP'=>'Deposit','WIT'=>'Withdraw');
		return $data;
	}
}
