<?php
/** 
	* Controller class of the user access log.
	* @pupose		Display user access logs
	*		
	* @filesource	./system/application/controller/user_access_logs.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controller.User_access_logs
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-03-07 $	 
*/ 
class User_access_logs extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('User_access_log','User'));		
	}

	function index()
	{
		$data = $this->_load_combo_data();
		
		$cond= "";
		$session_data = $this->session->userdata('user_access_logs.index');
		if(isset($_POST['txt_from_date']) || isset($_POST['txt_to_date']) || isset($_POST['cbo_user'])|| isset($_POST['cbo_user_branch'])){
			
			$cond['from_date'] = strtotime($_POST['txt_from_date']);
			$cond['to_date'] =  strtotime($_POST['txt_to_date']);			
			$cond['user'] = $_POST['cbo_user'];
			$cond['user_branch'] = $_POST['cbo_user_branch'];
			
			
			$sessionArray = array( 'user_access_logs.index'=>array(
												'from_date'=>$cond['from_date'],
												'to_date'=>$cond['to_date'],
												'user'=>$cond['user'],
												'user_branch'=>$cond['user_branch']																						
												));
			//print_r($session_data);
			$this->session->unset_userdata('user_access_logs.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['from_date'] = $session_data['from_date'];
			$cond['to_date'] = $session_data['to_date'];
			$cond['user'] = $session_data['user'];
			$cond['user_branch'] = $session_data['user_branch'];			
		} else {
			$this->session->unset_userdata('user_access_logs.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->User_access_log->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/user_access_logs/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['access_logs']=$this->User_access_log->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='User Access Log';
		$this->layout->view('/user_access_logs/index',$data);
	}
	
	function _load_combo_data()
	{
		//This function is for listing of users
		$data['user_lists'] = $this->User_access_log->get_user_list();	
		//This function is for listing of branches	
		$data['user_branches'] = $this->User_access_log->get_branch_list();		
		//Type list which will be used in combo box for action type
		$data['action_info'] = array('-1'=>'--Action Type--','insert'=>'insert','update'=>'update','delete'=>'delete');	
		return $data;
	}
}
