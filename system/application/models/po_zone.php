<?php
/** 
	* PO Zones Model Class.
	* @pupose		Manage PO Zones information
	*		
	* @filesource	./system/application/models/po_zone.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_zone
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_zone extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc");
        $query = $this->db->get('po_zones', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_zones');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('po_zones', 'id');
        return $this->db->insert('po_zones', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_zones', $data, array('id'=> $data['id']));
    }
	
	function read($po_zone_id)
    {
        $query=$this->db->getwhere('po_zones', array('id' => $po_zone_id));
		return $query->row();
    }
	
	function delete($po_zone_id)
	{
		return $this->db->delete('po_zones', array('id'=> $po_zone_id));
	}
	function get_zone_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_zones');  
		return $query->result();
    }
    /*
     * @Author: Matin
     * @lastModification: 05-04-2011
     */
    function _get_used_area()
    {
        $result = $this->db->query('SELECT area_list FROM po_zones')->result_array();
        $alloted_area = '';
        if(!empty($result))
        {
            foreach($result as $result)
            {
                $alloted_area[] = $result['area_list'];
            }
            $alloted_area = implode(',', $alloted_area);
        }
        return $alloted_area;
    }
    /*
     * @Author: Matin
     * @lastModification: 05-04-2011
     */
	function get_areas_info($area_list_for_particular_zone=array ())
	{
        $alloted_area = $this->_get_used_area();

        $query = "SELECT `id` AS area_id, `name` AS area_name, `code` AS area_code FROM (`po_areas`) ";
        if(isset ($alloted_area) and !empty ($alloted_area))
        {
            $query .= "WHERE `id` NOT IN ($alloted_area) ";
        }
        if(!empty ($area_list_for_particular_zone))
        {
            $query =  "SELECT area_id,area_name,area_code FROM ((" . $query . ")";
            $query .=   "UNION
                        (SELECT `id` AS area_id, `name` AS area_name, `code` AS area_code
                        FROM (`po_areas`)
                        WHERE `id` IN ($area_list_for_particular_zone)
                        ))AS alias_table
                        ORDER BY area_code";
        }
        //$query .= "ORDER BY code";
        $result = $this->db->query($query);
		return $result->result();
	}
    /*
     * @Author: Matin
     * @Modification Date: 06-04-2011
     */
    function get_area_code_name($area_list)
    {
        $result = $this->db->query("SELECT CONCAT(code, '-', name) AS area_code_name FROM po_areas WHERE id IN ($area_list) ORDER BY area_code_name");
        return $result->result_array();
    }
}
