<?php
/** 
	* Samity Model Class.
	* @pupose		Employee Designation information
	*		
	* @filesource	./system/application/models/samity.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.samity
	* @version      $Revision: 1 $
	* @author       $Author: S. Abdul Matin $	
	* @lastmodified $Date: 2011-01-05 $	 
*/ 
class Samity extends MY_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
		$this->load->library('auth');	
    }
    
    function get_list($offset,$limit,$cond=null)
    {       
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				if(is_numeric($cond['name'])){	
					$this->db->like('samities.code', $cond['name']);	
				} else {
					$this->db->like('samities.name', $cond['name']);					
				}
				
			}
			if(isset($cond['branchname']) and !empty($cond['branchname']) and $cond['branchname'] != -1){	
				$this->db->where('samities.branch_id', $cond['branchname']);
				
			}		
		}
        $this->db->select('samities.id,samities.name,samities.code,samities.samity_day,samities.samity_type,samities.opening_date,samities.branch_id,samities.status AS current_status,employees.name AS field_officer_name');
        $this->db->from('samities');
        $this->db->join('employees','samities.field_officer_id=employees.id');
		$this->db->limit($offset, $limit);		
        $this->db->order_by('code','ASC');
		$query = $this->db->get(); 
        return $query->result(); 
    }
	
	function row_count($cond=null)
	{
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				if(is_numeric($cond['name'])){	
					$this->db->or_where('samities.code', $cond['name']);	
				} else {
					$this->db->like('samities.name', $cond['name']);					
				}
			}	
		if(isset($cond['branchname']) and !empty($cond['branchname']) and $cond['branchname'] != -1){	
				$this->db->where('samities.branch_id', $cond['branchname']);
				
			}	
		}
        $this->db->from('samities');
		return $this->db->count_all_results();
	}
	
    function add($data)
    {
		//The first param->Table Name, 2nd Param: id field
		$data['id'] = $this->get_new_id('samities', 'id');
        return $this->db->insert('samities', $data);
    }

    function edit($data)
    {
        return $this->db->update('samities', $data, array('id'=> $data['id']));
    }
	
	function read($samity_id)
    {
        //query=$this->db->getwhere('samities', array('id' => $samity_id));
		$this->db->select('po_working_areas.name as working_area_name,employees.name as employee_name,loan_products.short_name,samities.*');
		$this->db->from('samities');
		$this->db->join('po_working_areas', 'samities.working_area_id = po_working_areas.id');
		$this->db->join('employees', 'samities.field_officer_id = employees.id');
		$this->db->join('loan_products', 'samities.product_id = loan_products.id','LEFT');
        $this->db->where(array('samities.id' =>$samity_id));	        
		$query = $this->db->get(); 
		return $query->row();
    }
	
	function delete($samity_id)
	{
		return $this->db->delete('samities', array('id'=> $samity_id));
	}	
	/**
 * @name get_samities
 * @uses 
 * @lasUpdatedBy Anis Alamgir
 * @lastDate 20-Jan-2010  
 */	
	function get_samities()
	{	
		$samity_info = $this->db->query("SELECT id as samity_id,CONCAT(code,'(',name,')')  as samity_name FROM samities ORDER BY samity_name ASC");  
		return $samity_info->result();	
	}
	
