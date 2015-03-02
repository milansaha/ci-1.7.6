<?php
/** 
	* Saving Model Class. 
	* @pupose		Manage Saving information
	*		
	* @filesource	\app\model\po_saving.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_saving
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Saving extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond=null)
    {
       	if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){					
				$where = "( savings.code LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);				
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('members.samity_id', $cond['samity']);								
			}				
		}	
		$this->db->select('members.id as member_id,members.code as member_code,members.name as member_name,saving_products.name as product_name,samities.id as samity_id, samities.code as samity_code,samities.name as samity_name,savings.*');
		$this->db->from('savings');		
		$this->db->join('members', 'savings.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->join('saving_products', 'savings.saving_products_id = saving_products.id');		
		$this->db->where(array('savings.branch_id'=> $this->auth->get_branch_id(),'members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id()), $offset, $limit);		
		$this->db->limit($offset, $limit);
		$this->db->order_by('savings.opening_date','DSCE');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond=null)
	{		
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){					
				$where ="( savings.code LIKE '%{$cond['name']}%' OR  members.code LIKE '%{$cond['name']}%' OR samities.code LIKE '%{$cond['name']}%' ) ";
				$this->db->where($where);				
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('members.samity_id', $cond['samity']);				
			}				
		}
		$this->db->join('members', 'savings.member_id = members.id');
		$this->db->join('samities', 'samities.id = members.samity_id');
		$this->db->join('saving_products', 'savings.saving_products_id = saving_products.id');		
		$this->db->where(array('members.branch_id'=> $this->auth->get_branch_id(),'samities.branch_id'=> $this->auth->get_branch_id(),'savings.branch_id'=> $this->auth->get_branch_id()));			
		return $this->db->count_all_results('savings');
	}
	
    function add($data)
    {
         $data['id']=$this->get_new_id('savings', 'id');
		return $this->db->insert('savings', $data);
    }

    function edit($data)
    {
        return $this->db->update('savings', $data, array('id'=> $data['id']));
    }
	
	function read($saving_id)
    {
        $query=$this->db->getwhere('savings', array('id' => $saving_id));
		return $query->result();
    }
    /*
     * @Modified By: Matin
     */
    function delete($saving_id)
	{
		return $this->db->delete('savings', array('id'=> $saving_id));
	}
	

	/*function get_branch_list()
    {
        $branches = $this->db->query("SELECT id,name FROM po_branches ORDER BY name ASC");			
		return $branches->result();  
    }

	function get_samity_list()
    {
        $samities = $this->db->query("SELECT id,name FROM samities ORDER BY name ASC");			
		return $samities->result();  
    }
	
	function get_member_list()
    {
        $groups = $this->db->query("SELECT id,name FROM members ORDER BY name ASC");			
		return $groups->result();  
    }*/

	/*function get_saving_products_list()
    {
        $sub_groups = $this->db->query("SELECT id,concat(mnemonic,' - ',name) as name FROM saving_products where type = 'SAVINGS' ORDER BY name ASC");			
		return $sub_groups->result();  
    }*/
	/*function get_saving_products_list($member_id=null)
    {
		$member_id = !is_numeric($member_id)?"-1":$member_id;
		$sub_groups = $this->db->query(" SELECT p.id,p.name
            FROM saving_products AS p 
            WHERE TYPE='savings'            
            AND p.id NOT IN (SELECT saving_products_id FROM savings WHERE member_id=$member_id)");
		return $sub_groups->result();  
    }
	*/
    function get_saving_products_list($member_id=null)
    {
		$member_id = !is_numeric($member_id)?"-1":$member_id;
		$sub_groups = $this->db->query(" SELECT sp.id,sp.name
            FROM saving_products AS sp 
            WHERE sp.id NOT IN (SELECT saving_products_id FROM savings WHERE member_id=$member_id)");
		return $sub_groups->result();  
    }	
    
    function get_member_info($member_id='-1')
    {			 
        $member_id = !is_numeric($member_id)?"-1":$member_id;
		$member_loan_info = $this->db->query("SELECT id,name,code,branch_id,samity_id FROM members where id =$member_id");			
		return $member_loan_info->result();
    }	
	function get_savings_code($code=null)
    {
        $code = $this->db->query("SELECT code from savings where code='$code'");			
		$code=$code->result();
		if(!empty($code))
		{ 
			return $code[0]->code;
		}
		else 
		{  
			return $code="";
		}  
    }
	/*function get_member_savings_product_list($member_id=null)
    {
		$member_id = !is_numeric($member_id)?"-1":$member_id;
		$sub_groups = $this->db->query("SELECT saving_products_id,name,savings.code FROM savings JOIN saving_products ON  saving_products.id=savings.saving_products_id WHERE member_id=$member_id GROUP BY saving_products_id");
		return $sub_groups->result();  
    }
	/*function get_member_savings_id($member_id=null,$saving_products_id=null)
    {
		$member_id = !is_numeric($member_id)?"-1":$member_id;
		$saving_products_id = !is_numeric($saving_products_id)?"-1":$saving_products_id;
		$savings_id = $this->db->query("SELECT id,weekly_savings FROM savings WHERE member_id=$member_id and saving_products_id=$saving_products_id");
		$savings_id=$savings_id->result();
		//echo "<pre>";print($savings_id[0]->id);die;
		return $savings_id;  
    }*/
/*	function get_member_savings_code_list($member_id=null)
    {
		$member_id = !is_numeric($member_id)?"-1":$member_id;
		$sub_groups = $this->db->query("SELECT savings.id,savings.code,saving_products.mnemonic FROM savings join saving_products on savings.saving_products_id=saving_products.id WHERE member_id=$member_id GROUP BY id,savings.code,saving_products.mnemonic");
		return $sub_groups->result();  
    } */

	// This is modified by Liton for replacing product table by saving_products
    function get_member_savings_code_list($member_id=null)
    {
		$member_id = !is_numeric($member_id)?"-1":$member_id;
		$sub_groups = $this->db->query("SELECT savings.id,savings.code,saving_products.short_name FROM savings join saving_products on savings.saving_products_id=saving_products.id WHERE member_id=$member_id GROUP BY id,savings.code,saving_products.short_name");
		return $sub_groups->result();  
    } 
	function get_member_savings_product_info($savings_id=null)
    {		
		$savings_id = $this->db->query("SELECT saving_products_id,weekly_savings FROM savings WHERE id=$savings_id");
		$savings_id=$savings_id->result();
		//echo "<pre>";print($savings_id[0]->id);die;
		return $savings_id;  
    }
	function get_savings_opening_date($member_id=null,$saving_products_id=null)
	{		
		if(!is_numeric($member_id)) {
			return false;
		}
		$date = $this->db->query("SELECT opening_date FROM savings WHERE member_id=$member_id and saving_products_id=$saving_products_id");		
		$date=$date->row();
		if(!empty($date))
		{ 	return $date->opening_date; } 
    }
	function get_savings_product_info($product_id=null)
    {		
		$product_info = $this->db->query("SELECT type_of_deposit,mandatory_amount_for_deposit,interest_rate,short_name FROM saving_products WHERE id=$product_id");
		$product_info=$product_info->result();
		//echo "<pre>";print($savings_id[0]->id);die;
		return $product_info;  
    }
	function get_member_code($member_id=null)
    {		
		$member_info = $this->db->query("SELECT code FROM members WHERE id=$member_id");
		$member_info=$member_info->result();			
		return $member_info[0]->code;  
    }
}
