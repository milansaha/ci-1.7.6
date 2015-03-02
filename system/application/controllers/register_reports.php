<?php
/** 
	* REGISTER REPORT - (BRANCH LEVEL) Controller Class.
	* @pupose		REGISTER REPORT - (BRANCH LEVEL) information
	*		
	* @filesource	./system/application/models/register_reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.register_reports
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Register_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Register_report','Report','Samity','Saving','Loan_product','Member','Po_branch'),'',TRUE);	
		//if(PROFILER) $this->output->enable_profiler(TRUE);			
	}	
	function index()
	{
		$data['headline'] = 'REGISTER REPORT LIST';		
		$this->layout->view('/register_reports/index',$data);
	}
	// *****************************************Admission Resister Report****************************************************************************
	function admission_register_index()
	{	
		
		$data = $this->_load_combo_data();
		$data['headline'] = 'Admission Resister Report';
		$data['title'] = 'Admission Resister Report';		
		$this->layout->view('/register_reports/admission_register_index',$data);
	}	
	function ajax_admission_register()
	{	
		$data = $this->_get_posted_data();
		$data['headline'] = 'Admission Resister Report';
		$data['title'] = 'Admission Resister Report';
		if(empty($data['branch_id']) || empty($data['date_from']) || empty($data['date_to']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{			
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$data['date_from']=$data['date_from'];	
			$data['date_to']=$data['date_to'];
			$data['admission_register_information'] = $this->Register_report->get_admission_register_information($data['branch_id'],$data['date_from'],$data['date_to']);
			$data['admission_register_total_information'] = $this->Register_report->get_admission_register_total_information($data['branch_id'],$data['date_from'],$data['date_to']);	
			$this->load->view('/register_reports/admission_register',$data);
		}
	}
	// ***************************************Loan Disbursement Register/Master Roll****************************************************************************
	function loan_disbursement_master_report_index()
	{			
		$data = $this->_load_combo_data();
		$data['headline'] = 'Loan Disbursement Register/Master Roll';
		$data['title'] = 'Loan Disbursement Register/Master Roll';
		$this->layout->view('/register_reports/loan_disbursement_master_report_index',$data);
	}	
	function ajax_loan_disbursement_master_report()
	{
		$data = $this->_get_posted_data();
		$data['headline'] = 'Loan Disbursement Register/Master Roll';
		$data['title'] = 'Loan Disbursement Register/Master Roll';
		if(empty($data['branch_id']) || empty($data['product_id']) || empty($data['date_from']) || empty($data['date_to']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{			
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$data['date_from']=$data['date_from'];	
			$data['date_to']=$data['date_to'];
			//print_r($data);die;
			$data['product'] = $this->Loan_product->get_selected_product_info($data['product_id']);
			$data['loan_disbursement_information'] = $this->Register_report->get_loan_disbursement_information($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']);
			$data['loan_disbursement_total'] = $this->Register_report->get_loan_disbursement_total($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']);			
			$this->load->view('/register_reports/loan_disbursement_master_report',$data);
		}		
	}	
	// ***************************************************Fully Paid Loan Register****************************************************************************	
	function fully_paid_loan_register_index()
	{	
		$data = $this->_load_combo_data();
		$data['headline'] = 'Fully Paid Loan Register';
		$data['title'] = 'Fully Paid Loan Register';
		$this->layout->view('/register_reports/fully_paid_loan_register_index',$data);
	}	
	//
	function ajax_fully_paid_loan_register_report()
	{
		$data = $this->_get_posted_data();
		$data['headline'] = 'Fully Paid Loan Register';
		$data['title'] = 'Fully Paid Loan Register';
		if(empty($data['branch_id']) || empty($data['product_id']) || empty($data['date_from']) || empty($data['date_to']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$data['date_from']=$data['date_from'];	
			$data['date_to']=$data['date_to'];
			//print_r($data);die;
			$data['product'] = $this->Loan_product->get_selected_product_info($data['product_id']);
			$data['fully_paid_loan_register_information'] = $this->Register_report->get_fully_paid_loan_register($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']);
			$data['total_fully_paid_loan_register_information'] = $this->Register_report->get_total_fully_paid_loan($data['branch_id'],$data['product_id'],$data['date_from']);
			$this->load->view('/register_reports/fully_paid_loan_register_report',$data);
		}
	}
	//********************************************************Cancellation Register****************************************************************************
	function member_cancellation_register_index()
	{	
		$data = $this->_load_combo_data();
		$data['headline'] = 'Cancellation Register';
		$data['title'] = 'Cancellation Register';
		$this->layout->view('/register_reports/member_cancellation_register_index',$data);
	}	
	function ajax_member_cancellation_register_report()
	{
		$data = $this->_get_posted_data();
		$data['headline'] = 'Cancellation Register';
		$data['title'] = 'Cancellation Register';
		if(empty($data['branch_id']) || empty($data['date_from']) || empty($data['date_to']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$data['date_from']=$data['date_from'];	
			$data['date_to']=$data['date_to'];
			//print_r($data);die;
			$data['member_cancellation_register_information'] = $this->Register_report->get_cancellation_register($data['branch_id'],$data['date_from'],$data['date_to']);
			$data['cancel_register_total_information'] = $this->Register_report->get_cancellation_register_total_information($data['branch_id'],$data['date_from'],$data['date_to']);
			$this->load->view('/register_reports/member_cancellation_register',$data);
		}
	}
	// **************************************** savings refund register **************************************
	function savings_refund_register_report_index()
	{
		$data = $this->_load_combo_data();
		$data['headline'] = 'Savings Refund Register';
		$data['title'] = 'Savings Refund Register';
		$this->layout->view('/register_reports/savings_refund_register_report_index',$data);
	}
	
	function ajax_savings_refund_register()
	{
		$data = $this->_get_posted_data();
		$data['headline'] = 'Savings Refund Register';
		$data['title'] = 'Savings Refund Register';
		if(empty($data['branch_id']) || empty($data['date_from']) || empty($data['date_to']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{
                    $data['date_from'] = $data['date_from'];
                    $data['date_to'] = $data['date_to'];
                    $data['branch_id'] = $data['branch_id'];
                    $data['product_id'] = $data['product_id'];
                    $data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);
                    $data['savings_general_info'] = $this->Register_report->get_savings_refund_register_general_info($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']);
                    //$data['total_savings_refund_register_amount_info'] = $this->Register_report->get_savings_refund_register_amount_info($data['branch_id'],$data['product_id'],$data['date_from'],$data['date_to']);
                    //$this->layout->view('/register_reports/savings_refund_register',$data);
                    $this->load->view('/register_reports/savings_refund_register',$data);
                }
	}
	// ************** ************** ************ ***************** ******************* ****************
	// ************** ************** ************ ***************** ******************* ****************
	//Report Generation - member_wise_subsidy_loan_saving_ledger_index
	function member_wise_subsidy_loan_saving_ledger_index()
	{
		$data = $this->_load_combo_data();	
		$data['headline'] = 'Member Wise Subsidiary Loan and Savings Ledger';	
		$data['title'] = 'Member Wise Subsidiary Loan and Savings Ledger';	
		$data['members_info'] = $this->Member->get_member_list_by_branch();		
		$this->layout->view('/register_reports/member_wise_subsidy_loan_saving_ledger_index',$data);
	}
	
	//Report Generation - member_wise_subsidy_loan_saving_ledger_index
	function ajax_member_wise_subsidy_loan_saving_ledger_report()
	{
		$data = $this->_get_posted_data();
		$data['headline'] = 'Member Wise Subsidiary Loan and Savings Ledger';	
		$data['title'] = 'Member Wise Subsidiary Loan and Savings Ledger';			
		if(empty($data['product_id']) || empty($data['cbo_month']) || empty($data['cbo_year']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{
                    $branch_id = $data['branch_id'];
                    $samity_id = $data['cbo_samity_id'];
                    $member_id = $data['cbo_member_id'];
                    $month = $data['cbo_month'];
                    $year = $data['cbo_year'];
                    $data['get_samity_branch_loan_init_info'] = $this->Register_report->get_samity_branch_loan_init_info($branch_id,$samity_id,$member_id,$month,$year);
                    $data['get_loan_transaction_info'] = $this->Register_report->get_loan_transaction_information($branch_id,$samity_id,$member_id,$month, $year);
                    $data['get_holiday_info'] = $this->Register_report->get_holiday_info($branch_id,$samity_id,$month,$year);
                    $data['get_savings_transaction_info'] = $this->Register_report->get_savings_transaction_information($branch_id,$samity_id,$member_id,$month, $year);
                    $data['get_loan_schedule_info'] = $this->Register_report->get_loan_schedule_information($branch_id,$samity_id,$member_id,$month,$year);
                    $this->load->view('/register_reports/member_wise_subsidy_loan_saving_ledger_report',$data);
                }
	}
	
	
	/*//----------------------------------------------------------------------------------------
	function samity_wise_monthly_loan_and_savings_working_sheet_index()
	{	
		$data['headline'] = 'Samity Wise Monthly Loan And Savings Working Sheet';
		$data = $this->_load_combo_data();
		$this->layout->view('/samity_wise_monthly_loan_and_savings_working_sheet_reports/samity_wise_monthly_loan_and_savings_working_sheet_index',$data);
	}	
	//
	function samity_wise_monthly_loan_and_savings_working_sheet_reports()
	{
		$data = $this->_get_posted_data();
		$this->layout->view('/samity_wise_monthly_loan_and_savings_working_sheet_reports/samity_wise_monthly_loan_and_savings_working_sheet_index');
	}
	//
	function member_wise_subsidy_loan_saving_ledger_index()
	{
		$data['headline'] = 'Member Wise Subsidiary Loan and Savings Ledger';	
		$data = $this->_load_combo_data();	
		$data['members_info'] = $this->Member->get_member_info();		
		$this->layout->view('/member_wise_subsidy_loan_saving_ledger_reports/index',$data);
	}
	
	//Report Generation
	function member_wise_subsidy_loan_saving_ledger_report()
	{		
		$data = $this->_get_posted_data();
		$this->layout->view('/member_wise_subsidy_loan_saving_ledger_reports/member_wise_subsidy_loan_saving_ledger_report',$data);		
	}
	
	//
	function member_cancellation_index()
	{
		$data['headline'] = 'Member Wise Subsidiary Loan and Savings Ledger';		
		$data['branches_info'] = $this->Po_Branch->get_branches_info();		
		$this->layout->view('/member_cancellation_reports/member_cancellation_index',$data);
	}
	//Report Generation
	function member_cancellation_report()
	{		
		$data = $this->_get_posted_data();
		$this->layout->view('/member_cancellation_reports/member_cancellation_report',$data);		
	}
	//
	function balancing_register_member_wise_index()
	{
		$data['headline'] = 'Balancing Register Member Wise';	
		$data = $this->_load_combo_data();	
		$data['branches_info'] = $this->Po_Branch->get_branches_info();		
		$this->layout->view('/branch_wise_consolidated_balancing_register_reports/branch_wise_consolidated_balancing_register_index',$data);
	}
	//Report Generation
	function balancing_register_member_wise_report()
	{		
		$data = $this->_get_posted_data();
		$this->layout->view('/branch_wise_consolidated_balancing_register_reports/branch_wise_consolidated_balancing_register_report',$data);		
	}	
	*/
	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		$data['branch_id']=$this->input->post('cbo_branch');
		$data['product_id']=$this->input->post('cbo_product');
		$data['date_from']=$this->input->post('txt_date_from');
		$data['date_to']=$this->input->post('txt_date_to');
		$data['cbo_samity_id']=$this->input->post('cbo_samity_id');
		$data['cbo_member_id']=$this->input->post('cbo_member_id');
		$data['cbo_month']=$this->input->post('cbo_month');
		$data['cbo_year']=$this->input->post('cbo_year');
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data() 
	{			
		$data['branch_info'] = $this->Po_branch->get_branches_info();		
		$data['samities_info'] = $this->Samity->get_samities();
		$data['products_info'] = $this->Loan_product->get_product_info();		
		$data['savings_products_info'] = $this->Saving->get_saving_products_list();	
		//echo '<pre>';print_r($data['savings_products_info']);
		$data['months_info'] = $this->Report->get_months();
		$data['year_info'] = $this->Report->get_year_range();
		$data['samity_day_info'] = $this->Report->get_samity_days();		
		return $data;
	}	
}
