<?php
/** 
	* Member Controller Class. 
	* @pupose		Manage Member information
	*		
	* @filesource	\app\model\po_members_controller.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_members_controller
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam Liton $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
/**
 * Members
 *
 * @package microfin
 * @author 9022391199
 * @copyright 2011
 * @version $Id$
 * @access public
 */

class Member_closings extends MY_Controller {
	
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery','date'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Member_closing','Member','Samity','Config_customized_id','Po_branch','Loan_product_category'),'',TRUE);
		
		//$this->output->enable_profiler(1);		
	}
	function index()
	{
		$cond= "";
		$session_data = $this->session->userdata('member_closings.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];
			$cond['cbo_samity'] = $_POST['cbo_samity'];
			$sessionArray = array( 'member_closings.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['cbo_samity']));
			$this->session->unset_userdata('member_closings.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_samity'] = $session_data['cbo_samity'];
		} else {
			$this->session->unset_userdata('member_closings.index');
		} 
		$cond['cbo_branch'] = $this->get_branch_id();
		$data = $this->_load_combo_data($cond);
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Member_closing->row_canceled_member_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/member_closings/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['members']=$this->Member_closing->get_canceled_member_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Member Closing';
        $data['headline']='Member Closing';
		$this->layout->view('/member_closings/index',$data);
	}
	
	function add(){
		$this->_prepare_validation_for_member_closing();
		
		$is_validaiton_fail = false;
		
		if($_POST)
		{
			$data=$this->_get_posted_member_closing_data();
			//load session data
			$user=$this->session->userdata('system.user');	
			//$data['created_by']=$user['id'];		
			$data['created_on']=date("Y-m-d");
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				if($this->Member_closing->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
						redirect('/member_closings/index/', 'refresh');
				} else {
					$this->session->set_flashdata('message','Member information has been Closing failed.');
				}
			} else {
				$is_validaiton_fail = true;
			}
		}
		if($is_validaiton_fail){
			
			if(isset($data['member_id']) and is_numeric($data['member_id'])){
				$member_id = $data['member_id'];
				$data['member_samity_info'] = $this->Member->get_member_samity_info($member_id);
				$data['member_loan_info'] = $this->Member->get_member_loan_info($member_id);
				$data['member_saving_info'] = $this->Member->get_member_saving_info($member_id);
			}
		}
		//print_r($data);
		$data['title']='Add Member Closing';
        $data['headline']='Add Member Closing';
		$this->layout->view('/member_closings/save',$data);	
	}
	
	function edit($member_closing_id=null){
		
		if(empty($member_closing_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Member ID is not provided');
			redirect('/member_closings/index/', 'refresh');
		}
		
		$this->_prepare_validation_for_member_closing();
		
		$is_validaiton_fail = false;
		
		if($_POST)
		{
			$data=$this->_get_posted_member_closing_data();
			//load session data
			$user=$this->session->userdata('system.user');	
			$data['id']=$this->input->post('member_closing_id');
		//	die;	
			//$data['created_by']=$user['id'];		
			$data['created_on']=date("Y-m-d");
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				if($this->Member_closing->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
						redirect('/member_closings/index/', 'refresh');
				} else {
					$this->session->set_flashdata('message','Member information has been Closing failed.');
				}
			} else {
				$is_validaiton_fail = true;
			}
		}
		$row=$this->Member_closing->read($member_closing_id);
		$data['row']=$row;
		if(isset($row->member_id) and is_numeric($row->member_id)){
				$member_id = $row->member_id;
				$transaction_date = $row->closing_date;
				$data['member_samity_info'] = $this->Member->get_member_samity_info($member_id);
				$data['member_loan_info'] = $this->Member->get_member_loan_info($member_id,0,$transaction_date);
				$data['member_saving_info'] = $this->Member->get_member_saving_info($member_id,0,$transaction_date);
			}
		$data['title']='Edit Member Closing';
		$data['headline']='Edit Member Closing';
		$this->layout->view('/member_closings/save',$data);	
	}
	
	function delete($member_closing_id=null)
	{			
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($member_closing_id))
		{
			$this->session->set_flashdata('message','Member Closing ID is not provided');
			redirect('/member_closings/index/', 'refresh');
		}
		else
		{			
			//load session data
			//$user=$this->session->userdata('system.user');					
			$data['deleted_by']=$this->get_user_id();		
			$data['delete_date']=date("Y-m-d");				
			$data['is_deleted']='1';
			$data['id']=$member_closing_id;
			$row=$this->Member_closing->read($member_closing_id);
			$row = $row;
			$data['member_id'] = isset($row->member_id)?$row->member_id:'-1';
			$data['closing_date'] = isset($row->closing_date)?$row->closing_date:'';
			$data['transaction_log'] = isset($row->transaction_log)?$row->transaction_log:'';
			//Update this data and redirect to the index page
			
			if($this->Member_closing->delete($data))
			{
				$this->session->set_flashdata('message',DELETE_MESSAGE);
				redirect('/member_closings/index/', 'refresh');
			}								
		}
	}
	
	function _get_posted_member_closing_data()
	{	
		$data=array();	
		
		$data['member_id']=$this->input->post('member_id');
		
		$members_info = $this->Member->read($this->input->post('member_id'));
		
		$data['branch_id']=isset($members_info->branch_id)?$members_info->branch_id:"";
		$data['samity_id']=isset($members_info->samity_id)?$members_info->samity_id:"";
		$data['saving']['member_primary_product_id'] = isset($members_info->primary_product_id)?$members_info->primary_product_id:"";
	
		$total_loan = count($this->input->post('loan_id'));
		$loan_id = $this->input->post('loan_id');
		$loan_paid_amount = $this->input->post('loan_paid_amount');
		
		$total_saving = count($this->input->post('saving_id'));
		$saving_id = $this->input->post('saving_id');
		$saving_withdraw_amount = $this->input->post('saving_withdraw_amount');
		
		$data['loan']['total_row'] = $total_loan;
		$data['saving']['total_row'] = $total_saving;
		
		//echo $total_loan;
		for($i=0;$i<$total_loan;$i++) {
			$data['loan']['id'][] = $loan_id[$i];
			$data['loan']['amount'][] = $loan_paid_amount[$i];
			
			$data['loan']['transaction_date'][] = $this->input->post('txt_closing_date');
			$data['loan']['entry_by'][] = $this->get_user_id();
			$data['loan']['entry_date'][] = $this->input->post('txt_closing_date');
		}
		for($i=0;$i<$total_saving;$i++) {
			$data['saving']['id'][] = $saving_id[$i];
			$data['saving']['amount'][] = $saving_withdraw_amount[$i];
			$data['saving']['transaction_date'][] = $this->input->post('txt_closing_date');
			$data['saving']['created_by'][] = $this->get_user_id();
			$data['saving']['created_on'][] = $this->input->post('txt_closing_date');
			$data['saving']['updated_by'][] = $this->get_user_id();
			$data['saving']['updated_on'][] = $this->input->post('txt_closing_date');	
		}
		$data['closing_date']=$this->input->post('txt_closing_date');
		$data['updated_by']=$this->get_user_id();
		$data['updated_on']=$this->input->post('txt_closing_date');
		
	return $data;
	}
	function _load_combo_data($cond = array())
	{
		$branch_id = $this->get_branch_id();
		$samity_id = isset($cond['cbo_samity'])?$cond['cbo_samity']:-1;
		// Loading samity list which will be used in combo box
		$data['samities'] = $this->Samity->get_samity_list($branch_id);	
		return $data;
	}
	function _prepare_validation_for_member_closing()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('member_id','Member','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_closing_date','Closing Date','trim|xss_clean|required|callback_check_closing_date|max_length[15]');
	}
	function check_duplicate_transfer($str)
	{
		$member_id = $this->input->post('member_id');
		$member_transfer_id = $this->input->post('member_transfer_id');
		// check unauthorised transfer exists
		if(is_numeric($member_id) and (empty($member_transfer_id)) ){
			if($this->Member_transfer->get_unauthorised_transfer_by_member_id($member_id))
			{
				$this->form_validation->set_message('check_duplicate_transfer', "A transfer already pending.");
			        return FALSE;
			}	
		}
		return TRUE;
	}
	
	function check_closing_date($str)
	{
		
		$closing_date = $this->input->post('txt_closing_date');
		$member_id = $this->input->post('member_id');
		if(!empty($closing_date)) {
			$closing_date  = explode('-',$closing_date);
			if(isset($closing_date[2])) {
				
				$closing_year = (is_numeric($closing_date[0]))?$closing_date[0]:"";
				$closing_month = (is_numeric($closing_date[1]))?$closing_date[1]:"";
				$closing_day = (is_numeric($closing_date[2]))?$closing_date[2]:"";
				
				if(isset($member_id)){
					$last_transaction_date = $this->Member->get_member_last_transaction_date($member_id);
					$last_transaction_date  = explode('-',$last_transaction_date);
				
					if(isset($last_transaction_date[2])) {
						$last_transaction_year = (is_numeric($last_transaction_date[0]))?$last_transaction_date[0]:"";
						$last_transaction_month = (is_numeric($last_transaction_date[1]))?$last_transaction_date[1]:"";
						$last_transaction_day = (is_numeric($last_transaction_date[2]))?$last_transaction_date[2]:"";
				
						if(mysql_to_unix("{$last_transaction_year}{$last_transaction_month}{$last_transaction_day}") > mysql_to_unix("{$closing_year}{$closing_month}{$closing_day}"))	{
							$this->form_validation->set_message('check_closing_date', " Closing date must be upper than last transaction date.");
						
				        	return FALSE;
						}
					}	
				}
								
			} else {
				$this->form_validation->set_message('check_closing_date', "Must be enterd transfer date properly.");
		        	return FALSE;
			}
		} else {
				$this->form_validation->set_message('check_closing_date', "Must be enterd transfer date properly.");
		        return FALSE;
			}
			
		return TRUE;
	}
	

}
