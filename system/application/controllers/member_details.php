<?php
/** 
	* Member Detail Controller Class. 
	* @pupose		Manage Member Detail information
	*		
	* @filesource	\app\model\po_member_details_controller.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_member_details_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
class Member_details extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Member_detail','',TRUE);		
	}

	function index()
	{
		$data['headline']='Member Detail List';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_detail->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/member_details/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['member_details']=$this->Member_detail->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/member_details/index',$data);
	}
	
	function add()
	{
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();			
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_detail->add($data))
				{
					$this->session->set_flashdata('message','Member detail information has been added successfully');
					redirect('/member_details/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['headline']='Add Member detail';
		$this->layout->view('/member_details/add',$data);				
	}	
	
	function edit($member_detail_id=null)
	{			
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($member_detail_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Member detail ID is not provided');
			redirect('/member_details/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$member_detail_id=$_POST['member_detail_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('member_detail_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Member_detail->edit($data))
				{
					$this->session->set_flashdata('message','Member detail information has been updated successfully');
					redirect('/member_details/index/', 'refresh');
				}
			}
		}		
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Member_detail->read($member_detail_id);
		$data['row']=$row[0];	
		//If data is not posted or validation fails, the add view is displayed
		$data['headline']='Edit Member detail';
		$this->layout->view('member_details/edit',$data);		
	}	
	
	function is_delete($member_detail_id=null)
	{			
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($member_detail_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Member detail ID is not provided');
			redirect('/member_details/index/', 'refresh');
		}
		else
		{					
			$data['is_deleted']='1';
			$data['id']=$member_detail_id;
			//Update this data and redirect to the index page
			if($this->Member_detail->edit($data))
			{
				$this->session->set_flashdata('message','Member detail information has been deleted successfully');
				redirect('/member_details/index/', 'refresh');
			}	
		}							
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['member_id']=$this->input->post('cbo_member');
		$data['fathers_name']=$this->input->post('txt_fathers_name');
		$data['mothers_name']=$this->input->post('txt_mothers_name');
		$data['spouse_name']=$this->input->post('txt_spouse_name');
		$data['mothers_name']=$this->input->post('txt_date_of_birth');
		$data['working_area_id']=$this->input->post('cbo_working_area');
		$data['present_address']=$this->input->post('txt_present_address');
		$data['contact_number']=$this->input->post('txt_contact_number');
		$data['last_achieved_degree']=$this->input->post('txt_last_achieved_degree');
		$data['no_of_family_member']=$this->input->post('txt_no_of_family_member');
		$data['yearly_income']=$this->input->post('txt_yearly_income');
		$data['national_id']=$this->input->post('txt_national_id');
		$data['nominee_name']=$this->input->post('txt_nominee_name');
		$data['nominee_relation']=$this->input->post('txt_nominee_relation');
		$data['nominee_picture']=$this->input->post('txt_nominee_picture');
		$data['member_picture']=$this->input->post('txt_member_picture');
		$data['remarks']=$this->input->post('txt_remarks');
		$data['date_of_death']=$this->input->post('txt_date_of_death');
		$data['reason_of_death']=$this->input->post('txt_reason_of_death');
		$data['cancel_date']=$this->input->post('txt_cancel_date');
		$data['cancel_reason']=$this->input->post('txt_cancel_reason');	
		$data['cancel_registration_no']=$this->input->post('txt_cancel_registration_no');	
		$data['guarantor_name_1']=$this->input->post('txt_guarantor_name_1');
		$data['guarantor_address_1']=$this->input->post('txt_guarantor_address_1');
		$data['guarantor_relationship_1']=$this->input->post('txt_guarantor_relationship_1');
		$data['guarantor_name_2']=$this->input->post('txt_guarantor_name_2');
		$data['guarantor_address_2']=$this->input->post('txt_guarantor_address_2');
		$data['guarantor_relationship_2']=$this->input->post('txt_guarantor_relationship_2');			
		return $data;
	}


	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_member','Member','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_fathers_name','Father Name','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_mothers_name','Mother Name','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_spouse_name','Spouse Name','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_date_of_birth','Date of Birth','trim|max_length[10]|xss_clean');	
		$this->form_validation->set_rules('txt_present_address','Present Address','trim|xss_clean');	
		$this->form_validation->set_rules('txt_contact_number','Contact Number','trim|xss_clean');	
		$this->form_validation->set_rules('txt_last_achieved_degree','Last achieved degree','trim|max_length[100]|xss_clean');	
		$this->form_validation->set_rules('txt_no_of_family_member','No of family member','trim|integer|xss_clean');	
		$this->form_validation->set_rules('txt_yearly_income','Yearly income','trim|numeric|xss_clean');	
		$this->form_validation->set_rules('txt_national_id','National ID','trim|max_length[13]|numeric|xss_clean');	
		$this->form_validation->set_rules('txt_nominee_name','Nominee Name','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_nominee_relation','Nominee Relation','trim|max_length[50]|xss_clean');	
		$this->form_validation->set_rules('txt_nominee_picture','Nominee Picture','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_member_picture','Member picture','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_remarks','Remarks','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_date_of_death','Date of death','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_reason_of_death','Reason of death','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_cancel_date','Cancel Date','trim|max_length[10]|xss_clean');	
		$this->form_validation->set_rules('txt_cancel_reason','Cancel Reason','trim|max_length[200]|xss_clean');
		$this->form_validation->set_rules('txt_cancel_registration_no','Cancel Registration No','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_guarantor_name_1','Guarantor Name 1','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_guarantor_address_1','Guarantor Address 1','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_guarantor_relationship_1','Guarantor Relationship 1','trim|max_length[50]|xss_clean');	
		$this->form_validation->set_rules('txt_guarantor_name_2','Guarantor Name 2','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_guarantor_address_2','Guarantor Address 2','trim|max_length[200]|xss_clean');	
		$this->form_validation->set_rules('txt_guarantor_relationship_2','Guarantor Relationship 2','trim|max_length[50]|xss_clean');			
	}
	function _load_combo_data()
	{
		// Loading member list which will be used in combo box
		$data['members'] = $this->Member_detail->get_member_list();
		// Loading working area list which will be used in combo box
		$data['working_areas'] = $this->Member_detail->get_working_area_list();		
		return $data;
	}
}
