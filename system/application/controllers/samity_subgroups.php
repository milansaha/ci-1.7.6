<?php
/**
        * Samity Sub Group Controller Class.
        * @pupose        Manage  information
        *
        * @filesource   \app\controllers\samity_subgroups.php
        * @package              microfin
        * @subpackage   microfin.controller.samity_subgroups_controller
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam Liton $
        * @lastmodified $Date: 2011-01-04 $
*/
class Samity_subgroups extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Samity_subgroup','Samity_group'),'',TRUE);		
	}

	function index()
	{
		$cond= "";
		$session_data = $this->session->userdata('samity_subgroups.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_samity_group']))
        {
			$cond['name'] = $_POST['txt_name'];
			$cond['cbo_samity_group'] = $_POST['cbo_samity_group'];
			$sessionArray = array( 'samity_subgroups.index'=>array('name'=>$cond['name'],'cbo_samity_group'=>$cond['cbo_samity_group']));
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_samity_group'] = $session_data['cbo_samity_group'];
		} else {
			$this->session->unset_userdata('samity_subgroups.index');
		}
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Samity_subgroup->row_count($cond);
		$data = $this->_load_combo_data();
		//Initializing Pagination
		$config['base_url'] = site_url('/samity_subgroups/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['subgroups']=$this->Samity_subgroup->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Samity SubGroups';
        $data['headline']='Samity SubGroups';
		$this->layout->view('/samity_subgroups/index',$data);
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
				//$data['created_by']=$user['name'];
				$data['created_by']= '1';
				$data['created_date']=date("Y-m-d");
				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity_subgroup->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/samity_subgroups/add/');
				}
			}
		}
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Samity SubGroup';
        $data['headline']='Add New';
		$this->layout->view('/samity_subgroups/add',$data);				
	}	
	
	function edit($subgroup_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($subgroup_id) && !$_POST)
		{
			$this->session->set_flashdata('message',EDIT_MESSAGE);
			redirect('/samity_subgroups/index/');
		}
		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$subgroup_id=$_POST['subgroup_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('subgroup_id');
				$user=$this->session->userdata('system.user');
				//$data['updated_by']=$user['name'];
				$data['updated_by'] = '1';
				$data['updated_date']=date("Y-m-d");
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity_subgroup->edit($data))
				{
					$this->session->set_flashdata('message','Samity sub Group has been updated successfully');
					redirect('/samity_subgroups/index/');
				}
			}
		}
		$data = $this->_load_combo_data();
		//Load data from database
		$data['row'] = $this->Samity_subgroup->read($subgroup_id);		
		$data['title']='Edit Samity SubGroup';
        $data['headline']='Edit';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('samity_subgroups/edit',$data);		
	}
	
	function delete($subgroup_id=null)
	{
        if(empty($subgroup_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Samity Sub Group ID is not provided');
			redirect('/samity_subgroups/index/');
		}
		if($this->Samity_subgroup->delete($subgroup_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/samity_subgroups/index/');
		}
	}
	function _get_posted_data()
	{
		$data=array();
		//$data['id']=$this->input->post('subgroup_id');
		$data['name']=$this->input->post('txt_name');
		$data['subgroup_code']=$this->input->post('txt_subgroup_code');
		$data['group_id']=$this->input->post('cbo_group');	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_name','Sub Group Name','trim|required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('cbo_group','Group Name','required');
		$this->form_validation->set_rules('txt_subgroup_code','SubGroup Code','trim|required|xss_clean|max_length[50]');
	}
	
	function _load_combo_data()
	{
		//This function is for listing of Samity Group	
		$data['samity_group_infos'] = $this->Samity_group->get_samity_groups();
		return $data;
	}
/**
 * @name ajax_for_get_samity_group_list_by_samity
 * @uses member(add,edit)
 * @updatedBy Anis Alamgir
 * @lastDate 20-Jan-2010  
 */
	function ajax_for_get_samity_sub_group_list_by_samity_group() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$samity_group_id      = $this->input->post('samity_group_id');
		if(empty($samity_group_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select a Group.';
        }
		else
        {
			$callback_message['status'] = 'success';
			$callback_message['samity_sub_group_id'][] = '';
			$callback_message['samity_sub_group_name'][] = '--Select--';
			$samities_info = $this->Samity_subgroup->get_samity_sub_group_list_by_samity_group($samity_group_id);
	  		 foreach( $samities_info as $row) {
				 $callback_message['samity_sub_group_id'][] = $row->samity_sub_group_id;
				 $callback_message['samity_sub_group_name'][] = $row->samity_sub_group_name;		
	  		}
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
}
