<?php
/** 
	* Loan Transaction Model Class. 
	* @pupose		Manage Loan Transaction information
	*		
	* @filesource	\app\model\loan_transaction.php	
	* @package		microfin 
	* @subpackage	microfin.model.loan_transaction
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Loan_transaction extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('Scheduler1');
    }
    
    function get_list($offset,$limit,$cond=null)
    {
       	$this->db->select('loan_transactions.*, loans.id AS loan_id,loans.customized_loan_no,members.code AS member_code,samities.code AS samity_code');
		$this->db->from('loan_transactions');		
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){					
				$where ="( loans.customized_loan_no LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);	
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loan_transactions.samity_id', $cond['samity']);				
			}
			if(isset($cond['to_date']) and !empty($cond['to_date']) and isset($cond['from_date']) and !empty($cond['from_date'])){	
				$this->db->where("loan_transactions.transaction_date between '{$cond['to_date']}' AND '{$cond['from_date']}'");				
			}	
		}		
		$this->db->join('loans', 'loan_transactions.loan_id = loans.id','left');
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->join('samities', 'loan_transactions.samity_id = samities.id','left');
		$this->db->where(array('loan_transactions.branch_id'=> $this->auth->get_branch_id()));
		$this->db->limit($offset,$limit);
		$query = $this->db->get();        
		return $query->result();
    }
	
	function row_count($cond=null)
	{
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){		
				$where ="( loans.customized_loan_no LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);			
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loan_transactions.samity_id', $cond['samity']);				
			}
			if(isset($cond['to_date']) and !empty($cond['to_date']) and isset($cond['from_date']) and !empty($cond['from_date'])){	
				$this->db->where("loan_transactions.transaction_date between '{$cond['to_date']}' AND '{$cond['from_date']}'");				
			}	
		}
		
		$this->db->join('loans', 'loan_transactions.loan_id = loans.id','left');
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->join('samities', 'loan_transactions.samity_id = samities.id','left');
		$this->db->where(array('loan_transactions.branch_id'=> $this->auth->get_branch_id()));
		return $this->db->count_all_results('loan_transactions');
	}
	
    function add($data)
    {   
		$loan_id=$data['loan_id'];
		$transaction_date=$data['transaction_date'];			
		
		// get transaction_principal_amount,transaction_interest_amount
		$loandata=$this->get_loan_transaction_amount($data['loan_id'],$data['transaction_amount']);
		if(isset($loandata['transaction_principal_amount']))
		{
			$data['transaction_principal_amount']=$loandata['transaction_principal_amount'];
		}
		if(isset($loandata['transaction_interest_amount']))
		{
			$data['transaction_interest_amount']=$loandata['transaction_interest_amount'];
		}
		
		// get current_total_collection_amount
		$loan_transaction_information = $this->db->query("SELECT  current_total_collection_amount,current_outstanding_amount
				FROM loan_transactions WHERE loan_id=$loan_id AND id=(SELECT MAX(id) FROM loan_transactions WHERE loan_id=$loan_id)");			
		$loan_transaction_information=$loan_transaction_information->result();  
		//echo "<pre>"; print_r($loan_transaction_information[0]->current_total_collection_amount);die;
		if(!empty($loan_transaction_information))
		{
			$data['current_total_collection_amount']=$loan_transaction_information[0]->current_total_collection_amount+$data['transaction_amount'];			
		}
		else
		{
			$data['current_total_collection_amount']=$data['transaction_amount'];
		}

		// get current_outstanding_amount
		$loan_information = $this->db->query("SELECT total_payable_amount FROM loans WHERE id=$loan_id");			
		$loan_information=$loan_information->result();  
		if(!empty($loan_information))
		{
			$data['current_outstanding_amount']=$loan_information[0]->total_payable_amount-$data['current_total_collection_amount'];
		}

		// get current_due_amount
		/*$installment_amount = $this->db->query("SELECT SUM(installment_amount) as total_installment_amount FROM loan_schedules WHERE loan_id=$loan_id AND schedule_date<'$transaction_date'");			
		$installment_amount =$installment_amount->result(); 		
		if(!empty($installment_amount))
		{
			if($data['current_total_collection_amount']<$installment_amount[0]->total_installment_amount)
			{
				$data['current_due_amount']=$installment_amount[0]->total_installment_amount-$data['current_total_collection_amount'];
			}
		}
		
		// get current_overdue_amount
		$total_amount = $this->db->query("SELECT SUM(installment_amount) as installment_amount,MAX(schedule_date) as schedule_date FROM loan_schedules WHERE loan_id=$loan_id");			
		$total_amount = $total_amount->result(); 		
		if(!empty($total_amount))
		{
			//print($total_amount[0]->schedule_date);die;
			if($transaction_date>$total_amount[0]->schedule_date)
			{
				$data['current_overdue_amount']=$total_amount[0]->installment_amount-$data['current_total_collection_amount'];				
			}
		}*/
		//echo "<pre>"; print_r($data);die;
 		$data['id']=$this->get_new_id('loan_transactions', 'id');
		return $this->db->insert('loan_transactions', $data);
    }

    function edit($data)
    {
        return $this->db->update('loan_transactions', $data, array('id'=> $data['id']));
    }
	
	function read($loan_transaction_id)
    {
        $query=$this->db->getwhere('loan_transactions', array('id' => $loan_transaction_id));
		return $query->result();
    }
	
	function delete($loan_transaction_id)
	{
		return $this->db->delete('loan_transactions', array('id'=> $loan_transaction_id));
	}
	
	function get_loan_information($member_id = -1)
    {
        //print_r($member_id);die;
        $member_id = !is_numeric($member_id)?"-1":$member_id;
		$loan_information = $this->db->query("SELECT l.id AS loan_id,l.customized_loan_no AS loan_code,p.short_name AS product_mnemonic
                                    FROM loans AS l
                                    INNER JOIN loan_products AS p ON (p.id = l.product_id)
                                    WHERE l.member_id=$member_id AND l.is_authorized=1");
		return  $loan_information->result();  
    }
    function get_loan_information_by_loan_id($loan_id = -1)
    {
        $loan_id = !is_numeric($loan_id)?"-1":$loan_id;
        /*
		$loan_information = $this->db->query("SELECT loan_schedules.installment_amount,loans.product_id,(MAX(IFNULL(loan_transactions.installment_number,0)) + 1) AS installment_number
		FROM loans 
		LEFT JOIN loan_transactions ON (loan_transactions.loan_id = loans.id)
		LEFT JOIN loan_schedules ON (loan_schedules.loan_id = loans.id)
		WHERE loans.id=$loan_id");
         */
        $loan_information = $this->db->query("SELECT loans.product_id,(MAX(IFNULL(loan_transactions.installment_number,0)) + 1) AS installment_number
		FROM loans
		LEFT JOIN loan_transactions ON (loan_transactions.loan_id = loans.id)
		WHERE loans.id=$loan_id");
		return  $loan_information->result();  
    }
    
    function get_loan_transaction_information_by_loan_id($loan_id = null)
    {
		$loan_transaction_information=array();
        if(!empty($loan_id)){
        
        $loan_transaction_information = $this->db->query("SELECT loans.id as loan_id,loans.product_id,(IFNULL(loan_transactions.installment_number,1)) AS installment_number
		FROM loans
		LEFT JOIN loan_transactions ON (loan_transactions.loan_id = loans.id)
		WHERE loans.id=$loan_id");
		$loan_transaction_information=$loan_transaction_information->result_array();  
		}
		return  $loan_transaction_information;  
    }
    
	function get_member_id_by_loan_id($loan_id = -1)
    {
        $loan_id = !is_numeric($loan_id)?"-1":$loan_id;
		$member_information = $this->db->query("SELECT l.member_id AS member_id FROM loans AS l WHERE l.id=$loan_id");			
		return  $member_information->result();  
    }
	//Loan transaction authorization 
	function get_unauthorized_loan_transaction_list($offset,$limit,$cond=null)
    {
       	$this->db->select('loan_transactions.*, loans.id AS loan_id,loans.customized_loan_no');	
		$this->db->from('loan_transactions');		
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){					
				$where ="( loans.customized_loan_no LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);	
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loan_transactions.samity_id', $cond['samity']);				
			}
			if(isset($cond['to_date']) and !empty($cond['to_date']) and isset($cond['from_date']) and !empty($cond['from_date'])){	
				$this->db->where("loan_transactions.transaction_date between '{$cond['to_date']}' AND '{$cond['from_date']}'");				
			}	
		}		
		$this->db->join('loans', 'loan_transactions.loan_id = loans.id','left');
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->join('samities', 'loan_transactions.samity_id = samities.id','left');
		$this->db->where(array('loan_transactions.branch_id'=> $this->auth->get_branch_id(),'loan_transactions.is_authorized'=>0));
		$this->db->limit($offset,$limit);
		$query = $this->db->get();        
		return $query->result();
    }
	function get_unauthorized_loan_transaction_list_row_count($cond=null)
    {
       if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){		
				$where ="( loans.customized_loan_no LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);			
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loan_transactions.samity_id', $cond['samity']);				
			}
			if(isset($cond['to_date']) and !empty($cond['to_date']) and isset($cond['from_date']) and !empty($cond['from_date'])){	
				$this->db->where("loan_transactions.transaction_date between '{$cond['to_date']}' AND '{$cond['from_date']}'");				
			}	
		}		
		$this->db->join('loans', 'loan_transactions.loan_id = loans.id','left');
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->join('samities', 'loan_transactions.samity_id = samities.id','left');
		$this->db->where(array('loan_transactions.branch_id'=> $this->auth->get_branch_id(),'loan_transactions.is_authorized'=>0));
		return $this->db->count_all_results('loan_transactions'); 
    }
    function authorized($data)
    { 		
		$flag=0;
		foreach($data as $data)
		{ 			
			$this->db->update('loan_transactions', $data, array('id'=> $data['id']));  
			$flag=1;
		}
		if($flag==1)  
		{
			return true;   
		}
		else
		{
			return false;
		}
	}
	function get_loan_transaction_amount($loan_id,$transaction_amount)
    {
        $current_date=$this->session->userdata('system.software_date');
        $system_date = date('Y-m-d',strtotime( $current_date['current_date']));
        $schedule_info = $this->scheduler1->get_loan_transaction_amount($loan_id,$system_date);        
		$data['transaction_principal_amount']=0;
		$data['transaction_interest_amount']=0;		
		//print($loan_schedule_information[0]->principal_installment_amount);die;
		if($transaction_amount>$schedule_info['principal_installment_amount'])
		{
			$installment_amount=$schedule_info['principal_installment_amount']+$schedule_info['interest_installment_amount'];
            
			$installment_no=(int)($transaction_amount/$installment_amount);			
			for($i=0;$installment_no>$i;$i++)
			{
				$data['transaction_principal_amount']=$data['transaction_principal_amount']+$schedule_info['principal_installment_amount'];
				$data['transaction_interest_amount']=$data['transaction_interest_amount']+$schedule_info['interest_installment_amount'];
			}			
			$remaing_amount=$transaction_amount-($installment_no*$installment_amount);
			if(!empty($remaing_amount))	
			{				
				$data['transaction_principal_amount']=$data['transaction_principal_amount']+$remaing_amount;		
			}		
		}	
		else if($transaction_amount<$schedule_info['principal_installment_amount'])
		{
			$data['transaction_principal_amount']=$transaction_amount;
		}	
		else 
		{
			$data['transaction_principal_amount']=$data['transaction_principal_amount'];
		}			
		return  $data; 		
	}
	function get_first_schedule_date($loan_id=null)
    { 
        return $this->scheduler1->get_first_schedule_date($loan_id);
    }
	function get_last_transaction_date($loan_id=null)
    {      
		$last_schedule_date = $this->db->query("SELECT max(transaction_date) as transaction_date FROM loan_transactions WHERE loan_id=$loan_id");			
		$last_schedule_date=$last_schedule_date->result();  
		return  $last_schedule_date[0]->transaction_date;
    }
}
