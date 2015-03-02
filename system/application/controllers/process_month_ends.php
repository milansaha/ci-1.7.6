<?php

class Process_month_ends extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Process_month_end','Report_loan_data','Process_day_end','Report'),'',TRUE);	
		$this->Process_month_end->loan_base_class = $this->Report_loan_data;	
		
		$this->load->library('Scheduler1',null,"scheduler");
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index()
	{
		$data = $this->_load_combo_data();
		$data['title']='Month End Process';
		//
		$cond= "";
		$session_data = $this->session->userdata('process_month_ends.index');
		if($_POST){
			//print_r($_POST);
            $cond['cbo_year'] = $this->input->post('cbo_year');

			$sessionArray = array( 'process_month_ends.index'=>array(
                                        'cbo_year'=>$cond['cbo_year']));

            $this->session->unset_userdata('process_month_ends.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['cbo_year'] = $session_data['cbo_year'];

		} else {
			$this->session->unset_userdata('process_month_ends.index');
		}
		/* End of filtering conditions */	
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Process_month_end->row_count($this->get_branch_id(),$cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/process_month_ends/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['month_end_process']=$this->Process_month_end->get_list($this->get_branch_id(),ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['day_end_valid_deletable_date']=$this->Process_month_end->get_day_end_valid_deletable_date($this->get_branch_id());		
		$data['counter'] = (int)$this->uri->segment(3);
		if($_POST){
			$this->load->view('/process_month_ends/execute',$data);
		} else {
			$this->layout->view('/process_month_ends/index',$data);
		}
	}
	//Combo Data Generation
	function _load_combo_data()
	{		
		$data['year_info'] = $this->Report->get_year_range();		
		return $data;
	}
	function is_day_end_completed($branch_id){
		$last_day_end_date = $this->__get_last_day_end_date($branch_id);
		$new_day_end_date =  $this->Process_day_end->get_new_day_end_date($last_day_end_date,$branch_id);
		$last_day_end_month = date('m',strtotime($last_day_end_date));
		$new_day_end_month = date('m',strtotime($new_day_end_date));
		$last_day_end_year = date('yyyy',strtotime($last_day_end_date));
		$new_day_end_year = date('yyyy',strtotime($new_day_end_date));
		return ($last_day_end_month == $new_day_end_month and $last_day_end_year == $new_day_end_year )?false:true;
	}
	function __get_last_day_end_date($branch_id)
	{		
		$last_day_end_date = $this->Process_day_end->get_day_end_last_date($branch_id);
		if(empty($last_day_end_date)) {
			$branch_opening_date = $this->Process_day_end->get_branch_opening_date($branch_id);
			$organization_established_date = $this->Process_day_end->get_software_start_date();
			$date_diff = strtotime($organization_established_date) - strtotime($branch_opening_date);
			$last_day_end_date = ($date_diff > 0)?$organization_established_date:$branch_opening_date;
		}
		return $last_day_end_date;
	}
		function ajax_execute()
		{
			//sleep(5);
			$this->output->enable_profiler(FALSE);			
			$branch_id = $this->get_branch_id();
			$is_day_end_complete = false;
			$is_day_end_complete = $this->is_day_end_completed($branch_id);
			// 
			if($is_day_end_complete){
				$data=$this->_get_month_end_data($branch_id);
				//echo '<pre>';
					//print_r($data);
				$this->Process_month_end->execute_month_end($branch_id,$data);
				if(!empty($data['savings_interest'])) {
					$this->Process_month_end->execute_savings_interest_process($data['savings_interest']);
				}
				//$pomis['savings_interest']
			} else {
				echo "<div class='error'>Some day end processes are pending...</div>";
			}
			// load pagination class
			
			//
		$cond= "";
		$session_data = $this->session->userdata('process_month_ends.index');
		if($_POST){
			//print_r($_POST);
            $cond['cbo_year'] = $this->input->post('cbo_year');

			$sessionArray = array( 'process_month_ends.index'=>array(
                                        'cbo_year'=>$cond['cbo_year']));

            $this->session->unset_userdata('process_month_ends.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['cbo_year'] = $session_data['cbo_year'];

		} else {
			$this->session->unset_userdata('process_month_ends.index');
		}
		/* End of filtering conditions */	
			
			$this->load->library('pagination');
			$total = $this->Process_month_end->row_count($branch_id,$cond);
			
			//Initializing Pagination
			$config['base_url'] = site_url('/process_month_ends/index/');
			$config['total_rows'] = $total;
			$config['per_page'] = ROW_PER_PAGE;
			
			$this->pagination->initialize($config);	
			
			//Loading data by model function call
			$data['month_end_process']=$this->Process_month_end->get_list($branch_id,ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
			$data['counter'] = (int)$this->uri->segment(3);
			$this->load->view('/process_month_ends/execute',$data);
		}
	/*
		function lastday($month = '', $year = '') {
		   if (empty($month)) {
		      $month = date('m');
		   }
		   if (empty($year)) {
		      $year = date('Y');
		   }
		   $result = strtotime("{$year}-{$month}-01");
		   $result = strtotime('-1 second', strtotime('+1 month', $result));
		   return date('Y-m-d', $result);
		}
		 */
		function _get_month_end_data($branch_id){
			$max_date = $this->Process_month_end->get_month_end_max_date($branch_id);
			$is_software_1st_month_end = false;
			if(empty($max_date)) {
				$is_software_1st_month_end = true;
			}
			$last_day_end_date = $this->__get_last_day_end_date($branch_id);
			//$new_day_end_date =  $this->get_new_day_end_date($last_day_end_date,$branch_id,'Process_month_end');
			//$max_date = $last_day_end_date;
			//echo "---$max_date----";
			//$next_month = date('Y-m-d',strtotime($max_date."+1 day"));
			$current_month_list = explode('-',$last_day_end_date);
			//
			$to_date = $last_day_end_date;
			$from_date = $current_month_list[0].'-'.$current_month_list[1].'-1';
			
           // echo "$to_date";
           if($is_software_1st_month_end){
           		$pre_month_closing = $this->__pre_month_closing_info($branch_id,$max_date,$is_software_1st_month_end);
			} else {
				
			}            
			$pomis = $this->execute($from_date,$to_date,$branch_id,$is_software_1st_month_end);
		//	echo "<pre>";
		//print_r($pomis);
			//echo '<pre>';
			$i = 0;
			$data['month_end_date'] = $to_date;
			$data['savings_interest'] = $pomis['savings_interest'];
			foreach( $pomis as $po){	
				if(isset($po['product_id'])){
					// Female Member
                   if($is_software_1st_month_end ){
					$f_opening_members = isset($po['F']['opening_member'])?$po['F']['opening_member']:'';
					$opening_deposit_collection = isset($po['F']['opening_deposit_collection'])?$po['F']['opening_deposit_collection']:'';
					$opening_saving_refund = isset($po['F']['opening_saving_refund'])?$po['F']['opening_saving_refund']:'';
					$f_closing_saving_balance  = $opening_saving_refund - $opening_deposit_collection;
					$f_opening_borrower_no	= isset($po['F']['opening_borrower_no'])?$po['F']['opening_borrower_no']:'';
					
					$opening_principal_recoverable_amount = isset($po['F']['opening_principal_recoverable_amount'])?$po['F']['opening_principal_recoverable_amount']:'';
					$opening_interest_recoverable_amount = isset($po['F']['opening_interest_recoverable_amount'])?$po['F']['opening_interest_recoverable_amount']:'';
					
					$opening_principal_recovery_amount = isset($po['F']['opening_principal_recovery_amount'])?$po['F']['opening_principal_recovery_amount']:'';
					$opening_interest_recovery_amount = isset($po['F']['opening_interest_recovery_amount'])?$po['F']['opening_interest_recovery_amount']:'';
					
					$f_opening_outstanding_amount	= $opening_principal_recoverable_amount - $opening_principal_recovery_amount;
					$f_opening_outstanding_amount_with_services_charge	= $f_opening_outstanding_amount + ($opening_interest_recoverable_amount - $opening_interest_recovery_amount);
					
					$opening_principal_advance_amount = isset($po['F']['opening_principal_advance_amount'])?$po['F']['opening_principal_advance_amount']:'';
					$opening_interest_advance_amount = isset($po['F']['opening_interest_advance_amount'])?$po['F']['opening_interest_advance_amount']:'';
					
					$opening_principal_due_amount = isset($po['F']['opening_principal_due_amount'])?$po['F']['opening_principal_due_amount']:'';
					$opening_interest_due_amount = isset($po['F']['opening_interest_due_amount'])?$po['F']['opening_interest_due_amount']:'';
					// current regular = current recovery - (current due - current adavance) 
					$principal_current_regular = $opening_principal_recovery_amount - $opening_principal_advance_amount - $opening_principal_due_amount;
					$interest_current_regular = $opening_interest_recovery_amount - $opening_interest_advance_amount - $opening_interest_due_amount;
					// new due = current recoveable - current regular collection
					$principal_new_due = $opening_principal_recoverable_amount - $principal_current_regular;
					$interest_new_due = $opening_interest_recovery_amount - $interest_current_regular;
					
					$f_pre_month_closing_due_amount = $principal_new_due;
					$f_pre_month_closing_due_amount_with_services_charge = $principal_new_due + $interest_new_due;
					
				   } else {
					$f_opening_members = isset($pre_month_closing['member'][$po['product_id']]['F']['closing_member'])?$pre_month_closing['member'][$po['product_id']]['F']['closing_member']:'';
					$f_closing_saving_balance  = isset($pre_month_closing['saving'][$po['product_id']]['F']['closing_balance'])?$pre_month_closing['saving'][$po['product_id']]['F']['closing_balance']:'';
					$f_opening_borrower_no	= isset($pre_month_closing['loan'][$po['product_id']]['F']['closing_borrower_no'])?$pre_month_closing['loan'][$po['product_id']]['F']['closing_borrower_no']:'';
					$f_opening_outstanding_amount	= isset($pre_month_closing['loan'][$po['product_id']]['F']['closing_outstanding_amount'])?$pre_month_closing['loan'][$po['product_id']]['F']['closing_outstanding_amount']:'';
					$f_opening_outstanding_amount_with_services_charge	= isset($pre_month_closing['loan'][$po['product_id']]['F']['closing_outstanding_amount_with_services_charge'])?$pre_month_closing['loan'][$po['product_id']]['F']['closing_outstanding_amount_with_services_charge']:'';
					$f_pre_month_closing_due_amount = isset($pre_month_closing['loan'][$po['product_id']]['F']['closing_due_amount'])?$pre_month_closing['loan'][$po['product_id']]['F']['closing_due_amount']:'';
					$f_pre_month_closing_due_amount_with_services_charge = isset($pre_month_closing['loan'][$po['product_id']]['F']['closing_due_amount_with_services_charge'])?$pre_month_closing['loan'][$po['product_id']]['F']['closing_due_amount_with_services_charge']:'';
				}
					
					//echo $f_opening_members.'<br>';
					$data['member'][$i]['date'] = $to_date;
					$data['member'][$i]['branch_id'] =$branch_id;
					$data['member'][$i]['product_id'] = $po['product_id'];
					$data['member'][$i]['type'] = 'F';
					$data['member'][$i]['opening_member'] = $f_opening_members;
					$data['member'][$i]['branch_no'] = $po['branch_no'];
					$data['member'][$i]['samity_no'] = $po['F']['samity_no'];
					$data['member'][$i]['new_member_admission_no'] = $po['F']['new_member_admission_no'];
					$data['member'][$i]['member_cancellation_no'] = $po['F']['member_cancellation_no'];
					$data['member'][$i]['avg_savings_depositor'] = $po['avg_savings_depositor'];
					$data['member'][$i]['avg_attendance'] = $po['avg_attendance'];
					$data['member'][$i]['closing_member'] = $f_opening_members + $po['F']['new_member_admission_no'] - $po['F']['member_cancellation_no'];
					// Female Saving
					$data['saving'][$i]['date'] = $to_date;
					$data['saving'][$i]['branch_id'] =$branch_id;
					$data['saving'][$i]['product_id'] = $po['product_id'];
					$data['saving'][$i]['type'] = 'F';
					$data['saving'][$i]['opening_balance'] = $f_closing_saving_balance ;
					$data['saving'][$i]['deposit_collection'] = $po['F']['deposit_collection'];
					$data['saving'][$i]['saving_refund'] = $po['F']['saving_refund'];
					$data['saving'][$i]['closing_balance'] = $f_closing_saving_balance + $po['F']['deposit_collection'] - $po['F']['saving_refund'];
					// Female Loan
					$data['loan'][$i]['date'] = $to_date;
					$data['loan'][$i]['branch_id'] =$branch_id;
					$data['loan'][$i]['product_id'] = $po['product_id'];
					$data['loan'][$i]['type'] = 'F';
					//
					// pomis 2.1
					$data['loan'][$i]['opening_borrower_no'] = 	$f_opening_borrower_no;
					$data['loan'][$i]['opening_outstanding_amount'] = $data['loan'][$i]['opening_borrower_no'] + $f_opening_outstanding_amount;
					$data['loan'][$i]['opening_outstanding_amount_with_services_charge'] = $f_opening_outstanding_amount_with_services_charge;			
					$data['loan'][$i]['borrower_no'] = $po['F']['borrower_no'];
					$data['loan'][$i]['disbursed_amount'] = $po['F']['disbursed_amount'];
					$data['loan'][$i]['principal_recovery_amount'] = $po['F']['principal_recovery_amount'];
					$data['loan'][$i]['interest_recovery_amount'] = $po['F']['interest_recovery_amount'];
					$data['loan'][$i]['fully_paid_borrower_no'] = $po['F']['fully_paid_borrower_no'];
					$data['loan'][$i]['closing_borrower_no'] = $f_opening_borrower_no + $po['F']['borrower_no'] - $po['F']['fully_paid_borrower_no'];
					//todo
					$data['loan'][$i]['closing_outstanding_amount'] = $f_opening_outstanding_amount + $po['F']['disbursed_amount'] - ($po['F']['principal_recovery_amount']);
					//
					$total_interest_amount = 0;
					$data['loan'][$i]['closing_outstanding_amount_with_services_charge'] =$data['loan'][$i]['closing_outstanding_amount'] +  $f_opening_outstanding_amount_with_services_charge + $total_interest_amount - ($po['F']['interest_recovery_amount']);
					//
					// pomis 2.2
					// opening data will get from previous month TODO
					//$data['loan'][$i]['opening_due_amount'] = $pre_month_closing_due_amount;
					$data['loan'][$i]['closing_due_amount'] = $f_pre_month_closing_due_amount;
					$data['loan'][$i]['closing_due_amount_with_services_charge'] = $data['loan'][$i]['closing_due_amount'] + $f_pre_month_closing_due_amount_with_services_charge;
					$data['loan'][$i]['principal_recoverable_amount'] = $po['F']['principal_recoverable_amount'];
					$data['loan'][$i]['interest_recoverable_amount'] = $po['F']['interest_recoverable_amount'];
					$data['loan'][$i]['principal_advance_amount'] = $po['F']['principal_advance_amount'];
					$data['loan'][$i]['interest_advance_amount'] = $po['F']['interest_advance_amount'];
					$data['loan'][$i]['principal_due_amount'] = $po['F']['principal_due_amount'];
					$data['loan'][$i]['interest_due_amount'] = $po['F']['interest_due_amount'];
					// current regular = current recovery - (current due - current adavance) 
					$current_regular = $po['F']['principal_recovery_amount'] - ($po['F']['principal_due_amount'] + $po['F']['principal_advance_amount']);
					// new due = current recoveable - current regular collection
					$interest_current_regular = $po['F']['interest_recovery_amount'] - ($po['F']['interest_due_amount'] + $po['F']['interest_advance_amount']);
					// new due = current recoveable - current regular collection
					$new_due = $po['F']['principal_recoverable_amount'] - $current_regular;
					$interest_new_due = $po['F']['interest_recoverable_amount'] - $interest_current_regular;
					// total due = opeing due - (new due  +  current due)
					$data['loan'][$i]['closing_due_amount'] = $f_pre_month_closing_due_amount - $new_due + $po['F']['principal_due_amount'];
					$data['loan'][$i]['closing_due_amount_with_services_charge'] = $data['loan'][$i]['closing_due_amount'] + $f_pre_month_closing_due_amount_with_services_charge - $interest_new_due + $po['F']['interest_due_amount'];
					//
					// POMIS 3.1
					$data['loan'][$i]['substandard_outstanding'] = $po['F']['substandard_outstanding'];		
					$data['loan'][$i]['substandard_outstanding_with_services_charge'] = $po['F']['substandard_outstanding_with_services_charge'];
					$data['loan'][$i]['substandard_overdue'] = $po['F']['substandard_overdue'];
					$data['loan'][$i]['substandard_overdue_with_services_charge'] = $po['F']['substandard_overdue_with_services_charge'];
					$data['loan'][$i]['doubtfull_outstanding'] = $po['F']['doubtfull_outstanding'];
					$data['loan'][$i]['doubtfull_outstanding_with_services_charge'] = $po['F']['doubtfull_outstanding_with_services_charge'];
					$data['loan'][$i]['doubtfull_overdue'] = $po['F']['doubtfull_overdue'];
					$data['loan'][$i]['doubtfull_overdue_with_services_charge'] = $po['F']['doubtfull_overdue_with_services_charge'];
					$data['loan'][$i]['bad_outstanding'] = $po['F']['bad_outstanding'];
					$data['loan'][$i]['bad_outstanding_with_services_charge'] = $po['F']['bad_outstanding_with_services_charge'];
					$data['loan'][$i]['bad_overdue'] = $po['F']['bad_overdue'];
					$data['loan'][$i]['bad_overdue_with_services_charge'] = $po['F']['bad_overdue_with_services_charge'];
					$data['loan'][$i]['no_of_due_loanee'] = $po['F']['no_of_due_loanee'];
					$data['loan'][$i]['saving_balance_of_overdue_loanee'] = $po['F']['saving_balance_of_overdue_loanee'];
					
					//echo $po['F']['saving_balance_of_overdue_loanee']."<br>";
					/***********************Male Part***************************/
					$i++;
					if($is_software_1st_month_end ){
						$m_opening_members = isset($po['M']['opening_member'])?$po['M']['opening_member']:'';
						$opening_deposit_collection = isset($po['M']['opening_deposit_collection'])?$po['M']['opening_deposit_collection']:'';
						$opening_saving_refund = isset($po['M']['opening_saving_refund'])?$po['M']['opening_saving_refund']:'';
						
						$m_closing_saving_balance  = $opening_saving_refund - $opening_deposit_collection;$m_opening_borrower_no	= isset($pre_month_closing['loan'][$po['product_id']]['M']['closing_borrower_no'])?$pre_month_closing['loan'][$po['product_id']]['M']['closing_borrower_no']:'';
						$m_opening_borrower_no	= isset($po['M']['opening_borrower_no'])?$po['M']['opening_borrower_no']:'';
					
						$opening_principal_recoverable_amount = isset($po['M']['opening_principal_recoverable_amount'])?$po['M']['opening_principal_recoverable_amount']:'';
						$opening_interest_recoverable_amount = isset($po['M']['opening_interest_recoverable_amount'])?$po['M']['opening_interest_recoverable_amount']:'';
						$opening_principal_recovery_amount = isset($po['M']['opening_principal_recovery_amount'])?$po['M']['opening_principal_recovery_amount']:'';
						
						$opening_interest_recovery_amount = isset($po['M']['opening_interest_recovery_amount'])?$po['M']['opening_interest_recovery_amount']:'';
						
						$m_opening_outstanding_amount	= $opening_principal_recoverable_amount - $opening_principal_recovery_amount;
						$m_opening_outstanding_amount_with_services_charge	= $m_opening_outstanding_amount + ($opening_interest_recoverable_amount - $opening_interest_recovery_amount);
					
						$opening_principal_advance_amount = isset($po['M']['opening_principal_advance_amount'])?$po['M']['opening_principal_advance_amount']:'';
						$opening_interest_advance_amount = isset($po['M']['opening_interest_advance_amount'])?$po['M']['opening_interest_advance_amount']:'';
						
						$opening_principal_due_amount = isset($po['M']['opening_principal_due_amount'])?$po['M']['opening_principal_due_amount']:'';
						$opening_interest_due_amount = isset($po['M']['opening_interest_due_amount'])?$po['M']['opening_interest_due_amount']:'';
						// current regular = current recovery - (current due - current adavance) 
						$principal_current_regular = $opening_principal_recovery_amount - $opening_principal_advance_amount - $opening_principal_due_amount;
						$interest_current_regular = $opening_interest_recovery_amount - $opening_interest_advance_amount - $opening_interest_due_amount;
						// new due = current recoveable - current regular collection
						$principal_new_due = $opening_principal_recoverable_amount - $principal_current_regular;
						$interest_new_due = $opening_interest_recovery_amount - $interest_current_regular;
						
						$m_pre_month_closing_due_amount = $principal_new_due;
						$m_pre_month_closing_due_amount_with_services_charge = $principal_new_due + $interest_new_due;
						
					} else {
						$m_opening_members = isset($pre_month_closing['member'][$po['product_id']]['M']['closing_member'])?$pre_month_closing['member'][$po['product_id']]['M']['closing_member']:'';
						$m_closing_saving_balance  = isset($pre_month_closing['saving'][$po['product_id']]['M']['closing_balance'])?$pre_month_closing['saving'][$po['product_id']]['M']['closing_balance']:'';
						$m_opening_borrower_no	= isset($pre_month_closing['loan'][$po['product_id']]['M']['closing_borrower_no'])?$pre_month_closing['loan'][$po['product_id']]['M']['closing_borrower_no']:'';
						$m_opening_outstanding_amount	= isset($pre_month_closing['loan'][$po['product_id']]['M']['closing_outstanding_amount'])?$pre_month_closing['loan'][$po['product_id']]['M']['closing_outstanding_amount']:'';
						$m_opening_outstanding_amount_with_services_charge	= $m_opening_outstanding_amount + isset($pre_month_closing['loan'][$po['product_id']]['M']['closing_outstanding_amount_with_services_charge'])?$pre_month_closing['loan'][$po['product_id']]['M']['closing_outstanding_amount_with_services_charge']:'';
						
						
						$m_pre_month_closing_due_amount = isset($pre_month_closing['loan'][$po['product_id']]['M']['closing_due_amount'])?$pre_month_closing['loan'][$po['product_id']]['M']['closing_due_amount']:'';
						$m_pre_month_closing_due_amount_with_services_charge = $m_pre_month_closing_due_amount + isset($pre_month_closing['loan'][$po['product_id']]['M']['closing_due_amount_with_services_charge'])?$pre_month_closing['loan'][$po['product_id']]['M']['closing_due_amount_with_services_charge']:'';
					}
					
					// Male Member
					$data['member'][$i]['date'] = $to_date;
					$data['member'][$i]['branch_id'] =$branch_id;
					$data['member'][$i]['product_id'] = $po['product_id'];
					$data['member'][$i]['type'] = 'M';
					$data['member'][$i]['opening_member'] = $m_opening_members;
					$data['member'][$i]['branch_no'] = $po['branch_no'];
					$data['member'][$i]['samity_no'] = $po['M']['samity_no'];
					//$opening_members = 0;
					$data['member'][$i]['new_member_admission_no'] = $po['M']['new_member_admission_no'];
					$data['member'][$i]['member_cancellation_no'] = $po['M']['member_cancellation_no'];
					$data['member'][$i]['avg_savings_depositor'] = $po['avg_savings_depositor'];
					$data['member'][$i]['avg_attendance'] = $po['avg_attendance'];
					$data['member'][$i]['closing_member'] = $m_opening_members +  $po['M']['new_member_admission_no'] - $po['M']['member_cancellation_no'];
					// Male Saving
					$data['saving'][$i]['date'] = $to_date;
					$data['saving'][$i]['branch_id'] =$branch_id;
					$data['saving'][$i]['product_id'] = $po['product_id'];
					$data['saving'][$i]['type'] = 'M';
					
					$data['saving'][$i]['opening_balance'] = $m_closing_saving_balance;
					//$closing_saving_balance = 0;
					$data['saving'][$i]['deposit_collection'] = $po['M']['deposit_collection'];
					$data['saving'][$i]['saving_refund'] = $po['M']['saving_refund'];
					$data['saving'][$i]['closing_balance'] = $m_closing_saving_balance + $po['M']['deposit_collection'] - $po['M']['saving_refund'];
					
					// Male Loan
					$data['loan'][$i]['date'] = $to_date;
					$data['loan'][$i]['branch_id'] =$branch_id;
					$data['loan'][$i]['product_id'] = $po['product_id'];
					$data['loan'][$i]['type'] = 'M';
					//
					// pomis 2.1
					$data['loan'][$i]['opening_borrower_no'] = 	$m_opening_borrower_no;
					$data['loan'][$i]['opening_outstanding_amount'] = $m_opening_outstanding_amount;					
					$data['loan'][$i]['opening_outstanding_amount_with_services_charge'] =$data['loan'][$i]['opening_outstanding_amount'] + $m_opening_outstanding_amount_with_services_charge;					
					$data['loan'][$i]['borrower_no'] = $po['M']['borrower_no'];
					$data['loan'][$i]['disbursed_amount'] = $po['M']['disbursed_amount'];
					$data['loan'][$i]['principal_recovery_amount'] = $po['M']['principal_recovery_amount'];
					$data['loan'][$i]['interest_recovery_amount'] = $po['M']['interest_recovery_amount'];
					$data['loan'][$i]['fully_paid_borrower_no'] = $po['M']['fully_paid_borrower_no'];
					$data['loan'][$i]['closing_borrower_no'] = $m_opening_borrower_no + $po['M']['borrower_no'] - $po['M']['fully_paid_borrower_no'];
					//todo
					$data['loan'][$i]['closing_outstanding_amount'] = $m_opening_outstanding_amount + $po['M']['disbursed_amount'] - ($po['M']['principal_recovery_amount']);
					$total_interest_amount = 0;
					$data['loan'][$i]['closing_outstanding_amount_with_services_charge'] = $data['loan'][$i]['closing_outstanding_amount'] + $m_opening_outstanding_amount_with_services_charge + $total_interest_amount - ($po['M']['interest_recovery_amount']);
					//
					// pomis 2.2
					// opening data will get from previous month TODO
					//$pre_month_closing_due_amount = 0;
					//$data['loan'][$i]['opening_due_amount'] = $pre_month_closing_due_amount;
					
					$data['loan'][$i]['closing_due_amount'] = $m_pre_month_closing_due_amount;
					$data['loan'][$i]['closing_due_amount_with_services_charge'] = $m_pre_month_closing_due_amount_with_services_charge;
					$data['loan'][$i]['principal_recoverable_amount'] = $po['M']['principal_recoverable_amount'];
					$data['loan'][$i]['interest_recoverable_amount'] = $po['M']['interest_recoverable_amount'];
					$data['loan'][$i]['principal_advance_amount'] = $po['M']['principal_advance_amount'];
					$data['loan'][$i]['interest_advance_amount'] = $po['M']['interest_advance_amount'];
					$data['loan'][$i]['principal_due_amount'] = $po['M']['principal_due_amount'];
					$data['loan'][$i]['interest_due_amount'] = $po['M']['interest_due_amount'];
					// current regular = current recovery - (current due - current adavance) 
					$current_regular = $po['M']['principal_recovery_amount'] - ($po['M']['principal_due_amount'] + $po['M']['principal_advance_amount']);
										 
					$interest_current_regular = $po['M']['interest_recovery_amount'] - ($po['M']['interest_due_amount'] + $po['M']['interest_advance_amount']);
					// new due = current recoveable - current regular collection
					$new_due = $po['M']['principal_recoverable_amount'] - $current_regular;
					$interest_new_due = $po['M']['interest_recoverable_amount'] - $interest_current_regular;
					
					// total due = opeing due - (new due  +  current due)
					$data['loan'][$i]['closing_due_amount'] = $m_pre_month_closing_due_amount - $new_due + $po['M']['principal_due_amount'];
					
					$data['loan'][$i]['closing_due_amount_with_services_charge'] = $data['loan'][$i]['closing_due_amount'] + $m_pre_month_closing_due_amount_with_services_charge - $interest_new_due + $po['M']['interest_due_amount'];
					//
					// POMIS 3.1
					$data['loan'][$i]['substandard_outstanding'] = $po['M']['substandard_outstanding'];
					$data['loan'][$i]['substandard_outstanding_with_services_charge'] = $po['M']['substandard_outstanding_with_services_charge'];
					$data['loan'][$i]['substandard_overdue'] = $po['M']['substandard_overdue'];
					$data['loan'][$i]['substandard_overdue_with_services_charge'] = $po['M']['substandard_overdue_with_services_charge'];
					$data['loan'][$i]['doubtfull_outstanding'] = $po['M']['doubtfull_outstanding'];
					$data['loan'][$i]['doubtfull_outstanding_with_services_charge'] = $po['M']['doubtfull_outstanding_with_services_charge'];
					$data['loan'][$i]['doubtfull_overdue'] = $po['M']['doubtfull_overdue'];
					$data['loan'][$i]['doubtfull_overdue_with_services_charge'] = $po['M']['doubtfull_overdue_with_services_charge'];
					$data['loan'][$i]['bad_outstanding'] = $po['M']['bad_outstanding'];
					$data['loan'][$i]['bad_outstanding_with_services_charge'] = $po['M']['bad_outstanding_with_services_charge'];
					$data['loan'][$i]['bad_overdue'] = $po['M']['bad_overdue'];
					$data['loan'][$i]['bad_overdue'] = $po['M']['bad_overdue'];
					$data['loan'][$i]['no_of_due_loanee'] = $po['M']['no_of_due_loanee'];
					$data['loan'][$i]['saving_balance_of_overdue_loanee'] = $po['M']['saving_balance_of_overdue_loanee'];
					
					$i++;					
				}
			}
			//print_r($data);
			return $data;
		}
	function __pre_month_closing_info($branch_id,$max_date,$is_software_1st_month_end){
		$month_end_closing = array();
		
		$month_end_members = $this->Process_month_end->get_month_end_membrs_info($branch_id,$max_date,$is_software_1st_month_end);
		$month_end_closing_member = array();
        foreach($month_end_members as $month_end_member){
		     $month_end_closing['member'][$month_end_member['product_id']][$month_end_member['type']]['closing_member'] = $month_end_member['closing_member'];
		}
        
        $month_end_savings = $this->Process_month_end->get_month_end_savings_info($branch_id,$max_date);
		$month_end_closing_saving = array();
        foreach($month_end_savings as $month_end_saving){
		     $month_end_closing['saving'][$month_end_saving['product_id']][$month_end_saving['type']]['closing_balance'] = $month_end_saving['closing_balance'];
		}
        
        $month_end_loans = $this->Process_month_end->get_month_end_loans_info($branch_id,$max_date);
		$month_end_closing_loan = array();
        foreach($month_end_loans as $month_end_loan){
		     $month_end_closing['loan'][$month_end_loan['product_id']][$month_end_loan['type']]['closing_borrower_no'] = $month_end_loan['closing_borrower_no'];
		     $month_end_closing['loan'][$month_end_loan['product_id']][$month_end_loan['type']]['closing_outstanding_amount'] = $month_end_loan['closing_outstanding_amount'];
            $month_end_closing['loan'][$month_end_loan['product_id']][$month_end_loan['type']]['closing_due_amount'] = $month_end_loan['closing_due_amount'];
		}
		return $month_end_closing;		
	}
	function execute($from_date,$to_date,$branch_id,$is_software_1st_month_end)
	{
		
		//$from_date = '2011-03-01';
		//		$to_date = '2011-03-31';
		//		$branch_id = $this->get_branch_id();
		//echo "<pre>";
		$pomis = array();
		$product_list = array();
		$all_member_list = $this->Process_month_end->get_member_list($to_date,null,2,null,null);
		$this->__get_product_information($branch_id,$from_date,$to_date,$pomis,$product_list);
		
		$no_of_branchs = $this->Process_month_end->get_no_of_branch($branch_id);
		//print_r($no_of_branchs);
		foreach($no_of_branchs as $no_of_branch){
			$pomis[$no_of_branch['product_id']]['branch_no']=$no_of_branch['no_of_branch'];
		}
	
		$no_of_samities = $this->Process_month_end->get_no_of_samity($branch_id);
		//print_r($no_of_samities);
		foreach($no_of_samities as $no_of_samity){
			$pomis[$no_of_samity['product_id']]['F']['samity_no']=$no_of_samity['no_of_female_samity'];
			$pomis[$no_of_samity['product_id']]['M']['samity_no']=$no_of_samity['no_of_male_samity'];
		}
		
		$this->__get_member_information($all_member_list,$branch_id,$from_date,$to_date,$pomis,$product_list,$is_software_1st_month_end);
		//	echo '<pre>';
		$this->__get_saving_information($branch_id,$from_date,$to_date,$pomis,$is_software_1st_month_end);	
		
		$this->__get_loan_information($branch_id,$from_date,$to_date,$pomis,$is_software_1st_month_end);
		$this->__get_loan_over_due_information($all_member_list,$branch_id,$from_date,$to_date,$pomis,$product_list);
		// Savings Interest calculate 
		
		$savings_general_config = $this->Process_month_end->get_savings_general_config();
		$savings_frequency = $savings_general_config['savings_frequency_of_interest_posting_to_accounts'];
		//$savings_frequency = 3;
		$disbursment_month =$savings_general_config['savings_interest_disbursment_month'];
		$closing_month =$savings_general_config['savings_interest_calculation_closing_month'];
		for($i=1;$i<=12/$savings_frequency;$i++){
			$disbursment_month = date('F',strtotime(" -$savings_frequency month ".$disbursment_month));
			$closing_month = date('F',strtotime(" -$savings_frequency month ".$closing_month));
			$disbursment_months[] = date('m',strtotime(" -$savings_frequency month ".$disbursment_month));
			$closing_months[] = date('m',strtotime(" -$savings_frequency month ".$closing_month));
			//echo "$disbursment_month $closing_month <br>";
	
		}
		//echo "$to_date<pre>".date('Y-m-d',strtotime(" -1 second ".$from_date));;
		//echo date('m',strtotime($savings_general_config['savings_interest_calculation_closing_month']))."<br>";
		//echo date('m',strtotime(" -6 month ".$savings_general_config['savings_interest_disbursment_month']))."<br>";
		//print_r($disbursment_months);
		//print_r($closing_months);
		//print_r($savings_general_config );
		$month_end_month = date('m',strtotime("$to_date"));
		$pomis['savings_interest']  = array();
		if(in_array($month_end_month,$closing_months)){
			$transaction_date = $to_date;
			$to_date = date('Y-m-d',strtotime(" -1 second ".$from_date));
			$savings_deposit_amounts_info = $this->__get_savings_interest_information($savings_general_config,$branch_id,$from_date,$to_date,$pomis,$transaction_date);	
			$pomis['savings_interest'] = $savings_deposit_amounts_info;
		}
		
		//	echo '<pre>';
		//print_r($pomis);
	return $pomis;
	}
	function __get_product_information($branch_id,$from_date,$to_date,&$pomis,&$product_list){
		
		$products= $this->Process_month_end->get_product_list();
		//print_r($products);
		foreach($products as $product){
			$product_list[$product['product_id']] = $product['short_name'];
			$pomis[$product['product_id']]['product_id']=$product['product_id'];
			$pomis[$product['product_id']]['short_name']=$product['short_name'];
			$pomis[$product['product_id']]['branch_no']=0;
			$pomis[$product['product_id']]['type']='';
			$pomis[$product['product_id']]['F']['opening_member']=0;
			$pomis[$product['product_id']]['M']['opening_member']=0;
			$pomis[$product['product_id']]['F']['samity_no']=0;
			$pomis[$product['product_id']]['M']['samity_no']=0;
			$pomis[$product['product_id']]['F']['new_member_admission_no']=0;
			$pomis[$product['product_id']]['M']['new_member_admission_no']=0;
			$pomis[$product['product_id']]['F']['member_cancellation_no']=0;
			$pomis[$product['product_id']]['M']['member_cancellation_no']=0;
			$pomis[$product['product_id']]['avg_savings_depositor']=0;
			$pomis[$product['product_id']]['avg_attendance']=0;
			$pomis[$product['product_id']]['F']['closing_member']=0;
			$pomis[$product['product_id']]['M']['closing_member']=0;
			$pomis[$product['product_id']]['F']['opening_balance']=0;
			$pomis[$product['product_id']]['M']['opening_balance']=0;
			$pomis[$product['product_id']]['F']['opening_deposit_collection']=0;
			$pomis[$product['product_id']]['M']['opening_deposit_collection']=0;
			$pomis[$product['product_id']]['F']['opening_saving_refund']=0;
			$pomis[$product['product_id']]['M']['opening_saving_refund']=0;
			$pomis[$product['product_id']]['F']['deposit_collection']=0;
			$pomis[$product['product_id']]['M']['deposit_collection']=0;
			$pomis[$product['product_id']]['F']['saving_refund']=0;
			$pomis[$product['product_id']]['M']['saving_refund']=0;
			$pomis[$product['product_id']]['F']['closing_balance']=0;
			$pomis[$product['product_id']]['M']['closing_balance']=0;
			$pomis[$product['product_id']]['F']['opening_borrower_no']=0;
			$pomis[$product['product_id']]['M']['opening_borrower_no']=0;
			$pomis[$product['product_id']]['F']['opening_outstanding_amount']=0;
			$pomis[$product['product_id']]['M']['opening_outstanding_amount']=0;
			$pomis[$product['product_id']]['F']['opening_outstanding_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['opening_outstanding_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['borrower_no']=0;
			$pomis[$product['product_id']]['M']['borrower_no']=0;
			$pomis[$product['product_id']]['F']['disbursed_amount']=0;
			$pomis[$product['product_id']]['M']['disbursed_amount']=0;
			$pomis[$product['product_id']]['F']['opening_principal_recovery_amount']=0;
			$pomis[$product['product_id']]['M']['opening_principal_recovery_amount']=0;
			$pomis[$product['product_id']]['F']['opening_interest_recovery_amount']=0;
			$pomis[$product['product_id']]['M']['opening_interest_recovery_amount']=0;
			$pomis[$product['product_id']]['F']['principal_recovery_amount']=0;
			$pomis[$product['product_id']]['M']['principal_recovery_amount']=0;
			$pomis[$product['product_id']]['F']['interest_recovery_amount']=0;
			$pomis[$product['product_id']]['M']['interest_recovery_amount']=0;
			$pomis[$product['product_id']]['F']['fully_paid_borrower_no']=0;
			$pomis[$product['product_id']]['M']['fully_paid_borrower_no']=0;
			$pomis[$product['product_id']]['F']['closing_borrower_no']=0;
			$pomis[$product['product_id']]['M']['closing_borrower_no']=0;
			$pomis[$product['product_id']]['F']['closing_outstanding_amount']=0;
			$pomis[$product['product_id']]['M']['closing_outstanding_amount']=0;
			$pomis[$product['product_id']]['F']['closing_outstanding_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['closing_outstanding_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['opening_due_amount']=0;
			$pomis[$product['product_id']]['M']['opening_due_amount']=0;
			$pomis[$product['product_id']]['F']['opening_due_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['opening_due_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['opening_principal_recoverable_amount']=0;
			$pomis[$product['product_id']]['M']['opening_principal_recoverable_amount']=0;
			$pomis[$product['product_id']]['F']['opening_interest_recoverable_amount']=0;
			$pomis[$product['product_id']]['M']['opening_interest_recoverable_amount']=0;
			$pomis[$product['product_id']]['F']['principal_recoverable_amount']=0;
			$pomis[$product['product_id']]['M']['principal_recoverable_amount']=0;
			$pomis[$product['product_id']]['F']['interest_recoverable_amount']=0;
			$pomis[$product['product_id']]['M']['interest_recoverable_amount']=0;
			$pomis[$product['product_id']]['F']['opening_principal_advance_amount']=0;
			$pomis[$product['product_id']]['M']['opening_principal_advance_amount']=0;
			$pomis[$product['product_id']]['F']['opening_interest_advance_amount']=0;
			$pomis[$product['product_id']]['M']['opening_interest_advance_amount']=0;
			$pomis[$product['product_id']]['F']['opening_principal_due_amount']=0;
			$pomis[$product['product_id']]['M']['opening_principal_due_amount']=0;
			$pomis[$product['product_id']]['F']['opening_interest_due_amount']=0;
			$pomis[$product['product_id']]['M']['opening_interest_due_amount']=0;
			$pomis[$product['product_id']]['F']['principal_advance_amount']=0;
			$pomis[$product['product_id']]['M']['principal_advance_amount']=0;
			$pomis[$product['product_id']]['F']['interest_advance_amount']=0;
			$pomis[$product['product_id']]['M']['interest_advance_amount']=0;
			$pomis[$product['product_id']]['F']['principal_due_amount']=0;
			$pomis[$product['product_id']]['M']['principal_due_amount']=0;
			$pomis[$product['product_id']]['F']['interest_due_amount']=0;
			$pomis[$product['product_id']]['M']['interest_due_amount']=0;
			$pomis[$product['product_id']]['F']['closing_due_amount']=0;
			$pomis[$product['product_id']]['M']['closing_due_amount']=0;
			$pomis[$product['product_id']]['F']['closing_due_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['closing_due_amount_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['substandard_outstanding']=0;
			$pomis[$product['product_id']]['M']['substandard_outstanding']=0;
			$pomis[$product['product_id']]['F']['substandard_outstanding_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['substandard_outstanding_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['substandard_overdue']=0;
			$pomis[$product['product_id']]['M']['substandard_overdue']=0;
			$pomis[$product['product_id']]['F']['substandard_overdue_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['substandard_overdue_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['doubtfull_outstanding']=0;
			$pomis[$product['product_id']]['M']['doubtfull_outstanding']=0;
			$pomis[$product['product_id']]['F']['doubtfull_outstanding_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['doubtfull_outstanding_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['doubtfull_overdue']=0;
			$pomis[$product['product_id']]['M']['doubtfull_overdue']=0;
			$pomis[$product['product_id']]['F']['doubtfull_overdue_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['doubtfull_overdue_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['bad_outstanding']=0;
			$pomis[$product['product_id']]['M']['bad_outstanding']=0;
			$pomis[$product['product_id']]['F']['bad_outstanding_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['bad_outstanding_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['bad_overdue']=0;
			$pomis[$product['product_id']]['M']['bad_overdue']=0;
			$pomis[$product['product_id']]['F']['bad_overdue_with_services_charge']=0;
			$pomis[$product['product_id']]['M']['bad_overdue_with_services_charge']=0;
			$pomis[$product['product_id']]['F']['no_of_due_loanee']=0;
			$pomis[$product['product_id']]['M']['no_of_due_loanee']=0;
			$pomis[$product['product_id']]['F']['saving_balance_of_overdue_loanee']=0;
			$pomis[$product['product_id']]['M']['saving_balance_of_overdue_loanee']=0;
		}
	}
		function __get_loan_over_due_information($all_member_list,$branch_id,$from_date,$to_date,&$pomis,$product_list){
		
		$active_member_list = $this->Process_month_end->get_active_member($all_member_list,'member_status');
		//	print_r($active_member_list);
		 $member_list = '';
		 $i = 0;
		 $c = count($active_member_list);
			foreach($active_member_list as $row){
				if(++$i == $c){
			
					$member_list .= $row['id'].'';
				}else {
					
				$member_list .= $row['id'].',';
				}
				
			//	print_r($row);
			}
			//$loan_schedules = 
			//echo "<pre>";
			$products= $this->Process_month_end->get_product_list();
		//	print_r($products);
		foreach($products as $product){
				$loans = $this->Process_month_end->get_loan_report_data($member_list,$to_date,$branch_id,$product['product_id']);
			//echo "$tmp_loan_product_category_id == {$product['loan_product_category_id']} <br>";
		
				$pomis[$product['product_id']]['F']['substandard_outstanding']=$loans['substandard_outstanding'];
				$pomis[$product['product_id']]['F']['substandard_outstanding_with_services_charge']=$loans['substandard_outstanding_with_services_charge'];
				$pomis[$product['product_id']]['F']['substandard_overdue']=$loans['substandard_overdue'];
				$pomis[$product['product_id']]['F']['substandard_overdue_with_services_charge']=$loans['substandard_overdue_with_services_charge'];
				$pomis[$product['product_id']]['F']['doubtfull_outstanding']=$loans['doubtfull_outstanding'];
				$pomis[$product['product_id']]['F']['doubtfull_outstanding_with_services_charge']=$loans['doubtfull_outstanding_with_services_charge'];
				$pomis[$product['product_id']]['F']['doubtfull_overdue']=$loans['doubtfull_overdue'];
				$pomis[$product['product_id']]['F']['doubtfull_overdue_with_services_charge']=$loans['doubtfull_overdue_with_services_charge'];
				$pomis[$product['product_id']]['F']['bad_outstanding']=$loans['bad_outstanding'];
				$pomis[$product['product_id']]['F']['bad_outstanding_with_services_charge']=$loans['bad_outstanding_with_services_charge'];
				$pomis[$product['product_id']]['F']['bad_overdue']=$loans['bad_overdue'];
				$pomis[$product['product_id']]['F']['bad_overdue_with_services_charge']=$loans['bad_overdue_with_services_charge'];
				$pomis[$product['product_id']]['F']['no_of_due_loanee']=$loans['no_of_due_loanee'];
				$pomis[$product['product_id']]['F']['saving_balance_of_overdue_loanee'] = $loans['saving_balance_of_overdue_loanee'];
				
		//	echo "<pre>";
	//	print_r($pomis);
	//echo "{$loans['saving_balance_of_overdue_loanee']}";
			}
			//print_r($products);
			//		echo "<pre>";
		//print_r($products);
	//	die;
		}
	function __get_member_information($all_member_list,$branch_id,$from_date,$to_date,&$pomis,$product_list,$is_software_1st_month_end){
		//echo "<pre> $from_date $to_date <br>";
		
		$active_member_list = $this->Process_month_end->get_active_member($all_member_list,'member_status');

		$inactive_member_list = $this->Process_month_end->get_inactive_member($all_member_list,'member_status');
		
		
		$current_month_member_cancellation = $this->Process_month_end->between_date_range_member($inactive_member_list,"cancel_date",$from_date,$to_date);
		//echo count($inactive_member_list)."--".count($pre_month_member_cancellation)."==".count($current_month_member_cancellation);
		//print_r($inactive_member_list);
		
		$current_month_member_registration =  $this->Process_month_end->between_date_range_member($active_member_list,"registration_date",$from_date,$to_date);
		//print_r($current_month_member_registration);
		//$total_member_end_of_the_last_month =   $this->Process_month_end->between_date_range_member($active_member_list,"registration_date",$from_date);
		
		if($is_software_1st_month_end){
			/*
			$pre_month_member_cancellation = $this->Process_month_end->between_date_range_member($inactive_member_list,"cancel_date",$from_date);
			$pre_month_member_cancellation_by_product = $this->Process_month_end->group_by($pre_month_member_cancellation,$product_list);
			foreach($pre_month_member_cancellation_by_product as $pre_month_member_cancellation){
				//print_r($current_month_member_cancellation);
				$pomis[$pre_month_member_cancellation['product_id']]['F']['opening_member']=$pre_month_member_cancellation['F'];
				$pomis[$pre_month_member_cancellation['product_id']]['M']['opening_member']=$pre_month_member_cancellation['M'];
			}
			*/
			$pre_month_member_registration =  $this->Process_month_end->between_date_range_member($active_member_list,"registration_date",$from_date);
			$pre_month_member_registration_by_product = $this->Process_month_end->group_by($pre_month_member_registration,$product_list);
			//print_r($pre_month_member_registration );
			foreach($pre_month_member_registration_by_product as $pre_month_member_registration){
				//print_r($current_month_member_cancellation);
				$pomis[$pre_month_member_registration['product_id']]['F']['opening_member']=$pre_month_member_registration['F'];
				$pomis[$pre_month_member_registration['product_id']]['M']['opening_member']=$pre_month_member_registration['M'];
			}
			
		}
		
		$current_month_member_cancellation_by_product = $this->Process_month_end->group_by($current_month_member_cancellation,$product_list);
		//print_r($current_month_member_cancellation_by_product);
		foreach($current_month_member_cancellation_by_product as $current_month_member_cancellation){
		//print_r($current_month_member_cancellation);
			$pomis[$current_month_member_cancellation['product_id']]['F']['member_cancellation_no']=$current_month_member_cancellation['F'];
			$pomis[$current_month_member_cancellation['product_id']]['M']['member_cancellation_no']=$current_month_member_cancellation['M'];
		}
		
		$current_month_member_registration_by_product = $this->Process_month_end->group_by($current_month_member_registration,$product_list);
		
		foreach($current_month_member_registration_by_product as $current_month_member_registration){
			$pomis[$current_month_member_registration['product_id']]['F']['new_member_admission_no']=$current_month_member_registration['F'];
			$pomis[$current_month_member_registration['product_id']]['M']['new_member_admission_no']=$current_month_member_registration['M'];
		}
		//print_r($pomis);
	}
	function __get_saving_information($branch_id,$from_date,$to_date,&$pomis,$is_software_1st_month_end){
		//savings
		if($is_software_1st_month_end) {
			
			$pre_month_saving_refunds =$this->Process_month_end->get_withdraw_information($branch_id,$from_date);
			
			foreach($pre_month_saving_refunds as $pre_month_saving_refund){
				$pomis[$pre_month_saving_refund['product_id']]['F']['opening_saving_refund']=$pre_month_saving_refund['female_withdraws_amount'];
				$pomis[$pre_month_saving_refund['product_id']]['M']['opening_saving_refund']=$pre_month_saving_refund['male_withdraws_amount'];
			}
			
			$pre_month_deposit_collections = $this->Process_month_end->get_deposit_information($branch_id,$from_date);
			//print_r($pre_month_deposit_collections);
			foreach($pre_month_deposit_collections as $pre_month_deposit_collection){
				$pomis[$pre_month_deposit_collection['product_id']]['F']['opening_deposit_collection']=$pre_month_deposit_collection['female_withdraws_amount'];
				$pomis[$pre_month_deposit_collection['product_id']]['M']['opening_deposit_collection']=$pre_month_deposit_collection['male_withdraws_amount'];
			}
		}
		
		$current_month_saving_refunds =$this->Process_month_end->get_withdraw_information($branch_id,$from_date,$to_date);
		//print_r($current_month_saving_refunds);
		foreach($current_month_saving_refunds as $current_month_saving_refund){
			$pomis[$current_month_saving_refund['product_id']]['F']['saving_refund']=$current_month_saving_refund['female_withdraws_amount'];
			$pomis[$current_month_saving_refund['product_id']]['M']['saving_refund']=$current_month_saving_refund['male_withdraws_amount'];
		}
		//

		$current_month_deposit_collections = $this->Process_month_end->get_deposit_information($branch_id,$from_date,$to_date);
		foreach($current_month_deposit_collections as $current_month_deposit_collection){
			$pomis[$current_month_deposit_collection['product_id']]['F']['deposit_collection']=$current_month_deposit_collection['female_withdraws_amount'];
			$pomis[$current_month_deposit_collection['product_id']]['M']['deposit_collection']=$current_month_deposit_collection['male_withdraws_amount'];
		}
	}
	function __get_loan_information($branch_id,$from_date,$to_date,&$pomis,$is_software_1st_month_end){
		//$pomis = array();
		if($is_software_1st_month_end) {
			$pre_month_disburse_informations = $this->Process_month_end->get_loan_disburse_information($branch_id,$from_date);
			foreach($pre_month_disburse_informations as $pre_month_disburse_information){
				//$pomis[$pre_month_disburse_information['product_id']]['F']['disbursed_amount']=$pre_month_disburse_information['female_disbursed_amount'];
				//$pomis[$pre_month_disburse_information['product_id']]['M']['disbursed_amount']=$pre_month_disburse_information['male_disbursed_amount'];
				$pomis[$pre_month_disburse_information['product_id']]['F']['opening_borrower_no']=$pre_month_disburse_information['female_borrower_no'];
				$pomis[$pre_month_disburse_information['product_id']]['M']['opening_borrower_no']=$pre_month_disburse_information['male_borrower_no'];
			}
		}
		// loan
		$current_month_disburse_informations = $this->Process_month_end->get_loan_disburse_information($branch_id,$from_date,$to_date);
		foreach($current_month_disburse_informations as $current_month_disburse_information){
			$pomis[$current_month_disburse_information['product_id']]['F']['disbursed_amount']=$current_month_disburse_information['female_disbursed_amount'];
			$pomis[$current_month_disburse_information['product_id']]['M']['disbursed_amount']=$current_month_disburse_information['male_disbursed_amount'];
			$pomis[$current_month_disburse_information['product_id']]['F']['borrower_no']=$current_month_disburse_information['female_borrower_no'];
			$pomis[$current_month_disburse_information['product_id']]['M']['borrower_no']=$current_month_disburse_information['male_borrower_no'];
		}
		
		
		// Loan Recovery
	//	$last_month_loan_recovery_information = $this->Process_month_end->get_loan_recovery_information($branch_id,$from_date);
//		foreach($last_month_loan_recovery_information as $last_month_loan_recovery){
//			$pomis[$last_month_loan_recovery['product_id']]['loan_last_month_female_recovery_amount']=$last_month_loan_recovery['female_recovery_amount'];
//			$pomis[$last_month_loan_recovery['product_id']]['loan_last_month_male_recovery_amount']=$last_month_loan_recovery['male_recovery_amount'];
//		}
		if($is_software_1st_month_end){
			$pre_month_loan_recovery_information = $this->Process_month_end->get_loan_recovery_information($branch_id,$from_date);
			//	print_r($current_month_loan_recovery_information);
				foreach($pre_month_loan_recovery_information as $pre_month_loan_recovery){
					$pomis[$pre_month_loan_recovery['product_id']]['F']['opening_principal_recovery_amount']=$pre_month_loan_recovery['female_recovery_amount'];
					$pomis[$pre_month_loan_recovery['product_id']]['M']['opening_principal_recovery_amount']=$pre_month_loan_recovery['male_recovery_amount'];
					$pomis[$pre_month_loan_recovery['product_id']]['F']['opening_interest_recovery_amount']=$pre_month_loan_recovery['female_interest_recovery_amount'];
					$pomis[$pre_month_loan_recovery['product_id']]['M']['opening_interest_recovery_amount']=$pre_month_loan_recovery['male_interest_recovery_amount'];
				}
		}
		$current_month_loan_recovery_information = $this->Process_month_end->get_loan_recovery_information($branch_id,$from_date,$to_date);
	//	print_r($current_month_loan_recovery_information);
		foreach($current_month_loan_recovery_information as $current_month_loan_recovery){
			$pomis[$current_month_loan_recovery['product_id']]['F']['principal_recovery_amount']=$current_month_loan_recovery['female_recovery_amount'];
			$pomis[$current_month_loan_recovery['product_id']]['M']['principal_recovery_amount']=$current_month_loan_recovery['male_recovery_amount'];
			$pomis[$current_month_loan_recovery['product_id']]['F']['interest_recovery_amount']=$current_month_loan_recovery['female_interest_recovery_amount'];
			$pomis[$current_month_loan_recovery['product_id']]['M']['interest_recovery_amount']=$current_month_loan_recovery['male_interest_recovery_amount'];
		}
		// Loan fully paid borrower
		//$last_month_loan_fully_paid_borrowers = $this->Process_month_end->get_loan_fully_paid_borrower($branch_id,$from_date);
//		foreach($last_month_loan_fully_paid_borrowers as $last_month_loan_fully_paid_borrower){
//			$pomis[$last_month_loan_fully_paid_borrower['product_id']]['loan_last_month_female_fully_paid_borrower']=$last_month_loan_fully_paid_borrower['female_fully_paid_borrower'];
//			$pomis[$last_month_loan_fully_paid_borrower['product_id']]['loan_last_month_male_fully_paid_borrower']=$last_month_loan_fully_paid_borrower['male_fully_paid_borrower'];
//		}
		
		$current_month_loan_fully_paid_borrowers = $this->Process_month_end->get_loan_fully_paid_borrower($branch_id,$from_date,$to_date);
		foreach($current_month_loan_fully_paid_borrowers as $current_month_loan_fully_paid_borrower){
			$pomis[$current_month_loan_fully_paid_borrower['product_id']]['F']['fully_paid_borrower_no']=$current_month_loan_fully_paid_borrower['female_fully_paid_borrower'];
			$pomis[$current_month_loan_fully_paid_borrower['product_id']]['M']['fully_paid_borrower_no']=$current_month_loan_fully_paid_borrower['male_fully_paid_borrower'];
		}
		
		// loan Recoverable
		
		if($is_software_1st_month_end){
			$pre_month_loan_recoverable_amounts = $this->scheduler->get_loan_recoverable_amount_branch_id($branch_id,$from_date);
			//print_r($pre_month_loan_recoverable_amounts);
			//$product_id_key = 0;
			foreach($pre_month_loan_recoverable_amounts as $product_id_key=>$pre_month_loan_recoverable_amount){
				$pomis[$product_id_key]['F']['opening_principal_recoverable_amount']=$pre_month_loan_recoverable_amount['F']['principle_installment_amount'];
				$pomis[$product_id_key]['M']['opening_principal_recoverable_amount']=$pre_month_loan_recoverable_amount['M']['principle_installment_amount'];
				$pomis[$product_id_key]['F']['opening_interest_recoverable_amount']=$pre_month_loan_recoverable_amount['F']['interrest_installment_amount'];
				$pomis[$product_id_key]['M']['opening_interest_recoverable_amount']=$pre_month_loan_recoverable_amount['M']['interrest_installment_amount'];
			} 
		}
		//var_dump($branch_id);
		$current_month_loan_recoverable_amounts = $this->scheduler->get_loan_recoverable_amount_branch_id($branch_id,$from_date,$to_date);
		//print_r($current_month_loan_recoverable_amounts);
		//$product_id_key = 0;
		foreach($current_month_loan_recoverable_amounts as $product_id_key=>$current_month_loan_recoverable_amount){
			$pomis[$product_id_key]['F']['principal_recoverable_amount']=$current_month_loan_recoverable_amount['F']['principle_installment_amount'];
			$pomis[$product_id_key]['M']['principal_recoverable_amount']=$current_month_loan_recoverable_amount['M']['principle_installment_amount'];
			$pomis[$product_id_key]['F']['interest_recoverable_amount']=$current_month_loan_recoverable_amount['F']['interrest_installment_amount'];
			$pomis[$product_id_key]['M']['interest_recoverable_amount']=$current_month_loan_recoverable_amount['M']['interrest_installment_amount'];
		} 
		
		// loan Advance
		if($is_software_1st_month_end){
			$pre_month_loan_advance_amounts = $this->Process_month_end->get_loan_advance_collection_amount($branch_id,$from_date);
			foreach($pre_month_loan_advance_amounts as $pre_month_loan_advance_amount){
				$pomis[$pre_month_loan_advance_amount['product_id']]['F']['opening_principal_advance_amount']=$pre_month_loan_advance_amount['female_principal_advance_amount'];
				$pomis[$pre_month_loan_advance_amount['product_id']]['M']['opening_principal_advance_amount']=$pre_month_loan_advance_amount['male_principal_advance_amount'];
				$pomis[$pre_month_loan_advance_amount['product_id']]['F']['opening_interest_advance_amount']=$pre_month_loan_advance_amount['female_interest_advance_amount'];
				$pomis[$pre_month_loan_advance_amount['product_id']]['M']['opening_interest_advance_amount']=$pre_month_loan_advance_amount['male_interest_advance_amount'];
			}
		}
		
		$current_month_loan_advance_amounts = $this->Process_month_end->get_loan_advance_collection_amount($branch_id,$from_date,$to_date);
		foreach($current_month_loan_advance_amounts as $current_month_loan_advance_amount){
			$pomis[$current_month_loan_advance_amount['product_id']]['F']['principal_advance_amount']=$current_month_loan_advance_amount['female_principal_advance_amount'];
			$pomis[$current_month_loan_advance_amount['product_id']]['M']['principal_advance_amount']=$current_month_loan_advance_amount['male_principal_advance_amount'];
			$pomis[$current_month_loan_advance_amount['product_id']]['F']['interest_advance_amount']=$current_month_loan_advance_amount['female_interest_advance_amount'];
			$pomis[$current_month_loan_advance_amount['product_id']]['M']['interest_advance_amount']=$current_month_loan_advance_amount['male_interest_advance_amount'];
		}
		
		// loan Due
		if($is_software_1st_month_end){
			$pre_month_loan_due_amounts = $this->Process_month_end->get_loan_due_collection_amount($branch_id,$from_date);
			//print_r($pre_month_loan_due_amounts);
			foreach($pre_month_loan_due_amounts as $pre_month_loan_due_amount){
				$pomis[$pre_month_loan_due_amount['product_id']]['F']['opening_principal_due_amount']=$pre_month_loan_due_amount['female_principal_due_amount'];
				$pomis[$pre_month_loan_due_amount['product_id']]['M']['opening_principal_due_amount']=$pre_month_loan_due_amount['male_principal_due_amount'];
				$pomis[$pre_month_loan_due_amount['product_id']]['F']['opening_interest_due_amount']=$pre_month_loan_due_amount['female_interest_due_amount'];
				$pomis[$pre_month_loan_due_amount['product_id']]['M']['opening_interest_due_amount']=$pre_month_loan_due_amount['male_interest_due_amount'];
			}
		}
		$current_month_loan_due_amounts = $this->Process_month_end->get_loan_due_collection_amount($branch_id,$from_date,$to_date);
		foreach($current_month_loan_due_amounts as $current_month_loan_due_amount){
			$pomis[$current_month_loan_due_amount['product_id']]['F']['principal_due_amount']=$current_month_loan_due_amount['female_principal_due_amount'];
			$pomis[$current_month_loan_due_amount['product_id']]['M']['principal_due_amount']=$current_month_loan_due_amount['male_principal_due_amount'];
			$pomis[$current_month_loan_due_amount['product_id']]['F']['interest_due_amount']=$current_month_loan_due_amount['female_interest_due_amount'];
			$pomis[$current_month_loan_due_amount['product_id']]['M']['interest_due_amount']=$current_month_loan_due_amount['male_interest_due_amount'];
		}
		return true;
	}	
	function __get_savings_interest_information($savings_general_config,$branch_id,$from_date,$to_date,&$pomis,$transaction_date){
		//echo "<pre>";
		//print_r($savings_general_config);
		if(isset($savings_general_config['savings_minimum_account_duration_to_receive_interest'])){
			$savings_minimum_date_to_receive_interest = date("Y-m-d", strtotime("-{$savings_general_config['savings_minimum_account_duration_to_receive_interest']} months", strtotime($to_date)));
		}
		$savings_interest_eligible_list = $this->Process_month_end->get_savings_interest_eligible_list($branch_id,$savings_minimum_date_to_receive_interest);
		$savings_product_list = $this->Process_month_end->get_savings_product_list();
		//print_r($savings_product_list);
		$savings_product_interest_rate = array();
		foreach($savings_product_list as $savings_product) {
			$savings_product_interest_rate[$savings_product['saving_product_id']]['saving_product_id'] = $savings_product['saving_product_id'];
			$savings_product_interest_rate[$savings_product['saving_product_id']]['interest_rate'] = $savings_product['interest_rate'];
		}
		$savings_interest_eligible_members = array();
		$savings_interest_eligible_members_savings_id = array();
		foreach($savings_interest_eligible_list as $savings_interest_eligible) {
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['savings_id'] = $savings_interest_eligible['savings_id'];
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['member_id'] = $savings_interest_eligible['member_id'];			
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['samity_id'] = $savings_interest_eligible['samity_id'];			
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['branch_id'] = $savings_interest_eligible['branch_id'];			
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['saving_products_id'] = $savings_interest_eligible['saving_products_id'];
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['member_primary_product_id'] = $savings_interest_eligible['primary_product_id'];
			$product_interest_rate = isset($savings_product_interest_rate[$savings_interest_eligible['saving_products_id']]['interest_rate'])?$savings_product_interest_rate[$savings_interest_eligible['saving_products_id']]['interest_rate']:"";
			$savings_interest_eligible_members[$savings_interest_eligible['savings_id']]['interest_rate'] = $product_interest_rate ;
			$savings_interest_eligible_members_savings_id[] = $savings_interest_eligible['savings_id'];
		}
		
		//echo "$savings_minimum_date_to_receive_interest";
		$savings_interest_eligible_members_savings_id_str = join(',',$savings_interest_eligible_members_savings_id);
		
		$saving_deposit_by_eligible_members =$this->Process_month_end->get_saving_deposit_by_eligible_members($branch_id,$to_date,$savings_interest_eligible_members_savings_id_str);
		$saving_deposits = array();
		foreach($saving_deposit_by_eligible_members  as $saving_deposit_by_eligible_member){
			$saving_deposits[$saving_deposit_by_eligible_member['savings_id']]['savings_id'] = $saving_deposit_by_eligible_member['savings_id'];
			$saving_deposits[$saving_deposit_by_eligible_member['savings_id']]['deposit_amount'] = $saving_deposit_by_eligible_member['deposit_amount'];
		}
		
		$saving_refunds_by_eligible_members =$this->Process_month_end->get_saving_refunds_by_eligible_members($branch_id,$to_date,$savings_interest_eligible_members_savings_id_str);
		$saving_refunds = array();
		foreach($saving_refunds_by_eligible_members  as $saving_refunds_by_eligible_member){
			$saving_refunds[$saving_refunds_by_eligible_member['savings_id']]['savings_id'] = $saving_refunds_by_eligible_member['savings_id'];
			$saving_refunds[$saving_refunds_by_eligible_member['savings_id']]['refund_amount'] = $saving_refunds_by_eligible_member['refund_amount'];
		}
		$savings_interest_calculations = $savings_interest_eligible_members;
		foreach($savings_interest_eligible_members as $savings_eligible_member) {
					$deposit_amount = isset($saving_deposits[$savings_eligible_member['savings_id']]['deposit_amount'])?$saving_deposits[$savings_eligible_member['savings_id']]['deposit_amount']:0;
					$refund_amount = isset($saving_refunds[$savings_eligible_member['savings_id']]['refund_amount'])?$saving_refunds[$savings_eligible_member['savings_id']]['refund_amount']:0;
					$savings_interest_calculations[$savings_eligible_member['savings_id']]['deposit_amount'] = $deposit_amount;
					$savings_interest_calculations[$savings_eligible_member['savings_id']]['refund_amount'] = $refund_amount;
					$savings_interest_calculations[$savings_eligible_member['savings_id']]['total_amount_for_interest_calculate'] = $deposit_amount - $refund_amount;
		}
		$savings_deposit_amounts_info = array();
		//print_r($savings_interest_calculations);
		foreach($savings_interest_calculations as $savings){
			$total_amount_for_interest_calculate = 0;
			if($savings_general_config['savings_balance_used_for_interest_calculation'] == 'MINIMUM_BALANCE') {
				$total_amount_for_interest_calculate = $savings['total_amount_for_interest_calculate'];
			} elseif($savings_general_config['savings_balance_used_for_interest_calculation'] == 'AVERAGE_BALANCE') {
				$duration  = ($savings_general_config['savings_frequency_of_interest_posting_to_accounts']>0)?$savings_general_config['savings_frequency_of_interest_posting_to_accounts']:1;
				$total_amount_for_interest_calculate = $savings['total_amount_for_interest_calculate']/$duration ;
			}  
			//echo "{$savings['total_amount_for_interest_calculate']} <br>";
			if($savings_general_config['savings_minimum_balance_required_for_interest_calculation'] <= $total_amount_for_interest_calculate ) {
				$savings_deposit_amounts_info[$savings['savings_id']]['savings_id'] = $savings['savings_id'];
				$savings_deposit_amounts_info[$savings['savings_id']]['member_id'] = $savings['member_id'];
				$savings_deposit_amounts_info[$savings['savings_id']]['member_primary_product_id'] = $savings['member_primary_product_id'];
				$savings_deposit_amounts_info[$savings['savings_id']]['saving_products_id'] = $savings['saving_products_id'];
				$savings_deposit_amounts_info[$savings['savings_id']]['branch_id'] = $savings['branch_id'];
				$savings_deposit_amounts_info[$savings['savings_id']]['samity_id'] = $savings['samity_id'];
				$savings_deposit_amounts_info[$savings['savings_id']]['transaction_date'] = $transaction_date;
				$savings_deposit_amounts_info[$savings['savings_id']]['transaction_type'] = 'INT';
				$savings_deposit_amounts_info[$savings['savings_id']]['mode_of_payment'] = 'SYS';
				$total_amount = $savings['total_amount_for_interest_calculate'] * ($savings['interest_rate']/100/12);
				$savings_deposit_amounts_info[$savings['savings_id']]['amount'] = $total_amount;
				$savings_deposit_amounts_info[$savings['savings_id']]['is_authorized'] = true;
			}
		}
		//print_r($savings_deposit_amounts_info);
		//die;
		return $savings_deposit_amounts_info;
		
	}
	
	function delete($date=null)
	{
        if(empty($date))
		{
			$this->session->set_flashdata('warning','Date is not provided');
			redirect('/process_month_ends/index/');
		}
		//Check wether the child data exists
        $last_day_branch_date = $this->Process_month_end->get_day_end_valid_deletable_date($this->get_branch_id());
        if($last_day_branch_date != $date)
        {
            $this->session->set_flashdata('warning', 'You must be entered a valid date.');
			redirect('/process_month_ends/index/');
        }
        else
        { 
            if($this->Process_month_end->delete($this->get_branch_id(),$date))
            {
               $this->get_current_date(true);
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/process_month_ends/index/');
            }
            
        }
	}
}

/* Location: ./system/application/controllers/welcome.php */
