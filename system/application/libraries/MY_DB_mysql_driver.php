<?php
/** 
	* Extended  MySQL Driver Class.
	* @pupose		Perform audit trail operation on mysql database
	*		
	* @filesource	\app\libraries\MY_DB_mysql_driver.php	
	* @package		microfin 
	* @subpackage	microfin.libraries.MY_DB_mysql_driver
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury, Saroj Roy $	
	* @lastmodified $Date: 2011-03-07 $	 
*/ 

class MY_DB_mysql_driver extends CI_DB_mysql_driver {
	
	//table list for which audit trail will not be done
	private $audit_skip_tables=array(
		'user_access_logs'=>TRUE,
		'user_audit_trails'=>TRUE,
		'user_autologins'=>TRUE,
		'user_login_attempts'=>TRUE,
		'user_login_profiles'=>TRUE
		);
	private $debug=FALSE;
	private $CI=null;
	private $session_table='';
	
	function __construct($params)
	{
		parent::__construct($params);
		log_message('debug', 'Extended DB driver class instantiated!');
		$this->CI =& get_instance();
		$this->session_table=$this->CI->config->item('sess_table_name');
		$this->audit_skip_tables[$this->session_table]=TRUE;
	}
	
	//overriding the insert method
	function insert($table = '', $set = NULL){
		//perform the operation
		$status= parent::insert($table , $set);
		//add audit log
		$this->_add_audit_log($status,'insert',$table, $set);
		//return the operation status
		return $status;
	}
	
	//overriding the update method
	function update($table = '', $set = NULL, $where = NULL, $limit = NULL){
		
		//getting the old values
		$old_value=null;
		//storing the initial conditions whatever is set
		$ar_where=$this->ar_where;
		
		if($this->is_auditable($table)){
			
			if(empty($where))
				$query=$this->get($table);
			else
				$query=$this->get_where($table,$where);
			
			$old_value=$query->result_array();
			//print_r($old_value);
			$query->free_result();
		}
		//restoring the conditions after executing the query
		$this->ar_where=$ar_where;
		
		//perform the operation
		$status= parent::update($table, $set, $where, $limit);
		//add audit log
		$this->_add_audit_log($status,'update',$table, $set,$old_value);
		//return the operation status
		return $status;
	}
	
	//overriding the delete method
	function delete($table = '', $where = '', $limit = NULL, $reset_data = TRUE){
		
		//getting the old values
		$old_value=null;
		//storing the initial conditions whatever is set
		$ar_where=$this->ar_where;
		if($this->is_auditable($table)){
			if(empty($where))
				$query=$this->get($table);
			else
				$query=$this->get_where($table,$where);
			
			$old_value=$query->result_array();
			
			$query->free_result();
		}
		//restoring the conditions after executing the query
		$this->ar_where=$ar_where;
				
		//perform the operation
		$status= parent::delete($table, $where, $limit, $reset_data);
		//add audit log
		$this->_add_audit_log($status,'delete',$table, $where,$old_value);
		//return the operation status
		return $status;
	}
	
	//adding audit trail functionality
	function _add_audit_log($status,$operation,$table,$set = NULL,$previous_values=NULL)
	{
		if ($this->debug) echo("[Audit Trail] Called; ");
		//if db operation failed, return false;
		if(!$status) return false;
		//If not for audit then return true
		if(!$this->is_auditable($table)){
			if ($this->debug) echo("[Audit Trail] Skipped for $table; ");
			return true;
		}
		
		$new_value=json_encode($set);
		//If edit or delete operation, adding the old values
		$old_value=null;
		if(!empty($previous_values))
		{
			$old_value=json_encode($previous_values);
		}	
		
		//print_r($set);
		//print_r($previous_values);
		//die('debug');
		
		$user=$this->CI->session->userdata('system.user');
		$audit_trail_data=array('time_stamp'=>time(),'user_id'=>$user['id'],'ip_address'=>$this->CI->input->ip_address(),'branch_id'=>$user['branch_id'],'table_name'=>$table,'url'=>$this->CI->uri->ruri_string(),'action'=>$operation,'old_value'=>$old_value,'new_value'=>$new_value);
		$success=parent::insert('user_audit_trails' , $audit_trail_data);
		if(!$success)
		{
			log_message('error', "Error writing log for $operation operation on $table");
		}
		if ($this->debug) echo("[Audit Trail] Executed for $table; ");
		return $success;
	}
	
	function is_auditable($table_name)
	{
		//If AUDIT_TRAIL is disabled for command line use, return FALSE to skip auditing
		if(defined('AUDIT_TRAIL'))
			if(AUDIT_TRAIL==FALSE) return FALSE;
		
		return (!isset($this->audit_skip_tables[$table_name]));
	}
}
