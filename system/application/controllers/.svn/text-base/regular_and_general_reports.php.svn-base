<?php
/** 
	* REGULAR & GENERAL REPORT Controller Class.
	* @pupose		REGULAR & GENERAL REPORTs information
	*		
	* @filesource	./system/application/models/regular_and_general_reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.regular_and_general_reports
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Regular_and_general_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Regular_and_general_report','Report','Samity','Loan_product','Saving_product','Po_branch','Member','Config_holiday','Employee','Report_loan_data','Report_savings_data'),'',TRUE);	
		$this->Regular_and_general_report->loan_base_class = $this->Report_loan_data;	
		$this->Regular_and_general_report->savings_base_class = $this->Report_savings_data;
	}

	function index()
	{
		$data['headline'] = 'REGULAR & GENERAL REPORT LIST';		
		$this->layout->view('/regular_and_general_reports/index');
	}	
	//*******************************************************Component Wise Daily Collection Report*******************************************************
	function component_wise_daily_collection_report_index() 
	{
		$data = $this->_load_combo_data() ;
		$data['headline'] = 'Daily Collection Component Wise';	
		$data['title'] = 'Daily Collection Component Wise';			
		$this->layout->view('/regular_and_general_reports/component_wise_daily_collection_report_index',$data);		
	}
	//
	function ajax_component_wise_daily_collection_report() 
	{	
		if($_POST)
		{		
			$this->_prepare_validation();			
			$this->form_validation->set_rules('txt_date','Date','trim|xss_clean|required');	
			$data = $this->_get_posted_data();			
			if ($this->form_validation->run() === TRUE)
			{					
				$data['headline'] = 'Daily Collection Component Wise';	
				$data['title'] = 'Daily Collection Component Wise';
				$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);			
				$data['product'] = $this->Loan_product->get_selected_product_info($data['product_id']);
				$data['date']=$data['date'];				
				$data['savings_product_type'] = $this->Saving_product->get_savings_product_type_information();			
				$data['component_wise_daily_collection'] = $this->Regular_and_general_report->get_component_wise_daily_collection_report_data($data['branch_id'],$data['product_id'],$data['date']);
				//echo "<pre>";print_r($data['component_wise_daily_collection']);die;			
				//$this->layout->view('/regular_and_general_reports/component_wise_daily_collection_report',$data);
				$this->load->view('regular_and_general_reports/component_wise_daily_collection_report',$data);
			}	
			else{
				$data['errors'][]='Please enter proper branch, product and date';
				$this->load->view('/reports/report_message',$data);				
			}				
		}	
	}
	//*******************************************Branch Manager Report*********************************************
	function branch_manager_report_index() 
	{
		$data = $this->_load_combo_data() ;
		$data['headline'] = 'Branch Manager Report(Field Officer\'s And Component Wise)';	
		$data['title'] = 'Branch Manager Report(Field Officer\'s And Component Wise)';						
		$this->layout->view('/regular_and_general_reports/branch_manager_report_index',$data);		
	}	
	function ajax_branch_manager_report() 
	{		
		if($_POST)
		{			
			$this->_prepare_validation();	
			$data = $this->_get_posted_data();
			list($data['date_from'],$data['date_to']) =preg_split('[\sto\s]',$this->input->post('cbo_week_list'));
			$data['from']=$data['date_from'];
			$data['to']=$data['date_to'];
			$data['headline'] = 'Branch Manager Report(Field Officer\'s And Component Wise)';
			$data['title'] = 'Branch Manager Report(Field Officer\'s And Component Wise)';			
			//print_r($data);die;
			if ($this->form_validation->run() === TRUE)
			{
				$data ['last_date']= date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['date_to'])) . " +1 day"));				
				$data['branch_data'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
				//print_r($data['branch_data']);die;
				$data['branch_manager'] = $this->Regular_and_general_report->get_selected_branches_info_with_branch_manager($data['branch_id']);	
				//print_r($data['branch_manager']);die;				
				$data['product'] = $this->Loan_product->get_selected_product_info($data['product_id']);				
				//print_r($data['product']);die;			
				
				$data['branch_manager_report_data_beginning_week'] = $this->Regular_and_general_report->get_branch_manager_report_data($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']=null);
				//echo "<pre>";print_r($data['branch_manager_report_data_beginning_week'] );die;
				
				$data['branch_manager_report_data_for_this_week'] = $this->Regular_and_general_report->get_branch_manager_report_data($data['branch_id'],$data['product_id'],$data['date_from'],$data['to']);
				//echo "<pre>";print_r($data['branch_manager_report_data_for_this_week'] );				
				
				$data['branch_manager_report_data_end_week'] = $this->Regular_and_general_report->get_branch_manager_report_data($data['branch_id'],$data['product_id'],$data ['last_date'],$data['date_to']=null);				
				//echo "<pre>";print_r($data['branch_manager_report_data_end_week'] );die;
				
				//_beginning_week------------------------------------------------------------------------------------				
				$data['total_member_beginning_week']=0;
				$data['total_savings_beginning_week']=0;
				$data['total_cum_disbursement_no_beginning_week']=0;
				$data['total_cum_loan_amount_beginning_week']=0;
				$data['total_cum_fully_paid_loan_disbursement_no_beginning_week']=0;
				$data['total_cum_fully_paid_loan_amount_beginning_week']=0;
				$data['total_cum_exp_borrower_beginning_week']=0;
				$data['total_cum_exp_loan_amount_beginning_week']=0;
				$data['total_current_borrower_beginning_week']=0;
				$data['total_current_loan_amount_beginning_week']=0;
				$data['total_due_beginning_week']=0;
				$data['total_outstanding_beginning_week']=0;
				if(isset($data['branch_manager_report_data_beginning_week'])){
					foreach($data['branch_manager_report_data_beginning_week'] as $row)
					{
						$data['total_member_beginning_week']+=$row['member_no'];	
						$data['total_savings_beginning_week']+=$row['savings'];
						$data['total_cum_disbursement_no_beginning_week']+=$row['cum_disbursement_no'];
						$data['total_cum_loan_amount_beginning_week']+=$row['cum_loan_amount'];
						$data['total_cum_fully_paid_loan_disbursement_no_beginning_week']+=$row['cum_fully_paid_loan_disbursement_no'];
						$data['total_cum_fully_paid_loan_amount_beginning_week']+=$row['cum_fully_paid_loan_amount'];
						$data['total_cum_exp_borrower_beginning_week']+=$row['cum_exp_borrower'];
						$data['total_cum_exp_loan_amount_beginning_week']+=$row['cum_exp_loan_amount'];
						$data['total_current_borrower_beginning_week']+=$row['current_borrower'];
						$data['total_current_loan_amount_beginning_week']+=$row['current_loan_amount'];
						$data['total_due_beginning_week']+=$row['due'];
						$data['total_outstanding_beginning_week']+=$row['outstanding'];
					}		
				}
				//_between_week------------------------------------------------------------------------------------			
				$data['total_member_between_week']=0;
				$data['total_savings_between_week']=0;
				$data['total_cum_disbursement_no_between_week']=0;
				$data['total_cum_loan_amount_between_week']=0;
				$data['total_cum_fully_paid_loan_disbursement_no_between_week']=0;
				$data['total_cum_fully_paid_loan_amount_between_week']=0;
				$data['total_cum_exp_borrower_between_week']=0;
				$data['total_cum_exp_loan_amount_between_week']=0;
				$data['total_loan_recoverable_amount_between_week']=0;
				$data['total_transaction_amount_between_week']=0;
				$data['total_due_between_week']=0;
				$data['total_advance_between_week']=0;				
				$data['total_recovery_total_between_week']=0;
				$data['total_new_due_between_week']=0;
				if(isset($data['branch_manager_report_data_for_this_week'])){
					foreach($data['branch_manager_report_data_for_this_week'] as $row)
					{
						$data['total_member_between_week']+=$row['member_no'];	
						$data['total_savings_between_week']+=$row['savings'];
						$data['total_cum_disbursement_no_between_week']+=$row['cum_disbursement_no'];
						$data['total_cum_loan_amount_between_week']+=$row['cum_loan_amount'];
						$data['total_cum_fully_paid_loan_disbursement_no_between_week']+=$row['cum_fully_paid_loan_disbursement_no'];
						$data['total_cum_fully_paid_loan_amount_between_week']+=$row['cum_fully_paid_loan_amount'];
						$data['total_cum_exp_borrower_between_week']+=$row['cum_exp_borrower'];
						$data['total_cum_exp_loan_amount_between_week']+=$row['cum_exp_loan_amount'];
						$data['total_loan_recoverable_amount_between_week']+=$row['loan_recoverable_amount'];
						$data['total_transaction_amount_between_week']+=$row['transaction_amount'];
						$data['total_due_between_week']+=$row['due'];
						$data['total_advance_between_week']+=$row['advance'];
						$data['total_recovery_total_between_week']+=$row['recovery_total'];
						$data['total_new_due_between_week']+=$row['new_due'];
					}
				}
				//_end of the week------------------------------------------------------------------------------------
				$data['total_member_end_week']=0;
				$data['total_savings_end_week']=0;
				$data['total_cum_disbursement_no_end_week']=0;
				$data['total_cum_loan_amount_end_week']=0;
				$data['total_cum_fully_paid_loan_disbursement_no_end_week']=0;
				$data['total_cum_fully_paid_loan_amount_end_week']=0;
				$data['total_cum_exp_borrower_end_week']=0;
				$data['total_cum_exp_loan_amount_end_week']=0;
				$data['total_current_borrower_end_week']=0;
				$data['total_current_loan_amount_end_week']=0;
				$data['total_due_end_week']=0;
				$data['total_overdue_end_week']=0;
				$data['total_total_overdue_end_week']=0;
				$data['total_total_outstanding_end_week']=0;				
				if(isset($data['branch_manager_report_data_end_week'])){
					foreach($data['branch_manager_report_data_end_week'] as $row)
					{
						$data['total_member_end_week']+=$row['member_no'];	
						$data['total_savings_end_week']+=$row['savings'];
						$data['total_cum_disbursement_no_end_week']+=$row['cum_disbursement_no'];
						$data['total_cum_loan_amount_end_week']+=$row['cum_loan_amount'];
						$data['total_cum_fully_paid_loan_disbursement_no_end_week']+=$row['cum_fully_paid_loan_disbursement_no'];
						$data['total_cum_fully_paid_loan_amount_end_week']+=$row['cum_fully_paid_loan_amount'];
						$data['total_cum_exp_borrower_end_week']+=$row['cum_exp_borrower'];
						$data['total_cum_exp_loan_amount_end_week']+=$row['cum_exp_loan_amount'];
						$data['total_current_borrower_end_week']+=$row['current_borrower'];
						$data['total_current_loan_amount_end_week']+=$row['current_loan_amount'];
						$data['total_due_end_week']+=$row['due'];
						$data['total_overdue_end_week']+=$row['overdue'];
						$data['total_total_overdue_end_week']+=$row['total_overdue'];
						$data['total_total_outstanding_end_week']+=$row['total_outstanding'];
					}
				}
				//echo "<pre>";
				//print_r($data);die;
				$this->load->view('regular_and_general_reports/branch_manager_report',$data);
				//$this->layout->view('/regular_and_general_reports/branch_manager_report',$data);
			}	
			else{
				$data['errors'][]='Please enter proper branch,product,year,month and week';
				$this->load->view('/reports/report_message',$data);				
			}
		}				
	}
	/**
	 *  Get holiday list
	 *  @use branch_manager_report_index
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 31-Mar-2011
	*/
	function ajax_for_get_week_list() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$branch_id     = $this->input->post('branch_id');
		$year   	= $this->input->post('year');
		$month  	= $this->input->post('month');
		//print('<br>');print($branch_id);
		//print('<br>');print($year);
		//print('<br>');print($month);die;
		if(empty($branch_id)||empty($year)||empty($month))
        	{
            		$callback_message['status'] = 'failure';
            		$callback_message['message']= 'Missing Input';
        	}
		else
        	{
			$holiday_list = $this->Config_holiday->get_month_wise_holiday_list($branch_id,$year,$month);	
			if(empty($holiday_list))
			{
				$callback_message['status'] = 'failure';
            			$callback_message['message']= 'Missing holiday list';
			}
			else
			{
				$callback_message['status'] = 'success';
				$week_list = $this->Report->get_month_working_day_list($holiday_list,$year,$month);
				if(!empty($week_list)) {
				//print_r($week_list);die;
				foreach($week_list as $key=>$value) {
					
					$callback_message['week']['id'][]=$key;	  
					$callback_message['week']['name'][]=$value;	 
				}
				}
				else {
					$callback_message['status'] = 'failure';
		    			$callback_message['message']= 'No data found';           	
				}	  		 
			}
		}
		if( count($callback_message) != 0 )
	    	{
	        	echo json_encode($callback_message);
	    	}			  	
	} 
	//*********************************Field Worker's Report*******************************************************
	function field_worker_report_index() 
	{
		$data = $this->_load_combo_data() ;	
		$data['headline'] = 'Field Worker Report(Field Officer\'s And Component Wise)';		
		$data['title'] = 'Field Worker Report(Field Officer\'s And Component Wise)';		
		$this->layout->view('/regular_and_general_reports/field_worker_report_index',$data);		
	}	
	function ajax_field_worker_report() 
	{		
		if($_POST)
		{			
			$this->_prepare_validation();	
			$data = $this->_get_posted_data();
			
			list($data['date_from'],$data['date_to']) =preg_split('[\sto\s]',$this->input->post('cbo_week_list'));
			$data['headline'] = 'Field Worker Report(Field Officer\'s And Component Wise)';
			$data['title'] = 'Field Worker Report(Field Officer\'s And Component Wise)';		
			$data['d_date_from']=$data['date_from'];
			$data['d_date_to']=$data['date_to'];	
			//print_r($data);die;
			if ($this->form_validation->run() === TRUE)
			{
				$data['field_officer_info']=$this->Employee->read($data['employee_id']);
				//print_r($data['field_officer_info']);die;
								
				$date['last_date']= date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['date_to'])) . " +1 day"));	
				//print_r($date['last_date']);die;			
				$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
				$data['product'] = $this->Loan_product->get_selected_product_info($data['product_id']);				
				$data['branch_manager_report_data_beginning_week'] = $this->Regular_and_general_report->get_branch_field_officer_report_data($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']=null);	
				//echo "<pre>";print_r($data['branch_manager_report_data_beginning_week'] );die;
				$data['branch_manager_report_data_for_this_week'] = $this->Regular_and_general_report->get_branch_field_officer_report_data($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']);				
				//echo "<pre>";print_r($data['branch_manager_report_data_for_this_week'] );die;				
				$data['branch_manager_report_data_end_week'] = $this->Regular_and_general_report->get_branch_field_officer_report_data($data['branch_id'],$data['product_id'],$date ['last_date'],$data['date_to']=null);				
				//echo "<pre>";print_r($data['branch_manager_report_data_end_week'] );die;
				
				//_beginning_week------------------------------------------------------------------------------------				
				$data['total_member_beginning_week']=0;
				$data['total_savings_beginning_week']=0;
				$data['total_cum_disbursement_no_beginning_week']=0;
				$data['total_cum_loan_amount_beginning_week']=0;
				$data['total_cum_fully_paid_loan_disbursement_no_beginning_week']=0;
				$data['total_cum_fully_paid_loan_amount_beginning_week']=0;
				$data['total_cum_exp_borrower_beginning_week']=0;
				$data['total_cum_exp_loan_amount_beginning_week']=0;
				$data['total_current_borrower_beginning_week']=0;
				$data['total_current_loan_amount_beginning_week']=0;
				$data['total_due_beginning_week']=0;
				$data['total_outstanding_beginning_week']=0;
				foreach($data['branch_manager_report_data_beginning_week'] as $row)
				{
					$data['total_member_beginning_week']+=$row['member_no'];	
					$data['total_savings_beginning_week']+=$row['savings'];
					$data['total_cum_disbursement_no_beginning_week']+=$row['cum_disbursement_no'];
					$data['total_cum_loan_amount_beginning_week']+=$row['cum_loan_amount'];
					$data['total_cum_fully_paid_loan_disbursement_no_beginning_week']+=$row['cum_fully_paid_loan_disbursement_no'];
					$data['total_cum_fully_paid_loan_amount_beginning_week']+=$row['cum_fully_paid_loan_amount'];
					$data['total_cum_exp_borrower_beginning_week']+=$row['cum_exp_borrower'];
					$data['total_cum_exp_loan_amount_beginning_week']+=$row['cum_exp_loan_amount'];
					$data['total_current_borrower_beginning_week']+=$row['current_borrower'];
					$data['total_current_loan_amount_beginning_week']+=$row['current_loan_amount'];
					$data['total_due_beginning_week']+=$row['due'];
					$data['total_outstanding_beginning_week']+=$row['outstanding'];
				}				
				//_between_week------------------------------------------------------------------------------------			
				$data['total_member_between_week']=0;
				$data['total_savings_between_week']=0;
				$data['total_cum_disbursement_no_between_week']=0;
				$data['total_cum_loan_amount_between_week']=0;
				$data['total_cum_fully_paid_loan_disbursement_no_between_week']=0;
				$data['total_cum_fully_paid_loan_amount_between_week']=0;
				$data['total_cum_exp_borrower_between_week']=0;
				$data['total_cum_exp_loan_amount_between_week']=0;
				$data['total_loan_recoverable_amount_between_week']=0;
				$data['total_transaction_amount_between_week']=0;
				$data['total_due_between_week']=0;
				$data['total_advance_between_week']=0;				
				$data['total_recovery_total_between_week']=0;
				$data['total_new_due_between_week']=0;
				foreach($data['branch_manager_report_data_for_this_week'] as $row)
				{
					$data['total_member_between_week']+=$row['member_no'];	
					$data['total_savings_between_week']+=$row['savings'];
					$data['total_cum_disbursement_no_between_week']+=$row['cum_disbursement_no'];
					$data['total_cum_loan_amount_between_week']+=$row['cum_loan_amount'];
					$data['total_cum_fully_paid_loan_disbursement_no_between_week']+=$row['cum_fully_paid_loan_disbursement_no'];
					$data['total_cum_fully_paid_loan_amount_between_week']+=$row['cum_fully_paid_loan_amount'];
					$data['total_cum_exp_borrower_between_week']+=$row['cum_exp_borrower'];
					$data['total_cum_exp_loan_amount_between_week']+=$row['cum_exp_loan_amount'];
					$data['total_loan_recoverable_amount_between_week']+=$row['loan_recoverable_amount'];
					$data['total_transaction_amount_between_week']+=$row['transaction_amount'];
					$data['total_due_between_week']+=$row['due'];
					$data['total_advance_between_week']+=$row['advance'];
					$data['total_recovery_total_between_week']+=$row['recovery_total'];
					$data['total_new_due_between_week']+=$row['new_due'];
				}
				
				//_end of the week------------------------------------------------------------------------------------
				$data['total_member_end_week']=0;
				$data['total_savings_end_week']=0;
				$data['total_cum_disbursement_no_end_week']=0;
				$data['total_cum_loan_amount_end_week']=0;
				$data['total_cum_fully_paid_loan_disbursement_no_end_week']=0;
				$data['total_cum_fully_paid_loan_amount_end_week']=0;
				$data['total_cum_exp_borrower_end_week']=0;
				$data['total_cum_exp_loan_amount_end_week']=0;
				$data['total_current_borrower_end_week']=0;
				$data['total_current_loan_amount_end_week']=0;
				$data['total_due_end_week']=0;
				$data['total_overdue_end_week']=0;
				$data['total_total_overdue_end_week']=0;
				$data['total_total_outstanding_end_week']=0;				
				foreach($data['branch_manager_report_data_end_week'] as $row)
				{
					$data['total_member_end_week']+=$row['member_no'];	
					$data['total_savings_end_week']+=$row['savings'];
					$data['total_cum_disbursement_no_end_week']+=$row['cum_disbursement_no'];
					$data['total_cum_loan_amount_end_week']+=$row['cum_loan_amount'];
					$data['total_cum_fully_paid_loan_disbursement_no_end_week']+=$row['cum_fully_paid_loan_disbursement_no'];
					$data['total_cum_fully_paid_loan_amount_end_week']+=$row['cum_fully_paid_loan_amount'];
					$data['total_cum_exp_borrower_end_week']+=$row['cum_exp_borrower'];
					$data['total_cum_exp_loan_amount_end_week']+=$row['cum_exp_loan_amount'];
					$data['total_current_borrower_end_week']+=$row['current_borrower'];
					$data['total_current_loan_amount_end_week']+=$row['current_loan_amount'];
					$data['total_due_end_week']+=$row['due'];
					$data['total_overdue_end_week']+=$row['overdue'];
					$data['total_total_overdue_end_week']+=$row['total_overdue'];
					$data['total_total_outstanding_end_week']+=$row['total_outstanding'];
				}				
				$this->load->view('regular_and_general_reports/field_worker_report',$data);
				//$this->layout->view('/regular_and_general_reports/field_worker_report',$data);
			}	
			else{
				$data['errors'][]='Please enter proper branch,field officer,product,year,month and week';
				$this->load->view('/reports/report_message',$data);					
			}
		}				
	}

	//*************************************************Samity Wise Monthly Loan & Saving Collection Sheet*******************************************************
	function samity_wise_monthly_loan_and_savings_collection_sheet_index()
	{	
		$data = $this->_load_combo_data();
		$data['headline'] = 'Samity Wise Monthly Loan & Saving Collection Sheet';
		$data['title'] = 'Samity Wise Monthly Loan & Saving Collection Sheet';		
		$this->layout->view('/regular_and_general_reports/samity_wise_monthly_loan_and_savings_collection_sheet_reports/samity_wise_monthly_loan_and_savings_collection_sheet_index',$data);
	}		
	function ajax_samity_wise_monthly_loan_and_savings_collection_sheet_reports()
	{
		$this->_prepare_validation();		
		$this->form_validation->set_rules('cbo_samity','Samity','trim|xss_clean|numeric|required');
		$this->form_validation->set_rules('cbo_month','Month','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_year','Year','trim|xss_clean|required');	
		$data = $this->_get_posted_data();			
		$data['headline'] = 'Samity Wise Monthly Loan & Saving Collection Sheet';
		$data['title'] = 'Samity Wise Monthly Loan & Saving Collection Sheet';	
		//print_r($data);die;		
		//Perform the Validation		
		if ($this->form_validation->run() === TRUE)
		{			
			$report_header_infos = $this->Samity->get_branch_samity_field_officer_info_by_samity_id_report($data['samity_id']);
			// page title			
			//$data['title'] = "{$report_header_infos[0]->samity_name} ({$report_header_infos[0]->samity_code}) Monthly Loan & Saving Collection Sheet";
			//echo "<pre>";print_r($data['title']);die;
			$data['report_header_info'] = (array)$report_header_infos[0];			
			$data['report_header_info']['report_month'] = date("F, Y", mktime(0, 0, 0, $data['month_name'], 1, $data['year_name']));			
			$data['report_header_info']['samity_day']  =  $this->Report->get_samity_day_info($data['samity_day']);			
			$data['report_header_info']['product_mnemonic'] = $this->Loan_product->get_selected_product_info($data['product_id']);			
			$data['report_header_info']['print_date']  =  date('Y-m-d');
			//print_r($data['samity_id']);print('taposhi0');die;
			//print('<br>');
			$active_members = $this->Member->get_active_member_list_by_samity_id_csv($data['samity_id']);
			//print_r($active_members);die; 
			$data['savings_collection_data'] = $this->Regular_and_general_report->get_samity_wise_monthly_savings_collection_report_data($active_members,$data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);
			//echo "<pre>";print_r($data['savings_collection_data']);die; 
			$data['cancellation_member_skt_amount'] = $this->Regular_and_general_report->get_cancellation_member_skt_amount($data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);			
			//echo "<pre>";print_r($data['cancellation_member_skt_amount']);die; 
			$data['loan_collection_data'] = $this->Regular_and_general_report->get_samity_wise_monthly_loan_collection_report_data($active_members,$data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);
			//echo "<pre>";print_r($data['loan_collection_data']);die;
 
			$data['holiday_list'] = $this->Config_holiday->get_samity_wise_monthly_holiday_list($data['samity_id'],$data['branch_id'],$data['year_name'],$data['month_name']);
			//echo "<pre>";print_r($data['holiday_list']); 
			$data['working_list'] = $this->Report->get_monthly_regular_working_day_list($data['year_name'],$data['month_name'],$data['samity_day']);		
			//echo "<pre>";print_r($data['working_list']);die; 
			//$this->layout->view('/regular_and_general_reports/samity_wise_monthly_loan_and_savings_collection_sheet_reports/samity_wise_monthly_loan_and_savings_collection_sheet_report',$data);
			$this->load->view('regular_and_general_reports/samity_wise_monthly_loan_and_savings_collection_sheet_reports/samity_wise_monthly_loan_and_savings_collection_sheet_report',$data);
		} else {
			$data['errors'][]='Please enter proper branch,field officer,product,year,month and week';
			$this->load->view('/reports/report_message',$data);	
		}
	}
	//*************************************************Samity Wise Monthly Loan & Saving Working Sheet*******************************************************
	function samity_wise_monthly_loan_and_savings_working_sheet_index()
	{	
		$data = $this->_load_combo_data();
		$data['headline'] = 'Samity Wise Monthly Loan & Saving Working Sheet';
		$data['title'] = 'Samity Wise Monthly Loan & Saving Working Sheet';		
		$this->layout->view('/regular_and_general_reports/samity_wise_monthly_loan_and_savings_working_sheet_reports/samity_wise_monthly_loan_and_savings_working_sheet_index',$data);
	}	
	function ajax_samity_wise_monthly_loan_and_savings_working_sheet_reports()
	{
		//$this->output->enable_profiler(TRUE);		
		$this->_prepare_validation();		
		$this->form_validation->set_rules('cbo_samity','Samity','trim|xss_clean|numeric|required');
		$this->form_validation->set_rules('cbo_month','Month','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_year','Year','trim|xss_clean|required');	
		$data = $this->_get_posted_data();		
		$data['headline'] = 'Samity Wise Monthly Loan & Saving Working Sheet';
		$data['title'] = 'Samity Wise Monthly Loan & Saving Working Sheet';
		//Perform the Validation
		if ($this->form_validation->run() === TRUE)
		{
			$report_header_infos = $this->Samity->get_branch_samity_field_officer_info_by_samity_id_report($data['samity_id']);
			// page title
			//$data['title'] = "{$report_header_infos[0]->samity_name} ({$report_header_infos[0]->samity_code}) Monthly Loan & Saving Collection Sheet";		
			$data['report_header_info'] = (array)$report_header_infos[0];			
			$data['report_header_info']['report_month'] = date("F, Y", mktime(0, 0, 0, $data['month_name'], 1, $data['year_name']));			
			$data['report_header_info']['samity_day']  =  $this->Report->get_samity_day_info($data['samity_day']);			
			$data['report_header_info']['product_mnemonic'] = $this->Loan_product->get_selected_product_info($data['product_id']);	
			$data['report_header_info']['print_date']  =  date('Y-m-d');			
			//echo "<pre>";print_r($data['report_header_info']);die;
			$active_members = $this->Member->get_active_member_list_by_samity_id_csv($data['samity_id']);
			
			//$data['savings_collection_data'] = $this->Regular_and_general_report->get_samity_wise_monthly_savings_collection_report_data($active_members,$data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);
			
			//$data['loan_collection_data'] = $this->Regular_and_general_report->get_samity_wise_monthly_loan_collection_report_data($active_members,$data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);
			
			$data['holiday_list'] = $this->Config_holiday->get_samity_wise_monthly_holiday_list($data['samity_id'],$data['branch_id'],$data['year_name'],$data['month_name']);
			
			$data['working_list'] = $this->Report->get_monthly_regular_working_day_list($data['year_name'],$data['month_name'],$data['samity_day']);
			$data['cancellation_member_skt_amount'] = $this->Regular_and_general_report->get_cancellation_member_skt_amount($data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);	
			$data['loan_saving_collection_data'] = $this->Regular_and_general_report->get_samity_wise_monthly_loan_saving_worksheet_report_data($active_members,$data['samity_id'],$data['report_date'],$data['branch_id'],$data['product_id']);
			//print_r($data);
			//die;
			//$this->layout->view('/regular_and_general_reports/samity_wise_monthly_loan_and_savings_working_sheet_reports/samity_wise_monthly_loan_and_savings_working_sheet_report',$data);
			$this->load->view('regular_and_general_reports/samity_wise_monthly_loan_and_savings_working_sheet_reports/samity_wise_monthly_loan_and_savings_working_sheet_report',$data);
		} else {
			$data['errors'][]='Please enter proper branch,field officer,product,year,month and week';
			$this->load->view('/reports/report_message',$data);	
		}
	}
	/*
	function field_officer_wise_loan_index()
	{	
		$data = $this->_load_combo_data();
		$data['headline'] = 'Loan Report (Field Officer Wise)';
		$data['title'] = 'Loan Report (Field Officer Wise)';		
		$this->layout->view('/regular_and_general_reports/field_officer_wise_loan_reports/field_officer_wise_loan_index',$data);
	}	
	function field_officer_wise_loan_reports()
	{
		//$this->output->enable_profiler(TRUE);
		
		$this->_prepare_validation();
		
		$data = $this->_get_posted_data();
		
		$data['headline'] = 'Loan Report (Field Officer Wisw)';
		$data['title'] = 'Loan Report (Field Officer Wisw)';
		//Perform the Validation
		if (TRUE === TRUE)
		{
			
			$data['report_header_info']['print_date']  =  date('Y-m-d');
			$da = $this->Report_loader_saving->get_savings_information($data['from_date'],$data['to_date']);
			//print_r($da);
			//die;		
			$data['officer_wise_loan_info'] = $this->Regular_and_general_report->get_field_officer_wise_loan_report();
			//print_r($data['officer_wise_loan_info']);
			$this->layout->view('/regular_and_general_reports/field_officer_wise_loan_reports/field_officer_wise_loan_reports',$data);
		} else {
			$data = $this->_load_combo_data();
			$this->layout->view('/regular_and_general_reports/field_officer_wise_loan_reports/field_officer_wise_loan_index',$data);
		}
	}
	*/
	// *****************************************Loan Report (Field Officer Wise)****************************************************************************
	function loan_field_officer_wise_index()
	{			
		$data = $this->_load_combo_data();
		$data['title'] = $data['headline'] = 'Loan Report (Field Officer Wise)';	
		$this->layout->view('/regular_and_general_reports/loan_field_officer_wise_index',$data);
	}	
	function ajax_loan_field_officer_wise()
	{	
		$this->_prepare_validation();	
		$data = $this->_get_posted_data();
		//print_r($data);
		$data['title'] = $data['headline'] = 'Loan Report (Field Officer Wise)';	
		//Perform the Validation
		if ($this->form_validation->run() === TRUE)
		{
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$data['loan_field_officer_wise_info'] = $this->Regular_and_general_report->get_loan_field_officer_wise_information($data['branch_id'],$data['from_date'],$data['to_date'],$data['product_id']);
			//$data['admission_register_total_information'] = $this->Register_report->get_admission_register_total_information($data['branch_id'],$data['date_from'],$data['date_to']);	
			$this->load->view('/regular_and_general_reports/loan_field_officer_wise',$data);
		} else {
			$data['errors'][]='Please enter proper branch, date from, date to and product';
			$this->load->view('/reports/report_message',$data);
		}
	}
	//
	// *****************************************Loan Classification & DMR Report****************************************************************************
	function loan_classification_and_dmr_index()
	{			
		$data = $this->_load_combo_data();
		$data['title'] = $data['headline'] = 'Loan Classification & DMR Report';	
		$this->layout->view('/regular_and_general_reports/loan_classification_and_dmr_index',$data);
	}	
	function ajax_loan_classification_and_dmr()
	{	
		$this->_prepare_validation_loan_classification_drm();	
		$data = $this->_get_posted_data();
		//print_r($data);
		$data['title'] = $data['headline'] = 'Loan Classification & DMR Report';	
		//Perform the Validation
		if ($this->form_validation->run() === TRUE)
		{
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$data['year_name'] = $year = $data['year_name'];
			$data['month_name'] = $month = $data['month_name'];
			$pre_date = date("Y-m-d",strtotime("-1 day",strtotime("$year-$month-01")));
			$pre_dates = explode('-',$pre_date);
			$pre_year = $pre_dates[0];
			$pre_month = $pre_dates[1];
			$data['loan_field_officer_wise_info'] = $this->Regular_and_general_report->get_loan_classification_and_dmr($data['branch_id'],$year,$month,$pre_year,$pre_month);
			$this->load->view('/regular_and_general_reports/loan_classification_and_dmr',$data);			
		} else {
			$data['errors'][]='Please enter proper branch, Month and Year.';
			$this->load->view('/reports/report_message',$data);
		}
	}
	//
	function _prepare_validation()
	{					
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_branch','Branch','trim|xss_clean|numeric|required');			
		$this->form_validation->set_rules('cbo_product','Product','trim|xss_clean|numeric|required');	
		//$this->form_validation->set_rules('txt_date_from','Date From','trim|xss_clean|required|is_date');
		//$this->form_validation->set_rules('txt_date_to','Date To','trim|xss_clean|required|is_date');					
	}
	
	function _prepare_validation_loan_classification_drm()
	{					
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_branch','Branch','trim|xss_clean|numeric|required');		
		$this->form_validation->set_rules('cbo_month','Month','trim|xss_clean|required');	
		$this->form_validation->set_rules('cbo_year','Year','trim|xss_clean|required');					
	}
	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		$data['samity_day']=$this->input->post('cbo_samity_day');	
		$data['branch_id']=$this->input->post('cbo_branch');
		$data['samity_id']=$this->input->post('cbo_samity');	
		$data['product_id']=$this->input->post('cbo_product');	
		$data['date']=$this->input->post('txt_date');	
		$data['month_name']=$this->input->post('cbo_month');
		$data['year_name']=$this->input->post('cbo_year');
		$data['report_date']= $this->input->post('cbo_year').'-'.$this->input->post('cbo_month').'-01';		
		$data['employee_id']=$this->input->post('cbo_employee');
		$data['from_date']=$this->input->post('txt_date_from');
		$data['to_date']=$this->input->post('txt_date_to');	
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data($cond = array())
	{
		$branch_id = isset($cond['branch_id'])?(!empty($cond['branch_id'])?$cond['branch_id']:"-1"):"-1";			
		$data['branch_info'] = $this->Po_branch->get_branches_info();	
		$data['samities_info'] = $this->Samity->get_samity_list_by_branch($branch_id);
		$data['products_info'] = $this->Loan_product->get_product_info();
		$data['employee_list'] = $this->Employee->get_field_officer_info();
		$data['months_info'] = $this->Report->get_months();
		$data['year_info'] = $this->Report->get_year_range();
		$data['samity_day_info'] = $this->Report->get_samity_days();		
		return $data;
	}		
}
