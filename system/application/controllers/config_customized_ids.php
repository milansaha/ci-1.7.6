<?php
class Config_customized_ids extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Config_customized_id','',TRUE);	
		error_reporting(E_ALL);	
	}

	function index()
	{
		$data['title']='Id Configuration';
		$data['headline']='Id Configuration';

		$row=$this->Config_customized_id->readall();
		//print_r($row);
               // var_dump($row);
                if(isset($row) && isset($row->id) && $row->id!=''){
                
                    $data['config_id']=$row;
                } else {
					redirect('/config_customized_ids/add/','refresh');
				}
         
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('config_customized_ids/index',$data);
	}

	function ajaxmethod_for_get_branch_list() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$branch_id      = $this->input->post('branch_id');
		if(empty($branch_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select a Branch';
        }
		else
        {
			$callback_message['status'] = 'success';
			$callback_message['samity_id'][] = '';
			$callback_message['samity_name'][] = '--Select--';
			$samities_info = $this->Config_customized_id->get_samity_by_branch($branch_id);
	  		 foreach( $samities_info as $row) {
				 $callback_message['samity_id'][] = $row->samity_id;
				 $callback_message['samity_name'][] = $row->samity_name;		
	  		}
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }		
	}
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			//Perform the Validation
			if(1 == TRUE)
			{				
                //Validation is OK. So, add this data and redirect to the index page
				if($this->Config_customized_id->add($data))
				{
					$this->session->set_flashdata('message','Configuration has been added successfully');					
                    redirect('/config_customized_ids/index/','refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Auto ID Configuration';
		$data['headline']='Add Auto ID Configuration';
		$this->layout->view('/config_customized_ids/editconfig',$data);
	}	
	
	function edit($Config_customized_id_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($Config_customized_id_id) && !$_POST)
		{
			$this->session->set_flashdata('message','ID is not provided');
			redirect('/Config_customized_ids/index/', 'refresh');
		}
                
		
		$this->_prepare_validation();
        $data['id']=$this->input->post('config_id');
        // print_r($data['id']);
        //die();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if(isset($data['id']) && $_POST)
		{
			//echo $data['id'];
			$data=$this->_get_posted_data();
			// print_r($data);
			//die();
			//$Config_customized_id_id=$_POST['Config_customized_id_id'];
			//Perform the Validation
							
			$data=$this->_get_posted_data();
			$data['id']=$this->input->post('config_id');
			//Validation is OK. So, add this data and redirect to the index page		  
			if($this->Config_customized_id->edit($data))
			{
					$this->session->set_flashdata('message','Configuration has been updated successfully');
					redirect('/config_customized_ids/index/','refresh');
			}                               
			
		}
		//Load data from database
		$row=$this->Config_customized_id->read($Config_customized_id_id);
		$data = $this->_load_combo_data();
		$data['row']=$row[0];
        $data['title'] = 'Auto ID Configuration';
        $data['headline'] = 'Auto ID Configuration';
		//If data is not posted or validation fails, the add view is displayed
        //print_r($data['row']);
		$this->layout->view('config_customized_ids/editconfig',$data);
	}
	
	function delete($Config_customized_id_id=null)
	{	
		if($this->Config_customized_id->delete($Config_customized_id_id))
		{
			$this->session->set_flashdata('message','Holiday Configuration has been deleted successfully');
			redirect('/Config_customized_ids/index/');
		}
	}
	
	function _get_posted_data()
	{
		$data=array();		

		$data['is_branch_code_need']=$this->input->post('txt_is_branch_code_need');
		$data['branch_code_length']=$this->input->post('branch_code_length');

		$data['is_samity_code_need']=$this->input->post('txt_is_samity_code_need');
		$data['samity_code_length']=$this->input->post('samity_code_length');
		$data['is_include_branch_code_for_samity']=$this->input->post('txt_is_include_branch_code_for_samity');
		$data['is_product_code_for_samity']=$this->input->post('txt_is_include_product_code_for_samity');
		$data['samity_code_separator']=$this->input->post('samity_code_separator');
		$data['is_samity_product_fundname_need']=$this->input->post('samity_product_fund_name');


		$data['is_member_code_need']=$this->input->post('txt_is_member_code_need');
		$data['member_code_length']=$this->input->post('member_code_length');
		$data['is_include_samity_code_for_member']=$this->input->post('txt_is_include_samity_code_for_member');
		$data['is_include_branch_code_for_member']=$this->input->post('txt_is_include_branch_code_for_member');
		$data['member_code_separator']=$this->input->post('member_code_separator'); //echo 'hello';die();


		$data['is_saving_code_need']=$this->input->post('savings_product_code_length');	
		$data['is_saving_product_short_name_need']=$this->input->post('savings_product_short_name');	
		$data['is_include_member_code_for_savings']=$this->input->post('txt_is_include_member_code_for_savings');
		$data['savings_code_separator']=$this->input->post('savings_code_separator');


		$data['is_loan_code_need']=$this->input->post('product_loan_code_length');
		$data['is_loan_product_short_name_need']=$this->input->post('product_loan_code_shortname');
		$data['is_include_member_code_for_loan']=$this->input->post('txt_is_include_member_code_for_loan');
		$data['is_cycle_need']=$this->input->post('cycle_code')?1:0;
		$data['loan_code_separator']=$this->input->post('loan_code_separator');
		$data['is_loan_product_fundname_need']=$this->input->post('product_loan_fund_name');
		//print_r($data);
		//die();
		return $data;
	}
	
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		//$this->form_validation->set_rules('txt_holiday_date','Holiday Date','required');
		//$this->form_validation->set_rules('txt_description','Description','trim|xss_clean|max_length[500]');
		//$this->form_validation->set_rules('cbo_branch','Branch Name','');
		//$this->form_validation->set_rules('cbo_samity','Samity Name','');
		//$this->form_validation->set_rules('cbo_holiday_type','Holiday Type','required');
	}
	
	function _load_combo_data()
	{
		//This function is for listing of Holiday	
		$data['config_code_used_for'] = array(''=>'--Select--','Branch'=>'Branch','Samity'=>'Samity','Group'=>'Group','Sub Group'=>'Sub Group','Product'=>'Product','Member'=>'Member','Saving'=>'Saving','Loan'=>'Loan');
		$data['config_code_length'] = array(''=>'--Select--',2=>2,3=>3,4=>4,5=>5,6=>6,7=>7);
		$data['config_code_separator'] = array(''=>'--Select--','.'=>'.','-'=>'-');
		$data['config_code_product_savings'] = $this->Config_customized_id->get_saving_product();
        $data['config_code_product_loans'] = $this->Config_customized_id->get_loan_product();
       //$data['config_cycle'] = array(''=>'--Select--',cycle=>1);
        return $data;
	}
}
