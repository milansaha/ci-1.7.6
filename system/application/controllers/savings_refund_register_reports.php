<?php
/** 
	* Savings Refund Register Reports Controller Class.
	* @pupose		PO MIS Reports information
	*		
	* @filesource	./system/application/models/savings_refund_register_reports.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.savings_refund_register_reports
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Savings_refund_register_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Savings_refund_register_report','Po_branch','Product'),'',TRUE);		
	}

	function index()
	{
		$data['headline'] = 'Savings Refund Regsiter Report Report';	
		$data = $this->_load_combo_data();			
		$this->layout->view('/savings_refund_register_reports/index',$data);
	}
	
	//Report Generation
	function savings_refund_report()
	{		
		$data = $this->_get_posted_data();
		$this->layout->view('/savings_refund_register_reports/savings_refund_regsiter_report',$data);		
	}		
	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('po_area_id');
		$data['branch_id']=$this->input->post('cbo_brach');	
		$data['product_code']=$this->input->post('cbo_product_code');		
		$data['date_from']=$this->input->post('txt_date_from');	
		$data['date_to']=$this->input->post('txt_date_to');		
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data()
	{
		//This function is for listing of departments			
		$data['branches_info'] = $this->Po_branch->get_branches_info();		
		$data['products_info'] = $this->Product->get_product_info();		
		return $data;
	}	
	
}
