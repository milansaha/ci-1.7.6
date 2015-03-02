<?php
/** 
	* PO Division Controller Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\controllers\po_divisions_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.po_divisions_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Po_divisions extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Po_division','',TRUE);		
	}

	function index()
	{
		$data['title']='Divisions';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_division->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_divisions/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_divisions']=$this->Po_division->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/po_divisions/index',$data);
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
				if($this->Po_division->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_divisions/add/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Division';
        $data['headline']='Add Division';
		$this->layout->view('/po_divisions/save',$data);				
	}	
	
	function edit($id=null)
	{	
		//redirect if no id provided
		if(empty($id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Division ID is not provided');
			redirect('/po_divisions/index/');
		}
		
		if($_POST)
		{
			$id=$this->input->post('txt_id');
			$this->_prepare_validation();
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				
				if($this->Po_division->edit($data))
				{
					$this->session->set_flashdata('success',EDIT_MESSAGE);
					redirect('/po_divisions/index/');
				}
			}
		}
		$data['row']=$this->Po_division->read($id);
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Division';
        $data['headline']='Edit Division';
		$this->layout->view('/po_divisions/save',$data);		
	}
	/*
     * @Modified By: Matin
     * @Modification Date : 15-03-2011
     */
    function delete($division_id=null)
	{
        if(empty($division_id))
		{
			$this->session->set_flashdata('warning','Division ID is not provided');
			redirect('/po_divisions/index/');
		}
		//Check wether the child data exists
        $has_district_entry = $this->Po_division->is_dependency_found('po_districts',  array('division_id' => $division_id));
        if($has_district_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_divisions/index/');
        }
        else
        {
            if($this->Po_division->delete($division_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_divisions/index/');
            }
        }
	}
	
	function _get_posted_data()
	{
		$data=array();
		if($this->input->post('txt_id')){
			$data['id']=$this->input->post('txt_id');
		}
		$data['name']=$this->input->post('txt_name');		
		return $data;
	}
	
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule			
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean|unique[po_divisions.name.id.txt_id]');
	}
}
