<?php
/** 
	* Loan Transaction transactions Controller Class.
	* @pupose		Manage Loan Transaction information
	*		
	* @filesource	\app\controllers\loan_transactions.php	
	* @package		microfin 
	* @subpackage	microfin.controller.loan_transactions
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Loan_transactions extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
        $this->load->library('Scheduler1');
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Loan_transaction','Loan','Samity'),'',TRUE);
        $current_date=$this->session->userdata('system.software_date');
        $this->output->enable_profiler(TRUE);
	}
		
	function authorization_index()
	{
		$data['headline']='Loan Transaction Authorization';
		$data['title']='Loan Transaction Authorization';
		$cond= "";

		$session_data = $this->session->userdata('loan_transactions.index');
		//print_r($session_data);die;
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];		
			$cond['samity'] = $_POST['cbo_samity'];	
			$cond['to_date'] = $_POST['txt_to_date'];
			$cond['from_date'] = $_POST['txt_from_date'];			
			$sessionArray = array( 'loan_transactions.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity'],'txt_to_date'=>$cond['to_date'],'txt_from_date'=>$cond['from_date']));			
			$this->session->unset_userdata('loan_transactions.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];	
			$cond['to_date'] =$session_data['txt_to_date'];	
			$cond['from_date'] = $session_data['txt_from_date'];		
		} else {
			$this->session->unset_userdata('loan_transactions.index');
		} 
		if(isset($_POST['loantransactionsdata']))
		{
			//echo "<pre>";print_r($_POST['loantransactionsdata']);die;
			$user=$this->session->userdata('system.user');
			$i=1;
			if($this->input->post('submit_1'))
			{				
				foreach($_POST['loantransactionsdata'] as $row)
				{				
					if(!empty($row['is_authorized']))
					{
						$data['loan_transactions'][$i]['id']=$row['id'];							
						$data['loan_transactions'][$i]['is_authorized']=$row['is_authorized'];
						$data['loan_transactions'][$i]['authorized_by']=$user['id'];	
						$data['loan_transactions'][$i]['authorization_date']=date('Y-m-d');	
						$i++;
					}										
				}				
			}
			else
			{				
				foreach($_POST['loantransactionsdata'] as $row)
				{				
					$data['loan_transactions'][$i]['id']=$row['id'];	
					$data['loan_transactions'][$i]['is_authorized']=1;							
					$data['loan_transactions'][$i]['authorized_by']=$user['id'];	
					$data['loan_transactions'][$i]['authorization_date']=date('Y-m-d');	
					$i++;					
				}
			}
			//echo "<pre>";print_r($data['saving_deposit']);die;
			if($this->Loan_transaction->authorized($data['loan_transactions']))
			{
				$this->session->set_flashdata('message','Loan Transactions Information has been authorized successfully');
				redirect('/loan_transactions/authorization_index/');
			}
		}
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan_transaction->get_unauthorized_loan_transaction_list_row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/loan_transactions/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list();	
		
		//Loading data by model function call
		$data['loan_transactions']=$this->Loan_transaction->get_unauthorized_loan_transaction_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/loan_transactions/authorization_index',$data);
	}
	
	function index()
	{
		$data['headline']='Loan Transactions';
		$data['title']='Loan Transaction';
		$cond= "";

		$session_data = $this->session->userdata('loan_transactions.index');
		//print_r($session_data);die;
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];		
			$cond['samity'] = $_POST['cbo_samity'];	
			$cond['to_date'] = $_POST['txt_to_date'];
			$cond['from_date'] = $_POST['txt_from_date'];			
			$sessionArray = array( 'loan_transactions.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity'],'txt_to_date'=>$cond['to_date'],'txt_from_date'=>$cond['from_date']));			
			$this->session->unset_userdata('loan_transactions.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];	
			$cond['to_date'] =$session_data['txt_to_date'];	
			$cond['from_date'] = $session_data['txt_from_date'];		
		} else {
			$this->session->unset_userdata('loan_transactions.index');
		} 
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan_transaction->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/loan_transactions/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list();	
		
		//Loading data by model function call
		$data['loan_transactions']=$this->Loan_transaction->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        //echo "<pre>";print_r($data['loan_transactions']);die;
        /*
         * TO DO
         * Matin
        //Start of Due and Advance calculation
        if(!empty ($data['loan_transactions']))
        { $counter=0;
            foreach ($data['loan_transactions'] as $transaction_data)
            { 
                if(isset ($transaction_data->id) and !empty ($transaction_data->id) and isset ($transaction_data->transaction_date) and !empty ($transaction_data->transaction_date))
                {
                    $schedule_info = $this->scheduler1->get_loan_transaction_amount($transaction_data->id,$transaction_data->transaction_date);
                    $payable_amount = ($schedule_info['principal_installment_amount']+$schedule_info['interest_installment_amount'])*$schedule_info['installment_no'];
                    $advance_or_due = $payable_amount - $transaction_data->current_total_collection_amount;
                    if((int) $advance_or_due == 0)
                    {
                        $data['due_register'][$transaction_data->id] = $advance_or_due;
                        $data['advance_register'][$transaction_data->id] = $advance_or_due;
                    }
                    if((int) $advance_or_due > 0)
                    {
                        $data['due_register'][$transaction_data->id] = $advance_or_due;
                    }
                    if((int) $advance_or_due < 0)
                    {
                        $data['advance_register'][$transaction_data->id] = $advance_or_due;
                    }
                    //echo "<pre>";print_r($data['due_register']);die;
                }
            }
            
        }
        //End of Due and Advance calculation
        */
		$this->layout->view('/loan_transactions/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			$loan_id = $this->input->post('cbo_loan_id');
			$member_id = $this->input->post('member_id');
            $branch_id = $this->input->post('branch_id');
            $samity_id = $this->input->post('samity_id');
            $product_id = $this->input->post('product_id');
			$transaction_date = $this->input->post('txt_transaction_date');
			//$user=$this->session->userdata('system.user');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				$user=$this->session->userdata('system.user');
                $data['entry_by'] = $user['id'];
                $data['entry_date'] = date("Y-m-d");	
				if($this->Loan_transaction->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/loan_transactions/index/', 'refresh');
				}
			} else {
				$is_validate_error = true;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		
		if($is_validate_error and isset($loan_id) and is_numeric($loan_id)){
			$member_id=$this->Loan_transaction->get_member_id_by_loan_id($loan_id);
			if(isset($member_id[0]->member_id) and is_numeric($member_id[0]->member_id)){
				$members_info=$this->Loan->get_member_info($member_id[0]->member_id);				
				$data['row']->member_id = $members_info->id;
				$data['row']->member_info = $members_info->name.' - '.$members_info->code;
                $data['row']->branch_id = $branch_id;
                $data['row']->samity_id = $samity_id;
                $data['row']->product_id = $product_id;
                $data['row']->transaction_date = $transaction_date;
				$data['loans'] = $this->Loan_transaction->get_loan_information($member_id[0]->member_id);
			}
			$data['row']->loan_id = $loan_id;
			
		} elseif($is_validate_error and isset($member_id) and is_numeric($member_id)){
			//print_r($row);
			$members_info=$this->Loan->get_member_info($member_id);
			$data['row']->member_id = $members_info->id;
			$data['row']->member_info = $members_info->name.' - '.$members_info->code;
            $data['row']->branch_id = $branch_id;
            $data['row']->samity_id = $samity_id;
            $data['row']->product_id = $product_id;
            $data['row']->transaction_date = $transaction_date;
			$data['loans'] = $this->Loan_transaction->get_loan_information($members_info->id);
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Loan Transaction';
        $data['headline'] = 'Add New';
		$this->layout->view('/loan_transactions/save',$data);				
	}	
	
	function edit($loan_transaction_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($loan_transaction_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Loan Transaction ID is not provided');
			redirect('/loan_transactions/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$loan_transaction_id=$_POST['loan_transaction_id'];			
			//Perform the Validation	
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('loan_transaction_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Loan_transaction->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/loan_transactions/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Loan_transaction->read($loan_transaction_id);
		$data['row']=$row[0];
		if(isset($row[0]->loan_id)){
			$member_id=$this->Loan_transaction->get_member_id_by_loan_id($row[0]->loan_id);
			$members_info=$this->Loan->get_member_info($member_id[0]->member_id);
			$data['row']->member_id = $members_info->id;
			$data['row']->member_info = $members_info->name.' - '.$members_info->code;
			$data['loans'] = $this->Loan_transaction->get_loan_information($member_id[0]->member_id);
		}	
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Loan Transaction';
        $data['headline'] = 'Edit';
		$this->layout->view('/loan_transactions/save',$data);		
	}
	
	function delete($loan_transaction_id=null)
	{			
		//If ID is not provided, redirecting to index page
		if(empty($loan_transaction_id))
		{
			$this->session->set_flashdata('warning','Loan Transaction ID is not provided');
			redirect('/loan_transactions/index/', 'refresh');
		}
		else
		{	
			if($this->Loan_transaction->delete($loan_transaction_id))
			{
				$this->session->set_flashdata('message',DELETE_MESSAGE);
				redirect('/loan_transactions/index/', 'refresh');
			}				
		}	
	}
	
	function _get_posted_data()
	{
		$data=array();		
		$data['loan_id']=$this->input->post('cbo_loan_id');
		$data['branch_id']=$this->input->post('branch_id');
		$data['samity_id']=$this->input->post('samity_id');		
		$data['product_id']=$this->input->post('product_id');	
		$data['is_authorized']=0;	
		$data['transaction_date']=$this->input->post('txt_transaction_date');	
		$data['transaction_amount']=$this->input->post('txt_amount');
		$data['installment_number']=$this->input->post('txt_installment_number');		
		return $data;
	}
	
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('member_id','Member','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_loan_id','Loan','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_transaction_date','Date','trim|required|xss_clean|is_date|callback_check_schedule_date');
		$this->form_validation->set_rules('txt_installment_number','Installment Number','trim|required|xss_clean|integer');
		$this->form_validation->set_rules('txt_amount','Amount','trim|numeric|xss_clean|required');
	}
	
	function _load_combo_data()
	{		
	//	$data['payment_types'] = array('SOFT'=>'SOFT','ATM'=>'ATM','MOB'=>'MOB','SOFT'=>'SOFT');	
		$data['loans'] = array();	
		return $data;
	}
	
	function check_schedule_date()
	{
		// first_schedule_date
		$loan_id=$this->input->post('cbo_loan_id');
        if(!empty ($loan_id))
        {
            $installment_number=$this->input->post('txt_installment_number');
            $transaction_date=$this->input->post('txt_transaction_date');
            if($installment_number==1)
            {
                $first_schedule_date = $this->Loan_transaction->get_first_schedule_date($loan_id);
                if($first_schedule_date>$transaction_date) {
                    $this->form_validation->set_message('check_schedule_date', "Transaction date must be greater then first schedule date.");
                        return FALSE;
                }
            }
            else
            {
                $last_transaction_date = $this->Loan_transaction->get_last_transaction_date($loan_id);
                if($last_transaction_date>$transaction_date) {
                    $this->form_validation->set_message('check_schedule_date', "Transaction date must be greater then last transaction date.");
                        return FALSE;
                }
            }
        }
	}
		
	/**
    * @use loan_transactions(save)
    */	
	function ajax_for_get_loan_information() {
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
			$member_loan_info = $this->Loan_transaction->get_loan_information($member_id);
			if(!empty($member_loan_info)) {
				foreach( $member_loan_info as $row) {
				$callback_message['loan']['id'][] = $row->loan_id;
				$callback_message['loan']['code'][] = $row->loan_code;
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

	function ajax_for_get_loan_information_by_loan_id() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$loan_id = $this->input->post('loan_id');
		if(empty($loan_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			$loan_info = $this->Loan_transaction->get_loan_information_by_loan_id($loan_id);
            $current_date=$this->session->userdata('system.software_date');
            $system_date = date('Y-m-d',strtotime( $current_date['current_date']));
            //echo $tes;
			$schedule_info = $this->scheduler1->get_loan_transaction_amount($loan_id,$system_date);
            if(!empty ($schedule_info))
            {
                $installment_amount = $schedule_info['principal_installment_amount'] + $schedule_info['interest_installment_amount'];
            }
            //print_r();die;
			if(!empty($loan_info)) {
				foreach( $loan_info as $row) {									
					$callback_message['loan_schedules']['installment_number'] = $row->installment_number;
					$callback_message['loan_schedules']['installment_amount'] = $installment_amount;
					$callback_message['loan']['product_id'] = $row->product_id;									
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
