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
class Po_mis_report extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model(array('Report','Loan_product'));
    }
	
	function get_branches_info($branch_id=null)
    {
        $sql = "SELECT po_branches.name as branch_name,po_branches.code,po_branches.address FROM po_branches WHERE id = ?";
		$sql=$this->db->query($sql, array($branch_id)); 
		foreach ($sql->result_array() as $row)
		{
		   	$branch_info['name']=$row['branch_name'];
			$branch_info['code']=$row['code'];
			$branch_info['address']=$row['address'];		   
		}
		return $branch_info;
    }	
	function get_current_month_max_transaction($month=null,$year=null)
    {
		$date=$year."-".$month;	
		$date = " LIKE '$date%'";	
		$sql = "SELECT MAX(date) AS max_transaction_date FROM day_end_process_savings WHERE day_end_process_savings.date $date";
		$sql=$this->db->query($sql); 		
		foreach ($sql->result_array() as $row)
		{
		   	$current_month_max_transaction['current_month_date']=$row['max_transaction_date'];					   
		}				
		return $current_month_max_transaction;
	}
	function get_previous_month_max_transaction($month=null,$year=null)
    {
		$date=$year."-".$month.'-01';	
		$previous_month=date("Y-m-d",strtotime("-1 month", strtotime($date)));	
		$date = " LIKE '$previous_month%'";	
		$sql = "SELECT MAX(date) AS max_transaction_date FROM day_end_process_savings WHERE day_end_process_savings.date $date";
		$sql=$this->db->query($sql); 		
		foreach ($sql->result_array() as $row)
		{
		   	$previous_month_max_transaction['previous_month_date']=$row['max_transaction_date'];					   
		}				
		return $previous_month_max_transaction;
	}
	// Report-1
	function get_total_branches($month=null,$year=null)
    {
        $current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($current_month_first))));
		$sql = "SELECT COUNT(id) as total_branche_no FROM po_branches WHERE opening_date<?";
		$sql=$this->db->query($sql, array($current_month_last)); 
		foreach ($sql->result_array() as $row)
		{
		   	$branch_info['total_branche_no']=$row['total_branche_no'];				   
		}
		return $branch_info;
    } 
	function get_branch_member_information($branch_id=null,$month=null,$year=null)
	{
		$date_range=$this->Report->get_first_last_date_of_a_month($year,$month);
		$loan_product_list=$this->Loan_product->get_product_info();
		$sql = "SELECT loan_product_categories.short_name,SUM(IF(TYPE = 'M',branch_no,0)) AS branch_no
					,SUM(IF(TYPE = 'M',samity_no,0)) AS no_of_samity_male,SUM(IF(TYPE = 'F',samity_no,0)) AS no_of_samity_female
					,SUM(IF(TYPE = 'M',opening_member,0)) AS no_of_opening_member_male,SUM(IF(TYPE = 'F',opening_member,0)) AS no_of_opening_member_female
					,SUM(IF(TYPE = 'M',new_member_admission_no,0)) AS no_of_new_member_admission_male
					,SUM(IF(TYPE = 'F',new_member_admission_no,0)) AS no_of_new_member_admission_female
					,SUM(IF(TYPE = 'M',member_cancellation_no,0)) AS no_of_member_cancellation_male
					,SUM(IF(TYPE = 'F',member_cancellation_no,0)) AS no_of_member_cancellation_female
					,avg_savings_depositor,avg_attendance
					-- FROM loan_product_categories LEFT JOIN month_end_process_members ON loan_product_categories.id=month_end_process_members.product_id
					FROM loan_products LEFT JOIN month_end_process_members ON loan_products.id=month_end_process_members.product_id
                    JOIN loan_product_categories ON loan_product_categories.id=loan_products.loan_product_category_id
                    WHERE DATE BETWEEN ? AND ?";					
			if($branch_id>0)
			{
				$sql .=" AND branch_id=? GROUP BY loan_product_categories.short_name,avg_savings_depositor,avg_attendance"; 
				$sql=$this->db->query($sql, array($date_range['first_date'],$date_range['last_date'],$branch_id)); 
			}
			else
			{
				$sql .=" GROUP BY loan_product_categories.short_name,avg_savings_depositor,avg_attendance"; 
				$sql=$this->db->query($sql, array($date_range['first_date'],$date_range['last_date'])); 
			}
			$i=0;
			$branch_member_info=array();
			foreach ($sql->result_array() as $row)
			{			
				$i++;			
				$branch_member_info[$i]['mnemonic']=$row['short_name'];	
				$branch_member_info[$i]['no_of_branch']=$row['branch_no'];			
				$branch_member_info[$i]['avg_savings_depositor']=$row['avg_savings_depositor'];
				$branch_member_info[$i]['avg_attendance']=$row['avg_attendance'];
				$branch_member_info[$i]['no_of_samity_male']=$row['no_of_samity_male'];
				$branch_member_info[$i]['no_of_samity_female']=$row['no_of_samity_female'];
				$branch_member_info[$i]['prev_month_no_of_member_male']=$row['no_of_opening_member_male'];
				$branch_member_info[$i]['prev_month_no_of_member_female']=$row['no_of_opening_member_female'];	
				$branch_member_info[$i]['no_of_new_member_admission_male']=$row['no_of_new_member_admission_male'];
				$branch_member_info[$i]['no_of_new_member_admission_female']=$row['no_of_new_member_admission_female'];
				$branch_member_info[$i]['no_of_member_cancellation_male']=$row['no_of_member_cancellation_male'];
				$branch_member_info[$i]['no_of_member_cancellation_female']=$row['no_of_member_cancellation_female'];
				$branch_member_info[$i]['no_of_member_total_male']=$row['no_of_opening_member_male']+$row['no_of_new_member_admission_male']-$row['no_of_member_cancellation_male'];
				$branch_member_info[$i]['no_of_member_total_female']=$row['no_of_opening_member_female']+$row['no_of_new_member_admission_female']-$row['no_of_member_cancellation_female'];;		
			}
		return $branch_member_info;
	}
	function get_savings_statement_information($branch_id=null,$month=null,$year=null)
	{
		$date_range=$this->Report->get_first_last_date_of_a_month($year,$month);
		$loan_product_list=$this->Loan_product->get_product_info();
		$sql = "SELECT loan_product_categories.short_name
					,SUM(IF(TYPE = 'M',opening_balance,0)) AS opening_balance_male,SUM(IF(TYPE = 'F',opening_balance,0)) AS opening_balance_female
					,SUM(IF(TYPE = 'M',deposit_collection,0)) AS deposit_collection_male,SUM(IF(TYPE = 'F',deposit_collection,0)) AS deposit_collection_female
					,SUM(IF(TYPE = 'M',saving_refund,0)) AS saving_refund_male,SUM(IF(TYPE = 'F',saving_refund,0)) AS saving_refund_female
					,SUM(IF(TYPE = 'M',closing_balance,0)) AS closing_balance_male,SUM(IF(TYPE = 'F',closing_balance,0)) AS closing_balance_female
					-- FROM loan_product_categories LEFT JOIN month_end_process_savings ON loan_product_categories.id=month_end_process_savings.product_id
					FROM loan_products LEFT JOIN month_end_process_savings ON loan_products.id=month_end_process_savings.product_id
                    JOIN loan_product_categories ON loan_product_categories.id=loan_products.loan_product_category_id
                    WHERE DATE BETWEEN ? AND ?";					
			if($branch_id>0)
			{
				$sql .=" AND branch_id=? GROUP BY loan_product_categories.short_name"; 
				$sql=$this->db->query($sql, array($date_range['first_date'],$date_range['last_date'],$branch_id)); 
			}
			else
			{
				$sql .=" GROUP BY loan_product_categories.short_name"; 
				$sql=$this->db->query($sql, array($date_range['first_date'],$date_range['last_date'])); 
			}
			$i=0;
			$savings_statement_information=array();
			foreach ($sql->result_array() as $row)
			{			
				$i++;			
				$savings_statement_information[$i]['mnemonic']=$row['short_name'];	
				$savings_statement_information[$i]['opening_balance_male']=$row['opening_balance_male'];			
				$savings_statement_information[$i]['opening_balance_female']=$row['opening_balance_female'];
				$savings_statement_information[$i]['deposit_collection_male']=$row['deposit_collection_male'];
				$savings_statement_information[$i]['deposit_collection_female']=$row['deposit_collection_female'];
				$savings_statement_information[$i]['saving_refund_male']=$row['saving_refund_male'];	
				$savings_statement_information[$i]['saving_refund_female']=$row['saving_refund_female'];	
				$savings_statement_information[$i]['closing_balance_male']=$row['closing_balance_male'];
				$savings_statement_information[$i]['closing_balance_female']=$row['closing_balance_female'];						
			}
		return $savings_statement_information;

	}	

	/*function get_savings_statement_information($branch_id=null,$month=null,$year=null)
	{
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'1'))));		
		$previous_month_first=date("Y-m-d",strtotime("-1 month", strtotime($current_month_first)));	
		$previous_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($previous_month_first))));
		if($branch_id==-1)
		{
			$sql = "SELECT mnemonic,
				SUM(IF(samity_type = 'MALE',opening_balance,0)) AS opening_balance_male,
				SUM(IF(samity_type = 'FEMALE',opening_balance,0)) AS opening_balance_female,
				SUM(IF(samity_type = 'MALE',total_deposit,0)) AS total_deposit_male,
				SUM(IF(samity_type = 'FEMALE',total_deposit,0)) AS total_deposit_female,
				SUM(IF(samity_type = 'MALE',total_withdraw,0)) AS total_withdraw_male,
				SUM(IF(samity_type = 'FEMALE',total_withdraw,0)) AS total_withdraw_female,
				SUM(IF(samity_type = 'MALE',closing_balance,0)) AS closing_balance_male,
				SUM(IF(samity_type = 'FEMALE',closing_balance,0)) AS closing_balance_female,
				no_of_depositors
				FROM
				(
					SELECT products.mnemonic,branch_id,samity_type,SUM(total_deposit)AS total_deposit,SUM(total_withdraw) AS total_withdraw,SUM(closing_balance) AS closing_balance,
					no_of_depositors,'0' AS opening_balance
					FROM products JOIN day_end_process_savings
					ON products.id=day_end_process_savings.product_id
					WHERE day_end_process_savings.date BETWEEN ? AND ?
					GROUP BY products.mnemonic,branch_id,samity_type

					UNION ALL 

					SELECT products.mnemonic,branch_id,samity_type,'0' AS total_deposit,
					'0' AS total_withdraw,'0' AS closing_balance,'0' AS no_of_depositors,SUM(closing_balance) AS opening_balance
					FROM products JOIN day_end_process_savings
					ON products.id=day_end_process_savings.product_id
					WHERE day_end_process_savings.date BETWEEN ? AND ?
					GROUP BY products.mnemonic,branch_id,samity_type
				) AS day_end_process_info
				GROUP BY mnemonic";
			$sql=$this->db->query($sql, array($current_month_first,$current_month_last,$previous_month_first,$previous_month_last)); 
			$i=0;
			$savings_statement="";
			foreach ($sql->result_array() as $row)
			{
				$i++;			
				$savings_statement[$i]['mnemonic']=$row['mnemonic'];
				$savings_statement[$i]['opening_balance_male']=$row['opening_balance_male'];
				$savings_statement[$i]['opening_balance_female']=$row['opening_balance_female'];
				$savings_statement[$i]['total_deposit_male']=$row['total_deposit_male'];
				$savings_statement[$i]['total_deposit_female']=$row['total_deposit_female'];
				$savings_statement[$i]['total_withdraw_male']=$row['total_withdraw_male'];
				$savings_statement[$i]['total_withdraw_female']=$row['total_withdraw_female'];
				$savings_statement[$i]['closing_balance_male']=$row['closing_balance_male'];
				$savings_statement[$i]['closing_balance_female']=$row['closing_balance_female'];
			}	
		}
		else
		{
			$sql = "SELECT mnemonic,
				SUM(IF(samity_type = 'MALE',opening_balance,0)) AS opening_balance_male,
				SUM(IF(samity_type = 'FEMALE',opening_balance,0)) AS opening_balance_female,
				SUM(IF(samity_type = 'MALE',total_deposit,0)) AS total_deposit_male,
				SUM(IF(samity_type = 'FEMALE',total_deposit,0)) AS total_deposit_female,
				SUM(IF(samity_type = 'MALE',total_withdraw,0)) AS total_withdraw_male,
				SUM(IF(samity_type = 'FEMALE',total_withdraw,0)) AS total_withdraw_female,
				SUM(IF(samity_type = 'MALE',closing_balance,0)) AS closing_balance_male,
				SUM(IF(samity_type = 'FEMALE',closing_balance,0)) AS closing_balance_female,
				no_of_depositors
				FROM
				(
					SELECT products.mnemonic,branch_id,samity_type,SUM(total_deposit)AS total_deposit,SUM(total_withdraw) AS total_withdraw,SUM(closing_balance) AS closing_balance,
					no_of_depositors,'0' AS opening_balance
					FROM products JOIN day_end_process_savings
					ON products.id=day_end_process_savings.product_id
					WHERE day_end_process_savings.branch_id=? AND day_end_process_savings.date BETWEEN ? AND ?
					GROUP BY products.mnemonic,branch_id,samity_type

					UNION ALL 

					SELECT products.mnemonic,branch_id,samity_type,'0' AS total_deposit,
					'0' AS total_withdraw,'0' AS closing_balance,'0' AS no_of_depositors,SUM(closing_balance) AS opening_balance
					FROM products JOIN day_end_process_savings
					ON products.id=day_end_process_savings.product_id
					WHERE day_end_process_savings.branch_id=? AND day_end_process_savings.date BETWEEN ? AND ?
					GROUP BY products.mnemonic,branch_id,samity_type
				) AS day_end_process_info
				GROUP BY mnemonic";
			$sql=$this->db->query($sql, array($branch_id,$current_month_first,$current_month_last,$branch_id,$previous_month_first,$previous_month_last)); 
			$i=0;
			$savings_statement="";
			foreach ($sql->result_array() as $row)
			{
				$i++;			
				$savings_statement[$i]['mnemonic']=$row['mnemonic'];
				$savings_statement[$i]['opening_balance_male']=$row['opening_balance_male'];
				$savings_statement[$i]['opening_balance_female']=$row['opening_balance_female'];
				$savings_statement[$i]['total_deposit_male']=$row['total_deposit_male'];
				$savings_statement[$i]['total_deposit_female']=$row['total_deposit_female'];
				$savings_statement[$i]['total_withdraw_male']=$row['total_withdraw_male'];
				$savings_statement[$i]['total_withdraw_female']=$row['total_withdraw_female'];
				$savings_statement[$i]['closing_balance_male']=$row['closing_balance_male'];
				$savings_statement[$i]['closing_balance_female']=$row['closing_balance_female'];
			}		
		}	
		return $savings_statement;	
	}*/

	function get_member_statement_information($branch_id=null,$month=null,$year=null)
	{
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'1'))));		
		$previous_month_first=date("Y-m-d",strtotime("-1 month", strtotime($current_month_first)));	
		$previous_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($previous_month_first))));
		$member_code=" LIKE '$branch_id%'";
		if($branch_id==-1)
		{
			$sql = "SELECT Product_Id AS Product_Id,mnemonic AS mnemonic,C_Status AS C_Status, Gender AS Gender, 
				SUM(IF(Gender='M',last_month_no_of_member,0)) AS previous_male_member_no,
				SUM(IF(Gender='F',last_month_no_of_member,0)) AS previous_female_member_no,
				SUM(IF(Gender='M',current_month_no_of_member,0)) AS current_male_member_no, 
				SUM(IF(Gender='F',current_month_no_of_member,0)) AS current_female_member_no,
				SUM(IF(Gender='M',no_of_cancel_member,0)) AS canceled_member_no_male, 
				SUM(IF(Gender='F',no_of_cancel_member,0)) AS canceled_member_no_female,
				avg_depositor AS avg_depositor,avg_attendanc AS avg_attendanc
				FROM (
					SELECT Product_Id AS Product_Id,mnemonic AS mnemonic,'' AS C_Status, Gender AS Gender, SUM(last_month_no_of_member) AS last_month_no_of_member,
					SUM(current_month_no_of_member) AS current_month_no_of_member, 
					SUM(no_of_cancel_member) AS no_of_cancel_member, avg_depositor AS avg_depositor,avg_attendanc AS avg_attendanc
					FROM (					
						SELECT  products.id AS Product_Id,products.mnemonic, members.Gender AS Gender,COUNT(members.id) AS last_month_no_of_member , 0  AS current_month_no_of_member  , 0 AS no_of_cancel_member , 0 AS avg_depositor,0 AS avg_attendanc 
						FROM products JOIN samities ON products.id=samities.product_id
						JOIN members ON members.samity_id=samities.id
						WHERE members.registration_date<? 
						AND members.id NOT IN(SELECT id
						FROM members
						WHERE members.member_status='Inactive'
						AND members.cancel_date>?) 
						GROUP BY products.mnemonic,Gender

						UNION ALL
		
						SELECT  products.id AS Product_Id,products.mnemonic, Gender AS Gender, 0 AS No_Of_Member_End_Last_Month ,
						COUNT(DISTINCT members.id ) AS No_Of_Current_Member , 0 AS No_Of_Cancel_Member , 0 AS avg_depositor,0 AS avg_attendanc 
						FROM products JOIN samities ON products.id=samities.product_id
						JOIN members ON members.samity_id=samities.id		
						WHERE members.member_status ='ACTIVE' 
						AND members.code $member_code AND members.registration_date BETWEEN ? AND ?
						GROUP BY  products.id,Gender
						
						UNION ALL

						SELECT Product_Id,mnemonic,'' AS Gender,0 AS last_month_no_of_member , 0  AS current_month_no_of_member  , 0 AS no_of_cancel_member 
						, (no_of_depositors/date) AS avg_depositor,0 AS avg_attendanc
						FROM 			
							(SELECT products.id AS Product_Id,products.mnemonic,COUNT(day_end_process_savings.date) AS date,
							SUM(day_end_process_savings.no_of_depositors) AS no_of_depositors
							FROM products JOIN day_end_process_savings ON products.id=day_end_process_savings.product_id			
							WHERE day_end_process_savings.date BETWEEN ? AND ?
							GROUP BY products.mnemonic,day_end_process_savings.branch_id) AS agv_dep

						UNION ALL
			
						SELECT Product_Id,mnemonic,'' AS Gender,0 AS last_month_no_of_member , 0  AS current_month_no_of_member  , 0 AS no_of_cancel_member ,
						0 AS avg_depositor, (attendanc/DATE) AS avg_attendanc
						FROM (			
							SELECT products.id AS Product_Id,products.mnemonic,COUNT(DISTINCT DATE) AS DATE
							,'' AS no_of_depositors,SUM(attendance_status) AS attendanc
							FROM products JOIN saving_attendance_register ON products.id=saving_attendance_register.product_id			
							WHERE saving_attendance_register.date BETWEEN ? AND ?
							AND attendance_status=1
							GROUP BY products.id,products.mnemonic			
							) AS agv_att
					) tbl3 GROUP BY Product_Id,Gender
				) tbl3_Final GROUP BY Product_Id";
			$sql=$this->db->query($sql, array($current_month_first,$current_month_first,$previous_month_first,$previous_month_last,$current_month_first,$current_month_last,$current_month_first,$current_month_last)); 
			$i=0;
			$member_statement="";
			foreach ($sql->result_array() as $row)
			{
				$i++;			
				$member_statement[$i]['mnemonic']=$row['mnemonic'];
				$member_statement[$i]['previous_male_member_no']=$row['previous_male_member_no'];
				$member_statement[$i]['previous_female_member_no']=$row['previous_female_member_no'];
				$member_statement[$i]['current_male_member_no']=$row['current_male_member_no'];
				$member_statement[$i]['current_female_member_no']=$row['current_female_member_no'];
				$member_statement[$i]['canceled_member_no_male']=$row['canceled_member_no_male'];
				$member_statement[$i]['canceled_member_no_female']=$row['canceled_member_no_female'];
				$member_statement[$i]['avg_depositor']=$row['avg_depositor'];
				$member_statement[$i]['avg_attendanc']=$row['avg_attendanc'];				
			}
		}
		else
		{
			$sql = "SELECT Product_Id AS Product_Id,mnemonic AS mnemonic,C_Status AS C_Status, Gender AS Gender, 
				SUM(IF(Gender='M',last_month_no_of_member,0)) AS previous_male_member_no,
				SUM(IF(Gender='F',last_month_no_of_member,0)) AS previous_female_member_no,
				SUM(IF(Gender='M',current_month_no_of_member,0)) AS current_male_member_no, 
				SUM(IF(Gender='F',current_month_no_of_member,0)) AS current_female_member_no,
				SUM(IF(Gender='M',no_of_cancel_member,0)) AS canceled_member_no_male, 
				SUM(IF(Gender='F',no_of_cancel_member,0)) AS canceled_member_no_female,
				avg_depositor AS avg_depositor,avg_attendanc AS avg_attendanc
				FROM (
					SELECT Product_Id AS Product_Id,mnemonic AS mnemonic,'' AS C_Status, Gender AS Gender, SUM(last_month_no_of_member) AS last_month_no_of_member,
					SUM(current_month_no_of_member) AS current_month_no_of_member, 
					SUM(no_of_cancel_member) AS no_of_cancel_member, avg_depositor AS avg_depositor,avg_attendanc AS avg_attendanc
					FROM (					
						SELECT  products.id AS Product_Id,products.mnemonic, members.Gender AS Gender,COUNT(members.id) AS last_month_no_of_member , 0  AS current_month_no_of_member  , 0 AS no_of_cancel_member , 0 AS avg_depositor,0 AS avg_attendanc 
						FROM products JOIN samities ON products.id=samities.product_id
						JOIN members ON members.samity_id=samities.id
						WHERE samities.branch_id=? AND 
						members.registration_date<? 
						AND members.id NOT IN(SELECT id
						FROM members
						WHERE members.member_status='Inactive'
						AND members.cancel_date>?) 
						GROUP BY products.mnemonic,Gender

						UNION ALL
		
						SELECT  products.id AS Product_Id,products.mnemonic, Gender AS Gender, 0 AS No_Of_Member_End_Last_Month ,
						COUNT(DISTINCT members.id ) AS No_Of_Current_Member , 0 AS No_Of_Cancel_Member , 0 AS avg_depositor,0 AS avg_attendanc 
						FROM products JOIN samities ON products.id=samities.product_id
						JOIN members ON members.samity_id=samities.id		
						WHERE samities.branch_id=?  AND members.member_status ='ACTIVE' 
						AND members.code $member_code AND members.registration_date BETWEEN ? AND ?
						GROUP BY  products.id,Gender
						
						UNION ALL

						SELECT Product_Id,mnemonic,'' AS Gender,0 AS last_month_no_of_member , 0  AS current_month_no_of_member  , 0 AS no_of_cancel_member 
						, (no_of_depositors/date) AS avg_depositor,0 AS avg_attendanc
						FROM 			
							(SELECT products.id AS Product_Id,products.mnemonic,COUNT(day_end_process_savings.date) AS date,
							SUM(day_end_process_savings.no_of_depositors) AS no_of_depositors
							FROM products JOIN day_end_process_savings ON products.id=day_end_process_savings.product_id			
							WHERE day_end_process_savings.branch_id=? AND day_end_process_savings.date BETWEEN ? AND ?
							GROUP BY products.mnemonic,day_end_process_savings.branch_id) AS agv_dep

						UNION ALL
			
						SELECT Product_Id,mnemonic,'' AS Gender,0 AS last_month_no_of_member , 0  AS current_month_no_of_member  , 0 AS no_of_cancel_member ,
						0 AS avg_depositor, (attendanc/DATE) AS avg_attendanc
						FROM (			
							SELECT products.id AS Product_Id,products.mnemonic,COUNT(DISTINCT DATE) AS DATE
							,'' AS no_of_depositors,SUM(attendance_status) AS attendanc
							FROM products JOIN saving_attendance_register ON products.id=saving_attendance_register.product_id			
							WHERE saving_attendance_register.branch_id=? AND saving_attendance_register.date BETWEEN ? AND ?
							AND attendance_status=1
							GROUP BY products.id,products.mnemonic			
							) AS agv_att
					) tbl3 GROUP BY Product_Id,Gender
				) tbl3_Final GROUP BY Product_Id";
			$sql=$this->db->query($sql, array($branch_id,$current_month_first,$current_month_first,$branch_id,$previous_month_first,$previous_month_last,$branch_id,$current_month_first,$current_month_last,$branch_id,$current_month_first,$current_month_last)); 
			$i=0;
			$member_statement="";
			foreach ($sql->result_array() as $row)
			{
				$i++;			
				$member_statement[$i]['mnemonic']=$row['mnemonic'];
				$member_statement[$i]['previous_male_member_no']=$row['previous_male_member_no'];
				$member_statement[$i]['previous_female_member_no']=$row['previous_female_member_no'];
				$member_statement[$i]['current_male_member_no']=$row['current_male_member_no'];
				$member_statement[$i]['current_female_member_no']=$row['current_female_member_no'];
				$member_statement[$i]['canceled_member_no_male']=$row['canceled_member_no_male'];
				$member_statement[$i]['canceled_member_no_female']=$row['canceled_member_no_female'];
				$member_statement[$i]['avg_depositor']=$row['avg_depositor'];
				$member_statement[$i]['avg_attendanc']=$row['avg_attendanc'];				
			}	
		}
		//echo "<pre>";print_r($member_statement);die;
		return $member_statement;	
	}

	//POMIS Report -2 
	function get_loan_information($year=null,$month=null,$branchId=null,$charge=null)
	{		
		//echo "<pre>";
	if($charge == 'No') {
		if($branchId!='-1'){ 
			$loan_statement = "SELECT product_id,sum(opening_borrower_no) as opening_borrower_no,SUM(opening_outstanding_amount) as opening_outstanding_amount,
							TYPE,sum(borrower_no) as borrower_no,SUM(disbursed_amount) as disbursed_amount,
							SUM(principal_recovery_amount) as principal_recoverable_amount,0 as interest_recoverable_amount,
							SUM(fully_paid_borrower_no) as fully_paid_borrower_no,SUM(closing_borrower_no) as closing_borrower_no,SUM(closing_outstanding_amount) as closing_outstanding_amount,
							loan_products.short_name,loan_products.code
							FROM month_end_process_loans
							JOIN loan_products
							ON month_end_process_loans.product_id=loan_products.id
							WHERE branch_id='$branchId' 
							AND YEAR(DATE)='$year' AND MONTH(DATE)='$month' GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";
			}
			else{
				$loan_statement = "SELECT product_id,sum(opening_borrower_no) as opening_borrower_no,SUM(opening_outstanding_amount) as opening_outstanding_amount,
							TYPE,sum(borrower_no) as borrower_no,SUM(disbursed_amount) as disbursed_amount,
							SUM(principal_recovery_amount) as principal_recoverable_amount,0 as interest_recoverable_amount,
							SUM(fully_paid_borrower_no) as fully_paid_borrower_no,SUM(closing_borrower_no) as closing_borrower_no,SUM(closing_outstanding_amount) as closing_outstanding_amount,
							loan_products.short_name,loan_products.code
							FROM month_end_process_loans
							JOIN loan_products
							ON month_end_process_loans.product_id=loan_products.id
							WHERE YEAR(DATE)='$year' AND MONTH(DATE)='$month'  GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";		
								
				}	
		} else {
			if($branchId!='-1'){ 
			$loan_statement = "SELECT product_id,sum(opening_borrower_no) as opening_borrower_no,SUM(opening_outstanding_amount_with_services_charge) as opening_outstanding_amount,
							TYPE,sum(borrower_no) as borrower_no,SUM(disbursed_amount) as disbursed_amount,
							(SUM(principal_recovery_amount)  + SUM(interest_recovery_amount)) as principal_recoverable_amount, 0 as interest_recoverable_amount,
							SUM(fully_paid_borrower_no) as fully_paid_borrower_no,SUM(closing_borrower_no) as closing_borrower_no,SUM(closing_outstanding_amount_with_services_charge) as closing_outstanding_amount,
							loan_products.short_name,loan_products.code
							FROM month_end_process_loans
							JOIN loan_products
							ON month_end_process_loans.product_id=loan_products.id
							WHERE branch_id='$branchId' 
							AND YEAR(DATE)='$year' AND MONTH(DATE)='$month' GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";
			}
			else{
				$loan_statement = "SELECT product_id,sum(opening_borrower_no) as opening_borrower_no,SUM(opening_outstanding_amount_with_services_charge) as opening_outstanding_amount,
							TYPE,sum(borrower_no) as borrower_no,SUM(disbursed_amount) as disbursed_amount,
							(SUM(principal_recovery_amount)  + SUM(interest_recovery_amount)) as principal_recoverable_amount, 0 as interest_recoverable_amount,
							SUM(fully_paid_borrower_no) as fully_paid_borrower_no,SUM(closing_borrower_no) as closing_borrower_no,SUM(closing_outstanding_amount_with_services_charge) as closing_outstanding_amount,
							loan_products.short_name,loan_products.code
							FROM month_end_process_loans
							JOIN loan_products
							ON month_end_process_loans.product_id=loan_products.id
							WHERE YEAR(DATE)='$year' AND MONTH(DATE)='$month'  
							GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";		
								
				}	
		}
		//		echo $loan_statement;			
		$loan_statement_sql=$this->db->query($loan_statement);
        return $loan_statement_sql->result();
		//die();						
	}
	
	function get_loan_due_information($year=null,$month=null,$branchId=null,$charge=null)
	{		
		if($charge == 'No') {
			if($branchId !='-1'){ 
				$loan_due_statement = "SELECT product_id,TYPE,
								sum(opening_due_amount) as opening_due_amount,
								sum(principal_recoverable_amount) as principal_recoverable_amount,0 as interest_recoverable_amount,
								sum(principal_due_amount) as principal_due_amount,0 as interest_due_amount,
							SUM(principal_recovery_amount) as principal_recovery_amount,0 as interest_recovery_amount,
								sum(principal_advance_amount) as principal_advance_amount,0 as interest_advance_amount,							
								loan_products.short_name,loan_products.code
								FROM month_end_process_loans
								JOIN loan_products
								ON month_end_process_loans.product_id=loan_products.id
								WHERE branch_id='$branchId' 
								AND YEAR(DATE)='$year' AND MONTH(DATE)='$month'
							GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";	
			}
			else{
					$loan_due_statement = "SELECT product_id,TYPE,
								sum(opening_due_amount) as opening_due_amount,
								sum(principal_recoverable_amount) as principal_recoverable_amount,0 as interest_recoverable_amount,
								sum(principal_due_amount) as principal_due_amount,0 as interest_due_amount,
							SUM(principal_recovery_amount) as principal_recovery_amount,0 as interest_recovery_amount,
								sum(principal_advance_amount) as principal_advance_amount,0 as interest_advance_amount,								
								loan_products.short_name,loan_products.code
								FROM month_end_process_loans
								JOIN loan_products
								ON month_end_process_loans.product_id=loan_products.id
								WHERE YEAR(DATE)='$year' AND MONTH(DATE)='$month'
							GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";				
				
			}	
		} else {
			if($branchId!='-1'){ 
				$loan_due_statement = "SELECT product_id,TYPE,
								sum(opening_due_amount_with_services_charge) as opening_due_amount,
								(sum(principal_recoverable_amount) + SUM(interest_recoverable_amount) ) as principal_recoverable_amount,0 as interest_recoverable_amount,
								(sum(principal_due_amount) + SUM(interest_due_amount) ) as principal_due_amount,0 as interest_due_amount,
							(SUM(principal_recovery_amount) + SUM(interest_recovery_amount)) as principal_recovery_amount,0 as interest_recovery_amount,
								(sum(principal_advance_amount) + SUM(interest_advance_amount) ) as principal_advance_amount,0 as interest_advance_amount,							
								loan_products.short_name,loan_products.code
								FROM month_end_process_loans
								JOIN loan_products
								ON month_end_process_loans.product_id=loan_products.id
								WHERE branch_id='$branchId' 
								AND YEAR(DATE)='$year' AND MONTH(DATE)='$month'
							GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";	
			}
			else{
					$loan_due_statement = "SELECT product_id,TYPE,
								sum(opening_due_amount_with_services_charge) as opening_due_amount,
								(sum(principal_recoverable_amount) + SUM(interest_recoverable_amount) ) as principal_recoverable_amount,0 as interest_recoverable_amount,
								(sum(principal_due_amount) + SUM(interest_due_amount) ) as principal_due_amount,0 as interest_due_amount,
							(SUM(principal_recovery_amount) + SUM(interest_recovery_amount)) as principal_recovery_amount,0 as interest_recovery_amount,
								(sum(principal_advance_amount) + SUM(interest_advance_amount) ) as principal_advance_amount,0 as interest_advance_amount,							
								loan_products.short_name,loan_products.code
								FROM month_end_process_loans
								JOIN loan_products
								ON month_end_process_loans.product_id=loan_products.id
								WHERE YEAR(DATE)='$year' AND MONTH(DATE)='$month'
							GROUP BY product_id,TYPE,loan_products.short_name,loan_products.code;";				
				
			}
		}
		$loan_due_statement_sql=$this->db->query($loan_due_statement);
        return $loan_due_statement_sql->result();
		//die();						
	}
	
	// Report-3
	//mathing with Report -2 
	function get_over_due_loan_information($year=null,$month=null,$branchId=null,$charge=null)
	{	
		if($charge == 'No') {
			if($branchId!='-1'){ 
				$loan_statement = "SELECT product_id,		
								SUM(opening_outstanding_amount) as opening_outstanding_amount,
								SUM(substandard_outstanding) as substandard_outstanding,
								SUM(substandard_overdue) as substandard_overdue,
								SUM(doubtfull_outstanding) as doubtfull_outstanding,
								SUM(doubtfull_overdue) as doubtfull_overdue,
								SUM(bad_outstanding) as bad_outstanding,
								SUM(bad_overdue) as bad_overdue,
								SUM(no_of_due_loanee) as no_of_due_loanee,
								SUM(saving_balance_of_overdue_loanee) as saving_balance_of_overdue_loanee,
								loan_products.short_name,loan_products.code,
								po_funding_organizations.name AS fundname
								FROM month_end_process_loans
								JOIN loan_products                            
								ON month_end_process_loans.product_id=loan_products.id
								JOIN po_funding_organizations
								ON loan_products.funding_organization_id=po_funding_organizations.id
								WHERE branch_id='$branchId' 
								AND YEAR(DATE)='$year' AND MONTH(DATE)='$month'
								GROUP BY product_id,short_name,code,po_funding_organizations.name";
				}
				else{
					$loan_statement = "SELECT product_id,	
								SUM(opening_outstanding_amount) as opening_outstanding_amount,
								SUM(substandard_outstanding) as substandard_outstanding,
								SUM(substandard_overdue) as substandard_overdue,
								SUM(doubtfull_outstanding) as doubtfull_outstanding,
								SUM(doubtfull_overdue) as doubtfull_overdue,
								SUM(bad_outstanding) as bad_outstanding,
								SUM(bad_overdue) as bad_overdue,
								SUM(no_of_due_loanee) as no_of_due_loanee,
								SUM(saving_balance_of_overdue_loanee) as saving_balance_of_overdue_loanee,
								loan_products.short_name,loan_products.code,
								po_funding_organizations.name AS fundname
								FROM month_end_process_loans
								JOIN loan_products                            
								ON month_end_process_loans.product_id=loan_products.id
								JOIN po_funding_organizations
								ON loan_products.funding_organization_id=po_funding_organizations.id
								WHERE YEAR(DATE)='$year' AND MONTH(DATE)='$month'
								GROUP BY product_id,short_name,code,po_funding_organizations.name";		
									
			}		
		} else {
						if($branchId!='-1'){ 
				$loan_statement = "SELECT product_id,		
								SUM(opening_outstanding_amount_with_services_charge) as opening_outstanding_amount,
								SUM(substandard_outstanding_with_services_charge) as substandard_outstanding,
								SUM(substandard_overdue_with_services_charge) as substandard_overdue,
								SUM(doubtfull_outstanding_with_services_charge) as doubtfull_outstanding,
								SUM(doubtfull_overdue_with_services_charge) as doubtfull_overdue,
								SUM(bad_outstanding_with_services_charge) as bad_outstanding,
								SUM(bad_overdue_with_services_charge) as bad_overdue,
								SUM(no_of_due_loanee) as no_of_due_loanee,
								SUM(saving_balance_of_overdue_loanee) as saving_balance_of_overdue_loanee,
								loan_products.short_name,loan_products.code,
								po_funding_organizations.name AS fundname
								FROM month_end_process_loans
								JOIN loan_products                            
								ON month_end_process_loans.product_id=loan_products.id
								JOIN po_funding_organizations
								ON loan_products.funding_organization_id=po_funding_organizations.id
								WHERE branch_id='$branchId' 
								AND YEAR(DATE)='$year' AND MONTH(DATE)='$month'
								GROUP BY product_id,short_name,code,po_funding_organizations.name";
				}
				else{
					$loan_statement = "SELECT product_id,		
								SUM(opening_outstanding_amount_with_services_charge) as opening_outstanding_amount,
								SUM(substandard_outstanding_with_services_charge) as substandard_outstanding,
								SUM(substandard_overdue_with_services_charge) as substandard_overdue,
								SUM(doubtfull_outstanding_with_services_charge) as doubtfull_outstanding,
								SUM(doubtfull_overdue_with_services_charge) as doubtfull_overdue,
								SUM(bad_outstanding_with_services_charge) as bad_outstanding,
								SUM(bad_overdue_with_services_charge) as bad_overdue,
								SUM(no_of_due_loanee) as no_of_due_loanee,
								SUM(saving_balance_of_overdue_loanee) as saving_balance_of_overdue_loanee,
								loan_products.short_name,loan_products.code,
								po_funding_organizations.name AS fundname
								FROM month_end_process_loans
								JOIN loan_products                            
								ON month_end_process_loans.product_id=loan_products.id
								JOIN po_funding_organizations
								ON loan_products.funding_organization_id=po_funding_organizations.id
								WHERE YEAR(DATE)='$year' AND MONTH(DATE)='$month'
								GROUP BY product_id,short_name,code,po_funding_organizations.name";		
									
			}		
		}		
		$loan_statement_sql=$this->db->query($loan_statement);
        return $loan_statement_sql->result();
		//die();						
	}
	function get_branch_wise_product($branch_id=null,$month=null,$year=null)
	{
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'1'))));		
		$previous_month_first=date("Y-m-d",strtotime("-1 month", strtotime($current_month_first)));	
		$previous_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($previous_month_first))));
		//Product information
		$product_sql = "SELECT lp.id,lp.short_name,lp.code
						FROM loan_products as lp JOIN samities ON lp.id=samities.product_id
						WHERE samities.branch_id=?
						GROUP BY lp.id,lp.short_name,lp.code";
		$product_sql=$this->db->query($product_sql, array($branch_id)); 
		$product=array();		
		foreach ($product_sql->result_array() as $row)
		{			
			$product[$row['id']]=$row['short_name'];					
		}		
		//echo "<pre>";print_r($product);die;
		return $product;
	}
	function get_branch_wise_designation($branch_id=null,$month=null,$year=null)
	{
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'1'))));		
		$previous_month_first=date("Y-m-d",strtotime("-1 month", strtotime($current_month_first)));	
		$previous_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($previous_month_first))));
		//Designation information
		$sql = "SELECT id,short_name AS mnemonic FROM employee_designations ORDER BY report_sorting_order ASC";
		$sql=$this->db->query($sql, array()); 
		$designation=array();
		foreach ($sql->result_array() as $row)
		{						
			$designation[$row['id']]=$row['mnemonic'];	
		}		
		//echo "<pre>";print_r($designation);die;
		return $designation;
	}

	function get_statement_of_staff($branch_id=null,$month=null,$year=null)
	{
		echo "<pre>";
		
		$staffs = array();
		$branch_conditon = "";
		if($branch_id > 1) {
			$branch_conditon = " AND branch_id = $branch_id";
		}
		$samity_branch_conditon = "";
		if($branch_id > 1) {
			$samity_branch_conditon = " AND samities.branch_id = $branch_id";
		}
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'1'))));		
		$previous_month_first=date("Y-m-d",strtotime("-1 month", strtotime($current_month_first)));	
		$previous_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($previous_month_first))));
		//Product information
		$product_sql = "SELECT loan_products.id,loan_products.short_name,loan_products.code
						FROM loan_products JOIN samities ON loan_products.id=samities.product_id
						WHERE 1=1 $branch_conditon
						GROUP BY loan_products.id,loan_products.short_name,loan_products.code";
		$product_sql=$this->db->query($product_sql); 
		$product=array();
		
		foreach ($product_sql->result_array() as $row)
		{			
			$product[$row['id']]['id']=$row['id'];
			$product[$row['id']]['code']=$row['code'];		
			$product[$row['id']]['short_name']=$row['short_name'];	
			$staffs["{$row['short_name']}"]['short_name']=$row['short_name'];			
		}
		//print_r($product);
		//Designation information
		$sql = "SELECT id,short_name AS short_name FROM employee_designations ORDER BY report_sorting_order ASC";
		//echo $sql;
		$sql=$this->db->query($sql, array()); 
		$designation_wise_product=array();
		$designation_list = $sql->result_array();
		$designations = array();
		foreach ($designation_list as $row)
		{
			$designations[$row['id']]['designation_id'] = $row['id'];
			$designations[$row['id']]['short_name'] = $row['short_name'];
		}
		$total_designation_employee = array();	
		foreach ($designation_list as $row)
		{
			foreach ($product as $row1)
			{
				$staffs["{$row1['short_name']}"]["{$designations[$row['id']]['short_name']}"]=0;
				
			}	
			$total_designation_employee["{$designations[$row['id']]['short_name']}"]=0;	
		}
		//print_r($total_designation_employee);
		// Employee Termination
		$q= "SELECT employee_id,effective_date FROM employee_terminations 
		WHERE effective_date <= '$current_month_last'";
		$result=$this->db->query($q); 
		$employee_termination_list = $result->result_array();
		$employee_terminations = array();
		$employee_id_termination_list = array();
		$employee_id_termination_string = "";
		foreach ($employee_termination_list as $row)
		{
			$employee_terminations[$row['employee_id']]['employee_id'] = $row['employee_id'];
			$employee_terminations[$row['employee_id']]['effective_date'] = $row['effective_date'];
			$employee_id_termination_list[] = $row['employee_id'];
		}
		$employee_id_termination_string = join(',',$employee_id_termination_list);
		$employee_id_termination_string = empty($employee_id_termination_string)?"-999":$employee_id_termination_string;
		
		// Employee
		$q = "SELECT id,branch_id,designation_id,date_of_joining,date_of_discontinue FROM employees 
		WHERE date_of_joining <= '$current_month_last' $branch_conditon AND id NOT IN ($employee_id_termination_string);";
		$result=$this->db->query($q); 
		$employee_list = $result->result_array();
		$employees = array();
		$employee_id_list = array();
		$employee_id_string = "";
		foreach ($employee_list as $row)
		{
			$employees[$row['id']]['employee_id'] = $row['id'];
			$employees[$row['id']]['branch_id'] = $row['branch_id'];
			$employees[$row['id']]['designation_id'] = $row['designation_id'];
			$employees[$row['id']]['designation_short_name'] = $designations[$row['designation_id']]['short_name'];
			$employees[$row['id']]['date_of_joining'] = $row['date_of_joining'];
			$employees[$row['id']]['date_of_discontinue'] = $row['date_of_discontinue'];
			$employee_id_list[] = $row['id'];
			//
		}
		$employee_id_string = join(',',$employee_id_list);
		$employee_id_string = empty($employee_id_string)?"-999":$employee_id_string;
		
		// Samity Product with Empoyee list
		$q = "SELECT product_id,field_officer_id FROM samities 
