<?php
class Config_generals extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Config_general','',TRUE);		
	}

	function index()
	{
		$data['title']='General Configuration';
		$data['headline']='General Configuration';
	
		$row=$this->Config_general->read();
		$data['config_general']=$row;	
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('config_generals/index',$data);
	}
	
	function edit()
	{	
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			if ($this->form_validation->run() === TRUE)
			{
                //Insert, If the initail data is empty
                $initail_data=$this->Config_general->read();
                if(empty ($initail_data))
                {
                    if($this->Config_general->add($data))
                    {
                        $this->get_general_configuration(TRUE);
                        $this->session->set_flashdata('message',ADD_MESSAGE);
                        redirect('/config_generals/index/');
                    }
                }//End Insert
                else
                {
                    if($this->Config_general->edit($data))
                    {
                        $this->session->unset_userdata('txt_po_logo.file_name');
                        // delete exitng photo.
                       
                        if(file_exists(IMAGE_UPLOAD_PATH.$_POST['txt_po_logo_edit']))
                        {
                            @unlink((IMAGE_UPLOAD_PATH.$_POST['txt_po_logo_edit']));
                        }
                        
                        //Refreshing the data stored in the session
                        $this->get_general_configuration(TRUE);
                        $this->session->set_flashdata('message','General Configuration has been updated successfully');
                        redirect('/config_generals/index/', 'refresh');
                    }
                }
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$row=$this->Config_general->read();
		$data['row']=$row;
		$data['title']='Edit general Configuration';
		$data['headline']='Edit general Configuration';	
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('config_generals/save',$data);		
	}
	function _get_posted_data()
	{
		$data=array();
		
		$data['po_name']=$this->input->post('txt_po_name');
		$data['po_code']=$this->input->post('txt_po_code');
		$data['po_establishment_date']=$this->input->post('txt_po_establishment_date');
		$data['sw_start_date_of_operation']=$this->input->post('txt_sw_start_date_of_operation');
		$data['default_interest_calculation_method']=$this->input->post('cbo_default_interest_calculation_method');
		$data['is_other_interest_calculation_method_allowed']=$this->input->post('cbo_is_other_interest_calculation_method_allowed');
		$data['is_multiple_loan_allowed_for_primary_products']=$this->input->post('cbo_is_multiple_loan_allowed_for_primary_products');
		$data['financial_year_start_month']=$this->input->post('cbo_financial_year_start_month');
		$data['savings_balance_used_for_interest_calculation']=$this->input->post('cbo_savings_balance_used_for_interest_calculation');
		$data['savings_minimum_balance_required_for_interest_calculation']=$this->input->post('txt_savings_minimum_balance_required_for_interest_calculation');
		$data['savings_minimum_account_duration_to_receive_interest']=$this->input->post('cbo_savings_minimum_account_duration_to_receive_interest');
		$data['savings_is_inactive_member_eligible_to_receive_interest']=$this->input->post('cbo_savings_is_inactive_member_eligible_to_receive_interest');
		$data['savings_frequency_of_interest_posting_to_accounts']=$this->input->post('cbo_savings_frequency_of_interest_posting_to_accounts');
		$data['savings_interest_calculation_closing_month']=$this->input->post('cbo_savings_interest_calculation_closing_month');
		$data['savings_interest_disbursment_month']=$this->input->post('cbo_savings_interest_disbursment_month');
		
		$data['report_header_line_1']=$this->input->post('txt_report_header_line_1');
		$data['report_header_line_2']=$this->input->post('txt_report_header_line_2');
		$data['report_header_line_3']=$this->input->post('txt_report_header_line_3');
		
		$data['report_footer_line_1']=$this->input->post('txt_report_footer_line_1');
		$data['report_footer_line_2']=$this->input->post('txt_report_footer_line_2');
		//logo
		$config['upload_path'] = IMAGE_UPLOAD_PATH;
		$config['allowed_types'] = IMAGE_UPLOAD_ALLOWED_TYPES;
		$config['max_size']	= IMAGE_UPLOAD_SIZE;
		$config['max_width']  = IMAGE_UPLOAD_MAX_WIDTH;
		$config['max_height']  = IMAGE_UPLOAD_MAX_HEIGHT;
		$config['encrypt_name'] = true;
		
		$this->load->library('upload', $config);
	
		//print_r($_FILES);
		$this->session->unset_userdata('txt_po_logo.error');
		$this->session->unset_userdata('txt_po_logo.file_name');
		//	print_r($_FILES);
		//	die();
		if(! empty($_FILES['txt_po_logo']['name']) ){
			if ( ! $this->upload->do_upload('txt_po_logo') )
			{
				$error = array('error' => $this->upload->display_errors());
				$sessionArray = array('txt_po_logo.error'=>$error);
				$this->session->set_userdata($sessionArray);
			}	
			else
			{
				$data['po_logo'] = $this->upload->data();
				$data['po_logo'] = $data['po_logo']['file_name'];
				$sessionArray = array('txt_po_logo.file_name'=>$data['po_logo']);
				$this->session->set_userdata($sessionArray);
			}
		}
		//print_r($data);
		//die();
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_po_name','Organization Name','trim|xss_clean|max_length[150]|required');
		$this->form_validation->set_rules('txt_po_code','Organization Code','trim|xss_clean|max_length[50]|required');
		$this->form_validation->set_rules('txt_po_establishment_date','Organization Establishment Date','trim|xss_clean|max_length[10]|is_date|required');
		$this->form_validation->set_rules('txt_sw_start_date_of_operation','Software Start date of Operation','trim|xss_clean|required|is_date|max_length[10]');
		$this->form_validation->set_rules('cbo_default_interest_calculation_method','Default Interest Calculation Method','trim|xss_clean|required|max_length[50]');
		$this->form_validation->set_rules('cbo_is_other_interest_calculation_method_allowed','Is Other Interest Calculation Method Allowed','trim|xss_clean|required|max_length[1]');
		$this->form_validation->set_rules('cbo_is_multiple_loan_allowed_for_primary_products','Is Multiple Loan Allowed for Primary Products','trim|xss_clean|required|max_length[1]');
		$this->form_validation->set_rules('cbo_financial_year_start_month','Financial Year Start Month','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_savings_balance_used_for_interest_calculation','Saving Balance used for Interest Calculation','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_savings_minimum_balance_required_for_interest_calculation','Minimum Balance required for Interest Calculation','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_savings_minimum_account_duration_to_receive_interest','Minimum Balance required for Interest Calculation','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_savings_is_inactive_member_eligible_to_receive_interest','Minimum Balance required for Interest Calculation','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_savings_frequency_of_interest_posting_to_accounts','Frequency of Interest Posting to Accounts','trim|xss_clean|required');
		
		$this->form_validation->set_rules('cbo_savings_interest_calculation_closing_month','Interest Calculation Closing Month','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_savings_interest_disbursment_month','Interest Dsibursment Month','trim|xss_clean|required');
		
		$this->form_validation->set_rules('txt_report_header_line_1','Report Header Line #1','trim|xss_clean|max_length[100]|required');
        $this->form_validation->set_rules('txt_report_header_line_2','Report Header Line #2','trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('txt_report_header_line_3','Report Header Line #3','trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('txt_report_footer_line_1','Report Footer Line #1','trim|xss_clean|max_length[100]');
        $this->form_validation->set_rules('txt_report_footer_line_2','Report Footer Line #1','trim|xss_clean|max_length[100]');
		
		// Logo
		$this->form_validation->set_rules('txt_po_logo','Organization logo','callback_po_logo_check_img'); 
		
	}
	function po_logo_check_img()
	{
	$res = TRUE;
	$data = $this->session->userdata('txt_po_logo.error');
    if(isset($data['error']))
    {
		$this->form_validation->set_message('po_logo_check_img', $data['error']);
		$this->session->unset_userdata('txt_po_logo.error');
		$res = FALSE;
    }
    
    return $res;
    }
	function _load_combo_data()
	{
		//This function is for listing of Holiday	
        $data['interest_calculation_methods'] = array(''=>'-- select --','FLAT'=>'FLAT METHOD','REDUCING'=>'DECLINING BALANCE');
        $data['options'] = array(''=>'-- select --','0'=>'No','1'=>'Yes');
        $data['savings_balance_used'] = array(''=>'-- select --','MINIMUM_BALANCE'=>'MINIMUM BALANCE','AVERAGE_BALANCE'=>'AVERAGE BALANCE');
        $data['financial_year_start_month']=array(''=>'--select--','January'=>'January','July'=>'July');
        $data['month_list']=array(
				''=>'--select--',
				'January'=>'January',
				'February'=>'February',
				'March'=>'March',
				'April'=>'April',
				'May'=>'May',
				'June'=>'June',
				'July'=>'July',
				'August'=>'August',
				'September'=>'September',
				'October'=>'October',
				'November'=>'November',
				'December'=>'December'
			);
        $data['frequency_in_months']=array(''=>'--select--','1'=>'1 Month','2'=>'2 Month','3'=>'3 Month','4'=>'4 Month','6'=>'6 Month','12'=>'12 Month');
        
		return $data;
	}
}
