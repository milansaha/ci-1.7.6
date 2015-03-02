<?php
/** 
	* REGULAR & GENERAL REPORT Model Class.
	* @pupose		REGULAR & GENERAL REPORT information
	*		
	* @filesource	./system/application/models/po_mis_report.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_mis_report
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Regular_and_general_report extends Model {

    	var $loan_base_class=null;
 	var $savings_base_class=null;	

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->model(array('Samity','Saving_product','Process_month_end','Member'));  
	}   
	/**
	 * component_wise_daily_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//*******************************************************Component Wise Daily Collection Report*******************************************************
	function get_component_wise_daily_collection_report_data($branch_id=null,$product_id=null,$date=null)
	{
		//print('--');print($branch_id);print('--');print($product_id);print('--');print($date);print('<br>');
		$loan_disburse_amount=$this->loan_base_class->get_loan_disburse_amount($branch_id,$product_id,$date);
		//echo "1 ";echo "<pre>";print_r($loan_disburse_amount);
		
		$loan_recoverable_amount=$this->loan_base_class->get_loan_recoverable_amount($branch_id,$product_id,$date);
		//echo "2 ";echo "<pre>";print_r($loan_recoverable_amount);
		
		$loan_due_amount=$this->loan_base_class->get_loan_due_amount($branch_id,$product_id,$date);
		//echo "3 ";echo "<pre>";print_r($loan_due_amount);
		
		$loan_advance_amount=$this->loan_base_class->get_loan_advance_amount($branch_id,$product_id,$date);
		//echo "4 ";echo "<pre>";print_r($loan_advance_amount);
		
		$loan_transaction_amount=$this->loan_base_class->get_loan_transaction_amount($branch_id,$product_id,$date);
		//echo "5 ";echo "<pre>";print_r($loan_transaction_amount);
		
		$saving_deposit_amount=$this->savings_base_class->get_saving_deposit_amount($branch_id,$product_id,$date);
		//echo "6 ";echo "<pre>";print_r($saving_deposit_amount);
		
		$saving_withdraw_amount=$this->savings_base_class->get_saving_withdraw_amount($branch_id,$product_id,$date);		
		//echo "7 ";echo "<pre>";print_r($saving_withdraw_amount);
		
		$SKT_collection_amount=$this->get_SKT_collection_amount($branch_id,$product_id,$date);	
		//echo "8 ";echo "<pre>";print_r($SKT_collection_amount);
		
		$samity_info=$this->get_samity_info($branch_id,$product_id,$date);
		//echo "9 ";echo "<pre>";print_r($samity_info);
		
		$component_wise_daily_collection_report_data=array();
		$i=0;
		foreach($samity_info as $samity_info)
		{
			$i++;
			$component_wise_daily_collection_report_data[$i]['employee_code']=$samity_info->employee_code;
			$component_wise_daily_collection_report_data[$i]['employee_name']=$samity_info->employee_name;
			$component_wise_daily_collection_report_data[$i]['samity_code']=$samity_info->samity_code;
			$component_wise_daily_collection_report_data[$i]['samity_name']=$samity_info->samity_name;
			$component_wise_daily_collection_report_data[$i]['loan_disburse_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['recoverable_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['loan_due_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['loan_advance_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['principal_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['interest_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['saving_deposit_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['saving_withdraw_collection_amount']=0;
			$component_wise_daily_collection_report_data[$i]['SKT_collection_collection_amount']=0;

			if (array_key_exists($samity_info->samity_id, $loan_disburse_amount)) {
				$component_wise_daily_collection_report_data[$i]['loan_disburse_collection_amount']=$loan_disburse_amount[$samity_info->samity_id];
			}
			if (array_key_exists($samity_info->samity_id, $loan_recoverable_amount)) {
				$component_wise_daily_collection_report_data[$i]['recoverable_collection_amount']=$loan_recoverable_amount[$samity_info->samity_id];
			}			
			if (array_key_exists($samity_info->samity_id, $loan_due_amount)) {
				$component_wise_daily_collection_report_data[$i]['loan_due_collection_amount']=$loan_due_amount[$samity_info->samity_id];
			}			
			if (array_key_exists($samity_info->samity_id, $loan_advance_amount)) {
				$component_wise_daily_collection_report_data[$i]['loan_advance_collection_amount']=$loan_advance_amount[$samity_info->samity_id];
			}
			if (array_key_exists($samity_info->samity_id, $loan_transaction_amount)) {
				$component_wise_daily_collection_report_data[$i]['principal_collection_amount']=$loan_transaction_amount[$samity_info->samity_id]['principal_amount'];
			$component_wise_daily_collection_report_data[$i]['interest_collection_amount']=$loan_transaction_amount[$samity_info->samity_id]['interest_amount'];
			}
			if (array_key_exists($samity_info->samity_id, $saving_deposit_amount)) {
				$component_wise_daily_collection_report_data[$i]['saving_deposit_collection_amount']=$saving_deposit_amount[$samity_info->samity_id];
			}				
			if (array_key_exists($samity_info->samity_id, $saving_withdraw_amount)) {
				$component_wise_daily_collection_report_data[$i]['saving_withdraw_collection_amount']=$saving_withdraw_amount[$samity_info->samity_id];
			}
			if (array_key_exists($samity_info->samity_id, $SKT_collection_amount)) {
				$component_wise_daily_collection_report_data[$i]['SKT_collection_collection_amount']=$SKT_collection_amount[$samity_info->samity_id];
			}					
		}	
		return $component_wise_daily_collection_report_data;
	}
	/**
	 * component_wise_daily_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_samity_info($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->db->query("SELECT employees.code as employee_code,employees.name as employee_name
							,samities.code as samity_code,samities.name as samity_name,samities.id as samity_id
							FROM samities JOIN members ON samities.id=members.samity_id 
							AND members.primary_product_id=$product_id 
							AND members.member_status=1 
							JOIN employees ON samities.field_officer_id=employees.id
							WHERE samities.branch_id=$branch_id and samities.opening_date<='$date'
							AND samities.status=1
							GROUP BY employees.name,employees.code,samities.name,samities.code,samities.id");		
		return $query->result();
	}
	/**
	 * component_wise_daily_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_SKT_collection_amount($branch_id=null,$product_id=null,$date=null)
	{
		$query=$this->db->query("SELECT samity_id,SUM(amount) as SKT_collection_amount
							FROM skt_collections
							WHERE branch_id=$branch_id AND member_primary_product_id=$product_id AND transaction_date='$date' 
							AND is_authorized=1
							GROUP BY samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]=$query->SKT_collection_amount;
		}
		
		return $data;
	}	
	//*************************************************Samity Wise Monthly Loan & Saving Collection Sheet*******************************************************
	/**
	 * samity_wise_monthly_savings_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	function get_samity_wise_monthly_savings_collection_report_data($member_list,$samity_id,$date,$branch_id= null,$primary_product_id=null)
	{
		if(empty($member_list) || empty($date) || !is_numeric($samity_id)) {
			return false;
		}	
		$active_member_name_code=$this->Report->get_active_member_name_code($member_list);	
		//echo "<br/> ";echo "<pre>";print_r($active_member_name_code);
		//print('<br>');print($samity_id);print('<br>');print($primary_product_id);print('<br>');print($member_list);print('<br>');print($date);print('<br>');
		$active_member_previous_savings_balance =$this->savings_base_class->get_active_member_previous_savings_balance($member_list,$date,$branch_id,$samity_id,$primary_product_id);
		//print("hellooooooooooooo");die;
		//echo "<br/>";echo "<pre>";print_r($active_member_previous_savings_balance);die;
		$active_member_savings_auto=$this->savings_base_class->get_active_member_savings_auto($member_list,$date,$branch_id,$samity_id,$primary_product_id);
		//print("hellooooooooooooo");die;
		//echo "<br/>2 ";echo "<pre>";print_r($active_member_savings_auto);die;
		$active_member_previous_skt_balance=$this->get_active_member_previous_skt_balance($member_list,$date,$branch_id,$samity_id,$primary_product_id);		
		//print("hellooooooooooooo");
		//echo "<br/>3 ";echo "<pre>";
		//print_r($active_member_previous_skt_balance);	die;		

		$samity_wise_monthly_savings_collection_report_data=array();
		$i=0;
		foreach($active_member_name_code as $row)
		{
			$i++;
			$samity_wise_monthly_savings_collection_report_data[$i]['member_name']=$row->member_name;
			$samity_wise_monthly_savings_collection_report_data[$i]['member_code']=$row->member_code;
			$samity_wise_monthly_savings_collection_report_data[$i]['member_id']=$row->id;
			$samity_wise_monthly_savings_collection_report_data[$i]['previous_savings_balance']=0;
			$samity_wise_monthly_savings_collection_report_data[$i]['previous_skt_balance']=0;
			$samity_wise_monthly_savings_collection_report_data[$i]['savings_auto']=0;				

			if (array_key_exists($row->id, $active_member_previous_savings_balance)) { 
				$samity_wise_monthly_savings_collection_report_data[$i]['previous_savings_balance']=$active_member_previous_savings_balance[$row->id];
			}
			if (array_key_exists($row->id,$active_member_savings_auto)) {
				$samity_wise_monthly_savings_collection_report_data[$i]['savings_auto']=$active_member_savings_auto[$row->id];
			}
			if (array_key_exists($row->id,$active_member_previous_skt_balance)) {
				$samity_wise_monthly_savings_collection_report_data[$i]['previous_skt_balance']=$active_member_previous_skt_balance[$row->id];
			}										
		}	
		//echo "<br/>6 ";echo "<pre>";print_r($samity_wise_monthly_savings_collection_report_data);die;
		return $samity_wise_monthly_savings_collection_report_data;		
	}
	/**
	 * samity_wise_monthly_savings_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_savings_collection_report_data
	function get_active_member_previous_skt_balance($member_list,$date,$branch_id,$samity_id,$primary_product_id)
	{
		if(empty($member_list) || empty($date) || !is_numeric($samity_id)) {
			return false;
		}
		//print($primary_product_id);die;
		$query=$this->db->query("SELECT skt_collections.member_id,SUM(skt_collections.amount) AS previous_skt_balance
							FROM skt_collections 
							WHERE skt_collections.member_id IN ($member_list) 
							AND skt_collections.is_authorized=1
							AND skt_collections.branch_id=$branch_id AND skt_collections.samity_id = $samity_id
							AND skt_collections.transaction_date < '$date' AND skt_collections.member_primary_product_id=$primary_product_id
							GROUP BY skt_collections.member_id "); 
		$query=$query->result();		
		//print('taposhi');die;
		$data=array();
		foreach($query as $query)
		{
			$data[$query->member_id]=$query->previous_skt_balance;
		}		
		return $data;
	}	
	/**
	 * samity_wise_monthly_savings_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_savings_collection_report_data
	function get_cancellation_member_skt_amount($samity_id,$date,$branch_id,$primary_product_id)
	{
		$cancel_member_list=$this->Report->get_cancel_member_list_by_samity_id_csv($date,$samity_id,$primary_product_id);
		if(empty($cancel_member_list) || empty($date) || !is_numeric($samity_id)) {
			return false;
		}//echo "<br/>4 ";echo "<pre>";print_r($cancel_member_list);	
		$query=$this->db->query("SELECT SUM(skt_collections.amount) AS canceled_member_skt_amount
							FROM skt_collections 
							WHERE skt_collections.member_id IN ($cancel_member_list) 
							AND skt_collections.is_authorized=1
							AND skt_collections.branch_id=$branch_id AND skt_collections.samity_id = $samity_id
							AND skt_collections.transaction_date < '$date' AND skt_collections.member_primary_product_id=$primary_product_id"); 				
		return $query->result();
	}
	/**
	 * samity_wise_monthly_loan_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_loan_collection_report_data
	function get_samity_wise_monthly_loan_collection_report_data($member_list,$samity_id,$date,$branch_id= null,$product_id=null)
	{
		if(empty($member_list) || empty($date) || !is_numeric($samity_id)) {
			return false;
		}		
		$active_member_name_code=$this->Report->get_active_member_name_code($member_list);
		$active_member_array=$this->Member->get_active_member_list_array_by_samity_id_csv($samity_id);
		//print_r($active_member_array);die;
		$active_member_loan_info =$this->loan_base_class->get_active_member_loan_info($member_list,$date,$branch_id,$samity_id,$product_id);
		$active_member_loan_schedule_info =$this->loan_base_class->get_active_member_loan_schedule_info($active_member_array,$date,$branch_id,$samity_id,$product_id); 			
		$samity_wise_monthly_loan_collection_report_data=array();
		$i=0;
		foreach($active_member_name_code as $row)
		{
			$i++;
			$samity_wise_monthly_loan_collection_report_data[$i]['member_name']=$row->member_name;
			$samity_wise_monthly_loan_collection_report_data[$i]['member_code']=$row->member_code;
			$samity_wise_monthly_loan_collection_report_data[$i]['member_id']=$row->id;
			$samity_wise_monthly_loan_collection_report_data[$i]['loan_disbuse_date']="";
			$samity_wise_monthly_loan_collection_report_data[$i]['loan_amount']=0;
			$samity_wise_monthly_loan_collection_report_data[$i]['cycle']=0;				
			$samity_wise_monthly_loan_collection_report_data[$i]['purpose_code']=0;	
			$samity_wise_monthly_loan_collection_report_data[$i]['repay_week']=0;	
			$samity_wise_monthly_loan_collection_report_data[$i]['previous_month_outstanding']=0;	
			$samity_wise_monthly_loan_collection_report_data[$i]['preious_month_due']=0;
			$samity_wise_monthly_loan_collection_report_data[$i]['auto']=0;	
			$samity_wise_monthly_loan_collection_report_data[$i]['total_payable_amount']=0;

			if (array_key_exists($row->id, $active_member_loan_info)) { 
				$samity_wise_monthly_loan_collection_report_data[$i]['loan_disbuse_date']=$active_member_loan_info[$row->id]['disburse_date'];
				$samity_wise_monthly_loan_collection_report_data[$i]['loan_amount']=$active_member_loan_info[$row->id]['loan_amount'];
				$samity_wise_monthly_loan_collection_report_data[$i]['cycle']=$active_member_loan_info[$row->id]['cycle'];
				$samity_wise_monthly_loan_collection_report_data[$i]['purpose_code']=$active_member_loan_info[$row->id]['purpose_code'];
				$samity_wise_monthly_loan_collection_report_data[$i]['repay_week']=$active_member_loan_info[$row->id]['repay_week'];
				$samity_wise_monthly_loan_collection_report_data[$i]['previous_month_outstanding']=$active_member_loan_info[$row->id]['prev_loan_outstanding'];	
				$samity_wise_monthly_loan_collection_report_data[$i]['auto']=$active_member_loan_info[$row->id]['installment_amount'];	
				$samity_wise_monthly_loan_collection_report_data[$i]['total_transaction_amount']=$active_member_loan_info[$row->id]['total_transaction_amount'];
			}
			if (array_key_exists($row->id,$active_member_loan_schedule_info)) {
				$amount=$active_member_loan_schedule_info[$row->id]['installment_number']*$active_member_loan_schedule_info[$row->id]['installment_amount'];
				$samity_wise_monthly_loan_collection_report_data[$i]['preious_month_due']=$amount-$samity_wise_monthly_loan_collection_report_data[$i]['total_transaction_amount'];	
			}													
		}	
		//echo "<br/>1 ";echo "<pre>";print_r($samity_wise_monthly_loan_collection_report_data);die;
		return $samity_wise_monthly_loan_collection_report_data;			
	}
	//*************************Samity Wise Monthly Loan & Saving worksheet Sheet********************************************************************************************/
	/* * samity_wise_monthly_loan_worksheet_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	function get_samity_wise_monthly_loan_saving_worksheet_report_data($member_list,$samity_id,$date,$branch_id,$product_id)
	{
		if(empty($member_list) || empty($date) || !is_numeric($samity_id) || !is_numeric($branch_id) || !is_numeric($product_id)) {
			return false;
		}
		$active_member_name_code=$this->Report->get_active_member_name_code($member_list);
		
		$active_member_array=$this->Member->get_active_member_list_array_by_samity_id_csv($samity_id);
		
		$active_member_previous_savings_balance =$this->savings_base_class->get_active_member_previous_savings_balance($member_list,$date,$branch_id,$samity_id,$product_id);
		$active_member_savings_auto=$this->savings_base_class->get_active_member_savings_auto($member_list,$date,$branch_id,$samity_id,$product_id);
		$active_member_previous_skt_balance=$this->get_active_member_previous_skt_balance($member_list,$date,$branch_id,$samity_id,$product_id);		
		$active_member_loan_info =$this->loan_base_class->get_active_member_loan_info($member_list,$date,$branch_id,$samity_id,$product_id);
		
		$active_member_loan_schedule_info =$this->loan_base_class->get_active_member_loan_schedule_info($active_member_array,$date,$branch_id,$samity_id,$product_id); 			
		
		$samity_wise_monthly_savings_loan_collection_report_data=array();
		$i=0;
		foreach($active_member_name_code as $row)
		{
			$i++;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['member_name']=$row->member_name;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['member_code']=$row->member_code;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['member_id']=$row->id;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['loan_disbuse_date']="";
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['loan_amount']=0;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['cycle']=0;				
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['purpose_code']=0;	
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['repay_week']=0;	
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['previous_month_outstanding']=0;	
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['preious_month_due']=0;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['loan_auto']=0;	
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['previous_savings_balance']=0;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['previous_skt_balance']=0;
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['savings_auto']=0;				
			$samity_wise_monthly_savings_loan_collection_report_data[$i]['pre_matuired_week']=0;
			if (array_key_exists($row->id, $active_member_previous_savings_balance)) { 
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['previous_savings_balance']=$active_member_previous_savings_balance[$row->id];
			}
			if (array_key_exists($row->id,$active_member_savings_auto)) {
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['savings_auto']=$active_member_savings_auto[$row->id];
			}
			if (array_key_exists($row->id,$active_member_previous_skt_balance)) {
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['previous_skt_balance']=$active_member_previous_skt_balance[$row->id];
			}
			if (array_key_exists($row->id, $active_member_loan_info)) { 
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['loan_disbuse_date']=$active_member_loan_info[$row->id]['disburse_date'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['loan_amount']=$active_member_loan_info[$row->id]['loan_amount'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['cycle']=$active_member_loan_info[$row->id]['cycle'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['purpose_code']=$active_member_loan_info[$row->id]['purpose_code'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['repay_week']=$active_member_loan_info[$row->id]['repay_week'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['previous_month_outstanding']=$active_member_loan_info[$row->id]['prev_loan_outstanding'];	
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['loan_auto']=$active_member_loan_info[$row->id]['installment_amount'];	
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['total_payable_amount']=$active_member_loan_info[$row->id]['total_payable_amount'];
			}
			if (array_key_exists($row->id,$active_member_loan_schedule_info)) {
				$amount=$active_member_loan_schedule_info[$row->id]['installment_number']*$active_member_loan_schedule_info[$row->id]['installment_amount'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['pre_matuired_week']=$active_member_loan_schedule_info[$row->id]['installment_number'];
				$samity_wise_monthly_savings_loan_collection_report_data[$i]['preious_month_due']=$samity_wise_monthly_savings_loan_collection_report_data[$i]['total_payable_amount']-$amount;	
			}			
		}
		return $samity_wise_monthly_savings_loan_collection_report_data;		
	}
	//***********************************************Branch Manager Report********************************************************************************************************************************************************************************************************************************************************************************
	/*
	 * branch_manager_report_data Beginning of the week
	 * @Auth: Taposhi Rabeya
	 * @date: 30-Mar-2011   
	*/	
	function get_branch_manager_report_data($branch_id=null,$product_id=null,$from_date=null,$to_date=null)
	{
		//print($branch_id);print($product_id);print($from_date);die;
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		//print($to_date);die;
		
		$samity_list_string=$this->get_branch_wise_samity_list_as_string($branch_id,$product_id,$from_date,$to_date);
	
		//echo "<pre>";print_r($samity_list_string);die;	
		$samity_list_array=$this->get_branch_wise_samity_list_as_array($samity_list_string);
			
		$branch_wise_active_employee_information=$this->get_branch_wise_active_employee_information($samity_list_string);		
		//echo "<pre>";print_r($branch_wise_active_employee_information);die;
			
		$branch_manager_report_data=array(); 

		if(!empty($samity_list_string)){
			
			$branch_wise_member_no=$this->get_branch_wise_member_no($samity_list_string,$branch_id,$product_id,$from_date,$to_date);
			//echo "<pre>";print_r($branch_wise_member_no);die;
			$branch_wise_members_savings=$this->get_branch_wise_members_savings($samity_list_string,$branch_id,$product_id,$from_date,$to_date);
			//echo "<pre>";print_r($branch_wise_members_savings);die;
			$branch_wise_loan_information=$this->get_branch_wise_loan_information($samity_list_string,$branch_id,$product_id,$from_date,$to_date);
			//echo "<pre>";print_r($branch_wise_loan_information);die;
			$branch_wise_fully_paid_loan_information=$this->get_branch_wise_fully_paid_loan_information($samity_list_string,$branch_id,$product_id,$from_date,$to_date);
			//echo "<pre>";print_r($branch_wise_fully_paid_loan_information);die;
			$branch_wise_loan_transaction_information=$this->get_branch_wise_loan_transaction_information($samity_list_string,$branch_id,$product_id,$from_date,$to_date);	
			//echo "<pre>";print_r($branch_wise_loan_transaction_information);
			$branch_wise_expired_loan_information=$this->get_branch_wise_exp_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id,$to_date);
			//echo "<pre>";print_r($branch_wise_expired_loan_information);die;
			//echo "Amalan";die;
			$branch_wise_loan_schedule_information=$this->get_branch_wise_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id,$to_date);
			//echo "<pre>";print_r($branch_wise_loan_schedule_information);die;
			//echo "Amalan";
			//echo $to_date;
			//die;
			if(!empty($to_date)){
				$branch_wise_admission_members_no=$this->get_branch_wise_admission_member_no($samity_list_string,$branch_id,$product_id,$from_date,$to_date);
				//echo "<pre>";print_r($branch_wise_admission_members_no);die;
				$branch_wise_closing_members_no=$this->get_branch_wise_closing_member_no($samity_list_string,$branch_id,$product_id,$from_date,$to_date);
				///echo "Amalan";die;
				//echo "<pre>";print_r($branch_wise_closing_members_no);die;
			}
			//echo $to_date;
			//echo "Amalan";die;
			$i=0;
			//print_r($branch_wise_active_employee_information);die;
			foreach($branch_wise_active_employee_information as $row)
			{			
				//print('<br>');print_r($row);
				if($i==0)
				{
					$previous_employee_id=$row->employee_id;
					//print_r($previous_employee_id);die;
					$branch_manager_report_data[$row->employee_id]['employee_id']=$row->employee_id;
					$branch_manager_report_data[$row->employee_id]['employee_name']=$row->employee_name;
					$branch_manager_report_data[$row->employee_id]['employee_code']=$row->employee_code;
					$branch_manager_report_data[$row->employee_id]['admission_member_no']=0;
					$branch_manager_report_data[$row->employee_id]['closing_member_no']=0;
					$branch_manager_report_data[$row->employee_id]['member_no']=0;
					$branch_manager_report_data[$row->employee_id]['savings']=0;
					$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']=0;
					$branch_manager_report_data[$row->employee_id]['cum_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']=0;
					$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['cum_exp_borrower']=0;
					$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['current_borrower']=0;
					$branch_manager_report_data[$row->employee_id]['current_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']=0;
					$branch_manager_report_data[$row->employee_id]['transaction_amount']=0; //Regular recoverable amount
					$branch_manager_report_data[$row->employee_id]['overdue']=0; 
					$branch_manager_report_data[$row->employee_id]['outstanding']=0;						
					$branch_manager_report_data[$row->employee_id]['overdue_transaction_amount']=0;
					$branch_manager_report_data[$row->employee_id]['advance']=0;//advance recoverable amount
					$branch_manager_report_data[$row->employee_id]['recovery_total']=0;
					$branch_manager_report_data[$row->employee_id]['due']=0;//due recoverable amount
					$branch_manager_report_data[$row->employee_id]['new_due']=0;
					$branch_manager_report_data[$row->employee_id]['total_overdue']=0;
					$branch_manager_report_data[$row->employee_id]['total_outstanding']=0;
					$branch_manager_report_data[$row->employee_id]['payable_amount']=0;
					
					if(isset($branch_wise_member_no)){
                                           if (array_key_exists($row->samity_id,$branch_wise_member_no)) { 
						$branch_manager_report_data[$row->employee_id]['member_no']=$branch_wise_member_no[$row->samity_id]['member_no'];
                                            } 
                                        }
					if(isset($branch_wise_admission_members_no)){
						if (array_key_exists($row->samity_id,$branch_wise_admission_members_no)) { 
							$branch_manager_report_data[$row->employee_id]['admission_member_no']=$branch_wise_admission_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_closing_members_no)){
						if (array_key_exists($row->samity_id,$branch_wise_closing_members_no)) { 
							$branch_manager_report_data[$row->employee_id]['closing_member_no']=$branch_wise_closing_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_members_savings)){
							if (array_key_exists($row->samity_id,$branch_wise_members_savings)) { 
							$branch_manager_report_data[$row->employee_id]['savings']=$branch_wise_members_savings[$row->samity_id]['savings'];
						}
					}
					if(isset($branch_wise_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']=$branch_wise_loan_information[$row->samity_id]['cum_disbursement_no'];
							$branch_manager_report_data[$row->employee_id]['cum_loan_amount']=$branch_wise_loan_information[$row->samity_id]['cum_loan_amount'];
							$branch_manager_report_data[$row->employee_id]['payable_amount']=$branch_wise_loan_information[$row->samity_id]['cum_payable_amount'];
						}
					}
					if(isset($branch_wise_loan_transaction_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_transaction_information)) { 
							$branch_manager_report_data[$row->employee_id]['transaction_amount']=$branch_wise_loan_transaction_information[$row->samity_id]['transaction_amount'];
						}
					}
					if(isset($branch_wise_fully_paid_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_fully_paid_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']=$branch_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_disbursement_no'];
							$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']=$branch_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_amount'];	
						}
					}
					if(isset($branch_wise_expired_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_expired_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_exp_borrower']=$branch_wise_expired_loan_information[$row->samity_id]['no_cumilative_expaired_borrower'];
							$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount']=$branch_wise_expired_loan_information[$row->samity_id]['cumilative_expaired_borrower_amount'];	
							$branch_manager_report_data[$row->employee_id]['overdue_transaction_amount']=$branch_wise_expired_loan_information[$row->samity_id]['exp_loan_transaction_amount'];
							$branch_manager_report_data[$row->employee_id]['overdue']=$branch_wise_expired_loan_information[$row->samity_id]['overdue'];
						}
					}
					if(isset($branch_wise_loan_schedule_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_schedule_information)) { 
							$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']=$branch_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount'];
							if($branch_manager_report_data[$row->employee_id]['transaction_amount']>$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']){
								$branch_manager_report_data[$row->employee_id]['advance']=$branch_manager_report_data[$row->employee_id]['transaction_amount']-$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount'];
							}
							else{
                                                            $branch_manager_report_data[$row->employee_id]['due']=$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount'];
                                                        }
							$branch_manager_report_data[$row->employee_id]['outstanding']=$branch_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount'];
						}
					}
					$branch_manager_report_data[$row->employee_id]['current_borrower']=$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']-$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']-$branch_manager_report_data[$row->employee_id]['cum_exp_borrower'];
					$branch_manager_report_data[$row->employee_id]['current_loan_amount']=$branch_manager_report_data[$row->employee_id]['cum_loan_amount']-$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']-$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount'];			
					$branch_manager_report_data[$row->employee_id]['recovery_total']=$branch_manager_report_data[$row->employee_id]['transaction_amount']+$branch_manager_report_data[$row->employee_id]['overdue']+$branch_manager_report_data[$row->employee_id]['advance'];			
					$branch_manager_report_data[$row->employee_id]['new_due']=$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount'];
					$branch_manager_report_data[$row->employee_id]['total_overdue']=$branch_manager_report_data[$row->employee_id]['due']+$branch_manager_report_data[$row->employee_id]['overdue'];
					$branch_manager_report_data[$row->employee_id]['total_outstanding']=$branch_manager_report_data[$row->employee_id]['outstanding']+$branch_manager_report_data[$row->employee_id]['payable_amount']-$branch_manager_report_data[$row->employee_id]['recovery_total'];
					//print($i.'----Mitu----');print('<br>');echo "<pre>";print_r($branch_manager_report_data);die;
				}		
				if($i!=0 && $previous_employee_id==$row->employee_id)
				{
					if(isset($branch_wise_member_no)){
						if (array_key_exists($row->samity_id,$branch_wise_member_no)) { 
							$branch_manager_report_data[$row->employee_id]['member_no']=$branch_manager_report_data[$row->employee_id]['member_no']+$branch_wise_member_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_admission_members_no)){
						if (array_key_exists($row->samity_id,$branch_wise_admission_members_no)) { 
							$branch_manager_report_data[$row->employee_id]['admission_member_no']=$branch_manager_report_data[$row->employee_id]['admission_member_no']+$branch_wise_admission_members_no[$row->samity_id]['member_no'];
						}
					}					
					if(isset($branch_wise_closing_members_no)){
						if (array_key_exists($row->samity_id,$branch_wise_closing_members_no)) { 
							$branch_manager_report_data[$row->employee_id]['closing_member_no']=$branch_manager_report_data[$row->employee_id]['closing_member_no']+$branch_wise_closing_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_members_savings)){
						if (array_key_exists($row->samity_id,$branch_wise_members_savings)) { 
							$branch_manager_report_data[$row->employee_id]['savings']=$branch_manager_report_data[$row->employee_id]['savings']+$branch_wise_members_savings[$row->samity_id]['savings'];
						}
					}
					if(isset($branch_wise_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']=$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']+$branch_wise_loan_information[$row->samity_id]['cum_disbursement_no'];
							$branch_manager_report_data[$row->employee_id]['cum_loan_amount']=$branch_manager_report_data[$row->employee_id]['cum_loan_amount']+$branch_wise_loan_information[$row->samity_id]['cum_loan_amount'];
							$branch_manager_report_data[$row->employee_id]['payable_amount']=$branch_manager_report_data[$row->employee_id]['payable_amount']+$branch_wise_loan_information[$row->samity_id]['cum_payable_amount'];
						}
					}
					if(isset($branch_wise_loan_transaction_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_transaction_information)) { 
							$branch_manager_report_data[$row->employee_id]['transaction_amount']=$branch_manager_report_data[$row->employee_id]['transaction_amount']+$branch_wise_loan_transaction_information[$row->samity_id]['transaction_amount'];
						}
					}
					if(isset($branch_wise_expired_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_expired_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_exp_borrower']=$branch_manager_report_data[$row->employee_id]['cum_exp_borrower']+$branch_wise_expired_loan_information[$row->samity_id]['no_cumilative_expaired_borrower'];
							$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount']=$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount']+$branch_wise_expired_loan_information[$row->samity_id]['cumilative_expaired_borrower_amount'];	
							$branch_manager_report_data[$row->employee_id]['overdue_transaction_amount']=$branch_manager_report_data[$row->employee_id]['overdue_transaction_amount']+$branch_wise_expired_loan_information[$row->samity_id]['exp_loan_transaction_amount'];
							$branch_manager_report_data[$row->employee_id]['overdue']=$branch_manager_report_data[$row->employee_id]['overdue']+$branch_wise_expired_loan_information[$row->samity_id]['overdue'];
						}	
					}
					if(isset($branch_wise_fully_paid_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_fully_paid_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']=$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']+$branch_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_disbursement_no'];
							$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']=$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']+$branch_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_amount'];
						}	
					}
					if(isset($branch_wise_loan_schedule_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_schedule_information)) { 
							$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']+=$branch_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount'];
							if($branch_manager_report_data[$row->employee_id]['transaction_amount']>$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']){
								$branch_manager_report_data[$row->employee_id]['advance']=$branch_manager_report_data[$row->employee_id]['advance']+($branch_manager_report_data[$row->employee_id]['transaction_amount']-$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']);
							}
							else{
                                                            $branch_manager_report_data[$row->employee_id]['due']=$branch_manager_report_data[$row->employee_id]['due']+($branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount']);
                                                        }
							$branch_manager_report_data[$row->employee_id]['outstanding']=$branch_manager_report_data[$row->employee_id]['outstanding']+($branch_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount']);
						}
					}
					$branch_manager_report_data[$row->employee_id]['current_borrower']=$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']-$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']-$branch_manager_report_data[$row->employee_id]['cum_exp_borrower'];
					$branch_manager_report_data[$row->employee_id]['current_loan_amount']=$branch_manager_report_data[$row->employee_id]['cum_loan_amount']-$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']-$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount'];
					$branch_manager_report_data[$row->employee_id]['recovery_total']=$branch_manager_report_data[$row->employee_id]['recovery_total']+($branch_manager_report_data[$row->employee_id]['transaction_amount']+$branch_manager_report_data[$row->employee_id]['overdue']+$branch_manager_report_data[$row->employee_id]['advance']);			
					$branch_manager_report_data[$row->employee_id]['new_due']=$branch_manager_report_data[$row->employee_id]['new_due']+($branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount']);
					$branch_manager_report_data[$row->employee_id]['total_overdue']=$branch_manager_report_data[$row->employee_id]['total_overdue']+$branch_manager_report_data[$row->employee_id]['due']+$branch_manager_report_data[$row->employee_id]['overdue'];
					$branch_manager_report_data[$row->employee_id]['total_outstanding']=$branch_manager_report_data[$row->employee_id]['total_outstanding']+($branch_manager_report_data[$row->employee_id]['outstanding']+$branch_manager_report_data[$row->employee_id]['payable_amount']-$branch_manager_report_data[$row->employee_id]['recovery_total']);
					//print($i.'---Nitu-----');print('<br>');echo "<pre>";print_r($branch_manager_report_data);die;
				}	
				elseif($i!=0 && $previous_employee_id!=$row->employee_id)
				{
					//print_r($row);die;
					$previous_employee_id=$row->employee_id;
					$branch_manager_report_data[$row->employee_id]['employee_id']=$row->employee_id;
					$branch_manager_report_data[$row->employee_id]['employee_name']=$row->employee_name;
					$branch_manager_report_data[$row->employee_id]['employee_code']=$row->employee_code;
					$branch_manager_report_data[$row->employee_id]['member_no']=0;
					$branch_manager_report_data[$row->employee_id]['admission_member_no']=0;
					$branch_manager_report_data[$row->employee_id]['closing_member_no']=0;
					$branch_manager_report_data[$row->employee_id]['savings']=0;
					$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']=0;
					$branch_manager_report_data[$row->employee_id]['cum_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']=0;
					$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['cum_exp_borrower']=0;
					$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['current_borrower']=0;
					$branch_manager_report_data[$row->employee_id]['current_loan_amount']=0;
					$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']=0;
					$branch_manager_report_data[$row->employee_id]['transaction_amount']=0; //Regular recoverable amount
					$branch_manager_report_data[$row->employee_id]['overdue']=0; //overdue recoverable amount
					$branch_manager_report_data[$row->employee_id]['outstanding']=0;						
					$branch_manager_report_data[$row->employee_id]['overdue_transaction_amount']=0;
					$branch_manager_report_data[$row->employee_id]['advance']=0;//advance recoverable amount		
					$branch_manager_report_data[$row->employee_id]['recovery_total']=0;
					$branch_manager_report_data[$row->employee_id]['due']=0;//due recoverable amount
					$branch_manager_report_data[$row->employee_id]['new_due']=0;
					$branch_manager_report_data[$row->employee_id]['total_overdue']=0;
					$branch_manager_report_data[$row->employee_id]['total_outstanding']=0;
					$branch_manager_report_data[$row->employee_id]['payable_amount']=0;
					
					if(isset($branch_wise_member_no)){
						if (array_key_exists($row->samity_id,$branch_wise_member_no)) { 
							$branch_manager_report_data[$row->employee_id]['member_no']=$branch_wise_member_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_admission_members_no)){
						if (array_key_exists($row->samity_id,$branch_wise_admission_members_no)) { 
							$branch_manager_report_data[$row->employee_id]['admission_member_no']=$branch_wise_admission_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_closing_members_no)){
						if (array_key_exists($row->samity_id,$branch_wise_closing_members_no)) { 
							$branch_manager_report_data[$row->employee_id]['closing_member_no']=$branch_wise_closing_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_wise_members_savings)){
						if (array_key_exists($row->samity_id,$branch_wise_members_savings)) { 
							$branch_manager_report_data[$row->employee_id]['savings']=$branch_wise_members_savings[$row->samity_id]['savings'];
						}
					}
					if(isset($branch_wise_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']=$branch_wise_loan_information[$row->samity_id]['cum_disbursement_no'];
							$branch_manager_report_data[$row->employee_id]['cum_loan_amount']=$branch_wise_loan_information[$row->samity_id]['cum_loan_amount'];
							$branch_manager_report_data[$row->employee_id]['payable_amount']=$branch_wise_loan_information[$row->samity_id]['cum_payable_amount'];
						}
					}
					if(isset($branch_wise_loan_transaction_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_transaction_information)) { 
							$branch_manager_report_data[$row->employee_id]['transaction_amount']=$branch_wise_loan_transaction_information[$row->samity_id]['transaction_amount'];
						}
					}
					if(isset($branch_wise_expired_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_expired_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_exp_borrower']=$branch_wise_expired_loan_information[$row->samity_id]['no_cumilative_expaired_borrower'];
							$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount']=$branch_wise_expired_loan_information[$row->samity_id]['cumilative_expaired_borrower_amount'];	
							$branch_manager_report_data[$row->employee_id]['overdue_transaction_amount']=$branch_wise_expired_loan_information[$row->samity_id]['exp_loan_transaction_amount'];
							$branch_manager_report_data[$row->employee_id]['overdue']=$branch_wise_expired_loan_information[$row->samity_id]['overdue'];
						}	
					}
					if(isset($branch_wise_fully_paid_loan_information)){
						if (array_key_exists($row->samity_id,$branch_wise_fully_paid_loan_information)) { 
							$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']=$branch_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_disbursement_no'];
							$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']=$branch_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_amount'];	
						}
					}
					if(isset($branch_wise_loan_schedule_information)){
						if (array_key_exists($row->samity_id,$branch_wise_loan_schedule_information)) { 	
							$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']=$branch_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount'];
							if($branch_manager_report_data[$row->employee_id]['transaction_amount']>$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']){
                                                            $branch_manager_report_data[$row->employee_id]['advance']=$branch_manager_report_data[$row->employee_id]['transaction_amount']-$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount'];
							}
							else{
                                                            $branch_manager_report_data[$row->employee_id]['due']=$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount'];
                                                        }
							$branch_manager_report_data[$row->employee_id]['outstanding']=$branch_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount'];
						}
					}
					$branch_manager_report_data[$row->employee_id]['current_borrower']=$branch_manager_report_data[$row->employee_id]['cum_disbursement_no']-$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_disbursement_no']-$branch_manager_report_data[$row->employee_id]['cum_exp_borrower'];
					$branch_manager_report_data[$row->employee_id]['current_loan_amount']=$branch_manager_report_data[$row->employee_id]['cum_loan_amount']-$branch_manager_report_data[$row->employee_id]['cum_fully_paid_loan_amount']-$branch_manager_report_data[$row->employee_id]['cum_exp_loan_amount'];					
					$branch_manager_report_data[$row->employee_id]['recovery_total']=$branch_manager_report_data[$row->employee_id]['transaction_amount']+$branch_manager_report_data[$row->employee_id]['overdue']+$branch_manager_report_data[$row->employee_id]['advance'];			
					$branch_manager_report_data[$row->employee_id]['new_due']=$branch_manager_report_data[$row->employee_id]['loan_recoverable_amount']-$branch_manager_report_data[$row->employee_id]['transaction_amount'];
					$branch_manager_report_data[$row->employee_id]['total_overdue']=$branch_manager_report_data[$row->employee_id]['due']+$branch_manager_report_data[$row->employee_id]['overdue'];
					$branch_manager_report_data[$row->employee_id]['total_outstanding']=$branch_manager_report_data[$row->employee_id]['outstanding']+$branch_manager_report_data[$row->employee_id]['payable_amount']-$branch_manager_report_data[$row->employee_id]['recovery_total'];
					//print('<br>');echo "<pre>";print_r($branch_manager_report_data);
				}
				$i++;	
			}
			
		}		
		//print_r('hello');die;
		//echo "<pre>";print_r($branch_manager_report_data);die;
		return $branch_manager_report_data;
	}		
	function get_selected_branches_info_with_branch_manager($branch_id)
	{
		if(empty($branch_id)){
			return false;
		}
		$query="SELECT po_branches.id AS branch_id,employees.name AS employee_name,employees.code AS employee_code
			FROM employees JOIN employee_designations ON employees.designation_id=employee_designations.id
			JOIN po_branches ON employees.branch_id=po_branches.id
			WHERE is_manager=1 AND po_branches.id=$branch_id";		
		$query=$this->db->query($query);
		$query=$query->result();				
		return $query;
	}
	function get_branch_wise_samity_list_as_string($branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		$query="SELECT samity_id FROM (
					SELECT samity_id FROM members WHERE branch_id=$branch_id
					AND `primary_product_id`=$product_id AND member_status='Active'";
					if(empty($to_date)){
						$query.=" AND `registration_date`<'$from_date'";
					}
					else
					{
						$query.=" AND `registration_date` between '$from_date'  and '$to_date' ";
					}

					$query.=" UNION 

					SELECT samity_id FROM loans WHERE branch_id=$branch_id
					AND `product_id`=$product_id AND current_status=1 ";
					if(empty($to_date)){
						$query.=" AND `disburse_date`<'$from_date' ) AS temp";
					}
					else
					{
						$query.=" AND `disburse_date` between '$from_date'  and '$to_date' ) AS temp";
					}	
					$query.=" ORDER BY samity_id";
			//print($query);die;
			$query=$this->db->query($query);
			$query=$query->result();				
			$data=array();
			if(!empty($query)){		
				foreach($query as $query)
				{			
					$data[] = $query->samity_id;				
				}
				$data= join(',',$data);	
			}			
		return $data;
	}
	function get_branch_wise_samity_list_as_array($samity_list)
	{
		if(empty($samity_list)) {
			return false;
		}
		$data=array();
		$data=explode(',',$samity_list);		
		return $data;
	}
	
	function get_branch_wise_active_employee_information($samity_list_string)
	{
		//print($branch_id);print($product_id);print($from_date);print($to_date);
		if(empty($samity_list_string)) {
			return false;
		}
		$query="SELECT samities.id AS samity_id,employees.id AS employee_id,employees.name AS employee_name,employees.code AS employee_code,samities.name as samity_name,samities.code as samity_code
			FROM employees JOIN samities ON employees.id=samities.field_officer_id
			WHERE samities.id IN ($samity_list_string) and employees.`status`=1
			ORDER BY employees.id";			
		$query=$this->db->query($query);		
		$query=$query->result();		
		$data=array();				
		if(!empty($query)){		
			foreach($query as $query)
			{			
				$data[$query->samity_id]->samity_id=$query->samity_id;
				$data[$query->samity_id]->employee_id=$query->employee_id;
				$data[$query->samity_id]->employee_name=$query->employee_name;
				$data[$query->samity_id]->employee_code=$query->employee_code;
				$data[$query->samity_id]->samity_name=$query->samity_name;
				$data[$query->samity_id]->samity_code=$query->samity_code;
			}			
		}		
		//echo "<pre>";print_r($data);die;
		return $data;
	}
	function get_branch_wise_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		$query="SELECT samity_id,COUNT(DISTINCT members.id) AS member_no
				FROM members 
				WHERE samity_id IN ($samity_list) 
				AND member_status='Active'
				AND branch_id=$branch_id
				AND primary_product_id=$product_id";
				if(empty($to_date)){
					$query .= " AND registration_date<'$from_date'";
				}
				else{
					$query .= " AND registration_date between '$from_date' AND '$to_date'";					
				}
				$query .= "GROUP BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result($query);
		
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{				
				$data[$query['samity_id']]['member_no']=$query['member_no'];
			}
		}		
		return $data;
	}	
	function get_branch_wise_admission_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date) || empty($to_date)) {
			return false;
		}
		$query="SELECT samity_id,COUNT(DISTINCT members.id) AS member_no
				FROM members 
				WHERE samity_id IN ($samity_list) 
				AND member_status='Active'
				AND branch_id=$branch_id AND primary_product_id=$product_id
				 AND registration_date BETWEEN '$from_date' AND '$to_date'					
				GROUP BY samity_id ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result($query);		
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{				
				$data[$query['samity_id']]['member_no']=$query['member_no'];
			}
		}		
		return $data;
	}
	function get_branch_wise_closing_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date) || empty($to_date)) {
			return false;
		}
		$query="SELECT samity_id,COUNT(DISTINCT member_closing.id) AS member_no
				FROM member_closing  
				WHERE samity_id IN ($samity_list) 			
				AND branch_id=$branch_id AND member_primary_product_id=$product_id AND closing_date BETWEEN '$from_date' AND '$to_date'					
				GROUP BY samity_id ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result($query);		
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{				
				$data[$query['samity_id']]['member_no']=$query['member_no'];
			}
		}		
		return $data;
	}
	function get_branch_wise_members_savings($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT samity_id,SUM(amount)AS savings
				FROM saving_deposits 
				WHERE saving_deposits.branch_id=$branch_id AND is_authorized=1 AND samity_id IN ($samity_list)  
				AND member_primary_product_id=$product_id";				
			if(empty($to_date)){
				$query.=" AND transaction_date<'$from_date'";
			}
			else{
				$query.=" AND transaction_date between '$from_date' AND '$to_date'";
			}
			$query.="GROUP BY samity_id	ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data[$query->samity_id]['savings']=$query->savings;
			}
		}		
		return $data;
	}
	function get_branch_wise_loan_information($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT samity_id,COUNT(DISTINCT loans.id) AS cum_disbursement_no,SUM(loan_amount) AS cum_loan_amount,sum(total_payable_amount) AS total_payable_amount
				FROM loans 
				WHERE loans.branch_id=$branch_id AND is_authorized=1
				AND samity_id IN ($samity_list) AND product_id=$product_id";
			if(empty($to_date)){
				$query.=" AND disburse_date<'$from_date' ";
			}
			else{
				$query.=" AND disburse_date between '$from_date' AND '$to_date'";
			}
			$query.="GROUP BY samity_id	ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();			
		$data=array();
		if(!empty($query)){		
			foreach($query as $query) 
			{
				$data[$query->samity_id]['cum_disbursement_no']=$query->cum_disbursement_no;
				$data[$query->samity_id]['cum_loan_amount']=$query->cum_loan_amount;
				$data[$query->samity_id]['cum_payable_amount']=$query->total_payable_amount;
			}
		}		
		return $data;
	}
	function get_branch_wise_fully_paid_loan_information($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT samity_id,COUNT(DISTINCT loans.id) AS cum_fully_paid_loan_disbursement_no
			,SUM(loan_amount) AS cum_fully_paid_loan_amount
			FROM loans 
			WHERE loans.branch_id=$branch_id AND is_authorized=1 AND samity_id IN ($samity_list) AND product_id=$product_id AND is_loan_fully_paid=1";
			if(empty($to_date))			{
				$query.=" AND disburse_date<'$from_date'"; 
			}
			else{
				$query.=" AND disburse_date between '$from_date' AND '$to_date'"; 
			}
			$query.="GROUP BY samity_id	ORDER BY samity_id";	
		$query=$this->db->query($query);
		$query=$query->result();			
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data[$query->samity_id]['cum_fully_paid_loan_disbursement_no']=$query->cum_fully_paid_loan_disbursement_no;
				$data[$query->samity_id]['cum_fully_paid_loan_amount']=$query->cum_fully_paid_loan_amount;
			}
		}		
		return $data;
	}	
	function get_branch_wise_loan_transaction_information($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT loan_transactions.samity_id,SUM(transaction_amount) AS transaction_amount
			FROM loan_transactions JOIN loans ON loan_transactions.loan_id=loans.id
			WHERE loan_transactions.branch_id=$branch_id AND loan_transactions.is_authorized=1
			AND loan_transactions.samity_id IN ($samity_list) AND loan_transactions.product_id=$product_id AND is_loan_fully_paid=0";
			if(empty($to_date)){
				$query.=" AND transaction_date<'$from_date' ";
			}else{			
				$query.=" AND transaction_date between '$from_date' AND '$to_date'";
			}			
			$query.="GROUP BY loan_transactions.samity_id ORDER BY loan_transactions.samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();				
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data[$query->samity_id]['transaction_amount']=$query->transaction_amount;			
			}
		}		
		return $data;
	}	
	function get_branch_wise_exp_loan_transaction_information($loan_list=null,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT sum(transaction_amount) AS transaction_amount
				FROM loan_transactions 
				WHERE branch_id=$branch_id AND is_authorized=1
				AND loan_id IN ($loan_list) AND product_id=$product_id";
			if(empty($to_date)){
				$query.=" AND transaction_date<'$from_date' ";
			}
			else{
				$query.=" AND transaction_date between '$from_date'  AND '$to_date'";				
			}
			$query.="GROUP BY samity_id	ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();				
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data['transaction_amount']=$query->transaction_amount;			
			}
		}		
		return $data;
	}
	//loan schedule data--------------------------------------------------------------
	
	function get_branch_wise_exp_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id,$to_date=null)
	{
		//print_r($samity_list_array);print($from_date);print($branch_id);print($product_id);print($to_date);die;
		if(empty($to_date)){
			$loan=$this->loan_base_class->get_samity_wise_expired_loan_information_before_date($samity_list_array,$from_date,$branch_id,$product_id);
		}
		else{
			$loan=$this->loan_base_class->get_samity_wise_expired_loan_information_between_date($samity_list_array,$from_date,$to_date,$branch_id,$product_id);
		}
		$data=array();		
		//print('Mitu');echo "<pre>";print_r($loan);		
		foreach($samity_list_array as $samity)
		{
			$samity_array[$samity]=$samity;
		}
		if(isset($loan[0])){
			foreach($loan[0] as $query){
				if(isset($query['samity_id'])){
					if (array_key_exists($query['samity_id'],$samity_array)) {				
						$loan_recoverable_amount=0;				
						$loan_list=array(0);							
						if(!empty($query)){		
							foreach($query as $row)
							{
								if(isset($row['loan_id'])){
									$loan_list[]=$row['loan_id'];		
								}			
								$loan_recoverable_amount=$loan_recoverable_amount+($row['installment_no']*$row['installment_amount']);
							}	
						}
						$loan_list = join(',',$loan_list);	
						//print($loan_list);die;	
						$data[$query['samity_id']]['exp_loan_transaction_amount']=0;				
						if(isset($loan_list))
						{
							$loan_info=$this->get_branch_wise_exp_loan_transaction_information($loan_list,$branch_id,$product_id,$from_date);
							//print_r($loan_info);die;
							if(isset($loan_info[0]))
							{
								$data[$query['samity_id']]['exp_loan_transaction_amount']=$loan_info[0]['transaction_amount'];
							}
						}				
						//print($loan_list);die;								
						$data[$query['samity_id']]['no_cumilative_expaired_borrower']=$query['no_cumilative_expaired_borrower'];
						$data[$query['samity_id']]['cumilative_expaired_borrower_amount']=$query['cumilative_expaired_borrower_amount'];
						$data[$query['samity_id']]['loan_recoverable_amount']=$loan_recoverable_amount;	
						$data[$query['samity_id']]['exp_loan_transaction_amount']=$data[$query['samity_id']]['exp_loan_transaction_amount'];
						$data[$query['samity_id']]['overdue']=$loan_recoverable_amount-$data[$query['samity_id']]['exp_loan_transaction_amount'];	
					}
				}				
			}
		}		
		//print('<br>');echo "<pre>";print_r($data);die;
		return $data;
	}
	function get_branch_wise_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id,$to_date=null)	
	{
		if(empty($to_date)){
			//print('amlan');die;
			$loan=$this->loan_base_class->get_samity_wise_current_loan_information_before_date($samity_list_array,$from_date,$branch_id,$product_id);
		}
		else{
			$loan=$this->loan_base_class->get_samity_wise_current_loan_information_between_date($samity_list_array,$from_date,$to_date,$branch_id,$product_id);
		}
		$data=array();		
		foreach($samity_list_array as $samity)
		{
			$samity_array[$samity]=$samity;
		}
		//print('Mitu');echo "<pre>";print_r($loan);die;
		if(isset($loan)){
			foreach($loan as $query)
			{
				if(isset($query['samity_id'])){
					if (array_key_exists($query['samity_id'],$samity_array)) {	
					
						$laon_recoverable_amount=0;
						foreach($query as $loan)
						{
							$laon_recoverable_amount=$laon_recoverable_amount+($loan['installment_no']*$loan['installment_amount']);
						}
						$data[$query['samity_id']]['loan_recoverable_amount']=$laon_recoverable_amount;	
					}
				}				
			}
		}		
		return $data;
	}	
