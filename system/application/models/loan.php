<?php
/** 
	* Loan Model Class. 
	* @pupose		Manage Loan information
	*		
	* @filesource	\app\model\loan.php	
	* @package		microfin 
	* @subpackage	microfin.model.loan
	* @version      $Revision: 1 $
	* @author       $Author: Amlan Chowdhury $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Loan extends MY_Model {

    private $scheduler=null;
    
    function __construct()
    {
        parent::__construct();
    }
    
    function set_loan_scheduler(&$scheduler)
    {
		$this->scheduler=$scheduler;
	}
    
    function get_list_one_time_loans($offset,$limit,$cond=null)
    {
       	$this->db->select('loans.*,members.code AS member_code, members.name member_name');
		$this->db->from('loans');
		if(is_array($cond)){

			if(isset($cond['name']) and !empty($cond['name'])){
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%' OR loans.customized_loan_no LIKE '%{$cond['name']}%')";
   				$this->db->where($where);
			}
			if(isset($cond['samity']) and !empty($cond['samity'])){
				$this->db->where('loans.samity_id', $cond['samity']);
			}
			if(isset($cond['loan_status']) and !empty($cond['loan_status'])){
				$this->db->where('loans.current_status', $cond['loan_status']);
			}
		}
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->where(array('loans.branch_id'=> $this->auth->get_branch_id(),'loans.loan_type'=>'O'), $offset, $limit);
		$this->db->limit($offset, $limit);
                $this->db->orderby('member_code');
		$query = $this->db->get();
        return $query->result();
    }

	function row_count_one_time_loans($cond=null)
	{
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%' OR loans.customized_loan_no LIKE '%{$cond['name']}%')";
   				$this->db->where($where);
			}
			if(isset($cond['samity']) and !empty($cond['samity'])){
				$this->db->where('loans.samity_id', $cond['samity']);
			}
			if(isset($cond['loan_status']) and !empty($cond['loan_status'])){
				$this->db->where('loans.current_status', $cond['loan_status']);
			}
		}
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->where( array('loans.branch_id'=> $this->auth->get_branch_id(),'loans.loan_type'=>'O'));
		return $this->db->count_all_results('loans');
	}

        function get_list($offset,$limit,$cond=null) {
       	$this->db->select('loans.*,members.code AS member_code, members.name member_name');
		$this->db->from('loans');
		if(is_array($cond)){
		
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%' OR loans.customized_loan_no LIKE '%{$cond['name']}%')";
   				$this->db->where($where);	
			}	
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loans.samity_id', $cond['samity']);				
			}
			if(isset($cond['loan_status']) and !empty($cond['loan_status'])){	
				$this->db->where('loans.current_status', $cond['loan_status']);				
			}	
		}	
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->where(array('loans.branch_id'=> $this->auth->get_branch_id(),'loans.loan_type'=>'R'), $offset, $limit);
		$this->db->limit($offset, $limit);
            $this->db->orderby('member_code');
            $query = $this->db->get();
            return $query->result();
        }
	
	function row_count($cond=null){
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%' OR loans.customized_loan_no LIKE '%{$cond['name']}%')";
   				$this->db->where($where);	
			}
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loans.samity_id', $cond['samity']);				
			}
			if(isset($cond['loan_status']) and !empty($cond['loan_status'])){	
				$this->db->where('loans.current_status', $cond['loan_status']);				
			}		
		}
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->where( array('loans.branch_id'=> $this->auth->get_branch_id(),'loans.loan_type'=>'R'));
		return $this->db->count_all_results('loans');
	}
	
        function add($data)
        {
            $data['id'] = $loan_id = $this->get_new_id('loans','id');
            return $this->db->insert('loans', $data);
        }

        function edit($data)
        {
            return $this->db->update('loans', $data, array('id'=> $data['id']));
        }
	function read($loan_id)
        {
		$this->db->select('loans.*,members.id AS mid, members.name as member_name,loan_purposes.name as purpose_name, members.code as member_code,loan_products.short_name AS product_short_name,po_funding_organizations.name AS funding_organization_name');
		$this->db->from('loans');
		$this->db->join('members', 'loans.member_id = members.id','left');
                $this->db->join('loan_products','loans.product_id=loan_products.id');
                $this->db->join('loan_purposes','loans.purpose_id=loan_purposes.id');
                $this->db->join('po_funding_organizations','loan_products.funding_organization_id=po_funding_organizations.id');
		$this->db->where(array('loans.id' => $loan_id));
		$query = $this->db->get(); 
        return $query->row();   
        }
        function get_unauthorized_loan_list($offset,$limit,$cond=null){
                $this->db->select('loans.*,loan_products.short_name as mnemonic,members.code AS member_code, members.name member_name');
		$this->db->from('loans');
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->join('loan_products', 'loans.product_id = loan_products.id','left');
		$this->db->where(array('loans.is_authorized' => 0,'loans.branch_id'=> $this->auth->get_branch_id()));
		if(is_array($cond)){
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loans.samity_id', $cond['samity']);				
			}					
		}
		$this->db->limit($offset, $limit);	
		$query = $this->db->get(); 
                return $query->result();
        }
	function get_unauthorized_loan_list_row_count($cond=null){
                $this->db->select('count(loans.id) as id');
		$this->db->from('loans');
		$this->db->join('members', 'loans.member_id = members.id','left');
		$this->db->join('loan_products', 'loans.product_id = loan_products.id','left');
		$this->db->where(array('loans.is_authorized' => 0,'loans.branch_id'=> $this->auth->get_branch_id()));		
		if(is_array($cond)){
			if(isset($cond['samity']) and !empty($cond['samity'])){	
				$this->db->where('loans.samity_id', $cond['samity']);				
			}					
		}
		$query = $this->db->get(); 
                $query=$query->result();
		return $query[0]->id;    
    }
    function authorized($data){ 		
		$flag=0;
		foreach($data as $data)
		{ 			
			$this->db->update('loans', $data, array('id'=> $data['id']));  
			$flag=1;
		}
		if($flag==1)  
		{
			return true;   
		}
		else
		{
			return false;
		}
	}

	function read_as_array($loan_id){
		$this->db->select('id,branch_id,samity_id,product_id,member_id,loan_amount,interest_rate,mode_of_interest,number_of_installment,loan_period_in_month,interest_calculation_method,repayment_frequency,first_repayment_date,loan_closing_date');
		$this->db->from('loans');
		$this->db->where(array('id'=>$loan_id));
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function delete($loan_id)
	{		
		$this->db->delete('loans', array('id'=> $loan_id));		
		return true;
	}
	
        function get_product_list(){
                $sub_groups = $this->db->query("SELECT id,concat(mnemonic,' - ',name) as name FROM products where type = 'LOAN' ORDER BY name ASC");
		return $sub_groups->result();  
        }
    
	/**
	 * get_loan_product_list_by_member
	 * TODO : l.current_status = 1 means loan is not fullypaid ?????
	 */
        function get_loan_product_list_by_member($member_id,$is_multiple_loan_allowed_for_primary_products = null){
		$member_id = !is_numeric($member_id)?"-1":$member_id;
                /*
                 * Query for single primary product loan
                 */
                $single_primary_loan = "SELECT product_id,product_short_name,product_name,funding_organization_name FROM
                                (
                                (SELECT lp.id AS product_id,lp.short_name AS product_short_name,lp.name AS product_name,po_funding_organizations.name AS funding_organization_name
                                FROM loan_products AS lp
                                JOIN po_funding_organizations ON lp.funding_organization_id = po_funding_organizations.id
                                WHERE lp.is_primary_product=0)
                                UNION
                                (SELECT lp.id AS product_id, lp.short_name AS product_short_name, lp.name AS product_name,po_funding_organizations.name AS funding_organization_name
                                FROM loan_products AS lp
                                JOIN members ON members.primary_product_id=lp.id
                                JOIN po_funding_organizations ON lp.funding_organization_id = po_funding_organizations.id
                                WHERE members.id=$member_id)
                                ) AS all_products
        
                                WHERE product_id NOT IN (
                                SELECT product_id FROM loans AS l
                                JOIN loan_products AS lp ON l.product_id = lp.id
                                WHERE l.member_id = $member_id
                                AND lp.is_primary_product=1)";
                /*
                 * Query for multiple primary product loan
                 */
                $multiple_primary_loan = "SELECT loan_products.id AS product_id,loan_products.short_name AS product_short_name,loan_products.name AS product_name,po_funding_organizations.name as funding_organization_name
                                  FROM loan_products
                                  JOIN po_funding_organizations ON loan_products.funding_organization_id = po_funding_organizations.id
                                  ORDER BY product_short_name";
                if($is_multiple_loan_allowed_for_primary_products==0)
                {
                    $loan_products = $this->db->query($single_primary_loan);
                }
                if($is_multiple_loan_allowed_for_primary_products==1)
                {
                    $loan_products = $this->db->query($multiple_primary_loan);
                }
		return $loan_products->result();
    }
    //one time loan
    function get_one_time_loan_product_list_by_member($member_id,$is_multiple_loan_allowed_for_primary_products = null) {
                $member_id = !is_numeric($member_id)?"-1":$member_id;
                /*
                 * Query for single primary product loan
                 */
                $single_primary_loan = "SELECT product_id,product_short_name,product_name,funding_organization_name FROM
                                (
                                (SELECT lp.id AS product_id,lp.short_name AS product_short_name,lp.name AS product_name,po_funding_organizations.name AS funding_organization_name
                                FROM loan_products AS lp
                                JOIN po_funding_organizations ON lp.funding_organization_id = po_funding_organizations.id
                                WHERE lp.is_primary_product=0)
                                UNION
                                (SELECT lp.id AS product_id, lp.short_name AS product_short_name, lp.name AS product_name,po_funding_organizations.name AS funding_organization_name
                                FROM loan_products AS lp
                                JOIN members ON members.primary_product_id=lp.id
                                JOIN po_funding_organizations ON lp.funding_organization_id = po_funding_organizations.id
                                WHERE members.id=$member_id)
                                ) AS all_products

                                WHERE product_id NOT IN (
                                SELECT product_id FROM loans AS l
                                JOIN loan_products AS lp ON l.product_id = lp.id
                                WHERE l.member_id = $member_id
                                AND lp.is_primary_product=1)";
            /*
             * Query for multiple primary product loan
             */
            $multiple_primary_loan = "SELECT loan_products.id AS product_id,loan_products.short_name AS product_short_name,loan_products.name AS product_name,po_funding_organizations.name as funding_organization_name
                                  FROM loan_products
                                  JOIN po_funding_organizations ON loan_products.funding_organization_id = po_funding_organizations.id
                                  ORDER BY product_short_name";
            if($is_multiple_loan_allowed_for_primary_products==0)
            {
                $loan_products = $this->db->query($single_primary_loan);
            }
            if($is_multiple_loan_allowed_for_primary_products==1)
            {
                $loan_products = $this->db->query($multiple_primary_loan);
            }
            return $loan_products->result();
    }
    function get_po_funding_organizations_list(){
            $po_funding_organizations = $this->db->query("SELECT id,name FROM po_funding_organizations ORDER BY name ASC");
            return $po_funding_organizations->result();
    }
    function get_loan_info(){
            $this->db->select('id AS loan_id, customized_loan_no');
            $this->db->where('is_deleted','0');
            $this->db->order_by('customized_loan_no','ASC');
            $query = $this->db->get('loans');
            return $query->result();
    }
    function get_member_info($member_id='-1'){
            $member_id = !is_numeric($member_id)?"-1":$member_id;
            $member_loan_info = $this->db->query("SELECT id,name,code,branch_id,samity_id FROM members where id =$member_id limit 1");
            return $member_loan_info->row();
    }
    /**
     * TODO l.current_status ?????
     * TODO : l.current_status = 0 means loan is fullypaid
     *
     */
     function get_loan_cycle_by_product_and_member($product_id = -1,$member_id = -1){
            $product_id = !is_numeric($product_id)?"-1":$product_id;
            $member_id = !is_numeric($member_id)?"-1":$member_id;
            $loan_cycle_product_interest = $this->db->query("SELECT (IFNULL(MAX(l.cycle),0) + 1) AS cycle,lp.interest_rate AS interest_rate,lp.interest_calculation_method
                                                     FROM loans AS l , loan_products AS lp
                                                     WHERE lp.id = l.product_id AND l.product_id = $product_id AND l.member_id = $member_id  AND l.current_status = 1  LIMIT 1;");
            //print_r($loan_cycle_product_interest->result());die;
            return $loan_cycle_product_interest->row();
     }
        /**
     * @Added Anis Alamgir
     * @return loan current cycle
     */
    function get_max_loan_cycle_by_product_and_member($product_id,$member_id){
	if(!is_numeric($product_id) || !is_numeric($member_id)) {
		    return FALSE;
	}
        $loan_cycle = $this->db->query("SELECT (IFNULL(MAX(loans.cycle),0) + 1) AS cycle,0 AS interest_rate
				FROM loans 
				WHERE loans.product_id = $product_id AND loans.member_id = $member_id  LIMIT 1");
	return $loan_cycle->row()->cycle;  
    }
    
    function get_loan_code($code=null){
        $code = $this->db->query("SELECT customized_loan_no from loans where customized_loan_no='$code'");			
		$code=$code->result();
		if(!empty($code))
		{ 
			return $code[0]->customized_loan_no;
		}
		else 
		{  
			return $code="";
		}  
    }
    
    //===loan list for batch loan schedule
    
    private function _get_loan_list_by_branch($branch_id,$date_from,$date_to){
                $this->db->select('id,branch_id,samity_id,product_id,member_id,loan_amount,interest_rate,mode_of_interest,number_of_installment,loan_period_in_month,interest_calculation_method,repayment_frequency,first_repayment_date,loan_closing_date');
                $this->db->from('loans');
                $this->db->where(array('branch_id'=>$branch_id,'loans.is_deleted' => 0));
                $this->db->where("(loan_closing_date is null or loan_closing_date between $date_from and $date_to)" );
                $query = $this->db->get();
                $result=$query->result_array();
                $query->free_result();
                return $result;
    }
	
    private function _get_loan_list_by_samity($samity_id,$date_from,$date_to){
            $this->db->select('id,branch_id,samity_id,product_id,member_id,loan_amount,interest_rate,mode_of_interest,number_of_installment,loan_period_in_month,interest_calculation_method,repayment_frequency,first_repayment_date,loan_closing_date');
            $this->db->from('loans');
            $this->db->where(array('samity_id'=>$samity_id,'loans.is_deleted' => 0));
            $this->db->where("(loan_closing_date is null or loan_closing_date between $date_from and $date_to)" );
            $query = $this->db->get();
            $result = $query->result_array();
            $query->free_result();
            return $result;
    }
	
    //dummy data insertion
    function insert_loan_dummy_data(){
            $query = $this->db->query('select id,branch_id,samity_id from members where branch_id=2');
            foreach($query->result() as $member )
            {
                    $str="INSERT INTO loans (branch_id,samity_id,product_id,member_id,interest_calculation_method,loan_amount,interest_rate,number_of_installment,repayment_frequency,loan_period_in_month,mode_of_interest,purpose_id,first_repayment_date,funding_org_id)
                                            values ($member->branch_id,$member->samity_id,1,$member->id,'FLAT',10000,12.5,45,'WEEKLY',12,'YEARLY_PER_HUNDRED',1,'2010-01-01',1)";
                    $this->db->query($str);
            }
	}
    /*
     * @Author: Matin
     * @check wehter the loan is authorized or not
     * @Date : 31-03-2011
     */
    function is_authorized_loan($loan_id = null)
    {   
        $result =  $this->db->select('COUNT(id) as authorized_loan')->from('loans')->where(array('is_authorized'=>'1','id'=>$loan_id))->get()->result();        
        return $result[0]->authorized_loan;
    }
    /*
     * @Author: Matin
     * @check wehter the loan id is valid?
     * @Date : 31-03-2011
     */
    function is_valid_loan_id($loan_id = null)
    {
        $result =  $this->db->select('COUNT(id) as valid_loan_id')->from('loans')->where('id',$loan_id)->get()->result();
        return $result[0]->valid_loan_id;
    }
}