WHERE field_officer_id IN ($employee_id_string) GROUP BY product_id,field_officer_id;";
		$result=$this->db->query($q); 
		$employee_product_list = $result->result_array();
		$employee_products=array();
		foreach ($employee_product_list as $row)
		{
			$employee_products[$row['product_id']][$row['field_officer_id']]['product_id'] = $row['product_id'];
			$employee_products[$row['product_id']][$row['field_officer_id']]['field_officer_id'] = $row['field_officer_id'];
			$employee_products[$row['product_id']][$row['field_officer_id']]['designation_id'] = $employees[$row['field_officer_id']]['designation_id'];
			$employee_products[$row['product_id']][$row['field_officer_id']]['designation_short_name'] = $employees[$row['field_officer_id']]['designation_short_name'];
			
			$employee_products[$row['product_id']][$row['field_officer_id']]['product_short_name'] = isset($product[$row['product_id']]['short_name'])?$product[$row['product_id']]['short_name']:"TEST";
			$staffs["{$employee_products[$row['product_id']][$row['field_officer_id']]['product_short_name']}"]["{$employees[$row['field_officer_id']]['designation_short_name']}"]=0;
			$staffs["{$employee_products[$row['product_id']][$row['field_officer_id']]['product_short_name']}"]["short_name"]=$employee_products[$row['product_id']][$row['field_officer_id']]['product_short_name'];		
			//$product["{$employees[$row['field_officer_id']]['designation_short_name']}"]["{$employee_products[$row['product_id']][$row['field_officer_id']]['product_short_name']}"]=0;	
			//$total_designation_employee["{$employees[$row['field_officer_id']]['designation_short_name']}"] = $row['field_officer_id'];
		}
		//print_r($total_designation_employee);
		foreach ($employee_products as $row)
		{
			foreach ($row as $r)
			{
				if(isset($staffs["{$r['product_short_name']}"]["{$r['designation_short_name']}"])){
					$staffs["{$r['product_short_name']}"]["{$r['designation_short_name']}"] +=1;
				}
			}
		}
		// Total Designation wise employee
		$q = "SELECT field_officer_id FROM samities 
