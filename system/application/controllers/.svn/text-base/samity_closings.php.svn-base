<?php

class Samity_closings extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		//Loading Helper Class
		$this->load->helper(array('form','date'));
		//Loading the model. The first param-> Model Name, 2nd Param: Custom Name, 3rd Param: AutoLoad Database. If 3rd parameter is not used, you have to load the database manually
		$this->load->model(array('Report','Samity'),'',TRUE);
	}

	function index()
	{
        $branch_id = $this->get_branch_id();
        $data['samity_days'] = $this->Report->get_samity_days();
		$this->load->library('pagination');
		$total = $this->Samity->count_closed_samity($branch_id);
		$config['base_url'] = site_url('/samity_closings/index/');
		$config['total_rows'] = $total;
		$config['per_page'] = ROW_PER_PAGE;
		$this->pagination->initialize($config);	//Pagination
		$current_offset=(int)$this->uri->segment(3);		
		$data['closed_samities']=$this->Samity->get_closed_samity_list(ROW_PER_PAGE, $current_offset,$branch_id);
		$data['title']='Samity Closing';
        $data['headline']='Closed Samities';
		$data['counter'] = $current_offset;
		$this->layout->view('/samity_closings/index',$data);
	}

	function close()
	{
        $is_validate_error = false;
        $this->_prepare_validation();
		if($_POST)
		{	//Perform the Validation
			if ($this->form_validation->run() === TRUE)
			{
				$data['id']=$this->input->post('cbo_samity');
                $data['closing_date']=$this->input->post('txt_closing_date');
				$user=$this->session->userdata('system.user');
				$data['updated_by']=$user['id'];				
				$data['updated_date']=date("Y-m-d");
                $data['status'] = 0;
				//Validation is OK. So, add this data and redirect to the index page
				if($this->Samity->edit($data))
				{
					$this->session->set_flashdata('message',EDIT_MESSAGE);
					redirect('/samity_closings/index/', 'refresh');
				}
			}else {
				$is_validate_error = TRUE;
			}
		}
        
        $data = $this->_load_combo_data();
		$data['title']='Close Samity';
        $data['headline']='Close Samity';
		$this->layout->view('/samity_closings/save',$data);
	}
    
	function _get_posted_data()
	{
		$data=array();
		$data['id']=$this->input->post('cbo_samity');
        $data['closing_date']=$this->input->post('txt_closing_date');
		return $data;
	}
	function _prepare_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('cbo_samity','Samity Name','trim|required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('txt_closing_date','Closing Date','trim|required|max_length[10]|xss_clean|is_date|callback_check_samity_opening_date_is_greater_than_closing_date');
	}
	function _load_combo_data()
	{
		$branch_id = $this->get_branch_id();
		$data['samities'] = $this->Samity->get_samity_list($branch_id);
		return $data;
	}
    /*
     * @Added By: Matin
     * @Purpose : Check wether the samity closing date is less than the opening date.
     * @Use: Useed in _prepare_validation() method
     * @Modification Date: 29-03-2011
     */
    function check_samity_opening_date_is_greater_than_closing_date()
    { 
        if($_POST)
        {
            $data = $this->_get_posted_data();
            $samity_id = $data['id'];

            $closing_date = $data['closing_date'];
            if(isset ($closing_date) and !empty($closing_date) and isset ($samity_id) and !empty ($samity_id))
            {
                $opening_date = $op_date = $this->Samity->check_samity_opening_date_is_greater_than_closing_date($samity_id);
                $closing_date  = explode('-',$closing_date);
                $opening_date  = explode('-',$opening_date);
                if(mysql_to_unix("{$opening_date[0]}{$opening_date[1]}{$opening_date[2]}") > mysql_to_unix("{$closing_date[0]}{$closing_date[1]}{$closing_date[2]}"))
                {
                    $this->form_validation->set_message('check_samity_opening_date_is_greater_than_closing_date', "Closing Date can't be less than less than openening date ($op_date).");
                    return FALSE;
                }
            }
            return TRUE;
        }
    }
}
