<?php
/** 
	* Transaction_authorizations Model Class. 
	* @pupose		Manage Transaction_authorizations information
	*		
	* @filesource	\app\model\transaction_authorization.php	
	* @package		microfin 
	* @subpackage	microfin.model.transaction_authorization
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-03-02 $	 
*/
    
class Transaction_authorization extends Model {

	function Transaction_authorization(){
		// Call the Model constructor
		parent::Model();
	}  	
	function get_unauthorized_transaction_authorizations_list($offset,$limit,$samity_id=null){		
		$branch_id=$this->auth->get_branch_id();
		$query="SELECT id as samity_id,name as samity_name,code AS samity_code
			,SUM(IF(TYPE='D',amount,0.00))AS deposit_amount
			,SUM(IF(TYPE='W',amount,0.00))AS withdraw_amount
			,SUM(IF(TYPE='SKT',amount,0.00))AS skt_collection_amount
			,SUM(IF(TYPE='L',amount,0.00))AS loan_amount
			,SUM(IF(TYPE='LT',amount,0.00))AS loan_transaction_amount

			FROM
			(
			SELECT samities.id,samities.name,samities.code,amount,'D' AS TYPE
			FROM samities LEFT JOIN saving_deposits ON saving_deposits.samity_id=samities.id and saving_deposits.branch_id=$branch_id 
			WHERE  samities.branch_id=$branch_id 
			AND is_authorized=0

			UNION ALL

			SELECT samities.id,samities.name,samities.code,amount,'W' AS TYPE
			FROM samities LEFT JOIN saving_withdraws ON saving_withdraws.samity_id=samities.id and saving_withdraws.branch_id=$branch_id 
			WHERE  samities.branch_id=$branch_id
			AND is_authorized=0

			UNION ALL 

			SELECT samities.id,samities.name,samities.code,amount,'SKT' AS TYPE
			FROM samities LEFT JOIN skt_collections ON skt_collections.samity_id=samities.id and skt_collections.branch_id=$branch_id 
			WHERE  samities.branch_id=$branch_id
			AND is_authorized=0

			UNION ALL

			SELECT samities.id,samities.name,samities.code,loan_amount AS amount,'L' AS TYPE 
			FROM samities LEFT JOIN loans ON loans.samity_id=samities.id and loans.branch_id=$branch_id 
			WHERE samities.branch_id=$branch_id
			AND is_authorized=0

			UNION ALL

			SELECT samities.id,samities.name,samities.code,transaction_amount AS amount,'LT' AS TYPE
			FROM samities LEFT JOIN loan_transactions ON loan_transactions.samity_id=samities.id and loan_transactions.branch_id=$branch_id 
			JOIN loans ON loan_transactions.loan_id=loans.id
			WHERE  samities.branch_id=$branch_id	
			AND loan_transactions.is_authorized=0
			) AS X
			GROUP BY id,name,code";
		$query=$this->db->query($query);
		$query=$query->result();
		$info=array();
		foreach($query as $row)
		{
			$info[$row->samity_id]->samity_id=$row->samity_id;
			$info[$row->samity_id]->samity_name=$row->samity_name;
			$info[$row->samity_id]->samity_code=$row->samity_code;
			$info[$row->samity_id]->deposit_amount=$row->deposit_amount;
			$info[$row->samity_id]->withdraw_amount=$row->withdraw_amount;
			$info[$row->samity_id]->skt_collection_amount=$row->skt_collection_amount;
			$info[$row->samity_id]->loan_amount=$row->loan_amount;
			$info[$row->samity_id]->loan_transaction_amount=$row->loan_transaction_amount;			
		}		
		return $info;
	}
	function get_samity_wise_unauthorized_transaction_authorizations_list($offset,$limit,$samity_id=null){		
		$query="SELECT member_id
			,SUM(IF(TYPE='D',amount,0.00))AS d_amount
			,SUM(IF(TYPE='W',amount,0.00))AS w_amount
			,SUM(IF(TYPE='SKT',amount,0.00))AS skt_amount
			,SUM(IF(TYPE='L',amount,0.00))AS l_amount
			,SUM(IF(TYPE='LT',amount,0.00))AS lt_amount

			FROM
			(
			SELECT member_id,amount,'D' AS TYPE
			FROM samities LEFT JOIN saving_deposits ON saving_deposits.samity_id=samities.id
			WHERE samity_id=$samity_id
			AND is_authorized=0

			UNION ALL

			SELECT member_id,amount,'W' AS TYPE
			FROM samities LEFT JOIN saving_withdraws ON saving_withdraws.samity_id=samities.id
			WHERE samity_id=$samity_id
			AND is_authorized=0

			UNION ALL 

			SELECT member_id,amount,'SKT' AS TYPE
			FROM samities LEFT JOIN skt_collections ON skt_collections.samity_id=samities.id
			WHERE samity_id=$samity_id
			AND is_authorized=0

			UNION ALL

			SELECT member_id,loan_amount AS amount,'L' AS TYPE
			FROM samities LEFT JOIN loans ON loans.samity_id=samities.id
			WHERE samity_id=$samity_id
			AND is_authorized=0

			UNION ALL

			SELECT member_id,transaction_amount AS amount,'LT' AS TYPE
			FROM samities LEFT JOIN loan_transactions ON loan_transactions.samity_id=samities.id
			JOIN loans ON loan_transactions.loan_id=loans.id
			WHERE loan_transactions.samity_id=$samity_id
			AND loan_transactions.samity_id=$samity_id
			AND loan_transactions.is_authorized=0

			) AS X
			GROUP BY member_id";
		$query=$this->db->query($query);
		$query=$query->result();
		$member_list=array();
		$member_info=array();
		foreach($query as $row)
		{
			$member_list[]=$row->member_id;	
			$member_info[$row->member_id]->deposit_amount=$row->d_amount;
			$member_info[$row->member_id]->withdraw_amount=$row->w_amount;
			$member_info[$row->member_id]->skt_collection_amount=$row->skt_amount;
			$member_info[$row->member_id]->loan_amount=$row->l_amount;
			$member_info[$row->member_id]->loan_transaction_amount=$row->lt_amount;			
		}
		$member_list=join(',',$member_list);
		$member_query="SELECT id,name,code FROM members WHERE id IN ($member_list)";
		$member_query=$this->db->query($member_query);
		$member_query=$member_query->result();		
		//echo "<pre>";print_r($member_array);die;
		foreach($member_query as $row)
		{
			if (array_key_exists($row->id, $member_info)) {
				$member_info[$row->id]->name=$row->name;
				$member_info[$row->id]->code=$row->code;
			}
		}
		//echo "<pre>";print_r($member_info);
		return $member_info;
	}
	
