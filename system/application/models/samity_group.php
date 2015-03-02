<?php
/** 
        * Samity Group Model Class.
        * @pupose               Manage Samity Group information
        *               
        * @filesource   \app\model\samity_groups.php      
        * @package              microfin 
        * @subpackage   microfin.model.samity_groups
        * @version      $Revision: 1 $
        * @author       $Author: Md. Kamrul Islam $       
        * @lastmodified $Date: 2011-01-04 $      
*/



class Samity_group extends MY_Model {

    
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
					$this->db->like('samity_groups.name', $cond['name']);
			}
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){
				$this->db->where('samity_groups.samity_id', $cond['cbo_samity']);

			}
		}
		// end search
		
		$this->db->select('samity_groups.*, samities.name AS samity_name');
		$this->db->from('samity_groups');
		$this->db->join('samities', 'samity_groups.samity_id = samities.id','left');		
		$this->db->order_by('samity_groups.name','ASC');
		$this->db->limit($offset,$limit);
		$query  = $this->db->get();         
        return $query->result();
    }
	
    function row_count($cond = null)
    {
        //Modified By: Matin
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
					$this->db->like('samity_groups.name', $cond['name']);
			}
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){
				$this->db->where('samity_groups.samity_id', $cond['cbo_samity']);

			}
		}
		// end search
        return $this->db->count_all_results('samity_groups');
    }
	
    function add($data)
    {
        //The first param->Table Name, 2nd Param: id field
        $data['id'] = $this->get_new_id('samity_groups', 'id');
        return $this->db->insert('samity_groups', $data);
    }

    function edit($data)
    {
        return $this->db->update('samity_groups', $data, array('id'=> $data['id']));
    }
	
    function read($samity_group_id)
    {
        $query=$this->db->getwhere('samity_groups', array('id' => $samity_group_id));
		return $query->row();
    }
	
    function delete($samity_group_id)
    {
            return $this->db->delete('samity_groups', array('id'=> $samity_group_id));
    }

    //This function is for listing of samity groups
    function get_samity_groups()
    {
            $this->db->select('id as group_id,name as group_name');
            $this->db->from('samity_groups');
            $this->db->order_by('group_name', 'ASC');
            return $this->db->get()->result();
    }
    /**
     * @name get_samity_group_by_samity
     * @uses member(add,edit)
     * @updatedBy Anis Alamgir
     * @lastDate 20-Jan-2010
     */
    function get_samity_group_by_samity($samity_id = -1)
    {
            $samity_id = (empty($samity_id))?"-1":$samity_id;
            $samity_group_info = $this->db->query("SELECT id as samity_group_id,name  as samity_group_name FROM samity_groups where samity_id = $samity_id ORDER BY name ASC");
            return $samity_group_info->result();
    }
     
}
