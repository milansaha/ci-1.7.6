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
class User_role_wise_privilege extends Model {

	var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->get('user_role_wise_privileges', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('user_role_wise_privileges');
	}
	
    function add($data)
    {
		$role_privilege = array();
		$role_id = $data['role_id'];
		$i = 0;
		$del = $this->db->delete('user_role_wise_privileges', array('role_id' => $role_id));
		if($del)
		{
			if(!empty($data['activity']))
			{
				foreach($data['activity'] as $d)
				{
					foreach($d as $dd)
					{
						$role_privilege[$i]['controller'] = '';
						$role_privilege[$i]['action'] = '';
						$role_privilege[$i]['role_id'] = $role_id;
						$role_privilege[$i]['resource_id'] = $dd;
						$i++;
					}
				}
				foreach($role_privilege as $rp)
				{
					$this->db->insert('user_role_wise_privileges', $rp);
				}
			}/*else{echo'sorry';die;}*/
		}
        //return $this->db->insert('user_role_wise_privileges', $role_privilege);
        return true;
    }

    function edit($data)
    {
        return $this->db->update('user_role_wise_privileges', $data, array('id'=> $data['id']));
    }
	
	function read($user_role_wise_privileges_id)
    {
        $query=$this->db->getwhere('user_role_wise_privileges', array('id' => $user_role_wise_privileges_id));
		return $query->result();
    }
    
    function get_by_role_id($role_id)
    {
        $query=$this->db->getwhere('user_role_wise_privileges', array('role_id' => $role_id));
		return $query->result_array();
    }
    
	function get_by_role_name($role_id)
    {
        $query=$this->db->getwhere('user_roles', array('id' => $role_id));
		return $query->result_array();
    }
    
    function get_by_role_id_controller_action($role_id, $controller, $action)
    {
        $query=$this->db->getwhere('user_role_wise_privileges', array('role_id' => $role_id,'controller'=>$controller,'action'=>$action));
		return $query->result_array();
    }
    
    function get_by_controller_action( $controller, $action)
    {
        $query=$this->db->getwhere('user_role_wise_privileges', array('controller'=>$controller,'action'=>$action));
		return $query->result_array();
    }
    
    function get_by_controller_action_role( $controller, $action,$role_id)
    {
        $query=$this->db->getwhere('user_role_wise_privileges', array('controller'=>$controller,'action'=>$action,'role_id'=>$role_id));
		return $query->result_array();
    }
	
	function get_privileged_resources($role_id)
    {
        $query=$this->db->getwhere('user_role_wise_privileges', array('role_id'=>$role_id));
		return $query->result_array();
    }
	
	function delete($user_role_wise_privileges_id)
	{
		return $this->db->delete('user_role_wise_privileges', array('id'=> $user_role_wise_privileges_id));
	}
	
	function delete_by_role_id_controller_action($role_id, $controller, $action)
	{
		return $this->db->delete('user_role_wise_privileges', array('role_id' => $role_id,'controller'=>$controller,'action'=>$action));
	}
	
	function delete_by_role_id($role_id)
	{
		return $this->db->delete('user_role_wise_privileges', array('role_id' => $role_id));
	}
	
	function check_permission( $role_id,$controller, $action){
		$controller=strtolower($controller);
		$action=strtolower($action);
		
		if($this->_is_globally_allowed_action($controller,$action)){ //if action is globally allowed, access is granted
			return true;
		}else{
			$controller=ucfirst($controller);
			$this->db->select('user_resources.id');
			$this->db->from('user_role_wise_privileges');
			$this->db->join('user_resources','user_role_wise_privileges.resource_id=user_resources.id');
			$this->db->where(array('user_role_wise_privileges.role_id'=>$role_id,'user_resources.controller'=>$controller,'user_resources.action'=>$action));				
			$query = $this->db->get();
			//echo $this->db->last_query();
			if($query->num_rows()>0){
				return true;
			}
			return false;
		}
	}
	
	function _is_globally_allowed_action($controller, $action)
	{
		//if ajax method then allow the method
		if(strcasecmp(substr($action,0,5),"ajax_")==0)
			return TRUE;
		//echo $controller.' '.$action;
		$actions=array(
				'pages'=>'access_denied',
				'pages'=>'enable_javascript',
				'pages'=>'no_data_found',
				'pages'=>'404',
				'pages'=>'index',
				'users'=>'change_password',
				'auths'=>'login',
				'auths'=>'logout',
				'user_roles'=>'access_denied'
			);
		if(isset($actions[$controller][$action]))
			return TRUE;
		else
			return FALSE;
	}
	
}
