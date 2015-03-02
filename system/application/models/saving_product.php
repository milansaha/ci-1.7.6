<?php
/** 
	* Saving Product Model Class.
	* @pupose		Manage Saving Product information
	*		
	* @filesource	./system/application/models/saving_product.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.saving_product
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam $	
	* @lastmodified $Date: 2011-03-08 $	 
*/ 
class Saving_product extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
		$this->db->order_by("name", "asc"); 
        $query = $this->db->get('saving_products', $offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('saving_products');
	}
	
    function add($data)
    {
		$data['id']=$this->get_new_id('saving_products', 'id');
        return $this->db->insert('saving_products', $data);
    }

    function edit($data)
    {
        return $this->db->update('saving_products', $data, array('id'=> $data['id']));
    }
	
	function read($saving_product_id)
    {
        $query=$this->db->getwhere('saving_products', array('id' => $saving_product_id));
		return $query->row();
    }
	
	function delete($saving_product_id)
	{
		return $this->db->delete('saving_products', array('id'=> $saving_product_id));
	}
	/*
	 * @uses Component Wise Daily Collection Report
	 * @Author: Taposhi Rabeya
	 * @Date: 08-02-2011
	 */
	function get_savings_product_type_information()
	{  
		$savings_product_type_sql ="SELECT id,name,short_name FROM saving_products order by id";
		$savings_product_type_sql=$this->db->query($savings_product_type_sql);					
		$savings_product_type=array();
		$i=0;
		foreach ($savings_product_type_sql->result_array() as $savings_product_type_row)
		{
			$i++;
			$savings_product_type[$i]['id']=$savings_product_type_row['id'];	
			$savings_product_type[$i]['name']=$savings_product_type_row['name'];
			$savings_product_type[$i]['short_name']=$savings_product_type_row['short_name'];
		}
		return $savings_product_type;	
	}
}

