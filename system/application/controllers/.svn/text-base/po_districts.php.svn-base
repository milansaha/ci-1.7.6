<?php
/** 
	* PO District Controller Class.
	* @pupose		Manage district information
	*		
	* @filesource	\app\controllers\po_districts_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.po_districts_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Po_districts extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_district','Po_division'),'',TRUE);		
	}

	function index()
	{
		$cond= "";
		$session_data = $this->session->userdata('po_districts.index');
		if(isset($_POST['txt_name']) && isset($_POST['cbo_division'])){
			$cond['name'] = $_POST['txt_name'];
			$cond['cbo_division'] = $_POST['cbo_division'];
			$sessionArray = array( 'po_districts.index'=>array('name'=>$cond['name'],'cbo_division'=>$cond['cbo_division']));			
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_division'] = $session_data['cbo_division'];
		} else {
			$this->session->unset_userdata('po_districts.index');
		} 		
		
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_district->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_districts/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	//Pagination		
		$current_offset=(int)$this->uri->segment(3);		
		$data = $this->_load_combo_data();		
		$data['po_districts']=$this->Po_district->get_list(ROW_PER_PAGE, $current_offset,$cond);			
		$data['title']='Districts';	
		$data['counter'] = $current_offset;
		$this->layout->view('/po_districts/index',$data);
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
				$data['id'] = $this->Po_district->get_new_id('po_districts', 'id');
                if($this->Po_district->add($data))
                {
                    $this->session->set_flashdata('message',ADD_MESSAGE);
                }
				redirect('/po_districts/add/');
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add District';
        $data['headline']='Add District';
		$this->layout->view('/po_districts/save',$data);
	}	
	
	function edit($district_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($district_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','District ID is not provided');
			redirect('/po_districts/index/', 'refresh');
		}
		$this->_prepare_validation();		
		if($_POST)
		{
			$district_id=$_POST['district_id'];
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('district_id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_district->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_districts/index/');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		$data['row']=$this->Po_district->read($district_id);
		$data['title']='Edit District';
        $data['headline']='Edit District';
		$this->layout->view('/po_districts/save',$data);
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 15-03-2011
     */
    function delete($district_id=null)
	{
        if(empty($district_id))
		{
			$this->session->set_flashdata('warning','District ID is not provided');
			redirect('/po_districts/index/');
		}
		//Check wether the child data exists
        $has_thana_entry = $this->Po_district->is_dependency_found('po_thanas',  array('district_id' => $district_id));
        if($has_thana_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_districts/index/');
        }
        else
        {
            if($this->Po_district->delete($district_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_districts/index/');
            }
        }
	}


	function _get_posted_data()
	{
		$data=array();				
		$data['name']=$this->input->post('txt_name');
		$data['division_id']=$this->input->post('cbo_division');		
		return $data;
	}
	function _prepare_validation()
	{
		//Loading Validation Library to Perform Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//Setting Validation Rule				
		$this->form_validation->set_rules('cbo_division','Division','trim|required|is_natural_no_zero');	
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean|unique[po_districts.name.id.district_id]');
	}
	function _load_combo_data()
	{
		// Loading partner organizations division list which will be used in combo box
		$data['divisions'] = $this->Po_division->get_division_list();		
		return $data;
	}
	
	function ajax_get_district_list()
	{
		
		$data=$this->Po_district->get_all_district_list($this->input->post('q'));
		foreach($data as $row)
		{
			echo $row->id.','.$row->name."\n";
		}
		die;
		$this->output->enable_profiler(FALSE);
	}
	
	function ajax_get_district_list_json()
	{
		
		$data=$this->Po_district->get_all_district_list($this->input->post('q'));
		$data2=array();
		foreach($data as $row)
		{
			$data2[]=array('id'=>$row->id,'name'=>$row->name);
		}
		echo json_encode($data2);
		die;
	}
	
	function ajax_get_district_list_2()
	{
		
		$data=array('Saroj','Ripon');
		foreach($data as $row)
		{
			echo $row."\n";
		}	
	}
}
