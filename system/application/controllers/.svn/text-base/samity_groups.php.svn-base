<?php
/** 
        * Samity Group Controller Class.
        * @pupose               Manage  information
        *               
        * @filesource   \app\controllers\samity_groups.php    
        * @package              microfin 
        * @subpackage   microfin.controller.samity_groups_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $       
        * @lastmodified $Date: 2011-01-04 $      
*/ 
class Samity_groups extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Samity_group','Samity'),'',TRUE);		
	}

	function index()
	{
        $cond= "";
		$session_data = $this->session->userdata('samity_groups.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];
			$cond['cbo_samity'] = $_POST['cbo_samity'];
			$sessionArray = array( 'samity_groups.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['cbo_samity']));
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_samity'] = $session_data['cbo_samity'];
		} else {
			$this->session->unset_userdata('samity_groups.index');
		}
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Samity_group->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/samity_groups/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		$data = $this->_load_combo_data();
		//Loading data by model function call
		$data['samity_groups']=$this->Samity_group->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Samity Groups';
        $data['headline']='Samity Groups';
		$this->layout->view('/samity_groups/index',$data);
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
				$user=$this->session->userdata('system.user');
				$data['created_by']= $user['id'];
				$data['created_date']=date("Y-m-d");
				if($this->Samity_group->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/samity_groups/add/');
				}
			}
		}
		$data = $this->_load_combo_data();
		$data['title']='Add Samity Group';
        $data['headline']='Add New';
		$this->layout->view('/samity_groups/save',$data);
	}	
	
	function edit($samity_group_id=null)
	{	
		if(empty($samity_group_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Sorry! Group ID is not provided');
			redirect('/samity_groups/index/');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$samity_group_id=$_POST['samity_group_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('samity_group_id');
				$user=$this->session->userdata('system.user');
				$data['updated_by']=$user['id'];
				$data['updated_date']=date("Y-m-d");
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity_group->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/samity_groups/index/');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$data['row'] = $this->Samity_group->read($samity_group_id);
		$data['title']='Edit Samity Group';
        $data['headline']='Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('samity_groups/save',$data);
	}
		
	function delete($samity_group_id=null)
	{
        if(empty($samity_group_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Group ID is not provided');
			redirect('/samity_groups/index/');
		}
        $is_dependent = $this->Samity_group->is_dependency_found('samity_subgroups',  array('group_id' => $samity_group_id));
        if($is_dependent)
        {
             $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/samity_groups/index/');
        }        
        else
        {
            if($this->Samity_group->delete($samity_group_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/samity_groups/index/');
            }
        }
	}
    
	function _get_posted_data()
	{
		$data=array();
		$data['id']=$this->input->post('samity_group_id');
		$data['samity_id']=$this->input->post('cbo_samity_id');
		$data['name']=$this->input->post('txt_name');
		$data['code']=$this->input->post('txt_code');
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Name','trim|required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('txt_code','Code','trim|required|xss_clean|max_length[50]');
		$this->form_validation->set_rules('cbo_samity_id','Samity','trim|required|xss_clean');
	}
	
	function _load_combo_data()
	{
		$branch_id = $this->get_branch_id();
		//This function is for listing of branches	
		$data['samities_info'] = $this->Samity->get_samity_list($branch_id);		
		return $data;
	}
	
        /**
         * @name ajax_for_get_samity_group_list_by_samity
         * @uses member(add,edit)
         * @updatedBy Anis Alamgir
         * @lastDate 20-Jan-2010
         */
	function ajax_for_get_samity_group_list_by_samity()
    {
        $this->output->enable_profiler(FALSE);
        $callback_message = array();
        $samity_id      = $this->input->post('samity_id');
        if(empty($samity_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select a Samity.';
        }
        else
        {
            $callback_message['status'] = 'success';
            $callback_message['samity_group_id'][] = '';
            $callback_message['samity_group_name'][] = '--Select--';
            $samities_info = $this->Samity_group->get_samity_group_by_samity($samity_id);
             foreach( $samities_info as $row) {
                     $callback_message['samity_group_id'][] = $row->samity_group_id;
                     $callback_message['samity_group_name'][] = $row->samity_group_name;
            }
        }
        if( count($callback_message) != 0 )
        {
            echo json_encode($callback_message);
        }
	}
    
}
