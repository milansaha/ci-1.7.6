<?php
/** 
	* PO Areas Controller Class.
	* @pupose		Manage PO Areas information
	*		
	* @filesource	./system/application/controllers/po_areas.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.controllers.po_areas
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 04-04-2011 $
*/ 
class Po_areas extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();		
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_branch','Po_area'),'',TRUE);
        $this->output->enable_profiler(TRUE);
	}

	function index()
	{
		$data['title']='Areas';
		$data['headline']='Areas';
        $branches = array();        
		$this->load->library('pagination');
		$total = $this->Po_area->row_count();
		$config['base_url'] = site_url('/po_areas/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		
		$this->pagination->initialize($config);	
        //Loading data by model function call
        $data['po_areas_info']=$this->Po_area->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3));
        $data['counter'] = (int)$this->uri->segment(3);
        //Get the branch list for each area
        if(!empty ($data['po_areas_info']))
        {
            $i = 0;
            //Outer loop
            foreach($data['po_areas_info'] as $area_info)
            {
                $branches = $this->Po_area->get_branch_code_name($area_info->branch_list);                
                if(!empty ($branches))
                {
                    $branch_code_name = '';
                    //Inner loo
                    foreach($branches as $branch)
                    {
                        $branch_code_name .= $branch['branch_code_name'] . ',';
                    }//End of inner loop
                    $data['po_areas_info'][$i]->branch_list = rtrim($branch_code_name,', ');
                }
                $i++;
            }//End of outer loop
        }//End of getting branch list
        $this->layout->view('/po_areas/index',$data);
		
	}
	
	function add()
	{
        $is_validation_error = false;
        $selected_branch = array();
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$data=$this->_get_posted_data();
            $selected_branch = $this->input->post('cbo_branch_list');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
                $data['branch_list'] = implode(',', $selected_branch);
				if($this->Po_area->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_areas/add/', 'refresh');
				}
			}  else {
                $is_validation_error = true;
            }
		}
		$data = $this->_load_combo_data();
        if($is_validation_error and !empty ($selected_branch))
        {
            $data['selected_branch'] = $selected_branch;
        }
		$data['title']='Add Area';
		$data['headline']='Add Area';
		$this->layout->view('/po_areas/save',$data);
	}	
	
	function edit($po_area_id=null)
	{	
		$is_validation_error = false;
        $selected_branch = array();
		if(empty($po_area_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Area ID is not provided');
			redirect('/po_areas/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
            $data=$this->_get_posted_data();
			$data['id'] = $po_area_id = $this->input->post('txt_area_id');
            $selected_branch = $this->input->post('cbo_branch_list');
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
                $data['branch_list'] = implode(',', $selected_branch);
				if($this->Po_area->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_areas/index/', 'refresh');
				}
			}else{
                $is_validation_error = true;
            }
		}
		//$data = $this->_load_combo_data();
		$data['row']=$this->Po_area->read($po_area_id);
        
        if(isset ($data['row']->branch_list) and !empty ($data['row']->branch_list))
        {
            $data['selected_branch'] = explode(',', $data['row']->branch_list);
        }
        // Load data for combo box
        $branches = $this->Po_area->get_branches_info($data['row']->branch_list);
        if(!empty ($branches))
        {
             foreach($branches as $branch)
             {
                 $data['branch_infos'][$branch->branch_id] = $branch->branch_code . ' - ' . $branch->branch_name;
             }
        }
        
        if($is_validation_error and !empty ($selected_branch))
        {
            $data['selected_branch'] = $selected_branch;
        }
		$data['title']='Edit Area';
		$data['headline']='Edit Area';
        
		$this->layout->view('po_areas/save',$data);
	}
	
	function delete($po_area_id=null)
	{
        if(empty($po_area_id))
		{
			$this->session->set_flashdata('warning','Area ID is not provided');
			redirect('/po_areas/index/');
		}
        
		if($this->Po_area->delete($po_area_id))
		{
			$this->session->set_flashdata('message',DELETE_MESSAGE);
			redirect('/po_areas/index/');
		}
	}
    function _load_combo_data()
	{
        $data['branch_infos'] = array();
        $branches = $this->Po_area->get_branches_info();
        if(!empty ($branches))
        {
             foreach($branches as $branch)
             {
                 $data['branch_infos'][$branch->branch_id] = $branch->branch_code . ' - ' . $branch->branch_name;
             }
        }
		return $data;
	}
	function _get_posted_data()
	{
		$data=array();
		$data['name']=$this->input->post('txt_name');
		$data['code']=$this->input->post('txt_code');
        $data['branch_list'] = $this->input->post('cbo_branch_list');
		return $data;
	}
	function _prepare_validation()
	{
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('txt_name','Name','trim|xss_clean|required|max_length[100]|unique[po_areas.name.id.txt_area_id]');
		$this->form_validation->set_rules('txt_code','Code','trim|xss_clean|required|max_length[100]');
        $this->form_validation->set_rules('cbo_branch_list[]','Branch','trim|xss_clean|required');
	}
}
