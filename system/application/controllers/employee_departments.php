<?php
class Employee_departments extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Employee_department','',TRUE);		
	}

	function index()
	{
		$data['title']='Employee Departments';
		$data['headline'] = 'Employee\'s Department Information';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee_department->row_count();

		//Initializing Pagination
		$config['base_url'] = site_url('/employee_departments/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;

		$this->pagination->initialize($config);	

		//Loading data by model function call
		$data['departments']=$this->Employee_department->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/employee_departments/index',$data);
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
				//The first param->Table Name, 2nd Param: id field
				$data['id'] = $this->Employee_department->get_new_id('employee_departments', 'id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_department->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employee_departments/add/');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Department';
        $data['headline'] = 'Add Department';
		$this->layout->view('/employee_departments/add',$data);				
	}	
	
	function edit($department_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($department_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Department ID is not provided');
			redirect('/employee_departments/index/');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$department_id=$_POST['department_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('department_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_department->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employee_departments/index/');
				}
			}
		}
		//Load data from database
		$data['row'] = $this->Employee_department->read($department_id);
		$data['title'] = 'Edit Department';
        $data['headline'] = 'Edit Department';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employee_departments/edit',$data);		
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($department_id=null)
	{
        if(empty($department_id))
		{
			$this->session->set_flashdata('warning','Department ID is not provided');
			redirect('/employee_departments/index/');
		}
		//Check wether the child data exists
        $has_designation_entry = $this->Employee_department->is_dependency_found('employee_designations',  array('department_id' => $department_id));

        if($has_designation_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/employee_departments/index/');
        }
        else
        {
            if($this->Employee_department->delete($department_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/employee_departments/index/');
            }
        }
	}

	function _get_posted_data()
	{
		$data=array();
		$data['name']=$this->input->post('txt_name');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|unique[employee_departments.name.id.department_id]|max_length[100]');	
	}
}
