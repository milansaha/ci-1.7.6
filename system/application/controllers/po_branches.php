<?php
/** 
	* PO Branch Informatin Controller Class.
	* @pupose		Manage PO Funding Organizations information
	*		
	* @filesource	./system/application/controllers/po_branches.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.po_branches
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-17 $	 
*/ 
class Po_branches extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_branch','Config_customized_id'),TRUE);
	}

	function index()
	{
		$data['title'] = 'Branch Information';
		$data['headline'] = 'Branch Information';		
		$cond= "";
		$session_data = $this->session->userdata('po_branch.index');
		if(isset($_POST['txt_name']) || isset($_POST['txt_from_date']) || isset($_POST['txt_to_date'])){
			
			$cond['from_date'] = $_POST['txt_from_date'];
			$cond['to_date'] =  $_POST['txt_to_date'];			
			$cond['name'] = $_POST['txt_name'];						
			
			$sessionArray = array( 'po_branch.index'=>array(
												'from_date'=>$cond['from_date'],
												'to_date'=>$cond['to_date'],
												'name'=>$cond['name']																																	
												));
			//print_r($session_data);
			$this->session->unset_userdata('po_branch.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			//print_r($session_data);
			$cond['from_date'] = $session_data['from_date'];
			$cond['to_date'] = $session_data['to_date'];
			$cond['name'] = $session_data['name'];
						
		} else {
			$this->session->unset_userdata('po_branch.index');
		} 	
		
				
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_branch->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_branches/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_branches_info']=$this->Po_branch->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/po_branches/index',$data);
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
				if($this->Po_branch->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_branches/add/', 'refresh');
				}
			}
		}
		
		//If data is not posted or validation fails, the add view is displayed	
		$data = $this->_load_combo_data();	
		$data['headline']='Add New';
		$data['title'] = 'Add New Branch';
		$this->layout->view('/po_branches/save',$data);				
	}	
	
	function edit($po_branch_id=null)
	{       
		if(empty($po_branch_id) && !$_POST)
		{
			$this->session->set_flashdata('message','PO Branch ID is not provided');
			redirect('/po_branches/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('po_branch_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_branch->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_branches/index/', 'refresh');
				}
			}else{
                $is_validation_error = true;
            }
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$data['headline']='Edit';
		$data['row']=$this->Po_branch->read($po_branch_id);        
		$data['title'] = 'Edit Branch';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('po_branches/save',$data);		
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($po_branch_id=null)
	{
        if(empty($po_branch_id))
		{
			$this->session->set_flashdata('warning','PO Branch ID is not provided');
			redirect('/po_branches/index/');
		}
		//Check wether the child data exists
        $has_samities_entry = $this->Po_branch->is_dependency_found('samities',  array('branch_id' => $po_branch_id));
        $has_suser_entry = $this->Po_branch->is_dependency_found('users',  array('default_branch_id' => $po_branch_id));
        if($has_samities_entry || $has_suser_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_branches/index/');
        }
        else
        {
            if($this->Po_branch->delete($po_branch_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_branches/index/');
            }
        }
	}


	function _get_posted_data()
	{
		$data=array();		
		$data['code']=$this->input->post('txt_code');
		$data['name']=$this->input->post('txt_name');		
		$data['opening_date']=$this->input->post('txt_opening_date');
		//$data['branch_images']=$this->input->post('txt_branch_images');
        $data['land_phone']=$this->input->post('txt_land_phone');
        $data['mobile_phone']=$this->input->post('txt_mobile_phone');
        $data['email']=$this->input->post('txt_email');
        $data['address']=$this->input->post('txt_address');
		$data['is_head_office']=$this->input->post('cbo_is_head_office');
		return $data;
	}
	
	function _load_combo_data()
	{		
		// auto id config data
		$data['branch_code'] = '';
		
		// Auto ID		
		$branch_auto_id_config = $this->Config_customized_id->get_auto_id_config_info();
		//$branch_auto_id_config =$branch_auto_id_config[0];
		
		if( isset($branch_auto_id_config->is_branch_code_need) AND $branch_auto_id_config->is_branch_code_need) {
			 $max_id = $this->Po_branch->get_new_id('po_branches','code');
			 $data['branch_code'] = $this->zerofill($max_id,$branch_auto_id_config->branch_code_length);
		}
		//end auto id config
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule			
		$this->form_validation->set_rules('txt_code','Branch ID','trim|xss_clean|required|max_length[50]|callback_check_branch_auto_id_config|unique[po_branches.code.id.po_branch_id]');
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]');
		$this->form_validation->set_rules('txt_opening_date','Opening Date','trim|xss_clean|required|is_date|max_length[10]');
        $this->form_validation->set_rules('txt_land_phone','Land Phone','trim|xss_clean|max_length[20]');
        $this->form_validation->set_rules('txt_mobile_phone','Mobile Phone','trim|xss_clean|max_length[20]');
        $this->form_validation->set_rules('txt_email','Email','trim|xss_clean|valid_email|max_length[100]');
        $this->form_validation->set_rules('txt_address','Address','trim|xss_clean|required|max_length[255]');
        $this->form_validation->set_rules('cbo_is_head_office','Head Office','trim|xss_clean|required|callback_check_duplicate_head_office');
	}	
	function check_branch_auto_id_config($str)
	{
		$branch_auto_id_config = $this->Config_customized_id->get_auto_id_config_info();
		
		if( isset($branch_auto_id_config->is_branch_code_need) AND $branch_auto_id_config->is_branch_code_need) {
			if($branch_auto_id_config->branch_code_length != strlen($str)) {
				$this->form_validation->set_message('check_branch_auto_id_config', "The Branch ID field must be exactly {$branch_auto_id_config->branch_code_length} characters in length.");
		        return FALSE;
			}	
		}	
		return TRUE;
	}
    /*
     * @Author: Matin
     * @Modification Date : 06-04-2011
     * @Use : Check duplicate head office entry
     */
    function check_duplicate_head_office()
    {        
        $branch_id = $this->input->post('po_branch_id');
        $cbo_is_head_office = $this->input->post('cbo_is_head_office');
        $branch_id = (!empty ($branch_id))?$branch_id:'';
        $has_head_office = $this->Po_branch->check_duplicate_head_office($branch_id);
        if($has_head_office == '1' and $cbo_is_head_office == '1')
        {
            $this->form_validation->set_message('check_duplicate_head_office', "Sorry! You already have defined a Head Office.Multiple head office is no allowed.");
            return FALSE;
        }
        return TRUE;
    }
}
