<?php
/** 
	* PO Areas Model Class.
	* @pupose		Manage PO Areas information
	*		
	* @filesource	./system/application/models/po_area.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_area
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_area extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc"); 
        $query = $this->db->get('po_areas', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_areas');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('po_areas', 'id');
        return $this->db->insert('po_areas', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_areas', $data, array('id'=> $data['id']));
    }
	
	function read($po_area_id)
    {
        $query=$this->db->getwhere('po_areas', array('id' => $po_area_id));
		return $query->row();
    }
	
	function delete($po_area_id)
	{
		return $this->db->delete('po_areas', array('id'=> $po_area_id));
	}
	function get_area_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_areas');  
		return $query->result();
    }
    
    function _get_latest_area()
    {
        $result = $this->db->query('SELECT branch_list FROM po_areas')->result_array();
        $alloted_branch = '';
        if(!empty($result))
        {
            foreach($result as $result)
            {
                $alloted_branch[] = $result['branch_list'];
            }
            $alloted_branch = implode(',', $alloted_branch);
        }        
        return $alloted_branch;
    }
    //This function is for listing of branches
	function get_branches_info($branch_list_for_particular_area=array ())
	{
        $alloted_branch = $this->_get_latest_area();
        
        $query = "SELECT `id` AS branch_id, `name` AS branch_name, `code` AS branch_code FROM (`po_branches`) ";
        if(isset ($alloted_branch) and !empty ($alloted_branch))
        {
            $query .= "WHERE `id` NOT IN ($alloted_branch) ";
        }
        if(!empty ($branch_list_for_particular_area))
        {
            $query =  "(" . $query . ")";
            $query .=   "UNION
                        (SELECT `id` AS branch_id, `name` AS branch_name, `code` AS branch_code
                        FROM (`po_branches`)
                        WHERE `id` IN ($branch_list_for_particular_area)
                        )";
        }
        //$query .= "ORDER BY code";
        $result = $this->db->query($query);
		return $result->result();
	}
    /*
     * @Author: Matin
     * @Modification Date: 06-04-2011
     */
    function get_branch_code_name($branch_list)
    {
        $result = $this->db->query("SELECT CONCAT(code, '-', name) AS branch_code_name FROM po_branches WHERE id IN ($branch_list) ORDER BY branch_code_name");
        return $result->result_array();
    }

}
