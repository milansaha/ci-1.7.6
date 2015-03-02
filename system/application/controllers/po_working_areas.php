<?php
/** 
	* PO Working Areas Controller Class. 
	* @pupose		Manage Working Areas information
	*		
	* @filesource	\app\controllers\po_working_areas_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.po_working_areas_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Po_working_areas extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_division','Po_district','Po_thana','Po_unions_or_ward','Po_working_area','Po_village_or_block'),'',TRUE);
	}

	function index()
	{
		$data['title']='Working Areas';
		
		$cond= "";
		$session_data = $this->session->userdata('po_working_area.index');
		if(isset($_POST['txt_name']) ){
			
			$cond['name'] = $_POST['txt_name'];
				
			$sessionArray = array( 'po_working_area.index'=>array(
												'name'=>$cond['name']																																											
												));
			
			$this->session->unset_userdata('po_working_area.index');
			$this->session->set_userdata($sessionArray);
		}elseif(is_array($session_data)) {
			
			$cond['name'] = $session_data['name'];			
						
		} else {
			$this->session->unset_userdata('po_working_area.index');
		} 
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_working_area->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_working_areas/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_working_areas']=$this->Po_working_area->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
		$this->layout->view('/po_working_areas/index',$data);
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
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_working_area->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_working_areas/add/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Working Area';
        $data['headline']='Add Working Area';
		$this->layout->view('/po_working_areas/save',$data);
	}	
	
	function edit($working_area_id=null)
	{			
		$is_validate_error = false;
		if(empty($working_area_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Working Area ID is not provided');
			redirect('/po_working_areas/index/', 'refresh');
		}
        //$data['row']=$this->Po_working_area->read($working_area_id);
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$working_area_id=$_POST['working_area_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('working_area_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_working_area->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_working_areas/index/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
		//Load data from database
		$data['divisions'] = $this->Po_division->get_division_list();
		$data['row']=$this->Po_working_area->read($working_area_id);
        if(empty ($data['row']))
        {
            $this->session->set_flashdata('warning','Sorry! Valid ID required');
			redirect('/po_working_areas/index/', 'refresh');
        }
        //echo "$working_area_id<pre>";print_r($data['row']);die;
        if(isset ($data['row']->division_id) and !empty ($data['row']->division_id))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($data['row']->division_id);
        }
        if(isset ($data['row']->district_id) and !empty ($data['row']->district_id))
        {
            $data['thanas'] = $this->Po_thana->get_thanas_by_district($data['row']->district_id);
        }
        if(isset ($data['row']->thana_id) and !empty ($data['row']->thana_id))
        {
            $data['unions'] = $this->Po_unions_or_ward->get_union_by_thana($data['row']->thana_id);
        }
        if(isset ($data['row']->union_or_ward_id) and !empty ($data['row']->union_or_ward_id))
        {
            $data['villages'] = $this->Po_village_or_block->get_village_by_union($data['row']->union_or_ward_id);
        }
        if($is_validate_error and !empty ($working_area_id)){
            $data['row']->id = $working_area_id;
			$data['row']->division_id = $this->input->post('cbo_division');
            $data['row']->district_id = $this->input->post('cbo_district');
            $data['row']->thana_id = $this->input->post('cbo_thana');
            $data['row']->union_or_ward_id = $this->input->post('cbo_union');
            $data['row']->village_or_block_id = $this->input->post('cbo_village');
		}
		$data['title']='Edit Working Area';
        $data['headline']='Edit Working Area';
		$this->layout->view('/po_working_areas/save',$data);
	}

     /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($working_area_id=null)
	{
        if(empty($working_area_id))
		{
			$this->session->set_flashdata('warning','Working Area ID is not provided');
			redirect('/po_working_areas/index/');
		}
		//Check wether the child data exists
        $has_samities_entry = $this->Po_working_area->is_dependency_found('samities',  array('working_area_id' => $working_area_id));
        if($has_samities_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_working_areas/index/');
        }
        else
        {
            if($this->Po_working_area->delete($working_area_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_working_areas/index/');
            }
        }
	}

	function _get_posted_data()
	{
		$data=array();		
		$data['name']=$this->input->post('txt_name');
		$data['village_or_block_id']=$this->input->post('cbo_village');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('cbo_division','Division','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_district','District','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_thana','Thana','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_union','Union/Ward','trim|xss_clean|required');
		$this->form_validation->set_rules('cbo_village','Village/Block','trim|xss_clean|required');
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean');
	}
	function _load_combo_data()
	{
        $data['divisions'] = $this->Po_division->get_division_list();
        $data['districts'] = $this->Po_district->get_district_by_division($this->input->post('cbo_division'));
		$data['thanas'] = $this->Po_thana->get_thanas_by_district($this->input->post('cbo_district'));
		$data['unions'] = $this->Po_unions_or_ward->get_union_by_thana($this->input->post('cbo_thana'));
		$data['villages'] = $this->Po_village_or_block->get_village_by_union($this->input->post('cbo_union'));
		return $data;
	}
	function ajax_get_working_area_list_json_auto()
	{
		
		$data=$this->Po_working_area->get_working_area_list_json_auto($this->input->post('q'));
		$data2=array();
		foreach($data as $row)
		{
			$data2[]=array('id'=>$row->id,'name'=>$row->village_name,'village_name'=>$row->village_name);
		}
		echo json_encode($data2);		
	}	
	
	function ajax_get_working_area_list_auto()
	{
		
		$data=$this->Po_working_area->get_working_area_list_json_auto($this->input->post('q'));
		foreach($data as $row)
		{
			echo $row->id.','.$row->name.','.$row->village_name.','.$row->thana_name.','.$row->district_name."\n";
		}	
		$this->output->enable_profiler(FALSE);
	}
    /*
     * @Added By: Matin
     * @Modification Date : 26-03-2011
     */
    function ajax_for_get_village_by_union()
    	{
        $this->output->enable_profiler(FALSE);
		$callback_message = array();
		$union_id  = $this->input->post('union_id');
		if(empty($union_id))
        	{
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select Union';
        	}
		else
        	{
			$callback_message['status'] = 'success';
			$village_info = $this->Po_village_or_block->get_village_by_union($union_id);
            //print_r($callback_message);
			if(!empty($village_info)) {
				foreach( $village_info as $row) {
                    $callback_message['village']['id'][] = $row->id;
                    $callback_message['village']['name'][] = $row->name;
	  			}
            }
			else {
				$callback_message['status'] = 'failure';
            	$callback_message['message']= 'No data found';
            	//die;
				}
		} //print_r($callback_message);
		if( count($callback_message) != 0 )
	    {
	        echo json_encode($callback_message);
	    }
    }
}