/**
 * @name get_samity_list_by_branch
 * @uses member(add,edit)
 * @lasUpdatedBy Anis Alamgir
 * @lastDate 20-Jan-2010  
 */
	function get_samity_list_by_branch($branch_id,$samity_day = null)
	{		
		$samity_day_cond = "";
		if(!is_numeric($branch_id)) {
			return false;
		}
		if(is_string($samity_day) and !empty($samity_day)) {
			$samity_day_cond = " AND samity_day = '$samity_day' ";
		}
		$samity_info = $this->db->query("SELECT id as samity_id,CONCAT(code,' - ',name)  as samity_name FROM samities where branch_id = $branch_id $samity_day_cond ORDER BY samity_name ASC");			
		return $samity_info->result();  
    }
    function get_samity_type_by_samity_id($samity_id)
	{		
		if(!is_numeric($samity_id)) {
			return false;
		}
		$samity_info = $this->db->query("SELECT samity_type FROM samities where id = $samity_id limit 1");		
		return isset($samity_info->row()->samity_type)?$samity_info->row()->samity_type:false;  
    }
    
    function get_samity_created_date($samity_id)
	{		
		if(!is_numeric($samity_id)) {
			return false;
		}
		$created_date = $this->db->query("SELECT opening_date FROM samities where id = $samity_id limit 1");
		return $created_date->row()->opening_date;
    }
	function get_samity_list_auto_search($search_key = null)
    {
			 $search_key = trim($search_key);
			 $groups = $this->db->query("SELECT s.id AS samity_id, s.code AS samity_code , s.name AS samity_name, wa.name AS working_area_name
										,vb.name AS village_name, th.name AS thana_name, d.name AS district_name, s.branch_id as branch_id
										FROM 
										samities AS s 
										INNER JOIN po_working_areas AS wa ON (wa.id = s.working_area_id)
										INNER JOIN po_village_or_blocks AS vb ON (vb.id = wa.village_or_block_id)
										INNER JOIN po_thanas AS th ON (th.id = vb.thana_id)
										INNER JOIN po_districts AS d ON (d.id = vb.district_id)
										WHERE (TRIM(s.name) LIKE '%$search_key%' OR TRIM(s.code) LIKE '%$search_key%') LIMIT 10");			
		return $groups->result();

    }
    /**
 * @uses member_transfers(add,edit),report
 */
    function get_branch_samity_field_officer_info_by_samity_id_report($samity_id)
	{		
		if(!is_numeric($samity_id)) {
			return false;
		}
		$samity_info = $this->db->query("SELECT s.id AS samity_id, s.code AS samity_code, s.name AS samity_name,s.skt_amount 
									, b.id AS branch_id, b.code AS branch_code , b.name AS branch_name
									, e.id AS field_officer_id, e.code AS field_officer_code , e.name AS field_officer_name
									, p.id AS product_id, p.name AS product_name, p.short_name AS product_mnemonic
									FROM samities AS s
									LEFT JOIN po_branches AS b ON (b.id = s.branch_id)
									LEFT JOIN employees AS e ON (e.id = s.field_officer_id)
									LEFT JOIN loan_products AS p ON (p.id = s.product_id)
									WHERE s.id = $samity_id LIMIT 1");			
		return $samity_info->result();  
    }
	/*
	 * @uses Regular_and_general_report(Field worker's report)
	 * @Author: Taposhi Rabeya
	 * @Date: 07-02-2011
	 */
	function get_previous_samity_list($employee_id=null,$branch_id=null,$from_date=null,$to_date=null)
	{
		$previous_samity_list_sql ="SELECT id,code,name
				FROM
				(
					SELECT samities.id,samities.code,samities.name
					FROM samities JOIN employees ON samities.field_officer_id=employees.id
					WHERE samities.opening_date<=? AND samities.branch_id=?
					AND field_officer_id=? AND samities.id 
					AND samities.is_deleted=0 AND samities.status=1 AND samities.id
					NOT IN (
					SELECT new_samity_id
					FROM employee_histories
					WHERE id IN (SELECT MAX(id)
					FROM employee_histories WHERE employee_histories.employee_id=?
					AND type_of_operation='Samity Change'
					AND date_of_operation BETWEEN ? AND ?))

					UNION ALL 

					SELECT old_samity_id AS id,samities.code,samities.name
					FROM samities LEFT JOIN employee_histories ON samities.id=employee_histories.new_samity_id
					WHERE samities.is_deleted=0 AND samities.status=1
					AND employee_histories.id IN (
						SELECT MAX(id)
						FROM employee_histories 
						WHERE employee_histories.employee_id=?
						AND type_of_operation='Samity Change'
						AND date_of_operation BETWEEN ? AND ?)
				) AS samity_list
				ORDER BY samity_list.id";
		$previous_samity_list_sql=$this->db->query($previous_samity_list_sql, array($from_date,$branch_id,$employee_id,$employee_id,$from_date,$to_date,$employee_id,$from_date,$to_date));					
		$previous_samity_list=array();
		$i=0;
		foreach ($previous_samity_list_sql->result_array() as $previous_samity_list_row)
		{	
			$i++;					
			$previous_samity_list[$i]['samity_id']=$previous_samity_list_row['id'];	
			$previous_samity_list[$i]['samity_code']=$previous_samity_list_row['code'];
			$previous_samity_list[$i]['samity_name']=$previous_samity_list_row['name'];
		}
		//echo "<pre>";print_r($previous_samity_list);die;
		return $previous_samity_list;	
	}
	function get_current_samity_list($employee_id=null,$branch_id=null,$to_date=null)
	{
		$current_samity_list_sql ="SELECT samities.id,samities.code,samities.name
			FROM samities JOIN employees ON samities.field_officer_id=employees.id
			WHERE samities.opening_date<=?
			AND samities.branch_id=?
			AND field_officer_id=? 
			AND samities.is_deleted=0 AND samities.status=1";
		$current_samity_list_sql=$this->db->query($current_samity_list_sql, array($to_date,$branch_id,$employee_id));					
		$current_samity_list=array();
		$i=0;
		foreach ($current_samity_list_sql->result_array() as $current_samity_list_row)
		{	
			$i++;					
			$current_samity_list[$i]['samity_id']=$current_samity_list_row['id'];	
			$current_samity_list[$i]['samity_code']=$current_samity_list_row['code'];
			$current_samity_list[$i]['samity_name']=$current_samity_list_row['name'];
		}
		//echo "<pre>";print_r($current_samity_list);die;
		return $current_samity_list;	
	}
	function get_samity_member_count($samity_id=null,$opening_date=null)
	{
		$samity_member_list_sql ="SELECT count(id) as members FROM members WHERE samity_id=? AND members.registration_date<=?";
		$samity_member_list_sql=$this->db->query($samity_member_list_sql, array($samity_id,$opening_date));					
		$samity_member_count="";
		$i=0;
		foreach ($samity_member_list_sql->result_array() as $samity_member_list_row)
		{	
				$samity_member_count=$samity_member_list_row['members'];		
		}		
		return $samity_member_count;	
	}
	function get_samity_list($branch_id=null)
    {
        $branch_id = (empty($branch_id))?$this->auth->get_branch_id():$branch_id;       
		//$samities = $this->db->query("SELECT id,name FROM samities ORDER BY name ASC");
		$samities = $this->db->query("SELECT id ,CONCAT(code,' - ',name)  as name FROM samities where samities.closing_date IS NULL AND branch_id = $branch_id ORDER BY code ASC");
		return $samities->result();  
    }
    /*
     * @Author: Matin
     * @Date: 02-04-2011
     */
    function get_all_samity_list_by_branch($branch_id=null)
    {
        $branch_id = (empty($branch_id))?$this->auth->get_branch_id():$branch_id;		
		$samities = $this->db->query("SELECT id ,CONCAT(code,' - ',name)  as name FROM samities where samities.closing_date IS NULL AND branch_id = $branch_id ORDER BY code ASC");
		return $samities->result();
    }
	function get_samity_list_auto($search_key='')
    {
    	$user=$this->session->userdata('system.user');
    	$branch_id = $user['branch_id'];
    	$where_branch_id = is_numeric($branch_id)?" AND samities.branch_id = $branch_id":"";    	
    	$search_key = TRIM($search_key);    	
		$samity_info = $this->db->query("SELECT `samities`.`id` AS samity_id, `samities`.`name` AS samity_name
			,`samities`.`code` as samity_code,`samities`.`samity_day` as samity_day
			FROM (`samities`)
			WHERE (TRIM(`samities`.`name`)  LIKE '%$search_key%' OR TRIM(`samities`.`code`)  LIKE '%$search_key%')  
			$where_branch_id
			LIMIT 10");			
		return $samity_info->result();
    }
	function get_samity_info($samity_id='-1')
    {
		$samity_info = $this->db->query("SELECT `samities`.`id` AS samity_id, `samities`.`name` AS samity_name,`skt_amount` AS skt_amount
			,`samities`.`code` as samity_code,`samities`.`samity_day` as samity_day
			FROM (`samities`)
			WHERE samities.id =$samity_id");			
		return $samity_info->result();
    }
	/*
	 * @uses Samity day change
	 * @Author: Taposhi Rabeya
	 * @Date: 13-02-2011
	 */
	function get_samity_opening_date($samity_id=null,$opening_date=null)
    {
		$samity_list_sql ="SELECT count(opening_date) as opening_date FROM samities WHERE id=? AND opening_date<=?";
		$samity_list_sql=$this->db->query($samity_list_sql, array($samity_id,$opening_date));					
		$samity_opening_date="";		
		foreach ($samity_list_sql->result_array() as $samity_list_row)
		{	
				$samity_opening_date=$samity_list_row['opening_date'];		
		}		
		return $samity_opening_date;
    }	
	/**
	 * 	Get branch Code
	 *	@auth Anis Alamgir
	 * 	@return	string
	 */
	function get_samity_code($samity_id)
	{
		if(!is_numeric($samity_id)){
			return false;
		}
		$user=$this->session->userdata('system.user');
		$sql = "SELECT code FROM samities WHERE id = ? LIMIT 1;";
		$sql=$this->db->query($sql, array($samity_id)); 
		return isset($sql->row()->code)?$sql->row()->code:false;
	}

    function get_closed_samity_list($offset,$limit,$branch_id=null)
    {
        if(isset ($branch_id) and !empty ($branch_id) and is_numeric($branch_id))
        {
            $this->db->where('samities.branch_id', $branch_id);
        }
        $this->db->select('samities.*,employees.name AS field_officer_name');
        $this->db->from('samities');
        $this->db->join('employees','samities.field_officer_id=employees.id');
        $this->db->where('samities.status','0');
		$this->db->limit($offset, $limit);
        $this->db->order_by('code','ASC');
		$query = $this->db->get();
        return $query->result();    
    }
    function count_closed_samity($branch_id=null)
	{
		if(isset ($branch_id) and !empty ($branch_id) and is_numeric($branch_id))
        {
            $this->db->where('samities.branch_id', $branch_id);
        }
        $this->db->from('samities');       
        $this->db->where('samities.status','0');
		return $this->db->count_all_results();
	}
    /*
     * @Added By: Matin
     * @Purpose : Returns samity opening date
     * @Use: Useed in Samity_closings controller
     * @Modification Date: 29-03-2011
     */
    function check_samity_opening_date_is_greater_than_closing_date($samity_id)
    {
        if ( isset($samity_id) and ! empty($samity_id))
        {
            $query = $this->db->select('opening_date')->from('samities')->where(array('id' =>$samity_id))->get();
            return $query->row()->opening_date;
        }
        
    }
    /*
     * Author: Matin
     * Date: 02-05-4-2011
     */
    function get_samities_by_branch_id($branch_id=null)
    {
        if ( isset($branch_id) and ! empty($branch_id) and $branch_id!=-1)
        {
            $this->db->where('branch_id',$branch_id);
        }
        $this->db->select('samities.*,po_branches.name as branch_name,po_branches.code as branch_code,po_branches.address as branch_address');
        $this->db->from('samities');
        $this->db->join('po_branches','samities.branch_id=po_branches.id');
        $this->db->order_by('samities.branch_id','ASC');
        return $this->db->get()->result();
    }
}
