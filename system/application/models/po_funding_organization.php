<?php
/** 
	* Po Funding Organization Model Class.
	* @pupose		Manage Po Funding Organization information
	*		
	* @filesource	./system/application/models/po_funding_organization.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_funding_organization
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_funding_organization extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->get('po_funding_organizations', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_funding_organizations');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('po_funding_organizations', 'id');
        return $this->db->insert('po_funding_organizations', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_funding_organizations', $data, array('id'=> $data['id']));
    }
	
	function read($po_funding_organization_id)
    {
        $query=$this->db->getwhere('po_funding_organizations', array('id' => $po_funding_organization_id));
		return $query->row();
    }
	
	function delete($po_funding_organization_id)
	{
		return $this->db->delete('po_funding_organizations', array('id'=> $po_funding_organization_id));
	}
	function get_funding_organization_list()
    {
        $loan_product_categories = $this->db->query("SELECT id,name FROM po_funding_organizations ORDER BY name;");		
		return $loan_product_categories->result();  
    }

}
