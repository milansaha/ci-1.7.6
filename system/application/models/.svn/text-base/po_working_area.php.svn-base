<?php
/** 
	* PO Working Areas Model Class. 
	* @pupose		Manage po Working Areas information
	*		
	* @filesource	\app\model\po_working_area.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_working_area
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Po_working_area extends MY_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
        $this->db->select('po_working_areas.id,po_working_areas.name,po_village_or_blocks.id AS village_id,po_village_or_blocks.name AS village_name,po_unions_or_wards.id AS union_id,po_unions_or_wards.name AS union_name,po_thanas.id AS thana_id,po_thanas.name AS thana_name,po_districts.id AS district_id,po_districts.name AS district_name,po_divisions.id AS division_id, po_divisions.name AS division_name');
        $this->db->from('po_working_areas');
        $this->db->join('po_village_or_blocks','po_working_areas.village_or_block_id = po_village_or_blocks.id');
        $this->db->join('po_unions_or_wards','po_village_or_blocks.union_or_ward_id = po_unions_or_wards.id');
        $this->db->join('po_thanas','po_unions_or_wards.thana_id = po_thanas.id');
        $this->db->join('po_districts','po_thanas.district_id = po_districts.id');
        $this->db->join('po_divisions','po_districts.division_id = po_divisions.id');
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){		
   				$this->db->like('po_working_areas.name', $cond['name']);
			}			
		}
		// end search
		$this->db->limit($offset,$limit);	
		$this->db->order_by('po_working_areas.name','ASC');
		$query = $this->db->get(); 
        return $query->result();        
    }
	
	function row_count($cond)
	{
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){		
   				$this->db->like('po_working_areas.name', $cond['name']);
			}		
		}
		$this->db->select('po_working_areas.id,po_working_areas.name,po_village_or_blocks.id AS village_id,po_village_or_blocks.name AS village_name,po_unions_or_wards.id AS union_id,po_unions_or_wards.name AS union_name,po_thanas.id AS thana_id,po_thanas.name AS thana_name,po_districts.id AS district_id,po_districts.name AS district_name,po_divisions.id AS division_id, po_divisions.name AS division_name');
        $this->db->from('po_working_areas');
        $this->db->join('po_village_or_blocks','po_working_areas.village_or_block_id = po_village_or_blocks.id');
        $this->db->join('po_unions_or_wards','po_village_or_blocks.union_or_ward_id = po_unions_or_wards.id');
        $this->db->join('po_thanas','po_unions_or_wards.thana_id = po_thanas.id');
        $this->db->join('po_districts','po_thanas.district_id = po_districts.id');
        $this->db->join('po_divisions','po_districts.division_id = po_divisions.id');
		return $this->db->count_all_results();
	}
	
    function add($data)
    {
        $data['id'] = $this->get_new_id('po_working_areas', 'id');
        return $this->db->insert('po_working_areas', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_working_areas', $data, array('id'=> $data['id']));
    }
	
	function read($district_id)
    {
        $this->db->select('po_working_areas.id,po_working_areas.name,po_village_or_blocks.id AS village_or_block_id,po_village_or_blocks.name AS village_name,po_unions_or_wards.id AS union_or_ward_id,po_unions_or_wards.name AS union_name,po_thanas.id AS thana_id,po_thanas.name AS thana_name,po_districts.id AS district_id,po_districts.name AS district_name,po_divisions.id AS division_id, po_divisions.name AS division_name');
        $this->db->from('po_working_areas');
        $this->db->join('po_village_or_blocks','po_working_areas.village_or_block_id = po_village_or_blocks.id');
        $this->db->join('po_unions_or_wards','po_village_or_blocks.union_or_ward_id = po_unions_or_wards.id');
        $this->db->join('po_thanas','po_unions_or_wards.thana_id = po_thanas.id');
        $this->db->join('po_districts','po_thanas.district_id = po_districts.id');
        $this->db->join('po_divisions','po_districts.division_id = po_divisions.id');
        $this->db->where('po_working_areas.id',$district_id);
		return $this->db->get()->row();
    }
	
	function delete($district_id)
	{
		return $this->db->delete('po_working_areas', array('id'=> $district_id));
	}
	
	function get_village_list()
    {
        $villages = $this->db->query("SELECT id,name FROM po_village_or_blocks ORDER BY name ASC");			
		return $villages->result();  
    }
        
	function get_working_area_info()
	{		
		$this->db->select('id as working_area_id,name as working_area_name');
		$this->db->from('po_working_areas');		
		$this->db->order_by('working_area_name','ASC');
		$query = $this->db->get(); 
        return $query->result(); 
	}
	function get_working_area_list_json_auto($search_key='')
    {
        $this->db->select('po_working_areas.id, po_working_areas.name,po_village_or_blocks.name as village_name,po_thanas.name as thana_name,po_districts.name as district_name');
		$this->db->from('po_working_areas');
		$this->db->join('po_village_or_blocks', 'po_village_or_blocks.id = po_working_areas.village_or_block_id');
		$this->db->join('po_thanas', 'po_thanas.id = po_village_or_blocks.thana_id');
		$this->db->join('po_districts', 'po_districts.id = po_village_or_blocks.district_id');
		$this->db->like('po_working_areas.name',$search_key);
		$this->db->order_by('po_working_areas.name');
		$this->db->limit(10); 	
		$query = $this->db->get();
        return $query->result();
    }
}
