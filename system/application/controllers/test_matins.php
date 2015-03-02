<?php

class Test_matins extends Controller {
	
	function Test_matins()
	{
		parent::Controller();
		//$this->load->helper(array('form', 'url'));
		$this->load->model(array('Test'));
		$this->load->helper(array('form','jquery'));
		//$this->load->library('test');
	}
	
	function index()
	{
		//$new_id = $this->Test->get_new_id('po_branches','id');
		//print_r($new_id);
		//$this->layout->view('/members/index',$data);
		$this->layout->view('test_matins/index');
	}

	function do_upload()
	{
		$config['upload_path'] = '/var/www/microfin/uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			
			$this->load->view('test_matins/index', $error);
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			$this->load->view('test_matins/upload_success', $data);
		}
	}	
	
	function ajax_get_district_list_auto()
	{
		
		$data=$this->Test->get_district_list_json_auto($this->input->post('q'));
		foreach($data as $row)
		{
			echo $row->id.','.$row->name.','.$row->village_name.','.$row->thana_name.','.$row->district_name."\n";
		}
		die;
		$this->output->enable_profiler(FALSE);
	}
}
?>
