<?php
/** 
	* samity employee changes Controller Class.
	* @pupose		Manage Employee branch transfers information
	*		
	* @filesource	./system/application/controllers/samity_employee_changes.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.samity_employee_changes
	* @version      $Revision: 1 $
	* @author       $Author: Sheikh Imtiaz Hossain $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Samity_employee_changes extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Samity_employee_change','Employee','Samity'),'',TRUE);		
	}
		
	function ajax_for_get_old_field_officer_list() 
	{
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$samity_id = $this->input->post('samity_id');
		if(empty($samity_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message'] = 'Select a Employee';
        }
		else
        {
			$callback_message['status'] = 'success';
			//$callback_message['branch_name'][] = '--Select--';
			$field_officer_info = $this->Samity_employee_change->get_old_field_officer_list($samity_id);
	  		foreach( $field_officer_info as $row) {
				 $callback_message['emp_name'][] = '('.$row->code.') - '.$row->name;
				 $callback_message['emp_id'][] = $row->id;		
				 $callback_message['emp_code'][] = $row->code;		
	  		}
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}

	function index()
	{
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Samity_employee_change->row_count();

		$cond= "";
		$session_data = $this->session->userdata('samity_employee_changes.index');
		if(isset($_POST['cbo_emp']) || isset($_POST['cbo_samity']))
		{
			//getting employee id
			$cond['emp_id'] = $_POST['cbo_emp'];
			//getting samity id
			$cond['samity_id'] = $_POST['cbo_samity'];
			$sessionArray = array('samity_employee_changes.index'=>array(												
													'emp_id'=>$cond['emp_id'],
													'samity_id'=>$cond['samity_id']));
			$this->session->unset_userdata('samity_employee_changes.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {		
			$cond['emp_id'] = $session_data['emp_id'];
			$cond['samity_id'] = $session_data['samity_id'];			
		} else {
			$this->session->unset_userdata('samity_employee_changes.index');
		} 
		//Initializing Pagination
		$config['base_url'] = site_url('/samity_employee_changes/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	

		//Loading data by model function call
		$data = $this->_load_combo_data();
		$data['samity_employee_transfers']=$this->Samity_employee_change->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	

        $data['headline']='Samity Field Officer Change';
	$data['title']='Samity Field Officer Change';
		$this->layout->view('/samity_employee_changes/index',$data);
	}
	
	function add()
	{
		$is_validate_error = false;
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{	
			$data = $this->_get_posted_data();
			$old_field_officer_id = $this->input->post('txt_old_field_officer_id');
			$samity_id = $this->input->post('cbo_samity');
			$effective_date = $this->input->post('txt_effective_date');
			//Perform the Validation			
			if ($this->form_validation->run() === TRUE)
			{
				//multiple entry checking on same date
				$samity_multiple_entry = $this->Samity_employee_change->samity_multiple_entry($samity_id,$effective_date);
				if($samity_multiple_entry == 0)
				{
					// check any entry have on future date
					$samity_future_entry_exsist = $this->Samity_employee_change->samity_future_entry_exsist($samity_id,$effective_date);
					if($samity_future_entry_exsist == 0)
					{
						//Validation is OK. So, add this data and redirect to the index page
						if($this->Samity_employee_change->add($data))
						{
							$this->session->set_flashdata('message','Samity Field Officer Transfer has been added successfully');
							redirect('/samity_employee_changes/add/', 'refresh');
						}
					}else{
						$this->session->set_flashdata('message','You already have entry on future date so you can\'t add on old date.');
						//$this->session->set_flashdata('message','You already have entry on this date so you can\'t add on this date again.');
						redirect('/samity_employee_changes/add/', 'refresh');
					}
				}else{
					//$this->session->set_flashdata('message','You already have entry on future date so you can\'t add on old date.');
					$this->session->set_flashdata('message','You already have entry on this date so you can\'t add on this date again.');
					redirect('/samity_employee_changes/add/', 'refresh');
				}
			}
			else 
			{
				$is_validate_error = TRUE;
			}
		}
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed		
		$data['headline']='Add Samity Field Officer Change';
		$data['title']='Add Samity Field Officer Change';
		$this->layout->view('/samity_employee_changes/add',$data);				
	}
	
	function edit($samity_employee_changes_id=null)
	{			
		//If ID is not provided, redirecting to index page
		$is_validate_error = false;
		if(empty($samity_employee_changes_id) && !$_POST)
		{
			$this->session->set_flashdata('message','Samity Employee Changes ID is not provided');
			redirect('/samity_employee_changes/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$old_field_officer_id = $this->input->post('txt_old_field_officer_id');
			$samity_id = $this->input->post('cbo_samity');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data = $this->_get_posted_data();
				$data['id'] = $this->input->post('samity_employee_changes_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity_employee_change->edit($data))
				{
					$this->session->set_flashdata('message','Samity Employee Changes has been updated successfully');
					redirect('/samity_employee_changes/index/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		else
		{
			//Load data from database
			$data = $this->_load_combo_data();
			$data['row']=$this->Samity_employee_change->read($samity_employee_changes_id);
			if(empty($data['row']))
			{
				$this->session->set_flashdata('message','Invalid  Samity Employee Changes Id');
				redirect('/samity_employee_changes/index/', 'refresh');
			}
			else
			{
				$samity_id = $data['row']->samity_id;
				$effective_date = $data['row']->effective_date;
				$samity_future_entry_exsist = $this->Samity_employee_change->samity_future_entry_exsist($samity_id,$effective_date);
				if($samity_future_entry_exsist > 0)
				{
					$this->session->set_flashdata('message','You already have entry on future date so you can\'t edit old dated data.');
					redirect('/samity_employee_changes/index');
				}
			}
			$data['headline']='Edit Samity Field Officer Change';
			$data['title']='Edit Samity Field Officer Change';
			//If data is not posted or validation fails, the add view is displayed
			$this->layout->view('samity_employee_changes/edit',$data);
		}
	}
	
	function delete($samity_employee_changes_id=null)
	{
        if(empty($samity_employee_changes_id))
		{
			$this->session->set_flashdata('warning','Samity Employee Changes ID is not provided');
			redirect('/samity_employee_changes/index/');
		}
		$data['row']=$this->Samity_employee_change->read($samity_employee_changes_id);
		if(empty($data['row']))
		{
			$this->session->set_flashdata('message','Invalid  Samity Employee Changes Id');
			redirect('/samity_employee_changes/index/', 'refresh');
		}
		else
		{
			$samity_id = $data['row']->samity_id;
			$effective_date = $data['row']->effective_date;
			$samity_future_entry_exsist = $this->Samity_employee_change->samity_future_entry_exsist($samity_id,$effective_date);
			if($samity_future_entry_exsist > 0)
			{
				$this->session->set_flashdata('message','You already have entry on future date so you can\'t delete old dated data.');
				redirect('/samity_employee_changes/index');
			}else{
				if($this->Samity_employee_change->delete($samity_employee_changes_id))
				{
					$this->session->set_flashdata('message','Employee Branch Transfer has been deleted successfully');
					redirect('/samity_employee_changes/index/');
				}
			}
		}
	}
	
	function _get_posted_data()
	{
		$data=array();
		$data['samity_id']=$this->input->post('cbo_samity');
		$data['previous_employee_id']=$this->input->post('txt_old_field_officer_id');
		$data['new_employee_id']=$this->input->post('cbo_new_field_officer');
		$data['effective_date']=$this->input->post('txt_effective_date');
		$data['comment']=$this->input->post('txt_comments');
		return $data;
	}
	
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_samity','Samity Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_old_field_officer_id','Old Field Officer Name','trim|xss_clean||max_length[100]');	
		$this->form_validation->set_rules('cbo_new_field_officer','New Field Officer Name','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_effective_date','Effective Date','trim|xss_clean|is_date|required|callback_check_joining_date|callback_check_effective_date');	
		$this->form_validation->set_rules('txt_comments','Comments','trim|xss_clean||max_length[200]');	
	}
	
	function _load_combo_data()
	{       
        // Loading employee list which will be used in employee combo box
		$data['employee_list'] = $this->Employee->get_employee_list();		
		// Loading designation list which will be used in new designation combo box
		$data['new_branch'] = $this->Samity_employee_change->get_new_branch_list();	
		$data['branches'] = $this->Samity_employee_change->get_new_branch_list();
		// Loading samity list which will be used in combo box
		$data['samities'] = $this->Samity->get_samities();
		return $data;
	}
}
