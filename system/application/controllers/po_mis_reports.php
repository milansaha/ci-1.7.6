<?php
/** 
	* PO MIS Reports Controller Class.
	* @pupose		PO MIS Reports information
	*		
	* @filesource	./system/application/models/po_mis_reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_mis_reports
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_mis_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_mis_report','Po_branch','Po_region','Po_area','Po_zone','Report'),'',TRUE);		
	}

	function index()
	{
		$data['headline'] = 'PO MIS Report List';		
		$this->layout->view('/po_mis_reports/index',$data);
	}

	//POMIS Report -1 
	function po_mis_1_index()
	{		
		$data = $this->_load_combo_data();				
		$data['headline'] = 'POMIS-1';	
		$data['title'] = 'POMIS-1';	
		$this->layout->view('/po_mis_reports/po_mis_1_index',$data);
	}	
	function ajax_po_mis_1_report()
	{
		if($_POST)
		{
			$this->_prepare_validation();
			$data = $this->_get_posted_data();			
			if ($this->form_validation->run() === TRUE)
			{			
				$data['headline'] = 'POMIS-1';	
				$data['title'] = 'POMIS-1';	
				$data['reporting_date']=date("F j, Y"); 
				$data['month']=$data['month_name'];
				$data['year']=$data['year_name'];
				if($data['branch_id']==-1)
				{
					$data['branch_info']='';					
				}
				else
				{
					$data['branch_info'] = $this->Po_mis_report->get_branches_info($data['branch_id']);
				}
				$data['branch_id']=$data['branch_id'];
				$data['branch_member_info'] = $this->Po_mis_report->get_branch_member_information($data['branch_id'],$data['month'],$data['year']);		
				$data['savings_statement'] = $this->Po_mis_report->get_savings_statement_information($data['branch_id'],$data['month'],$data['year']);	
				$this->load->view('/po_mis_reports/po_mis_1_report',$data);				
				//$this->layout->view('/po_mis_reports/po_mis_1_report',$data);					
			}
			else{
				//$data = $this->_load_combo_data();				
				//$this->layout->view('/po_mis_reports/po_mis_1_index',$data);
				$data['errors'][]='Please enter proper branch, date from and date to';
				$this->load->view('/reports/report_message',$data);
			}	
		}
	}	

	//POMIS Report -2 
	function po_mis_2_index()
	{
		$data = $this->_load_combo_data();	
		$data['headline']='POMIS-2';	
		$data['title']='POMIS-2';		
		$this->layout->view('/po_mis_reports/po_mis_2_index',$data);
	}	
	function ajax_po_mis_2_report()
	{	
		if($_POST)
		{
			$this->_prepare_validation();
			$data = $this->_get_posted_data();			
			if ($this->form_validation->run() === TRUE){			
				$data['headline'] = 'POMIS-2';	
				$data['title'] = 'POMIS-2';	
				$data['reporting_date']=date("F j, Y"); 
				$data['month']=$data['month_name'];
				$data['year']=$data['year_name'];
				if($data['branch_id']==-1)
				{
					$data['branch_info']='';					
				}
				else
				{
					$data['branch_info'] = $this->Po_mis_report->get_branches_info($data['branch_id']);
				}
				$data['branch_id']=$data['branch_id'];
				$data['loan_info'] = $this->Po_mis_report->get_loan_information($data['year'],$data['month'],$data['branch_id'],$data['cbo_service_charge']);		
				$data['loan_due_info'] = $this->Po_mis_report->get_loan_due_information($data['year'],$data['month'],$data['branch_id'],$data['cbo_service_charge']);
				$this->load->view('/po_mis_reports/po_mis_2_report',$data);				
				//$this->layout->view('/po_mis_reports/po_mis_1_report',$data);					
			}
			else{
				$data['errors'][]='Please enter proper branch, date from and date to';
				$this->load->view('/reports/report_message',$data);
			}	
		}
		
		/*if($_POST)
		{					
			$data = $this->_get_posted_data();	
			$data['headline']='POMIS-2';
			$data['title']='POMIS-2';
			$data['month']=$data['month_name'];
			$data['year']=$data['year_name'];
			//$data['reporting_date']=date("d-m-Y");
			$data['charge']=$data['cbo_service_charge'];
			$data['branch_info'] = $this->Po_mis_report->get_branches_info($data['branch_id']);
			$data['loan_info'] = $this->Po_mis_report->get_loan_information($data['year'],$data['month'],$data['branch_id'],$data['charge']);		
			$data['loan_due_info'] = $this->Po_mis_report->get_loan_due_information($data['year'],$data['month'],$data['branch_id'],$data['charge']);		
				
		}	
		//print_r($data['loan_due_info']);
		//die();	
		$this->layout->view('/po_mis_reports/po_mis_2_report',$data);*/		
	}

	//POMIS Report -3 
	function po_mis_3_index()
	{
		$data = $this->_load_combo_data();
		$data['headline']='POMIS-3';
		$data['title']='POMIS-3';	
		$this->layout->view('/po_mis_reports/po_mis_3_index',$data);
	}
	function ajax_po_mis_3_report()
	{		
		//echo "reeeeeeeeee";
		if($_POST)
		{
			$this->_prepare_validation();
			$data = $this->_get_posted_data();			
			if ($this->form_validation->run() === TRUE){			
				$data['headline'] = 'POMIS-3';	
				$data['title'] = 'POMIS-3';	
				$data['reporting_date']=date("F j, Y"); 
				$data['month']=$data['month_name'];
				$data['year']=$data['year_name'];
				if($data['branch_id']==-1)
				{
					$data['branch_info']='';					
				}
				else
				{
					$data['branch_info'] = $this->Po_mis_report->get_branches_info($data['branch_id']);
				}
				$data['branch_id']=$data['branch_id'];
				$data['loan_info'] = $this->Po_mis_report->get_over_due_loan_information($data['year'],$data['month'],$data['branch_id'],$data['cbo_service_charge']);	
				//$data['designation'] = $this->Po_mis_report->get_branch_wise_designation($data['branch_id'],$data['month'],$data['year']);	
				$data['product'] = $this->Po_mis_report->get_branch_wise_product($data['branch_id'],$data['month'],$data['year']);	
				$data['staff_info'] = $this->Po_mis_report->get_statement_of_staff($data['branch_id'],$data['month'],$data['year']);
				$data['statement_of_workingarea'] = $this->Po_mis_report->get_statement_of_workinarea($data['branch_id'],$data['month'],$data['year']);	
				$data['statement_of_total_workingarea'] = $this->Po_mis_report->get_statement_of_total_workinarea($data['branch_id'],$data['month'],$data['year']);
				$this->load->view('/po_mis_reports/po_mis_3_report',$data);				
				//$this->layout->view('/po_mis_reports/po_mis_1_report',$data);					
			}
			else{
				$data['errors'][]='Please enter proper branch, date from and date to';
				$this->load->view('/reports/report_message',$data);
			}	
		}
		/*if($_POST)
		{
			$data = $this->_get_posted_data();
			$data['headline']='POMIS-3';
			$data['title']='POMIS-3';	
			$data['month']=$data['month_name'];
			$data['year']=$data['year_name'];
			$data['reporting_date']=date("d-m-Y");
			//$data['statement_of_staff'] = $this->Po_mis_report->get_statement_of_staff($data['branch_id'],$data['month'],$data['year']);
			$data['loan_info'] = $this->Po_mis_report->get_over_due_loan_information($data['year'],$data['month'],$data['branch_id'],$data['cbo_service_charge']);	
			$data['designation'] = $this->Po_mis_report->get_branch_wise_designation($data['branch_id'],$data['month'],$data['year']);	
			$data['product'] = $this->Po_mis_report->get_branch_wise_product($data['branch_id'],$data['month'],$data['year']);	
			$data['statement_of_workingarea'] = $this->Po_mis_report->get_statement_of_staff($data['branch_id'],$data['month'],$data['year']);
			$data['statement_of_workingarea'] = $this->Po_mis_report->get_statement_of_workinarea($data['branch_id'],$data['month'],$data['year']);	
			$data['statement_of_total_workingarea'] = $this->Po_mis_report->get_statement_of_total_workinarea($data['branch_id'],$data['month'],$data['year']);					
		}
		//	print_r($data);
			//die;
		$data['service_charge']=$this->input->post('cbo_service_charge');
		$this->layout->view('/po_mis_reports/po_mis_3_report',$data);*/		
	}

	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		$data['branch_id']=$this->input->post('cbo_branch');
		$data['month_name']=$this->input->post('cbo_month');
		$data['year_name']=$this->input->post('cbo_year');		
		$data['cbo_service_charge']=$this->input->post('cbo_service_charge');		
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data()
	{
		//This function is for listing of branches			
		$data['branches_info'] = $this->Po_branch->get_branches_info();
		//This function is for listing of months		
		$data['months_info'] = $this->Report->get_months();
		//This function is for listing of year
		$data['year_info'] = $this->Report->get_year_range();
		//This function is for listing of service charge
		$data['service_charge_info'] = array('' => '--Select--', 'Yes' => 'With Service charge', 'No' => 'Without Service charge');
		// Loading partner organizations division list which will be used in region combo box
		$data['regions'] = $this->Po_region->get_region_list();	
		// Loading partner organizations district list which will be used in zones combo box
		$data['zones'] = $this->Po_zone->get_zone_list();	
		// Loading partner organizations district list which will be used in areas combo box
		$data['areas'] = $this->Po_area->get_area_list();		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_branch','Branch','trim|xss_clean|numeric|required');	
		$this->form_validation->set_rules('cbo_month','Month','trim|xss_clean|numeric|required');
		$this->form_validation->set_rules('cbo_year','Year','trim|xss_clean|numeric|required');		
	}		
}
