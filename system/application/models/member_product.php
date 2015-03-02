<?php
class Member_product extends Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond='')
    {
       // search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				if(is_numeric($cond['name'])){	
					$this->db->or_where('members.code', $cond['name']);	
				} else {
					$this->db->like('members.name', $cond['name']);					
				}
			}			
			if(isset($cond['cbo_branch']) and !empty($cond['cbo_branch'])){	
				$this->db->where('member_products.branch_id', $cond['cbo_branch']);
				
			}			
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){	
				$this->db->where('member_products.samity_id', $cond['cbo_samity']);
				
			}
		}
		// end search	
        $this->db->select('old_product.name AS old_product_name,new_product.name AS new_product_name,members.name as member_name,members.code as member_code,member_products.*');
		$this->db->from('member_products');
		$this->db->join('members', 'member_products.member_id = members.id');
		$this->db->join('loan_products AS old_product', 'member_products.old_primary_product_id = old_product.id');
		$this->db->join('loan_products AS new_product', 'member_products.new_primary_product_id = new_product.id');
		$this->db->limit($offset,$limit);	
		$query = $this->db->get(); 		
		//echo "<pre>";print_r($query->result());die;
		return $query->result();
    }
	
	function row_count($cond='')
	{
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				if(is_numeric($cond['name'])){	
					$this->db->or_where('members.code', $cond['name']);	
				} else {
					$this->db->like('members.name', $cond['name']);					
				}
			}			
			if(isset($cond['cbo_branch']) and !empty($cond['cbo_branch'])){	
				$this->db->where('member_products.branch_id', $cond['cbo_branch']);
				
			}			
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){	
				$this->db->where('member_products.samity_id', $cond['cbo_samity']);
				
			}
		}
		// end search
		$this->db->join('members', 'member_products.member_id = members.id');
		$this->db->join('loan_products AS old_product', 'member_products.old_primary_product_id = old_product.id');
		$this->db->join('loan_products AS new_product', 'member_products.new_primary_product_id = new_product.id');
		return $this->db->count_all_results('member_products');
	}
	
    function add($data)
    {   
		if($this->db->insert('member_products', $data))
		{			
			$member['primary_product_id']=$data['new_primary_product_id'];
			$this->db->update('members',$member, array('id'=> $data['member_id']));
			return true;
		}
		else { return false; } 
    }

    function edit($data)
    {
        if($this->db->update('member_products', $data, array('id'=> $data['id'])))
		{
			$member['primary_product_id']=$data['new_primary_product_id'];
			$this->db->update('members',$member, array('id'=> $data['member_id']));
			return true;
		}
		else { return false; } 
    }
	
	function read($member_product_id)
    {
        $this->db->select('members.name as member_name,members.code as member_code,member_products.*');
		$this->db->from('member_products');
		$this->db->join('members', 'members.id = member_products.member_id');
		$this->db->join('loan_products', 'loan_products.id = member_products.new_primary_product_id');
		$this->db->where(array('member_products.id' =>$member_product_id));
		$query = $this->db->get(); 		
		return $query->result();
    }
	
	function soft_delete($data)
	{		
		
		$this->db->select('member_products.member_id,member_products.new_primary_product_id,member_products.old_primary_product_id');
		$this->db->from('member_products');	
		$this->db->where(array('member_products.id' =>$data['id']));
		$query = $this->db->get(); 		
		$query=$query->result();
		$member_id=$query[0]->member_id;
		$new_primary_product_id=$query[0]->new_primary_product_id;
		$old_primary_product_id=$query[0]->old_primary_product_id;
		
		$this->db->select('saving_transactions.*');
		$this->db->from('saving_transactions');	
		$this->db->join('savings', 'savings.id = saving_transactions.savings_id');
		$this->db->where(array('saving_transactions.member_primary_product_id' =>$new_primary_product_id,'savings.member_id'=>$member_id));
		$savings_transaction_query = $this->db->get(); 		
		$savings_transaction_data=$savings_transaction_query->result();
		
		if(empty($savings_transaction_data))
		{
			$member['primary_product_id']=$old_primary_product_id;
			if($this->db->update('members',$member, array('id'=> $member_id)))
			{
				return $this->db->delete('member_products', array('id'=> $data['id'])); 
			}			
		}
		else 
		{
			return false;
		}
	}
	
	/*function delete($member_product_id)
	{
		return $this->db->delete('member_products', array('id'=> $member_product_id));
	}*/
	
	//This function is for listing of departments
	function get_members()
	{		
		$member_info = $this->db->query("SELECT id as member_id,name as member_name FROM members ORDER BY member_name ASC");			
		return $member_info->result();  
	}
	function get_products()
	{		
		$product_info = $this->db->query("SELECT id as product_id,name as product_name FROM products ORDER BY product_name ASC");			
		return $product_info->result();  
	}

}
