<?php
/** 
	* PO Thana Model Class. 
	* @pupose		Manage po thana information
	*		
	* @filesource	\app\model\po_thana.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_thana
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Report_modeler extends MY_Model {

	var $member_list=array();
	var $samity_list=array();
	var $branch_id;
	var $samity_id;
	var $date_to;
	var $loan_list;
	var $loan_transaction_list;
	var $savings_account_list;
	var $savings_transaction_list;
	var $holiday_list;
	var $dubug=TRUE;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();               
    }
    
    //load data from database
    function load_data($branch_id,$date_to)
    {
		$this->branch_id=$branch_id;
        $this->date_to=$date_to;
        //Loading active samity list
        $this->_load_samity_list_for_this_branch();
		//loading active member list
		$this->_load_member_list_for_this_branch();
		//loading saveing transactions
		$this->_load_savings_transaction_list();
		return true;
	}
	
	function _load_samity_list_for_this_branch()
    {
        $this->db->select('branch_id,samity_type,product_id,opening_date,status');
		$this->db->from('samities');
		$this->db->where('branch_id', $this->branch_id);
		$query = $this->db->get();
        $result=$query->result_array();
        $this->_debug("Query: ".$this->db->last_query()." Having: ".$query->num_rows()."rows");
        foreach($result as $member)
        {
			$this->member_list[$member['id']]=$member;
		}
		$this->_debug("Total Member = ".count($this->member_list));
        //deal with member transfer
        //deal with primary product transfer
        return true;
	}
	
    
    function _load_member_list_for_this_branch()
    {
        $this->db->select('id,branch_id,samity_id,gender,primary_product_id,member_status,registration_date,cancel_date');
		$this->db->from('members');
		$this->db->where('branch_id', $this->branch_id);
		$query = $this->db->get();
        $result=$query->result_array();
        $this->_debug("Query: ".$this->db->last_query()." Having: ".$query->num_rows()."rows");
        foreach($result as $member)
        {
			$this->member_list[$member['id']]=$member;
		}
		$this->_debug("Total Member = ".count($this->member_list));
        //deal with member transfer
        //deal with primary product transfer
        return true;
	}
	
	function _load_savings_transaction_list(){
		$member_id_list=array_keys($this->member_list);
		$member_id_list=implode(",", $member_id_list);
		$this->db->query("SELECT id, name from members where id in($member_id_list)");
		//$this->_debug("Query: ".$this->db->last_query());
		return true;
	}
	
	//if we want to set the data manually
	function set_data($member_list,$holiday_list,$loan_transaction_list,$savings_transaction_list)
	{
		$this->member_list=$member_list;
		$this->holiday_list=$holiday_list;
		$this->loan_transaction_list=$loan_transaction_list;
		$this->savings_transaction_list=$savings_transaction_list;
		
	}
	
	function _debug($message)
	{
		echo "$message <br/>";
	}
}
