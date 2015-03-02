<?php
/** 
	* Loan Model Class. 
	* @pupose		Manage Loan schedule
	* 
	* @filesource	\app\model\loan_scheduler.php	
	* @package		microfin 
	* @subpackage	microfin.model.loan
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-04-05 $	 
*/
    
class Loan_reschedule extends MY_Model {

	
    function __construct()
    {
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {		
		

		$this->db->select('loan_reschedules.id, loan_reschedules.loan_id,loans.customized_loan_no, loan_reschedules.installment_no, loan_reschedules.reschedule_from, loan_reschedules.reschedule_to, members.name, loans.loan_amount, samities.code');
		$this->db->from('loan_reschedules');
		
		$this->db->join('loans', 'loan_reschedules.loan_id = loans.id');
		$this->db->join('members', 'loans.member_id = members.id');
		$this->db->join('samities', 'loans.samity_id = samities.id');
		$this->db->where(array('loans.branch_id'=> $this->auth->get_branch_id(),'loans.is_authorized'=>1,'loans.is_loan_fully_paid'=>0), $offset, $limit);
		
		$this->db->orderby('samities.code');
        $query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('loan_reschedules');				
	}
	
    function add($data)
    {
		$data['id'] = $this->get_new_id('loan_reschedules','id');
        return $this->db->insert('loan_reschedules', $data);
    }

    function edit($data)
    {
        return $this->db->update('loan_reschedules', $data, array('id'=> $data['id']));
    }
	
	function read($loan_reschedule_id)
    {
        $query=$this->db->getwhere('loan_reschedules', array('id' => $loan_reschedule_id));
		return $query->row();
    }
	
	function delete($loan_reschedule_id)
	{
		return $this->db->delete('loan_reschedules', array('id'=> $loan_reschedule_id));
	}
	
	function delete_by_loan_id_installment_no($loan_id, $installment_no)
	{
		$this->db->where('loan_id', $loan_id);
        $this->db->where('installment_no', $installment_no);
		return $this->db->delete('loan_reschedules');
	}
 
}
