<?php
class Config_general extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function add($data)
    {
		return $this->db->insert('config_general', $data);
    }
    function edit($data)
    {
        return $this->db->update('config_general', $data);
    }
	
	function read()
    {
        $query=$this->db->getwhere('config_general');
	    return $query->row();
    }
    function read_array()
    {
        $query=$this->db->getwhere('config_general');
	    return $query->row_array();
    }
}
