<?php

class Process_day_ends extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Process_day_end','Report_loan_data','Po_branch','Report'),'',TRUE);
		$this->Process_day_end->loan_base_class = $this->Report_loan_data;			
	}
	
	function index()
	{
		$data['title']='Day End Process';
		/* Conditions for filtering */
		$cond= "";
		$session_data = $this->session->userdata('process_day_ends.index');
		if($_POST){
			//print_r($_POST);
            $cond['cbo_month'] = $this->input->post('cbo_month');
            $cond['cbo_year'] = $this->input->post('cbo_year');

			$sessionArray = array( 'process_day_ends.index'=>array(
                                        'cbo_month'=>$cond['cbo_month'],
                                        'cbo_year'=>$cond['cbo_year']));

            $this->session->unset_userdata('process_day_ends.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['cbo_month'] = $session_data['cbo_month'];
			$cond['cbo_year'] = $session_data['cbo_year'];

		} else {
			$this->session->unset_userdata('process_day_ends.index');
		}
		/* End of filtering conditions */		
		
		$data = $this->_load_combo_data();
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Process_day_end->row_count($this->get_branch_id(),$cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/process_day_ends/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['day_end_process']=$this->Process_day_end->get_list($this->get_branch_id(),ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		$data['day_end_valid_deletable_date']=$this->Process_day_end->get_day_end_valid_deletable_date($this->get_branch_id());		
		$data['counter'] = (int)$this->uri->segment(3);
		if($_POST){
			$this->load->view('/process_day_ends/execute',$data);
		} else {
			$this->layout->view('/process_day_ends/index',$data);
		}
	}
	
	function ajax_execute()
	{
		//sleep(5);
		$error = "";
		$this->output->enable_profiler(FALSE);
		$branch_id = $this->get_branch_id();
		$last_day_end_date = $this->__get_last_day_end_date($branch_id);

		$new_day_end_date = $this->__get_new_day_end_date($last_day_end_date,$branch_id);
		
		$samities = $this->__get_samity_list($new_day_end_date,$branch_id);
		
		$members = $this->__get_member_list($samities);
	
		// SKT
		$skt_samities = $this->__get_skt_samity_list($new_day_end_date,$branch_id);
		$skt_members = $this->__get_member_list($skt_samities);
		
		$error = $this->Process_day_end->check_loan_information($error,$members,$new_day_end_date);
		if($error <> ''){
			if(isset($error['loan']['pending_laon_list']) and !empty($error['loan']['pending_laon_list'])){
				$error['msg'][] = "Some Loan entry are pending.";
				//print_r($error['loan']['pending_laon_list']);
			}
			if(isset($error['loan']['pending_authorized_laon_transaction_list']) and !empty($error['loan']['pending_authorized_laon_transaction_list'])){
				//print_r($error['loan']['pending_authorized_laon_transaction_list']);
				$error['msg'][] = "Some Loan authorization are pending.";
			}
		}
		$error = $this->Process_day_end->check_saving_information($error,$members,$new_day_end_date);
		if($error <> ''){
			if(isset($error['saving']['pending_saving_list']) and !empty($error['saving']['pending_saving_list'])){
				$error['msg'][] = "Some Saving entry are pending.";
			}
			if(isset($error['saving']['pending_authorized_saving_transaction_list']) and !empty($error['saving']['pending_authorized_saving_transaction_list'])){
				//print_r($error['loan']['pending_authorized_laon_transaction_list']);
				$error['msg'][] = "Some Saving authorization are pending.";
			}
		}
		$error = $this->Process_day_end->check_skt_saving_information($error,$skt_members,$new_day_end_date);
		if($error <> ''){
			if(isset($error['skt_member']['pending_skt_member_list']) and !empty($error['skt_member']['pending_skt_member_list'])){
				$error['msg'][] = "Some SKT Saving entry are pending.";
			}
			if(isset($error['skt_member']['pending_authorized_skt_member_transaction_list']) and !empty($error['skt_saving']['pending_authorized_skt_saving_transaction_list'])){
				//print_r($error['loan']['pending_authorized_laon_transaction_list']);
				$error['msg'][] = "Some SKT Saving authorization are pending.";
			}
		}
		//	print_r($members);		
		//print_r($error);
		if(isset($error['msg'])){
			$data['error_msg'] = $error['msg'];
		} else {
			$data['date'] =  $new_day_end_date;			
			$data['branch_id'] =  $branch_id;
			// fully paid loans are closing
			$this->Process_day_end->execute_loan_closing($members,$samities,$branch_id,$new_day_end_date);	
			// day end execute
			$this->Process_day_end->execute_day_end($data);
			$this->get_current_date(true);
		}
		
		//echo "$new_day_end_date";
		//print_r($tmp);
		/* Conditions for filtering */
		$cond= "";
		$session_data = $this->session->userdata('process_day_ends.index');
		if($_POST){
			//print_r($_POST);
            $cond['cbo_month'] = $this->input->post('cbo_month');
            $cond['cbo_year'] = $this->input->post('cbo_year');

			$sessionArray = array( 'process_day_ends.index'=>array(
                                        'cbo_month'=>$cond['cbo_month'],
                                        'cbo_year'=>$cond['cbo_year']));

            $this->session->unset_userdata('process_day_ends.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['cbo_month'] = $session_data['cbo_month'];
			$cond['cbo_year'] = $session_data['cbo_year'];

		} else {
			$this->session->unset_userdata('process_day_ends.index');
		}
		/* End of filtering conditions */		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Process_day_end->row_count($branch_id,$cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/process_day_ends/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
	
		//Loading data by model function call
		$data['day_end_process']=$this->Process_day_end->get_list($branch_id,ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['day_end_valid_deletable_date']=$this->Process_day_end->get_day_end_valid_deletable_date($this->get_branch_id());		
		$data['counter'] = (int)$this->uri->segment(3);
		$this->load->view('/process_day_ends/execute',$data);
	}
	function __get_last_day_end_date($branch_id)
	{		
		$last_day_end_date = $this->Process_day_end->get_day_end_last_date($branch_id);
		if(empty($last_day_end_date)) {
			$branch_opening_date = $this->Process_day_end->get_branch_opening_date($branch_id);
			$organization_established_date = $this->Process_day_end->get_software_start_date();
			$date_diff = strtotime($organization_established_date) - strtotime($branch_opening_date);
			$last_day_end_date = ($date_diff > 0)?$organization_established_date:$branch_opening_date;
		}
		return $last_day_end_date;
	}

	function __get_new_day_end_date($last_day_end_date,$branch_id)
	{	
		$is_holiday = true;
		for($i=1;$is_holiday;$i++){			
			$new_day_end_date=date('Y-m-d',strtotime($last_day_end_date." + $i day"));
			$is_holiday = $this->Process_day_end->check_is_holiday($new_day_end_date,$branch_id);
		}
		return $new_day_end_date;
	}
	function __get_samity_list($new_day_end_date,$branch_id){
		//Samity
		$samity_list = $this->Process_day_end->get_samity_list($new_day_end_date,$branch_id);
		$samities = "";
		foreach($samity_list as $samity){
			$samities .=$samity['id'].',';
		}
		$samities = 	substr($samities,0, -1);
		return $samities;
	}
	function __get_skt_samity_list($new_day_end_date,$branch_id){
		//Samity
		$samity_list = $this->Process_day_end->get_skt_samity_list($new_day_end_date,$branch_id);
		$samities = "";
		foreach($samity_list as $samity){
			$samities .=$samity['id'].',';
		}
		$samities = 	substr($samities,0, -1);
		return $samities;
	}
	function __get_member_list($samities){
		//Member
		$member_list = $this->Process_day_end->get_member_list($samities);
		$members = "";
		foreach($member_list as $member){
			$members .=$member['id'].',';
		}
		$members = 	substr($members,0, -1);
		return $members;
	}
	function first_day_end($branch_id=10,$date='0000-00-00')
	{
		//$this->load->view('welcome_message');
		
		$this->day_end_process->get_by_branch_id_date();
	}
	 function delete($date=null)
	{
        if(empty($date))
		{
			$this->session->set_flashdata('warning','Date is not provided');
			redirect('/process_day_ends/index/');
		}
		//Check wether the child data exists
        $last_day_branch_date = $this->Process_day_end->get_day_end_valid_deletable_date($this->get_branch_id());
        if($last_day_branch_date != $date)
        {
            $this->session->set_flashdata('warning', 'You must be entered a valid date.');
			redirect('/process_day_ends/index/');
        }
        else
        { 
            if($this->Process_day_end->delete($this->get_branch_id(),$date))
            {
               $this->get_current_date(true);
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/process_day_ends/index/');
            }
            
        }
	}

	//Combo Data Generation
	function _load_combo_data()
	{		
		$data['months_info'] = $this->Report->get_months();
		$data['year_info'] = $this->Report->get_year_range();		
		return $data;
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