///***********************************************************************************************

/*function get_branch_field_officer_wise_samity_list_as_array($branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		$query=$this->db->query("SELECT code FROM loan_products WHERE id=$product_id");
		$product_code=$query->row()->code;		
		$query="SELECT samities.id AS samity_id,employees.id AS employee_id ,employees.name AS employee_name,employees.code AS employee_code
				FROM employees JOIN samities ON employees.id=samities.field_officer_id
				WHERE samities.status=1 AND employees.status=1 AND employees.product LIKE('%$product_code%')  AND samities.branch_id=$branch_id AND employees.branch_id=$branch_id";
				if(empty($to_date)){
					$query .=	" AND employees.date_of_joining<'$from_date' AND samities.opening_date<'$from_date'";
				}
				else{			
					$query .=	" AND employees.date_of_joining between '$from_date' AND '$to_date'  AND samities.opening_date between '$from_date' AND '$to_date' ";
				}
				$query .=" ORDER BY samities.id";		
		$query=$this->db->query($query);
		$query=$query->result();				
		$data=array();
		if(!empty($query)){		
			foreach($query as $query){			
				$data[] =trim($query->samity_id);				
			}			
		}			
		return $data;
	}
	function get_branch_field_officer_wise_samity_list_as_string($branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		$query=$this->db->query("SELECT code FROM loan_products WHERE id=$product_id");
		$product_code=$query->row()->code;		
		$query="SELECT samities.id AS samity_id,employees.id AS employee_id,employees.name AS employee_name,employees.code AS employee_code
				FROM employees JOIN samities ON employees.id=samities.field_officer_id
				WHERE samities.status=1 AND employees.status=1 AND employees.product LIKE('%$product_code%') AND samities.branch_id=$branch_id AND employees.branch_id=$branch_id";
				if(empty($to_date)){
					$query .= " AND employees.date_of_joining<'$from_date' AND samities.opening_date<'$from_date'";
				}
				else{
					$query .=	" AND employees.date_of_joining between '$from_date' AND '$to_date'  AND samities.opening_date between '$from_date' AND '$to_date' ";
				}				
				$query .= "ORDER BY samities.id";
		$query=$this->db->query($query);
		$query=$query->result();				
		$data=array();
		if(!empty($query)){		
			foreach($query as $query)
			{			
				$data[] = $query->samity_id;				
			}
			$data= join(',',$data);	
		}			
		return $data;
	}
	function get_branch_field_officer_wise_active_employee_information($branch_id,$product_id,$from_date,$to_date=null)
	{
		//print($branch_id);print($product_id);print($from_date);print($to_date);die;
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		//print_r($product_id);die;
		$query=$this->db->query("SELECT code FROM loan_products WHERE id=$product_id");
		$product_code=$query->row()->code;		
		$query="SELECT samities.id AS samity_id,samities.name AS samity_name,samities.code AS samity_code,employees.id AS employee_id,employees.name AS employee_name,employees.code AS employee_code
			FROM employees JOIN samities ON employees.id=samities.field_officer_id
			WHERE samities.status=1 AND employees.status=1 AND employees.product LIKE('%$product_code%') AND samities.branch_id=$branch_id AND employees.branch_id=$branch_id";
			if(empty($to_date)){
				$query .= " AND employees.date_of_joining<'$from_date' AND samities.opening_date<'$from_date'";	
			}
			else{
				$query .= " AND employees.date_of_joining between '$from_date' AND '$to_date' AND samities.opening_date between '$from_date' AND '$to_date'";
			}
			$query.= "GROUP BY samities.id";		
		
		$query=$this->db->query($query);
		$query=$query->result();
		$data=array();				
		if(!empty($query)){		
			foreach($query as $query)
			{			
				$data[$query->samity_id]->samity_id=$query->samity_id;
				$data[$query->samity_id]->employee_id=$query->employee_id;
				$data[$query->samity_id]->employee_name=$query->employee_name;
				$data[$query->samity_id]->employee_code=$query->employee_code;
				
				$data[$query->samity_id]->samity_name=$query->samity_name;
				$data[$query->samity_id]->samity_code=$query->samity_code;
			}			
		}		
		return $data;
	}*/
	
	function get_branch_field_officer_wise_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
		$query="SELECT samity_id,COUNT(DISTINCT members.id) AS member_no
				FROM members 
				WHERE samity_id IN ($samity_list) 
				AND member_status='Active'
				AND branch_id=$branch_id
				AND primary_product_id=$product_id";
				if(empty($to_date)){
					$query .= " AND registration_date<'$from_date'";
				}
				else{
					$query .= " AND registration_date between '$from_date' AND '$to_date'";					
				}
				$query .= "GROUP BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result($query);
		
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{				
				$data[$query['samity_id']]['member_no']=$query['member_no'];
			}
		}		
		return $data;
	}	
	function get_branch_field_officer_wise_admission_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date) || empty($to_date)) {
			return false;
		}
		$query="SELECT samity_id,COUNT(DISTINCT members.id) AS member_no
				FROM members 
				WHERE samity_id IN ($samity_list) 
				AND member_status='Active'
				AND branch_id=$branch_id AND primary_product_id=$product_id
				 AND registration_date BETWEEN '$from_date' AND '$to_date'					
				GROUP BY samity_id ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result($query);		
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{				
				$data[$query['samity_id']]['member_no']=$query['member_no'];
			}
		}		
		return $data;
	}
	function get_branch_field_officer_wise_closing_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date) || empty($to_date)) {
			return false;
		}
		$query="SELECT samity_id,COUNT(DISTINCT member_closing.id) AS member_no
				FROM member_closing  
				WHERE samity_id IN ($samity_list) 			
				AND branch_id=$branch_id AND member_primary_product_id=$product_id AND closing_date BETWEEN '$from_date' AND '$to_date'					
				GROUP BY samity_id ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result($query);		
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{				
				$data[$query['samity_id']]['member_no']=$query['member_no'];
			}
		}		
		return $data;
	}
	function get_branch_field_officer_wise_members_savings($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT samity_id,SUM(amount)AS savings
				FROM saving_deposits 
				WHERE saving_deposits.branch_id=$branch_id AND is_authorized=1 AND samity_id IN ($samity_list)  
				AND member_primary_product_id=$product_id";				
			if(empty($to_date)){
				$query.=" AND transaction_date<'$from_date'";
			}
			else{
				$query.=" AND transaction_date between '$from_date' AND '$to_date'";
			}
			$query.="GROUP BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data[$query->samity_id]['savings']=$query->savings;
			}
		}		
		return $data;
	}
	function get_branch_field_officer_wise_loan_information($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT samity_id,COUNT(DISTINCT loans.id) AS cum_disbursement_no,SUM(loan_amount) AS cum_loan_amount,sum(total_payable_amount) AS total_payable_amount
				FROM loans 
				WHERE loans.branch_id=$branch_id AND is_authorized=1
				AND samity_id IN ($samity_list) AND product_id=$product_id";
			if(empty($to_date)){
				$query.=" AND disburse_date<'$from_date' ";
			}
			else{
				$query.=" AND disburse_date between '$from_date' AND '$to_date'";
			}
			$query.="GROUP BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();			
		$data=array();
		if(!empty($query)){		
			foreach($query as $query) 
			{
				$data[$query->samity_id]['cum_disbursement_no']=$query->cum_disbursement_no;
				$data[$query->samity_id]['cum_loan_amount']=$query->cum_loan_amount;
				$data[$query->samity_id]['cum_payable_amount']=$query->total_payable_amount;
			}
		}		
		return $data;
	}
	function get_branch_field_officer_wise_fully_paid_loan_information($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT samity_id,COUNT(DISTINCT loans.id) AS cum_fully_paid_loan_disbursement_no
			,SUM(loan_amount) AS cum_fully_paid_loan_amount
			FROM loans 
			WHERE loans.branch_id=$branch_id AND is_authorized=1 AND samity_id IN ($samity_list) AND product_id=$product_id AND is_loan_fully_paid=1";
			if(empty($to_date))			{
				$query.=" AND disburse_date<'$from_date'"; 
			}
			else{
				$query.=" AND disburse_date between '$from_date' AND '$to_date'"; 
			}
			$query.="GROUP BY samity_id";	
		$query=$this->db->query($query);
		$query=$query->result();			
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data[$query->samity_id]['cum_fully_paid_loan_disbursement_no']=$query->cum_fully_paid_loan_disbursement_no;
				$data[$query->samity_id]['cum_fully_paid_loan_amount']=$query->cum_fully_paid_loan_amount;
			}
		}		
		return $data;
	}	
	function get_branch_field_officer_wise_loan_transaction_information($samity_list,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT loan_transactions.samity_id,SUM(transaction_amount) AS transaction_amount
			FROM loan_transactions JOIN loans ON loan_transactions.loan_id=loans.id
			WHERE loan_transactions.branch_id=$branch_id AND loan_transactions.is_authorized=1
			AND loan_transactions.samity_id IN ($samity_list) AND loan_transactions.product_id=$product_id AND is_loan_fully_paid=0";
			if(empty($to_date)){
				$query.=" AND transaction_date<'$from_date' ";
			}else{			
				$query.=" AND transaction_date between '$from_date' AND '$to_date'";
			}			
			$query.="GROUP BY loan_transactions.samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();				
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data[$query->samity_id]['transaction_amount']=$query->transaction_amount;			
			}
		}		
		return $data;
	}	
	function get_branch_field_officer_wise_exp_loan_transaction_information($loan_list=null,$branch_id,$product_id,$from_date,$to_date=null)
	{
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}
			$query="SELECT sum(transaction_amount) AS transaction_amount
				FROM loan_transactions 
				WHERE branch_id=$branch_id AND is_authorized=1
				AND loan_id IN ($loan_list) AND product_id=$product_id";
			if(empty($to_date)){
				$query.=" AND transaction_date<'$from_date' ";
			}
			else{
				$query.=" AND transaction_date between '$from_date'  AND '$to_date'";				
			}
			$query.="GROUP BY samity_id	ORDER BY samity_id";		
		$query=$this->db->query($query);
		$query=$query->result();				
		$data=array();
		if(!empty($query)){
			foreach($query as $query)
			{
				$data['transaction_amount']=$query->transaction_amount;			
			}
		}		
		return $data;
	}
	//loan schedule data----------------------------------------------------------------------------------------------------------------------------------------------------------------
	function get_branch_field_officer_wise_exp_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id,$to_date=null)
	{
		if(empty($to_date)){
			$loan=$this->loan_base_class->get_samity_wise_expired_loan_information_before_date($samity_list_array,$from_date,$branch_id,$product_id);
		}else{
			$loan=$this->loan_base_class->get_samity_wise_expired_loan_information_between_date($samity_list,$from_date,$to_date,$branch_id,$product_id);
		}
		$data=array();		
		//print('Mitu');echo "<pre>";print_r($loan);		
		foreach($samity_list_array as $samity)
		{
			$samity_array[$samity]=$samity;
		}
		foreach($loan[0] as $query)
		{
			if (array_key_exists($query['samity_id'],$samity_array)) {				
				$loan_recoverable_amount=0;				
				$loan_list=array(0);							
				if(!empty($query)){		
					foreach($query as $row)
					{
						if(isset($row['loan_id'])){
							$loan_list[]=$row['loan_id'];		
						}			
						$loan_recoverable_amount=$loan_recoverable_amount+($row['installment_no']*$row['installment_amount']);
					}	
				}
				$loan_list = join(',',$loan_list);	
				//print($loan_list);die;	
				$data[$query['samity_id']]['exp_loan_transaction_amount']=0;				
				if(isset($loan_list))
				{
					$loan_info=$this->get_branch_field_officer_wise_exp_loan_transaction_information($loan_list,$branch_id,$product_id,$from_date);
					//print_r($loan_info);die;
					if(isset($loan_info[0]))
					{
						$data[$query['samity_id']]['exp_loan_transaction_amount']=$loan_info[0]['transaction_amount'];
					}
				}				
				//print($loan_list);die;								
				$data[$query['samity_id']]['no_cumilative_expaired_borrower']=$query['no_cumilative_expaired_borrower'];
				$data[$query['samity_id']]['cumilative_expaired_borrower_amount']=$query['cumilative_expaired_borrower_amount'];
				$data[$query['samity_id']]['loan_recoverable_amount']=$loan_recoverable_amount;	
				$data[$query['samity_id']]['exp_loan_transaction_amount']=$data[$query['samity_id']]['exp_loan_transaction_amount'];
				$data[$query['samity_id']]['overdue']=$loan_recoverable_amount-$data[$query['samity_id']]['exp_loan_transaction_amount'];	
			}				
		}		
		//print('<br>');echo "<pre>";print_r($data);die;
		return $data;
	}
	function get_branch_field_officer_wise_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id,$to_date=null)	
	{
		if(empty($to_date)){
			$loan=$this->loan_base_class->get_samity_wise_current_loan_information_before_date($samity_list_array,$from_date,$branch_id,$product_id);
		}
		else{
			$loan=$this->loan_base_class->get_samity_wise_current_loan_information_between_date($samity_list,$from_date,$to_date,$branch_id,$product_id);
		}
		$data=array();		
		foreach($samity_list_array as $samity)
		{
			$samity_array[$samity]=$samity;
		}
		//print('Mitu');echo "<pre>";print_r($loan);die;
		if(isset($loan[0]))
		{
			foreach($loan[0] as $query)
			{
				if (array_key_exists($query['samity_id'],$samity_array)) {	
				
					$laon_recoverable_amount=0;
					foreach($query as $loan)
					{
						$laon_recoverable_amount=$laon_recoverable_amount+($loan['installment_no']*$loan['installment_amount']);
					}
					$data[$query['samity_id']]['loan_recoverable_amount']=$laon_recoverable_amount;	
				}				
			}	
		}
		return $data;
	}
	
	
	function get_branch_field_officer_report_data($branch_id=null,$product_id=null,$from_date=null,$to_date=null)
	{
		//print($branch_id);print($product_id);print($from_date);die;
		if(empty($branch_id) || empty($product_id) || empty($from_date)) {
			return false;
		}		
		$samity_list_string=$this->get_branch_wise_samity_list_as_string($branch_id,$product_id,$from_date,$to_date);	
		//echo "<pre>";print_r($samity_list_string);die;	
		$samity_list_array=$this->get_branch_wise_samity_list_as_array($samity_list_string);			
		$branch_field_officer_wise_active_employee_information=$this->get_branch_wise_active_employee_information($samity_list_string);
		
		/*$branch_field_officer_wise_active_employee_information=$this->get_branch_field_officer_wise_active_employee_information($branch_id,$product_id,$from_date,$to_date=null);		
		//echo "<pre>";print_r($branch_field_officer_wise_active_employee_information);die; 
		$samity_list_string=$this->get_branch_field_officer_wise_samity_list_as_string($branch_id,$product_id,$from_date);
		//echo "<pre>";print_r($samity_list_string);die;
		$samity_list_array=$this->get_branch_field_officer_wise_samity_list_as_array($branch_id,$product_id,$from_date);
		//echo "<pre>";print_r($samity_list_array);die;*/
		
		$branch_field_officer_report_data=array(); 

		if(!empty($samity_list_string)){
			$branch_field_officer_wise_member_no=$this->get_branch_field_officer_wise_member_no($samity_list_string,$branch_id,$product_id,$from_date);
			//echo "<pre>";print_r($branch_field_officer_wise_member_no);die;
			$branch_field_officer_wise_members_savings=$this->get_branch_field_officer_wise_members_savings($samity_list_string,$branch_id,$product_id,$from_date);
			//echo "<pre>";print_r($branch_field_officer_wise_members_savings);die;
			$branch_field_officer_wise_loan_information=$this->get_branch_field_officer_wise_loan_information($samity_list_string,$branch_id,$product_id,$from_date);
			//echo "<pre>";print_r($branch_field_officer_wise_loan_information);die;
			$branch_field_officer_wise_fully_paid_loan_information=$this->get_branch_field_officer_wise_fully_paid_loan_information($samity_list_string,$branch_id,$product_id,$from_date);
			//echo "<pre>";print_r($branch_field_officer_wise_fully_paid_loan_information);die;
			$branch_field_officer_wise_loan_transaction_information=$this->get_branch_field_officer_wise_loan_transaction_information($samity_list_string,$branch_id,$product_id,$from_date);	
			//echo "<pre>";print_r($branch_field_officer_wise_loan_transaction_information);die;
			$branch_field_officer_wise_expired_loan_information=$this->get_branch_field_officer_wise_exp_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id);
			//echo "<pre>";print_r($branch_field_officer_wise_expired_loan_information);die;
			$branch_field_officer_wise_loan_schedule_information=$this->get_branch_field_officer_wise_loan_schedule_info($samity_list_array,$from_date,$branch_id,$product_id);
			//echo "<pre>";print_r($branch_field_officer_wise_loan_schedule_information);die;
			
			if(!empty($to_date)){
				$branch_field_officer_wise_admission_members_no=$this->get_branch_field_officer_wise_admission_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date);
				$branch_field_officer_wise_closing_members_no=$this->get_branch_field_officer_wise_closing_member_no($samity_list,$branch_id,$product_id,$from_date,$to_date);
			}
			
			$i=0;
			//print_r($branch_field_officer_wise_active_employee_information);
			foreach($branch_field_officer_wise_active_employee_information as $row)
			{			
				//print('<br>');print_r($row);
				
				if($i==0)
				{
					//print_r($row);die;
					//$previous_employee_id=$row->employee_id;
					$previous_employee_id=$row->samity_id;
					//print_r($previous_employee_id);die;
					$branch_field_officer_report_data[$row->samity_id]['employee_id']=$row->employee_id;
					$branch_field_officer_report_data[$row->samity_id]['employee_name']=$row->employee_name;
					$branch_field_officer_report_data[$row->samity_id]['employee_code']=$row->employee_code;
					
					$branch_field_officer_report_data[$row->samity_id]['samity_id']=$row->samity_id;
					$branch_field_officer_report_data[$row->samity_id]['samity_name']=$row->samity_name;
					$branch_field_officer_report_data[$row->samity_id]['samity_code']=$row->samity_code;
					
					$branch_field_officer_report_data[$row->samity_id]['admission_member_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['closing_member_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['member_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['savings']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['current_borrower']=0;
					$branch_field_officer_report_data[$row->samity_id]['current_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['transaction_amount']=0; //Regular recoverable amount
					$branch_field_officer_report_data[$row->samity_id]['overdue']=0; 
					$branch_field_officer_report_data[$row->samity_id]['outstanding']=0;						
					$branch_field_officer_report_data[$row->samity_id]['overdue_transaction_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['advance']=0;//advance recoverable amount
					$branch_field_officer_report_data[$row->samity_id]['recovery_total']=0;
					$branch_field_officer_report_data[$row->samity_id]['due']=0;//due recoverable amount
					$branch_field_officer_report_data[$row->samity_id]['new_due']=0;
					$branch_field_officer_report_data[$row->samity_id]['total_overdue']=0;
					$branch_field_officer_report_data[$row->samity_id]['total_outstanding']=0;
					$branch_field_officer_report_data[$row->samity_id]['payable_amount']=0;
					
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_member_no)) { 
						$branch_field_officer_report_data[$row->samity_id]['member_no']=$branch_field_officer_wise_member_no[$row->samity_id]['member_no'];
					}					
					if(isset($branch_field_officer_wise_admission_members_no)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_admission_members_no)) { 
							$branch_field_officer_report_data[$row->samity_id]['admission_member_no']=$branch_field_officer_wise_admission_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_field_officer_wise_closing_members_no)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_closing_members_no)) { 
							$branch_field_officer_report_data[$row->samity_id]['closing_member_no']=$branch_field_officer_wise_closing_members_no[$row->samity_id]['member_no'];
						}
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_members_savings)) { 
						$branch_field_officer_report_data[$row->samity_id]['savings']=$branch_field_officer_wise_members_savings[$row->samity_id]['savings'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']=$branch_field_officer_wise_loan_information[$row->samity_id]['cum_disbursement_no'];
						$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']=$branch_field_officer_wise_loan_information[$row->samity_id]['cum_loan_amount'];
						$branch_field_officer_report_data[$row->samity_id]['payable_amount']=$branch_field_officer_wise_loan_information[$row->samity_id]['cum_payable_amount'];
					}					
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_transaction_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['transaction_amount']=$branch_field_officer_wise_loan_transaction_information[$row->samity_id]['transaction_amount'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_fully_paid_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']=$branch_field_officer_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_disbursement_no'];
						$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']=$branch_field_officer_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_amount'];	
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_expired_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['no_cumilative_expaired_borrower'];
						$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['cumilative_expaired_borrower_amount'];	
						$branch_field_officer_report_data[$row->samity_id]['overdue_transaction_amount']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['exp_loan_transaction_amount'];
						$branch_field_officer_report_data[$row->samity_id]['overdue']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['overdue'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_schedule_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']=$branch_field_officer_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount'];
						if($branch_field_officer_report_data[$row->samity_id]['transaction_amount']>$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']){
							$branch_field_officer_report_data[$row->samity_id]['advance']=$branch_field_officer_report_data[$row->samity_id]['transaction_amount']-$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount'];
						}
						$branch_field_officer_report_data[$row->samity_id]['due']=$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount'];
						$branch_field_officer_report_data[$row->samity_id]['outstanding']=$branch_field_officer_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount'];
					}
					
					$branch_field_officer_report_data[$row->samity_id]['current_borrower']=$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']-$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']-$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower'];
					$branch_field_officer_report_data[$row->samity_id]['current_loan_amount']=$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']-$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']-$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount'];			
					$branch_field_officer_report_data[$row->samity_id]['recovery_total']=$branch_field_officer_report_data[$row->samity_id]['transaction_amount']+$branch_field_officer_report_data[$row->samity_id]['overdue']+$branch_field_officer_report_data[$row->samity_id]['advance'];			
					$branch_field_officer_report_data[$row->samity_id]['new_due']=$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount'];
					$branch_field_officer_report_data[$row->samity_id]['total_overdue']=$branch_field_officer_report_data[$row->samity_id]['due']+$branch_field_officer_report_data[$row->samity_id]['overdue'];
					$branch_field_officer_report_data[$row->samity_id]['total_outstanding']=$branch_field_officer_report_data[$row->samity_id]['outstanding']+$branch_field_officer_report_data[$row->samity_id]['payable_amount']-$branch_field_officer_report_data[$row->samity_id]['recovery_total'];
					//print($i.'----Mitu----');print('<br>');echo "<pre>";print_r($branch_field_officer_report_data);
				}		
				if($i!=0 && $previous_employee_id==$row->employee_id)
				{
					$branch_field_officer_report_data[$row->samity_id]['samity_id']=$row->samity_id;
					$branch_field_officer_report_data[$row->samity_id]['samity_name']=$row->samity_name;
					$branch_field_officer_report_data[$row->samity_id]['samity_code']=$row->samity_code;
					
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_member_no)) { 
						$branch_field_officer_report_data[$row->samity_id]['member_no']=$branch_field_officer_report_data[$row->samity_id]['member_no']+$branch_field_officer_wise_member_no[$row->samity_id]['member_no'];
					}
					if(isset($branch_field_officer_wise_admission_members_no)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_admission_members_no)) { 
							$branch_field_officer_report_data[$row->samity_id]['admission_member_no']=$branch_field_officer_report_data[$row->samity_id]['admission_member_no']+$branch_field_officer_wise_admission_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_field_officer_wise_closing_members_no)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_closing_members_no)) { 
							$branch_field_officer_report_data[$row->samity_id]['closing_member_no']=$branch_field_officer_report_data[$row->samity_id]['closing_member_no']+$branch_field_officer_wise_closing_members_no[$row->samity_id]['member_no'];
						}
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_members_savings)) { 
						$branch_field_officer_report_data[$row->samity_id]['savings']=$branch_field_officer_report_data[$row->samity_id]['savings']+$branch_field_officer_wise_members_savings[$row->samity_id]['savings'];
					}
					if(isset($branch_field_officer_wise_loan_information)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_information)) { 
							$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']=$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']+$branch_field_officer_wise_loan_information[$row->samity_id]['cum_disbursement_no'];
							$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']=$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']+$branch_field_officer_wise_loan_information[$row->samity_id]['cum_loan_amount'];
							$branch_field_officer_report_data[$row->samity_id]['payable_amount']=$branch_field_officer_report_data[$row->samity_id]['payable_amount']+$branch_field_officer_wise_loan_information[$row->samity_id]['cum_payable_amount'];
						}
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_transaction_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['transaction_amount']=$branch_field_officer_report_data[$row->samity_id]['transaction_amount']+$branch_field_officer_wise_loan_transaction_information[$row->samity_id]['transaction_amount'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_expired_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower']=$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower']+$branch_field_officer_wise_expired_loan_information[$row->samity_id]['no_cumilative_expaired_borrower'];
						$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount']=$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount']+$branch_field_officer_wise_expired_loan_information[$row->samity_id]['cumilative_expaired_borrower_amount'];	
						$branch_field_officer_report_data[$row->samity_id]['overdue_transaction_amount']=$branch_field_officer_report_data[$row->samity_id]['overdue_transaction_amount']+$branch_field_officer_wise_expired_loan_information[$row->samity_id]['exp_loan_transaction_amount'];
						$branch_field_officer_report_data[$row->samity_id]['overdue']=$branch_field_officer_report_data[$row->samity_id]['overdue']+$branch_field_officer_report_data[$row->samity_id]['overdue'];
					}		
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_fully_paid_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']=$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']+$branch_field_officer_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_disbursement_no'];
						$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']=$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']+$branch_field_officer_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_amount'];
					}			
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_schedule_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']+=$branch_field_officer_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount'];
						if($branch_field_officer_report_data[$row->samity_id]['transaction_amount']>$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']){
							$branch_field_officer_report_data[$row->samity_id]['advance']=$branch_field_officer_report_data[$row->samity_id]['advance']+($branch_field_officer_report_data[$row->samity_id]['transaction_amount']-$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']);
						}
						$branch_field_officer_report_data[$row->samity_id]['due']=$branch_field_officer_report_data[$row->samity_id]['due']+($branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount']);
						$branch_field_officer_report_data[$row->samity_id]['outstanding']=$branch_field_officer_report_data[$row->samity_id]['outstanding']+($branch_field_officer_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount']);
					}
					//print_r($row->samity_id);die;
					$branch_field_officer_report_data[$row->samity_id]['current_borrower']=$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']-$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']-$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower'];
					$branch_field_officer_report_data[$row->samity_id]['current_loan_amount']=$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']-$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']-$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount'];
					$branch_field_officer_report_data[$row->samity_id]['recovery_total']=$branch_field_officer_report_data[$row->samity_id]['recovery_total']+($branch_field_officer_report_data[$row->samity_id]['transaction_amount']+$branch_field_officer_report_data[$row->samity_id]['overdue']+$branch_field_officer_report_data[$row->samity_id]['advance']);			
					$branch_field_officer_report_data[$row->samity_id]['new_due']=$branch_field_officer_report_data[$row->samity_id]['new_due']+($branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount']);
					$branch_field_officer_report_data[$row->samity_id]['total_overdue']=$branch_field_officer_report_data[$row->samity_id]['total_overdue']+$branch_field_officer_report_data[$row->samity_id]['due']+$branch_field_officer_report_data[$row->samity_id]['overdue'];
					$branch_field_officer_report_data[$row->samity_id]['total_outstanding']=$branch_field_officer_report_data[$row->samity_id]['total_outstanding']+($branch_field_officer_report_data[$row->samity_id]['outstanding']+$branch_field_officer_report_data[$row->samity_id]['payable_amount']-$branch_field_officer_report_data[$row->samity_id]['recovery_total']);
					//print($i.'---Nitu-----');print('<br>');echo "<pre>";print_r($branch_field_officer_report_data);die;
				}	
				elseif($i!=0 && $previous_employee_id!=$row->samity_id)
				{
					//print_r($row);die;
					$previous_employee_id=$row->samity_id;
					$branch_field_officer_report_data[$row->samity_id]['employee_id']=$row->employee_id;
					$branch_field_officer_report_data[$row->samity_id]['employee_name']=$row->employee_name;
					$branch_field_officer_report_data[$row->samity_id]['employee_code']=$row->employee_code;

					$branch_field_officer_report_data[$row->samity_id]['samity_id']=$row->samity_id;
					$branch_field_officer_report_data[$row->samity_id]['samity_name']=$row->samity_name;
					$branch_field_officer_report_data[$row->samity_id]['samity_code']=$row->samity_code;

					$branch_field_officer_report_data[$row->samity_id]['member_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['admission_member_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['closing_member_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['savings']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower']=0;
					$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['current_borrower']=0;
					$branch_field_officer_report_data[$row->samity_id]['current_loan_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['transaction_amount']=0; //Regular recoverable amount
					$branch_field_officer_report_data[$row->samity_id]['overdue']=0; //overdue recoverable amount
					$branch_field_officer_report_data[$row->samity_id]['outstanding']=0;						
					$branch_field_officer_report_data[$row->samity_id]['overdue_transaction_amount']=0;
					$branch_field_officer_report_data[$row->samity_id]['advance']=0;//advance recoverable amount		
					$branch_field_officer_report_data[$row->samity_id]['recovery_total']=0;
					$branch_field_officer_report_data[$row->samity_id]['due']=0;//due recoverable amount
					$branch_field_officer_report_data[$row->samity_id]['new_due']=0;
					$branch_field_officer_report_data[$row->samity_id]['total_overdue']=0;
					$branch_field_officer_report_data[$row->samity_id]['total_outstanding']=0;
					$branch_field_officer_report_data[$row->samity_id]['payable_amount']=0;
					
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_member_no)) { 
						$branch_field_officer_report_data[$row->samity_id]['member_no']=$branch_field_officer_wise_member_no[$row->samity_id]['member_no'];
					}
					if(isset($branch_field_officer_wise_admission_members_no)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_admission_members_no)) { 
							$branch_field_officer_report_data[$row->samity_id]['admission_member_no']=$branch_field_officer_wise_admission_members_no[$row->samity_id]['member_no'];
						}
					}
					if(isset($branch_field_officer_wise_closing_members_no)){
						if (array_key_exists($row->samity_id,$branch_field_officer_wise_closing_members_no)) { 
							$branch_field_officer_report_data[$row->samity_id]['closing_member_no']=$branch_field_officer_wise_closing_members_no[$row->samity_id]['member_no'];
						}
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_members_savings)) { 
						$branch_field_officer_report_data[$row->samity_id]['savings']=$branch_field_officer_wise_members_savings[$row->samity_id]['savings'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']=$branch_field_officer_wise_loan_information[$row->samity_id]['cum_disbursement_no'];
						$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']=$branch_field_officer_wise_loan_information[$row->samity_id]['cum_loan_amount'];
						$branch_field_officer_report_data[$row->samity_id]['payable_amount']=$branch_field_officer_wise_loan_information[$row->samity_id]['cum_payable_amount'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_transaction_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['transaction_amount']=$branch_field_officer_wise_loan_transaction_information[$row->samity_id]['transaction_amount'];
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_expired_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['no_cumilative_expaired_borrower'];
						$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['cumilative_expaired_borrower_amount'];	
						$branch_field_officer_report_data[$row->samity_id]['overdue_transaction_amount']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['exp_loan_transaction_amount'];
						$branch_field_officer_report_data[$row->samity_id]['overdue']=$branch_field_officer_wise_expired_loan_information[$row->samity_id]['overdue'];
					}			
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_fully_paid_loan_information)) { 
						$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']=$branch_field_officer_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_disbursement_no'];
						$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']=$branch_field_officer_wise_fully_paid_loan_information[$row->samity_id]['cum_fully_paid_loan_amount'];	
					}
					if (array_key_exists($row->samity_id,$branch_field_officer_wise_loan_schedule_information)) { 	
						$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']=$branch_field_officer_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount'];
						if($branch_field_officer_report_data[$row->samity_id]['transaction_amount']>$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']){
							$branch_field_officer_report_data[$row->samity_id]['advance']=$branch_field_officer_report_data[$row->samity_id]['transaction_amount']-$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount'];
						}
						$branch_field_officer_report_data[$row->samity_id]['due']=$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount'];
						$branch_field_officer_report_data[$row->samity_id]['outstanding']=$branch_field_officer_wise_loan_schedule_information[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount'];
					}
					
					$branch_field_officer_report_data[$row->samity_id]['current_borrower']=$branch_field_officer_report_data[$row->samity_id]['cum_disbursement_no']-$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_disbursement_no']-$branch_field_officer_report_data[$row->samity_id]['cum_exp_borrower'];
					$branch_field_officer_report_data[$row->samity_id]['current_loan_amount']=$branch_field_officer_report_data[$row->samity_id]['cum_loan_amount']-$branch_field_officer_report_data[$row->samity_id]['cum_fully_paid_loan_amount']-$branch_field_officer_report_data[$row->samity_id]['cum_exp_loan_amount'];					
					$branch_field_officer_report_data[$row->samity_id]['recovery_total']=$branch_field_officer_report_data[$row->samity_id]['transaction_amount']+$branch_field_officer_report_data[$row->samity_id]['overdue']+$branch_field_officer_report_data[$row->samity_id]['advance'];			
					$branch_field_officer_report_data[$row->samity_id]['new_due']=$branch_field_officer_report_data[$row->samity_id]['loan_recoverable_amount']-$branch_field_officer_report_data[$row->samity_id]['transaction_amount'];
					$branch_field_officer_report_data[$row->samity_id]['total_overdue']=$branch_field_officer_report_data[$row->samity_id]['due']+$branch_field_officer_report_data[$row->samity_id]['overdue'];
					$branch_field_officer_report_data[$row->samity_id]['total_outstanding']=$branch_field_officer_report_data[$row->samity_id]['outstanding']+$branch_field_officer_report_data[$row->samity_id]['payable_amount']-$branch_field_officer_report_data[$row->samity_id]['recovery_total'];
					//print('<br>');echo "<pre>";print_r($branch_field_officer_report_data);
				}
				$i++;	
			}
		}		
		//print_r('hello');die;
		//echo "<pre>";print_r($branch_field_officer_report_data);die;
		return $branch_field_officer_report_data;
	}

