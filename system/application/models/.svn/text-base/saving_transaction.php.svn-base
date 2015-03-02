<?php
/** 
	* Saving transaction Model Class. 
	* @pupose		Manage Saving_transaction information
	*		
	* @filesource	\app\model\po_saving.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_saving
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Saving_transaction extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
       	$this->db->select('savings.id as savings_id,saving_transactions.*');
		$this->db->from('saving_transactions');
		$this->db->join('savings', 'saving_transactions.savings_id = savings.id');
		$this->db->where('saving_transactions.is_deleted = 0');	
		$this->db->limit($offset, $limit);
		//$this->db->order_by('members.code','ASC');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('saving_transactions');
	}
	
    function add($data)
    {
        return $this->db->insert('saving_transactions', $data);
    }

    function edit($data)
    {
        return $this->db->update('saving_transactions', $data, array('id'=> $data['id']));
    }
	
	function read($saving_id)
    {
        $query=$this->db->getwhere('saving_transactions', array('id' => $saving_id));
		return $query->result();
    }
	
	function delete($saving_id)
	{
		return $this->db->delete('saving_transactions', array('id'=> $saving_id));
	}

	function get_savings_list()
    {
        $samities = $this->db->query("SELECT id FROM savings ORDER BY id ASC");			
		return $samities->result();  
    }
	function get_member_list()
    {
        $samities = $this->db->query("SELECT id,name FROM members ORDER BY name ASC");			
		return $samities->result();  
    }
	function get_savings_information($member_id = -1)
    {
        $member_id = empty($member_id)?"-1":$member_id;
		$savings_information = $this->db->query("SELECT s.id AS savings_id,s.code AS savings_code,p.short_name AS product_mnemonic
FROM savings AS s
INNER JOIN loan_products AS p ON (p.id = s.product_id)
WHERE s.member_id=$member_id AND s.is_deleted = 0");			
		return  $savings_information->result();  
    }
	
	function get_savings_information_by_saving_id($saving_id = -1)
    {
        $saving_id = empty($saving_id)?"-1":$saving_id;
		$savings_information = $this->db->query("SELECT s.weekly_savings AS weekly_savings
FROM savings AS s
WHERE s.id=$saving_id AND s.is_deleted = 0");			
		return  $savings_information->result();  
    }
	function get_member_id_by_saving_id($saving_id = -1)
    {
        $saving_id = empty($saving_id)?"-1":$saving_id;
		$member_information = $this->db->query("SELECT s.member_id AS member_id
FROM savings AS s
WHERE s.id=$saving_id");			
		return  $member_information->result();  
    }	
}
