<?php
/**
	* Educational Qualifications Controller Class.
	* @pupose		Manage Educational Qualifications
	*
	* @filesource	\app\controllers\educational_qualifications.php
	* @package		microfin
	* @version      $Revision: 1 $
	* @author       $Author: Matin $
	* @modification $Date: 06-04-2011 $
*/

class Educational_qualifications extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Educational_qualification','',TRUE);
	}

	function index()
	{
		$data['title']='Educational Qualifications';
        $data['headline']='Educational Qualifications';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Educational_qualification->row_count();

		//Initializing Pagination
		$config['base_url'] = site_url('/educational_qualifications/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);

		//Loading data by model function call
		$data['educational_qualifications']=$this->Educational_qualification->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/educational_qualifications/index',$data);
	}

	function add()
	{
		$this->_prepare_validation();
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Educational_qualification->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/educational_qualifications/add/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Educational Qualification';
        $data['headline']='Add New';
		$this->layout->view('/educational_qualifications/save',$data);
	}

	function edit($id=null)
	{
		//redirect if no id provided
		if(empty($id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Educational Qualification ID is not provided');
			redirect('/educational_qualifications/index/');
		}

		if($_POST)
		{
			$id=$this->input->post('txt_id');
			$this->_prepare_validation();
			if ($this->form_validation->run() === TRUE)
			{
				$data=$this->_get_posted_data();

				if($this->Educational_qualification->edit($data))
				{
					$this->session->set_flashdata('success',EDIT_MESSAGE);
					redirect('/educational_qualifications/index/');
				}
			}
		}
		$data['row']=$this->Educational_qualification->read($id);
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Educational Qualification';
        $data['headline']='Edit';
		$this->layout->view('/educational_qualifications/save',$data);
	}
	/*
     * @Modified By: Matin
     * @Modification Date : 15-03-2011
     */
    function delete($ducational_qualification_id=null)
	{
        if(empty($ducational_qualification_id))
		{
			$this->session->set_flashdata('warning','Educational Qualification ID is not provided');
			redirect('/educational_qualifications/index/');
		}
		//Check wether the child data exists
        $has_member_entry = $this->Educational_qualification->is_dependency_found('members',  array('last_achieved_degree' => $ducational_qualification_id));
        $has_employee_entry = $this->Educational_qualification->is_dependency_found('employees',  array('last_achieved_degree' => $ducational_qualification_id));
        if($has_member_entry || $has_employee_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/educational_qualifications/index/');
        }
        else
        {
            if($this->Educational_qualification->delete($ducational_qualification_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/educational_qualifications/index/');
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
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean|unique[educational_qualifications.name.id.txt_id]');
	}
}
