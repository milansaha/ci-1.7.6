<?php
/** 
	* PO Funding Organizations Controller Class.
	* @pupose		Manage PO Funding Organizations information
	*		
	* @filesource	./system/application/controllers/po_funding_organizations.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.po_funding_organizations
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_funding_organizations extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Po_funding_organization','',TRUE);		
	}

	function index()
	{
		$data['title']='Funding Organizations';
        $data['headline']='Funding Organizations';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_funding_organization->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_funding_organizations/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_funding_organizations_info']=$this->Po_funding_organization->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/po_funding_organizations/index',$data);
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
				if($this->Po_funding_organization->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_funding_organizations/index/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Funding Organization';
        $data['headline']='Add New';
		$this->layout->view('/po_funding_organizations/add',$data);				
	}	
	
	function edit($po_funding_organization_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($po_funding_organization_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Po Funding Organization ID is not provided');
			redirect('/po_funding_organizations/index/');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$po_funding_organization_id=$_POST['po_funding_organization_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('po_funding_organization_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_funding_organization->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_funding_organizations/index/');
				}
			}
		}
		//Load data from database
		$data['row']=$this->Po_funding_organization->read($po_funding_organization_id);
		
		$data['title']='Edit Funding Organization';
        $data['headline'] = 'Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('po_funding_organizations/edit',$data);		
	}

    /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($po_funding_organization_id=null)
	{
        if(empty($po_funding_organization_id))
		{
			$this->session->set_flashdata('warning','Funding Organization ID is not provided');
			redirect('/po_funding_organizations/index/');
		}
		//Check wether the child data exists
        $has_savings_entry = $this->Po_funding_organization->is_dependency_found('savings',  array('funding_organization_id' => $po_funding_organization_id));
        $has_loans_entry = $this->Po_funding_organization->is_dependency_found('loans',  array('funding_org_id' => $po_funding_organization_id));
        if($has_savings_entry || $has_loans_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_funding_organizations/index/');
        }
        else
        {
            if($this->Po_funding_organization->delete($po_funding_organization_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_funding_organizations/index/');
            }
        }
	}

	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('po_funding_organization_id');
		$data['name']=$this->input->post('txt_name');
		$data['concern_person']=$this->input->post('txt_concern_person');
		$data['address']=$this->input->post('txt_address');
		$data['land_phone']=$this->input->post('txt_land_phone');
		$data['mobile_phone']=$this->input->post('txt_mobile_phone');
		$data['email']=$this->input->post('txt_email');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required||max_length[100]');
		$this->form_validation->set_rules('txt_concern_person','Concern Person','trim|xss_clean|required|max_length[100]');
		$this->form_validation->set_rules('txt_address','Address','trim|xss_clean|required|max_length[255]');
		$this->form_validation->set_rules('txt_land_phone','Address','trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('txt_mobile_phone','Mobile Phone','trim|xss_clean|required|max_length[20]');
		$this->form_validation->set_rules('txt_email','Email','trim|xss_clean|valid_email|max_length[100]');
	}
}
