<?php
/** 
        * Member Transfer Model Class.
        * @pupose               Manage Member Transfer information
        *               
        * @filesource   \app\model\member_discontinues.php      
        * @package              microfin 
        * @subpackage   microfin.model.member_discontinues
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam $       
        * @lastmodified $Date: 2011-01-04 $      
*/



class Member_discontinue extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
       // $query = $this->db->get('member_discontinues', $offset, $limit);
	$this->db->select('md.id,m.id AS member_id, m.name as member_name,md.discontinue_date');
		$this->db->from('member_discontinue as md');
		$this->db->join('members as m', 'm.id = md.member_id','left');
		$this->db->where(array('md.is_deleted' => 0), $offset, $limit);
		$query = $this->db->get(); 
        return $query->result(); 
    }
	
	function row_count()
	{
		return $this->db->count_all_results('member_discontinue');
	}
	
    function add($data)
    {
        return $this->db->insert('member_discontinue',$data);
    }

    function edit($data)
    {
        return $this->db->update('member_discontinue', $data, array('id'=> $data['id']));
    }
	
	function read($member_discontinue_id)
    {
        $query=$this->db->getwhere('member_discontinue', array('id' => $member_discontinue_id));
		return $query->result();
    }
	
	function delete($member_discontinue_id)
	{
		return $this->db->delete('member_discontinue', array('id'=> $member_discontinue_id));
	}

}
