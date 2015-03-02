<?php
/** 
	* PO Organizations Controller Class.
	* @pupose		Manage PO Organizations information
	*		
	* @filesource	./system/application/controllers/po_organizations.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.po_organizations
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_organizations extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Po_organization','',TRUE);		
	}

	function index()
	{
		$data['title']='PO Organizations';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_organization->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_organizations/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_organizations_info']=$this->Po_organization->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/po_organizations/index',$data);
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
				if($this->Po_organization->add($data))
				{
					$this->session->set_flashdata('message','PO Organization has been added successfully');
					redirect('/po_organizations/add/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add PO Organization';
		$this->layout->view('/po_organizations/add',$data);				
	}	
	
	function edit($po_organization_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($po_organization_id) && !$_POST)
		{
			$this->session->set_flashdata('message','PO Organization ID is not provided');
			redirect('/po_organizations/index/');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$po_organization_id=$_POST['po_organization_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('po_organization_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_organization->edit($data))
				{
					$this->session->set_flashdata('message','PO Organization has been updated successfully');
					redirect('/po_organizations/index/');
				}
			}
		}
		//Load data from database
		$row=$this->Po_organization->read($po_organization_id);
		$data['row']=$row[0];	
		$data['title']='Edit PO Organization';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('po_organizations/edit',$data);		
	}
	
	function delete($po_organization_id=null)
	{	
		if($this->Po_organization->delete($po_organization_id))
		{
			$this->session->set_flashdata('message','PO Organization has been deleted successfully');
			redirect('/po_organizations/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('po_organization_id');
		$data['name']=$this->input->post('txt_name');
		$data['organaization_code']=$this->input->post('txt_organaization_code');
		$data['head_of_the_po']=$this->input->post('txt_head_of_the_po');
		$data['established_date']=$this->input->post('txt_established_date');
		$data['logo']=$this->input->post('file_logo');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_organaization_code','Organization Code','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_head_of_the_po','Head of the PO','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_established_date','Established Date','trim|xss_clean');
	}
}
