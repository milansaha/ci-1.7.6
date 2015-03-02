<?php
/** 
	* Employee Informatin Controller Class.
	* @pupose		Manage Employee information
	*		
	* @filesource	./system/application/controllers/employees.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.employees
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Employees extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
        $this->load->helper(array('form','date'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Employee','Employee_designation','Educational_qualification','Po_branch','Loan_product'),'',TRUE);		
		$this->load->library('employees_lib','MY_Form_validation');	
	}

	function index()
	{
		$data = $this->_load_combo_data();
		
		$cond= "";
		$session_data = $this->session->userdata('employee.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_employee_designation'])){
			$cond['name'] = $_POST['txt_name'];
			$cond['employee_designation'] = $_POST['cbo_employee_designation'];
			$sessionArray = array( 'employee.index'=>array('name'=>$cond['name'],'employee_designation'=>$cond['employee_designation']));
			$this->session->unset_userdata('employee.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['name'] = $session_data['name'];
			$cond['employee_designation'] = $session_data['employee_designation'];
		} else {
			$this->session->unset_userdata('employee.index');
		} 
		//$this->session->unset_userdata('employee.index');
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Employee->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/employees/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		//Loading data by model function call
		$data['employees_info']=$this->Employee->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$data['title']='Employees';
		$this->layout->view('/employees/index',$data);
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
				if($this->Employee->add($data))
				{
					//$this->employees_lib->add($data);
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/employees/add/', 'refresh');
				}
			} 
			else {
			    $del_employee_picture = $this->session->userdata('txt_employee_picture.file_name');				
				if (!empty($del_employee_picture)) {
				    @unlink(IMAGE_UPLOAD_PATH.$del_employee_picture);
				}
				$this->session->unset_userdata('txt_employee_picture.file_name');
			}
		}		
		$data = $this->_load_combo_data();		
		
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Employee';
		$data['headline']='Add New';
		$this->layout->view('/employees/save',$data);				
	}	
	
	function edit($employee_id=null)
	{	
		
		//If ID is not provided, redirecting to index page
		if(empty($employee_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Employee ID is not provided');
			redirect('/employees/index/', 'refresh');
		}
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			$this->_prepare_validation();
			$employee_id=$_POST['employee_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data['id']=$this->input->post('employee_id');
				//Validation is OK. So, add this data and redirect to the index page
				
				if($this->Employee->edit($data))
				{
					$this->session->unset_userdata('txt_employee_picture.file_name');
					// delete exitng photo.
					if (!empty($_POST['txt_employee_picture_edit'] )) {
					    @unlink((IMAGE_UPLOAD_PATH.$_POST['txt_employee_picture_edit']));
					    
					} 
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/employees/index/', 'refresh');
				}
			} else {
			     $del_employee_picture = $this->session->userdata('txt_employee_picture.file_name');
				
				if (!empty($del_employee_picture)) {
				    @unlink(IMAGE_UPLOAD_PATH.$del_employee_picture);
				}
				$this->session->unset_userdata('txt_employee_picture.file_name');
			}
		}		
		$data = $this->_load_combo_data();
		//Load data from database
		$data['row']=$this->Employee->read($employee_id);
		$data['title']='Edit Employee';
		$data['headline']='Edit Employee';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employees/save',$data);		
	}
	
	function view($employee_id=null)
	{
		//If ID is not provided, redirecting to index page
		if(empty($employee_id))
		{
			$this->session->set_flashdata('warning','Employee ID is not provided');
			redirect('/employees/index/', 'refresh');
		}		
		//Load data from database
		$data['row']=$this->Employee->read_view($employee_id);		
		$data['title']='View Employee';
		$data['headline']='View Employee';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('employees/view',$data);		
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 09-04-2011
     */
    function delete($employee_id=null)
	{
        if(empty($employee_id))
		{
			$this->session->set_flashdata('warning','Employee ID is not provided');
			redirect('/employees/index/');
		}
		$has_employee_history_entry = $this->Employee->is_dependency_found('employee_histories',  array('employee_id' => $employee_id)); 
		$has_employee_termination_entry = $this->Employee->is_dependency_found('employee_terminations',  array('employee_id' => $employee_id)); 
		$has_samity_entry = $this->Employee->is_dependency_found('samities',  array('field_officer_id' => $employee_id));    
		if($has_employee_history_entry || $has_employee_termination_entry || $has_samity_entry)
        {
        	$this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/employees/index/');
        }
        else
        {
            $data = $this->Employee->read($employee_id);
            $picture = (isset ($data->employee_picture))?$data->employee_picture:'';
			if($this->Employee->delete($employee_id))
		    {
                // delete exitng photo.
                if(file_exists(IMAGE_UPLOAD_PATH.$picture))
                {
                    @unlink((IMAGE_UPLOAD_PATH.$picture));
                }
		        $this->session->set_flashdata('message',DELETE_MESSAGE);
		        redirect('/employees/index/');
		    }
		}
	}

	function _get_posted_data()
	{
		$data=array();
		
		$data['designation_id']=$this->input->post('cbo_employee_designation');
		$data['name']=$this->input->post('txt_name');
        $data['branch_id']=$this->input->post('cbo_branch');
		$data['code']=$this->input->post('txt_code');
		$data['fathers_name']=$this->input->post('txt_fathers_name');
		$data['mothers_name']=$this->input->post('txt_mothers_name');
		$data['spouse_name']=$this->input->post('txt_spouse_name');
		$data['permanent_address']=$this->input->post('txt_permanent_address');
		$data['present_address']=$this->input->post('txt_present_address');
		$data['last_achieved_degree']=$this->input->post('cbo_last_achieved_degree');
		$data['date_of_birth']=$this->input->post('txt_date_of_birth');
		$data['date_of_joining']=$this->input->post('txt_date_of_joining');
        $data['is_field_officer']=$this->input->post('cbo_is_field_officer');
		$data['secuirity_money']=$this->input->post('txt_secuirity_money');
        $data['secuirity_money'] = (!empty ($data['secuirity_money']))?$data['secuirity_money']:NULL;
		$data['starting_salary']=$this->input->post('txt_starting_salary');
        $data['starting_salary'] = (!empty ($data['starting_salary']))?$data['starting_salary']:NULL;
		$data['current_salary']=$this->input->post('txt_current_salary');
        $data['current_salary'] = (!empty ($data['current_salary']))?$data['current_salary']:NULL;
		$data['national_id']=$this->input->post('txt_national_id');
		$data['status']=$this->input->post('cbo_status');		
		$data['refence_info_1']=$this->input->post('txt_refence_info_1');
		$data['refence_info_2']=$this->input->post('txt_refence_info_2');

        //configure Image upload
		$config['upload_path'] = IMAGE_UPLOAD_PATH;
		$config['allowed_types'] = IMAGE_UPLOAD_ALLOWED_TYPES;
		$config['max_size']	= IMAGE_UPLOAD_SIZE;
		$config['max_width']  = IMAGE_UPLOAD_MAX_WIDTH;
		$config['max_height']  = IMAGE_UPLOAD_MAX_HEIGHT;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);

		$this->session->unset_userdata('txt_employee_picture.error');
		$this->session->unset_userdata('txt_employee_picture.file_name');
      
        if(! empty($_FILES['txt_employee_picture']['name']) ){
    		if ( ! $this->upload->do_upload('txt_employee_picture'))
    		{
                $error = array('error' => $this->upload->display_errors());
    			$sessionArray = array('txt_employee_picture.error'=>$error);
    			$this->session->set_userdata($sessionArray);		
    	    }
    		else
    		{
    			$data['employee_picture'] = $this->upload->data();
    			$data['employee_picture'] = $data['employee_picture']['file_name'];
    			$sessionArray = array('txt_employee_picture.file_name'=>$data['employee_picture']);
    			$this->session->set_userdata($sessionArray);
    		}
		}        
		return $data;		
	}
    
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation numeric
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required');	
		$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|unique[employees.code.id.employee_id]');
        $this->form_validation->set_rules('cbo_branch','Brach','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_fathers_name','Father Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_mothers_name','Mother Name','trim|xss_clean|required');
        $this->form_validation->set_rules('cbo_employee_designation','Designation','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_spouse_name','Spouse Name','trim|xss_clean|max_length[200]');	
		$this->form_validation->set_rules('txt_permanent_address','Permanent Address','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_present_address','Present Address','trim|xss_clean|required');	
		$this->form_validation->set_rules('cbo_last_achieved_degree','Last Achieved Degree','trim|xss_clean|required');
        $this->form_validation->set_rules('txt_date_of_birth','Date of Birth','trim|required|is_date|max_length[10]|xss_clean|callback_check_employees_age_over_18');
		$this->form_validation->set_rules('txt_date_of_joining','Date of Joining','required|max_length[10]|is_date|callback_check_employees_joining_date_greater_than_birth_date');
        $this->form_validation->set_rules('cbo_is_field_officer','Can manage Loan','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_date_of_discontinue','Date of Discontinue','is_date|max_length[10]');
		$this->form_validation->set_rules('txt_secuirity_money','Security Money','trim|numeric');	
		$this->form_validation->set_rules('txt_national_id','National ID','trim|min_length[13]|max_length[14]|unique[employees.national_id.id.employee_id]');
		$this->form_validation->set_rules('cbo_status','Status','trim');
		$this->form_validation->set_rules('txt_refence_info_1','Reference Info 1','trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('txt_refence_info_2','Reference Info 2','trim|xss_clean|max_length[200]');		
		$this->form_validation->set_rules('txt_starting_salary','Starting Salary','trim|numeric');
		$this->form_validation->set_rules('txt_current_salary','Current Salary','trim|numeric');
        $this->form_validation->set_rules('txt_employee_picture','Employee Picture','callback_employee_picture_check_img');  
        //$this->form_validation->set_rules('file_attached_documents','Attached Documents','callback_checkfile_attached_documents');

	}
	function employee_picture_check_img()
	{
    	$res = TRUE;
    	$data = $this->session->userdata('txt_employee_picture.error');
        if(isset($data['error']))
        {
    		$this->form_validation->set_message('employee_picture_check_img', $data['error']);
    		$this->session->unset_userdata('txt_employee_picture.error');
    		$res = FALSE;
        }    
        return $res;
    }
	function _load_combo_data()
	{
		//This function is for listing of designations	
		$data['employee_designation_infos'] = $this->Employee_designation->get_employee_designations();		
		
		$data['status_info'] = array('1'=>'Active','0'=>'Inactive');
        $data['educational_qualification'] = $this->Educational_qualification->get_qualification_list();
        $data['branch_infos'] = $this->Po_branch->get_branches_info();
		return $data;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check the age of employee is greater than or equal to 18
     * @Modification Date: 23-03-2011
     */
    function check_employees_age_over_18($str) {
		if(!$this->is_date($str)) {
				$this->form_validation->set_message('check_employees_age_over_18', "Birth Date must be a valid date.");
			        return FALSE;
		}
		
        $software_date = date('Y-n-d');
	
		$software_date  = explode('-',$software_date);
		$birth_date  = explode('-',$str);
		
		if(mysql_to_unix("{$software_date[0]}{$software_date[1]}{$software_date[2]}") - mysql_to_unix("{$birth_date[0]}{$birth_date[1]}{$birth_date[2]}") < 568080000)	{

        $this->form_validation->set_message('check_employees_age_over_18', "Employee age must be greater than or equal 18.");
            return FALSE;
        }
		return TRUE;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check wether the joining date is less than the birth date
     * @Modification Date: 23-03-2011
     */
    function check_employees_joining_date_greater_than_birth_date($str)
    {
        if($_POST)
            {
                $birth_date = $this->input->post('txt_date_of_birth');
                if(!empty($birth_date))
                {
                    $birth_date  = explode('-',$birth_date);
                    $joining_date  = explode('-',$str);
                    if(mysql_to_unix("{$birth_date[0]}{$birth_date[1]}{$birth_date[2]}") > mysql_to_unix("{$joining_date[0]}{$joining_date[1]}{$joining_date[2]}"))
                    {
                        $this->form_validation->set_message('check_employees_joining_date_greater_than_birth_date', 'Joining Date can\'t be greater than birth date.');
                        return FALSE;
                    }
                }
                return TRUE;
            }
    }
}
