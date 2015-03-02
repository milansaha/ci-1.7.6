<?php
/** 
        * Member Transfer Model Class.
        * @pupose               Manage Member Transfer information
        *               
        * @filesource   \app\model\member_transfers.php      
        * @package              microfin 
        * @subpackage   microfin.model.member_transfers
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam $       
        * @lastmodified $Date: 2011-01-04 $      
*/



class Member_transfer extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		$this->db->select('member_transfers.id, member_transfers.transfer_date,member_transfers.is_approved, members.name , previous_samity.name AS previous_samity_name, current_samity.name AS current_samity_name');
		$this->db->from('member_transfers');
		$this->db->join('members', 'member_transfers.member_id = members.id');
		$this->db->join('samities AS previous_samity', 'member_transfers.previous_samity_id = previous_samity.id');
		$this->db->join('samities AS current_samity', 'member_transfers.current_samity_id = current_samity.id');
		$this->db->limit( $offset, $limit);
		
		//search
		if(is_array($cond)){
			if(isset($cond['from_date']) and !empty($cond['from_date'])){					
				$where = "( member_transfers.transfer_date BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}')";
   				//(time_stamp BETWEEN '1294077600' AND '1300125600')   				
   				$this->db->where($where);
			}			
			if(isset($cond['name']) and !empty($cond['name'])){	
				$this->db->like('members.name', $cond['name']);
				
			}	
		}
		$query = $this->db->get(); 
        return $query->result(); 
    }
	
	function row_count($cond)
	{
		return $this->db->count_all_results('member_transfers');
	}
	
	function member_transfer_add($data)
    {
    	//print_r($data);
    
		//die;
		$this->db->trans_begin(TRUE);
		
		$this->db->query("UPDATE members SET branch_id = {$data['new_branch_id']} , samity_id = {$data['new_samity_id']}, member_status = 'Transfered' WHERE id = {$data['member_id']} ");
		//$transaction_log = join('---',$transaction_log);
		$this->db->query("INSERT INTO member_transfers (member_id,transfer_date,previous_samity_id,current_samity_id ) VALUES
	({$data['member_id']} ,'{$data['transfer_date']}',{$data['old_samity_id']},{$data['new_samity_id']});");
		//print_r($data['loan']);
		
		// @start old loan closing
		if(isset($data['loan']['id'][0]) && !empty($data['loan']['id'][0])) {
			for($i=0;$i<$data['loan']['total_row'];$i++) {
			// read loan information by loan id
			
			// insert new loan
			$this->db->query("INSERT INTO loans (customized_loan_no, loan_application_no, branch_id, samity_id, product_id, member_id, 
	purpose_id, funding_org_id, interest_calculation_method, loan_amount, interest_rate, 
	interest_amount, discount_interest_amount, insurance_guarantor_percentage, insurance_guarantor_amount, 
	total_payable_amount, number_of_installment, installment_amount, repayment_frequency, 
	loan_period_in_month, mode_of_interest, interest_rate_calculation_amount, cycle, 
	first_repayment_date,last_repayment_date , is_authorized, disburse_registration_no, 
	disbursed_by, disburse_date, authorized_by, authorized_date, ledger_id, voucher_status, 
	fully_paid_registration_no, overdue_registration_no, is_loan_fully_paid, loan_fully_paid_date, 	current_status, loan_closing_date, loan_closing_info_verified_by
	) 
	SELECT customized_loan_no, loan_application_no, {$data['new_branch_id']}, {$data['new_samity_id']}, product_id, member_id, 
	purpose_id, funding_org_id, interest_calculation_method, loan_amount, interest_rate, 
	interest_amount, discount_interest_amount, insurance_guarantor_percentage, insurance_guarantor_amount, 
	total_payable_amount, number_of_installment, installment_amount, repayment_frequency, 
	loan_period_in_month, mode_of_interest, interest_rate_calculation_amount, cycle, 
	first_repayment_date, '{$data['loan']['transaction_date'][$i]}', is_authorized, disburse_registration_no, 
	disbursed_by, disburse_date, authorized_by, authorized_date, ledger_id, voucher_status, 
	fully_paid_registration_no, overdue_registration_no, is_loan_fully_paid, loan_fully_paid_date, 	current_status, loan_closing_date, loan_closing_info_verified_by
	 FROM loans WHERE id= {$data['loan']['id'][$i]}");
	 			$sql=$this->db->query("select max(id) as max_laon_id from loans"); 
	            foreach ($sql->result_array() as $row)
	            {
					$new_max_laon_id=$row['max_laon_id'];
				}
	 
			// update loan	
				$this->db->query("UPDATE loans SET current_status = 0,loan_closing_date = '{$data['loan']['transaction_date'][$i]}', last_repayment_date = '{$data['loan']['transaction_date'][$i]}' WHERE id = {$data['loan']['id'][$i]} ");
				$this->db->query("INSERT INTO loan_transactions (loan_id,transaction_date,transaction_amount,installment_number,entry_by ,entry_date) VALUES
		({$data['loan']['id'][$i]} ,'{$data['loan']['transaction_date'][$i]}',{$data['loan']['amount'][$i]},333,{$data['loan']['entry_by'][$i]},'{$data['loan']['entry_date'][$i]}' );");
		
			}
		}
		// @end old loan closing
		
		// @start new loan add
		// @end new loan add
		if(isset($data['saving']['id'][0]) && !empty($data['saving']['id'][0])) {
			for($i=0;$i<$data['saving']['total_row'];$i++) {
				
				// insert new loan
			$this->db->query("INSERT INTO savings (CODE,branch_id,samity_id,member_id,saving_products_id,funding_organization_id,opening_date,current_status,weekly_savings,created_by,created_on
	)SELECT concat(CODE,'-',{$data['saving']['id'][$i]}),{$data['new_branch_id']},{$data['new_samity_id']},member_id,saving_products_id,funding_organization_id,opening_date,current_status,weekly_savings,{$data['saving']['created_by'][$i]},'{$data['saving']['created_on'][$i]}'
	 FROM savings WHERE id= {$data['saving']['id'][$i]} limit 1");
	 
	 			$sql=$this->db->query("select max(id) as max_saving_id from savings"); 
	            foreach ($sql->result_array() as $row)
	            {
					$new_max_saving_id=$row['max_saving_id'];
				}
				
				$this->db->query("UPDATE savings SET current_status = 0,updated_by = '{$data['saving']['updated_by'][$i]}' , updated_on = '{$data['saving']['updated_on'][$i]}' WHERE id = {$data['saving']['id'][$i]} ");
				
				$this->db->query("INSERT INTO saving_deposits (savings_id,member_id,branch_id,samity_id,member_primary_product_id,transaction_date,transaction_type,mode_of_payment,amount,entry_by,entry_on ) VALUES
			({$new_max_saving_id},{$data['member_id']},{$data['new_branch_id']},{$data['new_samity_id']} ,{$data['saving']['member_primary_product_id']} ,'{$data['saving']['transaction_date'][$i]}','DEP','CASH',{$data['saving']['amount'][$i]},{$data['saving']['created_by'][$i]},'{$data['saving']['created_on'][$i]}' );");
				
				$this->db->query("INSERT INTO saving_withdraws (savings_id,member_id,branch_id,samity_id,member_primary_product_id,transaction_date,transaction_type,mode_of_payment,amount,entry_by,entry_on) VALUES
		({$data['saving']['id'][$i]},{$data['member_id']},{$data['new_branch_id']},{$data['new_samity_id']} ,{$data['saving']['member_primary_product_id']} ,'{$data['saving']['transaction_date'][$i]}','WIT','CASH',{$data['saving']['amount'][$i]},{$data['saving']['created_by'][$i]},'{$data['saving']['created_on'][$i]}' );");		
			
			}	
		}
		
	$this->db->trans_complete(); 
		return $this->db->trans_status();
    }
    function add($data)
    {
	$this->db->insert('member_transfers',$data);
	
	$sql=$this->db->query("select max(id) as max_transfer_id from member_transfers"); 
                foreach ($sql->result_array() as $row)
                {
			$data['member_transfer_id']=$row['max_transfer_id'];
		}
        return $this->db->insert('member_transfer_histories',$data);
    }

    function edit($data)
    {
	$this->db->update('member_transfers', $data, array('id'=> $data['id']));
	$data['member_transfer_id']=$data['id'];
	$sql=$this->db->query("select max(id) as max_transfer_id from member_transfer_histories");
                      foreach ($sql->result_array() as $row)
                      {
                              $data['id']=$row['max_transfer_id']+1;
                      }

        return $this->db->insert('member_transfer_histories',$data);
    }
    function soft_edit($data)
    {
	return $this->db->update('member_transfers', $data, array('id'=> $data['id']));	
    }	
	
	function read($member_transfer_id)
    {
        $query=$this->db->getwhere('member_transfers', array('id' => $member_transfer_id));
		return $query->result();
    }
	
	function delete($member_transfer_id)
	{
		return $this->db->delete('member_transfers', array('id'=> $member_transfer_id));
	}
	function get_unauthorised_transfer_by_member_id($member_id)
	{		
		if(!is_numeric($member_id)) {
			return false;
		}
		$member_transfer_id = $this->db->query("SELECT id AS member_transfer_id FROM member_transfers WHERE member_id = $member_id AND is_approved = 0 LIMIT 1;");		
		return (isset($member_transfer_id->row()->member_transfer_id))?true:false;  
    }
    
    /**
 * @param object
 */
	function get_all_transfer_data_by_transfer_id($member_transfer_info)
	{		
		if(!is_object($member_transfer_info)) {
			return false;
		}
		print_r($member_transfer_info);
		die;
		$member_transfer_id = $this->db->query("SELECT id AS member_transfer_id FROM member_transfers WHERE member_id = $member_id AND is_approved = 0 LIMIT 1;");		
		return (isset($member_transfer_id->row()->member_transfer_id))?true:false;  
    }

}
