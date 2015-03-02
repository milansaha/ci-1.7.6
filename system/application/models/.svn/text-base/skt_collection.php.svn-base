<?php
/** 
	* Skt_collection Model Class. 
	* @pupose		Manage Skt_collection information
	*		
	* @filesource	\app\model\skt_collection.php	
	* @package		microfin 
	* @subpackage	microfin.model.skt_collection
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-03-01 $	 
*/
    
class Skt_collection extends MY_Model {

    function Skt_collection()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    function get_list($offset,$limit,$cond=null)
    {
       	$this->db->select('members.id as member_id,members.code as member_code,members.name as member_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,skt_collections.*');
		$this->db->from('skt_collections');		
		$this->db->join('members', 'skt_collections.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->where(array('skt_collections.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));		
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('skt_collections.samity_id', $cond['samity']);				
			}			
			if(isset($cond['transaction_date']) and !empty($cond['transaction_date'])){	
				$this->db->where('skt_collections.transaction_date', $cond['transaction_date']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);
			}				
		}		
		$this->db->limit($offset, $limit);
		$this->db->order_by('skt_collections.transaction_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond=null)
	{		
		$this->db->join('members', 'skt_collections.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->where(array('skt_collections.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()));		
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('skt_collections.samity_id', $cond['samity']);				
			}
			if(isset($cond['transaction_date']) and !empty($cond['transaction_date'])){	
				$this->db->where('skt_collections.transaction_date', $cond['transaction_date']);				
			}
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);
			}				
		}			
		return $this->db->count_all_results('skt_collections');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('skt_collections', 'id');
		return $this->db->insert('skt_collections', $data);
    }

    function edit($data)
    {
        return $this->db->update('skt_collections', $data, array('id'=> $data['id']));
    }
	
	function read($saving_id)
    {
        $query=$this->db->getwhere('skt_collections', array('id' => $saving_id));
		return $query->result();
    }
		
	function delete($saving_id)
	{
		return $this->db->delete('skt_collections', array('id'=> $saving_id));
	}

	function get_products_list()
    {		
		$products = $this->db->query("SELECT p.id,p.name FROM products AS p WHERE p.type='savings'");
		return $products->result();  
    } 
	function get_member_info($member_id='-1')
    {			 
        $member_id = !is_numeric($member_id)?"-1":$member_id;
		$member_loan_info = $this->db->query("SELECT name,code,member_id,member_primary_product_id,skt_collections.branch_id,skt_collections.samity_id
FROM skt_collections JOIN members ON skt_collections.member_id=members.id WHERE skt_collections.member_id=$member_id GROUP BY skt_collections.member_id");			
		return $member_loan_info->result();
    } 
	
	//Savings deposited authorization 
	function get_unauthorized_skt_collections_list($offset,$limit,$cond=null)
    {
       	$this->db->select('members.id as member_id,members.code as member_code,members.name as member_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,skt_collections.*');
		$this->db->from('skt_collections');		
		$this->db->join('members', 'skt_collections.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->where(array('skt_collections.is_authorized' => 0,'skt_collections.branch_id'=> $this->auth->get_branch_id()));			
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('skt_collections.samity_id', $cond['samity']);				
			}							
		}		
		$this->db->limit($offset, $limit);
		$this->db->order_by('skt_collections.transaction_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	function get_unauthorized_skt_collections_list_row_count($cond=null)
    {
        $this->db->select('count(skt_collections.id) as id');
		$this->db->from('skt_collections');
		$this->db->join('members', 'skt_collections.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->where(array('skt_collections.is_authorized' => 0,'skt_collections.branch_id'=> $this->auth->get_branch_id()));			
		if(is_array($cond)){				
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('skt_collections.samity_id', $cond['samity']);				
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
			$this->db->update('skt_collections', $data, array('id'=> $data['id']));  
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
