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
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Transactions extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form','url'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Transaction','',TRUE);	
		$this->load->library('Scheduler1');
	}
	function auto_process()
	{
		$data['branch_id'] = $this->get_branch_id();
		$data['current_date'] = $this->get_current_date(); 
		$data['dayname'] = date("D",strtotime($data['current_date']));	  

		$samity_infos = $this->Transaction->get_samity_info($data);

		foreach($samity_infos as  $key=>$samity_info){				
			$data['auto_process'] = $this->Transaction->get_samity_wise_member_info($samity_info->samity_id);	
			if(count($data['auto_process'])>0){
				$samity_infos[$key]->total_member =count($data['auto_process']) ;
			}
		}

		$data['samity_infos']= $samity_infos;
		$data['title']='Auto Process';
		
		$this->layout->view('/transactions/auto_process',$data);
		
	}
	
	function auto_process_add($samity_id=null)
	{		
		$system_user=$this->session->userdata('system.user');
		
		$data['headline']='Auto Process Save';
		
		
		$this->_prepare_validation_save();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($samity_id)
		{			
			$data['branch_id'] = $this->get_branch_id();
			//$data['current_date'] = $this->get_current_date(); 
			$data['current_date'] = '2012-04-30'; 
			$data['dayname'] = date("D",strtotime($data['current_date']));
			$data['samity_id'] = $samity_id;
			
			//print_r($data);
			
			$data['auto_process'] = $this->Transaction->get_samity_wise_member_info($samity_id);
			$backup = $data['samity_info'] = $this->Transaction->samity_read($samity_id);
			$data['loan_info'] = $this->scheduler1->get_samity_wise_current_loan_information_before_date(array($data['samity_id']),$data['current_date'],$data['branch_id']);
			
/*
			foreach($data['loan_info']['0']['2561']['8'] as $member_info){
					//print_r($data['loan_info']['0']['2561']['6']);	
					//echo $total_date = count($data['loan_info']['0']['2561']['6']);
					//for($l;$l<=$total_date;$l++){					
					//}		
					echo $member_info['repayment_date'].'<br/>';
					echo $member_info['installment_amount'].'<br/>';	
					echo $member_info['installment_no'];		
				}
*/
				
			 // print_r($data['auto_process']);
			//print_r($data['loan_info']);
			
			if(empty($data['auto_process'])){	
				$this->session->set_flashdata('message','The Samity has no member.');
				redirect('/transactions/auto_process/');
			
			}
		}
		if($_POST)
		{	
			//print_r($_POST);
			//die();
			$backup = $data['samity_info'] = $this->Transaction->samity_read($_POST['samity_id']);
			$data['auto_process'] = $this->Transaction->get_samity_wise_member_info($_POST['samity_id']);
			
			if ($this->form_validation->run() === TRUE)
				{
					$members_id=$this->input->post('member_id');
					$is_attendence =$this->input->post('ch_attendence');
					$primary_product_id=$this->input->post('primary_product_id');
					$loans_id=$this->input->post('loan_id');
					$loan_product_id=$this->input->post('loan_product_id');
					$savings_product_id=$this->input->post('savings_product_id');
					$saving_id=$this->input->post('savings_id');
					//$samity_date=$this->input->post('samity_date');
					$samity_date = $this->get_current_date(); 
					$loan_amount=$this->input->post('txt_loan_amount');
					$savings_amount=$this->input->post('txt_savings_amount');
					$loan_due=$this->input->post('loan_due');
					$loan_advance=$this->input->post('loan_advance');
					$skt_amount=$this->input->post('txt_skt_amount');
					$total_member = count($members_id);
					$member_id_old = "";
					$member_id_new = "";
					//$j=0;
					//die();
					$is_saved = true;
					$last_insert_id=array();
					for($i=0;$i<$total_member;$i++){
						//loan
						$data=array();
						if($loans_id[$i]>0){
							$data['loan_id'] = $loans_id[$i];
							$data['transaction_date'] = $samity_date;
							$data['product_id'] = $loan_product_id[$i];						
							$data['transaction_amount'] = floor($loan_amount[$i]);
							$data['installment_number'] = 1;
							$data['entry_by'] = $system_user['id'];
							$data['entry_date'] = $samity_date;
							$data['is_authorized'] = 0;
							$data['branch_id'] = $_POST['branch_id'];
							$data['samity_id'] = $_POST['samity_id'];
							$data['is_auto_process'] = 1;						
							$is_saved = $this->Transaction->loan_transaction_add($data);
							$last_insert_id['loan_trans_id'][$i] = $this->db->insert_id();	
							
							$data_due=array();							
							if(isset($loan_due[$i]) && $loan_due[$i]>0){
								$data_due['loan_id'] = $loans_id[$i];								
								$data_due['product_id'] = $loan_product_id[$i];
								$data_due['branch_id'] = $_POST['branch_id'];
								$data_due['samity_id'] = $_POST['samity_id'];
								$data_due['transaction_date'] = $samity_date;
								$data_due['due_collection_amount']=$loan_amount[$i];
								$data_due['entry_by'] = $system_user['id'];														
								$data_due['entry_date'] = $samity_date;	
								
								$is_saved = $this->Transaction->loan_due_add($data_due);	
							}	
							
							$data_advance=array();							
							if(isset($loan_advance[$i]) && $loan_advance[$i]>0){
								$data_advance['loan_id'] = $loans_id[$i];								
								$data_advance['product_id'] = $loan_product_id[$i];
								$data_advance['branch_id'] = $_POST['branch_id'];
								$data_advance['samity_id'] = $_POST['samity_id'];
								$data_advance['transaction_date'] = $samity_date;
								$data_advance['advance_collection_amount']=$loan_amount[$i];
								$data_advance['entry_by'] = $system_user['id'];														
								$data_advance['entry_date'] = $samity_date;	
								
								$is_saved = $this->Transaction->loan_advance_add($data_advance);	
							}					
						}				
						//saving
						$data=array();
						if($saving_id[$i]>0) {
							$data['member_id'] = $members_id[$i];
							$data['savings_id'] = $saving_id[$i];
							$data['member_primary_product_id'] = $primary_product_id[$i];
							$data['saving_products_id'] = $savings_product_id[$i];						
							$data['transaction_date'] = $samity_date;
							$data['transaction_type'] = 'DEP';						
							$data['amount'] = $savings_amount[$i];
							$data['payment_received_by'] = $system_user['id'];
							$data['is_authorized'] = 0;
							$data['entry_by'] = $system_user['id'];						
							$data['branch_id'] = $_POST['branch_id'];
							$data['samity_id'] = $_POST['samity_id'];
							$is_saved = $this->Transaction->saving_transaction_add($data);
							$last_insert_id['saving_trans_id'][$i] = $this->db->insert_id() ;
						}
						//skt collection
						//if($member_id_old!=$members_id[$i] && isset($skt_amount[$i])){
							//$member_id_new = $members_id[$i];
						 
						$data_skt= array();
						if($skt_amount[$i]>0) {
							$data_skt['member_id'] = $members_id[$i];
							$data_skt['member_primary_product_id'] = $primary_product_id[$i];
							$data_skt['branch_id'] = $_POST['branch_id'];
							$data_skt['samity_id'] = $_POST['samity_id'];
							$data_skt['amount'] = $skt_amount[$i];
							$data_skt['transaction_date'] = $samity_date;						
							$data_skt['payment_received_by'] = $system_user['id'];
							$data_skt['is_authorized'] = 0;		
							
							//print_r($data_skt);						
							$is_saved = $this->Transaction->member_skt_add($data_skt);
						}
						
						//atendence
					//if($member_id_old!=$members_id[$i]){
						//$member_id_new = $members_id[$i];
							
						$data_attendence = array();
					if($is_attendence[$i]>0) {
						$data_attendence['member_id'] = $members_id[$i];
						$data_attendence['samity_id'] = $_POST['samity_id'];
						$data_attendence['attendance_status'] = $is_attendence[$i];//isset($is_attendence[$i])?$is_attendence[$i]:0;
						$data_attendence['samity_id'] = $_POST['samity_id'];
						$data_attendence['branch_id'] = $_POST['branch_id'];
						$data_attendence['major_product_id'] = $primary_product_id[$i];
						$data_attendence['date'] = $samity_date;						
						
						$is_saved = $this->Transaction->member_attendence_add($data_attendence);
					}
					
						$member_id_old=$member_id_new;
							
					}
					if($is_saved)
					{
						//$this->session->set_flashdata('message','All Transaction has been added successfully');
						//print_r($_POST);
						$saved_data['posted'] = $_POST;
						$saved_data['samity_info'] = $backup;
						$saved_data['last_id'] = $last_insert_id;
						$saved_data['is_saved'] = true;
						$saved_data['samity_date'] = $samity_date;
						//redirect('/transactions/auto_process_success/', 'refresh');
					}
				}				
		
		}		
		//If data is not posted or validation fails, the add view is displayed
		if(isset($is_saved) and $is_saved){
			$this->layout->view('/transactions/auto_process_success',$saved_data);			
		}	else {
			$this->layout->view('/transactions/auto_process_add',$data);
		}
	}
	function auto_process_success(){
		
	}
