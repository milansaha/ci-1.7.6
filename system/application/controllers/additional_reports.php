<?php
/** 
	* ADDITIONAL REPORT - (BRANCH LEVEL) Controller Class.
	* @pupose		ADDITIONAL REPORT - (BRANCH LEVEL) information
	*		
	* @filesource	./system/application/models/additional_reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.additional_reports
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Additional_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Additional_report','Report','Po_branch'),'',TRUE);		
	}
	//
	function index()
	{
		$data['headline'] = 'ADDITIONAL REPORT - (BRANCH LEVEL) LIST';		
		$this->layout->view('/additional_reports/index',$data);
	}
	
	/*
	function ratio_analysis_statement_index() 
	{
		$data['headline'] = 'Ratio Analysis Statement';	
		$data = $this->_load_combo_data() ;	
		$this->layout->view('/ratio_analysis_statement_reports/ratio_analysis_statement_index',$data);
	}
	//
	function ratio_analysis_statement_report() 
	{		
		$data = $this->_get_posted_data() ;	
		$this->layout->view('/ratio_analysis_statement_reports/ratio_analysis_statement_report',$data);
	}*/
	//
	function ratio_analysis_statement_index() 
	{
		$data = $this->_load_combo_data() ;	
		$data['headline'] = 'Ratio Analysis Statement';	
		$data['title'] = 'Ratio Analysis Statement';	
		$this->layout->view('/ratio_analysis_statement_reports/ratio_analysis_statement_index',$data);
	}
	//
	function ajax_ratio_analysis_statement_report() 
	{
		//echo '<pre>';
		//print_r($this->_get_posted_data());//die;
		$this->_prepare_validation();	
		$data = $this->_get_posted_data();
		$data['headline'] = 'Ratio Analysis Statement';	
		$data['title'] = 'Ratio Analysis Statement';
		if ($this->form_validation->run() === TRUE)
		{
			//print_r($data['get_selected_branches_info']);
			$data['report_month'] = date('F',$data['month_name']);
			$data['reporting_date'] = date("F, Y", mktime(0, 0, 0, $data['month_name']+1, 0, $data['year_name']));
			$data['report_year'] = $data['year_name'];
			$data['branch_id'] = $data['cbo_branch'];
			$data['project_id'] = $data['cbo_project'];
			//print_r($data);
			$data['get_productive_ratio'] = $this->Additional_report->get_productive_ratio($data['month_name'],$data['year_name'],$data['branch_id'],$data['project_id']);
			$data['get_selected_branches_info'] = $this->Po_branch->get_selected_branches_info($data['cbo_branch']);
			$data['headline'] = 'Ratio Analysis Statement';	
			//$this->layout->view('/ratio_analysis_statement_reports/ratio_analysis_statement_report',$data);
			$this->load->view('/ratio_analysis_statement_reports/ratio_analysis_statement_report',$data);			
		} else {
			$data['errors'][]='Please enter proper branch, Month and Year.';
			$this->load->view('/reports/report_message',$data);
		}		
	}
	
	// consolidated ratio analysis report
	function consolidated_ratio_analysis_statement_index() 
	{
		$data = $this->_load_combo_data() ;	
		$data['headline'] = 'Ratio Analysis Statement';
		$data['title'] = 'Ratio Analysis Statement';
		$this->layout->view('/ratio_analysis_statement_reports/consolidated_ratio_analysis_statement_index',$data);
	}
	//
	function ajax_consolidated_ratio_analysis_statement_report() 
	{
		$this->_prepare_validation();	
		$data = $this->_get_posted_data();
		$data['headline'] = 'Ratio Analysis Statement';
		$data['title'] = 'Ratio Analysis Statement';
		if ($this->form_validation->run() === TRUE)
		{
			$data['get_productive_ratio'] = $this->Additional_report->get_productive_consolidated_ratio($data['month_name'],$data['year_name']);
			//print_r($data['get_productive_ratio']);die;
			$data['report_month'] = date('F',$data['month_name']);
			$data['reporting_date'] = date("F, Y", mktime(0, 0, 0, $data['month_name']+1, 0, $data['year_name']));
			$data['report_year'] = $data['year_name'];
			//print_r($data);
			$data['headline'] = 'Consolidated Ratio Analysis Statement';	
			//$this->layout->view('/ratio_analysis_statement_reports/consolidated_ratio_analysis_statement_report',$data);
			$this->load->view('/ratio_analysis_statement_reports/consolidated_ratio_analysis_statement_report',$data);			
		} else {
			$data['errors'][]='Please enter proper branch, Month and Year.';
			$this->load->view('/reports/report_message',$data);
		}
	}
	
	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('po_area_id');		
		$data['month_name']=$this->input->post('cbo_month');
		$data['year_name']=$this->input->post('cbo_year');
		$data['cbo_branch']=$this->input->post('cbo_branch');
		$data['cbo_project']=$this->input->post('cbo_project');
		return $data;
	}
	
	//Combo Data Generation
	function _load_combo_data() 
	{			
		$data['branches_info'] = $this->Po_branch->get_branches_info();
		$data['projects_info'] = $this->Report->get_projects();		
		$data['months_info'] = $this->Report->get_months();
		$data['year_info'] = $this->Report->get_year_range();
		//$data['samity_day_info'] = $this->Report->get_samity_days();		
		return $data;
	}	
	function _prepare_validation()
	{					
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_month','Month','trim|xss_clean|numeric|required');			
		$this->form_validation->set_rules('cbo_year','Year','trim|xss_clean|numeric|required');					
	}
}
