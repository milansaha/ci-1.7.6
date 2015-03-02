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
class Report_savings_data extends Model {

    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->model(array('Saving_product'));  
	}
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_saving_deposit_amount($branch_id=null,$product_id=null,$date=null)
	{		
		$query=$this->db->query("SELECT saving_products.id,samity_id,SUM(amount)AS deposit_amount
							FROM saving_products
							LEFT JOIN saving_deposits ON saving_products.id=saving_deposits.saving_products_id 
							AND branch_id=$branch_id AND member_primary_product_id=$product_id AND transaction_date='$date' AND transaction_type='DEP' 
							GROUP BY saving_products.id,samity_id
							Order by saving_products.id"); 
		$query=$query->result();		
		$data=array();
		$i=0;
		foreach($query as $query)
		{
			$data[$query->samity_id][$query->id]=$query->deposit_amount;
		}
		//echo "<pre>";print_r($data);die;
		return $data;
	}
	/**
	 * component_wise_daily_collection_report
	 * @Auth: Taposhi Rabeya
	 * @date: 20-Mar-2011   
	*/
	//component_wise_daily_collection_report
	function get_saving_withdraw_amount($branch_id=null,$product_id=null,$date=null)
	{
		$query=$this->db->query("SELECT samity_id,SUM(amount) as withdraw_amount
							FROM saving_withdraws 
							WHERE branch_id=$branch_id AND member_primary_product_id=$product_id AND transaction_date='$date' 
							AND transaction_type='WIT' AND is_authorized=1
							GROUP BY samity_id"); 
		$query=$query->result();		
		$data=array();
		foreach($query as $query)
		{
			$data[$query->samity_id]=$query->withdraw_amount;
		}		
		return $data;
	}
	/**
	 * samity_wise_monthly_savings_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_savings_collection_report_data
	function get_active_member_previous_savings_balance($member_list,$date,$branch_id,$samity_id,$primary_product_id)
	{
		$query=$this->db->query("SELECT saving_deposits.member_id,SUM(saving_deposits.amount) AS previous_savings_balance 							
							FROM saving_deposits JOIN savings ON savings.id=saving_deposits.savings_id
							WHERE saving_deposits.member_id IN ($member_list) AND saving_deposits.is_authorized=1
							AND savings.current_status = 1 AND savings.branch_id=$branch_id AND savings.samity_id = $samity_id
							AND saving_deposits.transaction_date < '$date' AND saving_deposits.member_primary_product_id=$primary_product_id
							GROUP BY saving_deposits.member_id "); 
		$query=$query->result();		
		//print_r($query);die;
		$data=array();
		foreach($query as $query)
		{
			$data[$query->member_id]=$query->previous_savings_balance;
		}		
		//print_r($data);die;
		return $data;
	}
	/**
	 * samity_wise_monthly_savings_collection_report_data
	 * @Auth: Taposhi Rabeya
	 * @date: 24-Mar-2011   
	*/
	//samity_wise_monthly_savings_collection_report_data
	function get_active_member_savings_auto($member_list,$date,$branch_id,$samity_id,$primary_product_id)
	{
		//print_r($primary_product_id);die;
		$query=$this->db->query("SELECT savings.member_id,sum(savings.weekly_savings) AS savings_auto						
							FROM saving_deposits JOIN savings ON savings.id=saving_deposits.savings_id
							WHERE saving_deposits.member_id IN ($member_list) AND saving_deposits.is_authorized=1
							AND savings.current_status = 1 AND savings.branch_id=$branch_id AND savings.samity_id = $samity_id
							AND saving_deposits.transaction_date < '$date' AND saving_deposits.member_primary_product_id=$primary_product_id
							GROUP BY savings.member_id "); 
		$query=$query->result();	
		$data=array();
		foreach($query as $query)
		{
			$data[$query->member_id]=$query->savings_auto;
		}		
		return $data;
	}	
}
