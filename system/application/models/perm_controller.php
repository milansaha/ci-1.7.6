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
class Perm_controller extends Model {

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
        $query = $this->db->get('perm_controllers');
        return $query->result();
    }
    
    function get_list_all()
    {
        $query = $this->db->get('perm_controllers');
        return $query->result_array();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('perm_controllers');
	}
	
    function add($data)
    {
        return $this->db->insert('perm_controllers', $data);
    }

    function edit($data)
    {
        return $this->db->update('perm_controllers', $data, array('id'=> $data['id']));
    }
	
	function read($perm_controllers_id)
    {
        $query=$this->db->getwhere('perm_controllers', array('id' => $perm_controllers_id));
		return $query->result_array();
    }
    
    function read_by_controller($perm_controller)
    {
        $query=$this->db->getwhere('perm_controllers', array('controller' => $perm_controller));
		return $query->result_array();
    }
    
     function delete_by_controller_ids($controller_ids)
	{
		return $this->db->query('DELETE FROM perm_controllers WHERE id NOT IN ('.$controller_ids.')');
	}
    
    function truncate(){
		return $this->db->query('TRUNCATE TABLE perm_controllers');
	}
    
}
