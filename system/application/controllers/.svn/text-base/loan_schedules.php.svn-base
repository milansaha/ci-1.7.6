<?php

class Loan_schedules extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Scheduler1');
		$this->load->helper(array('form','jquery'));
		//$this->load->library('Scheduler1',null,"scheduler");
		//$this->load->model(array('loan_transaction'));
		$this->load->model(array('Loan','loan_reschedule','loan_transaction'));
	}
	
	function index($loan_id)
	{
		if(empty($loan_id))
		{
			$this->session->set_flashdata('message','Loan ID is not provided');
			redirect('/loans/index/');
		}
		$this->load->model(array('Loan','Loan_schedule'));
		$loan=$this->Loan->read($loan_id);
		$data['loan']=$loan;
		$data['schedules']=$this->scheduler1->get_loan_schedules($loan->branch_id,$loan->samity_id,$loan->member_id,$loan_id);
		$data['schedules']=$data['schedules'][0];
		//$data['schedules1']=$this->Loan_schedule->get_loan_schedule($loan_id);
		//echo "<pre>";
		//print_r($data['schedules']);
		
		//print_r($data['schedules1']);
		//echo "</pre>";
		//die;
		$this->layout->view('/loan_schedules/index',$data);
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
		$this->layout->view('/loan_schedules/reschedules',$data);
	}
	
	function add_reschedules($loan_id=null, $installment_no=null)
	{
		
		if($_POST){
			$data['loan_id']=$this->input->post('loan_id');
			$data['installment_no']=$this->input->post('installment_no');
			$data['reschedule_from']=$this->input->post('date_from');
			$data['reschedule_to']=$this->input->post('date_to');
			$data['rescheduled_by']=$this->get_user_id();
			$data['rescheduled_date']=$this->get_current_date();
			
			print_r($data['reschedule_to']);//die;
			if(!empty($data['reschedule_to'])){
				if($this->scheduler1->is_valid_schedule_date($data['loan_id'],$data['reschedule_to'])){
					$this->loan_reschedule->delete_by_loan_id_installment_no($data['loan_id'],$data['installment_no']);
					$this->loan_reschedule->add($data);
					$this->session->set_flashdata('message','Installment NO '.$data['installment_no'].' has been rescheduled');
					redirect('/loan_schedules/reschedules/'.$data['loan_id']);
				}
				else{
					$this->session->set_flashdata('message','The Schedule date: '.$data['reschedule_to'].' is not valid, Samity Day is on '.$this->scheduler1->get_samity_day($data['loan_id'],$data['reschedule_to']));
					
					$data['title'] = 'Add Reschedule';
					$data['headline'] = 'Add Reschedule';
					$data['action'] = 'add';
					
					$data['date_from']=$data['reschedule_from'];
					//print_r($data['date_from']);die;
					redirect('/loan_schedules/add_reschedules/'.$data['loan_id'].'/'.$data['installment_no']);
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
		$data['loan_id']=$loan_id;
		$data['installment_no']=$installment_no;
		//print_r($data['date_from']);die;
		$this->layout->view('/loan_schedules/add_reschedules',$data);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
