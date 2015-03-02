<?php
/** 
	* Loan Product Category Model Class. 
	* @pupose		Manage Loan Product Category information
	*		
	* @filesource	
	* @package		microfin 
	* @subpackage	microfin.model.loan_product_category
	* @version      $Revision: 1 $
	* @author       Anis Alamgir	
 	* @updated		Anis Alamgir
	* @lastmodified $Date: 2011-03-08 $	 
*/
    
class Loan_product_category extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->getwhere('loan_product_categories',null,$offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('loan_product_categories');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('loan_product_categories', 'id');
        return $this->db->insert('loan_product_categories', $data);
    }

    function edit($data)
    {
        return $this->db->update('loan_product_categories', $data, array('id'=> $data['id']));
    }
	
	function read($loan_product_category_id)
    {
        $query=$this->db->getwhere('loan_product_categories', array('id' => $loan_product_category_id));
		return $query->row();
    }
	
	function delete($loan_product_category_id)
	{
		return $this->db->delete('loan_product_categories', array('id'=> $loan_product_category_id));
	}
    
	function get_loan_product_category_list()
    {
        $loan_product_categories = $this->db->query("SELECT id,name,short_name FROM loan_product_categories ORDER BY short_name;");		
		return $loan_product_categories->result();  
    }
}
