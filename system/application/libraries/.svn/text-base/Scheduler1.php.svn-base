<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler1
{
	
	var $CI='';
	var $branch_holidays=array();
	var $samity_holidays=array();
	var $loan_reschedules=array();
	var $samity_day_change=array();
	var $samities=array();
	var $loans=array();
	
	var $sami;
	
	
	function __construct($branch_id=null)
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		$query="";
		if(!is_null($branch_id)){
			$query=$this->CI->db->query("(SELECT holiday_date FROM config_holidays WHERE branch_id=$branch_id UNION) (SELECT holiday_date FROM config_holidays WHERE (ISNULL(branch_id) OR branch_id=0) AND (ISNULL(samity_id) OR samity_id=0))"); 
		}
		else{
			$query=$this->CI->db->query("(SELECT holiday_date FROM config_holidays WHERE !ISNULL(branch_id) AND branch_id!=0) UNION (SELECT holiday_date FROM config_holidays WHERE (ISNULL(branch_id) OR branch_id=0) AND (ISNULL(samity_id) OR samity_id=0))");
		}
		//$result = mysql_query("SELECT holiday_date FROM config_holidays WHERE !ISNULL(branch_id) AND branch_id!=0");

		//$branch_holidays=array();
		foreach ($query->result_array() as $row){
			
			//array_push($samity_holidays[$row["samity_id"]],$row["holiday_date"]);
			array_push($this->branch_holidays, $row["holiday_date"]);
		}

		//print_r($this->branch_holidays);
		//die;
		if(!is_null($branch_id)){
			$query=$this->CI->db->query("SELECT samity_id,holiday_date FROM config_holidays WHERE !ISNULL(samity_id) AND samity_id!=0 AND branch_id=$branch_id");
		}
		else{
			$query=$this->CI->db->query("SELECT samity_id,holiday_date FROM config_holidays WHERE !ISNULL(samity_id) AND samity_id!=0");
		}
		//$result = mysql_query("SELECT samity_id,holiday_date FROM config_holidays WHERE !ISNULL(samity_id) AND samity_id!=0");

		//$samity_holidays=array();
		foreach ($query->result_array() as $row){
			
			if(!empty($this->samity_holidays[$row["samity_id"]])){
				array_push($this->samity_holidays[$row["samity_id"]],$row["holiday_date"]);//array_merge($samity_day_change[$row["samity_id"]],array($row["holiday_date"]));
			}
			else{
				$this->samity_holidays[$row["samity_id"]]=array($row["holiday_date"]);
			}
			
			//array_push($samity_holidays[$row["samity_id"]],$row["holiday_date"]);
			//array_push($samity_holidays, $row);
			//print_r($row);
			//die;
		}
		
		
		
		
		$query=$this->CI->db->query("SELECT loan_id, reschedule_from, reschedule_to FROM loan_reschedules ORDER BY loan_id");
		
		//$result = mysql_query("SELECT samity_id,holiday_date FROM config_holidays WHERE !ISNULL(samity_id) AND samity_id!=0");
		
		//$samity_holidays=array();
		foreach ($query->result_array() as $row){
			if(empty($this->loan_reschedules[$row['loan_id']])){
				$this->loan_reschedules[$row['loan_id']]=array();
			}
			array_push($this->loan_reschedules[$row['loan_id']],$row);
		}
		//echo "<pre>";
		//print_r($loan_reschedules);
		//echo "</pre>";

		$query=$this->CI->db->query("SELECT samity_id,effective_date,new_samity_day FROM samity_day_changes"); 
		//$result = mysql_query("SELECT samity_id,effective_date,new_samity_day FROM samity_day_changes");

		//$samity_day_change=array();
		foreach ($query->result_array() as $row){
			if(!empty($this->samity_day_change[$row["samity_id"]])){
				$this->samity_day_change[$row["samity_id"]]=array_merge($this->samity_day_change[$row["samity_id"]],array($row["effective_date"]=>$row["new_samity_day"]));
			}
			else{
				$this->samity_day_change[$row["samity_id"]]=array($row["effective_date"]=>$row["new_samity_day"]);
			}
			//array_push($samity_day_change, $temp);
			//print_r($temp);
			//die;
		}

		//print_r($samity_day_change);
		//die;
		if(!is_null($branch_id)){
			$query=$this->CI->db->query("SELECT * FROM samities WHERE branch_id=$branch_id"); 
		}
		else{
			$query=$this->CI->db->query("SELECT * FROM samities");
		}
		//$result = mysql_query("SELECT * FROM samities");

		//$samities=array();
		foreach ($query->result_array() as $row){
			$temp=$row;
			if(!empty($this->samity_day_change[$row["id"]])){
				$temp["samity_days"]=array_merge(array($row["opening_date"]=>$temp["samity_day"]),$this->samity_day_change[$row["id"]]);//array("1900-01-01"=>$temp["samity_day"]);
			}
			else{
				$temp["samity_days"]=array($row["opening_date"]=>$temp["samity_day"]);
			}
			array_push($this->samities, $temp);
			//print_r($row);
			//die;
		}

		if(!is_null($branch_id)){
			$query=$this->CI->db->query("SELECT
  id,
  customized_loan_no,
  loan_application_no,
  branch_id,
  samity_id,
  product_id,
  member_id,
  purpose_id,
  funding_org_id,
  interest_calculation_method,
  loan_amount,
  interest_rate,
  interest_amount,
  discount_interest_amount,
  insurance_guarantor_percentage,
  insurance_amount,
  total_payable_amount,
  number_of_installment,
  principal_installment_amount,
  installment_amount,
  repayment_frequency,
  loan_period_in_month,
  mode_of_interest,
  interest_rate_calculation_amount,
  cycle,
  first_repayment_date,
  is_interest_charged_if_last_repay_date_exceeds,
  is_authorized,
  disburse_registration_no,
  disbursed_by,
  IFNULL(disburse_date,'3000-01-01') disburse_date,
  authorized_by,
  authorization_date,
  ledger_id,
  voucher_status,
  fully_paid_registration_no,
  overdue_registration_no,
  fully_paid_amount,
  IFNULL(is_loan_fully_paid,0) is_loan_fully_paid,
  IFNULL(loan_fully_paid_date,'3000-01-01') loan_fully_paid_date,
  current_status,
  loan_closing_date,
  loan_closing_info_verified_by,
  guarantor_name_1,
  guarantor_relationship_1,
  guarantor_address_1,
  guarantor_name_2,
  guarantor_relationship_2,
  guarantor_address_2
FROM loans WHERE branch_id=$branch_id");
		}
		else{
			$query=$this->CI->db->query("SELECT
  id,
  customized_loan_no,
  loan_application_no,
  branch_id,
  samity_id,
  product_id,
  member_id,
  purpose_id,
  funding_org_id,
  interest_calculation_method,
  loan_amount,
  interest_rate,
  interest_amount,
  discount_interest_amount,
  insurance_guarantor_percentage,
  insurance_amount,
  total_payable_amount,
  number_of_installment,
  principal_installment_amount,
  installment_amount,
  repayment_frequency,
  loan_period_in_month,
  mode_of_interest,
  interest_rate_calculation_amount,
  cycle,
  first_repayment_date,
  is_interest_charged_if_last_repay_date_exceeds,
  is_authorized,
  disburse_registration_no,
  disbursed_by,
  IFNULL(disburse_date,'3000-01-01') disburse_date,
  authorized_by,
  authorization_date,
  ledger_id,
  voucher_status,
  fully_paid_registration_no,
  overdue_registration_no,
  fully_paid_amount,
  IFNULL(is_loan_fully_paid,0) is_loan_fully_paid,
  IFNULL(loan_fully_paid_date,'3000-01-01') loan_fully_paid_date,
  current_status,
  loan_closing_date,
  loan_closing_info_verified_by,
  guarantor_name_1,
  guarantor_relationship_1,
  guarantor_address_1,
  guarantor_name_2,
  guarantor_relationship_2,
  guarantor_address_2
FROM loans");
		}
		//$result = mysql_query("SELECT * FROM loans");
		
		//$loans=array();
		foreach ($query->result_array() as $row){
			if(empty($row["last_repayment_date"])){
				$row["last_repayment_date"]="1900-01-01";
			}
			array_push($this->loans, $row);
			//print_r($row);
			//die;
		}

			//print_r($loans);
			//die;
			//echo "<pre>";
		//print_r($this->loans);
		//echo "</pre>";//die;

		$this->sami = new Loan_scheduler();
/*
		echo "<pre>";
		print_r($this->branch_holidays);
		echo "</pre><pre>";
		print_r($this->samity_holidays);
		echo "</pre><pre>";
		print_r($this->loans);
		echo "</pre><pre>";
		print_r($this->samities);
		echo "</pre>";
*/



		//$this->sami->initialize(1,1,"2010-01-01","2012-01-01",$this->branch_holidays,$this->samity_holidays,$this->loans,array(),$this->samities);	
				
		$this->sami->initialize(1,1,"2010-01-01","2012-01-01",$this->branch_holidays,$this->samity_holidays,$this->loans,$this->loan_reschedules,$this->samities);	
		
	}
	
	function reinitialize($loan_reschedules){
		$this->sami->initialize($loan_reschedules);
	}
	
	function __destruct() {
       unset($this->sami);
   }
	
	function get_active_member_loan_schedule_info($member_list,$date,$branch_id,$product_id,$samity_id = null)
	{		
		$data=$this->sami->get_active_member_loan_schedule_info($member_list,$date,$branch_id,$product_id,$samity_id);	
		return $data[0];
	}
		
	function get_loan_schedules($branch_id=null,$samity_id=null,$member_id=null,$loan_id=null)
	{		
		
		$data=$this->sami->get_loan_schedules($branch_id,$samity_id,$member_id,$loan_id);	
		return $data[0];
	}
	
	function get_loan_schedules_by_memeberlist_branch_product($member_list,$branch_id,$product_id,$samity_id=NULL,$date_frm=NULL,$date_to=NULL)
	{		
		$data=$this->sami->get_loan_schedules_by_memeberlist_branch_product($member_list,$branch_id,$product_id,$samity_id,$date_frm,$date_to);	
		return $data[0];
	}
	
	function get_loan_recoverable_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$data=$this->sami->get_loan_recoverable_amount($branch_id,$product_id,$date);
		
		return $data[0];
	}
	
	function get_loan_recoverable_amount_branch_id($branch_id=null,$date_frm=null,$date_to=null)
	{		
		$data=$this->sami->get_loan_recoverable_amountt($branch_id,$date_frm,$date_to);
		
		return $data[0];
	}
	
	
	function get_loan_transaction_amount($loan_id,$s_date)
    { 	
		$loan_schedule_information =$this->sami->get_loan_transaction_amount($loan_id,$s_date);
		
		return $loan_schedule_information[0];
	}
	
	function get_loan_transaction_amount_before_date($loan_id,$s_date)
    { 	
		$loan_schedule_information =$this->sami->get_loan_transaction_amount_before_date($loan_id,$s_date);
		
		return $loan_schedule_information[0];
	}
	
	function get_first_schedule_date($loan_id=null)
    {      
		$first_schedule_date =$this->sami->get_first_schedule_date($loan_id);
		
		return $first_schedule_date;
	}
	
	function get_last_schedule_date($loan_id=null)
    {      
		$last_schedule_date=$this->sami->get_last_schedule_date($loan_id);
		
		return $last_schedule_date;
	}
	
	
	function get_schedule_date_by_installment_no($loan_id,$installment_no)
    {      
		$schedule_date=$this->sami->get_schedule_date_by_installment_no($loan_id,$installment_no-1);
		
		return $schedule_date;
	}
	//input samity_list,,branch_id,date,product_id
	//output cum_exp_borrower_no,cum_exp_loan_amount group by samity id
	//function get_branch_wise_loan_information_beginning_week($loan_id=null)
    	//{      
		
	//}
	function get_samity_wise_expired_loan_information_before_date($samity_list,$s_date,$branch_id,$product_id=null) 
	{
		
		return $this->sami->get_samity_wise_expired_loan_information_before_date($samity_list,$s_date,$branch_id,$product_id);
	}
	
	
	//input samity_list,from_date,to_date,product_id
	//output exp_borrower_no,exp_loan_amount,recoverable_amount group by samity id
	//function get_branch_wise_loan_information_for_the_week($loan_id=null)
    	//{      
		
	//}	
	
	function get_samity_wise_expired_loan_information_between_date($samity_list,$s_date_from,$s_date_to,$branch_id,$product_id=null){
		
		$temp=$this->sami->get_samity_wise_expired_loan_information_between_date($samity_list,$s_date_from,$s_date_to,$branch_id,$product_id);
		return $temp;
	}
	
	function get_samity_wise_current_loan_information_before_date($samity_list,$s_date,$branch_id,$product_id=null) 
	{
		
		return $this->sami->get_samity_wise_current_loan_information_before_date($samity_list,$s_date,$branch_id,$product_id);
	}
	
	function get_samity_wise_current_loan_information_between_date($samity_list,$s_date_from,$s_date_to,$branch_id,$product_id=null){
		
		return $this->sami->get_samity_wise_current_loan_information_between_date($samity_list,$s_date_from,$s_date_to,$branch_id,$product_id);
	}
	
	
	function get_samity_wise_current_loan_information_just_before_date($samity_list,$s_date,$branch_id=null,$product_id=null) 
	{
		$loans = $this->sami->get_samity_wise_current_loan_information_just_before_date($samity_list,$s_date,$branch_id,$product_id);
		return $loans[0];
	}
	
	
	function is_valid_schedule_date($loan_id, $s_date){
		return $this->sami->is_valid_schedule_date($loan_id, $s_date);
	}
	
	function get_samity_day($loan_id, $s_date){
		return $this->sami->get_samity_day($loan_id, $s_date);
	}
	
};