//**************************************Loan field officer*********************************************************
	function get_loan_field_officer_wise_information($branch_id,$date_from,$date_to,$product_id){
		//echo '<pre>';
		// Filed officers
		$field_officers = $this->loan_base_class->get_branch_wise_field_officer_list($branch_id,$date_to);
		$field_officer_id_string = join(',',array_keys($field_officers));
		//print_r($field_officers);
		
		//Samities
		$samities = $this->loan_base_class->get_field_officer_wise_samity_list($field_officer_id_string,$branch_id,$date_from);
		if(is_array($samities)) {
			$samity_id_list = array_keys($samities);
			$samity_id_string = join(',',$samity_id_list);
			//print_r($samities);
			
			// Schedule 
			$pre_loan_schedules = $this->loan_base_class->get_loan_schedule_info($samity_id_list,$branch_id,$date_from);
			$current_loan_schedules = $this->loan_base_class->get_loan_schedule_info($samity_id_list,$branch_id,$date_to);
			//print_r($pre_loan_schedules);
		}
		// Loans
		if(isset($samity_id_string)) {
			$pre_loans = $this->loan_base_class->get_loan_information($samity_id_string,$branch_id,$date_from,null,$product_id);
			if(is_array($pre_loans)) {
				$pre_loan_id_list = array_keys($pre_loans);		
				$pre_loan_id_string = join(',',$pre_loan_id_list);
				//$loans_info = array();
				foreach($pre_loans as $loan){
					$pre_loans[$loan['loan_id']]['field_officer_id'] = $samities[$loan['samity_id']]['field_officer_id'];
					$pre_loans[$loan['loan_id']]['gender'] = $samities[$loan['samity_id']]['samity_type'];
					$pre_installment_no = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['installment_no'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['installment_no']:"";
					$pre_principle_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['principle_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['principle_installment_amount']:"";
					$pre_interrest_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['interrest_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['interrest_installment_amount']:"";
					$pre_repayment_date = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['repayment_date'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['repayment_date']:"";
					$total_installment_no = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['total_installment_no'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['total_installment_no']:"";
					$last_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_installment_amount']:"";
					$last_principle_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_principle_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_principle_installment_amount']:"";
					$last_interrest_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_interrest_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_interrest_installment_amount']:"";
					$last_repayment_date = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_repayment_date'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_repayment_date']:"";
					//
					$pre_loans[$loan['loan_id']]['pre_installment_no'] = $pre_installment_no ;
					$pre_loans[$loan['loan_id']]['pre_principle_installment_amount'] = $pre_principle_installment_amount ;
					$pre_loans[$loan['loan_id']]['pre_interrest_installment_amount'] = $pre_interrest_installment_amount ;
					//
					/*
					if($total_installment_no == $pre_installment_no){
						$pre_loans[$loan['loan_id']]['pre_total_principle_recoverable'] = $pre_principle_installment_amount*($pre_installment_no - 1) + $last_installment_amount;
						$pre_loans[$loan['loan_id']]['pre_total_interrest_recoverable'] = $pre_interrest_installment_amount*($pre_installment_no - 1) + $last_installment_amount;
					} else {
						$pre_loans[$loan['loan_id']]['pre_total_principle_recoverable'] = $pre_principle_installment_amount*$pre_installment_no;
						$pre_loans[$loan['loan_id']]['pre_total_interrest_recoverable'] = $pre_interrest_installment_amount*$pre_installment_no;
					}
					* */
					$pre_loans[$loan['loan_id']]['pre_total_principle_recoverable'] = $pre_principle_installment_amount*($total_installment_no - 1) + $last_principle_installment_amount;
					$pre_loans[$loan['loan_id']]['pre_total_interrest_recoverable'] = $pre_interrest_installment_amount*($total_installment_no - 1) + $last_interrest_installment_amount;
					$pre_loans[$loan['loan_id']]['total_installment_no'] = $total_installment_no ;
					$pre_loans[$loan['loan_id']]['last_installment_amount'] = $last_installment_amount ;
					$pre_loans[$loan['loan_id']]['last_repayment_date'] = $last_repayment_date ;
					
					//echo " $pre_installment_no";
					//$pre_loans[$loan['loan_id']]['recovable_amount'] = $pre_loan_schedules
					
				}
				//print_r($pre_loans);
				foreach($pre_loans as $loan){
					if($loan['gender'] == 'M'){
						$field_officers[$loan['field_officer_id']]['m_current_loan'] += $loan['disbures_amount'];
						$field_officers[$loan['field_officer_id']]['m_pre_total_principle_recoverable'] += $loan['pre_total_principle_recoverable'] ;
						$field_officers[$loan['field_officer_id']]['m_pre_total_interrest_recoverable'] += $loan['pre_total_interrest_recoverable'];
					}elseif($loan['gender'] == 'F'){
						$field_officers[$loan['field_officer_id']]['f_current_loan'] += $loan['disbures_amount'];
						$field_officers[$loan['field_officer_id']]['f_pre_total_principle_recoverable'] += $loan['pre_total_principle_recoverable'] ;
						$field_officers[$loan['field_officer_id']]['f_pre_total_interrest_recoverable'] += $loan['pre_total_interrest_recoverable'];
					}
				}
				//print_r($field_officers);
			}
			$current_loans = $this->loan_base_class->get_loan_information($samity_id_string,$branch_id,$date_from,$date_to,$product_id);
			if(is_array($current_loans)) {
				$current_loan_id_list = array_keys($current_loans);		
				$current_loan_id_string = join(',',$current_loan_id_list);
				foreach($current_loans as $loan){
					$current_loans[$loan['loan_id']]['field_officer_id'] = $samities[$loan['samity_id']]['field_officer_id'];
					$current_loans[$loan['loan_id']]['gender'] = $samities[$loan['samity_id']]['samity_type'];
					//
					$current_installment_no = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['installment_no'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['installment_no']:"";
					$current_principle_installment_amount = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['principle_installment_amount'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['principle_installment_amount']:"";
					$current_interrest_installment_amount = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['interrest_installment_amount'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['interrest_installment_amount']:"";
					$current_repayment_date = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['repayment_date'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['repayment_date']:"";
					$total_installment_no = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['total_installment_no'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['total_installment_no']:"";
					$last_installment_amount = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_installment_amount'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_installment_amount']:"";
					$last_principle_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_principle_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_principle_installment_amount']:"";
					$last_interrest_installment_amount = isset($pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_interrest_installment_amount'])?$pre_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_interrest_installment_amount']:"";
					$last_repayment_date = isset($current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_repayment_date'])?$current_loan_schedules[$loan['samity_id']][$loan['loan_id']]['last_repayment_date']:"";
					//
					$current_loans[$loan['loan_id']]['current_installment_no'] = $current_installment_no ;
					$current_loans[$loan['loan_id']]['current_principle_installment_amount'] = $current_principle_installment_amount ;
					$current_loans[$loan['loan_id']]['current_interrest_installment_amount'] = $current_interrest_installment_amount ;
					//
					/*
					if($total_installment_no == $current_installment_no){
						$current_loans[$loan['loan_id']]['current_total_principle_recoverable'] = $current_principle_installment_amount*($current_installment_no - 1) + $last_installment_amount;
						$current_loans[$loan['loan_id']]['current_total_interrest_recoverable'] = $current_interrest_installment_amount*($current_installment_no - 1) + $last_installment_amount;
					} else {
						$current_loans[$loan['loan_id']]['current_total_principle_recoverable'] = $current_principle_installment_amount*$current_installment_no;
						$current_loans[$loan['loan_id']]['current_total_interrest_recoverable'] = $current_interrest_installment_amount*$current_installment_no;
					}
					* */
					//if((strtotime($date_from) - strtotime($current_repayment_date) > ))
					$disburse_date = $current_loans[$loan['loan_id']]['disburse_date'];
					if((strtotime($date_from) - strtotime($disburse_date) < 0)) {
						$current_loans[$loan['loan_id']]['current_total_principle_recoverable'] = $current_principle_installment_amount*($total_installment_no - 1) + $last_principle_installment_amount;
						$current_loans[$loan['loan_id']]['current_total_interrest_recoverable'] = $current_interrest_installment_amount*($total_installment_no - 1) + $last_interrest_installment_amount;
					}
					//print_r();
				}
				//print_r($current_loans);
				foreach($current_loans as $loan){
					if($loan['gender'] == 'M'){
						$field_officers[$loan['field_officer_id']]['m_current_disburse_principle'] += $loan['disbures_amount'];
						$field_officers[$loan['field_officer_id']]['m_current_disburse_services_charge'] += isset($loan['current_total_interrest_recoverable'])?$loan['current_total_interrest_recoverable']:0.00;
						$field_officers[$loan['field_officer_id']]['m_current_total_principle_recoverable'] += isset($loan['current_total_principle_recoverable'] )?$loan['current_total_principle_recoverable'] :0.00;
					
					}elseif($loan['gender'] == 'F'){
						$field_officers[$loan['field_officer_id']]['f_current_disburse_principle'] += $loan['disbures_amount'];
						$field_officers[$loan['field_officer_id']]['f_current_disburse_services_charge'] += isset($loan['current_total_interrest_recoverable'])?$loan['current_total_interrest_recoverable']:"0.00";
						$field_officers[$loan['field_officer_id']]['f_current_total_principle_recoverable'] += isset($loan['current_total_principle_recoverable'])?$loan['current_total_principle_recoverable']:"0.00" ;
					}
				}
			}
		
			// Loan Transactions
			if(isset($pre_loan_id_string)){
				$pre_loan_transactions = $this->loan_base_class->get_loan_transaction_information($pre_loan_id_string,$branch_id,$date_from,null,$product_id);
				foreach($pre_loan_transactions as $loan_trans){
					$pre_loan_transactions[$loan_trans['loan_id']]['field_officer_id'] = $samities[$loan_trans['samity_id']]['field_officer_id'];
					$pre_loan_transactions[$loan_trans['loan_id']]['gender'] = $samities[$loan_trans['samity_id']]['samity_type'];
					
				}
				
				foreach($pre_loan_transactions as $loan_trans){
					if($loan_trans['gender'] == 'M'){
						//$field_officers[$loan_trans['field_officer_id']]['m_recovery_principle'] += $loan_trans['transaction_principal_amount'];
						//$field_officers[$loan_trans['field_officer_id']]['m_recovery_services_charge'] += $loan_trans['transaction_interest_amount'];
						$field_officers[$loan_trans['field_officer_id']]['m_outstanding_opening_balance_principle'] += $field_officers[$loan_trans['field_officer_id']]['m_pre_total_principle_recoverable'] - $loan_trans['transaction_principal_amount'] ;
						$field_officers[$loan_trans['field_officer_id']]['m_outstanding_opening_balance_service_charge'] += $field_officers[$loan_trans['field_officer_id']]['m_pre_total_interrest_recoverable'] - $loan_trans['transaction_interest_amount'] ;
					}elseif($loan['gender'] == 'F'){
						//$field_officers[$loan_trans['field_officer_id']]['f_recovery_principle'] += $loan_trans['transaction_principal_amount'];
						//$field_officers[$loan_trans['field_officer_id']]['f_recovery_services_charge'] += $loan_trans['transaction_interest_amount'];
						$field_officers[$loan_trans['field_officer_id']]['f_outstanding_opening_balance_principle'] += $field_officers[$loan_trans['field_officer_id']]['f_pre_total_principle_recoverable'] - $loan_trans['transaction_principal_amount'] ;
						$field_officers[$loan_trans['field_officer_id']]['f_outstanding_opening_balance_service_charge'] += $field_officers[$loan_trans['field_officer_id']]['f_pre_total_interrest_recoverable'] - $loan_trans['transaction_interest_amount'] ;
					}
				}
			}
			if(isset($current_loan_id_string)){
				$current_loan_transactions = $this->loan_base_class->get_loan_transaction_information($current_loan_id_string,$branch_id,$date_from,$date_to,$product_id);
				if(!empty($current_loan_transactions)) {
					foreach($current_loan_transactions as $loan_trans){
						$current_loan_transactions[$loan_trans['loan_id']]['field_officer_id'] = $samities[$loan_trans['samity_id']]['field_officer_id'];
						$current_loan_transactions[$loan_trans['loan_id']]['gender'] = $samities[$loan_trans['samity_id']]['samity_type'];
						
					}
					foreach($current_loan_transactions as $loan_trans){
						if($loan_trans['gender'] == 'M'){
							$field_officers[$loan_trans['field_officer_id']]['m_recovery_principle'] += $loan_trans['transaction_principal_amount'];
							$field_officers[$loan_trans['field_officer_id']]['m_recovery_services_charge'] += $loan_trans['transaction_interest_amount'];
						}elseif($loan['gender'] == 'F'){
							$field_officers[$loan_trans['field_officer_id']]['f_recovery_principle'] += $loan_trans['transaction_principal_amount'];
							$field_officers[$loan_trans['field_officer_id']]['f_recovery_services_charge'] += $loan_trans['transaction_interest_amount'];
		
						}
					}
				}
			}
			// Loan Schedule
			//print_r($samity_id_list);
			//echo "<br> $branch_id,$date_from <br>";
			
		}
		//$samity_id_list = array_keys($samities);
		//$samity_id_string = join(',',array_keys($samity_id_list));
		//echo $pre_loan_id_string;
		//print_r($pre_loans);
		//print_r($field_officers);
		return $field_officers;
	}
	
	//**************************Loan Classification & DMR Report**************************************************
	function get_loan_classification_and_dmr($branch_id,$year,$month,$pre_year,$pre_month){
		//echo "<pre>,$pre_year,$pre_month";
		$branch_condition = "";
		if($branch_id != -1) {
			$branch_condition = " AND m.branch_id = $branch_id";
		}
		
		/*$q = "SELECT m.product_id
FROM month_end_process_loans AS m
 WHERE (MONTH(m.date) = $pre_month OR MONTH(m.date) = $month) AND (YEAR(m.date) = $pre_year OR YEAR(m.date) = $year) $branch_condition 
GROUP BY m.product_id;";*/
/*
$q = "SELECT id as product_id,short_name as product_name
FROM loan_products AS m
 WHERE start_date < '$year-$month-01' ORDER BY code";
 */
 $q = "SELECT id as product_id,short_name as product_name
FROM loan_products AS m
 WHERE 1=1 ORDER BY code";

	$query=$this->db->query($q); 
	$loan_classifications=$query->result_array();
	
	$loan_classification_drm_info = array();
	
	foreach($loan_classifications as $loan_classification){
		$loan_classification_drm_info[$loan_classification['product_id']]['product_name'] = $loan_classification['product_name'];
		$loan_classification_drm_info[$loan_classification['product_id']]['total_outstanding'] = 0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['total_overdue'] =0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['current_overdue'] = 0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['good_loan_outstanding'] = 0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['doubtful_loan_outstanding'] = 0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['bad_loan_outstanding'] = 0.00;
	}
	//print_r($loan_classifications);	
	//	die;
		$pre_q = "SELECT lp.short_name AS product_name,m.product_id,SUM(m.closing_outstanding_amount) AS outstanding_amount,
SUM(m.substandard_outstanding) AS substandard_outstanding,SUM(m.substandard_overdue) AS substandard_overdue,
SUM(m.doubtfull_outstanding) AS doubtfull_outstanding,SUM(m.doubtfull_overdue) AS doubtfull_overdue
,SUM(m.bad_outstanding) AS bad_outstanding , SUM(m.bad_overdue) AS bad_overdue
FROM month_end_process_loans AS m
INNER JOIN loan_products AS lp ON (lp.id = m.product_id)

 WHERE MONTH(m.date) = $pre_month $branch_condition AND YEAR(m.date) = $pre_year
GROUP BY m.product_id,lp.short_name,m.product_id  ORDER BY lp.code;";
	//echo $pre_q;
	$pre_query=$this->db->query($pre_q); 
	$pre_loan_classifications=$pre_query->result_array();
	
	
	foreach($pre_loan_classifications as $loan_classification){
		$loan_classification_drm_info[$loan_classification['product_id']]['product_name'] = $loan_classification['product_name'];
		$loan_classification_drm_info[$loan_classification['product_id']]['total_outstanding'] = $loan_classification['outstanding_amount'];
		$loan_classification_drm_info[$loan_classification['product_id']]['total_overdue'] = $loan_classification['substandard_overdue']+$loan_classification['doubtfull_overdue']+$loan_classification['bad_overdue'];
		$loan_classification_drm_info[$loan_classification['product_id']]['current_overdue'] = 0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['good_loan_outstanding'] = $loan_classification['substandard_outstanding']*1/100;
		$loan_classification_drm_info[$loan_classification['product_id']]['doubtful_loan_outstanding'] = $loan_classification['doubtfull_outstanding']*75/100;
		$loan_classification_drm_info[$loan_classification['product_id']]['bad_loan_outstanding'] = $loan_classification['bad_outstanding'];
	}
	//print_r($loan_classification_drm_info);
	$current_q = "SELECT lp.short_name AS product_name,m.product_id,SUM(m.closing_outstanding_amount) AS outstanding_amount,
SUM(m.substandard_outstanding) AS substandard_outstanding,SUM(m.substandard_overdue) AS substandard_overdue,
SUM(m.doubtfull_outstanding) AS doubtfull_outstanding,SUM(m.doubtfull_overdue) AS doubtfull_overdue
,SUM(m.bad_outstanding) AS bad_outstanding , SUM(m.bad_overdue) AS bad_overdue
FROM month_end_process_loans AS m
INNER JOIN loan_products AS lp ON (lp.id = m.product_id)

 WHERE MONTH(m.date) = $month $branch_condition AND YEAR(m.date) = $year
GROUP BY m.product_id,lp.short_name,m.product_id ORDER BY lp.code;";

	$current_query=$this->db->query($current_q); 
	$current_loan_classifications=$current_query->result_array();
	$current_loan_month_overdue  = array();
	foreach($current_loan_classifications as $loan_classification){
		$current_total_overdue = $loan_classification['substandard_overdue']+$loan_classification['doubtfull_overdue']+$loan_classification['bad_overdue'];
		$pre_total_overdue = isset($loan_classification_drm_info[$loan_classification['product_id']]['total_overdue'])?$loan_classification_drm_info[$loan_classification['product_id']]['total_overdue']:0.00;
		$loan_classification_drm_info[$loan_classification['product_id']]['current_overdue'] = $current_total_overdue -  $pre_total_overdue;	
	}
		
		
		
		//print_r($loan_classification_drm_info);

		//echo "</pre>";
		return $loan_classification_drm_info;
	}

}
