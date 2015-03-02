<?php
/** 
	* PO Union/Ward Model Class. 
	* @pupose		Manage po union information
	*		
	* @filesource	\app\model\po_unions_or_wards_or_ward.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_unions_or_wards_or_ward
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Po_unions_or_ward extends MY_Model {

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
					$this->db->like('po_unions_or_wards.name', $cond['name']);	
			}
            if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){
				$this->db->where('po_unions_or_wards.division_id', $cond['cbo_division']);
			}
            if(isset($cond['cbo_district']) and !empty($cond['cbo_district'])){
				$this->db->where('po_unions_or_wards.district_id', $cond['cbo_district']);
			}
			if(isset($cond['cbo_thana']) and !empty($cond['cbo_thana'])){	
				$this->db->where('po_unions_or_wards.thana_id', $cond['cbo_thana']);				
			}
		}
		// end search		
        $this->db->select('po_divisions.name as division_name, po_districts.name as district_name,po_thanas.name as thana_name,po_unions_or_wards.*');
		$this->db->from('po_unions_or_wards');
		$this->db->join('po_divisions', 'po_divisions.id = po_unions_or_wards.division_id');
		$this->db->join('po_districts', 'po_districts.id = po_unions_or_wards.district_id');
		$this->db->join('po_thanas', 'po_thanas.id = po_unions_or_wards.thana_id');		
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
					$this->db->like('po_unions_or_wards.name', $cond['name']);	
			}
            if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){
				$this->db->where('po_unions_or_wards.division_id', $cond['cbo_division']);
			}
            if(isset($cond['cbo_district']) and !empty($cond['cbo_district'])){
				$this->db->where('po_unions_or_wards.district_id', $cond['cbo_district']);
			}
			if(isset($cond['cbo_thana']) and !empty($cond['cbo_thana'])){	
				$this->db->where('po_unions_or_wards.thana_id', $cond['cbo_thana']);
				
			}
		}
		// end search
		return $this->db->count_all_results('po_unions_or_wards');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('po_unions_or_wards', 'id');
        return $this->db->insert('po_unions_or_wards', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_unions_or_wards', $data, array('id'=> $data['id']));
    }
	
	function read($union_id)
    {
        $query=$this->db->getwhere('po_unions_or_wards', array('id' => $union_id));
		return $query->row();
    }
	
	function delete($union_id)
	{
		return $this->db->delete('po_unions_or_wards', array('id'=> $union_id));
	}    
    
    /*
     * @Added By: Matin
     * @Purpose : Check the duplicate union under the same Thana
     * @Use: Useed in Po_unions_or_wards   controller class
     * @Modification Date: 24-03-2011
     */
    function check_duplicate_union_under_same_thana($data)
    {        
        if ( isset($data['name']) and ! empty($data['name']) and isset($data['thana_id']) and ! empty($data['thana_id']) and isset($data['union_id']) and ! empty($data['union_id']))
        {
            $query = $this->db->select('name')->from('po_unions_or_wards')->where(array('thana_id' =>$data['thana_id'],'name' => $data['name'],'id !=' => $data['union_id']) )->limit(1)->get();
        } else {
            $query = $this->db->select('name')->from('po_unions_or_wards')->where(array('thana_id' =>$data['thana_id'],'name' => $data['name']) )->limit(1)->get();
        }
        return $query->row()?false:true;
    }
    /*
     * @Added By: Matin
     * @Modification Date: 25-03-2011
     */
    function get_union_by_thana($thana_id)
    {
		if(empty($thana_id)) return array();
        $unions = $this->db->query("SELECT id,name FROM po_unions_or_wards where po_unions_or_wards.thana_id=$thana_id ORDER BY name ASC");
		return $unions->result();
    }
	
}
