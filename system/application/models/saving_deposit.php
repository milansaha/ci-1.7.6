<?php
/** 
	* Saving_deposit Model Class. 
	* @pupose		Manage Saving_deposit information
	*		
	* @filesource	\app\model\saving_deposit.php	
	* @package		microfin 
	* @subpackage	microfin.model.saving_deposit
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Saving_deposit extends MY_Model {

    function Saving_deposit()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    function get_list($offset,$limit,$cond=null)
    {
       	$this->db->select('savings.code as savings_code,members.id as member_id,members.code as member_code,members.name as member_name,saving_products.name as product_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,saving_deposits.*');
		$this->db->from('saving_deposits');		
		$this->db->join('savings', 'savings.id = saving_deposits.savings_id');
		$this->db->join('members', 'saving_deposits.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->join('saving_products', 'saving_deposits.saving_products_id = saving_products.id');		
		$this->db->where(array('saving_deposits.branch_id'=> $this->auth->get_branch_id(),'savings.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));			
		$type = array('DEP', 'INT');
		$this->db->where_in('saving_deposits.transaction_type', $type);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_deposits.samity_id', $cond['samity']);				
			}
			if(isset($cond['transaction_type']) and !empty($cond['transaction_type'])){	
				$this->db->where('saving_deposits.transaction_type', $cond['transaction_type']);				
			}
			if(isset($cond['transaction_date']) and !empty($cond['transaction_date'])){	
				$this->db->where('saving_deposits.transaction_date', $cond['transaction_date']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){					
				$where = "( savings.code LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);					
			}				
		}		
		$this->db->limit($offset, $limit);
		$this->db->order_by('saving_deposits.transaction_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond=null)
	{		
		$this->db->join('savings', 'savings.id = saving_deposits.savings_id');
		$this->db->join('members', 'saving_deposits.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->join('saving_products', 'saving_deposits.saving_products_id = saving_products.id');		
		$this->db->where(array('saving_deposits.branch_id'=> $this->auth->get_branch_id(),'savings.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));			
		$type = array('DEP', 'INT');
		$this->db->where_in('saving_deposits.transaction_type', $type);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_deposits.samity_id', $cond['samity']);				
			}
			if(isset($cond['transaction_type']) and !empty($cond['transaction_type'])){	
				$this->db->where('saving_deposits.transaction_type', $cond['transaction_type']);				
			}
			if(isset($cond['transaction_date']) and !empty($cond['transaction_date'])){	
				$this->db->where('saving_deposits.transaction_date', $cond['transaction_date']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( savings.code LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);
			}				
		}			
		return $this->db->count_all_results('saving_deposits');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('saving_deposits', 'id');
		return $this->db->insert('saving_deposits', $data);
    }

    function edit($data)
    {
        return $this->db->update('saving_deposits', $data, array('id'=> $data['id']));
    }
	
	function read($saving_id)
    {
        $query=$this->db->getwhere('saving_deposits', array('id' => $saving_id));
		return $query->result();
    }
		
	function delete($saving_id)
	{
		return $this->db->delete('saving_deposits', array('id'=> $saving_id));
	}

	function get_saving_products_list()
    {		
		$saving_products = $this->db->query("SELECT sp.id,sp.name FROM saving_products AS sp");
		return $saving_products->result();  
    } 
	function get_member_info($member_id='-1')
    {			 
        $member_id = !is_numeric($member_id)?"-1":$member_id;
		$member_loan_info = $this->db->query("SELECT name,code,savings_id,member_id,member_primary_product_id,
saving_deposits.saving_products_id,saving_deposits.branch_id,saving_deposits.samity_id
FROM saving_deposits JOIN members ON saving_deposits.member_id=members.id WHERE saving_deposits.member_id=$member_id GROUP BY saving_deposits.member_id");			
		return $member_loan_info->result();
    } 
	function get_available_savings_amount($member_id='-1')
    {			 
        $member_id = !is_numeric($member_id)?"-1":$member_id;
		$savings_amount = $this->db->query("SELECT IF((deposit_amount-IFNULL(withdraw_amount,0.00))>0,(deposit_amount-IFNULL(withdraw_amount,0.00)),0.00) AS amount
			FROM (
			(SELECT SUM(amount)AS deposit_amount,member_id FROM saving_deposits WHERE member_id=$member_id)AS a
			left JOIN 
			(SELECT SUM(amount) AS withdraw_amount,member_id FROM saving_withdraws WHERE member_id=$member_id)AS b
			ON a.member_id=b.member_id)");			
		$savings_amount=$savings_amount->result();	
		if(!empty($savings_amount))
		{
			return $savings_amount[0]->amount;
		}		
    }  
	//Savings deposited authorization 
	function get_unauthorized_saving_deposit_list($offset,$limit,$cond=null)
    {
       	$this->db->select('savings.code as savings_code,members.id as member_id,members.code as member_code,members.name as member_name,saving_products.name as product_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,saving_deposits.*');
		$this->db->from('saving_deposits');		
		$this->db->join('savings', 'savings.id = saving_deposits.savings_id');
		$this->db->join('members', 'saving_deposits.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->join('saving_products', 'saving_deposits.saving_products_id = saving_products.id');		
		$this->db->where(array('saving_deposits.is_authorized' => 0,'members.member_status <>'=>"Inactive",'saving_deposits.branch_id'=> $this->auth->get_branch_id(),'savings.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));	
		$type = array('DEP', 'INT');
		$this->db->where_in('saving_deposits.transaction_type', $type);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_deposits.samity_id', $cond['samity']);				
			}							
		}		
		$this->db->limit($offset, $limit);
		$this->db->order_by('saving_deposits.transaction_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	function get_unauthorized_saving_deposit_list_row_count($cond=null)
    {
        $this->db->select('count(saving_deposits.id) as id');
		$this->db->from('saving_deposits');
		$this->db->join('savings', 'savings.id = saving_deposits.savings_id');
		$this->db->join('members', 'saving_deposits.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->join('saving_products', 'saving_deposits.saving_products_id = saving_products.id');		
		$this->db->where(array('saving_deposits.is_authorized' => 0,'members.member_status <>'=>"Inactive",'saving_deposits.branch_id'=> $this->auth->get_branch_id(),'savings.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));			
		$type = array('DEP', 'INT');
		$this->db->where_in('saving_deposits.transaction_type', $type);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_deposits.samity_id', $cond['samity']);				
			}						
		}			
		$query = $this->db->get(); 
        $query=$query->result();
		return $query[0]->id;    
    }
    function authorized($data)
    { 		
		$flag=0;
		foreach($data as $data)
		{ 			
			$this->db->update('saving_deposits', $data, array('id'=> $data['id']));  
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
}
