<?php
/** 
	* Member Model Class. 
	* @pupose		Manage Member information
	*		
	* @filesource	\app\model\po_member.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_member
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam Liton $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Migrations_member extends My_Model 
{
    function __construct()
    {
        // Call the Model constructor
        //parent::Migrations_member();
		parent::__construct();
    }
	// get samity name from a particular samity id
	function get_samity_name($samity_id)
    {
        $get_samity_name = $this->db->query("SELECT id,name,code FROM samities WHERE id = $samity_id ORDER BY name ASC");			
		return $get_samity_name->result();  
    }
}
