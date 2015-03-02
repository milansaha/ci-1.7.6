<?php
/** 
	* PO Division Model Class.
	* @pupose		Manage division information
	*		
	* @filesource	\app\model\user.php	
	* @package		microfin 
	* @subpackage	microfin.model.user
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-04 $	 
*/
class User extends MY_Model {

	var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit,$cond='')
    {
		$this->db->select('users.id,users.full_name,users.login,user_roles.role_name,po_branches.name as branch_name,users.current_status');
		$this->db->order_by('login','ASC');
        $this->db->from('users', $offset, $limit);
        $this->db->join('user_roles', 'users.role_id = user_roles.id');
        $this->db->join('po_branches', 'users.default_branch_id = po_branches.id','left');
        // search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				//$array = array('login' => $cond['name'], 'full_name' => $cond['name']);
				//$this->db->like($array);
				//$this->db->like('users.full_name',$cond['name']); 
				$where = "( users.login LIKE '%{$cond['name']}%' OR users.full_name LIKE '%{$cond['name']}%')";
   				$this->db->where($where);
			}			
			if(isset($cond['user_role']) and !empty($cond['user_role']) and $cond['user_role'] != -1){	
				$this->db->where('users.role_id', $cond['user_role']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('users.default_branch_id', $cond['user_branch']);
				
			}
			if(isset($cond['user_status']) and !empty($cond['user_status'])and $cond['user_status'] != -1){	
				$this->db->where('users.current_status', $cond['user_status']);	
			}	
			
/*
			if(isset($cond['name']) and !empty($cond['name'])){	
				//$this->db->like('users.login', $cond['name']);
				//$this->db->or_like('users.full_name',$cond['name']); 
				$this->db->or_where('users.full_name',$cond['name']); 
			}	
*/
			
			
		}
		// end search
		$this->db->limit($offset, $limit);
		$this->db->order_by('users.login','ASC');
		$query = $this->db->get(); 
        return $query->result();   
    }
    
    
	
	function row_count($cond)
	{
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				//$array = array('login' => $cond['name'], 'full_name' => $cond['name']);
				//$this->db->like($array);
				//$this->db->like('users.full_name',$cond['name']); 
				$where = "( users.login LIKE '%{$cond['name']}%' OR users.full_name LIKE '%{$cond['name']}%')";
   				$this->db->where($where);
			}			
			if(isset($cond['user_role']) and !empty($cond['user_role']) and $cond['user_role'] != -1){	
				$this->db->where('users.role_id', $cond['user_role']);
				
			}
			if(isset($cond['user_branch']) and !empty($cond['user_branch']) and $cond['user_branch'] != -1){	
				$this->db->where('users.default_branch_id', $cond['user_branch']);
				
			}
			if(isset($cond['user_status']) and !empty($cond['user_status'])and $cond['user_status'] != -1){	
				$this->db->like('users.current_status', $cond['user_status']);	
			}				
			
			
			
		}
		// end search
		return $this->db->count_all_results('users');
	}
	
    function add($data)
    {
		$data['id'] = $this->get_new_id('users', 'id');
		$data['created_on'] = date('Y-m-d H:i:s');		
        return $this->db->insert('users', $data);
    }

    function edit($data,$default_secret_hash)
    {
		if($data['password']==$default_secret_hash)
		{
			unset($data['password']);
		}
		$data['modified_on'] = date('Y-m-d H:i:s');
        return $this->db->update('users', $data, array('id'=> $data['id']));
    }
	
	function read($id)
    {
        $query=$this->db->getwhere('users', array('id' => $id));
		$user= $query->row();
		return $user;
    }
    
    function get_user_by_login($login)
    {
		$this->db->select('users.id,users.full_name,users.login,users.role_id,users.password,users.default_branch_id,po_branches.name as branch_name');
		$this->db->from('users');
		$this->db->join('po_branches','users.default_branch_id=po_branches.id','left');
        $this->db->where(array('login' => $login));
        $query = $this->db->get();
        if ($query->num_rows() == 1) 
			return $query->row();
		else
			return false;
    }
	
	function delete($id)
	{
		return $this->db->delete('users', array('id'=> $id));
	}
	
	function get_user_role_list()
    {
        $user_roles = $this->db->query("SELECT id, role_name FROM user_roles ORDER BY role_name ASC");			
		return $user_roles->result();  
    }
    
    function get_branch_list()
    {
        $branches = $this->db->query("SELECT id, name FROM po_branches ORDER BY name ASC");			
		return $branches->result();  
    }
	
	function checkPassword($user_id,$password)
	{
		$sql = "select id from users where id= ? and password= ?";
		$query=$this->db->query($sql, array($user_id,$password));
		
		if ($query->num_rows()==1)
			return true;
		else
			return false;
	}
	
	function changePassword($data)
	{
		return $this->db->update('users', $data, array('id'=> $data['id']));
	}

	public function check_session()
	{
		
		if ($this->session->userdata('system.user') && $this->session->userdata('logged_in')==TRUE) {
			return TRUE;			
		} 
		else{
			return FALSE;
		}
	}
	
	/**
	 * Update user login info, such as IP-address or login time, and
	 * clear previously generated (but not activated) passwords.
	 *
	 * @param	int
	 * @param	bool
	 * @param	bool
	 * @return	void
	 */
	function update_login_info($user_id, $record_ip, $record_time)
	{
		$this->db->set('forgotten_password_key', NULL);
		$this->db->set('forgotten_password_requested', NULL);

		if ($record_ip)		$this->db->set('last_ip', $this->input->ip_address());
		if ($record_time)	$this->db->set('last_login', date('Y-m-d H:i:s'));

		$this->db->where('id', $user_id);
		$this->db->update('users');
	}
}
