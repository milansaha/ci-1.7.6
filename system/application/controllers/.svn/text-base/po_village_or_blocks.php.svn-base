<?php
/** 
	* PO Village/Block Controller Class.
	* @pupose		Manage Village/Block information
	*		
	* @filesource	\app\controllers\po_village_or_blocks_controller.php	
	* @package		microfin 
	* @subpackage	microfin.controller.po_village_or_blocks_controller
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
	
class Po_village_or_blocks extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Po_village_or_block','Po_division','Po_district','Po_thana','Po_unions_or_ward'),'',TRUE);
	}
	function ajax_for_get_union_by_thana()
    	{
        $this->output->enable_profiler(FALSE);
		$callback_message = array();
		$thana_id  = $this->input->post('thana_id');
		if(empty($thana_id))
        	{
            $callback_message['status'] = 'failure';
            $callback_message['message']= 'Select Thana';
        	}
		else
        	{
			$callback_message['status'] = 'success';
			$union_info = $this->Po_unions_or_ward->get_union_by_thana($thana_id);
            //print_r($district_info);die;
			if(!empty($union_info)) {
				foreach( $union_info as $row) {
                    $callback_message['union']['id'][] = $row->id;
                    $callback_message['union']['name'][] = $row->name;
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
    /*
     * @Modified By: Matin
     * @Modification Date : 25-03-2011
     */
	function index()
	{
		$data = $this->_load_combo_data();		
        /* Conditions for filtering */
		$cond= "";
		$session_data = $this->session->userdata('po_village_or_block.index');
		if($_POST){
			$cond['name'] = $this->input->post('txt_name');
            $cond['cbo_division'] = $this->input->post('cbo_division');
            $cond['cbo_district'] = $this->input->post('cbo_district');
            $cond['cbo_thana'] = $this->input->post('cbo_thana');
            $cond['cbo_union'] = $this->input->post('cbo_union');
            
			$sessionArray = array( 'po_village_or_block.index'=>array(
                                        'name'=>$cond['name'],
                                        'cbo_division'=>$cond['cbo_division'],
                                        'cbo_district'=>$cond['cbo_district'],
                                        'cbo_thana'=>$cond['cbo_thana'],
                                        'cbo_union'=>$cond['cbo_union']));
            
            $this->session->unset_userdata('po_village_or_block.index');
			$this->session->set_userdata($sessionArray);
		} elseif(is_array($session_data)) {
			$cond['name'] = $session_data['name'];
			$cond['cbo_division'] = $session_data['cbo_division'];
            $cond['cbo_district'] = $session_data['cbo_district'];
            $cond['cbo_thana'] = $session_data['cbo_thana'];
            $cond['cbo_union'] = $session_data['cbo_union'];

		} else {
			$this->session->unset_userdata('po_village_or_block.index');
		}
		/* End of filtering conditions */
        
        $data['divisions'] = $this->Po_division->get_division_list();
        if(isset ($cond['cbo_division']))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($cond['cbo_division']);
        }
        if(isset ($cond['cbo_district']))
        {
            $data['thanas'] = $this->Po_thana->get_thanas_by_district($cond['cbo_district']);
        }
        
		// load pagination class
		$this->load->library('pagination');
		$total = $this->Po_village_or_block->row_count($cond);
		
		//Initializing Pagination
		$config['base_url'] = site_url('/po_village_or_blocks/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	
		
		//Loading data by model function call
		$data['po_village_or_blocks']=$this->Po_village_or_block->get_list(ROW_PER_PAGE, (int)$this->uri->segment(3),$cond);	
		$data['counter'] = (int)$this->uri->segment(3);
        $data['title']='Villages/Blocks';        
		$this->layout->view('/po_village_or_blocks/index',$data);
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
				$data['id'] = $this->Po_village_or_block->get_new_id('po_village_or_blocks', 'id');
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Po_village_or_block->add($data))
				{
					$this->session->set_flashdata('message',ADD_MESSAGE);
					redirect('/po_village_or_blocks/add/', 'refresh');
				}
			}
		}
		//Load data from database
		$data = $this->_load_combo_data();
		//If data is not posted or validation fails, the add view is displayed
		$data['title']='Add Village/Block';
        $data['headline'] = 'Add Village/Block';
		$this->layout->view('/po_village_or_blocks/save',$data);
	}	
	
	function edit($village_id=null)
	{	
		//If ID is not provided, redirecting to index page
		if(empty($village_id) && !$_POST)
		{
			$this->session->set_flashdata('warning','Village/Block ID is not provided');
			redirect('/po_village_or_blocks/index/', 'refresh');
		}
		$this->_prepare_validation();
		//If the form is posted, perform the validation. is_posted is a hidden input used to detect if the form is posted
		if($_POST)
		{
			$village_id=$_POST['txt_village_id'];
			//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{				
				$data=$this->_get_posted_data();
				$data['id']=$this->input->post('txt_village_id');
				if($this->Po_village_or_block->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/po_village_or_blocks/index/', 'refresh');
				}
			}
		}
		
		$data = $this->_load_combo_data();
		$data['row']=$this->Po_village_or_block->read($village_id);       
        if(isset ($data['row']->division_id))
        {
            $data['districts'] = $this->Po_district->get_district_by_division($data['row']->division_id);
        }
        if(isset ($data['row']->district_id))
        {
            $data['thanas'] = $this->Po_thana->get_thanas_by_district($data['row']->district_id);
        }
        if(isset ($data['row']->thana_id))
        {
            $data['unions'] = $this->Po_unions_or_ward->get_union_by_thana($data['row']->thana_id);
        }		
		$data['title']='Edit Village/Block';
        $data['headline'] = 'Edit Village/Block';
		$this->layout->view('/po_village_or_blocks/save',$data);
	}
	
    /*
     * @Modified By: Matin
     * @Modification Date : 16-03-2011
     */
    function delete($village_id=null)
	{
        if(empty($village_id))
		{
			$this->session->set_flashdata('warning','Village/Block ID is not provided');
			redirect('/po_village_or_blocks/index/');
		}
		//Check wether the child data exists
        $has_po_village_or_blocks_entry = $this->Po_village_or_block->is_dependency_found('po_working_areas',  array('village_or_block_id' => $village_id));
        if($has_po_village_or_blocks_entry)
        {
            $this->session->set_flashdata('warning', DEPENDENT_DATA_FOUND);
			redirect('/po_village_or_blocks/index/');
        }
        else
        {
            if($this->Po_village_or_block->delete($village_id))
            {
                $this->session->set_flashdata('message',DELETE_MESSAGE);
                redirect('/po_village_or_blocks/index/');
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
		$data['union_or_ward_id']=$this->input->post('cbo_union');		
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
		$this->form_validation->set_rules('cbo_union','Union/Ward','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_name','Name','trim|required|max_length[100]|xss_clean|callback_check_duplicate_village_in_same_union');
	}
	function _load_combo_data()
	{
        $data['divisions'] = $this->Po_division->get_division_list();
        $data['districts'] = $this->Po_district->get_district_by_division($this->input->post('cbo_division'));
		$data['thanas'] = $this->Po_thana->get_thanas_by_district($this->input->post('cbo_district'));		
		$data['unions'] = $this->Po_unions_or_ward->get_union_by_thana($this->input->post('cbo_thana'));
		return $data;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check the duplicate village/block under the same Union/Ward
     * @Use: Useed in _prepare_validation() method
     * @Modification Date: 25-03-2011
     */
    function check_duplicate_village_in_same_union()
    {
        $data = $this->_get_posted_data();
        $data['village_id']=$this->input->post('txt_village_id');
        $this->form_validation->set_message('check_duplicate_village_in_same_union','The %s is already being used under the selected Union/Ward.');

        return $this->Po_village_or_block->check_duplicate_village_under_same_union($data);
    }
}
