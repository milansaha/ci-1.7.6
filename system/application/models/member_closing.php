<?php
/** 
	* Member Model Class. 
	* @pupose		Manage Member information
	*		
	* @filesource	\app\model\po_member.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_member
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam Liton $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Member_closing extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
    function add($data)
    {
      // print_r($data);
       // die()
        $transaction_log = array();
		$this->db->trans_start();
		$this->db->query("UPDATE members SET member_status = 'Inactive', cancel_date = '{$data['closing_date']}', updated_by = '{$data['updated_by']}', updated_on = '{$data['updated_on']}' WHERE id = {$data['member_id']} ");
		if(isset($data['loan']['id'][0]) && !empty($data['loan']['id'][0])) {
			for($i=0;$i<$data['loan']['total_row'];$i++) {
				
				$this->db->query("UPDATE loans SET current_status = 0,loan_closing_date = '{$data['loan']['transaction_date'][$i]}', last_repayment_date = '{$data['loan']['transaction_date'][$i]}' WHERE id = {$data['loan']['id'][$i]} ");
		
				$this->db->query("INSERT INTO loan_transactions (loan_id,transaction_date,transaction_amount,installment_number,entry_by ,entry_date) VALUES
			({$data['loan']['id'][$i]} ,'{$data['loan']['transaction_date'][$i]}',{$data['loan']['amount'][$i]},333,{$data['loan']['entry_by'][$i]},'{$data['loan']['entry_date'][$i]}' );");
				$transaction_log[] = "L{$data['loan']['id'][$i]}";
			}
		}
		if(isset($data['saving']['id'][0]) && !empty($data['saving']['id'][0])) {
			for($i=0;$i<$data['saving']['total_row'];$i++) {
					
				$this->db->query("UPDATE savings SET current_status = 0,updated_by = '{$data['saving']['updated_by'][$i]}' , updated_on = '{$data['saving']['updated_on'][$i]}' WHERE id = {$data['saving']['id'][$i]} ");
								
				$this->db->query("INSERT INTO saving_withdraws (savings_id,member_id,branch_id,samity_id,member_primary_product_id,transaction_date,transaction_type,mode_of_payment,amount,entry_by,entry_on) VALUES
		({$data['saving']['id'][$i]},{$data['member_id']},{$data['branch_id']},{$data['samity_id']} ,{$data['saving']['member_primary_product_id']} ,'{$data['saving']['transaction_date'][$i]}','WIT','CASH',{$data['saving']['amount'][$i]},{$data['saving']['created_by'][$i]},'{$data['saving']['created_on'][$i]}' );");
		
				$transaction_log[] = "S{$data['saving']['id'][$i]}";
			}
		}
		$transaction_log = join('---',$transaction_log);
		$this->db->query("INSERT INTO member_closing (member_id,closing_date,is_deleted,transaction_log ) VALUES
	({$data['member_id']} ,'{$data['closing_date']}',0,'{$transaction_log}');");
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
    }
     function edit($data)
    {
      
        $transaction_log = array();
		$this->db->trans_start();
		
		$this->db->query("UPDATE members SET member_status = 'Inactive', cancel_date = '{$data['closing_date']}', updated_by = '{$data['updated_by']}', updated_on = '{$data['updated_on']}' WHERE id = {$data['member_id']} ");
		
		if(isset($data['loan']['id'][0]) && !empty($data['loan']['id'][0])) {
			for($i=0;$i<$data['loan']['total_row'];$i++) {
				
				$this->db->query("UPDATE loans SET current_status = 0,loan_closing_date = '{$data['loan']['transaction_date'][$i]}', last_repayment_date = '{$data['loan']['transaction_date'][$i]}' WHERE id = {$data['loan']['id'][$i]} ");
		
				$this->db->query("DELETE FROM loan_transactions where loan_id={$data['loan']['id'][$i]} and transaction_date = '{$data['loan']['transaction_date'][$i]}'");
				
				$this->db->query("INSERT INTO loan_transactions (loan_id,transaction_date,transaction_amount,installment_number,entry_by ,entry_date) VALUES
			({$data['loan']['id'][$i]} ,'{$data['loan']['transaction_date'][$i]}',{$data['loan']['amount'][$i]},333,{$data['loan']['entry_by'][$i]},'{$data['loan']['entry_date'][$i]}' );");
			
				$transaction_log[] = "L{$data['loan']['id'][$i]}";
			}
		}
		if(isset($data['saving']['id'][0]) && !empty($data['saving']['id'][0])) {
			for($i=0;$i<$data['saving']['total_row'];$i++) {
					
				$this->db->query("UPDATE savings SET current_status = 0,updated_by = '{$data['saving']['updated_by'][$i]}' , updated_on = '{$data['saving']['updated_on'][$i]}' WHERE id = {$data['saving']['id'][$i]} ");
				
				$this->db->query("DELETE  FROM saving_withdraws where savings_id={$data['saving']['id'][$i]} and transaction_date = '{$data['saving']['transaction_date'][$i]}'");
				
				$this->db->query("INSERT INTO saving_withdraws (savings_id,member_id,branch_id,samity_id,member_primary_product_id,transaction_date,transaction_type,mode_of_payment,amount,entry_by,entry_on) VALUES
		({$data['saving']['id'][$i]},{$data['member_id']},{$data['branch_id']},{$data['samity_id']} ,{$data['saving']['member_primary_product_id']} ,'{$data['saving']['transaction_date'][$i]}','WIT','CASH',{$data['saving']['amount'][$i]},{$data['saving']['created_by'][$i]},'{$data['saving']['created_on'][$i]}' );");
		
				$transaction_log[] = "S{$data['saving']['id'][$i]}";
			}
		}
		$transaction_log = join('---',$transaction_log);
		$this->db->query("UPDATE member_closing SET closing_date = '{$data['closing_date']}',transaction_log  = '{$transaction_log}' where id= {$data['id']};");
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
    }
    
     function delete($data)
    {
		if(!is_numeric($data['id'])) {
			return false;
		}
      // Extract loan and saving id from transaction_log
      $transaction_info = explode('---', $data['transaction_log']);
      $total = count($transaction_info);
      $loans = array();
      $savings = array();
      if(isset($transaction_info[0][0])) {
      	for($i=0;$i<$total;$i++) {
			if($transaction_info[$i][0] == 'L'){
				$loans[]=strtok($transaction_info[$i],'L');
			}
			if($transaction_info[$i][0] == 'S'){
				$savings[]=strtok($transaction_info[$i],'S');
			}
		}
		
		}
     
		$this->db->trans_start();
		
		$this->db->query("UPDATE members SET member_status = 'Active', cancel_date = '', updated_by = '{$data['closing_date']}', updated_on = '{$data['deleted_by']}' WHERE id = {$data['member_id']} ");
		
		if(!empty($loans)) {
			for($i=0;$i<count($loans);$i++) {
				
				$this->db->query("DELETE FROM loan_transactions where loan_id={$loans[$i]} and transaction_date = '{$data['closing_date']}'");
				//TODO last repayment date
				$this->db->query("UPDATE loans SET current_status = 1,loan_closing_date = '', last_repayment_date = '{$data['closing_date']}' WHERE id = {$loans[$i]}; ");
			
			}
		}
		if(!empty($savings)) {
			for($i=0;$i<count($savings);$i++) {
				//TODO 				
				$this->db->query("DELETE  FROM saving_withdraws where savings_id={$savings[$i]} and transaction_date = '{$data['closing_date']}';");
								
				$this->db->query("UPDATE savings SET current_status = 1,updated_by = '{$data['deleted_by']}' , updated_on = '{$data['delete_date']}' WHERE id = {$savings[$i]} ");
		
			}
		}
		
		$this->db->query("delete from member_closing where id= {$data['id']};");
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
    }
    
    function get_canceled_member_list($offset,$limit,$cond='')
    {
 	// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%')";
   				$this->db->where($where);	
			}			
			if(isset($cond['cbo_branch']) and !empty($cond['cbo_branch'])){	
				$this->db->where('members.branch_id', $cond['cbo_branch']);
				
			}			
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){	
				$this->db->where('members.samity_id', $cond['cbo_samity']);
				
			}
		}
		// end search
		//Canceled
		$this->db->where('members.member_status', 'Inactive');
		
	 	$this->db->select('members.id,members.name,members.code,members.fathers_spouse_name,members.gender,po_branches.id AS branch_id,po_branches.name AS branch_name,samities.id AS samity_id,samities.name AS samity_name,member_closing.id as member_closing_id');
		$this->db->from('members');
		$this->db->join('member_closing', 'members.id = member_closing.member_id');
		$this->db->join('po_branches', 'members.branch_id = po_branches.id','left');
		$this->db->join('samities', 'members.samity_id = samities.id','left');
		
		$this->db->limit($offset, $limit);
		$this->db->order_by('members.code','ASC');
		$query = $this->db->get(); 
        return $query->result();   
        return $query->result();
    }
	
	function row_canceled_member_count($cond='')
	{
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%')";
   				$this->db->where($where);	
			}			
			if(isset($cond['cbo_branch']) and !empty($cond['cbo_branch'])){	
				$this->db->where('members.branch_id', $cond['cbo_branch']);
				
			}			
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){	
				$this->db->where('members.samity_id', $cond['cbo_samity']);
				
			}
		}
		// end search
		
		$this->db->join('member_closing', 'members.id = member_closing.member_id');
		//Canceled
		$this->db->where('members.member_status', 'Inactive');
		return $this->db->count_all_results('members');
	}
	
/**
 * get_active_member_list_by_samity_id
 * @auth Anis
 * @date 02-feb-2011 
 * @return return false if samity is empty otherwise return active member list. 
 */
 	function get_active_member_list_by_samity_id_csv($samity_id,$primary_product_id=null) {
 		
 		$primary_product_cond = ( !empty($primary_product_id) && is_numeric($primary_product_id) ) ? " AND primary_product_id = $primary_product_id ":"";
 		
		if( isset($samity_id) && is_numeric($samity_id) ) {
			$active_members = $this->db->query("SELECT id FROM members WHERE is_deleted = 0 AND member_status = 'Active' AND samity_id = $samity_id $primary_product_cond;");
			
			$active_members = $active_members->result();
			
			foreach($active_members as $active_member){
				$active_member_list[] = $active_member->id;
			}
			
			$active_member_list = join(',',$active_member_list);
			
			return $active_member_list;
		}
		return false;
	}
	
	function get_member_registration_date($member_id)
	{		
		if(!is_numeric($member_id)) {
			return false;
		}
		$registration_date = $this->db->query("SELECT registration_date FROM members where id = $member_id limit 1");		
		return $registration_date->row()->registration_date;  
    }
    
    function get_member_last_transaction_date($member_id)
	{		
		if(!is_numeric($member_id)) {
			return false;
		}
		$date = $this->db->query("SELECT MAX(transaction_date) AS transaction_date  FROM (
SELECT MAX(transaction_date) AS transaction_date FROM saving_withdraws WHERE member_id= $member_id LIMIT 1
UNION ALL
SELECT MAX(transaction_date) AS transaction_date FROM saving_deposits WHERE member_id= $member_id LIMIT 1
UNION ALL 
SELECT MAX(last_repayment_date) AS transaction_date FROM loans WHERE member_id= $member_id LIMIT 1
) saving_transactions;");		
		return $date->row()->transaction_date;  
    }
    function read($member_closing_id)
    {
        $query=$this->db->getwhere('member_closing', array('id' => $member_closing_id),1);
		return $query->row();
    }
    	
	/**
	 * 	Get member Code
	 *	@auth Anis Alamgir
	 * 	@return	string
	 */
	function get_member_code($member_id)
	{
		$user=$this->session->userdata('system.user');
		$sql = "SELECT code FROM members WHERE id = ? LIMIT 1;";
		$sql=$this->db->query($sql, array($member_id)); 
		return $sql->row()->code;
	}
}
