<?php
/** 
	* PO Division Model Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\model\po_division.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_division
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Po_division extends MY_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc");
        $query = $this->db->get('po_divisions', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_divisions');
	}
	
	function add($data)
    {
		$data['id']=$this->get_new_id('po_divisions', 'id');
		return $this->db->insert('po_divisions', $data);
    }
    
    function edit($data)
    {
		return $this->db->update('po_divisions', $data, array('id'=> $data['id']));
    }
    
	function read($division_id)
    {
        $query=$this->db->getwhere('po_divisions', array('id' => $division_id));
		return $query->row();
    }
	
	function delete($division_id)
	{
		return $this->db->delete('po_divisions', array('id'=> $division_id));
	}
	
	function get_division_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_divisions');  
		return $query->result();
    }    
}
