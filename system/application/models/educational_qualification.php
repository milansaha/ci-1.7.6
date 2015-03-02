<?php
 
class Educational_qualification extends My_Model
{
    function __construct()
    {
        // Call the Model constructor
        //parent::Member_educational_qualification();
		parent::__construct();
    }
	
	function get_qualification_list()
    {
        $qualifications = $this->db->query("SELECT id,name FROM educational_qualifications ORDER BY name ASC");
		return $qualifications->result();  
    }
	// count the rows 
	function row_count()
	{
		return $this->db->count_all_results('educational_qualifications');
	}
	// get the list of all rows in ascceding order of name
	function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc");
        $query = $this->db->get('educational_qualifications', $offset, $limit);
        return $query->result();
    }
	// read the record on given id
	function read($id)
    {
        $query = $this->db->getwhere('educational_qualifications', array('id' => $id));
		return $query->row();
    }
	// process edit operation getting on given id
	function edit($data)
    {
		return $this->db->update('educational_qualifications', $data, array('id'=> $data['id']));
    }
	// insert data 
	function add($data)
    {
		$data['id'] = $this->get_new_id('educational_qualifications', 'id');
		return $this->db->insert('educational_qualifications', $data);
    }
	// delete particular data
	function delete($id)
	{
		return $this->db->delete('educational_qualifications', array('id'=> $id));
	}
}
