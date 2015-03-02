<?php
/** 
	* PO Union/Ward Controller Class.
	* @pupose		Manage Union/Ward information
	*		
	* @filesource	\app\controllers\po_unions_or_wards_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.po_unions_or_wards_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Po_unions_or_wards extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_unions_or_ward','Po_division','Po_thana','Po_district'),'',TRUE);		
	}
 	function ajax_for_get_thana_by_district()
    	{
        $this->output->enable_profiler(FALSE);
		$callback_message = array();
		$district_id  = $this->input->post('district_id');
		if(empty($district_id))
        	{
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select District';
        	}
		else
        	{
			$callback_message['status'] = 'success';
			$thana_info = $this->Po_thana->get_thanas_by_district($district_id);
            //print_r($district_info);die;
			if(!empty($thana_info)) {
				foreach( $thana_info as $row) {
                    $callback_message['thana']['id'][] = $row->id;
                    $callback_message['thana']['name'][] = $row->name;
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
    /*
     * @Modified By: Matin
     * @Modification Date : 25-03-2011
     */
	function index()
	{
		$data['title']='Unions/Wards';
		
		/* Conditions for filtering */	
		$cond= "";
		$session_data = $this->session->userdata('po_unions_or_wards.index');
		if($_POST){
			$cond['name'] = $this->input->post('txt_name');
            $cond['cbo_division'] = $this->input->post('cbo_division');
            $cond['cbo_district'] = $this->input->post('cbo_district');
            $cond['cbo_thana'] = $this->input->post('cbo_thana');            
			$sessionArray = array( 'po_unions_or_wards.index'=>array('name'=>$cond['name'],'cbo_division'=>$cond['cbo_division'],'cbo_district'=>$cond['cbo_district'],'cbo_thana'=>$cond['cbo_thana']));
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_division'] = $session_data['cbo_division'];
            $cond['cbo_district'] = $session_data['cbo_district'];
            $cond['cbo_thana'] = $session_data['cbo_thana'];
            
		} else {
			$this->session->unset_userdata('po_unions_or_wards.index');
		} 	
		/* End of filtering conditions */
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_unions_or_ward->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_unions_or_wards/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_unions_or_wards']=$this->Po_unions_or_ward->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3), $cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['divisions'] = $this->Po_division->get_division_list();		
		//$data['thanas'] = $this->Po_thana->get_thana_list();
        if(isset ($cond['cbo_division']))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($cond['cbo_division']);
        }
        if(isset ($cond['cbo_district']))
        {
            $data['thanas'] = $this->Po_thana->get_thanas_by_district($cond['cbo_district']);
        }
        
		$this->layout->view('/po_unions_or_wards/index',$data);
	}
	
	function add()
	{
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{			
			$data=$this->_get_posted_data();
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				//The first param->Table Name, 2nd Param: id field
				$data['id'] = $this->Po_unions_or_ward->get_new_id('po_unions_or_wards', 'id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_unions_or_ward->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_unions_or_wards/add/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();        
		$data['title']='Add Union/Ward';
        $data['headline']='Add Union/Ward';
		$this->layout->view('/po_unions_or_wards/save',$data);
	}	
	
	function edit($union_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($union_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Unon/Ward ID is not provided');
			redirect('/po_unions_or_wards/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$union_id=$_POST['union_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('union_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_unions_or_ward->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_unions_or_wards/index/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$data['row']=$this->Po_unions_or_ward->read($union_id);
        if(isset ($data['row']->division_id))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($data['row']->division_id);
        }
        if(isset ($data['row']->district_id))
        {
            $data['thanas'] = $this->Po_thana->get_thanas_by_district($data['row']->district_id);
        }
		$data['title']='Edit Union/Ward';
        $data['headline']='Edit Union/Ward';
		$this->layout->view('/po_unions_or_wards/save',$data);
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($union_id=null)
	{
        if(empty($union_id))
		{
			$this->session->set_flashdata('warning','Union/Ward ID is not provided');
			redirect('/po_unions_or_wards/index/');
		}
		//Check wether the child data exists
        $has_po_village_or_blocks_entry = $this->Po_unions_or_ward->is_dependency_found('po_village_or_blocks',  array('union_or_ward_id' => $union_id));
        if($has_po_village_or_blocks_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_unions_or_wards/index/');
        }
        else
        {
            if($this->Po_unions_or_ward->delete($union_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_unions_or_wards/index/');
            }
        }
	}

	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		$data['division_id']=$this->input->post('cbo_division');
		$data['district_id']=$this->input->post('cbo_district');
		$data['thana_id']=$this->input->post('cbo_thana');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_division','Division','trim|required|xss_clean');
		$this->form_validation->set_rules('cbo_district','District','trim|required|xss_clean');
		$this->form_validation->set_rules('cbo_thana','Thana','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean|callback_check_duplicate_union_in_same_thana');
	}
	function _load_combo_data()
	{
		$data['divisions'] = $this->Po_division->get_division_list();		
        $data['districts'] = $this->Po_district->get_district_by_division($this->input->post('cbo_division'));
		$data['thanas'] = $this->Po_thana->get_thanas_by_district($this->input->post('cbo_district'));
		return $data;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check the duplicate union under the same Thana
     * @Use: Useed in _prepare_validation() method
     * @Modification Date: 24-03-2011
     */
    function check_duplicate_union_in_same_thana()
    {
        $data = $this->_get_posted_data();
        $data['union_id']=$this->input->post('union_id');        
        $this->form_validation->set_message('check_duplicate_union_in_same_thana','The %s is already being used under the selected Thana.');

        return $this->Po_unions_or_ward->check_duplicate_union_under_same_thana($data);
    }
}
