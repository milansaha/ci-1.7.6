<?php
/** 
	* PO Regions Model Class.
	* @pupose		Manage PO Regions information
	*		
	* @filesource	./system/application/models/po_region.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_region
	* @version      $Revision: 1 $
	* @author       $Author: S. Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_region extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc"); 
        $query = $this->db->get('po_regions', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_regions');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('po_regions', 'id');
        return $this->db->insert('po_regions', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_regions', $data, array('id'=> $data['id']));
    }
	
	function read($po_region_id)
    {
        $query=$this->db->getwhere('po_regions', array('id' => $po_region_id));
		return $query->row();
    }
	
	function delete($po_region_id)
	{
		return $this->db->delete('po_regions', array('id'=> $po_region_id));
	}
	function get_region_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_regions');  
		return $query->result();
    }
    /*
     * @Author: Matin
     * @lastModification: 05-04-2011
     */
    function _get_used_zone()
    {
        $result = $this->db->query('SELECT zone_list FROM po_regions')->result_array();
        $alloted_zone = '';
        if(!empty($result))
        {
            foreach($result as $result)
            {
                $alloted_zone[] = $result['zone_list'];
            }
            $alloted_zone = implode(',', $alloted_zone);
        }
        return $alloted_zone;
    }
    /*
     * @Author: Matin
     * @lastModification: 05-04-2011
     */
	function get_zone_info($zone_list_for_particular_region=array ())
	{
        $alloted_zone = $this->_get_used_zone();

        $query = "SELECT `id` AS zone_id, `name` AS zone_name, `code` AS zone_code FROM (`po_zones`) ";
        if(isset ($alloted_zone) and !empty ($alloted_zone))
        {
            $query .= "WHERE `id` NOT IN ($alloted_zone) ";
        }
        if(!empty ($zone_list_for_particular_region))
        {
            $query =  "SELECT zone_id,zone_name,zone_code FROM ((" . $query . ")";
            $query .=   "UNION
                        (SELECT `id` AS zone_id, `name` AS zone_name, `code` AS zone_code
                        FROM (`po_zones`)
                        WHERE `id` IN ($zone_list_for_particular_region)
                        ))AS alias_table
                        ";
        }
        $query .= " ORDER BY zone_code";
        $result = $this->db->query($query);
		return $result->result();
	}
    /*
     * @Author: Matin
     * @Modification Date: 06-04-2011
     */
    function get_zone_code_name($zone_list)
    {
        $result = $this->db->query("SELECT CONCAT(code, '-', name) AS zone_code_name FROM po_zones WHERE id IN ($zone_list) ORDER BY zone_code_name");
        return $result->result_array();
    }
}
