<?php
/** 
	* PO Division Model Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\model\user_role.php	
	* @package		microfin 
	* @subpackage	microfin.model.user_role
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class User_role extends MY_Model {

	var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
		
		if(is_array($cond)){
			if(isset($cond['role_name']) and !empty($cond['role_name'])){					
				$this->db->like('user_roles.role_name',$cond['role_name']); 
				$this->db->or_like('user_roles.role_description',$cond['role_name']); 
			}	
		}
		
		$this->db->order_by('role_name','ASC');
        $query = $this->db->get('user_roles', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('user_roles');
	}
	
    function add($data)
    {
        return $this->db->insert('user_roles', $data);
    }

    function edit($data)
    {
        return $this->db->update('user_roles', $data, array('id'=> $data['id']));
    }
	
	function read($role_id)
    {
        $query=$this->db->getwhere('user_roles', array('id' => $role_id));
		return $query->row();
    }
	
	function delete($role_id)
	{
		return $this->db->delete('user_roles', array('id'=> $role_id));
	}
	
	// Added By Matin
	function read_user_branch_privileges($user_id)
    {		
        $query=$this->db->getwhere('user_branch_privileges', array('user_id' => $user_id));
		return $query->result();
    }
    // Added By Matin
	function clear_user_branch_privileges($user_id)
    {		
		return  $this->db->delete('user_branch_privileges', array('user_id'=> $user_id));      
    }
    // Added By Matin
	function add_user_branch_privileges($data)
    {		
		//print_r($data);die;
		//$this->db->delete('user_branch_privileges', array('user_id'=> $data['user_id']));       
		return  $this->db->insert('user_branch_privileges', $data);
    }
    
    // Added By Matin
	function is_valid_user($user_id)
    {	
		$query = $this->db->get_where('users', array('id' => $user_id));		
		return $query->result_array();
    }
}
