<?php
/** 
	* Saving_withdraw Model Class. 
	* @pupose		Manage Saving_withdraw information
	*		
	* @filesource	\app\model\po_saving.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_saving
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Saving_withdraw extends MY_Model {

    function Saving_withdraw()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    function get_list($offset,$limit,$cond=null)
    {
       	$this->db->select('savings.code as savings_code,members.id as member_id,members.code as member_code,members.name as member_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,saving_withdraws.*');
		$this->db->from('saving_withdraws');		
		$this->db->join('members', 'saving_withdraws.member_id = members.id');
		$this->db->join('savings', 'savings.member_id = members.id AND saving_withdraws.savings_id=savings.id');
		$this->db->join('samities', 'samities.id = members.samity_id');		
		$this->db->where(array('saving_withdraws.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));		
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_withdraws.samity_id', $cond['samity']);				
			}			
			if(isset($cond['transaction_date']) and !empty($cond['transaction_date'])){	
				$this->db->where('saving_withdraws.transaction_date', $cond['transaction_date']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);
			}				
		}	
		$this->db->limit($offset, $limit);
		$this->db->group_by('saving_withdraws.id');
		$this->db->order_by('saving_withdraws.transaction_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond=null)
	{				
		$this->db->join('members', 'saving_withdraws.member_id = members.id');
		$this->db->join('savings', 'savings.member_id = members.id AND saving_withdraws.savings_id=savings.id');
		$this->db->join('samities', 'samities.id = members.samity_id');			
		$this->db->where(array('saving_withdraws.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));		
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_withdraws.samity_id', $cond['samity']);				
			}			
			if(isset($cond['transaction_date']) and !empty($cond['transaction_date'])){	
				$this->db->where('saving_withdraws.transaction_date', $cond['transaction_date']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);
			}				
		}
		$this->db->group_by('saving_withdraws.id');
		return $this->db->count_all_results('saving_withdraws');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('saving_withdraws', 'id');
		return $this->db->insert('saving_withdraws', $data);
    }

    function edit($data)
    {
        return $this->db->update('saving_withdraws', $data, array('id'=> $data['id']));
    }
	
	function read($saving_id)
    {
        $query=$this->db->getwhere('saving_withdraws', array('id' => $saving_id));
		return $query->result();
    }
	
	function delete($saving_id)
	{
		return $this->db->delete('saving_withdraws', array('id'=> $saving_id));
	}	
	function get_saving_products_list()
    {		
		$saving_products = $this->db->query(" SELECT p.id,p.name
            FROM saving_products AS p 
            WHERE p.type='savings'");
		return $saving_products->result();  
    }	
	function get_member_info($member_id='-1')
    {			 
        $member_id = !is_numeric($member_id)?"-1":$member_id;
		$member_loan_info = $this->db->query("SELECT name,code,member_id,member_primary_product_id,
saving_withdraws.saving_products_id,saving_withdraws.branch_id,saving_withdraws.samity_id
FROM saving_withdraws JOIN members ON saving_withdraws.member_id=members.id WHERE saving_withdraws.member_id=$member_id GROUP BY saving_withdraws.member_id");			
		return $member_loan_info->result();
    }	
	//Savings withdraw authorization 
	function get_unauthorized_saving_withdraws_list($offset,$limit,$cond=null)
    {
       	$this->db->select('savings.code as savings_code,members.id as member_id,members.code as member_code,members.name as member_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,saving_withdraws.*');
		$this->db->from('saving_withdraws');			
		$this->db->join('members', 'saving_withdraws.member_id = members.id');
		$this->db->join('savings', 'savings.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');		
		$this->db->where(array('saving_withdraws.is_authorized' => 0,'saving_withdraws.branch_id'=> $this->auth->get_branch_id()));			
		$type = array('WIT');
		$this->db->where_in('saving_withdraws.transaction_type', $type);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_withdraws.samity_id', $cond['samity']);				
			}							
		}		
		$this->db->limit($offset, $limit);
		$this->db->group_by('saving_withdraws.id');
		$this->db->order_by('saving_withdraws.transaction_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	function get_unauthorized_saving_withdraws_list_row_count($cond=null)
    {
        $this->db->select('count(saving_withdraws.id) as id');
		$this->db->from('saving_withdraws');		
		$this->db->join('members', 'saving_withdraws.member_id = members.id');
		$this->db->join('savings', 'savings.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');		
		$this->db->where(array('saving_withdraws.is_authorized' => 0,'saving_withdraws.branch_id'=> $this->auth->get_branch_id()));			
		$type = array('WIT');
		$this->db->where_in('saving_withdraws.transaction_type', $type);
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('saving_withdraws.samity_id', $cond['samity']);				
			}						
		}			
		$this->db->group_by('saving_withdraws.id');
		$query = $this->db->get(); 
        $query=$query->result();
		if(!empty($query))
		{
			return $query[0]->id;    
		}
    }
    function authorized($data)
    { 		
		$flag=0;
		foreach($data as $data)
		{ 			
			$this->db->update('saving_withdraws', $data, array('id'=> $data['id']));  
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
