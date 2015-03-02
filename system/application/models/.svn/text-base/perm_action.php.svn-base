<?php
/** 
	* PO Division Model Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\model\user_role.php	
	* @package		microfin 
	* @subpackage	microfin.model.user_role
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class Perm_action extends Model {

	var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->get('perm_actions');
        return $query->result();
    }
    
    function get_list_all()
    {
        $query = $this->db->get('perm_actions');
        return $query->result_array();
    }
    
    function read_by_controller_id($controller_id)
    {
        $query =  $query=$this->db->getwhere('perm_actions', array('controller_id' => $controller_id));;
        return $query->result_array();
    }
    
    function read_by_controller_id_action($controller_id,$action)
    {
        $query =  $query=$this->db->getwhere('perm_actions', array('controller_id' => $controller_id,'action'=>$action));
        return $query->result_array();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('perm_actions');
	}
	
    function add($data)
    {
        return $this->db->insert('perm_actions', $data);
    }

    function edit($data)
    {
        return $this->db->update('perm_actions', $data, array('id'=> $data['id']));
    }
	
	function read($action_id)
    {
        $query=$this->db->getwhere('perm_actions', array('id' => $action_id));
		return $query->result_array();
    }
    
    function delete($action_id)
	{
		return $this->db->delete('actions', array('id'=> $action_id));
	}
	
	function delete_by_controller_action($controller_id,$action)
	{
		return $this->db->delete('perm_actions', array('controller_id'=>$controller_id,'action'=> $action));
	}
	
    function delete_by_controller_ids($controller_ids)
	{
		return $this->db->query('DELETE FROM perm_actions WHERE controller_id NOT IN ('.$controller_ids.')');
	}
	
	
    function delete_by_ids($ids)
	{
		return $this->db->query('DELETE FROM perm_actions WHERE id NOT IN ('.$ids.')');
	}
	
	function truncate(){
		return $this->db->query('TRUNCATE TABLE perm_actions');
	}
   
}
