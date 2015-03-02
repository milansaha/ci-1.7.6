<?php
/** 
	* Auths Controller Class.
	* @pupose		Manage user authentication
	*		
	* @filesource	\app\controllers\auths.php	
	* @package		microfin 
	* @subpackage	microfin.controller.auts
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-04-02 $	 
*/ 
	
class Auths extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->helper(array('form'));
		$this->load->model(array('User','Po_branch'),'',TRUE);
		$this->load->library('encrypt');
	}

	function index()
	{
		$this->login();
	}
	
	function login()
	{	
		$data['title']='User Authentication';
		$this->_prepare_login_validation();
		
		if($_POST)
		{	
			if ($this->form_validation->run() == TRUE)
			{
				$data=$this->_get_posted_login_data();					
				if($this->auth->login($this->input->post('txt_login'),$this->input->post('txt_password'),$this->input->post('remember_me')))
				{
					//$branch=$this->Po_branch->read($this->input->post('cbo_branch_id'));
					//$this->auth->set_branch_name($branch[0]->name);
					redirect('');
				}else{
					$this->session->set_flashdata('message','Wrong Username or password');
					redirect('/auths/login/');
				}
			}
		}
		
		$data['branches'] = $this->User->get_branch_list();
		$this->layout->setLayout('login');
		$this->layout->view('/auths/login',$data);				
	}
	
	function logout(){
		$this->auth->logout();
		redirect('/auths/login/');
	}
	
	function _get_posted_login_data()
	{
		$data=array();
		$data['login']=$this->input->post('txt_login');
		$data['password']=$this->encrypt->sha1($this->input->post('txt_password'));
		return $data;
	}

	function _prepare_login_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_login','Login','required');
		$this->form_validation->set_rules('txt_password','Password','required');	
	}
}
