<?php
/** 
	* Extended Controller Class.
	* @pupose		Perform some operation which is common to all control class 
	*		
	* @filesource	\app\libraries\MY_Controller.php	
	* @package		microfin 
	* @subpackage	microfin.libraries.My_Controller
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury, Saroj Roy $	
	* @lastmodified $Date: 2011-03-07 $	 
*/ 
	
class MY_Controller extends Controller {
	
	public $is_access_denied=false;
	
	/**
	 * __construct() method
	 * Created by: Saroj Roy
	 * Purpose: overriding the default constructor for enabling global profiling, authentication and authorization
	 */
	function __construct()
	{
		parent::__construct();
		
		//If profiling is enable in config.php file, enabling it in controller
		if(PROFILER) $this->output->enable_profiler(TRUE);		
		
		$this->load->library('auth');		
		
		$this->load->model('User_role_wise_privilege','',TRUE);		
		$controller=strtolower($this->router->class);
		$action=$this->router->method;
		if(empty($action)){
				$action='index';
		}

		// redirecting to login page if not logged in or already in login page	
		if(!$this->auth->is_logged_in() && !($controller=='auths' && $action='login')){
			redirect('/auths/login');
			exit;
		}elseif($this->auth->is_logged_in()){ //user is logged in
			//load the branch date from database
			$this->get_current_date(TRUE);
			//create access log
			$this->_create_access_log();				
			if($this->User_role_wise_privilege->check_permission($this->get_role_id(),$controller,$action)==false)
			{
				//redirect('/user_roles/access_denied');
				$this->is_access_denied=TRUE;
			}else
			{
				$this->is_access_denied=FALSE;
			}			
		}	
	}
	
	/**
	 * _create_access_log() method
	 * Created by: Saroj Roy
	 * Purpose: adds an access log
	 */
	private function _create_access_log()
	{
		$user=$this->session->userdata('system.user');
		$this->User_access_log->add($user['id'],$this->input->ip_address(),$user['branch_id'],$this->get_current_date(),$this->uri->ruri_string(),!empty($_POST));
	}
	
	/**
	 * get_user_id() method
	 * Created by: Saroj Roy
	 * Purpose: get the logged-in user's id
	 */
	function get_user_id(){
		$system_user=$this->session->userdata('system.user');
		return $system_user['id'];
	}	
	
	/**
	 * get_role_id() method
	 * Created by: Saroj Roy
	 * Purpose: get the logged-in user's role id
	 */
	function get_role_id(){
		$system_user=$this->session->userdata('system.user');
		return $system_user['role_id'];
	}
	
	/**
	 * get_user_name() method
	 * Created by: Saroj Roy
	 * Purpose: get the logged-in user's full name
	 */
	function get_user_name(){
		
		$system_user=$this->session->userdata('system.user');		
		return $system_user['name'];
	}
	
	/**
	 * get_branch_id() method
	 * Created by: Saroj Roy
	 * Purpose: get the logged-in user's default branch id
	 */
	function get_branch_id(){
		
		$system_user=$this->session->userdata('system.user');				
		return $system_user['branch_id'];
	}
	
	/**
	 * get_branch_name() method
	 * Created by: Saroj Roy
	 * Purpose: get the logged-in user's default branch name
	 */
	function get_branch_name(){		
		$system_user=$this->session->userdata('system.user');		
		return $system_user['branch_name'];
	}
	
	/**
	 * get_current_date() method
	 * Created by: Saroj Roy, updated by Anis
	 * Purpose: get the current working date of the working branch
	 */
	function get_current_date($is_refresh_required = false){	
		$session_data = $this->session->userdata('system.software_date');
		if($is_refresh_required || !isset($session_data['current_date']))	{
			$this->load->model('Process_day_end','',TRUE);	
			$branch_id = $this->get_branch_id();
			$branch_date = $this->Process_day_end->get_software_current_date($branch_id);
		} else {
			$branch_date = $session_data['current_date'];
		}
		$sessionArray = array('system.software_date'=>array('current_date'=>$branch_date));
		$this->session->set_userdata($sessionArray);
		return $branch_date;
	}
	
	//methods bellow are created and used by anis ============================
	
	function zerofill ($num, $zerofill = 3) {
		return sprintf("%0".$zerofill."s", $num);	
	}
	
	/**
	* Array to Object
	* src:  http://www.lost-in-code.com/programming/php-code/php-array-to-object/
	*/
	function __array_to_object($array = array()) {
	    if (!empty($array)) {
	        $data = false;
	
	        foreach ($array as $akey => $aval) {
	            $data -> {$akey} = $aval;
	        }
	
	        return $data;
	    }
	    return false;
	}
	
	function is_date($date){
		$date_array = explode('-',$date);
		if( !isset($date_array[2]) && empty($date_array[2])) {
			return false;
		}
		return checkdate($date_array[1],$date_array[2],$date_array[0]);
	}
	
	function get_general_configuration($is_refresh_required=FALSE)
	{
		$session_data = $this->session->userdata('system.general_configuration');
		$data=array();
		if($is_refresh_required || empty($session_data))	{
			$this->load->model('Config_general','',TRUE);
			$data = $this->Config_general->read_array();
			$this->session->set_userdata('system.general_configuration',$data);
		}else
		{
			$data=$session_data;
		}		
		return $data;
	}
}
