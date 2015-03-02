<?php
/** 
	*  Register_report Model Class.
	* @pupose		Register_report information
	*		
	* @filesource	./system/application/models/register_report.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.register_report
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-26 $	 
*/ 
class Pass_book_report extends MY_Model {
    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->library('Scheduler1');
		
	} 
	// To know memberwise product information
	function get_product_info($member_id=null)
	{
		$loan_product_info="SELECT loan_products.id,short_name FROM loan_products,loans WHERE loans.product_id= loan_products.id AND loans.member_id=?";
		$loan_product_info=$this->db->query($loan_product_info, array($member_id));
		$loan_product_info=$loan_product_info->result_array();
		return $loan_product_info;
		
	}
	// To know Brach Information and Samity Name and Code
	function get_branch_samity_information($samity_id=null)
	{
		$branch_and_samity_info_sql="SELECT po_branches.id as branch_id,po_branches.name AS branch_name,po_branches.code AS branch_code,samities.name AS samity_name,samities.code AS samity_code FROM po_branches,samities WHERE po_branches.id=samities.branch_id AND samities.id=?";
                $branch_and_samity_info_sql=$this->db->query($branch_and_samity_info_sql, array($samity_id)); 
		$branch_and_samity_info=$branch_and_samity_info_sql->result_array();
		return $branch_and_samity_info;
	
	}
	//To know Loan Number
	/*function get_loan_no($branch_id=null,$member_id=null,$samity_id=null,$product_id=null)
	{
		
		$member_and_loan_info_sql="SELECT id FROM loans WHERE branch_id=$branch_id and samity_id=$samity_id AND member_id=$member_id AND product_id=$product_id"; 
		 $member_and_loan_info_sql=$this->db->query($member_and_loan_info_sql);
		 $member_and_loan_info=$member_and_loan_info_sql->result_array();
		return $member_and_loan_info;	
	}*/
	
	//To know Loan information Member Wise
	 
	function get_member_loan_information($member_id=null,$product_id=null)
	{
		$member_and_loan_info_sql="SELECT loans.cycle as dafa_no,loans.disburse_date AS disburse_date,loans.loan_amount AS disbursement_amount,loans.installment_amount AS amount_of_installment,loans.number_of_installment AS number_of_installment,loans.interest_rate AS
                 rate_of_service_change,loan_purposes.name AS loan_purposes_name,loans.first_repayment_date AS 1st_installment_date FROM loans 
                 LEFT JOIN loan_purposes ON loans.purpose_id=loan_purposes.id 
                 WHERE loans.member_id=? AND loans.product_id=?";
		 $member_and_loan_info_sql=$this->db->query($member_and_loan_info_sql, array($member_id,$product_id));
		 $member_and_loan_info=$member_and_loan_info_sql->result_array();
		return $member_and_loan_info;	
	}
	//To Get saving withdraw information Member and Product Wise
        function get_saving_withdraw_information($member_id=null,$product_id=null)
	{
		$save_withdraw_info_sql="SELECT saving_withdraws.transaction_date AS withdraw_date,saving_withdraws.amount AS saving_refund
                FROM saving_withdraws
                where saving_withdraws.member_id=? and saving_withdraws.member_primary_product_id=?";
		 $save_withdraw_info_sql=$this->db->query($save_withdraw_info_sql, array($member_id,$product_id));
		return $save_withdraw_info_sql->result_array();	
	}
	// To get Deposit Information Member and product wise
	 function get_saving_deposit_information($member_id=null,$product_id=null)
	{
		$save_deposit_info_sql="SELECT saving_deposits.transaction_date AS saving_date,saving_deposits.amount AS weekly_deposit
                FROM saving_deposits where saving_deposits.member_id=? and saving_deposits.member_primary_product_id=?";
		 $save_deposit_info_sql=$this->db->query($save_deposit_info_sql, array($member_id,$product_id));
		return $save_deposit_info_sql->result_array();	
	}
	// To Get Loan info
	function get_loan_info($member_id=null,$product_id=null)
	{
                $loan_info_sql="SELECT loan_transactions.transaction_date,loan_transactions.transaction_amount as weekly_recovery,loan_transactions.installment_number AS current_repay_week_no,loan_transactions.current_outstanding_amount FROM loan_transactions,
		loans where loan_transactions.loan_id=loans.id
                and loans.member_id=? and loan_transactions.product_id=?";
                $loan_info_sql=$this->db->query($loan_info_sql,array($member_id,$product_id)); 
                //echo "<pre>";echo $loan_info_sql->result_array();die;
		return $loan_info_sql->result_array();
	}
	//To get loan advance collection info
        function get_loan_advance_collection_info($member_id=null,$product_id=null)
	{
                $loan_advance_collection_info_sql="SELECT advance_collection_amount,transaction_date as advance_collection_date 
                FROM loan_advance_collection_register 
		left join loans on loans.id=loan_advance_collection_register.loan_id
		where loan_advance_collection_register.product_id=? and loans.member_id=?";
               $loan_advance_collection_info_sql=$this->db->query($loan_advance_collection_info_sql,array($product_id,$member_id));
		       return  $loan_advance_collection_info_sql->result_array();
	}
	//To get duc collection info
        function get_loan_due_collection_info($member_id=null,$product_id=null)
	{
               $loan_due_collection_info_sql="SELECT due_collection_amount,transaction_date as due_collection_date FROM loan_due_collection_register 
		left join loans on loans.id=loan_due_collection_register.loan_id
		where loan_due_collection_register.product_id=? and loans.member_id=?";
               $loan_due_collection_info_sql=$this->db->query($loan_due_collection_info_sql,array($product_id,$member_id)); 
		       return  $loan_due_collection_info_sql->result_array();
	}

	function get_date_list($branch_id=null,$member_id=null,$samity_id=null,$product_id=null)
	{
		//Start to Collect Transaction Date
		//Transaction Date is collected from loan advance collection Register 
		$date_info_sql_loan_advance_collection_register="SELECT transaction_date FROM loan_advance_collection_register,loans 
		 where loans.member_id=? and loan_advance_collection_register.product_id=? and loans.id=loan_advance_collection_register.loan_id";
                $date_info_sql_loan_advance_collection_register=$this->db->query($date_info_sql_loan_advance_collection_register,array($member_id,$product_id));
		foreach ($date_info_sql_loan_advance_collection_register->result_array() as $date_info_row)
		{							
			$date_info[$date_info_row['transaction_date']]['date']=$date_info_row['transaction_date'];
				// $date_info[$date_info_row['schedule_date']]['recoverable_amount']=$date_info_row['recoverable_amount'];
				$date_info[$date_info_row['transaction_date']]['installment_number']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['transaction_date']]['saving_refund']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['transaction_date']]['repay_week_no']=0;
			$date_info[$date_info_row['transaction_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['transaction_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['transaction_date']]['installment_amount']=0;
		}
		// Transaction Date is collected from loan due collection Register
		$date_info_sql_loan_due_collection_register="SELECT transaction_date FROM loan_due_collection_register,loans 
		 where loans.member_id=? and loan_due_collection_register.product_id=? and loans.id=loan_due_collection_register.loan_id";
                $date_info_sql_loan_due_collection_register=$this->db->query($date_info_sql_loan_due_collection_register,array($member_id,$product_id));
		foreach ($date_info_sql_loan_due_collection_register->result_array() as $date_info_row)
		{							
			$date_info[$date_info_row['transaction_date']]['date']=$date_info_row['transaction_date'];
			$date_info[$date_info_row['transaction_date']]['installment_number']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['transaction_date']]['saving_refund']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['transaction_date']]['repay_week_no']=0;
			$date_info[$date_info_row['transaction_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['transaction_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['transaction_date']]['installment_amount']=0;
		}
		// Transaction Date is collected from Saving Deposit
		$date_info_sql_deposits="SELECT transaction_date FROM saving_deposits 
		 where saving_deposits.member_id=? and saving_deposits.member_primary_product_id=?";
                $date_info_sql_deposits=$this->db->query($date_info_sql_deposits,array($member_id,$product_id));
		foreach ($date_info_sql_deposits->result_array() as $date_info_row)
		{							
			$date_info[$date_info_row['transaction_date']]['date']=$date_info_row['transaction_date'];
			$date_info[$date_info_row['transaction_date']]['installment_number']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['transaction_date']]['saving_refund']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['transaction_date']]['repay_week_no']=0;
			$date_info[$date_info_row['transaction_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['transaction_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['transaction_date']]['installment_amount']=0;
		}
		//Transaction Date is collected from Loan Transaction Table
		$date_info_sql_loan_transactions="SELECT transaction_date FROM loan_transactions,loans 
		 where loans.member_id=? and loan_transactions.product_id=? and loans.id=loan_transactions. loan_id";
                $date_info_sql_loan_transactions=$this->db->query($date_info_sql_loan_transactions,array($member_id,$product_id));
		foreach ($date_info_sql_loan_transactions->result_array() as $date_info_row)
		{							
			$date_info[$date_info_row['transaction_date']]['date']=$date_info_row['transaction_date'];
			$date_info[$date_info_row['transaction_date']]['installment_number']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['transaction_date']]['saving_refund']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['transaction_date']]['repay_week_no']=0;
			$date_info[$date_info_row['transaction_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['transaction_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['transaction_date']]['installment_amount']=0;
		}
		// Transaction Date is collected from saving_withdraw table
                $date_info_sql_withdraws="SELECT transaction_date FROM saving_withdraws
                where saving_withdraws.member_id=? and saving_withdraws.member_primary_product_id=? ";
                $date_info_sql_withdraws=$this->db->query($date_info_sql_withdraws,array($member_id,$product_id)); 
               
		foreach ($date_info_sql_withdraws->result_array() as $date_info_row)	
		{							
			$date_info[$date_info_row['transaction_date']]['date']=$date_info_row['transaction_date'];
			$date_info[$date_info_row['transaction_date']]['installment_number']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['transaction_date']]['saving_refund']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['transaction_date']]['repay_week_no']=0;
			$date_info[$date_info_row['transaction_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['transaction_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['transaction_date']]['installment_amount']=0;
		}
		// Get Recoverable Amount,Schedule Date,installment number from scheduler1.php
		 $date_info_sql_loan_schedule = $this->scheduler1->get_loan_schedules_by_memeberlist_branch_product(array($member_id),$branch_id,$product_id,$samity_id);
		 //echo "<pre>";print_r($date_info_sql_loan_schedule);die;
		foreach ($date_info_sql_loan_schedule as $date_info_rows)
		{	
			foreach ($date_info_rows as $date_info_row1)
			{	
				foreach ($date_info_row1 as $date_info_row)
			{
				//echo "<pre>";print_r($date_info_row);die;				
				$date_info[$date_info_row['schedule_date']]['date']=$date_info_row['schedule_date'];
				// $date_info[$date_info_row['schedule_date']]['recoverable_amount']=$date_info_row['recoverable_amount'];
				$date_info[$date_info_row['schedule_date']]['installment_number']=$date_info_row['installment_number'];
			$date_info[$date_info_row['schedule_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['schedule_date']]['saving_refund']=0;
			$date_info[$date_info_row['schedule_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['schedule_date']]['repay_week_no']=0;
			$date_info[$date_info_row['schedule_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['schedule_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['schedule_date']]['installment_amount']=$date_info_row['installment_amount']; 
			}
		}
		}
		
		
		if (!empty($date_info))
		ksort($date_info);   // Sort All Transaction Date
		// Get weekly deposit
               $saving_deposit_info=$this->get_saving_deposit_information($member_id,$product_id);
                foreach ($saving_deposit_info as $saving_deposit_info_row)
		{			
			$date_info[$saving_deposit_info_row['saving_date']]['weekly_deposit']=$saving_deposit_info_row['weekly_deposit']; 			
		}
		// Get Saving Refund
		$saving_withdraw_info=$this->get_saving_withdraw_information($member_id,$product_id);

                foreach ($saving_withdraw_info as $saving_withdraw_info_row)
		{			
			$date_info[$saving_withdraw_info_row['withdraw_date']]['saving_refund']=$saving_withdraw_info_row['saving_refund']; 
			$date_info[$date_info_row['withdraw_date']]['installment_number']=0;
			$date_info[$date_info_row['withdraw_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['withdraw_date']]['saving_refund']=0;
			$date_info[$date_info_row['withdraw_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['withdraw_date']]['repay_week_no']=0;
			$date_info[$date_info_row['withdraw_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['withdraw_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['withdraw_date']]['installment_amount']=0;			
		}
		// Get Weekly Recovery,current repay week no and current outstanding amount
		$loan_info=$this->get_loan_info($member_id,$product_id);
        foreach ($loan_info as $loan_info_row)
		{							
			$date_info[$loan_info_row['transaction_date']]['weekly_recovery']=$loan_info_row['weekly_recovery'];
            $date_info[$loan_info_row['transaction_date']]['current_repay_week_no']=$loan_info_row['current_repay_week_no'];
             $date_info[$loan_info_row['transaction_date']]['current_outstanding_amount']=$loan_info_row['current_outstanding_amount'];
             $date_info[$date_info_row['transaction_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['transaction_date']]['saving_refund']=0;
			$date_info[$date_info_row['transaction_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['transaction_date']]['repay_week_no']=0;
			$date_info[$date_info_row['transaction_date']]['advance_collection_amount']=0;
			$date_info[$date_info_row['transaction_date']]['due_collection_amount']=0; 
			$date_info[$date_info_row['transaction_date']]['installment_amount']=0;
             			
		}
		// Get Advance Collection Amount
		$loan_advance_collection_info=$this->get_loan_advance_collection_info($member_id,$product_id);
                foreach ($loan_advance_collection_info as $loan_advance_collection_info_row)
		{							
			$date_info[$loan_advance_collection_info_row['advance_collection_date']]['advance_collection_amount']=$loan_advance_collection_info_row['advance_collection_amount'];	
			$date_info[$date_info_row['advance_collection_date']]['saving_refund']=0;
			$date_info[$date_info_row['advance_collection_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['advance_collection_date']]['repay_week_no']=0;
			$date_info[$date_info_row['advance_collection_date']]['advance_collection_amount']=0; 
			$date_info[$date_info_row['advance_collection_date']]['installment_amount']=0;
		}
		// Get Due Collection Amount
		$loan_due_collection_info=$this->get_loan_due_collection_info($member_id,$product_id);
                foreach ($loan_due_collection_info as $loan_due_collection_info_row)
		{							
			$date_info[$loan_due_collection_info_row['due_collection_date']]['due_collection_amount']=$loan_due_collection_info_row['due_collection_amount'];
			 $date_info[$date_info_row['due_collection_date']]['weekly_deposit']=0;
			$date_info[$date_info_row['due_collection_date']]['saving_refund']=0;
			$date_info[$date_info_row['due_collection_date']]['weekly_recovery']=0;
			$date_info[$date_info_row['due_collection_date']]['repay_week_no']=0;
			$date_info[$date_info_row['due_collection_date']]['advance_collection_amount']=0; 
			$date_info[$date_info_row['due_collection_date']]['installment_amount']=0;
		}
		return $date_info;	
	}


}