WHERE field_officer_id IN ($employee_id_string) GROUP BY field_officer_id;";
		$result=$this->db->query($q); 
		$employees_ids = $result->result_array();
		foreach ($employees_ids as $row)
		{
			$total_designation_employee["{$employees[$row['field_officer_id']]['designation_short_name']}"] += 1;
		}
		
		//print_r($staffs);
		$data['staffs']= $staffs;
		$data['total_designation_employees']= $total_designation_employee;
		$data['designations']= $designations;
		return $data;
		//print_r($staffs);
		$data['staffs']= $staffs;
		$data['designations']= $designations;
		return $data;
	}
	function get_statement_of_workinarea($branch_id=null,$month=null,$year=null)
	{		
		$branch_conditon = "";
		if($branch_id > 1) {
			$branch_conditon = " AND branch_id = $branch_id";
		}
		$samity_branch_conditon = "";
		if($branch_id > 1) {
			$branch_conditon = " AND samity_branch_conditon.branch_id = $branch_id";
		}
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($current_month_first))));		
		$product_sql = "SELECT loan_products.id,loan_products.short_name as mnemonic
						FROM loan_products JOIN loans ON loan_products.id=loans.product_id
						JOIN samities ON loan_products.id=samities.product_id
						WHERE 1 =1 $samity_branch_conditon
						GROUP BY loan_products.id,loan_products.short_name";
		$product_sql=$this->db->query($product_sql); 
		$statement_of_workingarea=array();
		$i=1;
		$total_ptoduct=1;		
		foreach ($product_sql->result_array() as $row)
		{	
			$product_id=$row['id'];						
			$workingarea_sql = "SELECT  DISTINCT po_village_or_blocks.district_id,po_districts.name as district_name,
							po_village_or_blocks.thana_id,po_thanas.name as thana_name,
							COUNT(DISTINCT po_village_or_blocks.union_or_ward_id) AS union_no,
							COUNT(DISTINCT village_or_block_id) AS village_no
							FROM loan_products JOIN loans ON loan_products.id=loans.product_id
							JOIN samities ON loan_products.id=samities.product_id
							JOIN po_working_areas ON po_working_areas.id=samities.working_area_id
							JOIN po_village_or_blocks ON po_village_or_blocks.id=po_working_areas.village_or_block_id
							JOIN po_districts ON po_districts.id=po_village_or_blocks.district_id
							JOIN po_thanas ON po_thanas.id=po_village_or_blocks.thana_id
							JOIN po_unions_or_wards ON po_unions_or_wards.id=po_village_or_blocks.union_or_ward_id
							WHERE 1 =1 $samity_branch_conditon
							AND samities.opening_date<=?
							AND loans.product_id=?
							GROUP BY po_village_or_blocks.district_id,po_districts.name,
							po_village_or_blocks.thana_id,po_thanas.name";
			$workingarea_sql=$this->db->query($workingarea_sql, array($current_month_last,$product_id));	
			foreach ($workingarea_sql->result_array() as $workingarea_row)
			{
				$f=0;								
				if($i===1)
				{
					$p_product=$row['mnemonic'];
					$f=1;
				}
				else
				{					
					if($p_product!==$row['mnemonic'])
					{
						$p_product=$row['mnemonic'];
						$f=1;
						$total_ptoduct++;
					}
				}
				if($f==1)
				{
					$statement_of_workingarea[$i]['product_mnemonic']=$row['mnemonic'];	
					$statement_of_workingarea[$i]['branch']=1;
					$statement_of_workingarea[$i]['district_name']=$workingarea_row['district_name'];
				}
				else
				{
					$statement_of_workingarea[$i]['product_mnemonic']="";
					$statement_of_workingarea[$i]['branch']="";
					$statement_of_workingarea[$i]['district_name']="";	
				}
				$statement_of_workingarea[$i]['thana_name']=$workingarea_row['thana_name'];
				$statement_of_workingarea[$i]['union_no']=$workingarea_row['union_no'];
				$statement_of_workingarea[$i]['village_no']=$workingarea_row['village_no'];	
				$statement_of_workingarea[$i]['total_ptoduct']=$total_ptoduct;
				$i++;								
			}				
		}
		//echo "<pre>";print_r($product_wise_woringarea);die;
		return $statement_of_workingarea;
	}
	function get_statement_of_total_workinarea($branch_id=null,$month=null,$year=null)
	{
		
		$samity_branch_conditon = "";
		if($branch_id > 1) {
			$samity_branch_conditon = " AND samities.branch_id = $branch_id";
		}
		
		$current_month_first=date("Y-m-d", strtotime($year.'-'.$month.'-'.'1'));
		$current_month_last=date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($current_month_first))));		
		$total_workingarea_sql ="SELECT  COUNT(DISTINCT po_village_or_blocks.district_id) AS total_district,
							COUNT(DISTINCT po_village_or_blocks.thana_id) AS total_thana,
							COUNT(DISTINCT po_village_or_blocks.union_or_ward_id) AS total_union,
							COUNT(DISTINCT village_or_block_id) AS total_village
							FROM loan_products JOIN loans ON loan_products.id=loans.product_id
							JOIN samities ON loan_products.id=samities.product_id
							JOIN po_working_areas ON po_working_areas.id=samities.working_area_id
							JOIN po_village_or_blocks ON po_village_or_blocks.id=po_working_areas.village_or_block_id
							JOIN po_districts ON po_districts.id=po_village_or_blocks.district_id
							JOIN po_thanas ON po_thanas.id=po_village_or_blocks.thana_id
							JOIN po_unions_or_wards ON po_unions_or_wards.id=po_village_or_blocks.union_or_ward_id
							WHERE 1=1 $samity_branch_conditon
							AND samities.opening_date<=?";
				$total_workingarea_sql=$this->db->query($total_workingarea_sql, array($branch_id,$current_month_last));					
				foreach ($total_workingarea_sql->result_array() as $total_workingarea_row)
				{	
					$statement_of_total_workingarea['total_district']=$total_workingarea_row['total_district'];	
					$statement_of_total_workingarea['total_thana']=$total_workingarea_row['total_thana'];	
					$statement_of_total_workingarea['total_union']=$total_workingarea_row['total_union'];	
					$statement_of_total_workingarea['total_village']=$total_workingarea_row['total_village'];	
				}
		//echo "<pre>";print_r($statement_of_total_workingarea);die;
		return $statement_of_total_workingarea;
	}
}
