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
class Pass_book_reports extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Pass_book_report','Samity','Loan_product','Member'),'',TRUE);		
	}

	function index()
	{			
		$data = $this->_load_combo_data();
		$data['headline'] = 'Pass Book Report';	
		$data['title'] = 'Pass Book Report';				
		$this->layout->view('/pass_book_reports/index',$data);
	}	
	function ajax_pass_book_report()
	{		
		if($_POST)
		{
			$this->_prepare_validation();		
			$data = $this->_get_posted_data();	
			$data['headline'] = 'Pass Book Report';	
			$data['title'] = 'Pass Book Report';
			if ($this->form_validation->run() === TRUE)
			{
				$data['products_info'] = $this->Loan_product->get_selected_product_info($data['product_id']);
				$data['branch_and_samity_info'] = $this->Pass_book_report->get_branch_samity_information($data['samity_id']);
				//$data['loan_info']=$this->Pass_book_report->get_loan_no($data['branch_and_samity_info'][0]['branch_id'],$data['member_id'],$data['samity_id'],$data['product_id']);
				$data['member_and_loan_info'] = $this->Pass_book_report->get_member_loan_information($data['member_id'],$data['product_id']);
				$data['pass_book_info']=$this->Pass_book_report->get_date_list($data['branch_and_samity_info'][0]['branch_id'],$data['member_id'],$data['samity_id'],$data['product_id']);
				//$data['pass_book_info']=$this->Pass_book_report->get_date_list($data['branch_and_samity_info'][0]['branch_id'],$data['member_id'],$data['samity_id']);
				// print_r($data['pass_book_info']);die;
				//$data['saving_info'] = $this->Pass_book_report->get_saving_information($data['member_id'],$data['product_id']);
				//$data['admission_register_total_information'] = $this->Pass_book_report->get_admission_register_total_information($data['branch_id'],$data['date_from'],$data['date_to']);
				//$this->layout->view('/pass_book_reports/pass_book_report',$data);
				$this->load->view('pass_book_reports/pass_book_report',$data);
			}	
			else{
				$data['errors'][]='Please enter proper branch, product and date';
				$this->load->view('/reports/report_message',$data);				
			}		
		}
	}

	function _prepare_validation()
	{					
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_samitiy','Samity','trim|xss_clean|numeric|required');			
		$this->form_validation->set_rules('cbo_product','Product','trim|xss_clean|numeric|required');						
	}
	
	//Grabe posted data
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('po_area_id');
		$data['member_id']=$this->input->post('member_id');
		$data['samity_id']=$this->input->post('cbo_samitiy');	
		$data['product_id']=$this->input->post('cbo_product'); 					
		return $data;
	}
	//Combo Data Generation
	function _load_combo_data()
	{
		//This function is for listing of samities
		$data['samities_info'] = $this->Samity->get_samities();
                //This function is for listing of products
		$data['products_info'] = $this->Loan_product->get_product_info();
                //This function is for listing of members
		//$data['members_info'] = $this->Member->get_member_info();				
		return $data;
	}	
	/**
	 * Get Loan product information.
	 *  @use savings(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 10-Mar-2011
	*/
	function ajax_for_get_product_info() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$member_id      = $this->input->post('member_id');
		//print($member_id );die;

		if(empty($member_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';			
			$product_info = $this->Pass_book_report->get_product_info($member_id);				
			//print_r($product_info);die;
			if(!empty($product_info)) {
				foreach($product_info as $row) {					
					$callback_message['product']['id'][] = $row['id'];
					$callback_message['product']['name'][] = $row['short_name'];													
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }			  	
	} 
	
}
