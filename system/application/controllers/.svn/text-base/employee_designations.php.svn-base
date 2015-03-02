<?php
/** 
	* Employee Designation Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/employee_designation.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.employee_designation
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Employee_designations extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Employee_designation','Employee_department'),'',TRUE);		
	}

	function index()
	{
		$data['title']='Employee Designations';
        $data['headline']='Employee Designations';
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee_designation->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employee_designations/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['designations']=$this->Employee_designation->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/employee_designations/index',$data);
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
				$data['id'] = $this->Employee_designation->get_new_id('employee_designations', 'id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_designation->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employee_designations/add/');
				}
			}
		}
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title'] = 'Add Designation';
        $data['headline'] = 'Add Designation';
		$this->layout->view('/employee_designations/add',$data);				
	}	
	
	function edit($designation_id=null)
	{
		//If ID is not provided, redirecting to index page
		if(empty($designation_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Designation ID is not provided');
			redirect('/employee_designations/index/');
		}

		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$designation_id=$_POST['designation_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('designation_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Employee_designation->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employee_designations/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$data['row']=$this->Employee_designation->read($designation_id);

		$data['title']='Edit Designation';
        $data['headline']='Edit Designation';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employee_designations/edit',$data);		
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($designation_id=null)
	{
        if(empty($designation_id))
		{
			$this->session->set_flashdata('warning','Designation ID is not provided');
			redirect('/employee_designations/index/');
		}
		//Check wether the child data exists
        $has_employees_entry = $this->Employee_designation->is_dependency_found('employees',  array('designation_id' => $designation_id));

        if($has_employees_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/employee_designations/index/');
        }
        else
        {
            if($this->Employee_designation->delete($designation_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/employee_designations/index/');
            }
        }
	}

	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('designation_id');
		$data['name']=$this->input->post('txt_name');
		$data['department_id']=$this->input->post('cbo_department');
		$data['code']=$this->input->post('txt_code');
		$data['short_name']=$this->input->post('txt_short_name');
		$data['is_manager']=$this->input->post('cbo_is_manage');
		return $data;
	}
	
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]|unique[employee_designations.name.id.designation_id]');
		$this->form_validation->set_rules('cbo_department','Department','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_short_name','Short Name','trim|xss_clean|required|max_length[100]');
		$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|max_length[100]');		
	}
	
	function _load_combo_data()
	{
		//This function is for listing of departments	
		$data['departments'] = $this->Employee_department->get_employee_departments();
		return $data;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check the duplicate designation under the same Depatment
     * @Use: Useed in _prepare_validation() method
     * @Modification Date: 24-03-2011
     */
    function chek_duplicate_designation_in_same_department()
    {        
        $CI =& get_instance();        
		$CI->load->database();
        if($_POST)
        {
            $data = $this->_get_posted_data();          
            $this->form_validation->set_message('chek_duplicate_designation_in_same_department','The %s is already being used under the selected Department.');
            if ( isset($data['name']) and ! empty($data['name']) and isset($data['department_id']) and ! empty($data['department_id']))
            {
                $query = $CI->db->select('name')->from('employee_designations')->where(array('department_id' =>$data['department_id'],'name' => $data['name']) )->limit(1)->get();
            }           
        }
       return $query->row()?false:true;        
    }
}
