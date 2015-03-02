<?php
/** 
	* PO Village/Block Model Class. 
	* @pupose		Manage po Village/Block information
	*		
	* @filesource	\app\model\po_village_or_block.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_village_or_block
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Po_village_or_block extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond)
    {
        //Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('po_village_or_blocks.name', $cond['name']);
			}
            if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){
				$this->db->where('po_village_or_blocks.division_id', $cond['cbo_division']);
			}
            if(isset($cond['cbo_district']) and !empty($cond['cbo_district'])){
				$this->db->where('po_village_or_blocks.district_id', $cond['cbo_district']);
			}
			if(isset($cond['cbo_thana']) and !empty($cond['cbo_thana'])){
				$this->db->where('po_village_or_blocks.thana_id', $cond['cbo_thana']);
			}
            if(isset($cond['cbo_union']) and !empty($cond['cbo_union'])){
				$this->db->where('po_village_or_blocks.union_or_ward_id', $cond['cbo_union']);
			}
		}
		// end search	
        $this->db->select('po_divisions.name as division_name, po_districts.name as district_name,po_thanas.name as thana_name,po_unions_or_wards.name as union_name,po_village_or_blocks.*');
		$this->db->from('po_village_or_blocks');
		$this->db->join('po_divisions', 'po_divisions.id = po_village_or_blocks.division_id');
		$this->db->join('po_districts', 'po_districts.id = po_village_or_blocks.district_id');
		$this->db->join('po_thanas', 'po_thanas.id = po_village_or_blocks.thana_id');	
		$this->db->join('po_unions_or_wards', 'po_unions_or_wards.id = po_village_or_blocks.union_or_ward_id');	
		$this->db->limit($offset,$limit);	
		$this->db->order_by('po_village_or_blocks.name','ASC');
		$query = $this->db->get(); 
        return $query->result();
    }
	
	function row_count($cond)
	{
        //Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('po_village_or_blocks.name', $cond['name']);
			}
            if(isset($cond['cbo_division']) and !empty($cond['cbo_division'])){
				$this->db->where('po_village_or_blocks.division_id', $cond['cbo_division']);
			}
            if(isset($cond['cbo_district']) and !empty($cond['cbo_district'])){
				$this->db->where('po_village_or_blocks.district_id', $cond['cbo_district']);
			}
			if(isset($cond['cbo_thana']) and !empty($cond['cbo_thana'])){
				$this->db->where('po_village_or_blocks.thana_id', $cond['cbo_thana']);
			}
            if(isset($cond['cbo_union']) and !empty($cond['cbo_union'])){
				$this->db->where('po_village_or_blocks.union_or_ward_id', $cond['cbo_union']);
			}
		}
		// end search
		return $this->db->count_all_results('po_village_or_blocks');
	}
	
    function add($data)
    {
        $data['id'] = $this->get_new_id('po_village_or_blocks', 'id');
        return $this->db->insert('po_village_or_blocks', $data);
    }

    function edit($data)
    {
        return $this->db->update('po_village_or_blocks', $data, array('id'=> $data['id']));
    }
	
	function read($union_id)
    {
        $query=$this->db->getwhere('po_village_or_blocks', array('id' => $union_id));
		return $query->row();
    }
	
	function delete($union_id)
	{
		return $this->db->delete('po_village_or_blocks', array('id'=> $union_id));
	}
	
   /*
     * @Added By: Matin
     * @Purpose : Check the duplicate village/block under the same Union/Ward
     * @Use: Useed in _prepare_validation() method
     * @Modification Date: 25-03-2011
     */
    function check_duplicate_village_under_same_union($data)
    {       
        if ( isset($data['name']) and ! empty($data['name']) and isset($data['union_or_ward_id']) and ! empty($data['union_or_ward_id']) and isset($data['village_id']) and ! empty($data['village_id']))
        {
            $query = $this->db->select('name')->from('po_village_or_blocks')->where(array('union_or_ward_id' =>$data['union_or_ward_id'],'name' => $data['name'],'id !=' => $data['village_id']) )->limit(1)->get();
        } else {
            $query = $this->db->select('name')->from('po_village_or_blocks')->where(array('union_or_ward_id' =>$data['union_or_ward_id'],'name' => $data['name']) )->limit(1)->get();
        }
        return $query->row()?false:true;
    }

    /*
     * @Added By: Matin
     * @Modification Date: 26-03-2011
     */
    function get_village_by_union($union_id)
    {
		if(empty($union_id)) return array();
        $unions = $this->db->query("SELECT id,name FROM po_village_or_blocks WHERE union_or_ward_id=$union_id ORDER BY name ASC");
		return $unions->result();
    }
}
