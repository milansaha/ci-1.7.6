<?php
/** 
	* Saving_withdraws Controller Class.
	* @pupose		Manage saving_withdraws information
	*		
	* @filesource	\app\controllers\saving_withdraws.php	
	* @package		microfin 
	* @subpackage	microfin.controller.saving_withdraws
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Saving_withdraws extends MY_Controller {
	
	function Saving_withdraws()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Saving_withdraw','Samity','Member','Saving','Saving_deposit'),'',TRUE);
	}

	function authorization_index()
	{
		$cond= "";
		$session_data = $this->session->userdata('saving_withdraws.index');
	
		if(isset($_POST['cbo_samity'])){
			$cond['samity'] = $_POST['cbo_samity'];	
			$sessionArray = array('saving_withdraws.authorization_index'=>array('cbo_samity'=>$cond['samity']));			
			$this->session->unset_userdata('saving_withdraws.authorization_index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['samity'] = $session_data['cbo_samity'];					
		} else {
			$this->session->unset_userdata('saving_withdraws.authorization_index');
		} 
		
		if(isset($_POST['savingwithdrawsdata']))
		{
			//echo "<pre>";print_r($_POST['loandata']);die;
			$user=$this->session->userdata('system.user');
			$i=1;
			if($this->input->post('submit_1'))
			{				
				foreach($_POST['savingwithdrawsdata'] as $row)
				{				
					if(!empty($row['is_authorized']))
					{
						$data['saving_withdraws'][$i]['id']=$row['id'];	
						$data['saving_withdraws'][$i]['is_authorized']=0;
						$data['saving_withdraws'][$i]['is_authorized']=$row['is_authorized'];
						$data['saving_withdraws'][$i]['authorized_by']=$user['id'];	
						$data['saving_withdraws'][$i]['authorization_date']=date('Y-m-d');	
						$i++;
					}										
				}				
			}
			else
			{				
				foreach($_POST['savingwithdrawsdata'] as $row)
				{				
					$data['saving_withdraws'][$i]['id']=$row['id'];	
					$data['saving_withdraws'][$i]['is_authorized']=1;							
					$data['saving_withdraws'][$i]['authorized_by']=$user['id'];	
					$data['saving_withdraws'][$i]['authorization_date']=date('Y-m-d');	
					$i++;					
				}
			}
			//echo "<pre>";print_r($data['saving_withdraws']);die;
			if($this->Saving_withdraw->authorized($data['saving_withdraws']))
			{
				$this->session->set_flashdata('message','Savings Withdraw Information has been authorized successfully');
				redirect('/saving_withdraws/authorization_index/');
			}
		}
		$data['title']='Savings Withdraw Authorization';	
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Saving_withdraw->get_unauthorized_saving_withdraws_list_row_count($cond);		

		//Initializing Pagination
		$config['base_url'] = site_url('/saving_withdraws/authorization_index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);			
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());
		//Loading data by model function call
		$data['saving_withdraws']=$this->Saving_withdraw->get_unauthorized_saving_withdraws_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		$data['counter'] = (int)$this->uri->segment(3);
		// Loading samity list which will be used in combo box	
				
		$this->layout->view('/saving_withdraws/authorization_index',$data);
	}
	
	function index()
	{
		$cond= "";
		$session_data = $this->session->userdata('saving_withdraws.index');
		//print_r($session_data);die;
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];		
			$cond['samity'] = $_POST['cbo_samity'];				
			$cond['transaction_date'] = $this->input->post('txt_transaction_date');						
			$sessionArray = array( 'saving_withdraws.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity'],'txt_transaction_date'=>$cond['transaction_date']));		
			$this->session->unset_userdata('saving_withdraws.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];	
			$cond['transaction_date'] = $session_data['txt_transaction_date'];				
		} else {
			$this->session->unset_userdata('saving_withdraws.index');
		}

		// load pagination class
		$this->load->library('pagination');
		$total = $this->Saving_withdraw->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/saving_withdraws/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());			
		//$data['transactions'] = array('WIT'=>'Withdraw','Adj'=>'Adjust');

		//Loading data by model function call
		$data['saving_withdraws']=$this->Saving_withdraw->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
        $data['title']='Savings Withdraw';
        $data['headline']='Savings Withdraw';
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/saving_withdraws/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			$cbo_savings_code = $this->input->post('cbo_savings_code');
			//load session data
			$user=$this->session->userdata('system.user');		
			$data['payment_received_by']=$user['id'];		
			//$data['created_on']=date("Y-m-d");	
			//Perform the Validation
			//print_r($_POST);
			
			//echo "<pre>";print_r($data);die;
			if ($this->form_validation->run() === TRUE)
			{
				//echo "<pre>";print_r($data);die;
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_withdraw->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/saving_withdraws/index/', 'refresh');
				}
			} else {
				$is_validate_error = TRUE;                
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		if($is_validate_error and isset($member_id) and !empty($member_id)){
			$member_info=$this->Saving->get_member_info($member_id);
			$data['row']->member_id = $member_info[0]->id;
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$data['row']->branch_id = isset($branch_id)?$branch_id:"";
			$data['row']->samity_id = isset($samity_id)?$samity_id:"";
			$data['row']->savings_id = isset($cbo_savings_code)?$cbo_savings_code:"";
			$data['row']->mode_of_payment=isset($cbo_payment_type)?$cbo_payment_type:"";			
		}
		$data['title']='Add Savings Withdraw';
        $data['headline']='Add New';
		$this->layout->view('/saving_withdraws/save',$data);				
	}	
	
	function edit($saving_id=null)
	{	
		$is_validate_error = false;
		//If ID is not provided, redirecting to index page
		if(empty($saving_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Savings withdraw ID is not provided');
			redirect('/saving_withdraws/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		//echo "<pre>";print_r($_POST);die;
		if($_POST)
		{
			$saving_id=$this->input->post('saving_id'); 
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			$cbo_savings_code = $this->input->post('cbo_savings_code');
			//load session data		
			$user=$this->session->userdata('system.user');					
			$data['updated_by']=$user['id'];		
			$data['updated_on']=date("Y-m-d");
			//Perform the Validation	
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('saving_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving_withdraw->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/saving_withdraws/index/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Saving_withdraw->read($saving_id);
		$data['row']=$row[0];
		if(isset($row[0]->member_id)){
			$member_info=$this->Saving_withdraw->get_member_info($row[0]->member_id);
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
		}
		elseif($is_validate_error and isset($member_id) and !empty($member_id)){
			//$member_info=$this->Saving_withdraw->get_member_info($row[0]->member_id);
			//$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$member_info=$this->Saving_withdraw->get_member_info($member_id);
			$data['row']->member_id = $member_info[0]->id;
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$data['row']->branch_id = isset($branch_id)?$branch_id:"";
			$data['row']->samity_id = isset($samity_id)?$samity_id:"";
			$data['row']->savings_id = isset($cbo_savings_code)?$cbo_savings_code:"";
			$data['row']->mode_of_payment=isset($cbo_payment_type)?$cbo_payment_type:"";			
		}	
		$data['savings_code'] = $this->Saving->get_member_savings_code_list($row[0]->member_id);
		$data['payments'] = array('CASH'=>'CASH','CHQ'=>'CHQ');
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Savings Withdraw';
        $data['headline']='Edit';
		$this->layout->view('/saving_withdraws/save',$data);		
	}
	
	function delete($saving_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($saving_id))
		{
			$this->session->set_flashdata('warning','Savings withdraw ID is not provided');
			redirect('/saving_withdraws/index/');
		}
		else
		{			
			if($this->Saving_withdraw->delete($saving_id))
			{
				$this->session->set_flashdata('message',DELETE_MESSAGE);
				redirect('/saving_withdraws/index/');
			}
									
		}	
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['branch_id']=$this->input->post('branch_id');
		$data['samity_id']=$this->input->post('samity_id');
		$data['member_id']=$this->input->post('member_id');
		$data['member_primary_product_id']=$this->input->post('member_primary_product_id');
		$data['savings_id']=$this->input->post('cbo_savings_code');
		$data['saving_products_id']=$this->input->post('saving_products_id');	
		$data['transaction_type']='WIT';
		$data['mode_of_payment']=$this->input->post('cbo_payment_type');
		$data['transaction_date']=$this->input->post('txt_transaction_date');
		$data['amount']=$this->input->post('txt_amount');
		// current_status default 1
		//$data['current_status'] = 1;		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		//$this->form_validation->set_rules('txt_code','Code','trim|required|max_length[200]|xss_clean|callback_check_code');		
		$this->form_validation->set_rules('member_id','Memebr','trim|required|xss_clean');
		$this->form_validation->set_rules('cbo_savings_code','Savings code','trim|required|xss_clean');	
		$this->form_validation->set_rules('cbo_payment_type','Payment Type','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_transaction_date','Transaction Date','trim|max_length[10]|xss_clean|required|callback_check_transaction_date');		
		$this->form_validation->set_rules('txt_amount','Amount','trim|numeric|required|xss_clean|callback_check_amount');		
	}
	function _load_combo_data()
	{	
		// Loading products list which will be used in combo box
		$data['savings_code'] = $this->Saving->get_member_savings_code_list($this->input->post('member_id'));
		// Transaction type list which will be used in combo box
		$data['payments'] = array('CASH'=>'CASH','CHQ'=>'CHQ');
		// Payment type list which will be used in combo box
		//$data['transactions'] = array('WIT'=>'Withdraw','Adj'=>'Adjust');
		return $data;
	}
	/**
	 * Get saving_withdraws product list where member currently not loned.
	 *  @use saving_withdraws(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 20-Feb-2011
	*/
	function ajax_for_get_saving_withdraws_product_list_by_member() {
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
			$product_info = $this->Saving_withdraw->get_products_list($member_id);			
			if(!empty($product_info)) {
				foreach( $product_info as $row) {
				$callback_message['product']['id'][] = $row->id;
				$callback_message['product']['name'][] = $row->name;		
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
	 * @name check_opening_date
	 * @uses saving_withdraws(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 20-Feb-2011
	 */
	function check_transaction_date()
	{
		// check_transaction_date
		$transaction_date=$this->input->post('txt_transaction_date');
		$member_id=$this->input->post('member_id');
		$product_id=$this->input->post('cbo_product');
		if(!empty($member_id) && !empty($product_id))
		{
			$savings_opening_date = $this->Saving->get_savings_opening_date($this->input->post('member_id'),$this->input->post('cbo_product'));		
			if($savings_opening_date>$transaction_date) {
				$this->form_validation->set_message('check_transaction_date', "Transaction date must be greater than savings opening date.");
				    return FALSE;
			}	
		}	
		return TRUE;
	}	
	/**
	 * @name check_amount
	 * @uses saving_withdraws(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 20-Feb-2011
	 */
	function check_amount()
	{
		// check_transaction_date
		$amount=$this->input->post('txt_amount');			
		if(!empty($amount))
		{
			$savings_amount = $this->Saving_deposit->get_available_savings_amount($this->input->post('member_id'));				
			if($savings_amount<$amount) {
				$this->form_validation->set_message('check_amount', "Withdraw amount must be lower than savings deposit amount.");
				    return FALSE;
			}	
		}	
		return TRUE;
	}
}
