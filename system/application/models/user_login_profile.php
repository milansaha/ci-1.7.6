<?php
/** 
	* Model Class for User login profile.
	* @pupose		Display profile of user login
	*		
	* @filesource	./system/application/models/User_audit_trail.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.User_audit_trail
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-03-07 $	 
*/ 
class User_login_profile extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->select('user_login_profiles.id,user_login_profiles.time_stamp,user_login_profiles.ip_address,user_login_profiles.user_agent,users.full_name as user_name, po_branches.name as branch_name');
		$this->db->from('user_login_profiles');
		$this->db->join('users','users.id=user_audit_trails.user_id','left');
		$this->db->join('po_branches','po_branches.id=user_audit_trails.branch_id','left');
		$this->db->order_by('time_stamp','desc');
		$this->db->limit($offset, $limit);
		
        $query = $this->db->get();
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('user_login_profiles');
	}
	
	function add($user_id,$branch_id,$ip_address,$user_agent,$is_auto_login)
	{
		$data=array('user_id'=>$user_id,'branch_id'=>$branch_id,'ip_address'=>$ip_address,'user_agent'=>$user_agent,'time_stamp'=>time(),'is_auto_login'=>$is_auto_login);
		return $this->db->insert('user_login_profiles', $data);
	}

}
