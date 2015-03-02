<?php
class Config_customized_id extends Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        #$query = $this->db->get('config_holidays', $offset, $limit);
	$query = $this->db->query("
                        SELECT *
			from config_customized_ids 
                        LIMIT $offset OFFSET $limit
        ");  

        return $query->result();
    }	
	
	
    function add($data)
    {
        return $this->db->insert('config_customized_ids', $data);
    }

    function edit($data)
    {
        return $this->db->update('config_customized_ids', $data, array('id'=> $data['id']));
    }
	
	function read($config_holiday_id)
    {
        $query=$this->db->getwhere('config_customized_ids', array('id' => $config_holiday_id));
		return $query->result();
    }
    
    function readall()
    {
        $query=$this->db->getwhere('config_customized_ids');
	    return $query->row();
    }
	
	

	
	//This function is for listing of get_saving_product
	function get_saving_product()
	{		
		$saving_products_info = $this->db->query("SELECT * FROM saving_products ORDER BY name ASC");			
		return $saving_products_info->result();  
	}
	
	function get_loan_product()
	{		
		//$get_loan_product_info = $this->db->query("SELECT * FROM loan_products ORDER BY name ASC");			
	//	return $get_loan_product_info->result();  
		
		$this->db->select('loan_products.*, po_funding_organizations.name as fundname ');
		$this->db->from('loan_products');
		$this->db->join('po_funding_organizations', 'loan_products.funding_organization_id = po_funding_organizations.id');
		
		//$this->db->order_by('name', 'asc');
		$get_loan_product_info = $this->db->get();
        return $get_loan_product_info->result();
	}
	
	function get_loan_cycle()
	{		
		$loan_cycle_info = $this->db->query("SELECT cycle FROM loans");			
		return $loan_cycle_info->result();  
	}
	/*
	 * @uses Auto ID configuration
	 * @Author: Anis Alamgir
	 * @Date: 08-03-2011
	 */
	function get_auto_id_config_info()
	{		
		$query=$this->db->getwhere('config_customized_ids', null,1);
		return $query->row();
	}
}
