<?php
/** 
	* Report Loan Data Model Class.
	* @pupose		Get Report loan information
	*		
	* @filesource	./system/application/models/report_loan_data.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.report_loan_data
	* @version      $Revision: 1 $
	* @author       $Author: S. Taposhi Rabeya $	
	* @lastmodified $Date: 2011-03-22 $	 
*/ 
class Report_loan_data extends Model {

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->model(array('Saving_product'));  
		$this->load->library('Scheduler1',null,"scheduler");
		//$this->load->library('Scheduler1');
	}
	
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_loan_disburse_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->db->query("SELECT samity_id,SUM(loan_amount) as loan_disburse_amount
							FROM loans 
							WHERE branch_id=$branch_id AND product_id=$product_id AND disburse_date='$date' AND is_authorized=1 AND is_loan_fully_paid=0
							AND loans.current_status=1 GROUP BY samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]=$query->loan_disburse_amount;
		}		
		return $data;
	}
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_loan_recoverable_amount($branch_id=null,$product_id=null,$date=null)
	{		
		/*$query=$this->db->query("SELECT loan_schedules.samity_id,SUM(loan_schedules.installment_amount) AS recoverable_amount
							FROM loan_schedules JOIN loans ON loan_schedules.loan_id=loans.id
							WHERE loan_schedules.branch_id=$branch_id
							AND loan_schedules.schedule_date='$date'
							AND loans.product_id=$product_id
							AND loans.current_status=1
							GROUP BY loan_schedules.samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]=$query->recoverable_amount;
		}		
		return $data;*/
		$this->scheduler->get_loan_schedules();
		return $this->scheduler->get_loan_recoverable_amount($branch_id,$product_id,$date);
	}
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_loan_due_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->db->query("SELECT samity_id,SUM(due_collection_amount) as due_collection_amount
							FROM loan_due_collection_register
							WHERE branch_id=$branch_id AND transaction_date='$date' AND product_id=$product_id
							GROUP BY samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]=$query->due_collection_amount;
		}		
		return $data;		
	}
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_loan_advance_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->db->query("SELECT samity_id,SUM(advance_collection_amount) as advance_collection_amount
							FROM loan_advance_collection_register
							WHERE branch_id=$branch_id AND transaction_date='$date' AND product_id=$product_id
							GROUP BY samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]=$query->advance_collection_amount;
		}		
		return $data;
	}
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_loan_transaction_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->db->query("SELECT samity_id,SUM(transaction_principal_amount) AS principal_amount,SUM(transaction_interest_amount) AS interest_amount
							FROM loan_transactions
							WHERE branch_id=$branch_id AND transaction_date='$date' AND product_id=$product_id
							GROUP BY samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]['principal_amount']=$query->principal_amount;
			$data[$query->samity_id]['interest_amount']=$query->interest_amount;
		}		
		return $data;
	}
	/**
	 * samity_wise_monthly_loan_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_loan_collection_report_data
	function get_active_member_loan_info($member_list,$date,$branch_id,$samity_id,$product_id)
	{		
		$query=$this->db->query("SELECT loans.id,loans.member_id,loans.disburse_date,loans.cycle
									,loan_purposes.code AS loan_purpose_code,loans.loan_amount,loans.total_payable_amount,loans.installment_amount
									,IFNULL(SUM(loan_transactions.transaction_amount),0.00) AS total_transaction_amount
									,IFNULL(loans.total_payable_amount-IFNULL(SUM(loan_transactions.transaction_amount),0.00),0.00) AS loan_outstanding
								FROM loans 
								JOIN loan_purposes ON loan_purposes.id=loans.purpose_id 
								LEFT JOIN loan_transactions ON loans.id=loan_transactions.loan_id 
									AND loan_transactions.branch_id=$branch_id AND loan_transactions.samity_id = $samity_id 
									AND loan_transactions.transaction_date < '$date' AND loan_transactions.product_id=$product_id
								WHERE loans.member_id IN ($member_list) 
									AND loans.branch_id=$branch_id AND loans.samity_id = $samity_id AND loans.current_status = 1 AND is_loan_fully_paid=0 
									AND loans.product_id=$product_id 
								GROUP BY loans.id,loans.member_id,loans.disburse_date,loans.cycle
		,loan_purposes.code,loans.loan_amount,loans.total_payable_amount,loans.installment_amount"); 
		$query=$query->result();		
		$data=array();
		$repay_week=0;
		foreach($query as $query)
		{
			$repay_week=intval($query->total_transaction_amount/$query->installment_amount);
			$data[$query->member_id]['disburse_date']=$query->disburse_date;
			$data[$query->member_id]['cycle']=$query->cycle;
			$data[$query->member_id]['purpose_code']=$query->loan_purpose_code;
			$data[$query->member_id]['total_payable_amount']=$query->total_payable_amount;
			$data[$query->member_id]['loan_amount']=$query->loan_amount;
			$data[$query->member_id]['installment_amount']=$query->installment_amount;
			$data[$query->member_id]['total_transaction_amount']=$query->total_transaction_amount;
			$data[$query->member_id]['prev_loan_outstanding']=$query->loan_outstanding;
			$data[$query->member_id]['repay_week']=$repay_week;
		}		
		return $data;
	}
	
		/**
	 * get_member_loan_info
	 * @Auth: Anis
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_loan_collection_report_data
	function get_member_loan_info($member_list,$date,$branch_id,$product_id)
	{	
		$q = "SELECT loans.product_id,loans.id,loans.member_id,loans.disburse_date,loans.cycle
									,loan_purposes.code AS loan_purpose_code,loans.loan_amount,loans.total_payable_amount,loans.installment_amount
									,IFNULL(SUM(loan_transactions.transaction_amount),0.00) AS total_transaction_amount,IFNULL(SUM(loan_transactions.transaction_principal_amount),0.00) AS total_transaction_principal_amount,IFNULL(SUM(loan_transactions.transaction_interest_amount),0.00) AS total_transaction_interest_amount, MAX(loan_transactions.transaction_date) AS max_transaction_date
									, MAX(loan_transactions.installment_number) AS max_transaction_installment_number
								FROM loans 
								JOIN loan_purposes ON loan_purposes.id=loans.purpose_id 
								LEFT JOIN loan_transactions ON loans.id=loan_transactions.loan_id 
									AND loan_transactions.branch_id=$branch_id 
									AND loan_transactions.transaction_date < '$date' AND loan_transactions.product_id=$product_id
								WHERE loans.member_id IN ($member_list) 
									AND loans.branch_id=$branch_id  AND loans.current_status = 1 AND is_loan_fully_paid=0 
									AND loans.product_id=$product_id 
								GROUP BY loans.member_id";
							//	echo $q;
		$query=$this->db->query($q); 
		$q=$query->result();		
		$data=array();
		$repay_week=0;
		foreach($q as $query)
		{
			$repay_week=intval($query->total_transaction_amount/$query->installment_amount);
			$data[$query->member_id]['product_id']=$query->product_id;
			$data[$query->member_id]['member_id']=$query->member_id;
			$data[$query->member_id]['disburse_date']=$query->disburse_date;
			$data[$query->member_id]['cycle']=$query->cycle;
			$data[$query->member_id]['purpose_code']=$query->loan_purpose_code;
			$data[$query->member_id]['total_payable_amount']=$query->total_payable_amount;
			$data[$query->member_id]['loan_amount']=$query->loan_amount;
			$data[$query->member_id]['installment_amount']=$query->installment_amount;
			$data[$query->member_id]['total_transaction_amount']=$query->total_transaction_amount;
			$data[$query->member_id]['total_transaction_principal_amount']=$query->total_transaction_principal_amount;
			$data[$query->member_id]['total_transaction_interest_amount']=$query->total_transaction_interest_amount;
			$data[$query->member_id]['prev_loan_outstanding']=$query->total_payable_amount - $query->total_transaction_amount;
			$data[$query->member_id]['repay_week']=$repay_week;
			$data[$query->member_id]['max_transaction_date']=$query->max_transaction_date;
			$data[$query->member_id]['max_transaction_installment_number']=$query->max_transaction_installment_number;
			$data[$query->member_id]['installment_number']=0;
			$data[$query->member_id]['installment_amount']=0;
			$data[$query->member_id]['last_repayment_date']='2099-01-01';
			$data[$query->member_id]['substandard_outstanding']=0;
			$data[$query->member_id]['substandard_outstanding_with_services_charge']=0;
			$data[$query->member_id]['substandard_overdue']=0;
			$data[$query->member_id]['substandard_overdue_with_services_charge']=0;
			$data[$query->member_id]['doubtfull_outstanding']=0;
			$data[$query->member_id]['doubtfull_outstanding_with_services_charge']=0;
			$data[$query->member_id]['doubtfull_overdue']=0;
			$data[$query->member_id]['doubtfull_overdue_with_services_charge']=0;
			$data[$query->member_id]['bad_outstanding']=0;
			$data[$query->member_id]['bad_outstanding_with_services_charge']=0;
			$data[$query->member_id]['bad_overdue']=0;
			$data[$query->member_id]['bad_overdue_with_services_charge']=0;
		}		
		return $data;
	}
	/**
	 * samity_wise_monthly_loan_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_loan_collection_report_data
	function get_active_member_loan_schedule_info($member_list,$date,$branch_id,$product_id)
	{		
		/*$query=$this->db->query("SELECT loans.id,loans.member_id,MAX(loan_schedules.installment_number) AS installment_number,loan_schedules.installment_amount AS installment_amount
				FROM loans JOIN loan_schedules ON loans.id=loan_schedules.loan_id AND loan_schedules.branch_id=$branch_id 
				AND loan_schedules.samity_id = $samity_id AND loan_schedules.schedule_date < '$date'
				WHERE loans.member_id IN ($member_list) 
				AND loans.branch_id=$branch_id AND loans.samity_id =$samity_id AND loans.current_status = 1 AND is_loan_fully_paid=0 
				AND loans.product_id=$product_id
				GROUP BY loans.id,loans.member_id"); 
		$query=$query->result();		
		$data=array();		
		foreach($query as $query)
		{
			$data[$query->member_id]['installment_number']=$query->installment_number;
			$data[$query->member_id]['installment_amount']=$query->installment_amount;			
		}		
		return $data;*/
		//$member_list = explode(',',$member_list);
		//print_r($member_list);
		//$member_list = array();
		//$date =- 
		//echo "$date";
		return $this->scheduler->get_active_member_loan_schedule_info($member_list,$date,$branch_id,$product_id);
	}
	/**
	 * branch_manager_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 31-Mar-2011   
	*/
	//branch_manager_report_data
	function get_samity_wise_expired_loan_information_before_date($samity_list,$date,$branch_id,$product_id)
	{	
		
		$data=$this->scheduler->get_samity_wise_expired_loan_information_before_date($samity_list,$date,$branch_id,$product_id);
		return $data;
	}
	/**
	 * branch_manager_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 31-Mar-2011   
	*/
	//branch_manager_report_data
	function get_samity_wise_current_loan_information_before_date($samity_list,$date,$branch_id,$product_id)
	{	
		
		$data=$this->scheduler->get_samity_wise_current_loan_information_just_before_date($samity_list,$date,$branch_id,$product_id);		
		return $data;
	}
	/**
	 * branch_manager_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 31-Mar-2011   
	*/
	//branch_manager_report_data
	function get_samity_wise_expired_loan_information_between_date($samity_list,$from_date,$to_date,$branch_id,$product_id)
	{		
		return $this->scheduler->get_samity_wise_expired_loan_information_between_date($samity_list,$from_date,$to_date,$branch_id,$product_id);
	}
	/**
	 * branch_manager_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 31-Mar-2011   
	*/
	//branch_manager_report_data
	function get_samity_wise_current_loan_information_between_date($samity_list,$from_date,$to_date,$branch_id,$product_id)
	{		
		//print_r($samity_list);die;
		return $this->scheduler->get_samity_wise_current_loan_information_between_date($samity_list,$from_date,$to_date,$branch_id,$product_id);
	}
	/**
	 * get_branch_wise_field_officer_list
	 * @Auth: Anis Alamgir
	 * @date: 04-April-2011   
	 * @uses: loan field officer report
	*/
	function get_branch_wise_field_officer_list($branch_id,$date)
	{	
		if(!is_numeric($branch_id)){
			return false;
		}
		$branch_condition = "";
		if($branch_id > 0) {
			$branch_condition = " AND e.branch_id = $branch_id";
		}	
		$query=$this->db->query("SELECT e.id,e.name,e.code FROM employees AS e WHERE e.status = 1 
		AND e.is_field_officer = TRUE AND date_of_joining <= '$date' $branch_condition ;"); 
		$field_officer_list=$query->result_array();
		$field_officers = array();	
		foreach($field_officer_list as $field_officer){
			$field_officers[$field_officer['id']]['field_officer_id'] = $field_officer['id'];
			$field_officers[$field_officer['id']]['field_officer_name'] = $field_officer['name'];
			$field_officers[$field_officer['id']]['field_officer_code'] = $field_officer['code'];
			$field_officers[$field_officer['id']]['m_current_loan'] = 0.00;
			$field_officers[$field_officer['id']]['f_current_loan'] = 0.00;	
			//		
			$field_officers[$field_officer['id']]['m_pre_total_principle_recoverable'] = 0.00;
			$field_officers[$field_officer['id']]['m_pre_total_interrest_recoverable'] = 0.00;
			$field_officers[$field_officer['id']]['f_pre_total_principle_recoverable'] = 0.00;
			$field_officers[$field_officer['id']]['f_pre_total_interrest_recoverable'] = 0.00;
			//
			
			$field_officers[$field_officer['id']]['m_current_total_principle_recoverable'] = 0.00;
			$field_officers[$field_officer['id']]['f_current_total_principle_recoverable'] = 0.00;
			//
			$field_officers[$field_officer['id']]['m_outstanding_opening_balance_principle'] = 0.00;
			$field_officers[$field_officer['id']]['m_outstanding_opening_balance_service_charge'] = 0.00;
			$field_officers[$field_officer['id']]['f_outstanding_opening_balance_principle'] = 0.00;
			$field_officers[$field_officer['id']]['f_outstanding_opening_balance_service_charge'] = 0.00;
			//
			
			//
			$field_officers[$field_officer['id']]['m_current_disburse_principle'] = 0.00;
			$field_officers[$field_officer['id']]['m_current_disburse_services_charge'] = 0.00;
			$field_officers[$field_officer['id']]['f_current_disburse_principle'] = 0.00;
			$field_officers[$field_officer['id']]['f_current_disburse_services_charge'] = 0.00;
			//
			$field_officers[$field_officer['id']]['m_recovery_principle'] = 0.00;
			$field_officers[$field_officer['id']]['m_recovery_services_charge'] = 0.00;
			$field_officers[$field_officer['id']]['f_recovery_principle'] = 0.00;
			$field_officers[$field_officer['id']]['f_recovery_services_charge'] = 0.00;
		}			
		return $field_officers;		
	}
	/**
	 * get_field_officer_wise_samity_list
	 * @Auth: Anis Alamgir
	 * @date: 04-April-2011   
	 * @uses: loan field officer report
	 * @param field_officer_id_string as string
	*/
	function get_field_officer_wise_samity_list($field_officer_id_string,$branch_id,$date_from)
	{	
		if(empty($field_officer_id_string) || !is_numeric($branch_id)){
			return false;
		}
		$branch_condition = "";
		if($branch_id > 0) {
			$branch_condition = " AND s.branch_id = $branch_id";
		}		
		$q = "SELECT id,branch_id,field_officer_id,product_id,samity_type FROM
samities AS s
WHERE s.status = TRUE $branch_condition AND s.opening_date < '$date_from' AND s.field_officer_id IN ($field_officer_id_string);";
		
		$query=$this->db->query($q); 
		$samity_list=$query->result_array();
		//print_r($samity_list);
		$samities = array();
		if(!empty($samity_list)){
			foreach($samity_list as $samity){
				$samities[$samity['id']]['samity_id'] = $samity['id'];
				$samities[$samity['id']]['branch_id'] = $samity['branch_id'];
				$samities[$samity['id']]['field_officer_id'] = $samity['field_officer_id'];
				$samities[$samity['id']]['product_id'] = $samity['product_id'];				
				$samities[$samity['id']]['samity_type'] = $samity['samity_type'];
			}	
		}		
		return $samities;		
	}
	/**
	 * get_loan_information
	 * @Auth: Anis Alamgir
	 * @date: 04-April-2011   
	 * @uses: loan field officer report
	 * @param samity_id_string as string
	*/
	function get_loan_information($samity_id_string,$branch_id,$date_from,$date_to=null,$product_id=null)
	{	
		if(empty($samity_id_string) || !is_numeric($branch_id)){
			return false;
		}
		$date_condition = " AND disburse_date < '$date_from' ";	
		if(!empty($date_to)) {
			$date_condition = " AND disburse_date BETWEEN '$date_from' and '$date_to' ";
		}
		
		$branch_condition = "";
		if($branch_id > 0) {
			$branch_condition = " AND branch_id = $branch_id";
		}
		$product_condition = "";
		if($product_id > 0) {
			$product_condition = " AND product_id = $product_id";
		}		
		$q = "SELECT id,branch_id,samity_id,product_id,loan_amount,number_of_installment,disburse_date FROM
loans
WHERE is_authorized = TRUE $branch_condition AND is_loan_fully_paid = FALSE $date_condition $product_condition
AND samity_id IN ($samity_id_string);";
		$query=$this->db->query($q); 
		$loan_list=$query->result_array();
		//print_r($samity_list);
		$loans = array();
		if(!empty($loan_list)){
			foreach($loan_list as $loan){
				$loans[$loan['id']]['loan_id'] = $loan['id'];
				$loans[$loan['id']]['branch_id'] = $loan['branch_id'];
				$loans[$loan['id']]['samity_id'] = $loan['samity_id'];
				$loans[$loan['id']]['product_id'] = $loan['product_id'];
				$loans[$loan['id']]['disbures_amount'] = $loan['loan_amount'];
				$loans[$loan['id']]['disburse_date'] = $loan['disburse_date'];
				$loans[$loan['id']]['number_of_installment'] = $loan['number_of_installment'];
				$loans[$loan['id']]['field_officer_id'] = '';
			}	
		}		
		return $loans;		
	}
	
	/**
	 * get_loan_transaction_information
	 * @Auth: Anis Alamgir
	 * @date: 04-April-2011   
	 * @uses: loan field officer report
	 * @param loan_id_string as string
	*/
	function get_loan_transaction_information($loan_id_string,$branch_id,$date_from,$date_to=null,$product_id = null)
	{	
		if(empty($loan_id_string) || !is_numeric($branch_id)){
			return false;
		}
		$date_condition = " AND transaction_date < '$date_from' ";	
		if(!empty($date_to)) {
			$date_condition = " AND transaction_date BETWEEN '$date_from' and '$date_to' ";
		}
		$branch_condition = "";
		if($branch_id > 0) {
			$branch_condition = " AND branch_id = $branch_id";
		}
		
		$product_condition = "";
		if($product_id > 0) {
			$product_condition = " AND product_id = $product_id";
		}
		$q = "SELECT loan_id,product_id,branch_id,samity_id,max(transaction_date),
		SUM(transaction_principal_amount) AS transaction_principal_amount,SUM(transaction_interest_amount) AS transaction_interest_amount,MAX(installment_number) as max_installment_number FROM
loan_transactions
WHERE is_authorized = TRUE $branch_condition $product_condition $date_condition AND loan_id IN ($loan_id_string)
GROUP BY loan_id,samity_id,product_id,branch_id;";
		$query=$this->db->query($q); 
		$loan_transaction_list=$query->result_array();
		//print_r($samity_list);
		$loan_transactions = array();
		if(!empty($loan_transaction_list)){
			foreach($loan_transaction_list as $loan){
				$loan_transactions[$loan['loan_id']]['loan_id'] = $loan['loan_id'];
				$loan_transactions[$loan['loan_id']]['branch_id'] = $loan['branch_id'];
				$loan_transactions[$loan['loan_id']]['samity_id'] = $loan['samity_id'];
				$loan_transactions[$loan['loan_id']]['product_id'] = $loan['product_id'];
				$loan_transactions[$loan['loan_id']]['transaction_date'] = isset($loan['transaction_date'])?$loan['transaction_date']:"";
				$loan_transactions[$loan['loan_id']]['transaction_principal_amount'] = $loan['transaction_principal_amount'];
				$loan_transactions[$loan['loan_id']]['transaction_interest_amount'] = $loan['transaction_interest_amount'];
				$loan_transactions[$loan['loan_id']]['max_installment_number'] = $loan['max_installment_number'];
			}	
		}		
		return $loan_transactions;		
	}
	
	/**
	 * get_loan_schedule_info
	 * @Auth: Anis Alamgir
	 * @date: 04-April-2011   
	 * @uses: loan field officer report
	 * @param field_officer_id_string as string
	*/
	function get_loan_schedule_info($samity_id_list,$branch_id,$date_from,$product_id = null)
	{	
		
		if(empty($samity_id_list) || !is_numeric($branch_id)){
			return false;
		}	
		$loan_schedule = array(array(0=>null));
		$branch_condition = "";
		if($branch_id > 0 && $product_id > 0) {			
			$loan_schedule=$this->scheduler->get_samity_wise_current_loan_information_just_before_date($samity_id_list,$date_from,$branch_id,$product_id);
		} elseif($branch_id > 0 && empty($product_id)) {			
			$loan_schedule=$this->scheduler->get_samity_wise_current_loan_information_just_before_date($samity_id_list,$date_from,$branch_id);
		} elseif($product_id > 0 && empty($branch_id)) {
			$loan_schedule=$this->scheduler->get_samity_wise_current_loan_information_just_before_date($samity_id_list,$date_from,null,$product_id);
		} elseif(empty($product_id) && empty($branch_id)) {			
			$loan_schedule=$this->scheduler->get_samity_wise_current_loan_information_just_before_date($samity_id_list,$date_from);
		}
		
		/*
		$loan_schedule = array();
		//print_r($data);
		foreach($data as $row){
			foreach($row as $row1){
				foreach($row1 as $row2){
					$loan_schedule[] = $row2;
				}
			}
		}
		* */
		//print_r($loan_schedule[0]);		
				
		return $loan_schedule;	
	}
}
