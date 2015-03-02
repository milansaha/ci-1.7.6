<?php
/** 
	* PO Thana Controller Class.
	* @pupose		Manage thana information
	*		
	* @filesource	\app\controllers\po_thanas_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.po_thanas_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Po_thanas extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form','jquery'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_division','Po_thana','Po_district'),'',TRUE);		
	}
		
	function ajaxmethod_for_get_district_list() {
  		 foreach($this->Po_thana->get_district_list_by_division($this->input->post('division_id')) as $row) {
    		 echo "<option value=".$row->id.">".$row->name."</option>\n";		
  		}		
	}

    function ajax_for_get_district_by_division()
    {
        $this->output->enable_profiler(FALSE);
		$callback_message = array();
		$division_id  = $this->input->post('division_id');
		if(empty($division_id))
        {
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select Division';
        }
		else
        {
			$callback_message['status'] = 'success';
			$district_info = $this->Po_district->get_district_by_division($division_id);
            //print_r($district_info);die;
			if(!empty($district_info)) {
				foreach( $district_info as $row) {
                    $callback_message['district']['id'][] = $row->id;
                    $callback_message['district']['name'][] = $row->name;
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
            //die;
	    }		
    }

    function index()
	{	
		/* Conditions for filtering */
		$cond= "";
		$session_data = $this->session->userdata('po_thanas.index');
		if($_POST){
			$cond['name'] = $this->input->post('txt_name');
            $cond['cbo_division'] = $this->input->post('cbo_division');
            $cond['cbo_district'] = $this->input->post('cbo_district');

			$sessionArray = array( 'po_thanas.index'=>array(
                                        'name'=>$cond['name'],
                                        'cbo_division'=>$cond['cbo_division'],
                                        'cbo_district'=>$cond['cbo_district']));

            $this->session->unset_userdata('po_thanas.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_division'] = $session_data['cbo_division'];
            $cond['cbo_district'] = $session_data['cbo_district'];

		} else {
			$this->session->unset_userdata('po_thanas.index');
		}
		/* End of filtering conditions */
        
		 $data['divisions'] = $this->Po_division->get_division_list();
        if(isset ($cond['cbo_division']))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($cond['cbo_division']);
        }
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_thana->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_thanas/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_thanas']=$this->Po_thana->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3), $cond);	
		$data['counter'] = (int)$this->uri->segment(3);	
		$data['title']='Thanas';
		$this->layout->view('/po_thanas/index',$data);
	}
	
	function add()
	{
        $is_validate_error = FALSE;
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_thana->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_thanas/add/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
        if($is_validate_error){
			$data['row']->division_id = $this->input->post('cbo_division');
			$data['row']->district_id = $this->input->post('cbo_district');
		}
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Thana';
		$data['headline']='Add Thana';
		$this->layout->view('/po_thanas/save',$data);
	}	
	
	function edit($thana_id=null)
	{
		//If ID is not provided, redirecting to index page
		if(empty($thana_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Thana ID is not provided');
			redirect('/po_thanas/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$thana_id=$_POST['thana_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('thana_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_thana->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_thanas/index/', 'refresh');
				}
			}
		}
		$data = $this->_load_combo_data();
		$data['row']=$this->Po_thana->read($thana_id);
       
        if(isset ($data['row']->division_id))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($data['row']->division_id);
        }
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Edit Thana';
		$data['headline']='Edit';
		$this->layout->view('/po_thanas/save',$data);
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 15-03-2011
     */
    function delete($thana_id=null)
	{
        if(empty($thana_id))
		{
			$this->session->set_flashdata('warning','District ID is not provided');
			redirect('/po_thanas/index/');
		}
		//Check wether the child data exists
        $has_po_unions_or_wards_entry = $this->Po_thana->is_dependency_found('po_unions_or_wards',  array('thana_id' => $thana_id));
        if($has_po_unions_or_wards_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_thanas/index/');
        }
        else
        {
            if($this->Po_thana->delete($thana_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_thanas/index/');
            }
        }
	}

    
	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		$data['division_id']=$this->input->post('cbo_division');
		$data['district_id']=$this->input->post('cbo_district');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_division','Division','trim|required');
		$this->form_validation->set_rules('cbo_district','District','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[200]|xss_clean|callback_chek_duplicate_thana_in_same_district');
	}
	function _load_combo_data()
	{		
		$data['divisions'] = $this->Po_division->get_division_list();			
		$data['districts'] = $this->Po_district->get_district_by_division($this->input->post('cbo_division'));        
		return $data;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check the duplicate thana under the same District
     * @Use: Useed in _prepare_validation() method
     * @Modification Date: 24-03-2011
     */
    function chek_duplicate_thana_in_same_district()
    {
        $CI =& get_instance();
        
		$CI->load->database();
        if($_POST)
        {
            $data = $this->_get_posted_data();
            $data['thana_id']=$this->input->post('thana_id');
            //print_r($data['thana_id']);die;
            $this->form_validation->set_message('chek_duplicate_thana_in_same_district','The %s is already being used under the selected District.');
            if ( isset($data['name']) and ! empty($data['name']) and isset($data['district_id']) and ! empty($data['district_id']) and isset($data['thana_id']) and ! empty($data['thana_id']))
            {
                $query = $CI->db->select('name')->from('po_thanas')->where(array('district_id' =>$data['district_id'],'name' => $data['name'],'id !=' => $data['thana_id']) )->limit(1)->get();
            } else {
                $query = $CI->db->select('name')->from('po_thanas')->where(array('district_id' =>$data['district_id'],'name' => $data['name']) )->limit(1)->get();
            }
        }
       return $query->row()?false:true;
    }	
}
