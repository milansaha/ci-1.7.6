<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User_Autologin
 *
 * This model represents user autologin data. It can be used
 * for user verification when user claims his autologin passport.
 *
 */
class User_autologin extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get user data for auto-logged in user.
	 * Return NULL if given key or user ID is invalid.
	 *
	 * @param	int
	 * @param	string
	 * @return	object
	 */
	function get($user_id, $key)
	{
		
		$this->db->select('users.id,users.full_name,users.login,users.password,users.role_id,users.default_branch_id,po_branches.name as branch_name');
		$this->db->from('users');
		$this->db->join('po_branches','users.default_branch_id=po_branches.id','left');
		$this->db->join('user_autologins', 'user_autologins.user_id = users.id');
		$this->db->where('user_autologins.user_id', $user_id);
		$this->db->where('user_autologins.key_id', $key);
		$query = $this->db->get();
		if ($query->num_rows() == 1) return $query->row();
		return FALSE;
	}

	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @param	string
	 * @return	bool
	 */
	function set($user_id, $key)
	{
		return $this->db->insert('user_autologins', array(
			'user_id' 		=> $user_id,
			'key_id'	 	=> $key,
			'user_agent' 	=> substr($this->input->user_agent(), 0, 149),
			'last_ip' 		=> $this->input->ip_address(),
		));
	}

	/**
	 * Delete user's autologin data
	 *
	 * @param	int
	 * @param	string
	 * @return	void
	 */
	function delete($user_id, $key)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('key_id', $key);
		$this->db->delete('user_autologins');
	}

	/**
	 * Delete all autologin data for given user
	 *
	 * @param	int
	 * @return	void
	 */
	function clear($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user_autologins');
	}

	/**
	 * Purge autologin data for given user and login conditions
	 *
	 * @param	int
	 * @return	void
	 */
	function purge($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('user_agent', substr($this->input->user_agent(), 0, 149));
		$this->db->where('last_ip', $this->input->ip_address());
		$this->db->delete('user_autologins');
	}
}

/* End of file user_autologin.php */
/* Location: ./application/models/user_autologin.php */
