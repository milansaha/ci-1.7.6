<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('auth', TRUE);
		$this->ci->load->library('session');
		$this->ci->load->model(array('User','User_access_log','User_autologin'));
		//Try to autologin
		$this->try_autologin();
	}
	
	/**
	 * Login user on the site. Return TRUE if login is successful
	 * (user exists and activated, password is correct), otherwise FALSE.
	 *
	 * @param	string	(username or email or both depending on settings in config file)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function login($login, $password, $remember)
	{		
		if ((strlen($login) > 0) AND (strlen($password) > 0)) 
		{
			if ($user = $this->ci->User->get_user_by_login($login)) 
			{	// login ok
				
				if ($this->__check_password($password, $user->password)) 
				{	//login and password ok
					
					$session_data = array( 'system.user'=>array('id'=>$user->id,'login'=>$user->login,'full_name'=>$user->full_name,'name'=>$user->full_name,'logged_in'=>TRUE,'role_id'=>$user->role_id,'branch_id'=>$user->default_branch_id,'branch_name'=>$user->branch_name));
					$this->ci->session->set_userdata($session_data);
					
					if ($remember) 
					{
						$this->create_autologin($user->id);
					}
					
					$this->create_user_login_profile($user->id,$user->default_branch_id);
					$this->clear_login_attempts($login);					
					$this->ci->User->update_login_info(
							$user->id,
							$this->ci->config->item('login_record_ip', 'auth'),
							$this->ci->config->item('login_record_time', 'auth')
						);
										
					return TRUE;
				} else {														// fail - wrong password
					$this->increase_login_attempt($login);
					return FALSE;
				}
			} else {															// fail - wrong login
				$this->increase_login_attempt($login);
				return FALSE;
			}
		}
		return FALSE;
	}
	
	/**
	 * Increase number of attempts for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function increase_login_attempt($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'auth')) {
			if (!$this->is_max_login_attempts_exceeded($login)) {
				$this->ci->load->model('User_login_attempts');
				$this->ci->User_login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
			}
		}
	}
	
	/**
	 * Check if login attempts exceeded max login attempts (specified in config)
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_max_login_attempts_exceeded($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'auth')) {
			$this->ci->load->model('User_login_attempts');
			return $this->ci->User_login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
					>= $this->ci->config->item('login_max_attempts', 'auth');
		}
		return FALSE;
	}
	function __check_password($password_front,$password_db)
	{
		if(sha1($password_front)==$password_db)
			return TRUE;
		else
			return FALSE;
	}

	/**
	 * Logout user from the site
	 *
	 * @return	void
	 */
	function logout()
	{
		$this->delete_autologin();		
		// Clear authentication data from session in own responsibility
		$this->ci->session->unset_userdata('system.user');
		//destroying the session
		$this->ci->session->sess_destroy();
	}
	
	/**
	 * Clear user's autologin data
	 *
	 * @return	void
	 */
	private function delete_autologin()
	{
		$this->ci->load->helper('cookie');
		if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'auth'), TRUE)) {
			$data = unserialize($cookie);
			$this->ci->User_autologin->delete($data['user_id'], md5($data['key']));
			delete_cookie($this->ci->config->item('autologin_cookie_name', 'auth'));
		}
	}
	
	/**
	 * Check if user logged in. Also test if user is activated or not.
	 *
	 * @param	bool
	 * @return	bool
	 */
	function is_logged_in()
	{
		$user=$this->ci->session->userdata('system.user');
		if (empty($user))
			return FALSE;
		else
			return TRUE;
	}

	/**
	 * Get user_id
	 *
	 * @return	string
	 */
	function get_user_id()
	{
		$user=$this->ci->session->userdata('system.user');
		return $user['id'];
	}

	/**
	 * Get username
	 *
	 * @return	string
	 */
	function get_user_name()
	{
		$user=$this->ci->session->userdata('system.user');
		return $user['full_name'];
	}
	
	/**
	 * Get branch id
	 *
	 * @return	string
	 */
	function get_branch_id()
	{
		$user=$this->ci->session->userdata('system.user');
		return $user['branch_id'];
	}
	
	
	/**
	 * set branch name
	 *
	 * @return	string
	 */
	function set_branch_name($branch_name)
	{
		$user=$this->ci->session->userdata('system.user');
		$user['branch_name']=$branch_name;
		$this->ci->session->set_userdata('system.user',$user);	
	}

	/**
	 * Get branch name
	 *
	 * @return	string
	 */
	function get_branch_name()
	{
		$user=$this->ci->session->userdata('system.user');
		return $user['branch_name'];
	}	
	
	function check()
	{
		if (!$this->_isAuthenticated())
		{
			redirect('/users/login/');
		}
		
		if (!$this->_isAuthorized())
		{
			redirect('/');
		}
		
	}
	
	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_autologin($user_id)
	{
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

		$this->ci->User_autologin->purge($user_id);

		if ($this->ci->User_autologin->set($user_id, md5($key))) {
			set_cookie(array(
					'name' 		=> $this->ci->config->item('autologin_cookie_name', 'auth'),
					'value'		=> serialize(array('user_id' => $user_id, 'key' => $key)),
					'expire'	=> $this->ci->config->item('autologin_cookie_life', 'auth'),
			));
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Clear all attempt records for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function clear_login_attempts($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'auth')) {
			$this->ci->load->model('User_login_attempts');
			$this->ci->User_login_attempts->clear_attempts(
					$this->ci->input->ip_address(),
					$login,
					$this->ci->config->item('login_attempt_expire', 'auth'));
		}
	}
	
	/**
	 * Login user automatically if he/she provides correct autologin verification
	 *
	 * @return	void
	 */
	private function try_autologin()
	{
		if (!$this->is_logged_in()) {			// not logged in (as any user)
			
			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'auth'), TRUE)) {

				$data = unserialize($cookie);

				if (isset($data['key']) AND isset($data['user_id'])) {
					
					if (!is_null($user = $this->ci->User_autologin->get($data['user_id'], md5($data['key'])))) {
						
						// Login user
						
						$session_data = array( 'system.user'=>array('id'=>$user->id,'login'=>$user->login,'full_name'=>$user->full_name,'role_id'=>$user->role_id,'name'=>$user->full_name,'logged_in'=>TRUE,'branch_id'=>$user->default_branch_id,'branch_name'=>$user->branch_name));
						$this->ci->session->set_userdata($session_data);
						
						// Renew users cookie to prevent it from expiring
						set_cookie(array(
								'name' 		=> $this->ci->config->item('autologin_cookie_name', 'auth'),
								'value'		=> $cookie,
								'expire'	=> $this->ci->config->item('autologin_cookie_life', 'auth'),
						));

						$this->ci->User->update_login_info(
								$user->id,
								$this->ci->config->item('login_record_ip', 'auth'),
								$this->ci->config->item('login_record_time', 'auth')
							);
						$this->create_user_login_profile($user->id,$user->default_branch_id,TRUE);
						
						//die('Autologin done! If you get this message then please inform Saroj. Thanks.');
						
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}
	
	private function create_user_login_profile($user_id,$branch_id,$is_auto_login=FALSE)
	{
		$this->ci->load->model('User_login_profile');
		$this->ci->User_login_profile->add($user_id,$branch_id,$this->ci->input->ip_address(),$this->ci->input->user_agent(),$is_auto_login);
	}	
	
}
?>
