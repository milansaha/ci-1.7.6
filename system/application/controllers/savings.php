<?php
/** 
	* Savings Controller Class.
	* @pupose		Manage savings information
	*		
	* @filesource	\app\controllers\savings.php	
	* @package		microfin 
	* @subpackage	microfin.controller.savings
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class savings extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('auth');
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Saving','Samity','Member','Po_funding_organization','Config_customized_id'),'',TRUE);
	}

	function index()
	{		
		$cond= "";
		$session_data = $this->session->userdata('savings.index');
		//print_r($session_data);die;
		if(isset($_POST['txt_name']) || isset($_POST['cbo_samity'])){
			$cond['name'] = $_POST['txt_name'];		
			$cond['samity'] = $_POST['cbo_samity'];						
			$sessionArray = array( 'savings.index'=>array('name'=>$cond['name'],'cbo_samity'=>$cond['samity']));			
			$this->session->unset_userdata('savings.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {			
			$cond['name'] = $session_data['name'];	
			$cond['samity'] = $session_data['cbo_samity'];					
		} else {
			$this->session->unset_userdata('savings.index');
		}

		// load pagination class
		$this->load->library('pagination');
		$total = $this->Saving->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/savings/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		$data['samities'] = $this->Samity->get_samity_list($this->get_branch_id());			

		//Loading data by model function call
		$data['savings']=$this->Saving->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Savings';
        $data['headline']='Savings Information';
		$this->layout->view('/savings/index',$data);
	}
	
	function add()
	{		
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		$is_validate_error = false;
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			$cbo_product = $this->input->post('cbo_product');
			$type_of_deposite=$this->input->post('type_of_deposite');
			$interest_rate=$this->input->post('interest_rate');
			$cbo_funding_organization=$this->input->post('cbo_funding_organization');			
			//load session data
			$user=$this->session->userdata('system.user');		
			$data['created_by']=$user['id'];		
			$data['created_on']=date("Y-m-d");	
			//Perform the Validation
			//print_r($_POST);
			
			if ($this->form_validation->run() === TRUE)
			{
				//echo "<pre>";print_r($data);die;
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/savings/index/', 'refresh');
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
			$data['row']->saving_products_id = isset($cbo_product)?$cbo_product:"";
			$data['row']->type_of_deposite = isset($type_of_deposite)?$type_of_deposite:"";
			$data['row']->interest_rate = isset($interest_rate)?$interest_rate:"";
			$data['row']->funding_organization_id = isset($cbo_funding_organization)?$cbo_funding_organization:"";				
		}
		$data['title']='Add Savings';
        $data['headline']='Add New';
		$this->layout->view('/savings/save',$data);				
	}	
	
	function view($saving_id=null)
	{	
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($saving_id))
		{
			$this->session->set_flashdata('warning',DEPENDENT_DATA_FOUND);
			redirect('/savings/index/', 'refresh');
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Saving->read($saving_id);
		$data['row']=$row[0];		
		if(isset($row[0]->member_id)){
			$member_info=$this->Saving->get_member_info($row[0]->member_id);
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
		}
		elseif($is_validate_error and isset($member_id) and !empty($member_id)){
			$member_info=$this->Saving->get_member_info($member_id);
			$data['row']->member_id = $member_info[0]->id;
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$data['row']->branch_id = isset($branch_id)?$branch_id:"";
			$data['row']->samity_id = isset($samity_id)?$samity_id:"";
			$data['row']->saving_products_id= isset($cbo_product)?$cbo_product:"";
			$data['row']->funding_organization_id = isset($cbo_funding_organization)?$cbo_funding_organization:"";			
		}	
		if(isset($row[0]->saving_products_id)){
			$product_info=$this->Saving->get_savings_product_info($row[0]->saving_products_id);
			$data['row']->type_of_deposite = $product_info[0]->type_of_deposit;
			$data['row']->interest_rate = $product_info[0]->interest_rate;			
		}
		elseif($is_validate_error and isset($cbo_product) and !empty($cbo_product)){
			$product_info=$this->Saving->get_savings_product_info($cbo_product);
			$data['row']->type_of_deposite = $product_info[0]->type_of_deposit;
			$data['row']->interest_rate = $product_info[0]->interest_rate;
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Savings';
        $data['headline']='Edit';
		$this->layout->view('/savings/view',$data);		
	}
	
	
	function edit($saving_id=null)
	{	
		$is_validate_error = FALSE;
		//$this->load->library('auth');
		//If ID is not provided, redirecting to index page
		if(empty($saving_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Savings ID is not provided');
			redirect('/savings/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
			$saving_id=$this->input->post('saving_id'); 
			$branch_id = $this->input->post('branch_id');		
			$samity_id = $this->input->post('samity_id'); 
			$member_id = $this->input->post('member_id'); 			
			$cbo_product = $this->input->post('cbo_product');
			$type_of_deposite=$this->input->post('type_of_deposite');
			$interest_rate=$this->input->post('interest_rate');
			$code=$this->input->post('txt_code');
			$cbo_funding_organization=$this->input->post('cbo_funding_organization');			
			//load session data		
			$user=$this->session->userdata('system.user');			
			$data['updated_by']=$user['id'];		
			$data['updated_on']=date("Y-m-d");
			//Perform the Validation	
			if ($this->form_validation->run() === TRUE)
			{						
				$data['id']=$this->input->post('saving_id');				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Saving->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/savings/index/', 'refresh');
				}
			}else{
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$row=$this->Saving->read($saving_id);
		$data['row']=$row[0];		
		if(isset($row[0]->member_id)){
			$member_info=$this->Saving->get_member_info($row[0]->member_id);
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
		}
		if($is_validate_error and isset($member_id) and !empty($member_id)){
			echo "Here";
			$member_info=$this->Saving->get_member_info($member_id);
			$data['row']->member_id = $member_info[0]->id;
			$data['row']->member_info = $member_info[0]->name.' - '.$member_info[0]->code;
			$data['row']->branch_id = isset($branch_id)?$branch_id:"";
			$data['row']->samity_id = isset($samity_id)?$samity_id:"";
			$data['row']->saving_products_id= isset($cbo_product)?$cbo_product:"";
			$data['row']->funding_organization_id = isset($cbo_funding_organization)?$cbo_funding_organization:"";			
		}	
		if(isset($row[0]->saving_products_id)){
			$product_info=$this->Saving->get_savings_product_info($row[0]->saving_products_id);
			$data['row']->type_of_deposite = $product_info[0]->type_of_deposit;
			$data['row']->interest_rate = $product_info[0]->interest_rate;
			//$data['row']->code = $product_info[0]->code;		
		}
		elseif($is_validate_error and isset($cbo_product) and !empty($cbo_product)){
			$product_info=$this->Saving->get_savings_product_info($cbo_product);
			$data['row']->type_of_deposite = $product_info[0]->type_of_deposit;
			$data['row']->interest_rate = $product_info[0]->interest_rate;
			$data['row']->code = $product_info[0]->code;
			
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Savings';
        $data['headline']='Edit';
		$this->layout->view('/savings/save',$data);		
	}
    /*
     * @Modified By: Matin
     * @Modification Date : 21-03-2011
     */
    function delete($saving_id=null)
	{
        if(empty($saving_id))
		{
			$this->session->set_flashdata('warning','Savings ID is not provided');
			redirect('/savings/index/');
		}
		//Check wether the child data exists
        $has_saving_deposits_entry = $this->Saving->is_dependency_found('saving_deposits',  array('savings_id' => $saving_id));
        if($has_saving_deposits_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/savings/index/');
        }
        else
        {
            if($this->Saving->delete($saving_id))
			{
				$this->session->set_flashdata('message',DELETE_MESSAGE);
				redirect('/savings/index/', 'refresh');
			}
        }
	}

	function _get_posted_data()
	{
		$data=array();		
		$data['code']=$this->input->post('txt_code');
		$data['branch_id']=$this->input->post('branch_id');
		$data['samity_id']=$this->input->post('samity_id');
		$data['member_id']=$this->input->post('member_id');
		$data['saving_products_id']=$this->input->post('cbo_product');
		$data['funding_organization_id']=$this->input->post('cbo_funding_organization');
		$data['weekly_savings']=$this->input->post('txt_weekly_savings');
		$data['opening_date']=$this->input->post('txt_opening_date');
		// current_status default 1		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('txt_code','Code','trim|required|max_length[100]|xss_clean|callback_check_code');		
		$this->form_validation->set_rules('member_id','Memebr','trim|required|xss_clean');
		$this->form_validation->set_rules('cbo_product','Product','trim|required|xss_clean');
		$this->form_validation->set_rules('cbo_funding_organization','Funding Organization','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_opening_date','Opening Date','trim|max_length[10]|xss_clean|is_date|callback_check_opening_date|required');	
		$this->form_validation->set_rules('txt_weekly_savings','Weekly Savings','trim|numeric|xss_clean');	
	}
	function _load_combo_data()
	{	
		// Loading products list which will be used in combo box
		$data['products'] = $this->Saving->get_saving_products_list($this->input->post('member_id'));	
		// Loading funding organization list which will be used in combo box
		$data['funding_organizations'] = $this->Po_funding_organization->get_funding_organization_list();	
		return $data;
	}
	/**
	 * @name check_opening_date
	 * @uses savings(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 20-Feb-2011
	 */
	function check_opening_date()
	{
		// check_disburse_date
		$loan_opening_date=$this->input->post('txt_opening_date');
		$member_registration_date = $this->Member->get_member_registration_date($this->input->post('member_id'));		
		if($member_registration_date>$loan_opening_date) {
			$this->form_validation->set_message('check_opening_date', "Opening date must be greater then member registration date.");
		        return FALSE;
		}		
		return TRUE;
	}
	/**
	 * @name check_code
	 * @uses savings(add,edit)
	 * @lasUpdatedBy Taposhi Rabeya
	 * @lastDate 20-Feb-2011
	 */
	function check_code()
	{
		// check_code			
		$savings_id=$this->input->post('saving_id');
		if(empty($savings_id))	
		{
			$savings_code = $this->Saving->get_savings_code($this->input->post('txt_code'));						
			if(!empty($savings_code)) {
				$this->form_validation->set_message('check_code', "Savings code must be unique.");
				    return FALSE;
			}		
			return TRUE;
		}										
	}
	/**
	 * Get savings product information.
	 *  @use savings(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 10-Mar-2011
	*/
	function ajax_for_get_savings_product_info() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$member_id      = $this->input->post('member_id');
		$product_id      = $this->input->post('product_id');
		$separator='';
		$savings_code='';

		if(empty($product_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';			
			$config_info = $this->Config_customized_id->get_auto_id_config_info();		
			$product_info = $this->Saving->get_savings_product_info($product_id);				
			if(!empty($product_info)) {
				foreach($product_info as $row) {
					if( isset($config_info->is_saving_code_need) AND $config_info->is_saving_code_need) {
						$separator = $config_info->savings_code_separator;
						if( isset($config_info->is_saving_product_short_name_need) AND $config_info->is_saving_product_short_name_need) {
							$savings_code=$row->short_name.$separator;
						}
						if( isset($config_info->is_include_member_code_for_savings) AND $config_info->is_include_member_code_for_savings) {
							$savings_code=$savings_code.$this->Saving->get_member_code($member_id);
						}
					}
					$callback_message['savings']['savings_code'][] = $savings_code;
					$callback_message['savings_product']['type_of_deposite'][] = $row->type_of_deposit;
					$callback_message['savings_product']['mandatory_amount_for_deposite'][] = $row->mandatory_amount_for_deposit;
					$callback_message['savings_product']['interest_rate'][] = $row->interest_rate;									
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }			  	
	} 
	/**
	 * Get savings product list where member currently not loned.
	 *  @use savings(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 20-Feb-2011
	*/
	function ajax_for_get_savings_product_list_by_member() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$member_id      = $this->input->post('member_id');
		if(empty($member_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			$product_info = $this->Saving->get_saving_products_list($member_id);			
			if(!empty($product_info)) {
				foreach( $product_info as $row) {
				$callback_message['product']['id'][] = $row->id;
				$callback_message['product']['name'][] = $row->name;		
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }			  	
	} 		
	/**
	 * Get member savings product.
	 *  @use saving_deposites(save),saving_withdraws(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 22-Feb-2011
	*/
	function ajax_for_get_member_savings_code() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$member_id      = $this->input->post('member_id');
		if(empty($member_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			//print_r($product_info);die;
			$product_info = $this->Saving->get_member_savings_code_list($member_id);			
			//print_r($product_info);die;
			if(!empty($product_info)) {
				foreach( $product_info as $row) {
				$callback_message['savings']['id'][] = $row->id;				
				$callback_message['savings']['code'][] = $row->code;
				$callback_message['product']['short_name'][] = $row->short_name;					
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }			  	
	} 
	/**
	 * Get member savings id.
	 *  @use saving_deposites(save),saving_withdraws(save)
	 *  @lasUpdatedBy Taposhi Rabeya
	 *  @lastDate 22-Feb-2011
	*/
	function ajax_for_get_product_info() {
		$this->output->enable_profiler(FALSE);
		$callback_message = array();
		$savings_id      = $this->input->post('savings_id');
		if(empty($savings_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Type member';
        }
		else
        {
			$callback_message['status'] = 'success';
			//print_r($product_info);die;
			$savings_info = $this->Saving->get_member_savings_product_info($savings_id);			
			//print_r($product_info);die;
			if(!empty($savings_info)) {
				foreach( $savings_info as $row) {
				$callback_message['savings']['saving_products_id'][] = $row->saving_products_id;
				$callback_message['savings']['weekly_savings'][] = $row->weekly_savings;						
	  			}
			}
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
			}	  		 
		}
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }			  	
	} 	
}
