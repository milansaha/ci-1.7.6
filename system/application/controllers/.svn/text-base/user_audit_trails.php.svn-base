<?php
/** 
	* Employee Designation Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/employee_designation.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.employee_designation
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class User_audit_trails extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('User_audit_trail','User'));		
	}

	function index()
	{
		$data = $this->_load_combo_data();
		
		$cond= "";
		$session_data = $this->session->userdata('user_audit_trails.index');
		if(isset($_POST['txt_from_date']) || isset($_POST['txt_to_date']) || isset($_POST['cbo_user'])|| isset($_POST['cbo_user_branch'])|| isset($_POST['cbo_action_type'])){
			
			$cond['from_date'] = strtotime($_POST['txt_from_date']);
			$cond['to_date'] =  strtotime($_POST['txt_to_date']);			
			$cond['user'] = $_POST['cbo_user'];
			$cond['user_branch'] = $_POST['cbo_user_branch'];
			$cond['action_type'] = $_POST['cbo_action_type'];
			
			$sessionArray = array( 'user_audit_trails.index'=>array(
										'from_date'=>$cond['from_date'],
										'to_date'=>$cond['to_date'],
										'user'=>$cond['user'],
										'user_branch'=>$cond['user_branch'],
										'action_type'=>$cond['action_type']												
										));
			//print_r($session_data);
			$this->session->unset_userdata('user_audit_trails.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['from_date'] = $session_data['from_date'];
			$cond['to_date'] = $session_data['to_date'];
			$cond['user'] = $session_data['user'];
			$cond['user_branch'] = $session_data['user_branch'];
			$cond['action_type'] = $session_data['action_type'];
		} else {
			$this->session->unset_userdata('user_audit_trails.index');
		} 
		// load pagination class
		$this->load->library('pagination');
		$total = $this->User_audit_trail->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/user_audit_trails/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['audit_trails']=$this->User_audit_trail->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='User Audit Trail';
        $data['headline']='User Audit Trail';
		$this->layout->view('/user_audit_trails/index',$data);
	}
	
	function view($id = null)
	{			
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($id) && !$_GET)
		{
			$this->session->set_flashdata('message','ID is not provided');
			redirect('/user_audit_trails/index/', 'refresh');
		}
			
		//Load data from database
		$data['row'] = $this->User_audit_trail->get_detail($id);	
		//If data is not posted or validation fails, the add view is displayed
		$data['title'] = 'View User audit trail';
		
		$this->layout->view('user_audit_trails/view',$data);		
	}
	
	function _load_combo_data()
	{
		//This function is for listing of users
		$data['user_lists'] = $this->User_audit_trail->get_user_list();	
		//This function is for listing of branches	
		$data['user_branches'] = $this->User_audit_trail->get_branch_list();		
		//Type list which will be used in combo box for action type
		$data['action_info'] = array('-1'=>'--Action Type--','insert'=>'insert','update'=>'update','delete'=>'delete');	
		return $data;
	}
}
