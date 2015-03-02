<?php
class Saving_attendance_register extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
	$query = $this->db->query("
                        SELECT s.id,p.name as product_name,sa.name as samity_name,m.name as member_name,br.name as branch_name,s.attendance_status,s.date
			FROM products as p
                        LEFT JOIN saving_attendance_register as s                        
			ON p.id = s.product_id
			LEFT JOIN members as m
			on m.id=s.samity_id
			LEFT JOIN samities as sa
			on m.samity_id=sa.id
			LEFT JOIN po_branches as br
			on sa.branch_id=br.id
                        LIMIT $offset OFFSET $limit
        ");  
//        $query = $this->db->get('saving_attendance_register', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('saving_attendance_register');
	}
	
    function add($data)
    {
        return $this->db->insert('saving_attendance_register', $data);
    }

    function edit($data)
    {
        return $this->db->update('saving_attendance_register', $data, array('id'=> $data['id']));
    }
	
	function read($saving_attendance_register_id)
    {
        $query=$this->db->getwhere('saving_attendance_register', array('id' => $saving_attendance_register_id));
		return $query->result();
    }
	
	function delete($saving_attendance_register_id)
	{
		return $this->db->delete('saving_attendance_register', array('id'=> $saving_attendance_register_id));
	}
	
	//This function is for listing of Products
	function get_branch()
	{		
		$branch_info = $this->db->query("SELECT id as branch_id,name as branch_name FROM po_branches ORDER BY branch_name ASC");			
		return $branch_info->result();  
	}
	function get_products()
	{		
		$product_info = $this->db->query("SELECT id as product_id,name as product_name FROM products ORDER BY product_name ASC");			
		return $product_info->result(); 
	} 
	function get_members()
	{		
		$member_info = $this->db->query("SELECT id as member_id,name as member_name FROM members ORDER BY member_name ASC");			
		return $member_info->result();
	} 
	function get_samity()
	{		
		$samity_info = $this->db->query("SELECT id as samity_id,name as samity_name FROM samities ORDER BY samity_name ASC");			
		return $samity_info->result();
	} 

}
