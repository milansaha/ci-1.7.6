<?php
class Samity_subgroup extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond=null)
    {
        //Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('sg.name', $cond['name']);
			}
			if(isset($cond['cbo_samity_group']) and !empty($cond['cbo_samity_group'])){
				$this->db->where('sg.group_id', $cond['cbo_samity_group']);

			}
		}
		// end search
		$this->db->select('sg.id,sg.name as subgroup_name,subgroup_code,g.name as group_name');
		$this->db->from('samity_subgroups as sg');
		$this->db->join('samity_groups as g', 'g.id = sg.group_id','left');		
		$this->db->order_by('subgroup_name','ASC');
		$this->db->limit($offset,$limit);
		$query  = $this->db->get();         
        return $query->result();        
    }
	
	function row_count($cond=null)
	{
        //Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('samity_subgroups.name', $cond['name']);
			}
			if(isset($cond['cbo_samity_group']) and !empty($cond['cbo_samity_group'])){
				$this->db->where('samity_subgroups.group_id', $cond['cbo_samity_group']);

			}
		}
		// end search
		return $this->db->count_all_results('samity_subgroups');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('samity_subgroups', 'id');
        return $this->db->insert('samity_subgroups', $data);
    }

    function edit($data)
    {
        return $this->db->update('samity_subgroups', $data, array('id'=> $data['id']));
    }
	
	function read($subgroup_id)
    {
        $query=$this->db->getwhere('samity_subgroups', array('id' => $subgroup_id));
		return $query->row();
    }
	
	function delete($subgroup_id)
	{
		return $this->db->delete('samity_subgroups', array('id'=> $subgroup_id));
	}
/**
 * @name get_samity_sub_group_list_by_samity_group
 * @uses samity_sub_group
 * @updatedBy Anis Alamgir
 * @lastDate 20-Jan-2010  
 */
	function get_samity_sub_group_list_by_samity_group($samity_group_id = -1)
	{		
		$samity_group_id = (empty($samity_group_id))?"-1":$samity_group_id;
		$samity_sub_group_info = $this->db->query("SELECT id as samity_sub_group_id,name  as samity_sub_group_name FROM samity_subgroups where group_id = $samity_group_id ORDER BY name ASC");		
		return $samity_sub_group_info->result();  
    }

}
