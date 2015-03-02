<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler
{
	
	var $CI='';
	
	
	function Scheduler()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		
	}
	
	function get_active_member_loan_schedule_info($member_list,$date,$branch_id,$product_id,$samity_id = null)
	{		
	$samity_condition_loan_schedule = "";
	$samity_condition_loan = "";
	$product_condition = " AND loans.product_id=$product_id ";
	if(is_numeric($samity_id)){
		$samity_condition = "AND loan_schedules.samity_id = $samity_id ";
		$samity_condition_loan  = "AND loans.samity_id =$samity_id ";
	}
	$q = "SELECT loans.id,loans.member_id,MAX(loan_schedules.schedule_date) AS last_repayment_date,MAX(loan_schedules.installment_number) AS installment_number,loan_schedules.installment_amount AS installment_amount,loan_schedules.principal_installment_amount, loan_schedules.interest_installment_amount
				FROM loans JOIN loan_schedules ON loans.id=loan_schedules.loan_id AND loan_schedules.branch_id=$branch_id $samity_condition_loan_schedule
				AND loan_schedules.schedule_date < '$date'
				WHERE loans.member_id IN ($member_list) 
				AND loans.branch_id=$branch_id AND loans.current_status = 1 AND is_loan_fully_paid=0 
				AND loans.product_id=$product_id $samity_condition_loan
				GROUP BY loans.id,loans.member_id";
		//	echo $q;
		$query=$this->CI->db->query($q); 
		$query=$query->result();		
		$data=array();		
		foreach($query as $query)
		{
			$data[$query->member_id]['installment_number']=$query->installment_number;
			$data[$query->member_id]['installment_amount']=$query->installment_amount;
			$data[$query->member_id]['last_repayment_date']=$query->last_repayment_date;
			$data[$query->member_id]['principal_installment_amount']=$query->principal_installment_amount;
			$data[$query->member_id]['interest_installment_amount']=$query->interest_installment_amount;			
		}	
		//print_r($data);	
		return $data;
	}
		
	function get_loan_schedules($loan_id=null,$member_id=null,$branch_id=null,$samity_id=null)
	{		
		
		$query_string="";
		$query_string="SELECT * FROM loan_schedules";
		$qflag=0;
		if(!empty($loan_id)||!empty($member_id)||!empty($branch_id)||!empty($samity_id)){
			$query_string=$query_string." WHERE ";
		}
		if(!empty($loan_id)){
			$query_string=$query_string." loan_id=$loan_id ";
			$qflag=1;
		}
		if(!empty($member_id)){
			if($qflag==1){
				$query_string=$query_string." AND ";
			}
			$query_string=$query_string." member_id=$member_id ";
			$qflag=1;
		}
		if(!empty($branch_id)){
			if($qflag==1){
				$query_string=$query_string." AND ";
			}
			$query_string=$query_string." branch_id=$branch_id ";
			$qflag=1;
		}
		if(!empty($samity_id)){
			if($qflag==1){
				$query_string=$query_string." AND ";
			}
			$query_string=$query_string." samity_id=$samity_id ";
			$qflag=1;
		}
		
		$query=$this->CI->db->query($query_string); 
		$query=$query->result_array();		
		return $query;
	}
	
	function get_loan_recoverable_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->CI->db->query("SELECT loan_schedules.samity_id,SUM(loan_schedules.installment_amount) AS recoverable_amount
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
		
		return $data;
	}
	
	
	function get_loan_transaction_amount($loan_id,$transaction_amount)
    { 				
		$loan_schedule_information = $this->CI->db->query("SELECT principal_installment_amount,interest_installment_amount FROM loan_schedules 
		WHERE loan_id=$loan_id LIMIT 1");
		$loan_schedule_information->result_array();
		
		print_r($loan_schedule_information);
		die;
		
		return $loan_schedule_information;
	}
	
	function get_first_schedule_date($loan_id=null)
    {      
		$first_schedule_date = $this->CI->db->query("SELECT schedule_date FROM loan_schedules WHERE loan_id=$loan_id LIMIT 1");			
		$first_schedule_date=$first_schedule_date ->row();
		
		return $first_schedule_date;
	}
	
	function get_last_schedule_date($loan_id=null)
    {      
		$no_of_ins = $this->CI->db->query("SELECT number_of_installment FROM loans WHERE loan_id=$loan_id");
		$last_schedule_date = $this->CI->db->query("SELECT schedule_date FROM loan_schedules WHERE loan_id=$loan_id AND installment_number=$no_of_ins");			
		$last_schedule_date=$last_schedule_date ->row();
		
		return $last_schedule_date;
	}
	
	
	
};
