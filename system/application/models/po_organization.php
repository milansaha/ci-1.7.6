<?php
/** 
	* PO Organization Model Class.
	* @pupose		Manage PO Organization information
	*		
	* @filesource	./system/application/models/po_organization.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_organization
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-05 $	 
*/ 
class Po_organization extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->get('po_organizations', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_organizations');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('po_organizations', 'id');
        return $this->db->insert('po_organizations', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_organizations', $data, array('id'=> $data['id']));
    }
	
	function read($po_organization_id)
    {
        $query=$this->db->getwhere('po_organizations', array('id' => $po_organization_id));
		return $query->result();
    }
	
	function delete($po_organization_id)
	{
		return $this->db->delete('po_organizations', array('id'=> $po_organization_id));
	}

}
