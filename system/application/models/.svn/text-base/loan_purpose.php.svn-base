<?php
/** 
	* Loan Purpose Model Class.
	* @pupose		Manage Loan Purpose information
	*		
	* @filesource	./system/application/models/loan_purpose.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.loan_purpose
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Loan_purpose extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {		
        $query = $this->db->get('loan_purposes', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('loan_purposes');				
	}
	
    function add($data)
    {
		$data['id'] = $this->get_new_id('loan_purposes','id');
        return $this->db->insert('loan_purposes', $data);
    }

    function edit($data)
    {
        return $this->db->update('loan_purposes', $data, array('id'=> $data['id']));
    }
	
	function read($loan_purpose_id)
    {
        $query=$this->db->getwhere('loan_purposes', array('id' => $loan_purpose_id));
		return $query->row();
    }
	
	function delete($loan_purpose_id)
	{
		return $this->db->delete('loan_purposes', array('id'=> $loan_purpose_id));
	}
    function get_loan_purpose_list()
    {
        $query = $this->db->get('loan_purposes');
        return $query->result();
    }

}
