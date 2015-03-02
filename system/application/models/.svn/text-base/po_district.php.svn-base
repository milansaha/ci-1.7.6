<?php
/** 
	* PO District Model Class. 
	* @pupose		Manage po district information
	*		
	* @filesource	\app\model\po_district.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_district
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Po_district extends MY_Model {	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond='')
    {
		//Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){					
					$this->db->like('po_districts.name', $cond['name']);	
			}			
			if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){	
				$this->db->where('po_districts.division_id', $cond['cbo_division']);
				
			}
		}
		// end search
		
        $this->db->select('po_divisions.name as division_name, po_districts.*');
		$this->db->from('po_districts');
		$this->db->join('po_divisions', 'po_divisions.id = po_districts.division_id');
		$this->db->limit($offset,$limit);	
		$this->db->order_by("name", "asc");
		$query = $this->db->get();		
        return $query->result();
    }
	
	function row_count($cond=null)
	{
		//Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){					
					$this->db->like('po_districts.name', $cond['name']);	
			}			
			if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){	
				$this->db->where('po_districts.division_id', $cond['cbo_division']);
				
			}
		}
		// end search
		return $this->db->count_all_results('po_districts');
	}
	
    function add($data)
    {
		$data['id']=$this->get_new_id('po_districts', 'id');
        return $this->db->insert('po_districts', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_districts', $data, array('id'=> $data['id']));
    }
	
	function read($district_id)
    {
        $query=$this->db->getwhere('po_districts', array('id' => $district_id));
		return $query->row();
    }
	
	function delete($district_id)
	{
		return $this->db->delete('po_districts', array('id'=> $district_id));
	}	
	
    function get_all_district_list($search_key='')
    {
        $this->db->select('po_divisions.name as division_name, po_districts.id, po_districts.name');
		$this->db->from('po_districts');
		$this->db->join('po_divisions', 'po_divisions.id = po_districts.division_id');
		$this->db->like('po_districts.name',$search_key);
		$this->db->order_by('po_districts.name');
		$this->db->limit(10); 	
		$query = $this->db->get();
        return $query->result();
    }
    
    function get_district_list()
    {
		$this->db->select('id, name');		
		$this->db->order_by('name','ASC');		
		$query = $this->db->get('po_districts');  
		return $query->result();
    } 
    
    function get_district_by_division($division_id)
    {
		if(empty($division_id)) return array();
        $districts = $this->db->query("SELECT id,name FROM po_districts where po_districts.division_id=$division_id ORDER BY name ASC");
		return $districts->result();
    }
}
