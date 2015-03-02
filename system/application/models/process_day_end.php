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
class Process_day_end extends MY_Model {
	var $loan_base_class=null;
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($branch_id,$offset,$limit,$cond)
    {
		$this->db->select('process_day_ends.*,po_branches.name AS branch_name, po_branches.code as branch_code');
		$this->db->order_by("date", "desc");
		//
		$month = (isset($cond['cbo_month']) && !empty($cond['cbo_month']))?$cond['cbo_month']:"";
		$year = (isset($cond['cbo_year']) && !empty($cond['cbo_year']))?$cond['cbo_year']:"";
		if(empty($month) && empty($month)){
			$this->db->where(array('branch_id'=>$branch_id));
		}elseif(empty($month)){
			$this->db->where(array('branch_id'=>$branch_id,'YEAR(date)'=>$year));
		}elseif(empty($year)){
			$this->db->where(array('branch_id'=>$branch_id,'MONTH(date)'=>$month));
		}else {
			$this->db->where(array('branch_id'=>$branch_id,'YEAR(date)'=>$year,'MONTH(date)'=>$month));
		}
		//
		$this->db->join('po_branches', 'process_day_ends.branch_id = po_branches.id','inner');
        $query = $this->db->get('process_day_ends', $offset, $limit);
        return $query->result();
    }
    function execute_day_end($data)
	{	
		return $this->db->insert('process_day_ends', $data);
	}
    function row_count($branch_id,$cond)
	{
		//print_r($cond);
		$month = (isset($cond['cbo_month']) && !empty($cond['cbo_month']))?$cond['cbo_month']:"";
		$year = (isset($cond['cbo_year']) && !empty($cond['cbo_year']))?$cond['cbo_year']:"";
		if(empty($month) && empty($month)){
			$this->db->where(array('branch_id'=>$branch_id));
		}elseif(empty($month)){
			$this->db->where(array('branch_id'=>$branch_id,'YEAR(date)'=>$year));
		}elseif(empty($year)){
			$this->db->where(array('branch_id'=>$branch_id,'MONTH(date)'=>$month));
		}else {
			$this->db->where(array('branch_id'=>$branch_id,'YEAR(date)'=>$year,'MONTH(date)'=>$month));
		}
		
		return $this->db->count_all_results('process_day_ends');
	}
	function delete($branch_id,$date)
	{
		return $this->db->delete('process_day_ends', array('branch_id'=> $branch_id,'date'=>$date));
	} 
	function get_branch_opening_date($branch_id)
	{
		$this->db->select('opening_date');
		$this->db->where(array('id'=>$branch_id));
		$query = $this->db->get('po_branches');
		return isset($query->row(1)->opening_date)?$query->row(1)->opening_date:"";
	}

