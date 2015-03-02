<?php
/**
	* BRANCHWISE SAMITY REPORT Controller Class.
	* @pupose		BRANCHWISE SAMITY information
	*
	* @filesource	./system/application/controller/branchwise_samity_reports.php
	* @package		microfin
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $
	* @lastmodified $Date: 2011-04-02 $
*/
class Branchwise_samity_reports extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Report','Samity','Loan_product','Member','Po_branch'),'',TRUE);
		//if(PROFILER) $this->output->enable_profiler(FALSE);
	}
	function index()
	{
		$data = $this->_load_combo_data();
        $data['title'] = 'Branch Wise Samity Report';
		$data['headline'] = 'Branch Wise Samity Report';
		$this->layout->view('/branchwise_samity_reports/index',$data);
	}
	function ajax_get_branchwise_samities()
	{
		$data = $this->_get_posted_data();
		$data['title'] = 'Branch Wise Samity Report';
        $data['headline'] = 'Branch Wise Samity Report';
		if(empty($data['branch_id']))
		{
			$data['errors'][]='Please enter proper branch, date from and date to';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{
			$data['branch_info'] = $this->Po_branch->get_selected_branches_info($data['branch_id']);
            $data['samity_types'] = array('M'=>'Male','F'=>'Female');
            $data['status'] = array('1'=>'Active','0'=>'Inactive');	
            $data['samity_days'] = $this->Report->get_samity_days();
            $data['samity_infos'] = $this->Samity->get_samities_by_branch_id($data['branch_id']);
            //print_r($data);die;
			$this->load->view('/branchwise_samity_reports/branchwise_samity_report',$data);
		}
	}
	
	function _get_posted_data()
	{
		$data=array();
		$data['branch_id']=$this->input->post('cbo_branch');
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data()
	{
		$data['branch_info'] = $this->Po_branch->get_branches_info();
		return $data;
	}
}