	// authorization 
	/*function get_unauthorized_transaction_authorizations_list($offset,$limit,$cond=null)
    {
       	$this->db->select('members.id as member_id,members.code as member_code,members.name as member_name,samities.id as samity_id, 
				samities.code as samity_code,samities.name as samity_name,
				,saving_deposits.id as saving_deposits_id,saving_withdraws.id as saving_withdraws_id,
				skt_collections.id as skt_collection_id,loans.id as loan_id,
				sum(saving_deposits.amount) as saving_deposite_amount,
				sum(saving_withdraws.amount) as saving_withdraw_amount,
				sum(skt_collections.amount) as skt_collection_amouunt,
				sum(loans.total_payable_amount) as loan_amouunt');
		$this->db->from('members');			
		$this->db->join('samities', 'samities.id = members.samity_id');		
		$this->db->join('saving_deposits', 'saving_deposits.member_id = members.id','left');
		$this->db->join('saving_withdraws', 'saving_withdraws.member_id = members.id','left');
		$this->db->join('skt_collections', 'skt_collections.member_id = members.id','left');
		$this->db->join('loans', 'loans.member_id = members.id','left');
		$this->db->where(array('members.branch_id'=> $this->auth->get_branch_id()));
		$where = 'saving_deposits.is_authorized = 0 OR saving_withdraws.is_authorized = 0 OR loans.is_authorized = 0 OR skt_collections.is_authorized = 0 AND members.member_status <> "Inactive"';
		$this->db->where($where);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_deposits.samity_id', $cond['samity']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);
			}				
		}		
		$this->db->limit($offset, $limit);
		$this->db->order_by('members.registration_date','DSCE');
		$this->db->group_by('members.id','DSCE');
		$query = $this->db->get();
        return $query->result();
    }	*/
	function authorized($data)
	{	
		$this->db->trans_start();
			foreach($data as $data){				
				$this->db->query("UPDATE loan_transactions SET is_authorized='{$data['is_authorized']}' , authorized_by='{$data['authorized_by']}' ,authorization_date='{$data['authorization_date']}'  WHERE samity_id={$data['samity_id']} AND is_authorized=0");
				$this->db->query("UPDATE loans SET is_authorized='{$data['is_authorized']}' , authorized_by='{$data['authorized_by']}' ,authorization_date='{$data['authorization_date']}'  WHERE samity_id={$data['samity_id']} AND is_authorized=0");
				$this->db->query("UPDATE saving_deposits SET is_authorized='{$data['is_authorized']}' , authorized_by='{$data['authorized_by']}' ,authorization_date='{$data['authorization_date']}'  WHERE samity_id={$data['samity_id']} AND is_authorized=0");
				$this->db->query("UPDATE saving_withdraws SET is_authorized='{$data['is_authorized']}' , authorized_by='{$data['authorized_by']}' ,authorization_date='{$data['authorization_date']}'  WHERE samity_id={$data['samity_id']} AND is_authorized=0");
				$this->db->query("UPDATE skt_collections SET is_authorized='{$data['is_authorized']}' , authorized_by='{$data['authorized_by']}' ,authorization_date='{$data['authorization_date']}'  WHERE samity_id={$data['samity_id']} AND is_authorized=0");
			}	
		$this->db->trans_complete();	
		return $this->db->trans_status();		
	}
}
