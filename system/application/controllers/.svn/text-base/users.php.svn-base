<?php
/** 
	* PO Division Controller Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\controllers\users_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.users_controller
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Users extends MY_Controller {
	
	var $password_secret_phrase='this_is_a_secret_word';
	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('User','Po_branch'));
		$this->load->library('encrypt');
	}

	function index()
	{		
		$data = $this->_load_combo_data();
		
		$cond= "";
		$session_data = $this->session->userdata('user.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_user_role']) || isset($_POST['cbo_user_branch'])|| isset($_POST['cbo_user_status'])){
			
			$cond['name'] = $_POST['txt_name'];
			$cond['user_role'] = $_POST['cbo_user_role'];
			$cond['user_branch'] = $_POST['cbo_user_branch'];
			$cond['user_status'] = $_POST['cbo_user_status'];
			
			$sessionArray = array( 'user.index'=>array(
												'name'=>$cond['name'],
												'user_role'=>$cond['user_role'],
												'user_branch'=>$cond['user_branch'],
												'user_status'=>$cond['user_status']												
												));
			$this->session->unset_userdata('user.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {			
            if(isset ($session_data['name'])){$cond['name'] = $session_data['name'];}
			if(isset ($session_data['user_role'])){$cond['user_role'] = $session_data['user_role'];}
			if(isset ($session_data['user_branch'])){$cond['user_branch'] = $session_data['user_branch'];}
			if(isset ($session_data['user_status'])){$cond['user_status'] = $session_data['user_status'];}
		} else {
			$this->session->unset_userdata('user.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->User->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/users/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['users']=$this->User->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['title']='Manage User';
		$this->layout->view('/users/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			$data['created_by']=$this->get_user_id();
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				
				if($this->User->add($data))
				{
					$this->session->set_flashdata('message','User has been added successfully');
					redirect('/users/add/');
				}
			}
		}
		
		$data['user_roles'] = $this->User->get_user_role_list();
		$data['user_default_branches'] = $this->Po_branch->get_branches_info();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add User';
        $data['headline']='Add User';
		$this->layout->view('/users/add',$data);				
	}	
	
	function edit($user_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($user_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','User ID is not provided');
			redirect('/users/index/');
		}
		
		if($_POST)
		{
			$this->_prepare_validation();
			$user_id=$this->input->post('user_id');
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['modified_by']=$this->get_user_id();
				//Validation is OK. So, add this data and redirect to the index page
				if($this->User->edit($data,$this->encrypt->sha1($this->password_secret_phrase)))
				{
					$this->session->set_flashdata('success','User has been updated successfully');
					redirect('/users/index/');
				}
			}
		}
		//Load data from database
		$data['user_roles'] = $this->User->get_user_role_list();
		$data['user_default_branches'] = $this->Po_branch->get_branches_info();
		$user=$this->User->read($user_id);
		$user->password=$this->password_secret_phrase;
		$data['row']=$user;
		$data['title']='Edit User';
        $data['headline']='Edit User';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('/users/edit',$data);		
	}
	
	function delete($user_id=null)
	{
        $user=$this->session->userdata('system.user');

        if(empty($user_id))
		{
			$this->session->set_flashdata('warning','User ID is not provided');
			redirect('/users/index/');
		}
        //print_r($user);die;
        if(!empty($user_id) && $user_id == $user['id'])
        {
           $this->session->set_flashdata('warning','You can not delete yourself');
            redirect('/users/index/');
        }
        
		if($this->User->delete($user_id))
		{
			$this->session->set_flashdata('success','User has been deleted successfully');
			redirect('/users/index/');
		}
        
	}
	function _get_posted_data()
	{
		$data=array();
		$data['id']=$this->input->post('user_id');
		$data['full_name']=$this->input->post('txt_full_name');
		$data['login']=$this->input->post('txt_login');
		$data['password']=$this->encrypt->sha1($this->input->post('txt_password'));
		$data['role_id']=$this->input->post('cbo_role_id');
		$data['default_branch_id']=$this->input->post('cbo_default_branch_id');	
		$data['current_status']=$this->input->post('cbo_current_status');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_full_name','Full Name','required|trim|max_length[100]');
		$this->form_validation->set_rules('txt_login','Login','required|trim|max_length[40]|unique[users.login.id.user_id]');
		$this->form_validation->set_rules('txt_password','New Password','matches[txt_verify_password]|required|max_length[40]');
		$this->form_validation->set_rules('txt_verify_password','Verify New Password','required|max_length[40]');
		$this->form_validation->set_rules('cbo_role_id','Role','required');
		$this->form_validation->set_rules('cbo_default_branch_id','Default Branch','required');
		$this->form_validation->set_rules('cbo_current_status','Current Status','required');			
	}	
	
	function change_password()
	{
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule
		$this->form_validation->set_rules('old_password','Old Password','required|callback_old_password_check|max_length[40]');
		$this->form_validation->set_rules('password','New Password','required|matches[verify_password]|max_length[40]');
		$this->form_validation->set_rules('verify_password','Verify New Password','required|max_length[40]');
		$user=$this->session->userdata('system.user');
		if($_POST)
		{
			if ($this->form_validation->run() == TRUE)
			{		
					$data=array();
					$data['id']=$user['id'];
					$data['password']=$this->encrypt->sha1($this->input->post('password'));
					//Validation is OK. So, add this data and redirect to the index page
					if($this->User->changePassword($data))
					{
						$this->session->set_flashdata('success','Password has been changed successfully');
						redirect('/');
					}
				
			}
			
		}
        $data['title']='Change Password';
		$this->layout->view('users/change_password',$data);
	}
	
	function old_password_check($old_password)
	{

		$user=$this->session->userdata('system.user');		
		if($this->User->checkPassword($user['id'],$this->encrypt->sha1($old_password)))
		{
			return TRUE;
		}else
		{
			$this->form_validation->set_message('old_password_check', 'The %s field is not correct');
			return FALSE;
		}		
	}
	
	function _load_combo_data()
	{
		//This function is for listing of roles
		$data['user_roles'] = $this->User->get_user_role_list();		
		$data['user_branches'] = $this->User->get_branch_list();		
		//Type list which will be used in combo box
		$data['status_info'] = array('-1'=>'--All--','active'=>'Active','inactive'=>'Inactive');	
		return $data;
	}
}
