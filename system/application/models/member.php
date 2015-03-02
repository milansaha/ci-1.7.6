<?php
/** 
	* Member Model Class. 
	* @pupose		Manage Member information
	*		
	* @filesource	\app\model\po_member.php	
	* @package		microfin 
	* @subpackage	microfin.model.po_member
	* @version      $Revision: 1 $
	* @author       $Author: Md. Kamrul Islam Liton $	
	* @lastmodified $Date: 2011-01-05 $	 
*/
    
class Member extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('auth');
    }
    
	function get_religious(){
		$output = array(
			''=>'--Select--',
			'christian'=>'Christian',
			'jews'=>'Jews',
			'buddist'=>'Buddist',
			'muslim'=>'Muslim',
			'hindus'=>'Hindus'
		);
		return $output;
	}
	
	function get_gender(){
		$output = array(''=>'--Select--','M'=>'Male','F'=>'Female');
		return $output;
	}
	
	
    function get_list($offset,$limit,$cond=null)
    {
 	// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%')";
   				$this->db->where($where);	
			}			
			if(isset($cond['cbo_branch']) and !empty($cond['cbo_branch'])){	
				$this->db->where('members.branch_id', $cond['cbo_branch']);				
			}			
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){	
				$this->db->where('members.samity_id', $cond['cbo_samity']);				
			}
		}
		// end search
	    $this->db->where('members.member_status !=', 'Inactive');	
	 	$this->db->select('members.id,members.name,members.code,members.fathers_spouse_name,members.gender,po_branches.id AS branch_id,po_branches.name AS branch_name,samities.id AS samity_id,samities.name AS samity_name');
		$this->db->from('members');
		$this->db->join('po_branches', 'members.branch_id = po_branches.id','left');
		$this->db->join('samities', 'members.samity_id = samities.id','left');		
		$this->db->limit($offset, $limit);		
		$this->db->order_by('members.code','ASC');
		$query = $this->db->get(); 
        return $query->result(); 

    }
	function row_count($cond='')
	{
		// search
		if(is_array($cond)){
			if(isset($cond['name']) and !empty($cond['name'])){	
				$where = "( members.code LIKE '%{$cond['name']}%' OR members.name LIKE '%{$cond['name']}%')";
   				$this->db->where($where);	
			}			
			if(isset($cond['cbo_branch']) and !empty($cond['cbo_branch'])){	
				$this->db->where('members.branch_id', $cond['cbo_branch']);
				
			}			
			if(isset($cond['cbo_samity']) and !empty($cond['cbo_samity'])){	
				$this->db->where('members.samity_id', $cond['cbo_samity']);
				
			}
		}
		// end search	
		
	    $this->db->where('members.member_status !=', 'Inactive');
		$this->db->join('po_branches', 'members.branch_id = po_branches.id','left');
		$this->db->join('samities', 'members.samity_id = samities.id','left');	
		return $this->db->count_all_results('members');
	}
    function get_member_detail($member_id = -1)
    {
    	$this->db->where('members.id', $member_id);
		$this->db->select('members.*,
							po_village_or_blocks.name AS villagename,
							po_unions_or_wards.name AS unionname,
							po_thanas.name AS thananame,
							po_districts.name AS districtname,
							po_branches.id AS branch_id,
							po_branches.name AS branch_name,
							samities.id AS samity_id,
							samities.name AS samity_name,
							samity_groups.id AS samity_group_id,
							samity_groups.name AS samity_group_name,
							samity_subgroups.id AS samity_subgroup_id,
							samity_subgroups.name AS samity_subgroup_name,
							po_working_areas.id AS working_area_id,
							po_working_areas.name AS working_area_name,
							loan_products.name as product_name,
							loan_products.short_name as product_mnemonic');
		$this->db->from('members');
		$this->db->join('po_branches', 'members.branch_id = po_branches.id','left');
		$this->db->join('samities', 'members.samity_id = samities.id','left');
		$this->db->join('samity_groups', 'members.group_id = samity_groups.id','left');
		$this->db->join('samity_subgroups', 'members.sub_group_id = samity_subgroups.id','left');
		$this->db->join('po_working_areas', 'members.working_area_id = po_working_areas.id','left');
		$this->db->join('loan_products', 'members.primary_product_id = loan_products.id','left');
		
		$this->db->join('po_village_or_blocks', 'members.permanent_village_ward = po_village_or_blocks.id','left');
		$this->db->join('po_unions_or_wards', 'po_unions_or_wards.id = po_village_or_blocks.union_or_ward_id','left');
		$this->db->join('po_thanas', 'po_thanas.id = po_village_or_blocks.thana_id','left');
		$this->db->join('po_districts', 'po_districts.id = po_village_or_blocks.district_id','left');		
		
		
		
		$this->db->limit(1);
		$query = $this->db->get(); 
        return $query->row();

    }
    
    function get_member_view_detail($member_id = -1)
    {
    	$this->db->where('members.id', $member_id);
		$this->db->select('members.*,
							po_village_or_blocks.name AS villagename,
							po_unions_or_wards.name AS unionname,
							po_thanas.name AS thananame,
							po_districts.name AS districtname,
							po_branches.id AS branch_id,
							po_branches.name AS branch_name,
							samities.id AS samity_id,
							samities.name AS samity_name,
							samity_groups.id AS samity_group_id,
							samity_groups.name AS samity_group_name,
							samity_subgroups.id AS samity_subgroup_id,
							samity_subgroups.name AS samity_subgroup_name,
							po_working_areas.id AS working_area_id,
							po_working_areas.name AS working_area_name,
							loan_products.name as product_name,
							loan_products.short_name as product_mnemonic,
							educational_qualifications.name as educational_qualifications_name');
		$this->db->from('members');
		$this->db->join('po_branches', 'members.branch_id = po_branches.id','left');
		$this->db->join('samities', 'members.samity_id = samities.id','left');
		$this->db->join('samity_groups', 'members.group_id = samity_groups.id','left');
		$this->db->join('samity_subgroups', 'members.sub_group_id = samity_subgroups.id','left');
		$this->db->join('educational_qualifications', 'members.last_achieved_degree = educational_qualifications.id','left');
		
		$this->db->join('po_working_areas', 'members.working_area_id = po_working_areas.id','left');
		$this->db->join('loan_products', 'members.primary_product_id = loan_products.id','left');
		
		$this->db->join('po_village_or_blocks', 'members.permanent_village_ward = po_village_or_blocks.id','left');
		$this->db->join('po_unions_or_wards', 'po_unions_or_wards.id = po_village_or_blocks.union_or_ward_id','left');
		$this->db->join('po_thanas', 'po_thanas.id = po_village_or_blocks.thana_id','left');
		$this->db->join('po_districts', 'po_districts.id = po_village_or_blocks.district_id','left');		
		$this->db->limit(1);
		$query = $this->db->get(); 
        return $query->row();

    }
	
	
    function add($data)
    {
		$data['id']=$this->get_new_id('members', 'id');
        return $this->db->insert('members', $data);
    }

    function edit($data)
    {
        return $this->db->update('members', $data, array('id'=> $data['id']));
    }
	
	function read($Member_id)
    {
        $query=$this->db->getwhere('members', array('id' => $Member_id),1);
		return $query->row();
    }
	
	function delete($Member_id)
	{
		return $this->db->delete('members', array('id'=> $Member_id));
	}

	function get_member_list()
    {
        $members = $this->db->query("SELECT id,name FROM members ORDER BY name ASC");			
		return $members->result();  
    }

	function get_working_area_list()
    {
        $working_areas = $this->db->query("SELECT id,name FROM po_working_areas ORDER BY name ASC");			
		return $working_areas->result();  
    }
	function get_branch_list()
    {
        $branches = $this->db->query("SELECT id,name FROM po_branches ORDER BY name ASC");			
		return $branches->result();  
    }	
	function get_group_list($samity_id=-1)
    {
    	$samity_id = (empty($samity_id))?"-1":$samity_id;
        $groups = $this->db->query("SELECT id,name FROM samity_groups where samity_id = $samity_id ORDER BY name ASC");			
		return $groups->result();  
    }

	function get_sub_group_list($samity_group_id=-1)
    {
    	$samity_group_id = (empty($samity_group_id))?"-1":$samity_group_id;
        $sub_groups = $this->db->query("SELECT id,name FROM samity_subgroups where group_id = $samity_group_id  ORDER BY name ASC");			
		return $sub_groups->result();  
    }
	//Added By Matin
	function get_member_info()
	{		
		$this->db->select('id AS member_id, name AS member_name,code as member_code');		
		$this->db->order_by('member_name','ASC');		
		$query = $this->db->get('members');  
		return $query->result();	
	}
	function get_working_area_info($working_area_id)
    {
        $this->db->select('po_working_areas.id, po_working_areas.name,po_village_or_blocks.name as village_name,po_thanas.name as thana_name,po_districts.name as district_name');
		$this->db->from('po_working_areas');
		$this->db->join('po_village_or_blocks', 'po_village_or_blocks.id = po_working_areas.village_or_block_id');
		$this->db->join('po_thanas', 'po_thanas.id = po_village_or_blocks.thana_id');
		$this->db->join('po_districts', 'po_districts.id = po_village_or_blocks.district_id');
		$this->db->where('po_working_areas.id',$working_area_id);	
		$this->db->limit(1);		
		$query = $this->db->get();  
		return $query->row();
    }
	// ajax based function calling for member_products
    function get_member_list_auto($search_key='')
    {
    	$user = $this->session->userdata('system.user');
    	$branch_id = $user['branch_id'];
    	$where_branch_id = is_numeric($branch_id)?" AND members.branch_id = $branch_id":"";
    	$search_key = TRIM($search_key);
		$groups = $this->db->query("SELECT `members`.`id`, CONCAT(`members`.`name`,' - ',`members`.`code`) AS name, `members`.`fathers_spouse_name`, 
						`members`.`mothers_name`, 
						 members.primary_product_id as member_primary_product_id,
						`po_branches`.`id` AS branch_id, `po_branches`.`name` AS branch_name, 
						`samities`.`id` AS samity_id, `samities`.`name` AS samity_name, 
						`samity_groups`.`id` AS samity_group_id, `samity_groups`.`name` AS samity_group_name, 
						`samity_subgroups`.`id` AS samity_subgroup_id, `samity_subgroups`.`name` AS samity_subgroup_name,
						 `po_working_areas`.`id` AS working_area_id, `po_working_areas`.`name` AS working_area_name, `members`.`member_type`, `members`.`primary_product_id`
						FROM (`members`)
						LEFT JOIN `po_branches` ON `members`.`branch_id` = `po_branches`.`id`
						LEFT JOIN `samities` ON `members`.`samity_id` = `samities`.`id`
						LEFT JOIN `samity_groups` ON `members`.`group_id` = `samity_groups`.`id`
						LEFT JOIN `samity_subgroups` ON `members`.`sub_group_id` = `samity_subgroups`.`id`
						LEFT JOIN `po_working_areas` ON `members`.`working_area_id` = `po_working_areas`.`id`
						WHERE (TRIM(`members`.`name`)  LIKE '%$search_key%' OR TRIM(`members`.`code`)  LIKE '%$search_key%')  AND member_status <> 'Inactive' $where_branch_id
						LIMIT 10");			
		return $groups->result();
    }    
	// ajax based function calling for migration_members
	function get_samity_type_status_auto($samity_id = NULL)
    {
    	$user = $this->session->userdata('system.user');
    	$branch_id = $user['branch_id'];
    	$where_branch_id = is_numeric($branch_id)?" AND members.branch_id = $branch_id":"";
    	$search_key = TRIM($search_key);
		$groups = $this->db->query("SELECT `members`.`id`, CONCAT(`members`.`name`,' - ',`members`.`code`) AS name, `members`.`fathers_name`, 
						`members`.`mothers_name`, 
						members.primary_product_id as member_primary_product_id,
						`po_branches`.`id` AS branch_id, `po_branches`.`name` AS branch_name, 
						`samities`.`id` AS samity_id, `samities`.`name` AS samity_name, 
						`samity_groups`.`id` AS samity_group_id, `samity_groups`.`name` AS samity_group_name, 
						`samity_subgroups`.`id` AS samity_subgroup_id, `samity_subgroups`.`name` AS samity_subgroup_name,
						 `po_working_areas`.`id` AS working_area_id, `po_working_areas`.`name` AS working_area_name, `members`.`member_type`, `members`.`primary_product_id`
						FROM (`members`)
						LEFT JOIN `po_branches` ON `members`.`branch_id` = `po_branches`.`id`
						LEFT JOIN `samities` ON `members`.`samity_id` = `samities`.`id`
						LEFT JOIN `samity_groups` ON `members`.`group_id` = `samity_groups`.`id`
						LEFT JOIN `samity_subgroups` ON `members`.`sub_group_id` = `samity_subgroups`.`id`
						LEFT JOIN `po_working_areas` ON `members`.`working_area_id` = `po_working_areas`.`id`
						WHERE (TRIM(`members`.`name`)  LIKE '%$search_key%' OR TRIM(`members`.`code`)  LIKE '%$search_key%')  AND member_status <> 'Inactive' $where_branch_id
						LIMIT 10");			
		return $groups->result();
    }
	
    function get_member_loan_info($member_id,$status = 1,$transaction_date=null)
    {
			if(!is_numeric($member_id)) {
				return false;
			}
			$transaction_date_condition = "";
			if(!empty($transaction_date)){
				$transaction_date_condition = " AND lt.transaction_date = '$transaction_date'";
			}
			 $member_loan_info = $this->db->query("SELECT m.id AS member_id, m.name AS member_name, l.id AS loan_id, l.customized_loan_no AS customized_loan_no , IFNULL(l.loan_amount,0) AS loan_amount
				, IFNULL(l.interest_rate,0) AS interest_rate , IFNULL(l.interest_amount,0) AS interest_amount,IFNULL(l.discount_interest_amount,0) AS discount_interest_amount 
				,IFNULL(l.cycle,0)  AS loan_cycle , IFNULL(l.total_payable_amount,0) AS total_payable_amount , IFNULL(l.number_of_installment,0) AS number_of_installment

				,l.current_status, IFNULL(SUM(lt.transaction_amount),0) AS total_repayment_amount, MAX(lt.transaction_date) AS last_repayment_date
				,IFNULL(MAX(lt.installment_number),0) AS last_installment_number
				FROM members  AS m
				INNER JOIN loans AS l ON l.member_id = m.id
				LEFT JOIN loan_transactions AS lt ON (lt.loan_id = l.id )
				WHERE 
				m.id = $member_id AND l.current_status = $status $transaction_date_condition
				GROUP BY l.id");			
		return $member_loan_info->result();

    }
    function get_member_saving_info($member_id,$status = 1,$transaction_date=null)
    {
    	if(!is_numeric($member_id)) {
			return false;
		}
    	
		$transaction_date_condition = "";
		if(!empty($transaction_date)){
			$transaction_date_condition = " AND ( sd.transaction_date = '$transaction_date' OR sw.transaction_date = '$transaction_date' )";
		}
		$member_loan_info = $this->db->query("SELECT m.id AS member_id, m.name AS member_name, s.id AS saving_id, s.code AS saving_code ,s.funding_organization_id, s.opening_date , 
					s.weekly_savings,s.current_status,IFNULL(SUM(sd.amount),0) AS deposit_amount,IFNULL(SUM(sw.amount),0) AS withdraw_amount,p.id AS product_id, p.short_name AS product_mnemonic
					FROM members  AS m
					INNER JOIN savings AS s ON (s.member_id = m.id )
					LEFT JOIN saving_deposits AS sd ON (sd.savings_id = s.id)
					LEFT JOIN saving_withdraws AS sw ON (sw.savings_id = s.id)
					INNER JOIN saving_products AS p ON (p.id = s.saving_products_id)
					WHERE 
					m.id = $member_id AND s.current_status = $status $transaction_date_condition
					GROUP BY s.id;");			
		return $member_loan_info->result();

    }
    function get_member_samity_info($member_id='-1')
    {
			 $member_loan_info = $this->db->query("SELECT m.id AS member_id, m.name AS member_name, m.code AS member_code, s.id AS samity_id, s.code AS samity_code
					, s.name AS samity_name, wa.name AS working_area_name, wa.id AS working_area_id,vb.name AS village_name,b.id AS branch_id,b.name AS branch_name,p.id AS product_id,p.short_name AS product_mnemonic,p.name AS product_name,fo.name AS funding_org_name
					FROM members  AS m
					INNER JOIN samities AS s ON (s.id = m.samity_id )
					INNER JOIN po_branches AS b ON (b.id = m.branch_id)
					INNER JOIN po_working_areas AS wa ON (wa.id = s.working_area_id)
					INNER JOIN po_village_or_blocks AS vb ON (vb.id = wa.village_or_block_id)
					LEFT JOIN loan_products as p ON (p.id = m.primary_product_id)
                    LEFT JOIN po_funding_organizations as fo ON (fo.id = p.funding_organization_id)
					WHERE 
					m.id =$member_id");			
		return $member_loan_info->result();

    }
    
/**
 * get_active_member_list_by_samity_id
 * @auth Anis
 * @date 02-feb-2011 
 * @return return false if samity is empty otherwise return active member list. 
 */
 	function get_active_member_list_by_samity_id_csv($samity_id,$primary_product_id=null) {
 		
 		$primary_product_cond = ( !empty($primary_product_id) && is_numeric($primary_product_id) ) ? " AND primary_product_id = $primary_product_id ":"";
 		
		if( isset($samity_id) && is_numeric($samity_id) ) {
			$active_members = $this->db->query("SELECT id FROM members WHERE member_status = 'Active' AND samity_id = $samity_id $primary_product_cond;");
			
			$active_members = $active_members->result();
			$active_member_list=array();
			foreach($active_members as $active_member){
				$active_member_list[] = $active_member->id;
			}
			
			$active_member_list = join(',',$active_member_list);
			
			return $active_member_list;
		}
		return false;
	}
	//Samity Wise Monthly Loan & Saving Collection Sheet Report 
	function get_active_member_list_array_by_samity_id_csv($samity_id,$primary_product_id=null) {
 		
 		$primary_product_cond = ( !empty($primary_product_id) && is_numeric($primary_product_id) ) ? " AND primary_product_id = $primary_product_id ":"";
 		
		if( isset($samity_id) && is_numeric($samity_id) ) {
			$active_members = $this->db->query("SELECT id FROM members WHERE member_status = 'Active' AND samity_id = $samity_id $primary_product_cond;");
			
			$active_members = $active_members->result();
			$active_member_list=array();
			foreach($active_members as $active_member){
				$active_member_list[] = $active_member->id;
			}		
			return $active_member_list;
		}
		return false;
	}
	
	function get_member_registration_date($member_id)
	{		
		if(!is_numeric($member_id)) {
			return false;
		}
		$registration_date = $this->db->query("SELECT registration_date FROM members where id = $member_id limit 1");		
		return $registration_date->row()->registration_date;  
    }
    
    function get_member_last_transaction_date($member_id)
	{		
		if(!is_numeric($member_id)) {
			return false;
		}
		$date = $this->db->query("SELECT MAX(transaction_date) AS transaction_date  FROM (
							SELECT MAX(transaction_date) AS transaction_date FROM saving_withdraws WHERE member_id= $member_id LIMIT 1
							UNION ALL
							SELECT MAX(transaction_date) AS transaction_date FROM saving_deposits WHERE member_id= $member_id LIMIT 1
							UNION ALL 
							SELECT MAX(last_repayment_date) AS transaction_date FROM loans WHERE member_id= $member_id LIMIT 1
							) saving_transactions;");		
		return $date->row()->transaction_date;  
    }
    function member_closing_read($member_closing_id)
    {
        $query=$this->db->getwhere('member_closing', array('id' => $member_closing_id),1);
		return $query->row();
    }
    	
	/**
	 * 	Get member Code
	 *	@auth Anis Alamgir
	 * 	@return	string
	 */
	function get_member_code($member_id)
	{
		$user=$this->session->userdata('system.user');
		$sql = "SELECT code FROM members WHERE id = ? LIMIT 1;";
		$sql=$this->db->query($sql, array($member_id)); 
		return $sql->row()->code;
	}
    /*
     * Author: Matin
     * Date: 02-05-4-2011
     */
    function get_member_info_by_samity_id($samity_id=null)
    {
        if ( isset($samity_id) and ! empty($samity_id) and $samity_id!=-1)
        {
            $this->db->where('members.samity_id',$samity_id);
        }
        elseif ( isset($samity_id) and ! empty($samity_id) and $samity_id=-1)
        {
            $this->db->where('members.branch_id',$this->auth->get_branch_id());
        }

        $this->db->select('members.*,samities.name AS samity_name,samities.code AS samity_code');
        $this->db->from('members');
        $this->db->join('samities','members.samity_id=samities.id');
        $this->db->order_by('members.samity_id','ASC');
        return $this->db->get()->result();
    }

/**
 * member_wise_subsidy_loan_saving_ledger_index
 * @auth taposhi
 * @date 09-Apr-2011 
 * @return member list
 */
 	function get_member_list_by_branch() {
 		
 		$branch_id=$this->auth->get_branch_id();
		if( isset($branch_id) && is_numeric($branch_id) ) {
			$members = $this->db->query("SELECT id as member_id,name as member_name FROM members WHERE branch_id = $branch_id order by name asc");			
			$members = $members->result();						
			return $members;
		}
		return false;
	}
}