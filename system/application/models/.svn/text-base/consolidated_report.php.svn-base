<?php
/** 
	* consolidated Reports Model Class.
	* @pupose		PO MIS information
	*		
	* @filesource	./system/application/models/consolidated_report.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.consolidated_report
	* @version      $Revision: 1 $
	* @author       $Author: S. Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-25 $	 
*/ 
class Consolidated_report extends MY_Model {
    

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    } 	
	function get_product_mnemonic($product_id=null)
	{
		// Call the Model constructor
		parent::Model();
	} 	
	function get_consolidated_report_information_member_savings_loan($branch_id=null,$first_date=null,$last_date=null){
			//print($branch_id);
			//print($first_date);
			//print($last_date);die;
			
			$query="SELECT month_end_process_members.branch_id,
				po_branches.code,po_branches.name,
				E.employee_name,
				SUM(closing_member) AS member_no,				
				SUM(closing_borrower_no) AS borrower_no,
				SUM(disbursed_amount) AS current_loan,
				SUM(closing_outstanding_amount_with_services_charge) AS loan_outstanding,
				(SUM(substandard_overdue_with_services_charge)+SUM(doubtfull_overdue_with_services_charge)+SUM(bad_overdue_with_services_charge)) AS overdue,
				SUM(closing_balance) AS savings
				
				FROM month_end_process_members JOIN month_end_process_savings ON month_end_process_savings.branch_id=month_end_process_members.branch_id
				JOIN month_end_process_loans ON month_end_process_loans.branch_id=month_end_process_members.branch_id								
				JOIN po_branches ON po_branches.id=month_end_process_members.branch_id
				
				JOIN (SELECT po_branches.id as branch_id,employees.name as employee_name,employees.code as employee_code
				FROM employees JOIN employee_designations ON employees.designation_id=employee_designations.id
				JOIN po_branches ON employees.branch_id=po_branches.id
				WHERE is_manager=1";
				if($branch_id>0){
					$query.=" AND po_branches.id=$branch_id  ";
				}				
				$query.=" GROUP BY po_branches.id,employees.name,employees.code ) as E on E.branch_id=month_end_process_loans.branch_id
				WHERE month_end_process_members.date BETWEEN '$first_date' AND '$last_date'
				AND month_end_process_loans.date BETWEEN '$first_date' AND '$last_date'
				AND month_end_process_savings.DATE BETWEEN '$first_date' AND '$last_date'";
				if($branch_id>0){
					$query.=" AND month_end_process_members.branch_id=$branch_id AND month_end_process_savings.branch_id=$branch_id AND month_end_process_loans.branch_id=$branch_id ";
				}
				$query.="GROUP BY month_end_process_members.branch_id,po_branches.code,po_branches.name,E.employee_name";	
				
		$query=$this->db->query($query);
		$query=$query->result();
		//echo "<pre>";print_r($query);die;
		return $query;
	}	
	
	/*function get_consolidated_report_information($branch_id=null,$date=null)
	{		
		$consolidated_report_information_sql ="SELECT name,code,SUM(IF(data_type='member',members,0)) AS members
			,SUM(IF(data_type='loan',borrowers,0)) AS borrowers,SUM(IF(data_type='loan',current_loan,0)) AS current_loan
			,SUM(IF(data_type='loanT',loan_recovery,0)) AS loan_recovery
			,SUM(IF(data_type='SavingsT',savings_balance,0)) AS savings_balance,IF(data_type='member',manager,0) AS manager
			FROM (

			SELECT 'member' AS data_type,po_branches.id,po_branches.name,po_branches.code,COUNT(DISTINCT members.id)AS members 
			,0 AS borrowers,0 AS current_loan,0 AS loan_recovery,0 AS savings_balance,employees.name AS manager
			FROM po_branches LEFT JOIN members ON members.branch_id=po_branches.id 
			LEFT JOIN employees ON employees.branch_id=po_branches.id AND employees.designation_id=2            
			WHERE members.registration_date<=?
			GROUP BY   po_branches.name,po_branches.code  

			UNION ALL

			SELECT 'loan' AS data_type,po_branches.id,po_branches.name,po_branches.code,0 AS members 
			,COUNT(DISTINCT loans.id) AS borrowers,sum(loans.total_payable_amount) AS current_loan,0 AS loan_recovery,0 AS savings_balance,'' AS manager
			FROM po_branches LEFT JOIN loans ON loans.branch_id=po_branches.id 
			WHERE loans.disburse_date<=?
			AND loans.loan_fully_paid_date IS NULL  
			GROUP BY   po_branches.name,po_branches.code 

			UNION ALL

			SELECT 'loanT' AS data_type,po_branches.id,po_branches.name,po_branches.code,0 AS members 
			,0 AS borrowers,0 AS current_loan,SUM(loan_transactions.transaction_amount) AS loan_recovery,0 AS savings_balance,'' AS manager
			FROM po_branches 
			LEFT JOIN loans ON loans.branch_id=po_branches.id  
			LEFT JOIN loan_transactions ON loan_transactions.branch_id=po_branches.id        
			WHERE loan_transactions.transaction_date<=?
			AND loans.loan_fully_paid_date IS NULL 
			GROUP BY   po_branches.name,po_branches.code 

			UNION ALL

			SELECT 'SavingsT' AS data_type,po_branches.id,po_branches.name,po_branches.code,0 AS members 
			,0 AS borrowers,0 AS current_loan,0 AS loan_recovery,SUM(saving_transactions.amount) AS savings_balance,'' AS manager
			FROM po_branches LEFT JOIN saving_transactions ON saving_transactions.branch_id=po_branches.id        
			WHERE saving_transactions.transaction_date<=?
			GROUP BY   po_branches.name,po_branches.code 
			) AS consolidated_balance";				
			if($branch_id>0)
			{
				$consolidated_report_information_sql .=" where consolidated_balance.id=? ";
			}	
			$consolidated_report_information_sql .=" GROUP BY name,code ";	
			if($branch_id>0)
			{
				$consolidated_report_information_sql =$this->db->query($consolidated_report_information_sql , array($date,$date,$date,$date,$branch_id));	
			}
			else
			{
				$consolidated_report_information_sql =$this->db->query($consolidated_report_information_sql , array($date,$date,$date,$date));	
			}	
			
		$consolidated_report_information=array();	
		$i=0;	
		foreach ($consolidated_report_information_sql->result_array() as $consolidated_report_information_row)
		{	
			$i++;
			$consolidated_report_information[$i]['branch_code']=$consolidated_report_information_row['code'];
			$consolidated_report_information[$i]['branch_name']=$consolidated_report_information_row['name'];
			$consolidated_report_information[$i]['members']=$consolidated_report_information_row['members'];	
			$consolidated_report_information[$i]['borrowers']=$consolidated_report_information_row['borrowers'];
			$consolidated_report_information[$i]['current_loan']=$consolidated_report_information_row['current_loan'];
			$consolidated_report_information[$i]['loan_outstanding']=$consolidated_report_information_row['current_loan']-$consolidated_report_information_row['loan_recovery'];
			$consolidated_report_information[$i]['overdue']=0;
			$consolidated_report_information[$i]['savings_balance']=$consolidated_report_information_row['savings_balance'];
			$consolidated_report_information[$i]['manager']=$consolidated_report_information_row['manager'];
		}
		//echo "<pre>";print_r($consolidated_report_information);die;
		return $consolidated_report_information;
	}*/
}
