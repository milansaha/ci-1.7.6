<?php
/** 
	*Savings Refund Day_end_process Model Class.
	* @pupose		Day_end_process Reports
	*		
	* @filesource	./system/application/models/sDay_end_process.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.sDay_end_process
	* @version      $Revision: 1 $
	* @author       $Author: S. Amlan chowdhury $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Process_month_end extends MY_Model {
	var $loan_base_class=null;
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
	function get_list($branch_id,$offset,$limit,$cond)
    {
		$this->db->select('process_month_ends.*,po_branches.name AS branch_name, po_branches.code as branch_code');
		$this->db->order_by("date", "desc");
		//
		$year = (isset($cond['cbo_year']) && !empty($cond['cbo_year']))?$cond['cbo_year']:"";
		if(empty($month)){
			$this->db->where(array('branch_id'=>$branch_id));
		}else{
			$this->db->where(array('branch_id'=>$branch_id,'YEAR(date)'=>$year));
		}
		//
		$this->db->join('po_branches', 'process_month_ends.branch_id = po_branches.id','inner');
        $query = $this->db->get('process_month_ends', $offset, $limit);
        return $query->result();
    }
    
    function row_count($branch_id,$cond)
	{
		//
		$year = (isset($cond['cbo_year']) && !empty($cond['cbo_year']))?$cond['cbo_year']:"";
		if(empty($month)){
			$this->db->where(array('branch_id'=>$branch_id));
		}else{
			$this->db->where(array('branch_id'=>$branch_id,'YEAR(date)'=>$year));
		}
		//
		return $this->db->count_all_results('process_month_ends');
	}
	function delete($branch_id,$date)
	{
		if($this->db->delete('month_end_process_loans', array('branch_id'=> $branch_id,'date'=>$date))){
			if($this->db->delete('month_end_process_members', array('branch_id'=> $branch_id,'date'=>$date))){
				if($this->db->delete('month_end_process_savings', array('branch_id'=> $branch_id,'date'=>$date))){
					if($this->db->delete('process_month_ends', array('branch_id'=> $branch_id,'date'=>$date))){
						return true;
					}
				}
			}
		}
		return false;
	} 
	function get_month_end_max_date($branch_id)
	{
		
		$this->db->select('max(date) as max_date');
		$this->db->where(array('branch_id'=>$branch_id));
		$query = $this->db->get('process_month_ends');
		$date=$query->row();
		return $date->max_date;
	}
	
	
	function get_day_end_valid_deletable_date($branch_id){
		if(!is_numeric($branch_id)) {
			return false;
		}
		
		//check month end is exits
		$query="SELECT MAX(date) as branch_date FROM process_month_ends where branch_id=$branch_id ;";
		//echo $query;
		$query = $this->db->query($query);
		$result = $query->row();
		if(!isset($result->branch_date) && !empty($result->branch_date)){
			return false;
		}
		return $result->branch_date;
	}
	function execute_month_end($branch_id,$data)
	{		
		
		$date = $data['month_end_date'];
		$members = $data['member'];
       //return 1;
		foreach($members as $member){
			$member['date'] = $date;
			$this->db->insert('month_end_process_members', $member);
		}
		$savings = $data['saving'];
		foreach($savings as $saving){
			$saving['date'] = $date;
			$this->db->insert('month_end_process_savings', $saving);
		}
		$loans = $data['loan'];
		//echo "<pre>";
		//print_r($loans);
		foreach($loans as $loan){
			$loan['date'] = $date;
			$this->db->insert('month_end_process_loans', $loan);
		}
		$this->db->insert('process_month_ends', array('branch_id'=>$branch_id,'date'=>$date));
		
		$savings_interests = $data['savings_interest'];
		foreach($savings_interests as $savings_interest){
			$this->db->insert('saving_deposits', $savings_interest);
		}
		//savins interest deposits
		return true;
	}
	
    function execute_savings_interest_process($savings_interests)
	{	
		//return 1;
		foreach($savings_interests as $savings_interest){
			$this->db->insert('saving_deposits', $savings_interest);
		}
		//savins interest deposits
		return true;
	}
	
	
	function get_product_list(){
		$query="SELECT id as product_id, short_name FROM loan_products;";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function get_loan_product_list(){
		$query="SELECT id AS product_id, short_name, loan_product_category_id FROM loan_products ORDER BY loan_product_category_id;";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function get_no_of_branch($branch_id){
		$query="SELECT COUNT(DISTINCT(s.branch_id)) AS no_of_branch,s.product_id  AS product_id 
FROM samities AS s
INNER JOIN loan_products AS lp ON (lp.id = s.product_id)
WHERE s.branch_id = $branch_id GROUP BY s.product_id;";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function get_no_of_samity($branch_id){
		$query="SELECT SUM(no_of_female_samity) AS no_of_female_samity , 
SUM(no_of_male_samity) AS no_of_male_samity, product_id 
FROM (
SELECT 
IF(s.samity_type='F',COUNT(DISTINCT(s.id)),0) AS no_of_female_samity,
IF(s.samity_type='M',COUNT(DISTINCT(s.id)),0) AS no_of_male_samity,
s.product_id AS product_id 
FROM samities AS s
INNER JOIN loan_products AS lp ON (lp.id = s.product_id)
WHERE s.branch_id = $branch_id GROUP BY s.product_id
) t GROUP BY product_id;";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function is_date($date){
		$date_array = explode('-',$date);
		if( !isset($date_array[2]) && empty($date_array[2])) {
			return false;
		}
		return checkdate($date_array[1],$date_array[2],$date_array[0]);
	}
	function get_member_list($from_date,$to_date=null,$branch_id=null,$group_by='primary_product_id',$member_status='Active'){
    	
		if(!$this->is_date($from_date)) {
			return false;
		}
		if(!empty($to_date)){
			if($this->is_date($to_date)) {
				$this->db->where(" registration_date", $to_date);
			} else {
					return false;
			}
		}
		if(is_numeric($branch_id)){
			$this->db->where("branch_id", $branch_id);
		}
		if(!empty($member_status)){
			$this->db->where("member_status", $member_status);
		}
		if(!empty($group_by)){
			$this->db->group_by("$group_by");
		}
		$this->db->where("registration_date <=", $from_date);
		$this->db->select("id,primary_product_id,samity_id,gender,member_status,registration_date,cancel_date");
		$this->db->from("members");
		$members =  $this->db->get(); 
		$results = $members->result_array();
		//ECHO 	'<pre>';
		//print_r($results);
		return $results;  
	}
	function get_active_member($array,$clean_key) {
	    foreach($array as $key => $value) {
			if($array[$key]["$clean_key"] == 'Inactive') {
	            unset($array[$key]);
	        }
	    }
	    return $array;
	} 
	function get_inactive_member($array,$clean_key) {	
		$member_list = array();
	    foreach($array as $key => $value) {
			if($array[$key]["$clean_key"] == 'Inactive') {
	            $member_list[$key] = $array[$key];
	        }
	    }
	    return $member_list;
	} 
	function between_date_range_member($array,$clean_key,$from_date,$to_date=null) {
		$from_date = strtotime($from_date);
		$to_date = strtotime($to_date);
		$member_list = array();
	    foreach($array as $key => $value) {
			if(!empty($array[$key]["$clean_key"]) && $this->is_date($array[$key]["$clean_key"])) {
	    		$tmp_chack_date = strtotime($array[$key]["$clean_key"]);
	    		if(empty($to_date)){
					//echo $tmp_chack_date." == $from_date <br>";
					if($tmp_chack_date < $from_date){
						$member_list[$key] = $array[$key];
					}  				
				}
				else{
					if($tmp_chack_date >= $from_date && $tmp_chack_date <= $to_date){
						$member_list[$key] = $array[$key];
					}  
				}         
	        }
	    }
	    return $member_list;
	}
	function group_by($members,$products ){
		//print_r($members);
		$product_member  = array();
		foreach($products as $product_key => $product_value) {
			$product_member[$product_key]['F'] = 0;
			$product_member[$product_key]['M'] = 0;
			$product_member[$product_key]['product_id'] ='';
			foreach($members as $member_key => $member_key) {
				if($members[$member_key]['primary_product_id'] == $product_key){
					if($members[$member_key]['gender'] == 'F'){
						$product_member[$product_key]['F'] += 1;
					}else{
						$product_member[$product_key]['M'] += 1;
					}
					$product_member[$product_key]['product_id']=$product_key;
					unset($members[$member_key]);
				}
			}	
		}
		 return $product_member;
	}


	function get_withdraw_information($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND sw.transaction_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND sw.transaction_date < '$date_from'";
		}
				
		$query="SELECT SUM(IF(gender = 'F',withdraws_amount,0)) AS female_withdraws_amount
,SUM(IF(gender = 'M',withdraws_amount,0)) AS male_withdraws_amount, product_id as product_id FROM (

SELECT SUM(sw.amount) AS withdraws_amount , m.gender AS gender,lp.id as product_id
FROM saving_withdraws AS sw
INNER JOIN members AS m ON (m.id = sw.member_id) 
INNER JOIN loan_products AS lp ON (lp.id = sw.member_primary_product_id)
WHERE sw.branch_id = $branch_id AND m.branch_id = $branch_id $date_condition
GROUP BY lp.id, m.gender
) t GROUP BY product_id,gender;";
//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_deposit_information($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND sd.transaction_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND sd.transaction_date < '$date_from'";
		}
				
		$query="SELECT SUM(IF(gender = 'F',withdraws_amount,0)) AS female_withdraws_amount
,SUM(IF(gender = 'M',withdraws_amount,0)) AS male_withdraws_amount, product_id as product_id FROM (

SELECT SUM(sd.amount) AS withdraws_amount , m.gender AS gender,lp.id as product_id
FROM saving_deposits AS sd
INNER JOIN members AS m ON (m.id = sd.member_id)

INNER JOIN loan_products AS lp ON (lp.id = sd.member_primary_product_id)
WHERE sd.branch_id = $branch_id AND m.branch_id = $branch_id  $date_condition
GROUP BY lp.id, m.gender
) t GROUP BY product_id,gender;";
//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_loan_disburse_information($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND l.disburse_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND l.disburse_date < '$date_from'";
		}	
		$query="SELECT SUM(IF(gender = 'F',disbursed_amount,0)) AS female_disbursed_amount
,SUM(IF(gender = 'M',disbursed_amount,0)) AS male_disbursed_amount
,SUM(IF(gender = 'F',borrower_no,0)) AS female_borrower_no
,SUM(IF(gender = 'M',borrower_no,0)) AS male_borrower_no
,product_id
FROM (
SELECT
SUM(l.loan_amount) AS disbursed_amount
,COUNT(DISTINCT(l.member_id)) AS borrower_no
, lp.id AS  product_id ,m.gender
FROM loans AS l
INNER JOIN members AS m ON (m.id = l.member_id)
INNER JOIN loan_products AS lp ON (lp.id = l.product_id)
WHERE l.branch_id = $branch_id $date_condition 
GROUP BY lp.id,m.gender
) t GROUP BY product_id,gender;";

		$query = $this->db->query($query);
		return $query->result_array();
	}

	function get_loan_recovery_information($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND lt.transaction_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND lt.transaction_date < '$date_from'";
		}	
		$query="SELECT 
SUM(IF(gender = 'F', recovery_amount,0)) AS female_recovery_amount ,
SUM(IF(gender = 'M', recovery_amount,0)) AS male_recovery_amount ,
SUM(IF(gender = 'F', interest_recovery_amount,0)) AS female_interest_recovery_amount ,
SUM(IF(gender = 'M', interest_recovery_amount,0)) AS male_interest_recovery_amount 
, product_id
FROM (
SELECT SUM(lt.transaction_principal_amount) AS recovery_amount
,SUM(lt.transaction_interest_amount) AS interest_recovery_amount
, lp.id AS  product_id ,m.gender
FROM loan_transactions AS lt
INNER JOIN loans AS l ON (l.id = lt.loan_id)
INNER JOIN members AS m ON (m.id = l.member_id)
INNER JOIN loan_products AS lp ON (lp.id = l.product_id)
WHERE lt.branch_id = $branch_id $date_condition
GROUP BY lp.id,m.gender
) t GROUP BY product_id,gender;";

		$query = $this->db->query($query);
		return $query->result_array();
	}

	function get_loan_fully_paid_borrower($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND l.loan_fully_paid_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND l.loan_fully_paid_date < '$date_from'";
		}	
		$query="SELECT 
SUM(IF(gender = 'F', fully_paid_borrower,0)) AS female_fully_paid_borrower ,
SUM(IF(gender = 'M', fully_paid_borrower,0)) AS male_fully_paid_borrower , product_id
FROM (
SELECT COUNT(DISTINCT(l.member_id)) AS fully_paid_borrower
,lp.id AS product_id,m.gender
FROM loans AS l
INNER JOIN members AS m ON (m.id = l.member_id)
INNER JOIN loan_products AS lp ON (lp.id = l.product_id)
WHERE l.is_loan_fully_paid = 1 AND l.branch_id = $branch_id $date_condition
GROUP BY lp.id,m.gender
) t GROUP BY product_id,gender;";

		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_loan_recoverable_amount($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND ls.schedule_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND ls.schedule_date < '$date_from'";
		}	
		$query="SELECT 
SUM(IF(gender = 'F',principal_recoverable_amount,0)) AS female_principal_recoverable_amount 
,SUM(IF(gender = 'M',principal_recoverable_amount,0)) AS male_principal_recoverable_amount 
,SUM(IF(gender = 'F',interest_recoverable_amount,0)) AS female_interest_recoverable_amount 
,SUM(IF(gender = 'M',interest_recoverable_amount,0)) AS male_interest_recoverable_amount ,product_id 
FROM ( 
SELECT 
SUM(ls.principal_installment_amount) AS principal_recoverable_amount,
SUM(ls.interest_installment_amount) AS interest_recoverable_amount,
lp.id AS product_id,ls.branch_id,m.gender
FROM loans AS l
INNER JOIN loan_schedules AS ls ON (ls.loan_id = l.id)
INNER JOIN members AS m ON (m.id = l.member_id)
INNER JOIN loan_products AS lp ON (lp.id = l.product_id)
WHERE ls.branch_id = $branch_id $date_condition
GROUP BY lp.id,m.gender
) t
GROUP BY product_id,gender;";

		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_loan_advance_collection_amount($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND la.transaction_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND la.transaction_date < '$date_from'";
		}	
		$query="SELECT 
SUM(IF(gender = 'F',principal_advance_amount,0)) AS female_principal_advance_amount 
,SUM(IF(gender = 'M',principal_advance_amount,0)) AS male_principal_advance_amount 
,SUM(IF(gender = 'F',interest_advance_amount,0)) AS female_interest_advance_amount 
,SUM(IF(gender = 'M',interest_advance_amount,0)) AS male_interest_advance_amount ,product_id 
FROM ( 
SELECT 
SUM(la.principal_collection_amount) AS principal_advance_amount,
SUM(la.interest_collection_amount) AS interest_advance_amount,
lp.id AS product_id,m.gender
FROM loans AS l
INNER JOIN loan_advance_collection_register AS la ON (la.loan_id = l.id)
INNER JOIN members AS m ON (m.id = l.member_id)
INNER JOIN loan_products AS lp ON (lp.id = la.product_id)
WHERE la.branch_id = $branch_id $date_condition
GROUP BY lp.id,m.gender
) t
GROUP BY product_id,gender;";

		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_loan_due_collection_amount($branch_id,$date_from,$date_to=null){
		$date_condition = "";
		if($this->is_date($date_to)){
			$date_condition = " AND ld.transaction_date BETWEEN '$date_from' AND  '$date_to' ";
		} else {
			$date_condition = " AND ld.transaction_date < '$date_from'";
		}	
		$query="SELECT 
SUM(IF(gender = 'F',principal_due_amount,0)) AS female_principal_due_amount 
,SUM(IF(gender = 'M',principal_due_amount,0)) AS male_principal_due_amount 
,SUM(IF(gender = 'F',interest_due_amount,0)) AS female_interest_due_amount 
,SUM(IF(gender = 'M',interest_due_amount,0)) AS male_interest_due_amount ,product_id 
FROM ( 
SELECT 
SUM(ld.principal_collection_amount) AS principal_due_amount,
SUM(ld.interest_collection_amount) AS interest_due_amount,
lp.id AS product_id,m.gender
FROM loans AS l
INNER JOIN loan_due_collection_register AS ld ON (ld.loan_id = l.id)
INNER JOIN members AS m ON (m.id = l.member_id)
INNER JOIN loan_products AS lp ON (lp.id = ld.product_id)
WHERE ld.branch_id = $branch_id $date_condition
GROUP BY lp.id,m.gender
) t
GROUP BY product_id,gender;";

		$query = $this->db->query($query);
		return $query->result_array();
	}
    
    function get_month_end_membrs_info($branch_id,$date){
        
		$query="SELECT product_id,closing_member,type
FROM month_end_process_members
WHERE branch_id = $branch_id AND date = '$date';";

		$query = $this->db->query($query);
		return $query->result_array();
	}
    
    function get_month_end_savings_info($branch_id,$date){
        
		$query="SELECT product_id,closing_balance,type
FROM month_end_process_savings 
WHERE branch_id = $branch_id AND date = '$date';";

		$query = $this->db->query($query);
		return $query->result_array();
	}
    
    function get_month_end_loans_info($branch_id,$date){
        
		$query="SELECT product_id,closing_borrower_no,closing_outstanding_amount,closing_due_amount,type
FROM month_end_process_loans 
WHERE branch_id = $branch_id AND date = '$date';";

		$query = $this->db->query($query);
		return $query->result_array();
	}
	/**
 * Anis
 * 26-March-2011 
 */
	function get_loan_report_data($member_list,$date,$branch_id= null,$product_id=null)
	{
		if(empty($member_list) || empty($date) || !is_numeric($branch_id)) {
			return false;
		}		
		$active_member_loan_info = $this->loan_base_class->get_member_loan_info($member_list,$date,$branch_id,$product_id);
		$loan_members = array();
		foreach($active_member_loan_info as $active_member_loan){
				//print_r($active_member_loan);	
				$loan_members[] = $active_member_loan['member_id'];
		}
		//print_r($loan_members);
		$active_member_loan_schedule_info =$this->loan_base_class->get_active_member_loan_schedule_info($loan_members,$date,$branch_id,$product_id); 
		//echo "<pre>";
		//print_r($active_member_loan_info);
			$loan_over_due['substandard_outstanding']=0;
			$loan_over_due['substandard_outstanding_with_services_charge']=0;
			$loan_over_due['substandard_overdue']=0;
			$loan_over_due['substandard_overdue_with_services_charge']=0;
			$loan_over_due['doubtfull_outstanding']=0;
			$loan_over_due['doubtfull_outstanding_with_services_charge']=0;
			$loan_over_due['doubtfull_overdue']=0;
			$loan_over_due['doubtfull_overdue_with_services_charge']=0;
			$loan_over_due['bad_outstanding']=0;
			$loan_over_due['bad_outstanding_with_services_charge']=0;
			$loan_over_due['bad_overdue']=0;
			$loan_over_due['bad_overdue_with_services_charge']=0;
			$loan_over_due['no_of_due_loanee']=0;
			$loan_over_due['saving_balance_of_overdue_loanee']=0;
			$due_loanee_members = '';
		foreach($active_member_loan_info as $active_member_loan){
	
			//$active_member_loan_info[$active_member_loan['member_id']]['last_repayment_date'] = isset($active_member_loan_schedule_info[$active_member_loan['member_id']]['last_repayment_date'])?$active_member_loan_schedule_info[$active_member_loan['member_id']]['last_repayment_date']:"";
			$installment_number = isset($active_member_loan_schedule_info[$active_member_loan['member_id']]['installment_number'])?$active_member_loan_schedule_info[$active_member_loan['member_id']]['installment_number']:0;
			
			$principal_installment_amount = isset($active_member_loan_schedule_info[$active_member_loan['member_id']]['principle_installment_amount'])?$active_member_loan_schedule_info[$active_member_loan['member_id']]['principle_installment_amount']:0;
			
			$interest_installment_amount = isset($active_member_loan_schedule_info[$active_member_loan['member_id']]['interrest_installment_amount'])?$active_member_loan_schedule_info[$active_member_loan['member_id']]['interrest_installment_amount']:0;
			
			$principal_schedule_payable_amount=$installment_number*$principal_installment_amount;
			$installment_schedule_payable_amount=$installment_number*$interest_installment_amount;
			
			//$last_installment_number = isset($active_member_loan_schedule_info[$active_member_loan['member_id']]['last_installment_number'])?$active_member_loan_schedule_info[$active_member_loan['member_id']]['last_installment_number']:0;
			$last_installment_number = $installment_number;
			//$total_payable_amount = $active_member_loan_info[$active_member_loan['member_id']]['total_payable_amount'];	
			$max_transaction_installment_number = $active_member_loan_info[$active_member_loan['member_id']]['max_transaction_installment_number'];	
			$max_transaction_date = $active_member_loan_info[$active_member_loan['member_id']]['max_transaction_date'];	
			
			$total_transaction_principal_amount = $active_member_loan_info[$active_member_loan['member_id']]['total_transaction_principal_amount'];	
			$total_transaction_interest_amount = $active_member_loan_info[$active_member_loan['member_id']]['max_transaction_date'];	
			
			//echo " $max_transaction_installment_number --  $principal_schedule_payable_amount $installment_schedule_payable_amount <br>";
			
			//$installment_loan_amount = $total_payable_amount - $principal_schedule_payable_amount;
			$principal_outstanding = $principal_schedule_payable_amount -  $total_transaction_principal_amount;
			$installment_outstanding=  $installment_schedule_payable_amount - $total_transaction_interest_amount;	
			
			$month_principal_due= $max_transaction_installment_number * $principal_installment_amount  - $total_transaction_principal_amount;		
			$month_installment_due=  $max_transaction_installment_number * $interest_installment_amount   -  $total_transaction_interest_amount;	
			// Substandard outstanding
			//mysql_to_unix
			$last_repay_date = isset($active_member_loan_schedule_info[$active_member_loan['member_id']]['last_repayment_date'])?$active_member_loan_schedule_info[$active_member_loan['member_id']]['last_repayment_date']:"";
			
			$date_diff = strtotime($date) - strtotime($last_repay_date);
			//TODO
			$date_diff = floor($date_diff/(60*60*24));
			//echo " $date_diff  $date  $last_repay_date <br>";
		
			if(($date_diff > 0 && $date_diff <= 180)&& ( $month_principal_due + $month_installment_due) > 0  ) {	
				$loan_over_due['substandard_outstanding'] += $principal_outstanding;
				$loan_over_due['substandard_outstanding_with_services_charge'] += $installment_outstanding;
				
				$loan_over_due['substandard_overdue'] += $month_principal_due;
				$loan_over_due['substandard_overdue_with_services_charge'] += $month_installment_due;
				
				$loan_over_due['no_of_due_loanee']++;
				
				$due_loanee_members .= $active_member_loan['member_id'].',';
			}
			
			else if(($date_diff > 180 && $date_diff <= 365)&& ( $month_principal_due + $month_installment_due) > 0  ) {

				$loan_over_due['doubtfull_outstanding'] += $principal_outstanding;
				$loan_over_due['substandard_outstanding_with_services_charge'] += $installment_outstanding;
				
				$loan_over_due['doubtfull_overdue'] += $month_principal_due;
				$loan_over_due['doubtfull_overdue_with_services_charge'] += $month_installment_due;
				$loan_over_due['no_of_due_loanee']++;
				$due_loanee_members .= $active_member_loan['member_id'].',';
			}
			
			else if(($date_diff > 365)&& ( $month_principal_due + $month_installment_due) > 0   ) {
				$loan_over_due['bad_outstanding'] += $principal_outstanding;
				$loan_over_due['substandard_outstanding_with_services_charge'] += $installment_outstanding;
				
				$loan_over_due['bad_overdue'] += $month_principal_due;
				$loan_over_due['bad_overdue_with_services_charge'] += $month_installment_due;
				$loan_over_due['no_of_due_loanee']++;
				$due_loanee_members .= $active_member_loan['member_id'].',';
			}
			
		
		}
		// remove last ,
	$due_loanee_members = 	substr($due_loanee_members,0, -1);
	$withdraw_amount = 0;
	$deposit_amount = 0;
	if(!empty($due_loanee_members)) {
		$q = "SELECT SUM(amount) as withdraw_amount
FROM saving_withdraws WHERE member_id IN ($due_loanee_members) AND member_primary_product_id = $product_id AND transaction_date <= '$date' ";
		$query=$this->db->query($q); 
$withdraw_amount=$query->row()->withdraw_amount;
	}
	if(!empty($due_loanee_members)) {
		$q = "SELECT SUM(amount) as deposit_amount
FROM saving_deposits WHERE member_id IN ($due_loanee_members) AND member_primary_product_id = $product_id AND transaction_date <= '$date' ";
		$query=$this->db->query($q); 
		$deposit_amount=$query->row()->deposit_amount;
	}
	$loan_over_due['saving_balance_of_overdue_loanee'] = $deposit_amount - $withdraw_amount;	
//	echo "$withdraw_amount  --- $deposit_amount ";
	//print_r($loan_over_due);
	//	die;
//		
		return $loan_over_due;			
	}
	
	function get_day_end_last_date($branch_id)
	{		
		$this->db->select('max(date) as max_date');
		$this->db->where(array('branch_id'=>$branch_id));
		$query = $this->db->get('process_day_ends');
		$date=$query->row();
		$last_day_end_date = isset($date->max_date)?$date->max_date:"";
		return $last_day_end_date;
	}
	
	function get_savings_general_config(){
		$this->db->select('financial_year_start_month,savings_balance_used_for_interest_calculation,savings_minimum_balance_required_for_interest_calculation,
savings_minimum_account_duration_to_receive_interest,savings_is_inactive_member_eligible_to_receive_interest,
savings_frequency_of_interest_posting_to_accounts,savings_interest_calculation_closing_month,savings_interest_disbursment_month');
		$query = $this->db->get('config_general');
		return $query->row_array(1);;
	}
	
	function get_savings_interest_eligible_list($branch_id,$savings_minimum_date_to_receive_interest){
		$q = "SELECT s.id AS savings_id,s.branch_id ,s.samity_id,s.member_id
		,s.opening_date,s.saving_products_id, m.primary_product_id
FROM savings AS s
INNER JOIN members AS m ON (m.id = s.member_id)
WHERE s.branch_id = $branch_id 
AND s.current_status = 1 AND s.opening_date < '$savings_minimum_date_to_receive_interest' ;";
		//echo $q;
		$query=$this->db->query($q); 
		return $query->result_array();
	}
	function get_savings_product_list(){
		$q = "SELECT id AS saving_product_id,interest_rate FROM saving_products;";
		$query=$this->db->query($q); 
		return $query->result_array();
	}
	
	
	function get_saving_refunds_by_eligible_members($branch_id,$to_date,$savings_interest_eligible_members_savings_id_str){
		$savings_interest_eligible_members_savings_id_str = (empty($savings_interest_eligible_members_savings_id_str))?"-111":$savings_interest_eligible_members_savings_id_str;
		
		$q = "SELECT SUM(amount) AS refund_amount ,savings_id
FROM saving_withdraws 
WHERE branch_id = $branch_id AND is_authorized = 1 AND transaction_date <= '$to_date' AND savings_id IN ($savings_interest_eligible_members_savings_id_str)
GROUP BY savings_id;";
		//echo $q;
		$query=$this->db->query($q); 
		return $query->result_array();
	}
	
	function get_saving_deposit_by_eligible_members($branch_id,$to_date,$savings_interest_eligible_members_savings_id_str){
		$savings_interest_eligible_members_savings_id_str = (empty($savings_interest_eligible_members_savings_id_str))?"-111":$savings_interest_eligible_members_savings_id_str;
		
		$q = "SELECT SUM(amount) AS deposit_amount ,savings_id
FROM saving_deposits 
WHERE branch_id = $branch_id AND is_authorized = 1 AND transaction_date <= '$to_date' AND savings_id IN ($savings_interest_eligible_members_savings_id_str)
GROUP BY savings_id;";
		//echo $q;
		$query=$this->db->query($q); 
		return $query->result_array();
	}
	 
}
