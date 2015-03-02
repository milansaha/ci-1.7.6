<?php
/** 
        * Samity Day Change Model Class.
        * @pupose               Manage Samity Day Change information
        *               
        * @filesource   \app\model\samity_day_change.php      
        * @package              microfin 
        * @subpackage   microfin.model.samity_day_change
        * @version      $Revision: 1 $
        * @author       $Author: Taposhi Rabeya $       
        * @lastmodified $Date: 2011-02-13 $      
*/



class Samity_day_change extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->select('samity_day_changes.*, samities.name AS samity_name');
		$this->db->from('samity_day_changes');
		$this->db->join('samities', 'samity_day_changes.samity_id = samities.id','left');		
		$this->db->where(array('samity_day_changes.is_deleted' => 0));
		$this->db->order_by('samities.name','ASC');
		$this->db->limit($offset,$limit);
		$query  = $this->db->get();         
        return $query->result();
    }
	
	function row_count()
	{	
		$this->db->where(array('samity_day_changes.is_deleted' => 0));	
		return $this->db->count_all_results('samity_day_changes');
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('samity_day_changes', 'id');
        //return $this->db->insert('samity_day_changes', $data);
		if($this->db->insert('samity_day_changes', $data))
		{			
			$samity['samity_day']=$data['new_samity_day'];
			$this->db->update('samities',$samity, array('id'=> $data['samity_id']));
			return true;
		}
		else { return false; } 
    }

    function edit($data)
    {
        //return $this->db->update('samity_day_changes', $data, array('id'=> $data['id']));
		if($this->db->update('samity_day_changes', $data, array('id'=> $data['id'])))
		{
			$samity['samity_day']=$data['new_samity_day'];
			$this->db->update('samities',$samity, array('id'=> $data['samity_id']));
			return true;
		}
		else { return false; } 
    }
	
	function read($samity_day_change_id)
    {
        $this->db->select('samities.name as samity_name,samities.code as samity_code,samity_day_changes.*');
		$this->db->from('samity_day_changes');
		$this->db->join('samities', 'samities.id = samity_day_changes.samity_id');		
		$this->db->where(array('samity_day_changes.id' =>$samity_day_change_id));
		$query = $this->db->get();
		return $query->result();
    }
	
	function delete($samity_day_change_id)
	{
		return $this->db->delete('samity_day_changes', array('id'=> $samity_day_change_id));
	}
}
