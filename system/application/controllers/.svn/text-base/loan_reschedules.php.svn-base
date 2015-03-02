<?php

class Loan_reschedules extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Scheduler1');
		$this->load->helper(array('form','jquery'));
		//$this->load->library('Scheduler1',null,"scheduler");
		//$this->load->model(array('loan_transaction'));
		$this->load->model(array('Loan','loan_reschedule','loan_transaction','Samity'));
	}
	
	function index()
	{
		$data['title']='Loan Reschedules';
		$data['headline'] = 'Loan Reschedules';
		// load pagination class
		$this->load->library('pagination');
		$total = $this->loan_reschedule->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/loan_reschedules/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['loan_reschedules_infos']=$this->loan_reschedule->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));
		//print_r($data['loan_reschedules_infos']);
		//die;
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/loan_reschedules/index',$data);
	}
	
	function add(){
		
		$cond= "";        
		$session_data = $this->session->userdata('loan_reschedules.add');
	
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];		
			$cond['samity'] = $_POST['cbo_samity'];	
			//$cond['loan_status'] = $_POST['cbo_loan_status'];		
			//$sessionArray = array( 'loan_reschedules.add'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity'],'cbo_loan_status'=>$cond['loan_status']));			
			$sessionArray = array( 'loan_reschedules.add'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity']));			
			
			$this->session->unset_userdata('loan_reschedules.add');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];	
			//$cond['loan_status'] = $session_data['cbo_loan_status'];			
		} else {
			$this->session->unset_userdata('loan_reschedules.add');
		} 

		// load pagination class
		$this->load->library('pagination');
		$total = $this->Loan->row_count($cond);

		//Initializing Pagination
		$config['base_url'] = site_url('/loan_reschedules/add');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());	
		//$data['current_status'] = array('0'=>'Active','1'=>'Inactive','2'=>'Closed');
		
		//Loading data by model function call
		$data['loans']=array();
		//print_r($cond);
		if(!empty($cond['name']) || !empty($cond['samity'])){
			$data['loans']=$this->Loan->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		}
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Loans';
		$data['headline']='Loans';
		$this->layout->view('/loan_reschedules/add',$data);
	}
	
	
	function delete($loan_reschedule_id=null)
	{
		if(empty($loan_reschedule_id))
		{
			$this->session->set_flashdata('warning','Loan Reschedule ID is not provided');
			redirect('/loan_reschedules/index/');
		}
        
		if($this->loan_reschedule->delete($loan_reschedule_id))
           {
               $this->session->set_flashdata('message',DELETE_MESSAGE);
               redirect('/loan_reschedules/index/');
           }
		
	}
	
	
	function reschedules($loan_id)
	{
		//echo 'hi';//die;
		
		
		
		if(empty($loan_id))
		{
			$this->session->set_flashdata('message','Loan ID is not provided');
			redirect('/loans/index/');
		}
		//echo 'hi';//die;
		$loan=$this->Loan->read($loan_id);
		//$this->Loan_schedule->initialize($loan->branch_id,$loan->samity_id);
		$data['loan']=$loan;
		$data['schedules']=$this->scheduler1->get_loan_schedules($loan->branch_id,$loan->samity_id,$loan->member_id,$loan_id);
		//print_r($data['schedules']);die;
		$data['schedules']=$data['schedules'][0];
		$data['transcantions']=$this->loan_transaction->get_loan_transaction_information_by_loan_id($loan_id);
		//echo 'hi';//die;
		$trans=array();
		foreach($data['transcantions'] as $key =>$val){
			if(isset($val['installment_number'])){
				$trans[$val['installment_number']]=1;
			}
		}
		$data['transcantions']=$trans;
		//print_r($data['transcantions']);
		//echo "</br>";
		//print_r($data['schedules']);//die;
		
		//foreach($data['schedules'] as $key=>$val){
		//}
		//$data['schedules1']=$this->Loan_schedule->get_loan_schedule($loan_id);
		//echo "<pre>";
		//print_r($data['schedules']);
		
		//print_r($data['schedules1']);
		//echo "</pre>";
		//die;
		$this->layout->view('/loan_reschedules/reschedules',$data);
	}
	
	function add_reschedules($loan_id=null, $installment_no=null,$date_from=null,$date_to=null)
	{
		
		if($_POST){
			$data['loan_id']=$this->input->post('loan_id');
			$data['installment_no']=$this->input->post('installment_no');
			$data['reschedule_from']=$this->input->post('date_from');
			$data['reschedule_to']=$this->input->post('date_to');
			$data['rescheduled_by']=$this->get_user_id();
			$data['rescheduled_date']=$this->get_current_date();
			
			//print_r($data['reschedule_to']);//die;
			if(!empty($data['reschedule_to'])){
				if($this->scheduler1->is_valid_schedule_date($data['loan_id'],$data['reschedule_to'])){
					$this->loan_reschedule->delete_by_loan_id_installment_no($data['loan_id'],$data['installment_no']);
					$this->loan_reschedule->add($data);
					$this->session->set_flashdata('message','Installment NO '.$data['installment_no'].' has been rescheduled');
					redirect('/loan_reschedules/reschedules/'.$data['loan_id']);
				}
				else{
					$this->session->set_flashdata('message','The Schedule date: '.$data['reschedule_to'].' is not valid, Samity Day is on '.$this->scheduler1->get_samity_day($data['loan_id'],$data['reschedule_to']));
					
					$data['title'] = 'Add Reschedule';
					$data['headline'] = 'Add Reschedule';
					$data['action'] = 'add';
					
					$data['date_from']=$data['reschedule_from'];
					//print_r($data['date_from']);die;
					redirect('/loan_reschedules/add_reschedules/'.$data['loan_id'].'/'.$data['installment_no']);
				}
			}
			
			
		}
		if(empty($loan_id)||empty($installment_no))
		{
			$this->session->set_flashdata('message','Loan ID and/or Installment NO is not provided');
			redirect('/loans/index/');
		}
		$data = array();
		$data['title'] = 'Add Reschedule';
		$data['headline'] = 'Add Reschedule';
		$data['action'] = 'add';
		
		$data['date_from']=$this->scheduler1->get_schedule_date_by_installment_no($loan_id, $installment_no);
		if(!empty($date_from)){
			$data['date_from']=$date_from;
		}
		
		$data['date_to']="";
		if(!empty($date_to)){
			$data['date_to']=$date_to;
		}
		
		$data['loan_id']=$loan_id;
		$data['installment_no']=$installment_no;
		//print_r($data['date_from']);die;
		$this->layout->view('/loan_reschedules/add_reschedules',$data);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
