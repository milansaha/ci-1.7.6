<?php
/** 
	* Employee Designation Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/user_resource.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.Employee_designation
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-03-05 $	 
*/ 
class User_resource extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->select('user_resources.*, user_resource_groups.name as resource_group_name');
		$this->db->from('user_resources');
		$this->db->join('user_resource_groups', 'user_resources.user_resource_group_id = user_resource_groups.id');
		$this->db->order_by('resource_group_name, controller, action');
		$this->db->limit($offset,$limit);
		$query = $this->db->get();	
        return $query->result();
    }
    
    function get_all_resources()
    {
		$this->db->select('user_resources.*, user_resource_groups.name as resource_group_name');
		$this->db->from('user_resources');
		$this->db->join('user_resource_groups', 'user_resources.user_resource_group_id = user_resource_groups.id');
		$this->db->order_by('resource_group_name, controller, action');
		$query = $this->db->get();	
        return $query->result();
	}
	
	function row_count()
	{
		return $this->db->count_all_results('user_resources');
	}
	
    function add($data)
    {
		$actions=$data['action'];
		$actions=explode(',',$actions);
		$status=false;
		$title=$data['title'];
		foreach($actions as $action)
		{
			if(count($actions)>1){
				if($action=='index') $data['title']="View $title list";
				if($action=='add') $data['title']="Create new $title";
				if($action=='edit') $data['title']="Modify existing $title";
				if($action=='delete') $data['title']="Delete existing $title";
			}
			$data['id']=$this->get_new_id('user_resources', 'id');
			$data['action']=$action;
			$status=$this->db->insert('user_resources', $data);
		}
		return $status;
    }

    function edit($data)
    {
        return $this->db->update('user_resources', $data, array('id'=> $data['id']));
    }
	
	function read($id)
    {
        $query=$this->db->getwhere('user_resources', array('id' => $id));
		return $query->row();
    }
	
	function delete($id)
	{
		return $this->db->delete('user_resources', array('id'=> $id));
	}
	
	function get_resource_group_list()
	{
		$query = $this->db->get('user_resource_groups');
		$data=array();
		foreach($query->result() as $row)
		{
			$data[$row->id]=$row->name;
		}
		return $data;
	}
	
	function get_controller_list()
	{
		$controller_list=array(
			'users','user_roles','user_role_wise_privileges','user_audit_trails','user_access_logs','config_generals',
			'config_customized_ids','config_holidays','po_divisions','po_districts','po_designations','po_thanas','po_unions_or_wards','po_village_or_blocks',
			'po_working_areas','po_regions','po_areas','po_zones','po_branches','po_funding_organizations',
			'employees','employee_departments','employee_designations'
		);
		$data=array();
		foreach($controller_list as $row)
		{
			$data[$row]=$row;
		}
		return $data;
	}

}