/*
	function auto_process_edit($samity_id,$samity_date)
	{
		$data['headline']='Auto Process Save';
		$this->_prepare_validation_save();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			//$data=$this->_get_posted_data();
			//Perform the Validation
			
			$data['auto_process'] = $this->Transaction->get_samity_wise_member_info($_POST['samity_id']);
			$backup = $data['samity_info'] = $this->Transaction->samity_read($_POST['samity_id']);
			if ($this->form_validation->run() === TRUE)
			{
				$members_id=$this->input->post('member_id');
				$loans_id=$this->input->post('loan_id');
				$saving_id=$this->input->post('savings_id');
				$samity_date=$this->input->post('samity_date');
				$loan_amount=$this->input->post('txt_loan_amount');
				$savings_amount=$this->input->post('txt_savings_amount');
				$total_member = count($members_id);
				//echo $total_member;
				$is_saved = true;
				$last_insert_id=array();
				print_r($_POST);die();
				for($i=0;$i<$total_member;$i++){
					//loan
					$data=array();
					if($loans_id[$i]>0) {
						$data['loan_id'] = $loans_id[$i];
						$data['transaction_date'] = $samity_date;
						$data['transaction_code'] = $loans_id[$i];
						$data['payment_type'] = 'SOFT';
						$data['amount'] = $loan_amount[$i];
						$data['installment_number'] = 1;
						$data['received_by'] = 1;
						$data['authorization_status'] = false;
						$data['user_id'] = 1;
						$data['is_deleted'] = false;
						$data['is_auto_process'] = true;						
						$is_saved = $this->Transaction->loan_transaction_add($data);
						$last_insert_id['loan_trans_id'][$i] = $this->db->insert_id() ;
					}
					//saving
					$data=array();
					if($saving_id[$i]>0){
						$data['savings_id'] = $saving_id[$i];
						$data['transaction_code'] = $saving_id[$i];
						$data['transaction_date'] = $samity_date;
						$data['transaction_type'] = 'DEP';
						$data['payment_type'] = 'CASH';
						$data['amount'] = $savings_amount[$i];
						$data['payment_received_by'] = 1;
						$data['authorization_status'] = false;
						$data['user_id'] = 1;
						$data['is_deleted'] = false;
						$data['is_auto_process'] = true;
						$is_saved = $this->Transaction->saving_transaction_add($data);
						$last_insert_id['saving_trans_id'][$i] = $this->db->insert_id();
					}
				}
				if($is_saved)
				{
					$saved_data['posted'] = $_POST;
					$saved_data['samity_info'] = $backup;
					$saved_data['last_id'] = $last_insert_id;
					$saved_data['is_saved'] = true;
					$saved_data['samity_date'] = $samity_date;
					//redirect('/transactions/auto_process_success/', 'refresh');
				}
			}
		}
		//If data is not posted or validation fails, the add view is displayed
		if(isset($is_saved) and $is_saved){
			$this->layout->view('/transactions/auto_process_success',$saved_data);			
		}	else {
			$this->layout->view('/transactions/auto_process_add',$data);
		}
	}
*/
	function _load_combo_data($info)
	{
		//This function is for listing of samities	
		$data['samity_infos'] = $this->Transaction->get_samity_info($info);	
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule			
		$this->form_validation->set_rules('cbo_samity','Samity ID','trim|xss_clean|required|numeric');
	}
	function _prepare_validation_save()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule
		$this->form_validation->set_rules('samity_id', 'Samity', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('txt_loan_amount[]', 'Loan Amount', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('txt_savings_amount[]', 'Savings Collection', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('ch_loan_full_member[]', '', '');
		$this->form_validation->set_rules('ch_loan_partial_member[]', '', '');
		$this->form_validation->set_rules('ch_loan_zero_member[]', '', '');
		$this->form_validation->set_rules('ch_savings_full_member[]', '', '');
		$this->form_validation->set_rules('ch_savings_partial_member[]', '', '');
		$this->form_validation->set_rules('ch_savings_zero_member[]', '', '');
	}
	function _get_posted_data()
	{
		$data=array();
		$data['samity_id']=$this->input->post('cbo_samity');
		return $data;
	}
}
