<?php

class Day_end_processes extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Day_end_process','',TRUE);		
	}
	
	function index()
	{
		$data['title']='PO Zones';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Day_end_process->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/day_end_processes/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['day_end_process']=$this->Day_end_process->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/day_end_processes/index',$data);
	}
	
	function execute()
	{
		$data['title']='PO Zones';
		$this->layout->view('/day_end_processes/execute',$data);
	}
	
	function first_day_end($branch_id=10,$date='0000-00-00')
	{
		//$this->load->view('welcome_message');
		
		$this->day_end_process->get_by_branch_id_date();
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
