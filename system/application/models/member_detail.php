<?php
/** 
	* Member_detail Model Class. 
	* @pupose		Manage Member_detail information
	*		
	* @filesource	\app\model\po_member.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_member
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Member_detail extends Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $this->db->select('members.name, member_details.*');
		$this->db->from('member_details');
		$this->db->join('members', 'member_details.member_id = members.id');
		$this->db->where('member_details.is_deleted = 0');
		$query = $this->db->get();		
		return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('member_details');
	}
	
    function add($data)
    {
        return $this->db->insert('member_details', $data);
    }

    function edit($data)
    {
        return $this->db->update('member_details', $data, array('id'=> $data['id']));
    }
	
	function read($member_detail_id)
    {
        $query=$this->db->getwhere('member_details', array('id' => $member_detail_id));
		return $query->result();
    }
	
	function delete($member_detail_id)
	{
		return $this->db->delete('member_details', array('id'=> $member_detail_id));
	}

	function get_member_list()
    {
        $members = $this->db->query("SELECT id,name FROM members ORDER BY name ASC");			
		return $members->result();  
    }

	function get_working_area_list()
    {
        $working_areas = $this->db->query("SELECT id,name FROM po_working_areas ORDER BY name ASC");			
		return $working_areas->result();  
    }

}
	
