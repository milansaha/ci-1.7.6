<?php
/** 
        * Member Type Model Class.
        * @pupose               Manage Member Type information
        *               
        * @filesource   \app\model\member_type.php      
        * @package              microfin 
        * @subpackage   microfin.model.member_type
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam $       
        * @lastmodified $Date: 2011-01-04 $      
*/



class Member_type extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc");
        $query = $this->db->get('member_type', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('member_type');
	}
	
    function add($data)
    {
        return $this->db->insert('member_type', $data);
    }

    function edit($data)
    {
        return $this->db->update('member_type', $data, array('id'=> $data['id']));
    }
	
	function read($member_id)
    {
        $query=$this->db->getwhere('member_type', array('id' => $member_id));
		return $query->result();
    }
	
	function delete($member_id)
	{
		return $this->db->delete('member_type', array('id'=> $member_id));
	}

}
