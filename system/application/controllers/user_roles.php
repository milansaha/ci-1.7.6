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
	
class User_roles extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('User_role','',TRUE);		
		$this->load->model('User_role_wise_privilege','',TRUE);		
		$this->load->model('Po_branch','',TRUE); 
	}

	function index()
	{
		
		$cond= "";
		$session_data = $this->session->userdata('user_role.index');
		if(isset($_POST['txt_name'])){
			$cond['role_name'] = $_POST['txt_name'];			
			
			$sessionArray = array( 'user.index'=>array(
												'name'=>$cond['role_name']																								
												));
			$this->session->unset_userdata('user_role.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['role_name'] = $session_data['role_name'];			
		} else {
			$this->session->unset_userdata('user_role.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->User_role->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/user_roles/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['user_roles']=$this->User_role->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
        $data['title']='Manage User Role';
        $data['headline'] = 'User\'s Role Information';
		$this->layout->view('/user_roles/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//The first param->Table Name, 2nd Param: id field
				$data['id'] = $this->User_role->get_new_id('user_roles', 'id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->User_role->add($data))
				{
					$this->session->set_flashdata('success','User Role has been added successfully');
					redirect('/user_roles/add/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add User Role';
        $data['headline']='Add User Role';
		$this->layout->view('/user_roles/add',$data);				
	}	
	
	function edit($role_id=null)
	{
		//If ID is not provided, redirecting to index page
		if(empty($role_id) && !$_POST)
		{
			$this->session->set_flashdata('error','User Role ID is not provided');
			redirect('/user_roles/index/');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$role_id=$_POST['role_id'];
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{				
				$data=$this->_get_posted_data();
				//Validation is OK. So, add this data and redirect to the index page
				if($this->User_role->edit($data))
				{
					$this->session->set_flashdata('success','User Role has been updated successfully');
					redirect('/user_roles/index/');
				}
			}
		}
		//Load data from database
		$data['row']=$this->User_role->read($role_id);
		$data['title']='Edit User Role';
        $data['headline']='Edit User Role';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('/user_roles/edit',$data);		
	}
	
	function delete($role_id=null)
	{
         if(empty($role_id))
		{
			$this->session->set_flashdata('warning','User Role ID is not provided');
			redirect('/user_roles/index/');
		}
		if($this->User_role->delete($role_id))
		{
			$this->session->set_flashdata('message','User Role has been deleted successfully');
			redirect('/user_roles/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		$data['id']=$this->input->post('role_id');
		$data['role_name']=$this->input->post('txt_role_name');
		$data['role_description']=$this->input->post('txt_role_description');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_role_name','Name','required|trim|max_length[100]');
	}
	
	function __get_posted_data()
	{
		$data=array();
		$data['id']=$this->input->post('role_id');
		$data['role_name']=$this->input->post('txt_role_name');
		$data['role_description']=$this->input->post('txt_role_description');		
		return $data;
	}
	
	function __update_by_controller_action($controller,$action)
	{
		$val_controller=$this->Perm_controller->read_by_controller($controller);
		if(empty($val_controller)){
			$this->Perm_controller->add(array('controller'=>$controller,'controller_alias'=>$controller));
		}
		$val_controller=$this->Perm_controller->read_by_controller($controller);
		$val_action=$this->Perm_action->read_by_controller_id_action($val_controller[0]['id'],$action);		
		if(empty($val_action)){
			$this->Perm_action->add(array('controller_id'=>$val_controller[0]['id'],'action'=>$action,'action_alias'=>$action));
		}
		$val_action=$this->Perm_action->read_by_controller_id_action($val_controller[0]['id'],$action);
		$controller_action_ids="";
		
		$controller_action_ids['controller_id']=$val_controller[0]['id'];
		$controller_action_ids['action_id']=$val_action[0]['id'];
		return $controller_action_ids;
	}
	function __truncate_controller_action(){
		
		$this->Perm_action->truncate();
		$this->Perm_controller->truncate();
	}
	
	function __get_all_controller_action()
	{
		$controllers=$this->Perm_controller->get_list_all();
		foreach($controllers as $key=>$controller){
			$actions=$this->Perm_action->read_by_controller_id($controller['id']);
			$controllers[$key]['actions']=$actions;
		}
		
		return $controllers;
	}
	
	
	function __prepare_role_wise_privilege_data($reload=true,$truncate=false){
		
		$output_array=array();
		
		$controller_dir="./system/application/controllers/";
		if($reload){
			
			$controller_action_ids_array=array();
			
			if($truncate){
				$this->truncate_controller_action();
			}
			
			$dir=scandir($controller_dir);
			foreach($dir as $file) {
				$curr_controller_file=$controller_dir.$file;
				if ($file != "." && $file != ".."&& $file != ".svn" && is_file($curr_controller_file)) {
					//echo "$file\n";
					$lines=file($curr_controller_file);
					$class_matches=array();
					$controller_match="";
					foreach($lines as $line){
						$funtion_matches=array();
						if(empty($class_matches)){
							preg_match ( "/^[\s]*class[\s]+[a-zA-Z]+[_a-zA-Z0-9-]*/" , $line , $class_matches);
							if(!empty($class_matches)){
								$controller_match=trim(substr($class_matches[0],strpos($class_matches[0],'class')+6));
							}
						}
						preg_match ( "/^[\s]*function[\s]+ajax[_a-zA-Z0-9-]*/" , $line , $funtion_matches);
						if(empty($funtion_matches)){
							preg_match ( "/^[\s]*function[\s]+[a-zA-Z]+[_a-zA-Z0-9-]*/" , $line , $funtion_matches);
						}
						else{
							$funtion_matches=array();
						}
						if(!empty($funtion_matches)){
						
							    $funtion_match=trim(substr($funtion_matches[0],strpos($funtion_matches[0],'funtion')+9));
								if(strcmp($controller_match,$funtion_match)!=0){
									
									$controller_action_ids=$this->__update_by_controller_action($controller_match,$funtion_match);
									array_push($controller_action_ids_array,$controller_action_ids);									
								}
							
						}
					}
				}
			}
			
			$controller_not_delete_ids="";
			$action_not_delete_ids="";
			
			foreach($controller_action_ids_array as $controller_action_ids_val){
				$action_not_delete_ids=$action_not_delete_ids.$controller_action_ids_val['action_id'].",";
				$controller_not_delete_ids=$controller_not_delete_ids.$controller_action_ids_val['controller_id'].",";
			}
			
			if(!empty($action_not_delete_ids)){
				$action_not_delete_ids=substr($action_not_delete_ids,0,strrpos($action_not_delete_ids,','));
				$this->Perm_action->delete_by_ids($action_not_delete_ids);
			}
			if(!empty($controller_not_delete_ids)){
				$controller_not_delete_ids=substr($controller_not_delete_ids,0,strrpos($controller_not_delete_ids,','));
				$this->Perm_controller->delete_by_controller_ids($controller_not_delete_ids);
			}
		}
		
		$output_array=$this->__get_all_controller_action();
		
		return $output_array;
	}
	
	
	function permissions($role_id=null,$reload=true,$truncate=false)
	{
		
		
		if($_POST){
			$roles=array();
			
			if(empty($role_id)){
				$roles=$this->User_role->get_list_all();
			}
			else{
				$roles=$this->User_role->read($role_id);
				$temp_role=(array) $roles[0];
				$roles=array();
				$roles[0]=$temp_role;
			}
			$controller_actions = $this->__prepare_role_wise_privilege_data($reload,$truncate);
			
			foreach ($roles as $role){
				$this->User_role_wise_privilege->delete_by_role_id($role['id']);
			}
			
			foreach($controller_actions as $controller_action_key=>$controller_action){
				foreach($controller_action['actions'] as $action_key=>$action_val){
					foreach($roles as $role){
					
						//print_r($this->input->post($role['id'].":".$row_key.":".$value));
						$post_data=$this->input->post($role['id'].":".$controller_action['controller'].":".$action_val['action']);
						if(!empty($post_data)){
							
							$temp_role_id=substr($post_data,0,strpos($post_data,":"));
							$temp_controller=substr($post_data,strpos($post_data,":")+1);
							$temp_controller=substr($temp_controller,0,strpos($temp_controller,":"));
							$temp_action=substr($post_data,strrpos($post_data,":")+1);
							$insert_data=array('role_id'=>$temp_role_id,'controller'=>$temp_controller,'action'=>$temp_action);
							
							$this->User_role_wise_privilege->add($insert_data);
							
						}
					}
				}
			}
			
			
			if(!empty($role_id)){
				redirect('/user_roles/permissions/'.$role_id, 'refresh');
			}
			else{
				redirect('/user_roles/permissions/', 'refresh');
			}
		}
		
		$controller_actions = $this->__prepare_role_wise_privilege_data($reload,$truncate);
		$roles=array();
		if(empty($role_id)){
			$roles=$this->User_role->get_list_all();
		}
		else{
			$roles=$this->User_role->read($role_id);
			if(empty($roles)){
				redirect('/user_roles/permissions/', 'refresh');
			}
			$temp_role=(array) $roles[0];
			$roles=array();
			$roles[0]=$temp_role;
		}
		$data['roles']=$roles;
		
		foreach($controller_actions as $controller_action_key=>$controller_action){
			foreach($controller_action['actions'] as $action_key=>$action){
				foreach($roles as $role){
					$user_prev=$this->User_role_wise_privilege->get_by_controller_action_role($controller_action['controller'],$action['action'],$role['id']);
					$new_role=$role;
					
					if(empty($user_prev)){
						$new_role['checked']=FALSE;
					}
					else{
						$new_role['checked']=TRUE;
					}
					if(empty($controller_actions[$controller_action_key]['actions'][$action_key]['roles'])){
						$controller_actions[$controller_action_key]['actions'][$action_key]['roles']=array();
					}
					array_push($controller_actions[$controller_action_key]['actions'][$action_key]['roles'],$new_role);
					
				}
			}
		}
		
		if(!empty($role_id)){
			$data['single_role_id']=$role_id;
		}
		else{
			$data['single_role_id']=-1;
		}
		$data['permissions']=$controller_actions;
		
		
		$this->layout->view('/user_roles/permissions',$data);
		
	}
	
	function access_denied(){
		$data['url']=$this->session->userdata('url');
		
		$this->layout->view('/user_roles/access_denied',$data);
	}
	
	//Added By Matin
	function user_wise_branch_access($user_id=null)
	{
		if(empty($user_id) && !$_POST)
		{
			$this->session->set_flashdata('error','User ID is not provided');
			redirect('/users/index/');
		}
		
		if($_POST)
		{
			$branches = $this->Po_branch->get_branches_info();
			$posted_user_id = $this->input->post('user_id');
			$user_info = $this->User_role->is_valid_user($posted_user_id);
			//print_r($user_info);die;
			if(!empty($user_info))
			{
				$this->User_role->clear_user_branch_privileges($posted_user_id);
				foreach($branches as $branches)
				{
					$post_data=$this->input->post($branches->branch_id);
					if(!empty($post_data))
					{
						$insert_data=array('user_id'=>$posted_user_id,'branch_id'=>$post_data);						
						$this->User_role->add_user_branch_privileges($insert_data);						
					}						
				}
				$this->session->set_flashdata('message','Userwise Branch Privilege is set for '.'[' . $user_info[0]['full_name'] . ']');
				redirect('/users/index/');
			}
			else
			{
				$this->session->set_flashdata('error','Provided User ID is not valid');
				redirect('/users/index/');			
			}
			
		}
		//Load data from database
		$row=$this->User_role->read_user_branch_privileges($user_id);
		
		if(!empty($row))
		{
			foreach($row as $branch_row)
			{
				$checked_branch[$branch_row->branch_id] = $branch_row->branch_id;			
			}
			
			$data['checked_branch'] = $checked_branch;
			//print_r($data['checked_branch']);die;
			$data['row']=$row[0];
		}
		$data['user_id']=$user_id;
		$data['branches'] = $this->Po_branch->get_branches_info();
		$data['title'] = 'User Wise Branch Access';
		$this->layout->view('user_roles/user_wise_branch_access',$data);
	}
}
