<?php
/** 
	* Samity Model Class.
	* @pupose		Samity information
	*		
	* @filesource	./system/application/models/samities.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.samities
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
 
*/ 
class Samities extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Samity','Report','Employee','Po_branch','Loan_product','Config_customized_id'),'',TRUE);	
		$this->load->library('auth');		
	}

	function index()
	{	
		$cond= "";
		$session_data = $this->session->userdata('samities.index');
		//print_r($session_data);die;
		if(isset($_POST['txt_name'])||isset($_POST['cbo_branch'])){
			$cond['name'] = $_POST['txt_name'];			
			$cond['branchname'] = $_POST['cbo_branch'];
			
			$sessionArray = array( 'samities.index'=>array('name'=>$cond['name'],
														'branchname'=>$cond['branchname'],								
														));	
					
			$this->session->unset_userdata('samities.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];
			$cond['branchname'] = $session_data['branchname'];				
		} else {
			$this->session->unset_userdata('samities.index');
		} 	
		$data['branch_infos'] = $this->Po_branch->get_branches_info();
        $data['samity_days'] = $this->Report->get_samity_days();
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Samity->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/samities/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['samities']=$this->Samity->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Samities';
		$this->layout->view('/samities/index',$data);
	}
	
	function add()
	{	
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{			
			$data=$this->_get_posted_data();			
			
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{		
				$user=$this->session->userdata('system.user');
				$data['created_by']=$user['id'];
				$data['created_date']=date("Y-m-d");				
				//Validation is OK. So, add this data and redirect to the index page				
				if($this->Samity->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/samities/add/');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		$data = $this->_load_combo_data();
		if($is_validate_error){			
			$data['row']->working_area_id = $this->input->post('cbo_working_area_id');
            $data['row']->working_area_name = $this->input->post('working_area_name');
            $data['row']->skt_amount = $this->input->post('txt_skt_amount');
            $data['row']->name = $this->input->post('txt_name');
			$data['row']->opening_date = $this->input->post('txt_opening_date');
		}
        $data['next_registration_no'] = $this->Samity->get_new_id('samities','registration_no',  $this->get_branch_id());
		$data['branch_id']=$this->auth->get_branch_id();
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Samity';
        $data['headline']='Add New';
		$this->layout->view('/samities/save',$data);
	}	
	
	function edit($samity_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($samity_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Samity ID is not provided');
			redirect('/samities/index/', 'refresh');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$samity_id=$this->input->post('samity_id');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();				
				$data['id']=$this->input->post('samity_id');
				$user=$this->session->userdata('system.user');
				$data['updated_by']=$user['id'];
				//$data['updated_by'] = '1';
				$data['updated_date']=date("Y-m-d");				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/samities/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		$data['title']='Edit Samity';
        $data['headline']='Edit';
		//Load data from database
		$data['row']=$this->Samity->read($samity_id);
		if(empty($data['row']->registration_no)){
            $data['next_registration_no'] = $this->Samity->get_new_id('samities','registration_no',  $this->get_branch_id());
        }
		$data['row']->samity_day_full=$this->Report->get_samity_day_info($data['row']->samity_day);		
        $data['has_member_entry'] = $this->Samity->is_dependency_found('members',  array('samity_id' => $samity_id));
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('samities/save',$data);
	}
	
	function view($samity_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($samity_id))
		{
			$this->session->set_flashdata('warning','Samity ID is not provided');
			redirect('/samities/index/', 'refresh');
		}
		
		$data['title']='View Samity Detail';
        $data['headline']='View Samity Detail';
		$data['row']=$this->Samity->read($samity_id);
		$data['row']->samity_day_full=$this->Report->get_samity_day_info($data['row']->samity_day);		
        $data['has_member_entry'] = $this->Samity->is_dependency_found('members',  array('samity_id' => $samity_id));
		$this->layout->view('samities/view',$data);
	}
	
    function delete($samity_id=null)
	{
        if(empty($samity_id))
		{
			$this->session->set_flashdata('warning','Samity ID is not provided');
			redirect('/samities/index/');
		}
		//Check wether the child data exists
        $has_samity_group_entry = $this->Samity->is_dependency_found('samity_groups',  array('samity_id' => $samity_id));
        $has_member_entry = $this->Samity->is_dependency_found('members',  array('samity_id' => $samity_id));
        if($has_samity_group_entry || $has_member_entry)
        {
             $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/samities/index/');
        }
        else
        {
            if($this->Samity->delete($samity_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/samities/index/');
            }
        }
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		$data['code']=$this->input->post('txt_code');
		$data['branch_id']=$this->auth->get_branch_id();
		$data['working_area_id']=$this->input->post('cbo_working_area_id');
		$data['field_officer_id']=$this->input->post('cbo_field_officer_id');
		$data['product_id']=$this->input->post('cbo_product_id');	
		$data['registration_no']=$this->input->post('txt_registration_no');	
		$data['samity_day']=$this->input->post('cbo_samity_day');	
		$data['samity_type']=$this->input->post('cbo_samity_type');	
		$data['skt_amount']=$this->input->post('txt_skt_amount');	
		$data['opening_date']=$this->input->post('txt_opening_date');
		$data['id_sequence_no'] = $this->input->post('txt_id_sequence_no');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]');		
		//$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|callback_check_samity_auto_id_config');
		$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|max_length[100]|callback_check_samity_auto_id_config|unique[samities.code.id.samity_id]');
		$this->form_validation->set_rules('cbo_working_area_id','Working Area','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_product_id','Product','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_registration_no','Registration No','trim|xss_clean|required|integer|max_length[20]');
		$this->form_validation->set_rules('cbo_samity_day','Samity Day','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_samity_type','Samity Type','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_opening_date','Openinig Date','trim|xss_clean|required|is_date');
		$this->form_validation->set_rules('cbo_field_officer_id','Field Officer','trim|xss_clean|required');
        $this->form_validation->set_rules('txt_skt_amount','SKT Amount','trim|xss_clean|numeric');
	}	
	function check_check_samity_auto_id_config($str)
	{
		$samity_auto_id_config = $this->session->userdata('config.auto_id');
		
		if( isset($samity_auto_id_config['is_samity_code_need']) AND $samity_auto_id_config['is_samity_code_need']) {
			$data['samity_code_length'] = $samity_auto_id_config['samity_code_length'];
			if($samity_auto_id_config['is_include_branch_code_for_samity']){
				$data['samity_code_separator'] = $samity_auto_id_config['samity_code_separator'];
				$data['branch_code']=$this->Po_branch->get_branch_code();
				$data['samity_code_length'] = $samity_auto_id_config['samity_code_length']+$samity_auto_id_config['branch_code_length']+strlen($samity_auto_id_config['samity_code_separator']);
			}
		}
		
		if( isset($samity_auto_id_config->is_samity_code_need) AND $samity_auto_id_config->is_samity_code_need) {
			if($samity_auto_id_config->branch_code_length != strlen($str)) {
				$this->form_validation->set_message('check_branch_auto_id_config', "The Branch ID field must be exactly {$branch_auto_id_config->branch_code_length} characters in length.");
		        return FALSE;
			}	
		}	
		return TRUE;
	}
	
	function _load_combo_data()
	{
		//This function is for listing of branches	
		$data['branch_infos'] = $this->Po_branch->get_branches_info();		
		//This function is for listing of product	
		$data['product_infos'] = $this->Loan_product->get_primary_loan_product_list();
		//Type list which will be used in combo box
		$data['samity_types'] = array('M'=>'Male','F'=>'Female');		
		//Type list which will be used in combo box		
		$data['samity_days'] = $this->Report->get_samity_days();
		//Field list which will be used in combo box	
		$data['field_officer_infos'] = $this->Employee->get_field_officer_info();
				
		// Auto ID	
		$data['samity_code'] = '';	
		$branch_id = $this->auth->get_branch_id();
				
		$branch_auto_id_config = $this->Config_customized_id->get_auto_id_config_info();
				 
		if( isset($branch_auto_id_config->is_samity_code_need) AND $branch_auto_id_config->is_samity_code_need) {
			 $max_id = $this->Samity->get_new_id('samities','id_sequence_no', $branch_id);
			 $data['id_sequence_no'] = $max_id;
			 //$data['samity_code'] = $this->zerofill($max_id,$branch_auto_id_config->samity_code_length);
			 $samitiy_code = $this->zerofill($max_id,$branch_auto_id_config->samity_code_length);
			 if( isset($branch_auto_id_config->is_include_branch_code_for_samity) AND $branch_auto_id_config->is_include_branch_code_for_samity) {			 
				$data['samity_code'] .= $this->Po_branch->get_branch_code() . $branch_auto_id_config->samity_code_separator .  $samitiy_code;			
			}		
			else{
				$data['samity_code'] .= $samitiy_code;
				}
		}
		
		//end auto id config
		
		return $data;
	}
	function ajax_for_get_samity_list_by_branch() {
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
			$samities_info = $this->Samity->get_samity_list_by_branch($branch_id);
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
	function ajax_for_get_samity_type_by_samity_id() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$samity_id      = $this->input->post('samity_id');
		$callback_message['samity_type'] = '';
		if(!empty($samity_id))
        {
            $callback_message['samity_type'] = '';
            $samity_type = $this->Samity->get_samity_type_by_samity_id($samity_id);
			if(!empty($samity_type)){	
					 $callback_message['samity_type'] = $samity_type;

			}
        }
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
	function ajax_for_get_samity_list_by_branch_samity_day() {
		$this->output->enable_profiler(false);
		$callback_message = array();
		$branch_id      = $this->input->post('branch_id');		
		$samity_day      = $this->input->post('samity_day');
		if(!is_numeric($branch_id) or empty($samity_day) or strlen($samity_day) > 3)
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select a Branch or samity day';
        }
		else
        {
			$callback_message['status'] = 'success';
			$callback_message['samity_id'][] = '';
			$callback_message['samity_name'][] = '--Select--';
			$samities_info = $this->Samity->get_samity_list_by_branch($branch_id,$samity_day);
	  		if(!empty($samities_info)) {
			  foreach( $samities_info as $row) {
				 $callback_message['samity_id'][] = $row->samity_id;
				 $callback_message['samity_name'][] = $row->samity_name;		
	  			}
			} 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
	/**
	 * @name ajax_for_get_samity_auto_search
	 * @uses member(add,edit)
	 * @lasUpdatedBy Anis Alamgir
	 * @lastDate 20-Jan-2010  
	 */
	function ajax_for_get_samity_auto_search() {
		$data=$this->Samity->get_samity_list_auto_search($this->input->post('q'));
		
		foreach($data as $row)
		{
			//print_r($row);
			echo $row->samity_id.','.$row->samity_code.','.$row->samity_name.','.$row->working_area_name.','.$row->village_name.','.$row->thana_name.','.$row->district_name.','.$row->branch_id."\n";
		}
		die;
		$this->output->enable_profiler(FALSE);		
	}
	/**
	 * @name check_samity_opening_date
	 * @uses samity(edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 13-Feb-2011
	 */
	function check_samity_opening_date()
	{
		// check samity_opening_date
		$samity_member_count = $this->Samity->get_samity_member_count($this->input->post('samity_id'),$this->input->post('txt_opening_date'));		
		if($samity_member_count >0) {
			$this->form_validation->set_message('check_samity_opening_date', " Opening date can not be changed.");
		        return FALSE;
		}		
		return TRUE;
	}
	/**
	 * @name ajax_get_samity_list_auto
	 * @uses samity ady change (add)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 13-Feb-2011
	 */
	function ajax_get_samity_list_auto()
	{
		
		$data=$this->Samity->get_samity_list_auto($this->input->post('q'));
		
		foreach($data as $row)
		{
			//print_r($row);
			echo $row->samity_id.','.$row->samity_code.','.$row->samity_name.','.$row->samity_day."\n";
		}
		//die;
		$this->output->enable_profiler(FALSE);
	}
	/**
	 * @name ajax_for_get_samity_info_by_id
	 * @uses samity day change (add)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 13-Feb-2011
	 */
	function ajax_for_get_samity_info_by_id() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$samity_id      = $this->input->post('samity_id');		
		if(empty($samity_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			$samity_info = $this->Samity->get_samity_info($samity_id);
			if(!empty($samity_info)) {
				foreach($samity_info as $row) {
				 $callback_message['samity']['id'] = $row->samity_id;
				 $callback_message['samity']['code'] = $row->samity_code;
				 $callback_message['samity']['name'] = $row->samity_name;
				 $callback_message['samity']['samity_day'] = $row->samity_day;				
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
	/**
	 * @name ajax_for_get_samity_skt_amount
	 * @uses samity  change (add)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 13-Feb-2011
	 */
	function ajax_for_get_samity_skt_amount() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$samity_id      = $this->input->post('samity_id');
		$callback_message['skt_amount'] = '';
		if(!empty($samity_id))
        {
            $callback_message['skt_amount'] = '';
            $samity_info = $this->Samity->get_samity_info($samity_id);
			if(!empty($samity_info)){	
				foreach($samity_info as $row) {
					$callback_message['samity']['skt_amount'] = $row->skt_amount;
				}
			}
        }
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
}
