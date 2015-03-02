<?php
/** 
	* My Model Class. 
	* @pupose		Generate the database table id
	*		
	* @filesource	\app\model\M.php	
	* @package		microfin 
	* @subpackage	microfin.model
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-17 $	 
*/
class MY_Model extends Model {

    var $new_id   = '';    

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    //Generate the next id based on the current id
    function get_new_id($table_name, $id,$branch_id = null,$samity_id = null)
    {
		$this->db->select_max($id);
		if(is_numeric($branch_id)){
			$this->db->where("$table_name.branch_id", $branch_id);	
		}
		if(is_numeric($samity_id)){
			$this->db->where("$table_name.samity_id", $samity_id);	
		}
		$query = $this->db->get($table_name);      
		$max_id = $query->row();		
		$new_id = $max_id->{$id} + 1;
        return $new_id ;
    }
/**
 * get enum values
 * @Added Anis Alamgir
 * @source http://codeigniter.com/forums/viewthread/101110/#753140
 * @updated Add new param $showEmpty 
 * @date Jan-26-2011 
 */
    function enum_select( $table , $field,$showEmpty = false )
    {
        $query = "SHOW COLUMNS FROM ".$table." LIKE '$field'";
        $row = $this->db->query("SHOW COLUMNS FROM ".$table." LIKE '$field'")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        if($showEmpty){
			$enums[""]="--Select--";
		}
        foreach ($enum_fields as $key=>$value)
        {
            $enums[$value] = $value; 
        }
        return $enums;
    }  
    
     /**
     * @name is_dependent
     * @uses example: is_dependency_found('samity_subgroups',  array('group_id' => $samity_group_id));
     * @param $table_name = name of the dependent table, $cond = associative array()
     * @purpose Check wether the data to be deleted is dependent on others.
     * @updatedBy Matin
     * @lastDate 13-March-2011
     */
    function is_dependency_found($table_name,$cond='')
    {  
		//echo "<pre>";print_r($cond);die;
		if(is_array($cond))
		{			
			$this->db->where($cond);
			$this->db->from($table_name);
			$childs = $this->db->count_all_results();
			if($childs > 0)
			{
				return TRUE;
			}
		}
		return FALSE;	
       
    }
    
    function check_is_holiday($date,$branch_id)
	{
		$query="SELECT 1 as is_holiday 
			FROM config_holidays 
			WHERE ((holiday_date = '$date' AND branch_id = $branch_id) OR 
			(holiday_date = '$date'  AND (branch_id IS NULL OR branch_id  = 0)) ) AND (samity_id IS NULL OR samity_id  = 0)";
			//echo $query;
			
		$query = $this->db->query($query);

		return (isset($query->row(1)->is_holiday) and $query->row(1)->is_holiday )?true:false;
	}
    /*
     * @Author: Matin
     * @lastDate 31-03-2011
     */
    function get_general_configurations()
    {
        return $this->db->get('config_general')->row();
    }
}
