<?php
/** 
	* Product Model Class. 
	* @pupose		Manage Product information
	*		
	* @filesource	\app\model\po_product.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_product
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Loan_product extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_list($offset,$limit)
    {
        $query = $this->db->getwhere('loan_products',null,$offset, $limit);
        return $query->result();
    }
	
	function row_count()
	{
		return $this->db->count_all_results('loan_products');
	}
	
    function add($data)
    {
        $data['id']=$this->get_new_id('loan_products', 'id');
        return $this->db->insert('loan_products', $data);
    }

    function edit($data)
    {
        return $this->db->update('loan_products', $data, array('id'=> $data['id']));
    }
	
	function read($loan_product_id)
    {
        $query=$this->db->getwhere('loan_products', array('id' => $loan_product_id));
		return $query->row();
    }
	
	function delete($loan_product_id)
	{
		return $this->db->delete('loan_products', array('id'=> $loan_product_id));
	}
	//This function is for listing of products
	function get_product_info()
	{		
		$this->db->select('loan_products.id AS product_id, loan_products.code AS product_code, loan_products.short_name AS product_mnemonic, loan_products.name AS product_name,po_funding_organizations.name AS funding_org_name');
        $this->db->from('loan_products');
        $this->db->join('po_funding_organizations','loan_products.funding_organization_id = po_funding_organizations.id');
		$this->db->order_by('product_mnemonic','ASC');
		return $this->db->get()->result();
	}
	function get_product_detail_info($loan_product_id)
	{		
		$this->db->select('loan_products.id as loan_product_id,loan_products.name as loan_product_name,loan_products.short_name as loan_product_short_name,loan_products.code as loan_product_code,loan_products.loan_product_category_id,loan_products.start_date,loan_products.end_date,loan_products.interest_calculation_method,loan_products.interest_rate,loan_products.minimum_loan_amount,loan_products.maximum_loan_amount,loan_products.default_loan_amount,loan_products.funding_organization_id,loan_products.gl_code_for_principal,loan_products.gl_code_for_interest
	,loan_product_categories.name as loan_product_category_name,po_funding_organizations.name as po_funding_organization_name');
		$this->db->from('loan_products');
		$this->db->join('loan_product_categories', 'loan_products.loan_product_category_id = loan_product_categories.id');
		$this->db->join('po_funding_organizations', 'loan_products.funding_organization_id = po_funding_organizations.id');
		$this->db->where(array('loan_products.id' => $loan_product_id));
		$this->db->order_by('loan_products.name','ASC');
		$get_field_officer_info = $this->db->get(); 
        return $get_field_officer_info->result();    
	}
	/*
	 * @uses Component Wise Daily Collection Report
	 * @Author: Taposhi Rabeya
	 * @Date: 08-02-2011
	 */	
	function get_selected_product_info($loan_product_id=null)
	{       
		$sql = "SELECT name,short_name,is_primary_product FROM loan_products WHERE id= ?";
		$sql=$this->db->query($sql, array($loan_product_id)); 
		$product_info=array();
		foreach ($sql->result_array() as $row)
		{
		   	$product_info['name']=$row['name'];
			$product_info['short_name']=$row['short_name'];	   
			$product_info['is_primary_product']=$row['is_primary_product'];	
		}
		return $product_info;
	}
	/**
	 * @Author Anis Alamgir
	 * @return loan product short name 
	 * @Date: 12-03-2011
	 */
    function get_loan_product_short_name($product_id)
    {
		if(!is_numeric($product_id)) {
		    return FALSE;
		}
        $product_short_name = $this->db->query("SELECT short_name FROM loan_products WHERE id= $product_id LIMIT 1");			
		return $product_short_name->row()->short_name;  
    }
    /**
	 * @Author Anis Alamgir
	 * @return loan product code 
	 * @Date: 12-03-2011
	 */
    function get_loan_product_code($product_id)
    {
		if(!is_numeric($product_id)) {
		    return FALSE;
		}
        $product_short_name = $this->db->query("SELECT code FROM loan_products WHERE id= $product_id LIMIT 1");			
		return $product_short_name->row()->code;  
    } 
	/**
	 * @Author Anis Alamgir
	 * @return funding_organization_id 
	 * @Date: 12-03-2011
	 */
    function get_funding_organization_id_by_product($product_id)
    {
		if(!is_numeric($product_id)) {
		    return FALSE;
		}
        $funding_organization= $this->db->query("SELECT funding_organization_id FROM loan_products WHERE id= $product_id LIMIT 1");			
		return $funding_organization->row()->funding_organization_id;  
    }
	/*
	 * @uses member(add,edit)
	 * @Author: Anis Alamgir
	 * @Date: 15-02-2011
	 * @param $product_type = 'LOAN','SAVINGS','INSURANCE'
	 */	
	function get_product_list($product_type=null,$show_select=false)
	{       
		$product_type_condition = "";
		if(!empty($product_type)){
			$product_type_condition = " AND type = '$product_type' ";
		}
		$sql = "SELECT id,CONCAT(mnemonic,'-',name) as name FROM products WHERE product_status=1 $product_type_condition ";
		echo $sql;
		$sql=$this->db->query($sql); 
		$product_info=array();
		if($show_select){
			$product_info[""]="---Select---";
		}
		foreach ($sql->result_array() as $row)
		{
		   	$product_info[$row['id']]=$row['name'];	   
		}
		return $product_info;
	}
	/*
	 * @uses migrations_members for all loan type products
	 * @Author: Sheikh Imtiaz Hossain
	 * @Date: 20-02-2011
	 * @param $product_type = 'LOAN','SAVINGS','INSURANCE'
	*/	
	function get_loan_product_info()
	{		
		$this->db->select('id AS product_id, code AS product_code, mnemonic AS product_mnemonic, name AS product_name');		
		$this->db->where(array('products.is_deleted' => 0,'products.type' => 'LOAN'));
		$this->db->order_by('product_mnemonic','ASC');		
		$query = $this->db->get('loan_products');  
		return $query->result();
	}
	/**
	 * @Author Taposhi Rabeya
	 * @return loan product interest 
	 * @Date: 27-03-2011
	 */
    function get_loan_product_interest_rate($product_id)
    {
		if(!is_numeric($product_id)) {
		    return FALSE;
		}
        $product_interest_rate = $this->db->query("SELECT interest_rate FROM loan_products WHERE id=$product_id");			
		return $product_interest_rate->result();  
    }
    /*
     * @Author: Matin
	 * @Date: 29-03-2011   
     */
    function get_primary_loan_product_list($product_id='')
    {
        if(isset ($product_id) and !empty ($product_id))
        {
            $this->db->where('loan_products.id',$product_id);
        }
        $this->db->select('loan_products.id AS product_id, loan_products.code AS product_code, loan_products.short_name AS product_mnemonic, loan_products.name AS product_name,po_funding_organizations.name AS funding_org_name');
        $this->db->from('loan_products');
        $this->db->join('po_funding_organizations','loan_products.funding_organization_id = po_funding_organizations.id');
        $this->db->where('loan_products.is_primary_product','1');
		$this->db->order_by('product_mnemonic','ASC');
		return $this->db->get()->result();
    }
}
