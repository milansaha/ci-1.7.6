<?php
/** 
	* PO Zones Controller Class.
	* @pupose		Manage PO Zones information
	*		
	* @filesource	./system/application/controllers/po_zones.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.po_zones
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_zones extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Po_zone','',TRUE);		
	}

	function index()
	{
		$data['title']='Zones';
        $data['headline']='Zone\'s Informatin';
        $areas = array();
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_zone->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_zones/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_zones_info']=$this->Po_zone->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
        //Get the area list for each zone
        if(!empty ($data['po_zones_info']))
        {
            $i = 0;
            //Outer loop
            foreach($data['po_zones_info'] as $zone_info)
            {
                $areas = $this->Po_zone->get_area_code_name($zone_info->area_list);

                if(!empty ($areas))
                {
                    $area_code_name = '';
                    //Inner loop
                    foreach($areas as $area)
                    {
                        $area_code_name .= $area['area_code_name'] . ',';
                    }//End of inner loop
                    $data['po_zones_info'][$i]->area_list = rtrim($area_code_name,', ');
                }
                $i++;
            }//End of outer loop
        }//End of getting area list
		$this->layout->view('/po_zones/index',$data);
	}
	
	function add()
	{
		$is_validation_error = false;
        $selected_area = array();
		$this->_prepare_validation();
		if($_POST)
		{
			$data=$this->_get_posted_data();
            $selected_area = $this->input->post('cbo_area_list');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
                $data['area_list'] = implode(',', $selected_area);
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_zone->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_zones/add/', 'refresh');
				}
			}  else {
                $is_validation_error = true;
            }
		}
		$data = $this->_load_combo_data();
        if($is_validation_error and !empty ($selected_area))
        {
            $data['selected_area'] = $selected_area;
        }
		$data['title']='Add Zone';
        $data['headline']='Add Zone';
		$this->layout->view('/po_zones/save',$data);
	}	
	
	function edit($po_zone_id=null)
	{
        $is_validation_error = false;
        $selected_area = array();
        
		if(empty($po_zone_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Zone ID is not provided');
			redirect('/po_zones/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
            $data=$this->_get_posted_data();
			$data['id'] = $po_area_id = $this->input->post('txt_zone_id');
            $selected_area = $this->input->post('cbo_area_list');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data['area_list'] = implode(',', $selected_area);
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_zone->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_zones/index/', 'refresh');
				}
			}else{
                $is_validation_error = true;
            }
		}
		$data['title']='Edit Zone';
        $data['headline']='Edit Zone';
		//Load data from database
		$data['row']=$this->Po_zone->read($po_zone_id);
        
        if(isset ($data['row']->area_list) and !empty ($data['row']->area_list))
        {
            $data['selected_area'] = explode(',', $data['row']->area_list);
        }
        
        // Load data for combo box
        $areas = $this->Po_zone->get_areas_info($data['row']->area_list);
        //echo "$po_zone_id<pre>";print_r($areas);die;
        if(!empty ($areas))
        {
             foreach($areas as $area)
             {
                 $data['area_infos'][$area->area_id] = $area->area_code . ' - ' . $area->area_name;
             }
        }

        if($is_validation_error and !empty ($selected_area))
        {
            $data['selected_area'] = $selected_area;
        }
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('po_zones/save',$data);
	}
	
	function delete($po_zone_id=null)
	{
        if(empty($po_zone_id))
		{
			$this->session->set_flashdata('warning','Zone ID is not provided');
			redirect('/po_zones/index/');
		}
		if($this->Po_zone->delete($po_zone_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/po_zones/index/');
		}
	}
    function _load_combo_data()
	{
        $data['area_infos'] = array();
        $areas = $this->Po_zone->get_areas_info();
        if(!empty ($areas))
        {
             foreach($areas as $area)
             {
                 $data['area_infos'][$area->area_id] = $area->area_code . ' - ' . $area->area_name;
             }
        }
		return $data;
	}
	function _get_posted_data()
	{
		$data=array();
		$data['name']=$this->input->post('txt_name');
		$data['code']=$this->input->post('txt_code');
        $data['area_list'] = $this->input->post('cbo_area_list');
		return $data;
	}
	function _prepare_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]|unique[po_zones.name.id.txt_zone_id]');
		$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|max_length[100]');
        $this->form_validation->set_rules('cbo_area_list[]','Area','trim|xss_clean|required');
	}
}
