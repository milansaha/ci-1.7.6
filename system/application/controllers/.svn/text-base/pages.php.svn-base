<?php

class Pages extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','jquery'));	
	}
	
	function index()
	{
		$data['title']='Welcome';
		$this->layout->view('/pages/index',$data);
	}
	
	function enable_javascript()
	{
		$data['title']='Enable Javascript to use this application';
		$data['is_menu_disabled']=TRUE;
		$this->layout->view('/pages/enable_javascript',$data);
	}
	
	function access_denied()
	{
		$data['title']='Access Denied';
		$this->layout->view('/pages/access_denied',$data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
