<?php
/** 
	* Po Zone Area Detail Model Class.
	* @pupose		Manage PO Zones information
	*		
	* @filesource	./system/application/models/po_zone_area_detail.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.po_zone_area_detail
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-04 $	 
*/ 
class Po_zone_area_detail extends Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->query("
			SELECT po_zone_area_details.id, po_zones.name AS zone_name, po_areas.name AS area_name
			FROM po_zone_area_details
			LEFT JOIN po_zones
			ON po_zone_area_details.zone_id = po_zones.id
			LEFT JOIN po_areas
			ON po_zone_area_details.area_id = po_areas.id
			LIMIT $offset OFFSET $limit
        ");			
        //$query = $this->db->get('po_zone_area_details', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('po_zone_area_details');
	}
	
    function add($data)
    {
        return $this->db->insert('po_zone_area_details', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_zone_area_details', $data, array('id'=> $data['id']));
    }
	
	function read($designation_id)
    {
        $query=$this->db->getwhere('po_zone_area_details', array('id' => $designation_id));
		return $query->result();
    }
	
	function delete($designation_id)
	{
		return $this->db->delete('po_zone_area_details', array('id'=> $designation_id));
	}
	
	//This function is for listing of zones
	function get_po_zones()
	{		
		$po_zone_info = $this->db->query("SELECT id AS po_zone_id,name AS po_zone_name FROM po_zones ORDER BY po_zone_name ASC");			
		return $po_zone_info->result();  
	}
	//This function is for listing of zones
	function get_po_areas()
	{		
		$po_area_info = $this->db->query("SELECT id AS po_area_id,NAME AS po_area_name FROM po_areas ORDER BY po_area_name ASC");			
		return $po_area_info->result();  
	}

}
