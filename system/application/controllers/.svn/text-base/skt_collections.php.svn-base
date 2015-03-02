<?php
/** 
	* Skt_collections Controller Class.
	* @pupose		Manage skt_collections information
	*		
	* @filesource	\app\controllers\skt_collections.php	
	* @package		microfin 
	* @subpackage	microfin.controller.skt_collections
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-03-01 $	 
*/ 
	
class Skt_collections extends MY_Controller {
	
	function Skt_collections()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Skt_collection','Samity','Member','Saving'),'',TRUE);
	}

	function authorization_index()
	{
		$cond= "";
		$session_data = $this->session->userdata('skt_collections.index');
	
		if(isset($_POST['cbo_samity'])){
			$cond['samity'] = $_POST['cbo_samity'];	
			$sessionArray = array( 'skt_collections.authorization_index'=>array('cbo_samity'=>$cond['samity']));			
			$this->session->unset_userdata('skt_collections.authorization_index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['samity'] = $session_data['cbo_samity'];					
		} else {
			$this->session->unset_userdata('skt_collections.authorization_index');
		} 
		
		if(isset($_POST['sktcollectiondata']))
		{
			//echo "<pre>";print_r($_POST['loandata']);die;
			$user=$this->session->userdata('system.user');
			$i=1;
			if($this->input->post('submit_1'))
			{				
				foreach($_POST['sktcollectiondata'] as $row)
				{				
					if(!empty($row['is_authorized']))
					{
						$data['skt_collections'][$i]['id']=$row['id'];	
						$data['skt_collections'][$i]['is_authorized']=0;
						$data['skt_collections'][$i]['is_authorized']=$row['is_authorized'];
						$data['skt_collections'][$i]['authorized_by']=$user['id'];	
						$data['skt_collections'][$i]['authorization_date']=date('Y-m-d');	
						$i++;
					}										
				}				
			}
			else
			{				
				foreach($_POST['sktcollectiondata'] as $row)
				{				
					$data['skt_collections'][$i]['id']=$row['id'];	
					$data['skt_collections'][$i]['is_authorized']=1;							
					$data['skt_collections'][$i]['authorized_by']=$user['id'];	
					$data['skt_collections'][$i]['authorization_date']=date('Y-m-d');	
					$i++;					
				}
			}
			//echo "<pre>";print_r($data['skt_collections']);die;
			if($this->Skt_collection->authorized($data['skt_collections']))
			{
				$this->session->set_flashdata('message','SKT Collection Information has been authorized successfully');
				redirect('/skt_collections/authorization_index/');
			}
		}
		$data['title']='SKT Collection Authorization';	
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Skt_collection->get_unauthorized_skt_collections_list_row_count($cond);		

		//Initializing Pagination
		$config['base_url'] = site_url('/skt_collections/authorization_index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);			
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());
		//Loading data by model function call
		$data['skt_collections']=$this->Skt_collection->get_unauthorized_skt_collections_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		$data['counter'] = (int)$this->uri->segment(3);
		// Loading samity list which will be used in combo box	
				
		$this->layout->view('/skt_collections/authorization_index',$data);
	}
	
	function index()
	{
		$cond= "";
		$session_data = $this->session->userdata('skt_collections.index');
		//print_r($session_data);die;
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity']) || isset($_POST['txt_transaction_date']))
		{
			$cond['name'] = $this->input->post('txt_name');
			$cond['samity'] = $this->input->post('cbo_samity');				
			$cond['transaction_date'] = $this->input->post('txt_transaction_date');						
			$sessionArray = array( 'skt_collections.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity'],'txt_transaction_date'=>$cond['transaction_date']));			
			$this->session->unset_userdata('skt_collections.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];			
			$cond['transaction_date'] = $session_data['txt_transaction_date'];					
		} else {
			$this->session->unset_userdata('skt_collections.index');
		}

		// load pagination class
		$this->load->library('pagination');
		$total = $this->Skt_collection->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/skt_collections/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());			
		$data['transactions'] = array('DEP'=>'Deposit','INT'=>'Interest');

		//Loading data by model function call
		$data['skt_collections']=$this->Skt_collection->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='SKT Collection';
        $data['headline'] = 'SKT Collection Information';
		$this->layout->view('/skt_collections/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{			
			//echo "<pre>";print_r($_POST);die;
			$data=$this->_get_posted_data();
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			//load session data
			$user=$this->session->userdata('system.user');		
			$data['payment_received_by']=$user['id'];		
			//Perform the Validation
			//print_r($_POST);			
			//echo "<pre>";print_r($data);die;
			if ($this->form_validation->run() === TRUE)
			{
				//echo "<pre>";print_r($data);die;
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Skt_collection->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/skt_collections/index/', 'refresh');
				}
			} else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		if($is_validate_error and isset($member_id) and !empty($member_id)){
			$member_info=$this->Saving->get_member_info($member_id);
			$data['row']->member_id = $member_info[0]->id;
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$data['row']->branch_id = isset($branch_id)?$branch_id:"";
			$data['row']->samity_id = isset($samity_id)?$samity_id:"";
		}
		$data['title']='Add SKT collection';
        $data['headline'] = 'Add New';
		$this->layout->view('/skt_collections/save',$data);				
	}	
	
	function edit($skt_collection_id=null)
	{
		//If ID is not provided, redirecting to index page
		if(empty($skt_collection_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','SKT Collection ID is not provided');
			redirect('/skt_collections/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$skt_collection_id=$this->input->post('skt_collection_id'); 
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			//Perform the Validation	
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('skt_collection_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Skt_collection->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/skt_collections/index/', 'refresh');
				}
			}
		}
		//Load data from database		
		$row=$this->Skt_collection->read($skt_collection_id);
		$data['row']=$row[0];
		if(isset($row[0]->member_id)){
			$member_info=$this->Skt_collection->get_member_info($row[0]->member_id);
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
		}
		elseif($is_validate_error and isset($member_id) and !empty($member_id)){
			//$member_info=$this->Skt_collections->get_member_info($row[0]->member_id);
			//$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$member_info=$this->Skt_collections->get_member_info($member_id);
			$data['row']->member_id = $member_info[0]->id;
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$data['row']->branch_id = isset($branch_id)?$branch_id:"";
			$data['row']->samity_id = isset($samity_id)?$samity_id:"";			
		}	
		$data['payments'] = array('CASH'=>'CASH','CHQ'=>'CHQ');	
		$data['title']='Edit SKT collection';
        $data['headline'] = 'Edit';
		$this->layout->view('/skt_collections/save',$data);		
	}
	/*
     * @Modified By: Matin
     * @Modification Date : 21-03-2011
     */
	function delete($skt_collection_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($skt_collection_id))
		{
			$this->session->set_flashdata('warning','SKT Collection ID is not provided');
			redirect('/skt_collections/index/', 'refresh');
		}
		else
		{
			if($this->Skt_collection->delete($skt_collection_id))
			{
				$this->session->set_flashdata('message','SKT Collection Information has been deleted successfully');
				redirect('/skt_collections/index/');
			}
									
		}	
	}
	function _get_posted_data()
	{
		$data=array();		
		$data['branch_id']=$this->input->post('branch_id');
		$data['samity_id']=$this->input->post('samity_id');
		$data['member_id']=$this->input->post('member_id');
		$data['member_primary_product_id']=$this->input->post('member_primary_product_id');
		$data['mode_of_payment']=$this->input->post('cbo_payment_type');
		$data['transaction_date']=$this->input->post('txt_transaction_date');
		$data['amount']=$this->input->post('txt_amount');
		// current_status default 1
		//$data['current_status'] = 1;		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		//$this->form_validation->set_rules('txt_code','Code','trim|required|max_length[200]|xss_clean|callback_check_code');		
		$this->form_validation->set_rules('member_id','Memebr','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_transaction_date','Transaction Date','trim|max_length[10]|xss_clean|required|callback_check_transaction_date');		
		$this->form_validation->set_rules('txt_amount','Amount','trim|numeric|required|xss_clean');
		$this->form_validation->set_rules('cbo_payment_type','Payment Type','trim|required|xss_clean');					
	}
	function _load_combo_data()
	{	
		// Transaction type list which will be used in combo box
		$data['payments'] = array('CASH'=>'CASH','CHQ'=>'CHQ');
		return $data;
	}	
	/**
	 * @name check_opening_date
	 * @uses skt_collections(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 20-Feb-2011
	 */
	function check_transaction_date()
	{
		// check_transaction_date
		$transaction_date=$this->input->post('txt_transaction_date');		
		$member_id=$this->input->post('member_id');
		$product_id=$this->input->post('cbo_product');
		if(!empty($member_id) && !empty($product_id))
		{
			$savings_opening_date = $this->Saving->get_savings_opening_date($member_id,$product_id);						
			if($savings_opening_date>$transaction_date) {
				$this->form_validation->set_message('check_transaction_date', "Transaction date must be greater than savings opening date.");
					return FALSE;
			}
		}
		return TRUE;					
	}		
}
