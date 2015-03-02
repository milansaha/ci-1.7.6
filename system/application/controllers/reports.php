<?php
/** 
	* REPORT  Controller Class.
	* @pupose		provide print friendly and excel export functionality
	*		
	* @filesource	./system/application/controller/reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controller.reports
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $
	* @lastmodified $Date: 2011-03-24 $	 
*/ 
class Reports extends MY_Controller { 
// be aware.. this class must extend the Controller class, not the MY_Controller class as security overhead is not required here.
	
	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);			
		//Loading Helper Class
		//$this->load->helper(array('form','jquery'));
	}	
	
	function show_print_friendly()
	{
		$data['data']=$this->input->post('report_data');
		$this->load->view('/reports/show_print_friendly',$data);
	}
	
	function export_to_excel()
	{
		$data['data']=$this->input->post('report_data');
		$this->load->view('/reports/export_to_excel',$data);
	}
	
	function index()
	{
		$data['title']='Reports';
		$data['headline']='Reports';
		//$data['data'] = $this->input->post('report_data');
		$this->layout->view('/reports/index');
	}
}
