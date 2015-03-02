<?php
/** 
	* CONSOLIDATED REPORT - (HEADOFFICE LEVEL) Controller Class.
	* @pupose		CONSOLIDATED REPORT - (HEADOFFICE LEVEL) information
	*		
	* @filesource	./system/application/models/Consolidated_reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.Consolidated_reports
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Consolidated_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Consolidated_report','Report','Po_branch'),'',TRUE);				
	}
	//
	function index()
	{
		$data['headline'] = 'CONSOLIDATED REPORT - (HEADOFFICE LEVEL) LIST';		
		$this->layout->view('/consolidated_reports/index',$data);
	}
	// ***************************************************************** Consolidated Balancing Report (Branch wise) ****************************************************************************************
	function consolidated_balancing_report_index()
	{
		$data = $this->_load_combo_data();	
		$data['headline'] = 'Consolidated Balancing Report (Branch wise)';		
		$data['title'] = 'Consolidated Balancing Report (Branch wise)';					
		$this->layout->view('/consolidated_reports/consolidated_balancing_report_index',$data);
	}
	
	function ajax_consolidated_balancing_report()
	{		
		$data = $this->_get_posted_data();
		$data['headline'] = 'Consolidated Balancing Report (Branch wise)';		
		$data['title'] = 'Consolidated Balancing Report (Branch wise)';
		if(empty($data['branch_id']) || empty($data['month_name']) || empty($data['year_name']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{			
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);	
			$month=$data['month_name'];
			$year=$data['year_name'];				
			$date_range=$this->Report->get_first_last_date_of_a_month($year,$month);				
			$data['first_date']=$date_range['first_date'];
			$data['last_date']=$date_range['last_date'];
			//print_r($data);die;
			$data['consolidated_banalce_data'] = $this->Consolidated_report->get_consolidated_report_information_member_savings_loan($data['branch_id'],$date_range['first_date'],$date_range['last_date']);	
			$this->load->view('/consolidated_reports/consolidated_balancing_report',$data);
		}				
	}
	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		$data['branch_id']=$this->input->post('cbo_branch');
		$data['month_name']=$this->input->post('cbo_month');
		$data['year_name']=$this->input->post('cbo_year');		
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data()
	{
		//This function is for listing of branches			
		$data['branch_info'] = $this->Po_branch->get_branches_info();
		//This function is for listing of months		
		$data['months_info'] = $this->Report->get_months();
		//This function is for listing of year
		$data['year_info'] = $this->Report->get_year_range();			
		return $data;
	}
	function _prepare_validation()
	{					
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_branch','Branch','trim|xss_clean|numeric|required');	
		$this->form_validation->set_rules('cbo_year','Year','trim|xss_clean|numeric|required');	
		$this->form_validation->set_rules('cbo_month','Month','trim|xss_clean|numeric|required');	
	}	
}
