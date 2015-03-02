<?php
/** 
	* Migrations Member Controller Class. 
	* @pupose		Manage Member information
	*		
	* @filesource	\app\model\migrations_member_controller.php	
	* @package		microfin 
	* @subpackage	microfin.model.migrations_member_controller
	* @version      $Revision: 1 $
	* @author       $Author: Sheikh Imtiaz Hossain $	
	* @lastmodified $Date: 2011-02-18 $	 
*/
class Migrations_Members extends MY_Controller {
	
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Member','Migrations_Member','Loan_product','Samity','Educational_qualification','Employee'),'',TRUE);
	}

	function index()
	{
		
		$cond = "";
		//Loading user information from the session
		$user = $this->session->userdata('system.user');
		//Assigning the branch_id (retrive from session) into conditional_array
		$cond['branch_id'] = $user['branch_id'];
		//print_r($user);
		$session_data = $this->session->userdata('migrations_members.index');
		//print_r($session_data);
		$data = $this->_load_combo_data($cond);
        $data['title'] = 'Migrations Members';
		$this->layout->view('/migrations_members/index',$data);
	}
	
	function view($member_id=null)
	{
		$data['title'] = 'View Member';
		$this->layout->view('migrations_members/view',$data);		
	}
	
	function save()
	{
		if($_POST)
		{
			//$data = $this->_get_posted_saved_data();
			$data = $_POST;
			echo '<pre>';print_r($data);
			die;
		}
	}
	
	function add()
	{
		if($_POST)
		{
			$data['title'] = 'Members Migration List';
			$cond = "";
			$session_data = $this->session->userdata('migrations_members.index');
			$data = $this->_get_posted_data();
			//echo $data['migration_sex'];
			//echo '<pre>';print_r($data);die;
			//loaded conditional array
			$cond['samity_id'] = $data['samity_name'];
			//loaded data
			$data['get_samity_id'] = $data['samity_name'];
			$data['get_approved_name'] = $data['txt_approved_name'];
			$data['get_approved_date'] = $data['txt_approved_date'];
			$data['get_member_numbers'] = $data['txt_number_of_members'];
			$data['get_migration_sex'] = $data['migration_sex'];
			//loaded data 
			$data['working_areas'] = $this->Member->get_working_area_list();
			$data['educational_qualification'] = $this->Educational_qualification->get_qualification_list();
			$data['samities'] = $this->Samity->get_samities();
			$data['product_infos'] = $this->Product->get_product_info();
			$data['loan_product_infos'] = $this->Product->get_loan_product_info();
			//print_r($data['loan_product_infos']);
			$data['member_types'] = array('General'=>'General','Group Leader'=>'Group Leader','Samity Leader'=>'Samity Leader');
			$data['genders'] = array('select'=>'--Select--','Male'=>'Male','Female'=>'Female');
			//print_r($data);
			//$data = $this->_load_combo_data($cond);
			$data['get_samity_name'] = $this->Migrations_Member->get_samity_name($data['get_samity_id']);
			//print_r($data['get_samity_name']);
			$user = $this->session->userdata('system.user');		
			$data['created_on'] = date("Y-m-d");				
			$data['headline'] = 'Add Migrated Member';
			//$this->layout->view('/migrations_members/add',$data);
			$this->layout->view('/migrations_members/add',$data);
		}
	}	
	
	function edit($member_id=null)
	{
		$data['headline']='Edit Member';
		$this->layout->view('migrations_members/save',$data);		
	}	
	
	function is_delete($member_id=null)
	{			

	}
	
	function _load_combo_data($cond = array())
	{
		//print_r($cond);
		//$branch_id = isset($cond['cbo_branch'])?$cond['cbo_branch']:-1;
		$samity_id = isset($cond['samity_id'])?$cond['samity_id']:-1;
		//print_r($samity_id);die;
		//$samity_group_id = isset($cond['cbo_samity_group'])?$cond['cbo_samity_group']:-1;
		// Loading member list which will be used in combo box
		$data['members'] = $this->Member->get_member_list();
		// Loading working area list which will be used in combo box
		$data['working_areas'] = $this->Member->get_working_area_list();
		//print_r($data['working_areas']);
		// Loading branch list which will be used in combo box
		$data['branches'] = $this->Member->get_branch_list();

		// Loading educational qualification list which will be used in combo box
		$data['educational_qualification'] = $this->Educational_qualification->get_qualification_list();

		// Loading samity list which will be used in combo box
		$data['samities'] = $this->Samity->get_samities();
		//print_r($data['samities']);die;
		
		// Loading those samity list which are in current logged in branch which will be used in combo box
		$data['current_samities'] = $this->Samity->get_samity_list_by_branch($cond['branch_id']);
		//print_r($data['current_samities']);die;
		
		// Loading group list which will be used in combo box
		$data['groups'] = $this->Member->get_group_list($samity_id);	
		// Loading sub-group list which will be used in combo box
		//$data['sub_groups'] = $this->Member->get_sub_group_list($samity_group_id);	
		//Type list which will be used in combo box
		$data['member_types'] = array('General'=>'General','Group Leader'=>'Group Leader','Samity Leader'=>'Samity Leader');			
		//Type list which will be used in combo box
		$data['genders'] = array('select'=>'--Select--','Male'=>'Male','Female'=>'Female');		
		//Type list which will be used in combo box
		$data['member_status'] = array('select'=>'--Select--','Active'=>'Active','Inactive'=>'Inactive','Transfered'=>'Transfered');		
		$data['product_infos'] = $this->Loan_product->get_product_info();
		
		//Get employee list from employee table; this data will be loaded into combo box
		$data['field_officer'] = $this->Employee->get_field_officer_info();
		//print_r($data['field_officer']);die;
		return $data;
	}
	
	function _get_posted_data()
	{	
		$data = array();	
		$data['samity_name'] = $this->input->post('cbo_samities_option');
		$data['txt_approved_name'] = $this->input->post('txt_approved_name');
		$data['txt_approved_date'] = $this->input->post('txt_approved_date');
		$data['txt_number_of_members'] = $this->input->post('txt_number_of_members');
		$data['migration_sex'] = $this->input->post('migration_sex');

		/*if(! empty($_FILES['txt_nominee_picture']['name'])) {
			if ( ! $this->upload->do_upload('txt_nominee_picture'))
			{
				$error = array('error' => $this->upload->display_errors());
				$sessionArray = array('txt_nominee_picture.error'=>$error);
				$this->session->set_userdata($sessionArray);
			}	
			else
			{
				$data['nominee_picture'] = $this->upload->data();
				$data['nominee_picture'] = $data['nominee_picture']['file_name'];
				$sessionArray = array('nominee_picture.file_name'=>$data['nominee_picture']);
				$this->session->set_userdata($sessionArray);
			}
		}*/
		return $data;
	}
	
	function _get_posted_saved_data()
	{	
		$data = array();
		$data['member_name'] = $this->input->post('member_name');
		$data['txt_approved_name'] = $this->input->post('txt_approved_name');
		$data['txt_approved_date'] = $this->input->post('txt_approved_date');
		$data['txt_number_of_members'] = $this->input->post('txt_number_of_members');
		$data['migration_sex'] = $this->input->post('migration_sex');

		return $data;
	}
}
