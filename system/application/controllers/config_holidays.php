<?php
class Config_holidays extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Config_holiday','',TRUE);		
	}

	function index()
	{		
		$data = $this->_load_combo_data();
		$cond= "";
		$session_data = $this->session->userdata('Config_holiday.index');
		if(isset($_POST['txt_from_date']) || isset($_POST['txt_to_date']) || isset($_POST['cbo_holiday_type'])|| isset($_POST['cbo_user_branch'])){
			
			$cond['from_date'] = $_POST['txt_from_date'];
			$cond['to_date'] =  $_POST['txt_to_date'];			
			$cond['holiday_type'] = $_POST['cbo_holiday_type'];
			$cond['user_branch'] = $_POST['cbo_user_branch'];
			
			
			$sessionArray = array( 'Config_holiday.index'=>array(
												'from_date'=>$cond['from_date'],
												'to_date'=>$cond['to_date'],
												'holiday_type'=>$cond['holiday_type'],
												'user_branch'=>$cond['user_branch']																						
												));
			//print_r($session_data);
			$this->session->unset_userdata('Config_holiday.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['from_date'] = $session_data['from_date'];
			$cond['to_date'] = $session_data['to_date'];
			$cond['holiday_type'] = $session_data['holiday_type'];
			$cond['user_branch'] = $session_data['user_branch'];			
		} else {
			$this->session->unset_userdata('Config_holiday.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Config_holiday->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/config_holidays/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['config_holiday']=$this->Config_holiday->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Holiday Configuration';
        $data['headline']='Holiday Configuration';
		$this->layout->view('/config_holidays/index',$data);
	}
	function ajax_method_for_get_branch_list() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$branch_id      = $this->input->post('branch_id');
		if(empty($branch_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select a Branch';
        }
		else
        {
			$callback_message['status'] = 'success';
			$callback_message['samity_id'][] = '';
			$callback_message['samity_name'][] = '--Select--';
			$samities_info = $this->Config_holiday->get_samity_by_branch($branch_id);
	  		 foreach( $samities_info as $row) {
				 $callback_message['samity_id'][] = $row->samity_id;
				 $callback_message['samity_name'][] = $row->samity_name;		
	  		}
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
	function add()
	{
		$is_validate_error = FALSE;
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$category = 'Organization';
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			$category = $_POST['rdo_category'];
			$branch_id = $_POST['cbo_branch'];
			if ($this->form_validation->run() == TRUE)
			{
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Config_holiday->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/config_holidays/index/', 'refresh');
				}
			}
			else {
				$is_validate_error = TRUE;
				//print_r($_POST);
				//die;
			}
			 if($is_validate_error){
			
			}
		}
		$data = $this->_load_combo_data(isset($branch_id)?$branch_id:"");
		$data['rdo_category'] = $category;
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Holiday Configuration';
        $data['headline'] = 'Add New';
		$this->layout->view('/config_holidays/save',$data);				
	}	
	
	function edit($config_holiday_id=null)
	{			
		//If ID is not provided, redirecting to index page
		if(empty($config_holiday_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Holiday ID is not provided');
			redirect('/config_holidays/index/', 'refresh');
		}
		$is_validate_error = FALSE;
		$category = 'Organization';
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//$config_holiday_id=$_POST['config_holiday_id'];
			
			$config_holiday_id =$this->input->post('config_holiday_id');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				 $data['id']=$this->input->post('config_holiday_id');
				$category = $_POST['rdo_category'];
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Config_holiday->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/config_holidays/index/', 'refresh');
				}
			}
			
			else {
				$is_validate_error = TRUE;
				//print_r($_POST);
				//die;
			}
		}
		//Load data from database
		$row=$this->Config_holiday->read($config_holiday_id);
		//echo "$config_holiday_id <pre>";print_r($row);
		
		$branch_id = (isset($row->branch_id) AND $row->branch_id > 0)?$row->branch_id:"";
		$samity_id = (isset($row->samity_id) and $row->samity_id > 0)?$row->samity_id:"";
		if(is_numeric($samity_id)){
			$category = 'Samity';
		}elseif(is_numeric($branch_id)){
			$category = 'Branch';
		}
		$data = $this->_load_combo_data($branch_id);
		$data['row']=$row;
		$data['title']='Edit Holiday Configuration';
        $data['headline'] = 'Edit';
        
		$data['rdo_category'] = $category;
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('config_holidays/save',$data);		
	}
	
	function delete($config_holiday_id=null)
	{
        if(empty($config_holiday_id))
		{
			$this->session->set_flashdata('warning','Holiday Configuration ID is not provided');
			redirect('/config_holidays/index/');
		}
		if($this->Config_holiday->delete($config_holiday_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/config_holidays/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('config_holiday_id');
		$data['holiday_date']=$this->input->post('txt_holiday_date');
		$data['holiday_type']=$this->input->post('cbo_holiday_type');
		$data['description']=$this->input->post('txt_description');
		// check holiday category
		if($this->input->post('rdo_category') === 'Organization') {
			$data['branch_id']="";	
			$data['samity_id']="";
		} elseif($this->input->post('rdo_category') === 'Branch') {
			$data['branch_id']=$this->input->post('cbo_branch');
			$data['samity_id']="";
		} else {
			$data['branch_id']=$this->input->post('cbo_branch');
			//$data['branch_id']="";		
			$data['samity_id']=$this->input->post('cbo_samity');			
		}	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_holiday_date','Holiday Date','required|is_date|max_length[10]|callback_check_unique');
		$this->form_validation->set_rules('txt_description','Description','trim|xss_clean|max_length[255]');
		$this->form_validation->set_rules('cbo_branch','Branch Name','numeric|callback_check_branch_required');
		$this->form_validation->set_rules('cbo_samity','Samity Name','numeric|callback_check_samity_required');
		$this->form_validation->set_rules('cbo_holiday_type','Holiday Type','required');
	}
	
	function check_branch_required()
	{    	
    	$res = TRUE;
    	$category = $_POST['rdo_category'];
        if($category == 'Branch' || $category == 'Samity')
        {
    		if(isset($_POST['cbo_branch']) && empty($_POST['cbo_branch'])){
				$this->form_validation->set_message('check_branch_required', 'The Branch Name field is required.');
				$res = FALSE;
			}    		
        }    
        return $res;
    }
    function check_samity_required()
	{    	
    	$res = TRUE;
    	$category = $_POST['rdo_category'];
        if($category == 'Samity')
        {
    		if(isset($_POST['cbo_samity']) && empty($_POST['cbo_samity'])){
				$this->form_validation->set_message('check_samity_required', 'The Samity Name field is required.');
				$res = FALSE;
			}    		
        }    
        return $res;
    }
    function check_unique()
	{   
		//print_r($_POST) 	;
    	//die;
    	$res = TRUE;
    	$branch_id = (isset($_POST['cbo_branch']) and !empty($_POST['cbo_branch']))?$_POST['cbo_branch']:0;
    	$samity_id = (isset($_POST['cbo_samity']) and !empty($_POST['cbo_samity']))?$_POST['cbo_samity']:0;
    	$category = $_POST['rdo_category'];
    	$date = $_POST['txt_holiday_date'];
    	$holiday_id = isset($_POST['config_holiday_id'])?$_POST['config_holiday_id']:"";
        if($category == 'Organization')
        {    		
    		if($this->Config_holiday->holiday_unique($date,0,0,$holiday_id)){
				$this->form_validation->set_message('check_unique', 'The Holiday Date already inserted for Organization.');
				$res = FALSE;
			}    		
        } elseif($category == 'Branch')
        {    		
    		if($this->Config_holiday->holiday_unique($date,$branch_id,0,$holiday_id)){
				$this->form_validation->set_message('check_unique', 'The Holiday Date already inserted for Branch.');
				$res = FALSE;
			}    		
        } elseif($category == 'Samity')
        {    		
    		if($this->Config_holiday->holiday_unique($date,$branch_id,$samity_id,$holiday_id)){
				$this->form_validation->set_message('check_unique', 'The Holiday Date already inserted for Samity.');
				$res = FALSE;
			}    		
        }  
        return $res;
    }
	function _load_combo_data($branch_id = -1)
	{
		//This function is for listing of Holiday	
          $data['holiday_types'] = array('Weekly'=>'Weekly','Holiday'=>'Holiday','Others'=>'Others');
          $data['search_holiday_types'] = array('-1'=>'--Select--','Weekly'=>'Weekly','Holiday'=>'Holiday','Others'=>'Others');
		  $data['branch_infos'] = $this->Config_holiday->get_branch();
		  $data['samity_infos'] = $this->Config_holiday->get_samity_by_branch($branch_id);		
		return $data;
	}
	
	function cli_reschedule_due_to_holday_entry()
	{
		//disabling the profiler
		$this->output->enable_profiler(FALSE);
		//checking if called from web
		if (isset($_SERVER['REMOTE_ADDR'])) {  
			die('[cli_reschedule_due_to_holday_entry] Error! This method should be called from Command Line Only.');
		}  
		//perform the execution
		echo "cli_reschedule_due_to_holday_entry() called\n";
	}
}
