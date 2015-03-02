<?php
/** 
	* PO Zone Area Details Controller Class.
	* @pupose		PO Zone Area Details information
	*		
	* @filesource	./system/application/models/po_zone_area_details.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_zone_area_details
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-05 $	 
*/ 
class Po_zone_area_details extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Po_zone_area_detail','',TRUE);		
	}

	function index()
	{
		$data['headline']='PO Zone Area Details List';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_zone_area_detail->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_zone_area_details/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$list = $this->pagination->initialize($config);	
		if($list){
			//Loading data by model function call
			$data['po_zone_area_detail_infos']=$this->Po_zone_area_detail->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
			$data['counter'] = (int)$this->uri->segment(3);
			$this->layout->view('/po_zone_area_details/index',$data);
		}else{
			$this->layout->view('/pages/no_data_found.php');
		}
	}
	
	function add()
	{
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_zone_area_detail->add($data))
				{
					$this->session->set_flashdata('message','PO Zone Area has been added successfully');
					redirect('/po_zone_area_details/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed		
		$data['headline']='Add PO Zone Area Details';
		$this->layout->view('/po_zone_area_details/add',$data);				
	}	
	
	function edit($designation_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($designation_id) && !$_POST)
		{
			$this->session->set_flashdata('message','PO Zone Area ID is not provided');
			redirect('/po_zone_area_details/index/', 'refresh');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//$designation_id=$_POST['designation_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('po_zone_area_detail_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_zone_area_detail->edit($data))
				{
					$this->session->set_flashdata('message','PO Zone Area has been updated successfully');
					redirect('/po_zone_area_details/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$data['headline']='Edit PO Zone Area Details';
		$row=$this->Po_zone_area_detail->read($designation_id);
		$data['row']=$row[0];	
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('po_zone_area_details/edit',$data);		
	}
	
	function delete($designation_id=null)
	{	
		if($this->Po_zone_area_detail->delete($designation_id))
		{
			$this->session->set_flashdata('message','PO Zone Area has been deleted successfully');
			redirect('/po_zone_area_details/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('designation_id');
		$data['zone_id']=$this->input->post('cbo_zones');
		$data['area_id']=$this->input->post('cbo_areas');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule						
		$this->form_validation->set_rules('cbo_zones','Zone','required');
		$this->form_validation->set_rules('cbo_areas','Area','required');
	}
	
	function _load_combo_data()
	{
		//This function is for listing of zones	
		$data['po_zone_infos'] = $this->Po_zone_area_detail->get_po_zones();
		//This function is for listing of areas	
		$data['po_area_infos'] = $this->Po_zone_area_detail->get_po_areas();
		return $data;
	}
}
