<?php
class Product_interest_rate extends Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
	$query = $this->db->query("
                        SELECT pi.id as id,p.id as product_id,p.name as product_name,pi.interest_rate,pi.interest_provision_rate,pi.effective_date,pi.end_date
			FROM loan_products as p
                        JOIN product_interest_rates as pi                        
			ON p.id = pi.product_id
                        LIMIT $offset OFFSET $limit
        ");  
  //      $query = $this->db->get('product_interest_rates', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('product_interest_rates');
	}
	
    function add($data)
    {
        return $this->db->insert('product_interest_rates', $data);
    }

    function edit($data)
    {        
		$this->db->trans_start();
		$this->db->query("UPDATE loan_products SET interest_rate={$data['interest_rate']} WHERE id={$data['product_id']}");
		$this->db->update('product_interest_rates', $data, array('id'=> $data['id']));
		$this->db->trans_complete();		
		return $this->db->trans_status();		
    }
	
	function read($product_interest_id)
    {
        $query=$this->db->getwhere('product_interest_rates', array('id' => $product_interest_id));
		return $query->result();
    }
	
	function delete($product_interest_id)
	{		
		return $this->db->delete('product_interest_rates', array('id'=> $product_interest_id));
	}
	
	//This function is for listing of departments
	function get_products()
	{		
		$product_info = $this->db->query("SELECT id as product_id,name as product_name FROM loan_products ORDER BY product_name ASC");			
		return $product_info->result();  
	}

}
