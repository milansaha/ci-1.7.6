<?php
/** 
	* PO Thana Model Class. 
	* @pupose		Manage po thana information
	*		
	* @filesource	\app\model\po_thana.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_thana
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Po_thana extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit, $cond=null)
    {
		//Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('po_thanas.name', $cond['name']);
			}
            if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){
				$this->db->where('po_thanas.division_id', $cond['cbo_division']);
			}
            if(isset($cond['cbo_district']) and !empty($cond['cbo_district'])){
				$this->db->where('po_thanas.district_id', $cond['cbo_district']);
			}
		}
		// end search	
		
        $this->db->select('po_divisions.name as division_name, po_districts.name as district_name,po_thanas.*');
		$this->db->from('po_thanas');
		$this->db->join('po_districts', 'po_districts.id = po_thanas.district_id');
		$this->db->join('po_divisions', 'po_divisions.id = po_thanas.division_id');	
		$this->db->limit($offset,$limit);	
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
        return $query->result();
    }
	
	function row_count($cond=null)
	{
		//Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('po_thanas.name', $cond['name']);
			}
            if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){
				$this->db->where('po_thanas.division_id', $cond['cbo_division']);
			}
            if(isset($cond['cbo_district']) and !empty($cond['cbo_district'])){
				$this->db->where('po_thanas.district_id', $cond['cbo_district']);
			}
		}
		// end search	
		return $this->db->count_all_results('po_thanas');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('po_thanas', 'id');
        return $this->db->insert('po_thanas', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_thanas', $data, array('id'=> $data['id']));
    }
	
	function read($thana_id)
    {
        $query=$this->db->getwhere('po_thanas', array('id' => $thana_id));
		return $query->row();
    }
	
	function delete($thana_id)
	{
		return $this->db->delete('po_thanas', array('id'=> $thana_id));
	}    
    function get_thana_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_thanas');  
		return $query->result();
    }
    /*
     * @Added By: Matin
     * @Modification Date: 24-03-2011
     */
    function get_thanas_by_district($district_id)
    {
		if(empty($district_id)) return array();
        $districts = $this->db->query("SELECT id,name FROM po_thanas where po_thanas.district_id=$district_id ORDER BY name ASC");
		return $districts->result();
    }
}
