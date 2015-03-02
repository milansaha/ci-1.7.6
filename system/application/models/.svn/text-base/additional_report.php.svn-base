<?php
/** 
	* PO MIS Report Model Class.
	* @pupose		PO MIS information
	*		
	* @filesource	./system/application/models/po_mis_report.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_mis_report
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Additional_report extends MY_Model { // 'MY_Model' user defined model; default model 'Model'

    
    function Additional_report()
    {
        // Call the Model constructor
        //parent::MY_Model();
    }

	function get_productive_ratio($month_name=null,$year_name=null,$branch_id=null,$product_id=null)
	{
		if(is_null($branch_id)){$branch_id='';}
		if(is_null($product_id)){$product_id='';}
		$get_productive_ratio = 'get_productive_ratio';
		$start_date = $year_name.'-'.$month_name.'-'.'01';
		$end_date = $year_name.'-'.$month_name.'-'.'30';
		$sql = "-- A.1 Member per Samity
				SELECT IFNULL((A.total_members / B.total_samities),0) AS member_per_samity
				FROM (
					SELECT COUNT(members.id) AS total_members FROM members 
					WHERE member_status = 'Active'
					AND members.created_on BETWEEN '$start_date' AND '$end_date'
					AND members.branch_id = $branch_id
				) A JOIN (
					SELECT COUNT(samities.id) AS total_samities FROM samities 
					WHERE samities.status = 1
					AND samities.branch_id = $branch_id
				) B
				UNION ALL
				-- A.2 Member per Field Worker
				SELECT IFNULL((C.total_members / D.total_field_workers),0) AS member_per_field_worker
				FROM (
					SELECT COUNT(members.id) AS total_members FROM members 
					WHERE members.member_status = 'Active'
					AND members.created_on BETWEEN '$start_date' AND '$end_date'
					AND members.branch_id = $branch_id
				) C JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE samities.status = 1
					AND samities.created_date <= '$end_date'
					AND samities.branch_id = $branch_id
					GROUP BY samities.branch_id
					ORDER BY samities.created_date DESC 
				) D
				UNION ALL
				-- A.3 Borrower per Field Worker
				SELECT IFNULL((E.total_borrowers / F.total_field_workers),0) AS borrower_per_field_worker
				FROM (
					SELECT COUNT(members.id) AS total_borrowers
					FROM members JOIN loans ON members.id = loans.member_id
					WHERE members.member_status = 1
					AND members.branch_id = $branch_id
				) E JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE samities.status = 1
					AND samities.created_date <= '$end_date'
					AND samities.branch_id = $branch_id
					GROUP BY samities.branch_id
					ORDER BY samities.created_date DESC 
				) F
				UNION ALL
				-- A.4 Borrower Coverage %
				SELECT IFNULL((G.total_members / H.total_borrowers),0) AS borrower_coverage
				FROM (
					SELECT COUNT(members.id) AS total_members 
					FROM members 
					WHERE member_status = 'Active'
					AND members.created_on BETWEEN '$start_date' AND '$end_date'
					AND members.branch_id = $branch_id
				) G JOIN (
					SELECT COUNT(members.id) AS total_borrowers
					FROM members JOIN loans ON members.id = loans.member_id
					WHERE members.member_status = 1
					AND members.branch_id = $branch_id
				) H
				UNION ALL
				-- A.6 average loan size
				SELECT IFNULL((J.total_loan / J.total_loan_no),0) AS average_laon_size
				FROM(
					SELECT SUM(loans.loan_amount) AS total_loan, COUNT(loans.id) AS total_loan_no
					FROM loans 
					WHERE loans.is_authorized = 1
					AND loans.current_status = 1
					AND loans.branch_id = $branch_id
				) J 
				UNION ALL
				-- A.8 Total Staff : Total Field Worker
				SELECT IFNULL((K.total_staff / L.total_field_workers),0) AS total_staff_vs_field_worker
				FROM (
					SELECT COUNT(employees.id) AS total_staff
					FROM employees
					WHERE employees.branch_id = $branch_id
				) AS K JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE employees.status = 1
					AND employees.is_field_officer = 0
					AND samities.branch_id = $branch_id
					AND samities.status = 1
					AND samities.created_date <= '$end_date'
					GROUP BY samities.branch_id
					ORDER BY samities.created_date DESC
				) AS L
				UNION ALL
				SELECT IFNULL((M.total_outstanding_loan / N.total_field_workers),0) AS portfolio_per_field_worker
				FROM (
					SELECT (loans.total_payable_amount - SUM(loan_transactions.transaction_amount)) AS total_outstanding_loan
					FROM loan_transactions JOIN loans ON loan_transactions.loan_id = loans.id
					WHERE loan_transactions.branch_id = $branch_id
					AND loans.is_loan_fully_paid = 0 
					AND loan_transactions.transaction_date BETWEEN '$start_date' AND '$end_date'
					AND loans.branch_id = $branch_id
					GROUP BY loans.branch_id,loans.total_payable_amount
				) AS M JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers 
					FROM employees JOIN samities ON employees.id = samities.field_officer_id 
					WHERE employees.status = 1 
					AND employees.is_field_officer = 0 
					AND samities.branch_id = $branch_id 
					AND samities.status = 1 
					AND samities.created_date <= '$end_date'
					GROUP BY samities.branch_id
					ORDER BY samities.created_date DESC 
				) AS N 
				UNION ALL
				SELECT IFNULL((O.total_outstanding_loan / P.total_borrowers),0) AS outstanding_per_borrower
				FROM (
				SELECT (loans.total_payable_amount - SUM(loan_transactions.transaction_amount)) AS total_outstanding_loan
					FROM loan_transactions JOIN loans ON loan_transactions.loan_id = loans.id
					WHERE loan_transactions.branch_id = $branch_id
					AND loans.is_loan_fully_paid = 0 
					AND loan_transactions.transaction_date BETWEEN '$start_date' AND '$end_date'
					AND loans.branch_id = $branch_id
					GROUP BY loans.branch_id,loans.total_payable_amount 
				) AS O JOIN (
					SELECT COUNT(loans.id) AS total_borrowers
					FROM loans 
					WHERE loans.branch_id = $branch_id
					AND loans.branch_id = $branch_id
					AND loans.first_repayment_date BETWEEN '$start_date' AND '$end_date'
					AND loans.current_status = 1
					AND loans.is_authorized = 1
				) AS P 
				UNION ALL
				SELECT IFNULL((Q.total_outstanding_loan / R.total_staff),0) AS portfolio_per_staff
				FROM (
					SELECT (loans.total_payable_amount - SUM(loan_transactions.transaction_amount)) AS total_outstanding_loan
					FROM loan_transactions JOIN loans ON loan_transactions.loan_id = loans.id
					WHERE loan_transactions.branch_id = $branch_id
					AND loans.is_loan_fully_paid = 0 
					AND loans.branch_id = $branch_id
					AND loan_transactions.transaction_date BETWEEN '$start_date' AND '$end_date'
					GROUP BY loans.branch_id,loans.total_payable_amount 
				) AS Q JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_staff
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE employees.status = 1
					AND samities.status = 1
					AND samities.branch_id = $branch_id
					AND samities.created_date <= '$end_date'
					GROUP BY samities.branch_id
					ORDER BY samities.created_date DESC 
				) AS R
				UNION ALL
				SELECT IFNULL((S.total_outstanding_loan / T.total_branch),0) AS portfolio_per_branch
				FROM (
					SELECT (loans.total_payable_amount - SUM(loan_transactions.transaction_amount)) AS total_outstanding_loan
					FROM loan_transactions JOIN loans ON loan_transactions.loan_id = loans.id
					WHERE loan_transactions.branch_id = $branch_id
					AND loans.is_loan_fully_paid = 0 
					AND loans.branch_id = $branch_id
					AND loan_transactions.transaction_date BETWEEN '$start_date' AND '$end_date'
					GROUP BY loans.branch_id,loans.total_payable_amount
				) AS S JOIN (
					SELECT COUNT(po_branches.id) AS total_branch
					FROM po_branches
				) AS T
				UNION ALL
				SELECT IFNULL((U.total_field_workers / V.total_samities),0) AS field_worker_per_samity
				FROM (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers 
					FROM employees JOIN samities ON employees.id = samities.field_officer_id 
					WHERE employees.status = 1 
					AND employees.is_field_officer = 0 
					AND samities.branch_id = $branch_id 
					AND samities.status = 1 
					AND samities.created_date <= '$end_date'
					GROUP BY samities.branch_id
					ORDER BY samities.created_date DESC 
				) AS U JOIN (
					SELECT COUNT(samities.id) AS total_samities
					FROM samities JOIN po_branches ON samities.branch_id = po_branches.id
					WHERE samities.created_date BETWEEN '$start_date' AND '$end_date'
					AND samities.branch_id = $branch_id
				) AS V";
		//$sql = $this->db->query($sql, array($current_month_first,$current_month_last,$current_month_first,$current_month_last,$current_month_last)); 
		$sql = $this->db->query($sql);
		$i=0;
		$get_productive_ratio="";
		//echo '<pre>';print_r($sql->result_array());//die;
		foreach ($sql->result_array() as $row)
		{	//echo $row['member_per_samity'].'<br/>';
			$i++;
			if($i == 1)
				$get_productive_ratio[$i]['member_per_samity']=$row['member_per_samity'];
			if($i == 2)
				$get_productive_ratio[$i]['member_per_field_worker']=$row['member_per_samity'];
			if($i == 3)
				$get_productive_ratio[$i]['borrower_per_field_worker']=$row['member_per_samity'];
			if($i == 4)
				$get_productive_ratio[$i]['borrower_coverage']=$row['member_per_samity'];
			if($i == 5)
				$get_productive_ratio[$i]['average_laon_size']=$row['member_per_samity'];
			if($i == 6)
				$get_productive_ratio[$i]['total_staff_vs_field_worker']=$row['member_per_samity'];
			if($i == 7)
				$get_productive_ratio[$i]['portfolio_per_field_worker']=$row['member_per_samity'];
			if($i == 8)
				$get_productive_ratio[$i]['outstanding_per_borrower']=$row['member_per_samity'];
			if($i == 9)
				$get_productive_ratio[$i]['portfolio_per_staff']=$row['member_per_samity'];
			if($i == 10)
				$get_productive_ratio[$i]['portfolio_per_branch']=$row['member_per_samity'];
			if($i == 11)
				$get_productive_ratio[$i]['field_worker_per_samity']=$row['member_per_samity'];
			
			/*$get_productive_ratio[$i]['no_of_branch']=$row['no_of_branch_male']+$row['no_of_branch_female'];			
			$get_productive_ratio[$i]['no_of_samity_male']=$row['no_of_samity_male'];
			$get_productive_ratio[$i]['no_of_samity_female']=$row['no_of_samity_female'];
			$get_productive_ratio[$i]['no_of_members_male']=$row['no_of_members_male'];
			$get_productive_ratio[$i]['no_of_members_female']=$row['no_of_members_female'];	*/		
		}//print_r($get_productive_ratio);
		//echo '<pre>';print_r($get_productive_ratio);
		return $get_productive_ratio;
	}
	
	function get_productive_consolidated_ratio($month_name=null,$year_name=null)
	{		
		$get_productive_ratio = 'get_productive_ratio';
		$start_date = $year_name.'-'.$month_name.'-'.'01';
		$end_date = $year_name.'-'.$month_name.'-'.'30';
		$sql = "/* A.1 Member per Samity */
				SELECT IFNULL((A.total_members / B.total_samities),0) AS member_per_samity
				FROM (
					SELECT COUNT(members.id) AS total_members FROM members 
					WHERE member_status = 'Active'
					AND members.created_on BETWEEN '$start_date' AND '$end_date'
				) A JOIN (
					SELECT COUNT(samities.id) AS total_samities FROM samities 
					WHERE samities.status = 1
				) B
				UNION ALL
				/* A.2 Member per Field Worker */
				SELECT IFNULL((C.total_members / D.total_field_workers),0) AS member_per_field_worker
				FROM (
					SELECT COUNT(members.id) AS total_members FROM members 
					WHERE members.member_status = 'Active'
					AND members.created_on BETWEEN '$start_date' AND '$end_date'
				) C JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE samities.status = 1
					AND samities.created_date <= '$end_date'
				) D
				UNION ALL
				/* A.3 Borrower per Field Worker */
				SELECT IFNULL((E.total_borrowers / F.total_field_workers),0) AS borrower_per_field_worker
				FROM (
					SELECT COUNT(members.id) AS total_borrowers
					FROM members JOIN loans ON members.id = loans.member_id
					WHERE members.member_status = 1
				) E JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE samities.status = 1
					AND samities.created_date <= '$end_date'
				) F
				UNION ALL
				/* A.4 Borrower Coverage % */
				SELECT IFNULL((G.total_members / H.total_borrowers),0) AS borrower_coverage
				FROM (
					SELECT COUNT(members.id) AS total_members 
					FROM members 
					WHERE member_status = 'Active'
					AND members.created_on BETWEEN '$start_date' AND '$end_date'
				) G JOIN (
					SELECT COUNT(members.id) AS total_borrowers
					FROM members JOIN loans ON members.id = loans.member_id
					WHERE members.member_status = 1
				) H
				UNION ALL
				/* A.6 average loan size */
				SELECT IFNULL((J.total_loan / J.total_loan_no),0) AS average_laon_size
				FROM(
					SELECT SUM(loans.loan_amount) AS total_loan, COUNT(loans.id) AS total_loan_no
					FROM loans 
					WHERE loans.is_authorized = 1
					AND loans.current_status = 1
				) J 
				UNION ALL
				/* A.8 Total Staff : Total Field Worker */
				SELECT IFNULL((K.total_staff / L.total_field_workers),0) AS total_staff_vs_field_worker
				FROM (
					SELECT COUNT(employees.id) AS total_staff
					FROM employees
				) AS K JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE employees.status = 1
					AND employees.is_field_officer = 0
					AND samities.status = 1
					AND samities.created_date <= '$end_date'
				) AS L
				UNION ALL
				/* Porfolio per Field Worker */
				SELECT IFNULL((M.total_outstanding_loan / N.total_field_workers),0) AS portfolio_per_field_worker
				FROM (
					SELECT (loans.total_payable_amount - SUM(loan_transactions.transaction_amount)) AS total_outstanding_loan
					FROM loan_transactions JOIN loans ON loan_transactions.loan_id = loans.id
					WHERE loans.is_loan_fully_paid = 0 
					AND loan_transactions.transaction_date BETWEEN '$start_date' AND '$end_date'
					GROUP BY loans.branch_id,loans.total_payable_amount
				) AS M JOIN (
					SELECT COUNT(DISTINCT(samities.field_officer_id)) AS total_field_workers
					FROM employees JOIN samities ON employees.id = samities.field_officer_id
					WHERE employees.status = 1
					AND employees.is_field_officer = 0
					AND samities.status = 1
					AND samities.created_date <= '$end_date'
				) AS N 
				UNION ALL
				/* Outstanding per Borrower */
				SELECT IFNULL((O.total_outstanding_loan / P.total_borrowers),0) AS outstanding_per_borrower
				FROM (
				SELECT (loans.total_payable_amount - SUM(loan_transactions.transaction_amount)) AS total_outstanding_loan
					FROM loan_transactions JOIN loans ON loan_transactions.loan_id = loans.id
					WHERE loans.is_loan_fully_paid = 0 
					AND loan_transactions.transaction_date BETWEEN '$start_date' AND '$end_date'
					GROUP BY loans.branch_id,loans.total_payable_amount
				) AS O JOIN (
					SELECT COUNT(loans.id) AS total_borrowers
					FROM loans 
					WHERE loans.first_repayment_date BETWEEN '$start_date' AND '$end_date' 
					AND loans.current_status = 1
					AND loans.is_authorized = 1
				) AS P ";
		//$sql = $this->db->query($sql, array($current_month_first,$current_month_last,$current_month_first,$current_month_last,$current_month_last)); 
		$sql = $this->db->query($sql);
		$i=0;
		$get_productive_ratio="";
		//echo '<pre>';print_r($sql->result_array());//die;
		foreach ($sql->result_array() as $row)
		{	//echo $row['member_per_samity'].'<br/>';
			$i++;
			if($i == 1)
				$get_productive_ratio[$i]['member_per_samity']=$row['member_per_samity'];
			if($i == 2)
				$get_productive_ratio[$i]['member_per_field_worker']=$row['member_per_samity'];
			if($i == 3)
				$get_productive_ratio[$i]['borrower_per_field_worker']=$row['member_per_samity'];
			if($i == 4)
				$get_productive_ratio[$i]['borrower_coverage']=$row['member_per_samity'];
			if($i == 5)
				$get_productive_ratio[$i]['average_laon_size']=$row['member_per_samity'];
			if($i == 6)
				$get_productive_ratio[$i]['total_staff_vs_field_worker']=$row['member_per_samity'];
			if($i == 7)
				$get_productive_ratio[$i]['portfolio_per_field_worker']=$row['member_per_samity'];
			if($i == 8)
				$get_productive_ratio[$i]['outstanding_per_borrower']=$row['member_per_samity'];
			
			/*$get_productive_ratio[$i]['no_of_branch']=$row['no_of_branch_male']+$row['no_of_branch_female'];			
			$get_productive_ratio[$i]['no_of_samity_male']=$row['no_of_samity_male'];
			$get_productive_ratio[$i]['no_of_samity_female']=$row['no_of_samity_female'];
			$get_productive_ratio[$i]['no_of_members_male']=$row['no_of_members_male'];
			$get_productive_ratio[$i]['no_of_members_female']=$row['no_of_members_female'];	*/		
		}//print_r($get_productive_ratio);
		return $get_productive_ratio;
	}
	
}
