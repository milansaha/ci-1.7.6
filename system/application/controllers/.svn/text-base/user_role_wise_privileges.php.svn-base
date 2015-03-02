<?php
/** 
	* PO Division Controller Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\controllers\user_roles_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.user_roles_controller
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class User_role_wise_privileges extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('User_role','',TRUE);
		$this->load->model('User_resource');			
		$this->load->model('User_role_wise_privilege','',TRUE);
	}

	function index($role_id)
	{
		//echo $role_id;
		$data['title']='User role wise privileges';
		$data['user_resources'] = $this->User_resource->get_all_resources();
		$data['role_privilege_resources'] = $this->User_role_wise_privilege->get_privileged_resources($role_id);
		//echo '<pre>';
		//print_r($data['user_resources']);
		//print_r($data['role_privilege_resources']);
		$data['role_id'] = $role_id;
		$data['role_name'] = $this->User_role_wise_privilege->get_by_role_name($role_id);
		
		//echo '<pre>';print_r($data);
		$this->layout->view('/user_role_wise_privileges/index',$data);
	}
	
	function add()
	{
		if($_POST)
		{
			//echo '<pre>';
			//print_r($_POST);
			//print_r($_POST['activity']);
			$data = $this->_get_posted_data();
			//$data = $_POST;
			//print_r($data);die;
			if($this->User_role_wise_privilege->add($data))
			{
				// delete session image data
				//$this->session->unset_userdata('txt_member_picture.file_name');
				//$this->session->unset_userdata('txt_nominee_picture.file_name');
				
				$this->session->set_flashdata('message','User Role Privilege information has been added successfully');
				redirect('/user_roles/');
			} 
		}
	}
	
	function _get_posted_data()
	{
		$data=array();
		$data['role_id']=$this->input->post('role_id');
		$data['role_name']=$this->input->post('role_name');
		$data['activity']=$this->input->post('activity');
		$data['controller']=$this->input->post('controller');
		$data['action']=$this->input->post('action');
		return $data;
	}
}
