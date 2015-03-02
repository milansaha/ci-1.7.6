<?php
/** 
	* PO Regions Controller Class.
	* @pupose		Manage PO Regions information
	*		
	* @filesource	./system/application/controllers/po_regions.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.po_regions
	* @version      $Revision: 1 $
	* @author       $Author: S. Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_regions extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model('Po_region','',TRUE);
        $this->output->enable_profiler(TRUE);
	}

	function index()
	{
		$data['title']='Regions';
        $data['headline'] = 'Region Information';
        $zones = array();
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_region->row_count();
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_regions/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
		$data['po_regions_info']=$this->Po_region->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));	
		$data['counter'] = (int)$this->uri->segment(3);
        //Get the zone list for each region
        if(!empty ($data['po_regions_info']))
        {
            $i = 0;
            //Outer loop
            foreach($data['po_regions_info'] as $region_info)
            {
                $zones = $this->Po_region->get_zone_code_name($region_info->zone_list);

                if(!empty ($zones))
                {
                    $zone_code_name = '';
                    //Inner loop
                    foreach($zones as $zone)
                    {
                        $zone_code_name .= $zone['zone_code_name'] . ',';
                    }//End of inner loop
                    $data['po_regions_info'][$i]->zone_list = rtrim($zone_code_name,', ');
                }
                $i++;
            }//End of outer loop
        }//End of getting zone list

		$this->layout->view('/po_regions/index',$data);
	}
	
	function add()
	{
        $is_validation_error = false;
        $selected_zone = array();
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
            $selected_zone = $this->input->post('cbo_zone_list');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				$data['zone_list'] = implode(',', $selected_zone);
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_region->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_regions/add/', 'refresh');
				}
			}  else {
                $is_validation_error = true;
            }
		}
        $data = $this->_load_combo_data();
        if($is_validation_error and !empty ($selected_zone))
        {
            $data['selected_zone'] = $selected_zone;
        }
		//If data is not posted or validation fails, the add view is displayed		
		$data['title']='Add Region';
		$data['headline']='Add Region';
		$this->layout->view('/po_regions/save',$data);
	}	
	
	function edit($po_region_id=null)
	{
        $is_validation_error = false;
        $selected_zone = array();
		$data['title']='Edit Region';
		//If ID is not provided, redirecting to index page
		if(empty($po_region_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Region ID is not provided');
			redirect('/po_regions/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
            $data['id'] = $po_area_id = $this->input->post('txt_region_id');
            $selected_zone = $this->input->post('cbo_zone_list');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data['zone_list'] = implode(',', $selected_zone);
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_region->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_regions/index/', 'refresh');
				}
			}else{
                $is_validation_error = true;
            }
		}
		//Load data from database
		$data['row']=$this->Po_region->read($po_region_id);

        if(isset ($data['row']->zone_list) and !empty ($data['row']->zone_list))
        {
            $data['selected_zone'] = explode(',', $data['row']->zone_list);
        }

        // Load data for combo box
        $zones = $this->Po_region->get_zone_info($data['row']->zone_list);
        //echo "$po_zone_id<pre>";print_r($areas);die;
        if(!empty ($zones))
        {
             foreach($zones as $zone)
             {
                 $data['zone_infos'][$zone->zone_id] = $zone->zone_code . ' - ' . $zone->zone_name;
             }
        }

        if($is_validation_error and !empty ($selected_zone))
        {
            $data['selected_zone'] = $selected_zone;
        }
		$data['title']='Edit Region';
		$data['headline']='Edit Region';
		//If data is not posted or validation fails, the add view is displayed
		$this->layout->view('po_regions/save',$data);
	}
	
	function delete($po_region_id=null)
	{
        if(empty($po_region_id))
		{
			$this->session->set_flashdata('warning','Region ID is not provided');
			redirect('/po_regions/index/');
		}
		if($this->Po_region->delete($po_region_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/po_regions/index/');
		}
	}
    function _load_combo_data()
	{
        $data['zone_infos'] = array();
        $zones = $this->Po_region->get_zone_info();
        if(!empty ($zones))
        {
             foreach($zones as $zone)
             {
                 $data['zone_infos'][$zone->zone_id] = $zone->zone_code . ' - ' . $zone->zone_name;
             }
        }
		return $data;
	}
	function _get_posted_data()
	{
		$data=array();
		$data['name']=$this->input->post('txt_name');
		$data['code']=$this->input->post('txt_code');
        $data['zone_list'] = $this->input->post('cbo_zone_list');
		return $data;
	}
	function _prepare_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]|unique[po_regions.name.id.txt_region_id]');
		$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|max_length[100]');
        $this->form_validation->set_rules('cbo_zone_list[]','Zone','trim|xss_clean|required');
	}
}
