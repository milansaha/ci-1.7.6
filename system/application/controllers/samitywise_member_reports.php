<?php
/**
	* SAMITYWISE MEMBER REPORT Controller Class.
	* @pupose		SAMITYWISE MEMBER information
	* @filesource	./system/application/controller/samitywise_member_reports.php
	* @package		microfin
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $
	* @lastmodified $Date: 2011-04-02 $
*/
class Samitywise_member_reports extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Report','Samity','Loan_product','Member','Po_branch'),'',TRUE);
		if(PROFILER) $this->output->enable_profiler(FALSE);
	}
	function index()
	{
		$data = $this->_load_combo_data();
        $data['title'] = 'Samity Wise Member Report';
		$data['headline'] = 'Samity Wise Member Report';
		$this->layout->view('/samitywise_member_reports/index',$data);
	}
	function ajax_get_members_info_by_samity()
	{
		$data = $this->_get_posted_data();
		$data['title'] = 'Samity Wise Member Report';
        $data['headline'] = 'Samity Wise Member Report';
		if(empty($data['samity_id']))
		{
			$data['errors'][]='Please enter proper samity';
			$this->load->view('/reports/report_message',$data);
		}
		else
		{ 
            $data['samity_info'] = $this->Samity->read($data['samity_id']);
            $data['samity_types'] = array('M'=>'Male','F'=>'Female');
            $data['status'] = array('1'=>'Active','0'=>'Inactive');
            $data['samity_days'] = $this->Report->get_samity_days();
            $data['member_infos'] = $this->Member->get_member_info_by_samity_id($data['samity_id']);
			$this->load->view('/samitywise_member_reports/samitywise_member_report',$data);
		}
	}

	function _get_posted_data()
	{
		$data=array();
		$data['samity_id']=$this->input->post('cbo_samity');
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data()
	{
        $branch_id = $this->get_branch_id();
		$data['samities'] = $this->Samity->get_all_samity_list_by_branch($branch_id);
		return $data;
	}
}
