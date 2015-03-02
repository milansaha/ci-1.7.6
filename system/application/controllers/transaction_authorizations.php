<?php
/** 
	* Transaction_authorizations Controller Class.
	* @pupose		Manage transaction_authorizations information
	*		
	* @filesource	\app\controllers\transaction_authorizations.php	
	* @package		microfin 
	* @subpackage	microfin.controller.transaction_authorizations
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-03-02 $	 
*/ 
	
class Transaction_authorizations extends MY_Controller {
	
	function Transaction_authorizations()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Transaction_authorization','Samity'),'',TRUE);
	}

	/*function ajax_authorization_index()
	{
		$this->output->enable_profiler(true);
		$cond= "";
		$session_data = $this->session->userdata('transaction_authorizations.index');	 
		$b='tapohi';
		$a=$this->input->post('member_id');		
		echo $b;echo $a;die;
		//echo "<pre>";print_r($a);
		if(isset($_POST['transactiondata']))
		{
			//echo "<pre>";print_r($_POST['transactiondata']);die;
			$user=$this->session->userdata('system.user');
			$i=1;
			$f=0;
			if($this->input->post('submit_1'))
			{			
				foreach($_POST['transactiondata'] as $row)
				{				
					if(!empty($row['is_authorized']))
					{												
						$f=1;
						$data['transaction_authorizations'][$i]['samity_id']=$row['samity_id'];										
						$data['transaction_authorizations'][$i]['is_authorized']=$row['is_authorized'];
						$data['transaction_authorizations'][$i]['authorized_by']=$user['id'];	
						$data['transaction_authorizations'][$i]['authorization_date']=date('Y-m-d');	
						$i++;
					}										
				}								
			}
			if($this->input->post('submit_2'))
			{				
				if(!empty($_POST['transactiondata'] )){
					foreach($_POST['transactiondata'] as $row)
					{				
						$f=1;
						$data['transaction_authorizations'][$i]['samity_id']=$row['samity_id'];										
						$data['transaction_authorizations'][$i]['is_authorized']=1;
						$data['transaction_authorizations'][$i]['authorized_by']=$user['id'];	
						$data['transaction_authorizations'][$i]['authorization_date']=date('Y-m-d');	
						$i++;								
					}
				}
			}
			//echo "<pre>";print_r($data['transaction_authorizations']);die;
			if($f==1)
			{
				if($this->Transaction_authorization->authorized($data['transaction_authorizations']))
				{
					$this->session->set_flashdata('message','Information has been authorized successfully');
					redirect('/transaction_authorizations/authorization_index/');
				}
				else
				{
					$this->session->set_flashdata('warning','Information could not be authorized');
					redirect('/transaction_authorizations/authorization_index/');
				}
			}
			else
			{
				$this->session->set_flashdata('warning','No Information is selected for authorization');
				redirect('/transaction_authorizations/authorization_index/');
			}
		}
		$data['title']='Transaction Authorization';	
		// load pagination class
		$this->load->library('pagination');
		$data['transaction_authorizations']=$this->Transaction_authorization->get_unauthorized_transaction_authorizations_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		//echo "<pre>";print_r($query);
		$total=0;
		if(count($data['transaction_authorizations'])>0)		
		{	
			$total = count($data['transaction_authorizations']);	
		}
		//Initializing Pagination
		$config['base_url'] = site_url('/transaction_authorizations/authorization_index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);			
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());
		//Loading data by model function call		
		$data['counter'] = (int)$this->uri->segment(3);
		// Loading samity list which will be used in combo box		
		
		$this->layout->view('/transaction_authorizations/authorization_index',$data);
	}*/
	function authorization_index()
	{
		$this->output->enable_profiler(true);
		$cond= "";
		$session_data = $this->session->userdata('transaction_authorizations.index');	 
		$b='tapohi';
		$a=$this->input->post('member_id');		
		//echo $b;echo $a;
		//echo "<pre>";print_r($a);
		if(isset($_POST['transactiondata']))
		{
			//echo "<pre>";print_r($_POST['transactiondata']);die;
			$user=$this->session->userdata('system.user');
			$i=1;
			$f=0;
			if($this->input->post('submit_1'))
			{			
				foreach($_POST['transactiondata'] as $row)
				{				
					if(!empty($row['is_authorized']))
					{												
						$f=1;
						$data['transaction_authorizations'][$i]['samity_id']=$row['samity_id'];										
						$data['transaction_authorizations'][$i]['is_authorized']=$row['is_authorized'];
						$data['transaction_authorizations'][$i]['authorized_by']=$user['id'];	
						$data['transaction_authorizations'][$i]['authorization_date']=date('Y-m-d');	
						$i++;
					}										
				}								
			}
			if($this->input->post('submit_2'))
			{				
				if(!empty($_POST['transactiondata'] )){
					foreach($_POST['transactiondata'] as $row)
					{				
						$f=1;
						$data['transaction_authorizations'][$i]['samity_id']=$row['samity_id'];										
						$data['transaction_authorizations'][$i]['is_authorized']=1;
						$data['transaction_authorizations'][$i]['authorized_by']=$user['id'];	
						$data['transaction_authorizations'][$i]['authorization_date']=date('Y-m-d');	
						$i++;								
					}
				}
			}
			//echo "<pre>";print_r($data['transaction_authorizations']);die;
			if($f==1)
			{
				if($this->Transaction_authorization->authorized($data['transaction_authorizations']))
				{
					$this->session->set_flashdata('message','Information has been authorized successfully');
					redirect('/transaction_authorizations/authorization_index/');
				}
				else
				{
					$this->session->set_flashdata('warning','Information could not be authorized');
					redirect('/transaction_authorizations/authorization_index/');
				}
			}
			else
			{
				$this->session->set_flashdata('warning','No Information is selected for authorization');
				redirect('/transaction_authorizations/authorization_index/');
			}
		}
		$data['title']='Transaction Authorization';	
		// load pagination class
		$this->load->library('pagination');
		$data['transaction_authorizations']=$this->Transaction_authorization->get_unauthorized_transaction_authorizations_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);
		//echo "<pre>";print_r($query);
		$total=0;
		if(count($data['transaction_authorizations'])>0)		
		{	
			$total = count($data['transaction_authorizations']);	
		}
		//Initializing Pagination
		$config['base_url'] = site_url('/transaction_authorizations/authorization_index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);			
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());
		//Loading data by model function call		
		$data['counter'] = (int)$this->uri->segment(3);
		// Loading samity list which will be used in combo box		
		
		$this->layout->view('/transaction_authorizations/authorization_index',$data);
	}
	function authorization_detail($samity_id=null){
		if(empty($samity_id))
		{
			$this->session->set_flashdata('warning','Samity ID is not provided');
			redirect('/transaction_authorizations/authorization_index/');
		}
		else
		{
			$data['title']='Transaction Authorization Detail';	
			// load pagination class
			$this->load->library('pagination');
			$data['samity']=$this->Samity->get_samity_info($samity_id);			
			$data['transaction_authorizations_detail']=$this->Transaction_authorization->get_samity_wise_unauthorized_transaction_authorizations_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$samity_id);
			$total=0;
			if(count($data['transaction_authorizations_detail'])>0)		
			{	
				$total = count($data['transaction_authorizations_detail']);	
			}
			//Initializing Pagination
			$config['base_url'] = site_url('/transaction_authorizations/authorization_detail/');
			$config['total_rows'] = $total;
			$config['per_page'] = ROW_PER_PAGE;
			$this->pagination->initialize($config);			
			//$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());
			//Loading data by model function call			
			$data['counter'] = (int)$this->uri->segment(3);
			// Loading samity list which will be used in combo box				
			$this->layout->view('/transaction_authorizations/authorization_detail',$data);		
		}			
	}
}