	function get_software_start_date()
	{
		$query="SELECT sw_start_date_of_operation FROM config_general LIMIT 1";
		$query = $this->db->query($query);
		$result = $query->row();
		$sw_start_date_of_operation = isset($result->sw_start_date_of_operation)?$result->sw_start_date_of_operation:"";
		
		
		
		return $sw_start_date_of_operation;
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
	/**
	 * get_current_date() method
	 * Created by: Saroj Roy
	 * Purpose: get the current working date of the working branch
	 */
	function get_software_current_date($branch_id){		
		$query="SELECT max(date) as branch_date FROM process_day_ends where branch_id=$branch_id";
		$query = $this->db->query($query);
		$result = $query->row();
		if(isset($result->branch_date)){
			$new_day_end_date=$this->get_new_day_end_date($result->branch_date,$branch_id);
		}else {
			$sw_start_date_of_operation = $this->get_software_start_date();
			$branch_opening_date = $this->get_branch_opening_date($branch_id);
			$date_diff = strtotime($sw_start_date_of_operation) - strtotime($branch_opening_date);
			$new_day_end_date = ($date_diff > 0)?$sw_start_date_of_operation:$branch_opening_date;
		}
		
		$branch_date = isset($new_day_end_date)?$new_day_end_date:"";
		return $branch_date;
	}
	function get_new_day_end_date($last_day_end_date,$branch_id)
	{	
		$is_holiday = true;
		for($i=1;$is_holiday;$i++){			
			$new_day_end_date=date('Y-m-d',strtotime($last_day_end_date." + $i day"));
			$is_holiday = $this->check_is_holiday($new_day_end_date,$branch_id);
		}
		return $new_day_end_date;
	}
	function get_day_end_valid_deletable_date($branch_id){
		if(!is_numeric($branch_id)) {
			return false;
		}
		$query="SELECT MAX(date) as branch_date FROM process_day_ends where branch_id=$branch_id";
		$query = $this->db->query($query);
		$result = $query->row();
		if(!isset($result->branch_date) && !empty($result->branch_date)){
			return false;
		}
		$last_day_end_date = $result->branch_date;
		//check month end is exits
		$query="SELECT MAX(date) as branch_date FROM process_month_ends where branch_id=$branch_id and MONTH(date) = MONTH('$last_day_end_date') and YEAR(date) = YEAR('$last_day_end_date') ;";
		$query = $this->db->query($query);
		$result = $query->row();
		if(!isset($result->branch_date) && !empty($result->branch_date)){
			return false;
		}
		return $last_day_end_date;
	}
	function check_loan_information($error,$members,$new_day_end_date)
	{		
		//echo "<pre>";
		if(empty($members)) {
			return $error;
		}		
		//Loan
		$loan_list = $this->get_loan_list($members,$new_day_end_date);
		$loans = "";
		$loan_id_list = array();
		foreach($loan_list as $loan){
			$loans .=$loan['id'].',';
			$loan_id_list[] = $loan['id'];
		}
		$total_loan_id = count($loan_id_list);
		$loans = 	substr($loans,0, -1);
		//print_r($members);
		//
		//Loan Transactions
		$loan_transaction_list = $this->get_loan_transaction_list($loans,$new_day_end_date);
		$loan_id_list_in_transaction = array();
		$transaction_id_list = array();
		$transactions = "";
		foreach($loan_transaction_list as $loan_transaction){
			$transactions .=$loan_transaction['id'].',';
			$loan_id_list_in_transaction[] = $loan_transaction['loan_id'];
			$transaction_id_list[] = $loan_transaction['id'];
		}
						
		$total_loan_id_in_transaction = count($loan_id_list_in_transaction);
		
		$pending_laon_transaction_list = array_diff($loan_id_list, $loan_id_list_in_transaction);
		if(!empty($pending_laon_transaction_list)) {
			$error['loan']['pending_laon_list']=$pending_laon_transaction_list;
			return $error;
		}
		
		$transactions = 	substr($transactions,0, -1);
		//
		//Loan Transactions authorization check
		$authorized_loan_transaction_list = $this->get_loan_transaction_list_is_authorized($transactions);
		$authorized_loan_id_list_in_transaction = array();
		$authorized_transaction_id_list = array();
		$authorized_transactions = "";
		foreach($authorized_loan_transaction_list as $authorized_loan_transaction){
			$authorized_transactions .=$authorized_loan_transaction['id'].',';
			$authorized_loan_id_list_in_transaction[] = $authorized_loan_transaction['loan_id'];
			$authorized_transaction_id_list[] = $authorized_loan_transaction['id'];
		}
						
		$total_authorized_loan_id_in_transaction = count($authorized_loan_id_list_in_transaction);
		
		$pending_authorized_laon_transaction_list = array_diff($loan_id_list_in_transaction, $authorized_loan_id_list_in_transaction);
		if(!empty($pending_authorized_laon_transaction_list)) {
				$error['loan']['pending_authorized_laon_transaction_list']=$pending_authorized_laon_transaction_list;
			return $error;
		}
		//echo "$total_loan_id == $total_loan_id_in_transaction <br>";
		return $error;
	}
	function check_saving_information($error,$members,$new_day_end_date)
	{		
		//echo "<pre>";
		if(empty($members)) {
			return $error;
		}		
		//Saving
		$saving_list = $this->get_saving_list($members,$new_day_end_date);
		$savings = "";
		$saving_id_list = array();
		foreach($saving_list as $saving){
			$savings .=$saving['id'].',';
			$saving_id_list[] = $saving['id'];
		}
		$total_saving_id = count($saving_id_list);
		$savings = 	substr($savings,0, -1);
		//
		//Saving Transactions
		$saving_transaction_list = $this->get_saving_transaction_list($savings,$new_day_end_date);
		$saving_id_list_in_transaction = array();
		$transaction_id_list = array();
		$transactions = "";
		foreach($saving_transaction_list as $saving_transaction){
			$transactions .=$saving_transaction['id'].',';
			$saving_id_list_in_transaction[] = $saving_transaction['savings_id'];
			$transaction_id_list[] = $saving_transaction['id'];
		}
						
		$total_saving_id_in_transaction = count($saving_id_list_in_transaction);
		
		$pending_saving_transaction_list = array_diff($saving_id_list, $saving_id_list_in_transaction);
		if(!empty($pending_saving_transaction_list)) {
			$error['saving']['pending_saving_list']=$pending_saving_transaction_list;
			return $error;
		}
		
		$transactions = 	substr($transactions,0, -1);
		//
		//Saving Transactions authorization check
		$authorized_saving_transaction_list = $this->get_saving_transaction_list_is_authorized($transactions);
		$authorized_saving_id_list_in_transaction = array();
		$authorized_transaction_id_list = array();
		$authorized_transactions = "";
		foreach($authorized_saving_transaction_list as $authorized_saving_transaction){
			$authorized_transactions .=$authorized_saving_transaction['id'].',';
			$authorized_saving_id_list_in_transaction[] = $authorized_saving_transaction['savings_id'];
			$authorized_transaction_id_list[] = $authorized_saving_transaction['id'];
		}
						
		$total_authorized_saving_id_in_transaction = count($authorized_saving_id_list_in_transaction);
		
		$pending_authorized_saving_transaction_list = array_diff($saving_id_list_in_transaction, $authorized_saving_id_list_in_transaction);
		if(!empty($pending_authorized_saving_transaction_list)) {
				$error['saving']['pending_authorized_saving_transaction_list']=$pending_authorized_saving_transaction_list;
			return $error;
		}
		//echo "$total_saving_id == $total_saving_id_in_transaction <br>";
		return $error;
	}
	function check_skt_saving_information($error,$members,$new_day_end_date)
	{		
		//echo "<pre>";
		if(empty($members)) {
			return $error;
		}
		$skt_member_id_list = explode(',',$members);	
		//print_r($skt_member_list);
		$total_skt_member_id = count($skt_member_id_list);
		//
		//SKT Saving Transactions
		$skt_member_transaction_list = $this->get_skt_member_transaction_list($members,$new_day_end_date);
		$skt_member_id_list_in_transaction = array();
		$transaction_id_list = array();
		$transactions = "";
		foreach($skt_member_transaction_list as $skt_member_transaction){
			$transactions .=$skt_member_transaction['id'].',';
			$skt_member_id_list_in_transaction[] = $skt_member_transaction['member_id'];
			$transaction_id_list[] = $skt_member_transaction['id'];
		}
						
		$total_skt_member_id_in_transaction = count($skt_member_id_list_in_transaction);
		
		$pending_skt_member_transaction_list = array_diff($skt_member_id_list, $skt_member_id_list_in_transaction);
		//print_r($pending_skt_member_transaction_list);
		if(!empty($pending_skt_member_transaction_list)) {
			$error['skt_member']['pending_skt_member_list']=$pending_skt_member_transaction_list;
			return $error;
		}
		
		$transactions = 	substr($transactions,0, -1);
		//
		//SKT Transactions authorization check
		$authorized_skt_member_transaction_list = $this->get_skt_member_transaction_list_is_authorized($transactions);
		$authorized_skt_member_id_list_in_transaction = array();
		$authorized_transaction_id_list = array();
		$authorized_transactions = "";
		foreach($authorized_skt_member_transaction_list as $authorized_skt_member_transaction){
			$authorized_transactions .=$authorized_skt_member_transaction['id'].',';
			$authorized_skt_member_id_list_in_transaction[] = $authorized_skt_member_transaction['member_id'];
			$authorized_transaction_id_list[] = $authorized_skt_member_transaction['id'];
		}
						
		$total_authorized_skt_member_id_in_transaction = count($authorized_skt_member_id_list_in_transaction);
		
		$pending_authorized_skt_member_transaction_list = array_diff($skt_member_id_list_in_transaction, $authorized_skt_member_id_list_in_transaction);
		if(!empty($pending_authorized_skt_member_transaction_list)) {
				$error['skt_member']['pending_authorized_skt_member_transaction_list']=$pending_authorized_skt_member_transaction_list;
			return $error;
		}
		//echo "$total_saving_id == $total_saving_id_in_transaction <br>";
		return $error;
	}
	function get_loan_transaction_list_is_authorized($transactions){
		$transactions = ($transactions == '')?'-1111':$transactions;		
		$query = "SELECT loan_id,id FROM loan_transactions WHERE is_authorized = 1 and id IN ($transactions);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_loan_transaction_list($loans,$new_day_end_date){		
		$loans = ($loans == '')?'-1111':$loans;		
		$query = "SELECT loan_id,id FROM loan_transactions WHERE transaction_date = '$new_day_end_date' and loan_id IN ($loans);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
    function get_loan_list($members,$new_day_end_date){	
			
		$members = ($members == '')?'-1111':$members;		
		$query = "SELECT *
FROM loans 
WHERE current_status = 1 AND is_authorized = 1 AND first_repayment_date < '$new_day_end_date' AND is_loan_fully_paid = 0 AND member_id IN ($members);";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_saving_transaction_list_is_authorized($transactions){	
		$transactions = ($transactions == '')?'-1111':$transactions;		
		$query = "SELECT savings_id,id FROM saving_deposits WHERE is_authorized = 1 and id IN ($transactions);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_saving_transaction_list($savings,$new_day_end_date){
		$savings = ($savings == '')?'-1111':$savings;		
		$query = "SELECT savings_id,id FROM saving_deposits WHERE transaction_date = '$new_day_end_date' and savings_id IN ($savings);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
    function get_saving_list($members,$new_day_end_date){
		$members = ($members == '')?'-1111':$members;		
		$query = "SELECT * FROM savings WHERE current_status = 1 AND opening_date < '$new_day_end_date' AND member_id IN ($members);";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function get_skt_member_transaction_list_is_authorized($transactions){	
		$transactions = ($transactions == '')?'-1111':$transactions;		
		$query = "SELECT member_id,id FROM skt_collections WHERE is_authorized = 1 and id IN ($transactions);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	function get_skt_member_transaction_list($skt_members,$new_day_end_date){
		$skt_members = ($skt_members == '')?'-1111':$skt_members;		
		$query = "SELECT member_id,id FROM skt_collections WHERE transaction_date = '$new_day_end_date' and member_id IN ($skt_members);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
    function get_member_list($samities){	
		$samities = ($samities == '')?'-1111':$samities;		
		$query = "SELECT id FROM members WHERE member_status <> 'Inactive' AND samity_id IN ($samities);";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}

    function get_samity_list($new_day_end_date,$branch_id){
		$new_date = explode('-',$new_day_end_date);
		$samity_day = date("D",mktime(0,0,0,$new_date[1],$new_date[2],$new_date[0]));

		$query="SELECT id FROM samities WHERE branch_id = $branch_id AND samity_day = '$samity_day' AND opening_date <= '$new_day_end_date' AND STATUS  = 1";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function get_skt_samity_list($new_day_end_date,$branch_id){
		$new_date = explode('-',$new_day_end_date);
		$samity_day = date("D",mktime(0,0,0,$new_date[1],$new_date[2],$new_date[0]));

		$query="SELECT id FROM samities WHERE skt_amount <> 0 AND skt_amount IS NOT NULL AND branch_id = $branch_id AND samity_day = '$samity_day' AND opening_date <= '$new_day_end_date' AND STATUS  = 1";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function get_loan_transaction_info($loans,$new_day_end_date){
		$new_day_end_date = '2011-04-30';
		$loans = ($loans == '')?'-1111':$loans;		
		$query = "SELECT loan_id,SUM(transaction_amount) AS total_transaction_amount FROM loan_transactions 
WHERE is_authorized = 1 AND transaction_date <= '$new_day_end_date' 
AND loan_id IN ($loans) GROUP BY loan_id;";
		//echo $query;
		$query = $this->db->query($query);
		return $query->result_array();
	}
	function loan_edit($data)
    {
        return $this->db->update('loans', $data, array('id'=> $data['id']));
    }	
	function execute_loan_closing($members,$samities,$branch_id,$new_day_end_date){
		//echo "---------<pre>";
		//print_r($members);
		if(empty($members)) {
			return true;
		}
		$samity_id_list = explode(',',$samities);
		$loan_schedule_information=$this->scheduler->get_samity_wise_current_loan_information_just_before_date($samity_id_list,$new_day_end_date,$branch_id);
		$loan_schedules = array();
		foreach($loan_schedule_information as $loan_schedule) {
			if(is_array($loan_schedule)) {
				foreach($loan_schedule as $loan) {
					if(is_array($loan)) {
						$loan_schedules[$loan['loan_id']]['loan_id'] = $loan['loan_id'];
						//$loan_schedules[$loan['loan_id']]['installment_amount']  = $loan['installment_amount'];
						//$loan_schedules[$loan['loan_id']]['total_installment_no']  = $loan['total_installment_no'];
						//$loan_schedules[$loan['loan_id']]['last_installment_amount']  = $loan['last_installment_amount'];
						$loan_schedules[$loan['loan_id']]['total_recoverable_amount']  = ($loan['installment_amount'] * ($loan['total_installment_no'] - 1)) + $loan['last_installment_amount'];
					}
				}
			}
		}
		
		//Loan transaction
		$loan_id_list = array_keys($loan_schedules);
		
		$loan_id_string = join(',',$loan_id_list);
		$loan_transaction_list = $this->get_loan_transaction_info($loan_id_string,$new_day_end_date);
		$fully_paid_loan_list = array();
		if(!empty($loan_transaction_list)) {
			foreach($loan_transaction_list as $loan) {
				$loan_schedules[$loan['loan_id']]['transaction_amount'] = $loan['total_transaction_amount'];
				if($loan_schedules[$loan['loan_id']]['total_recoverable_amount'] <= $loan['total_transaction_amount']) {
					$fully_paid_loan_list[$loan['loan_id']]['id'] = $loan['loan_id'];
					$fully_paid_loan_list[$loan['loan_id']]['fully_paid_amount'] = $loan['total_transaction_amount'];
					$fully_paid_loan_list[$loan['loan_id']]['is_loan_fully_paid'] = true;
					$fully_paid_loan_list[$loan['loan_id']]['current_status'] = false;
					$fully_paid_loan_list[$loan['loan_id']]['loan_fully_paid_date'] = $new_day_end_date;
					$fully_paid_loan_list[$loan['loan_id']]['loan_closing_date'] = $new_day_end_date;
				}
			}
		}
		//make fully paid
		if(!empty($fully_paid_loan_list)) {
			foreach($fully_paid_loan_list as $fully_paid_loan){
				//print_r($fully_paid_loan);
				//$this->loan_edit($fully_paid_loan);
			}
		}
		return true;
	}
    function get_by_branch_id_date($branch_id=3,$start_date='0000-00-00',$end_date='2050-01-01'){
		
		$query="SELECT curr_date FROM curr_date";
		$query = $this->db->query($query);
		$c_date = $query->result_array();
		$c_date=$c_date[0]['curr_date'];
	
		$query="SELECT id, mnemonic FROM products WHERE TYPE!='SAVINGS'";
		$query = $this->db->query($query);
		$products = $query->result_array();
		
		$query="SELECT DISTINCT samity_type FROM samities";
		$query = $this->db->query($query);
		$samity_types = $query->result_array();
		
		$transaction_types=array();
		array_push($transaction_types,'DEP');
		array_push($transaction_types,'WIT');
		
		$query="SELECT saving_transactions.transaction_date, samities.branch_id, samities.product_id AS product_id,samities.samity_type, 
		saving_transactions.transaction_type,SUM(saving_transactions.amount) AS amount, 
		COUNT(DISTINCT savings.member_id) AS depositors 
		FROM saving_transactions 
		JOIN savings ON saving_transactions.savings_id=savings.id 
		JOIN products ON savings.product_id=products.id 
		JOIN members ON savings.member_id=members.id 
		JOIN samities ON members.samity_id=samities.id 
		WHERE samities.branch_id='".$branch_id."' 
		AND saving_transactions.transaction_date BETWEEN '".$start_date."' AND '".$end_date."'
		AND members.member_status='Active' AND (saving_transactions.transaction_type ='DEP' OR saving_transactions.transaction_type='WIT')
		GROUP BY samities.product_id,samities.samity_type,saving_transactions.transaction_type 
		ORDER BY saving_transactions.transaction_date";
		
		print_r($query);
		
		$query = $this->db->query($query);

		$transaction_array = $query->result_array();
		print_r($transaction_array);
		$result_array=array();
		
		
		print_r($products);
		print_r($samity_types);
		//die;
		
		//foreach($transaction_types as $transaction_type){
			foreach($products as $product){
				foreach($samity_types as $samity_type){
						
					$result_array[$product['id']][$samity_type['samity_type']]=array('date'=>$c_date,'branch_id'=>$branch_id,'product_id'=>$product['id'],'samity_type'=>$samity_type['samity_type'],'no_of_depositors'=>0,'total_withdraw'=>0,'total_deposit'=>0);
				}
			}
		//}
		
		
			foreach($products as $product){
				foreach($samity_types as $samity_type){
					foreach($transaction_types as $transaction_type){
						foreach($transaction_array as $transaction){
						if($transaction['product_id']==$product['id'] && $transaction['samity_type']==$samity_type['samity_type']){
							if($transaction_type=='DEP'){
						
								$result_array[$product['id']][$samity_type['samity_type']]=array('date'=>$transaction['transaction_date'],'branch_id'=>$transaction['branch_id'],'product_id'=>$transaction['product_id'],'samity_type'=>$transaction['samity_type'],'no_of_depositors'=>$transaction['depositors'],'total_withdraw'=>0,'total_deposit'=>$transaction['amount']);
							}
							else if($transaction_type=='WIT'){
						
								$result_array[$product['id']][$samity_type['samity_type']]=array('date'=>$transaction['transaction_date'],'branch_id'=>$transaction['branch_id'],'product_id'=>$transaction['product_id'],'samity_type'=>$transaction['samity_type'],'no_of_depositors'=>$transaction['depositors'],'total_withdraw'=>$transaction['amount'],'total_deposit'=>0);
							}
						}
					}
				}
			}
			
		}
		
		
		
		//foreach($result_array as $key=>$val){
			foreach($products as $product){
				foreach($samity_types as $samity_type){
					$result_array[$product['id']][$samity_type['samity_type']]['closing_balance']=$result_array[$product['id']][$samity_type['samity_type']]['total_deposit']-$result_array[$product['id']][$samity_type['samity_type']]['total_withdraw'];
					$this->db->insert('day_end_process_savings', $result_array[$product['id']][$samity_type['samity_type']]);
				}
			}
		//}
		
		$query="UPDATE curr_date SET curr_date = DATE_ADD(curr_date,INTERVAL 1 DAY)";
		$query = $this->db->query($query);
		
		//print_r($result_array);
		
		//die;
	}
	
	function process_loan(){
		
		"SELECT samities.branch_id branch_id,loan_transactions.transaction_date,products.id product_id,
		loans.id,samities.samity_type,SUM(loan_transactions.amount) AS recovery , 
		SUM(loans.total_payable_amount)-SUM(loan_transactions.amount) AS outstanding 
		FROM loan_transactions 
		JOIN loans ON loan_transactions.loan_id=loans.id 
		JOIN members ON loans.member_id=members.id 
		JOIN products ON loans.product_id=products.id 
		JOIN samities ON members.samity_id=samities.id 
		GROUP BY products.id,samities.samity_type 
		ORDER BY loan_transactions.transaction_date";

	}
	/*
	function($date){
	"SELECT * FROM saving_transactions WHERE saving_transactions.transaction_date='".$date."' AND saving_transactions.authorization_status='1'"
	
	}
	
	function count_members_by_branch_id_product_id_samity_type($branch_id,$product_id, $samity_type){
		
		$query="SELECT COUNT(*) FROM savings LEFT JOIN products ON savings.product_id=products.id LEFT JOIN members ON members.id=savings.member_id LEFT JOIN samities ON samities.id=members.samity_id WHERE samities.branch_id='".$branch_id."' AND products.id='".$product_id."' AND samities.samity_type='".$samity_type."' AND members.member_status='Active'";
	}
	
	function count_depositors_branch_id_product_id_samity_type($branch_id,$product_id, $samity_type){
		
		$query=SELECT COUNT(UNIQUE(saving_transactions.savings_id)) FROM saving_transactions WHERE saving_transactions.transaction_date='';;
	}
	
	*/

}
