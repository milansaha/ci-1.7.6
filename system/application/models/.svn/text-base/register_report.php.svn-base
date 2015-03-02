<?php
/** 
	*  Register_report Model Class.
	* @pupose		Register_report information
	*		
	* @filesource	./system/application/models/register_report.php	
	* @package		microfin 
	* @subpackage	microfin.system.application.models.register_report
	* @version      $Revision: 1 $
	* @author       $Author: Taposhi Rabeya $	
	* @lastmodified $Date: 2011-01-26 $	 
*/ 
class Register_report extends MY_Model {
    
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->library('Scheduler1');
	} 
	// ****************************************************************************Admission Register Report****************************************************************************
	function get_admission_register_information($branch_id=null,$from_date=null,$to_date=null)
	{
		
		//Modified Admission Register by Liton '6/04/2011'
		//Collected samities id according to branch that is provided from UI
		$samity_info_sql="SELECT samities.id as samities_id,samities.branch_id,samities.code as samity_code,
							samities.name as samity_name FROM samities";
		if ($branch_id>0)
		{
			$samity_info_sql .=" WHERE samities.branch_id=$branch_id";
		}
		$samity_info_sql=$this->db->query($samity_info_sql);	
		$samity_info=array();
		$all_samity_id=array();
		$samity_info_rows=$samity_info_sql->result_array();
		foreach ($samity_info_rows as $samity_info_row)
		{				
			$samity_info[$samity_info_row['samities_id']]['samities_id']=$samity_info_row['samities_id'];	
			$samity_info[$samity_info_row['samities_id']]['samity_name']=$samity_info_row['samity_name'];	
			$samity_info[$samity_info_row['samities_id']]['samity_code']=$samity_info_row['samity_code'];
			$all_samity_id[]=$samity_info_row['samities_id'];
		}
		$all_samity_id=join(',',$all_samity_id); //Samity Id is joined with comma to use in members table
		//Collected Member information According to Samity ID that is collected from Previous query
		$member_info_sql="SELECT members.id as members_id,members.name as member_name,
						members.samity_id,code as member_code,members.fathers_spouse_name,members.present_village_ward as village_id,
						members.last_achieved_degree,members.form_application_no,members.profession,
						members.registration_date as admission_date,members.member_status,members.date_of_birth, 
						CURDATE(),IF((YEAR(CURDATE())-YEAR(members.date_of_birth)) - (RIGHT(CURDATE(),5)<RIGHT(members.date_of_birth,5))>150,0,YEAR(CURDATE())-YEAR(members.date_of_birth)) - (RIGHT(CURDATE(),5)<RIGHT(members.date_of_birth,5))AS age,
						approved_by,approved_date
						from members where members.samity_id in ($all_samity_id) and members.registration_date between ? and ?";
		$member_info_sql=$this->db->query($member_info_sql,array($from_date,$to_date));
		$member_info_rows=$member_info_sql->result_array();
		$member_info=array();
		$all_village_id=array();
		$all_approved_by=array();
		foreach ($member_info_rows as $member_info_row)
		{
			$member_info[$member_info_row['members_id']]['members_id']=$member_info_row['members_id'];
			$member_info[$member_info_row['members_id']]['member_name']=$member_info_row['member_name'];
			$member_info[$member_info_row['members_id']]['member_code']=$member_info_row['member_code'];
			$member_info[$member_info_row['members_id']]['fathers_spouse_name']=$member_info_row['fathers_spouse_name'];
            $member_info[$member_info_row['members_id']]['samity_name']=isset($member_info_row[$samity_info_row['samities_id']]['samity_name'])?$member_info_row[$samity_info_row['samities_id']]['samity_name']:"";
            $member_info[$member_info_row['members_id']]['samity_code']=isset($member_info_row[$samity_info_row['samities_id']]['samity_code'])?$member_info_row[$samity_info_row['samities_id']]['samity_code']:"";
			$member_info[$member_info_row['members_id']]['village_id']=$member_info_row['village_id'];
            $member_info[$member_info_row['members_id']]['last_achieved_degree']=$member_info_row['last_achieved_degree'];
            $member_info[$member_info_row['members_id']]['form_application_no']=$member_info_row['form_application_no']; 
            $member_info[$member_info_row['members_id']]['profession']=$member_info_row['profession'];
            $member_info[$member_info_row['members_id']]['member_status']=$member_info_row['member_status'];
            $member_info[$member_info_row['members_id']]['age']=$member_info_row['age'];  
			$member_info[$member_info_row['members_id']]['approved_by']=$member_info_row['approved_by'];
			$member_info[$member_info_row['members_id']]['approved_date']=$member_info_row['approved_date'];
			$member_info[$member_info_row['members_id']]['admission_date']=$member_info_row['admission_date'];
			if (($member_info[$member_info_row['members_id']]['village_id']) >0 );
			{
			$all_village_id[$member_info[$member_info_row['members_id']]['village_id']] =$member_info[$member_info_row['members_id']]['village_id'];
			}
			if ($member_info[$member_info_row['members_id']]['approved_by'] >0)
			{
			$all_approved_by[] =$member_info[$member_info_row['members_id']]['approved_by'];
			}
		}
		
        $all_village_id=join(',',$all_village_id); //All Village ID is joined with ,
        $all_village_id=trim($all_village_id,','); 
		$all_approved_by=join(',',$all_approved_by); //Approved by is joined with ,
		$all_thana_id=array();
		$all_union_id=array();
		//Collected Village information According to village ID that is colleted from member table
		$village_info_sql="SELECT po_village_or_blocks.id as village_id,po_village_or_blocks.name as village_name,
		po_village_or_blocks.thana_id,po_village_or_blocks.union_or_ward_id 
		FROM po_village_or_blocks where po_village_or_blocks.id in ($all_village_id)";
		$village_info_sql=$this->db->query($village_info_sql);
		$village_info_rows=$village_info_sql->result_array();
		$village_info=array();
        foreach ($village_info_rows as $village_info_row)
		{
			$village_info[$village_info_row['village_id']]['village_id']=$village_info_row['village_id'];
			$village_info[$village_info_row['village_id']]['village_name']=$village_info_row['village_name'];
			$village_info[$village_info_row['village_id']]['thana_id']=$village_info_row['thana_id'];
			$village_info[$village_info_row['village_id']]['union_or_ward_id']=$village_info_row['union_or_ward_id'];
			$all_thana_id[]=$village_info_row['thana_id'];
			$all_union_id[]=$village_info_row['union_or_ward_id'];	
		}
		$all_thana_id=join(',',$all_thana_id);
		$all_union_id=join(',',$all_union_id);
		
		//Collected Thana Name
		$thana_info_sql="SELECT po_thanas.id as thana_id,po_thanas.name as thana_name 
		FROM po_thanas where po_thanas.id in ($all_thana_id)";
		$thana_info_sql=$this->db->query($thana_info_sql);
		$thana_info_rows=$thana_info_sql->result_array();
		$thana_info=array();
        foreach ($thana_info_rows as $thana_info_row)
		{
			
			$thana_info[$thana_info_row['thana_id']]['thana_id']=$thana_info_row['thana_id'];
			$thana_info[$thana_info_row['thana_id']]['thana_name']=$thana_info_row['thana_name'];				
		}
		
		//Collected Union name
		$union_info_sql="SELECT po_unions_or_wards.id as union_id,po_unions_or_wards.name as union_name 
						FROM po_unions_or_wards where po_unions_or_wards.id in ($all_union_id)";
		$union_info_sql=$this->db->query($union_info_sql);
		$union_info_rows=$union_info_sql->result_array();
		$union_info=array();
               foreach ($union_info_rows as $union_info_row)
		{
			
			$union_info[$union_info_row['union_id']]['union_id']=$union_info_row['union_id'];
			$union_info[$union_info_row['union_id']]['union_name']=$union_info_row['union_name'];				
		}
		
		//Collected Approved by information from employee table
	if (!empty($all_approved_by))
	{		
		$employee_info_sql="SELECT employees.id as employee_id,employees.name as employee_name 
		FROM employees where employees.id in ($all_approved_by)";
		$employee_info_sql=$this->db->query($employee_info_sql);
		$employee_info_rows=$employee_info_sql->result_array();
		//print_r($admission_register_village_information_rows);die;
		$employee_info=array();
               foreach ($employee_info_rows as $employee_info_row)
		{
			
			$employee_info[$employee_info_row['employee_id']]['employee_id']=$employee_info_row['employee_id'];
			$employee_info[$employee_info_row['employee_id']]['employee_name']=$employee_info_row['employee_name'];				
		}
	}
		// Village Name,Thana Name and Union Name is collected in village information array
		foreach ($village_info_rows as $village_info_row)
		{
			$village_info[$village_info_row['village_id']]['village_name']=$village_info_row['village_name'];
			$village_info[$village_info_row['village_id']]['thana_name']=$thana_info[$village_info[$village_info_row['village_id']]['thana_id']]['thana_name'];
			$village_info[$village_info_row['village_id']]['union_name']=$union_info[$village_info[$village_info_row['village_id']]['union_or_ward_id']]['union_name'];	
		}
		
		// Village Name,Thana Name and Union Name is collected in $member_information array
		foreach ($member_info_rows as $member_info_row)
		{
			if (isset($village_info[$member_info[$member_info_row['members_id']]['village_id']]))
			{
			$member_info[$member_info_row['members_id']]['village_name']=$village_info[$member_info[$member_info_row['members_id']]['village_id']]['village_name'];
			$member_info[$member_info_row['members_id']]['thana_name']=$village_info[$member_info[$member_info_row['members_id']]['village_id']]['thana_name'];
			$member_info[$member_info_row['members_id']]['union_name']=$village_info[$member_info[$member_info_row['members_id']]['village_id']]['union_name'];
			}
		}
		
         return $member_info;	
	}
		// Old code from admission register
		/*$admission_register_information_sql ="SELECT samities.code as samity_code,samities.name as samity_name,members.code as member_code,members.name as member_name,ifnull(members.fathers_spouse_name,'-') as fathers_spouse_name
				,po_village_or_blocks.name as village_name,po_unions_or_wards.name as ward_name,po_thanas.name as thana_name,ifnull(members.profession,'-') as profession
				,members.date_of_birth, CURDATE()
				,IF((YEAR(CURDATE())-YEAR(members.date_of_birth)) - (RIGHT(CURDATE(),5)<RIGHT(members.date_of_birth,5))>150,0,YEAR(CURDATE())-YEAR(members.date_of_birth)) 
				- (RIGHT(CURDATE(),5)<RIGHT(members.date_of_birth,5))AS age
				,ifnull(members.last_achieved_degree,'-') as last_achieved_degree,ifnull(members.form_application_no,'-') as form_application_no,members.approved_date,employees.name AS approved_by,members.registration_date,members.member_status
			FROM samities JOIN members ON samities.id=members.samity_id
				LEFT JOIN po_working_areas ON members.working_area_id=po_working_areas.id
				LEFT JOIN po_village_or_blocks ON po_working_areas.village_or_block_id=po_village_or_blocks.id
				LEFT JOIN po_unions_or_wards ON po_unions_or_wards.id=po_village_or_blocks.union_or_ward_id
				LEFT JOIN po_thanas ON po_village_or_blocks.thana_id=po_thanas.id
				LEFT JOIN employees ON employees.id=members.approved_by
			WHERE members.registration_date BETWEEN ? AND ? ";
			if($branch_id>0)
			{
				$admission_register_information_sql .=" AND  samities.branch_id=? ";
			}
			$admission_register_information_sql .= " GROUP BY samities.code,samities.name,members.code,members.name,members.fathers_spouse_name,po_village_or_blocks.name,po_unions_or_wards.name
				,po_thanas.name,members.last_achieved_degree,members.form_application_no,members.approved_date,members.approved_by
				,members.registration_date,members.member_status";
			if($branch_id>0)
			{
				$admission_register_information_sql=$this->db->query($admission_register_information_sql, array($from_date,$to_date,$branch_id));	
			}
			else
			{
				$admission_register_information_sql=$this->db->query($admission_register_information_sql, array($from_date,$to_date));	
			}
		$admission_register_information=array();
		$i=0;
		foreach ($admission_register_information_sql->result_array() as $admission_register_information_row)
		{	
			$i++;					
			$admission_register_information[$i]['samity_code']=$admission_register_information_row['samity_code'];	
			$admission_register_information[$i]['samity_name']=$admission_register_information_row['samity_name'];	
			$admission_register_information[$i]['member_code']=$admission_register_information_row['member_code'];	
			$admission_register_information[$i]['member_name']=$admission_register_information_row['member_name'];
			$admission_register_information[$i]['fathers_spouse_name']=$admission_register_information_row['fathers_spouse_name'];
			$admission_register_information[$i]['village_name']=$admission_register_information_row['village_name'];
			$admission_register_information[$i]['ward_name']=$admission_register_information_row['ward_name'];
			$admission_register_information[$i]['thana_name']=$admission_register_information_row['thana_name'];
			$admission_register_information[$i]['profession']=$admission_register_information_row['profession'];
			$admission_register_information[$i]['age']=$admission_register_information_row['age'];
			$admission_register_information[$i]['last_achieved_degree']=$admission_register_information_row['last_achieved_degree'];
			$admission_register_information[$i]['form_application_no']=$admission_register_information_row['form_application_no'];
			$admission_register_information[$i]['approved_date']=$admission_register_information_row['approved_date'];	
			$admission_register_information[$i]['approved_by']=$admission_register_information_row['approved_by'];	
			$admission_register_information[$i]['registration_date']=$admission_register_information_row['registration_date'];	
			$admission_register_information[$i]['member_status']=$admission_register_information_row['member_status'];						
		}
		//echo "<pre>";print_r($admission_register_information);die;
		return $admission_register_information;
	} */
	function get_admission_register_total_information($branch_id=null,$from_date=null,$to_date=null)
	{
		$admission_register_total_information_sql ="SELECT COUNT(DISTINCT approved_by) AS total_approved_by,COUNT(DISTINCT samities.code)AS total_samity
			FROM samities JOIN members ON samities.id=members.samity_id
			WHERE members.registration_date BETWEEN ? AND ? ";
			if($branch_id>0)
			{
				$admission_register_total_information_sql .=" AND  samities.branch_id=? ";
			}			
			if($branch_id>0)
			{
				$admission_register_total_information_sql =$this->db->query($admission_register_total_information_sql , array($from_date,$to_date,$branch_id));	
			}
			else
			{
				$admission_register_total_information_sql =$this->db->query($admission_register_total_information_sql , array($from_date,$to_date));	
			}			
		$admission_register_total_information=array();				
		foreach ($admission_register_total_information_sql->result_array() as $admission_register_total_information_row)
		{	
			$admission_register_total_information['total_samity']=$admission_register_total_information_row['total_samity'];
			$admission_register_total_information['total_approved_by']=$admission_register_total_information_row['total_approved_by'];				
		}
		//echo "<pre>";print_r($admission_register_information);die;
		return $admission_register_total_information;
	}
	
	
	
	// ***************************************Loan Disbursement Register/Master Roll****************************************************************************
	function get_loan_disbursement_information($branch_id=null,$product_id=null,$from_date=null,$to_date=null)
	{
		$samity_info_sql="SELECT samities.id as samities_id,samities.branch_id,samities.code as samity_code,samities.name as samity_name FROM samities";
		if ($branch_id>0)
		{
			$samity_info_sql .=" WHERE samities.branch_id=$branch_id";
			//$admission_register_samity_information_sql=$this->db->query($admission_register_samity_information_sql,$branch_id);	
		}
		$samity_info_sql=$this->db->query($samity_info_sql);	
		$samity_info=array();
		$all_samity_id=array();
		$samity_info_rows=$samity_info_sql->result_array();
		foreach ($samity_info_rows as $samity_info_row)
		{				
			$samity_info[$samity_info_row['samities_id']]['samities_id']=$samity_info_row['samities_id'];	
			$samity_info[$samity_info_row['samities_id']]['samity_name']=$samity_info_row['samity_name'];	
			$samity_info[$samity_info_row['samities_id']]['samity_code']=$samity_info_row['samity_code'];
			$all_samity_id[]=$samity_info_row['samities_id'];
		}
		$all_samity_id=join(',',$all_samity_id); //Samity Id is joined with comma to use in members table
		//Collected Member information According to Samity ID that is collected from Previous query
		$member_info_sql="SELECT members.id as members_id,members.name as member_name,
						code as member_code,members.fathers_spouse_name,members.present_village_ward as village_id
						from members where members.samity_id in ($all_samity_id)";
		$member_info_sql=$this->db->query($member_info_sql);
		$member_info_rows=$member_info_sql->result_array();
		$member_info=array();
		$all_village_id=array();
		$all_member_id[]="";
		foreach ($member_info_rows as $member_info_row)
		{
			$member_info[$member_info_row['members_id']]['members_id']=$member_info_row['members_id'];
			$member_info[$member_info_row['members_id']]['member_name']=$member_info_row['member_name'];
			$member_info[$member_info_row['members_id']]['member_code']=$member_info_row['member_code'];
			$member_info[$member_info_row['members_id']]['village_id']=$member_info_row['village_id'];
			$member_info[$member_info_row['members_id']]['fathers_spouse_name']=$member_info_row['fathers_spouse_name'];
            if ($member_info_row['members_id'] >0 )
			{
			$all_member_id[]=$member_info_row['members_id'];
			}
			if (($member_info[$member_info_row['members_id']]['village_id']) >0 );
			{
			$all_village_id[$member_info[$member_info_row['members_id']]['village_id']] =$member_info[$member_info_row['members_id']]['village_id'];
			}
		}
        $all_village_id=join(',',$all_village_id); //All Village ID is joined with ,
        $all_village_id=trim($all_village_id,',');
        $all_member_id=join(',',$all_member_id);
        $all_member_id=trim($all_member_id,',');
		//Collected Village information According to village ID that is colleted from member table
		$village_info_sql="SELECT po_village_or_blocks.id as village_id,po_village_or_blocks.name as village_name,
		po_village_or_blocks.thana_id,po_village_or_blocks.union_or_ward_id 
		FROM po_village_or_blocks where po_village_or_blocks.id in ($all_village_id)";
		$village_info_sql=$this->db->query($village_info_sql);
		$village_info_rows=$village_info_sql->result_array();
		$village_info=array();
        foreach ($village_info_rows as $village_info_row)
		{
			$village_info[$village_info_row['village_id']]['village_id']=$village_info_row['village_id'];
			$village_info[$village_info_row['village_id']]['village_name']=$village_info_row['village_name'];	
		}
		$loan_info_sql="SELECT id as loan_id,disburse_date,member_id,loan_amount,purpose_id,cycle FROM loans
		                where member_id in ($all_member_id)";
		$loan_info_sql=$this->db->query($loan_info_sql);
		$loan_info_rows=$loan_info_sql->result_array();
		$loan_info=array();
		$all_purpose_id[]="";
		foreach ($loan_info_rows as $loan_info_row)
		{
			$loan_info[$loan_info_row['loan_id']]['member_name']=$member_info_row['member_name'];
			$loan_info[$loan_info_row['loan_id']]['member_code']=$member_info_row['member_code'];
			$loan_info[$loan_info_row['loan_id']]['member_code']=$member_info_row['member_code'];
			$loan_info[$loan_info_row['loan_id']]['fathers_spouse_name']=$member_info_row['fathers_spouse_name'];
			$loan_info[$loan_info_row['loan_id']]['samity_name']=$samity_info_row['samity_name'];
			$loan_info[$loan_info_row['loan_id']]['samity_code']=$samity_info_row['samity_code'];
			$loan_info[$loan_info_row['loan_id']]['purpose_id']=$loan_info_row['purpose_id'];
			$loan_info[$loan_info_row['loan_id']]['disburse_date']=$loan_info_row['disburse_date'];
			$loan_info[$loan_info_row['loan_id']]['loan_amount']=$loan_info_row['loan_amount'];
			$loan_info[$loan_info_row['loan_id']]['cycle']=$loan_info_row['cycle'];
			$loan_info[$loan_info_row['loan_id']]['village_name']=$village_info[$village_info_row['village_id']]['village_name'];
			if ($loan_info[$loan_info_row['loan_id']]['purpose_id'] >0)	
			$all_purpose_id[]=$loan_info[$loan_info_row['loan_id']]['purpose_id'];	
		}
		$all_purpose_id=join(',',$all_purpose_id);
		$all_purpose_id=trim($all_purpose_id,',');
		$loan_purposes_sql="SELECT id as loan_purposes_id,name as loan_purposes FROM loan_purposes
		                where id in ($all_purpose_id)";
		$loan_purpose_sql=$this->db->query($loan_purposes_sql);
		$loan_purpose_rows=$loan_purpose_sql->result_array();
		$loan_purpose=array();                
		
		foreach ($loan_purpose_rows as $loan_purpose_row)
		{
			$loan_purpose[$loan_purpose_row['loan_purposes_id']]['loan_purposes_id']=$loan_purpose_row['loan_purposes_id'];
			$loan_purpose[$loan_purpose_row['loan_purposes_id']]['loan_purposes']=$loan_purpose_row['loan_purposes'];		
		}	
		foreach ($loan_info_rows as $loan_info_row)
		{
			$loan_info[$loan_info_row['loan_id']]['loan_purposes']=$loan_purpose_row['loan_purposes'];
		}
		return $loan_info;
	}
		
		/*$loan_disbursement_information_sql ="SELECT loans.disburse_date,members.name as member_name,members.code as member_code,
				samities.name as samity_name,samities.code as samity_code,members.fathers_spouse_name,po_village_or_blocks.name as village_name,
				loan_purposes.name as purpose_name,loans.cycle,SUM(loans.loan_amount) AS loan_amount,loan_products.short_name
			FROM loans JOIN members ON members.id=loans.member_id
				JOIN samities ON loans.samity_id=samities.id
				JOIN loan_products ON loan_products.id=loans.product_id
				LEFT JOIN po_working_areas ON po_working_areas.id=samities.working_area_id
				LEFT JOIN po_village_or_blocks ON po_working_areas.village_or_block_id=po_village_or_blocks.id
				JOIN loan_purposes ON loan_purposes.id=loans.purpose_id
			WHERE loans.product_id=? ";
			if($branch_id>0)
			{
				$loan_disbursement_information_sql .=" AND loans.branch_id=$branch_id";
			}
			$loan_disbursement_information_sql .="	AND disburse_date BETWEEN ? AND ?
				GROUP BY  loan_products.short_name,loans.disburse_date,members.name,members.code,samities.name,samities.code,members.fathers_spouse_name
				,po_village_or_blocks.name,loan_purposes.name,loans.cycle";
		$loan_disbursement_information_sql=$this->db->query($loan_disbursement_information_sql, array($product_id,$from_date,$to_date));						
		$loan_disbursement_information=array();
		$i=0;
		foreach ($loan_disbursement_information_sql->result_array() as $loan_disbursement_information_row)
		{	
			$i++;					
			$loan_disbursement_information[$i]['disburse_date']=$loan_disbursement_information_row['disburse_date'];	
			$loan_disbursement_information[$i]['member_name']=$loan_disbursement_information_row['member_name'];
			$loan_disbursement_information[$i]['member_code']=$loan_disbursement_information_row['member_code'];
			$loan_disbursement_information[$i]['samity_name']=$loan_disbursement_information_row['samity_name'];
			$loan_disbursement_information[$i]['samity_code']=$loan_disbursement_information_row['samity_code'];
			$loan_disbursement_information[$i]['fathers_spouse_name']=$loan_disbursement_information_row['fathers_spouse_name'];
			$loan_disbursement_information[$i]['village_name']=$loan_disbursement_information_row['village_name'];
			$loan_disbursement_information[$i]['purpose_name']=$loan_disbursement_information_row['purpose_name'];
			$loan_disbursement_information[$i]['cycle']=$loan_disbursement_information_row['cycle'];
			$loan_disbursement_information[$i]['loan_amount']=$loan_disbursement_information_row['loan_amount'];	
			$loan_disbursement_information[$i]['short_name']=$loan_disbursement_information_row['short_name'];								
		}
		//echo "<pre>";print_r($loan_disbursement_information);die;
		return $loan_disbursement_information;
	}*/
	function get_loan_disbursement_total($branch_id=null,$product_id=null,$from_date=null,$to_date=null)
	{
		$loan_disbursement_information_sql ="SELECT IFNULL(SUM(loans.loan_amount),0.00) AS total_loan
			FROM loans JOIN members ON members.id=loans.member_id
				JOIN samities ON loans.samity_id=samities.id
				JOIN loan_products ON loan_products.id=loans.product_id
				LEFT JOIN po_working_areas ON po_working_areas.id=samities.working_area_id
				LEFT JOIN po_village_or_blocks ON po_working_areas.village_or_block_id=po_village_or_blocks.id
				JOIN loan_purposes ON loan_purposes.id=loans.purpose_id
			WHERE loans.product_id=? ";
			if($branch_id>0)
			{
				$loan_disbursement_information_sql .=" AND loans.branch_id=$branch_id";
			}
			$loan_disbursement_information_sql .="	AND disburse_date<? ";
			if($branch_id>0)
			{
				$loan_disbursement_information_sql=$this->db->query($loan_disbursement_information_sql, array($branch_id,$product_id,$from_date));
			}
			else
			{
				$loan_disbursement_information_sql=$this->db->query($loan_disbursement_information_sql, array($product_id,$from_date));			
			}
		$loan_disbursement_information=array();				
		foreach ($loan_disbursement_information_sql->result_array() as $loan_disbursement_information_row)
		{	
			$loan_disbursement_information['total_loan']=$loan_disbursement_information_row['total_loan'];								
		}
		//echo "<pre>";print_r($loan_disbursement_information);die;
		return $loan_disbursement_information;
	} 
	
	
	
	//*********************************************************Cancellation Register****************************************************************************
	function get_cancellation_register($branch_id=null,$from_date=null,$to_date=null)
	{
		
		
		/*$member_product_transfer_sql="SELECT member_products.member_id 
			FROM members JOIN member_products ON members.id=member_products.member_id
			WHERE member_products.transfer_date<?";
			if($branch_id>0)
			{
				$member_product_transfer_sql .=" AND member_products.branch_id=$branch_id";
				$member_product_transfer_sql=$this->db->query($member_product_transfer_sql, array($to_date,$branch_id));
			}
			else
			{
				$member_product_transfer_sql=$this->db->query($member_product_transfer_sql, array($to_date));	
			}		
		$member_product_transfer=array();				
		foreach ($member_product_transfer_sql->result_array() as $member_product_transfer_row)
		{
			array_push($member_product_transfer,$member_product_transfer_row['member_id']);
		}		
		
		if(!empty($member_product_transfer))

		print_r($member_product_transfer);
		die;

		
		$manager_sql ="SELECT employees.branch_id,employees.name AS branch_manager 
			FROM employees JOIN employee_designations ON employees.designation_id=employee_designations.id
			WHERE employee_designations.is_manager='1'";
			if($branch_id>0)
			{
				$manager_sql .=" AND  employees.code LIKE '001%'";
			}
			$manager_sql .=" GROUP BY branch_id
							ORDER BY branch_id";
			if($branch_id>0)
			{
				$manager_sql =$this->db->query($manager_sql, array($from_date,$to_date));
			}			
			else
			{
				$manager_sql =$this->db->query($manager_sql, array($from_date,$to_date));
			}
		$manager=array();				
		$i=0;
		foreach ($manager_sql->result_array() as $manager_row)
		{	
			$i++;	
			$manager[$i]['branch_id']=$manager_row['branch_id'];
			$manager[$i]['branch_manager']=$manager_row['branch_manager'];
		}
		echo "<pre>";print_r($manager);die;*/
		
		$member_closing_sql="SELECT mc.id as cancellation_id,mc.samity_id as samities_id,mc.member_id as members_id,
		mc.member_primary_product_id,mc.cancel_by as manager_id,mc.closing_date as cancellation_date FROM member_closing mc";
		if ($branch_id>0)
		{
			$member_closing_sql .=" WHERE mc.branch_id=? and mc.closing_date between ? and ?";	
		}
		$member_closing_sql=$this->db->query($member_closing_sql,array($branch_id,$from_date,$to_date));
		$member_closing_info_rows=$member_closing_sql->result_array();	
		$member_closing_info=array();
		$all_samity_id=array();
		$all_primary_product_id=array();
		$all_manager_id=array();
		$all_member_id=array();
		
		foreach ($member_closing_info_rows as $member_closing_info_row)
		{				
			$member_closing_info[$member_closing_info_row['cancellation_id']]['samities_id']=$member_closing_info_row['cancellation_id'];
			$member_closing_info[$member_closing_info_row['cancellation_id']]['samities_id']=$member_closing_info_row['samities_id'];
			$member_closing_info[$member_closing_info_row['cancellation_id']]['members_id']=$member_closing_info_row['members_id'];	
			$member_closing_info[$member_closing_info_row['cancellation_id']]['member_primary_product_id']=$member_closing_info_row['member_primary_product_id'];
			$member_closing_info[$member_closing_info_row['cancellation_id']]['manager_id']=$member_closing_info_row['manager_id'];
			$member_closing_info[$member_closing_info_row['cancellation_id']]['cancellation_date']=$member_closing_info_row['cancellation_date'];
			$all_samity_id[]=$member_closing_info_row['samities_id'];
			if ($member_closing_info_row['manager_id'] >0)
			$all_manager_id[]=$member_closing_info_row['manager_id'];
			if ($member_closing_info_row['members_id'] >0)
			$all_member_id[]=$member_closing_info_row['members_id'];
			$all_primary_product_id[]=$member_closing_info_row['member_primary_product_id'];
		}
		$all_samity_id=join(',',$all_samity_id);
		$all_manager_id=join(',',$all_manager_id);
		$all_member_id=join(',',$all_member_id);
		$all_primary_product_id=join(',',$all_primary_product_id);
		if (!empty($all_primary_product_id))
		{
		$primary_product_info_sql="SELECT id as member_primary_product_id,short_name from loan_products where loan_products.id in ($all_primary_product_id)";
		$primary_product_info=array();
		$primary_product_info_sql=$this->db->query($primary_product_info_sql);
		$primary_product_info_rows=$primary_product_info_sql->result_array();
		foreach ($primary_product_info_rows as $primary_product_info_row)
			{
			$primary_product_info[$primary_product_info_row['member_primary_product_id']]['short_name']=$primary_product_info_row['short_name'];
			}
		}
		//Collected Member information 
		if (!empty($all_member_id))
		{
		$member_info_sql="SELECT members.id as members_id,members.name as member_name,code as member_code,
members.cancel_reason,members.registration_date as opening_date,members.cancel_registration_no,members.member_status from members where members.id in ($all_member_id)";
		$member_info=array();
		$member_info_sql=$this->db->query($member_info_sql);
		$member_info_rows=$member_info_sql->result_array();
		foreach ($member_info_rows as $member_info_row)
		{
			$member_info[$member_info_row['members_id']]['members_id']=$member_info_row['members_id'];
			$member_info[$member_info_row['members_id']]['member_name']=$member_info_row['member_name'];
			$member_info[$member_info_row['members_id']]['member_code']=$member_info_row['member_code'];	
			$member_info[$member_info_row['members_id']]['cancel_registration_no']=$member_info_row['cancel_registration_no'];
			$member_info[$member_info_row['members_id']]['opening_date']=$member_info_row['opening_date'];
			$member_info[$member_info_row['members_id']]['cancel_reason']=$member_info_row['cancel_reason'];
			$member_info[$member_info_row['members_id']]['member_status']=$member_info_row['member_status'];
		}
	}
	if (!empty($all_samity_id))
	{
		$samity_info_sql="SELECT samities.id as samity_id,samities.name as samity_name,samities.code as samity_code,samities.field_officer_id
 from samities where samities.id in ($all_samity_id)";
		$samity_info=array();
		$all_field_officer_id=array();
		$samity_info_sql=$this->db->query($samity_info_sql);
		$samity_info_rows=$samity_info_sql->result_array();
		foreach ($samity_info_rows as $samity_info_row)
		{
			$samity_info[$samity_info_row['samity_id']]['samity_id']=$samity_info_row['samity_id'];
			$samity_info[$samity_info_row['samity_id']]['samity_name']=$samity_info_row['samity_name'];
			$samity_info[$samity_info_row['samity_id']]['samity_code']=$samity_info_row['samity_code'];
			$samity_info[$samity_info_row['samity_id']]['field_officer_id']=$samity_info_row['field_officer_id'];	
			$all_field_officer_id[]=$samity_info_row['field_officer_id'];
		}
	
		$all_field_officer_id=join(',',$all_field_officer_id);
	}
		if (!empty($all_field_officer_id))
		{
		$field_officer_info_sql="SELECT employees.id as field_officer_id,employees.name as field_officer_name
 from employees where employees.id in ($all_field_officer_id)";
		$field_officer_info_sql=$this->db->query($field_officer_info_sql);
         $field_officer_info_rows=$field_officer_info_sql->result_array();
         $field_officer_info=array();
         foreach ($field_officer_info_rows as $field_officer_info_row)
		{
			$field_officer_info[$field_officer_info_row['field_officer_id']]['field_officer_id']=$field_officer_info_row['field_officer_id'];
			$field_officer_info[$field_officer_info_row['field_officer_id']]['field_officer_name']=$field_officer_info_row['field_officer_name'];
		}
	}
	
	if (!empty($all_manager_id))
	{
	
		$manager_info_sql="SELECT employees.id as manager_id,employees.name as manager_name
 from employees where employees.id in ($all_manager_id)";
 		$manager_info_sql=$this->db->query($manager_info_sql);
         $manager_info_rows=$manager_info_sql->result_array();
         $manager_info=array();
         foreach ($manager_info_rows as $manager_info_row)
		{
			$manager_info[$manager_info_row['manager_id']]['manager_id']=$manager_info_row['manager_id'];
			$manager_info[$manager_info_row['manager_id']]['manager_name']=$manager_info_row['manager_name'];
		}
	}
	// To know employee name for field office field
		if (!empty($all_field_officer_id))
		{
		foreach ($samity_info_rows as $samity_info_row)
		{
			$samity_info[$samity_info_row['samity_id']]['field_officer_name']=$field_officer_info[$samity_info_row['field_officer_id']]['field_officer_name'];
		}
	}
		foreach ($member_closing_info_rows as $member_closing_info_row)
		{
		$member_closing_info[$member_closing_info_row['members_id']]['samity_name']=$samity_info[$member_closing_info_row['samities_id']]['samity_name'];
		$member_closing_info[$member_closing_info_row['members_id']]['samity_code']=$samity_info[$member_closing_info_row['samities_id']]['samity_code'];			
		$member_closing_info[$member_closing_info_row['members_id']]['member_name']=$member_info[$member_closing_info_row['members_id']]['member_name'];
		$member_closing_info[$member_closing_info_row['members_id']]['member_code']=$member_info[$member_closing_info_row['members_id']]['member_code'];
		$member_closing_info[$member_closing_info_row['members_id']]['cancel_registration_no']=$member_info[$member_closing_info_row['members_id']]['cancel_registration_no'];
		$member_closing_info[$member_closing_info_row['members_id']]['opening_date']=$member_info[$member_closing_info_row['members_id']]['opening_date'];
		$member_closing_info[$member_closing_info_row['members_id']]['cancel_reason']=$member_info[$member_closing_info_row['members_id']]['cancel_reason'];
		$member_closing_info[$member_closing_info_row['members_id']]['member_status']=$member_info[$member_closing_info_row['members_id']]['member_status'];
		$member_closing_info[$member_closing_info_row['members_id']]['field_officer_name']=$samity_info[$member_closing_info_row['samities_id']]['field_officer_name'];
		$member_closing_info[$member_closing_info_row['members_id']]['manager_name']=isset($manager_info[$member_closing_info_row['manager_id']]['manager_name'])?$manager_info[$member_closing_info_row['manager_id']]['manager_name']:"";
		$member_closing_info[$member_closing_info_row['members_id']]['short_name']=$primary_product_info[$member_closing_info_row['member_primary_product_id']]['short_name'];
		}
		
		
			
		 /*$cancellation_register_sql ="SELECT cancel_registration_no,members.name AS member_name,members.code AS member_code,
			samities.name AS samity_name,samities.code AS samity_code,registration_date,cancel_date,cancel_reason,
			employees.name as employee_name,manager.name as branch_manager,members.member_status,loan_product_categories.short_name
			FROM samities JOIN members ON samities.id=members.samity_id
				JOIN employees ON samities.field_officer_id=employees.id
				JOIN member_closing ON member_closing.member_id=members.id
				left JOIN employees as manager ON member_closing.cancel_by=manager.id  
				JOIN loan_product_categories ON members.primary_product_id=loan_product_categories.id
			WHERE ";
			if($branch_id>0)
			{
				$cancellation_register_sql .=" samities.branch_id=$branch_id AND ";
			}
			$cancellation_register_sql .="	cancel_date BETWEEN ? AND ?";
		$cancellation_register_sql=$this->db->query($cancellation_register_sql, array($from_date,$to_date));
		$cancellation_register=array();				
		$i=0;
		foreach ($cancellation_register_sql->result_array() as $cancellation_register_row)
		{	
			$i++;				
			$cancellation_register[$i]['cancel_registration_no']=$cancellation_register_row['cancel_registration_no'];	
			$cancellation_register[$i]['member_name']=$cancellation_register_row['member_name'];	
			$cancellation_register[$i]['member_code']=$cancellation_register_row['member_code'];	
			$cancellation_register[$i]['samity_name']=$cancellation_register_row['samity_name'];	
			$cancellation_register[$i]['samity_code']=$cancellation_register_row['samity_code'];
			$cancellation_register[$i]['registration_date']=$cancellation_register_row['registration_date'];	
			$cancellation_register[$i]['cancel_date']=$cancellation_register_row['cancel_date'];	
			$cancellation_register[$i]['cancel_reason']=$cancellation_register_row['cancel_reason'];	
			$cancellation_register[$i]['employee_name']=$cancellation_register_row['employee_name'];	
			$cancellation_register[$i]['branch_manager']=$cancellation_register_row['branch_manager'];
			$cancellation_register[$i]['member_status']=$cancellation_register_row['member_status'];
			$cancellation_register[$i]['short_name']=$cancellation_register_row['short_name'];	
			//$cancellation_register[$i]['branch_id']=$cancellation_register_row['branch_id'];								
		}
		//echo "<pre>";print_r($cancellation_register);die;
		/*$i=0;
		for($j=1;$j<=count($manager);$j++)
		{			
			if($i==0)
			{				
				$manager_branch_id=$manager[$j]['branch_id'];
				$branch_id=$cancellation_register[$j]['branch_id'];
			}
			else
			{
				$branch_id=$cancellation_register[$i]['branch_id'];
			}
			if($branch_id==$manager_branch_id)
			{
				$i++;
				$cancellation_register[$i]['branch_manager']=$manager[$j]['branch_manager'];
				$j=1;	
			}
			else
			{				
				$i++;
				$manager_branch_id=$manager[$j+1]['branch_id'];
				$cancellation_register[$i]['branch_manager']=$manager[$j+1]['branch_manager'];				
			}
		}
		echo "<pre>";print_r($cancellation_register);die;
		return $cancellation_register;*/
		return $member_closing_info;
	}  


function get_cancellation_register_total_information($branch_id=null,$from_date=null,$to_date=null)
	{
		$cancel_register_total_information_sql ="SELECT COUNT(DISTINCT samities.code)AS total_samity
			FROM samities JOIN members ON samities.id=members.samity_id
			WHERE members.member_status='inactive' and  members.registration_date BETWEEN ? AND ? ";
			if($branch_id>0)
			{
				$cancel_register_total_information_sql .=" AND  samities.branch_id=? ";
			}			
			if($branch_id>0)
			{
				$cancel_register_total_information_sql =$this->db->query($cancel_register_total_information_sql , array($branch_id,$from_date,$to_date));	
			}
			else
			{
				$cancel_register_total_information_sql =$this->db->query($cancel_register_total_information_sql , array($from_date,$to_date));	
			}			
		$cancel_register_total_information=array();				
		foreach ($cancel_register_total_information_sql->result_array() as $cancel_register_total_information_row)
		{	
			$cancel_register_total_information['total_samity']=$cancel_register_total_information_row['total_samity'];
		}
		//echo "<pre>";print_r($admission_register_information);die;
	}
	
	
	
	// ***************************************************Fully Paid Loan Register****************************************************************************	
	function get_fully_paid_loan_register($branch_id=null,$product_id=null,$from_date=null,$to_date=null)
	{
		
		$samity_info_sql="SELECT samities.id as samities_id,samities.branch_id as branch_id,samities.code as samity_code,samities.name as samity_name FROM samities";
		if ($branch_id>0)
		{
			$samity_info_sql .=" WHERE samities.branch_id=$branch_id";
			//$admission_register_samity_information_sql=$this->db->query($admission_register_samity_information_sql,$branch_id);	
		}
		$samity_info_sql=$this->db->query($samity_info_sql);
		$samity_info_rows=$samity_info_sql->result_array();	
		$samity_info=array();
		$all_samity_id=array();
		foreach ($samity_info_rows as $samity_info_row)
		{				
			$samity_info[$samity_info_row['samities_id']]['samities_id']=$samity_info_row['samities_id'];	
			$samity_info[$samity_info_row['samities_id']]['samity_name']=$samity_info_row['samity_name'];	
			$samity_info[$samity_info_row['samities_id']]['samity_code']=$samity_info_row['samity_code'];
			$all_samity_id[]=$samity_info_row['samities_id'];
		}
		$all_samity_id=join(',',$all_samity_id); //Samity Id is joined with comma to use in members table
		//Collected Member information According to Samity ID that is collected from Previous query
		$member_info_sql="SELECT members.id as members_id,members.name as member_name,members.samity_id,code as member_code
						from members where members.samity_id in ($all_samity_id) and members.registration_date between ? and ?";
		$member_info_sql=$this->db->query($member_info_sql,array($from_date,$to_date));
		$member_info_rows=$member_info_sql->result_array();
		$member_info=array();
		$all_member_id=array();
		foreach ($member_info_rows as $member_info_row)
		{
			$member_info[$member_info_row['members_id']]['members_id']=$member_info_row['members_id'];
			$member_info[$member_info_row['members_id']]['member_name']=$member_info_row['member_name'];
			$member_info[$member_info_row['members_id']]['member_code']=$member_info_row['member_code'];
			$all_member_id[]=$member_info_row['members_id'];
		}
		$all_member_id=join($all_member_id,',');
		$loan_info_sql="SELECT id as loan_id,member_id,disburse_date,loan_fully_paid_date,loan_amount FROM loans
		                where member_id in ($all_member_id)";
		$loan_info_sql=$this->db->query($loan_info_sql);
		$loan_info_rows=$loan_info_sql->result_array();
		$loan_info=array();
		foreach ($loan_info_rows as $loan_info_row)
		{
			$loan_info[$loan_info_row['loan_id']]['member_name']=$member_info_row['member_name'];
			$loan_info[$loan_info_row['loan_id']]['member_code']=$member_info_row['member_code'];
			$loan_info[$loan_info_row['loan_id']]['samity_name']=$samity_info_row['samity_name'];
			$loan_info[$loan_info_row['loan_id']]['samity_code']=$samity_info_row['samity_code'];
			$loan_info[$loan_info_row['loan_id']]['disburse_date']=$loan_info_row['disburse_date'];
			$loan_info[$loan_info_row['loan_id']]['loan_fully_paid_date']=$loan_info_row['loan_fully_paid_date'];
			$loan_info[$loan_info_row['loan_id']]['loan_amount']=$loan_info_row['loan_amount'];		
		}	
		return $loan_info;
	}
		
		/*$fully_paid_loan_register_sql ="SELECT members.name AS member_name,members.code AS member_code,
			samities.name AS samity_name,samities.code AS samity_code,
			loans.loan_fully_paid_date,loans.disburse_date,loans.loan_amount
			FROM loans JOIN members ON members.id=loans.member_id
				JOIN samities ON loans.samity_id=samities.id
				JOIN loan_products ON loan_products.id=loans.product_id	
				JOIN loan_purposes ON loan_purposes.id=loans.purpose_id
			WHERE loans.product_id=? ";
			$fully_paid_loan_register_sql .=" AND loans.loan_fully_paid_date BETWEEN ? AND ? ";
			if($branch_id>0)
			{
				$fully_paid_loan_register_sql .=" AND loans.branch_id= ?";
			}			
			if($branch_id>0)
			{
				$fully_paid_loan_register_sql=$this->db->query($fully_paid_loan_register_sql, array($product_id,$from_date,$to_date,$branch_id));
			}
			else
			{			
				$fully_paid_loan_register_sql=$this->db->query($fully_paid_loan_register_sql, array($product_id,$from_date,$to_date));
			}
		$fully_paid_loan_register=array();				
		$i=0;
		foreach ($fully_paid_loan_register_sql->result_array() as $fully_paid_loan_register_row)
		{	
			$i++;	
			$fully_paid_loan_register[$i]['member_name']=$fully_paid_loan_register_row['member_name'];	
			$fully_paid_loan_register[$i]['member_code']=$fully_paid_loan_register_row['member_code'];	
			$fully_paid_loan_register[$i]['samity_name']=$fully_paid_loan_register_row['samity_name'];
			$fully_paid_loan_register[$i]['samity_code']=$fully_paid_loan_register_row['samity_code'];	
			$fully_paid_loan_register[$i]['loan_amount']=$fully_paid_loan_register_row['loan_amount'];
			$fully_paid_loan_register[$i]['loan_fully_paid_date']=$fully_paid_loan_register_row['loan_fully_paid_date'];
			$fully_paid_loan_register[$i]['disburse_date']=$fully_paid_loan_register_row['disburse_date'];										
		}
		//echo "<pre>";print_r($admission_register_information);die;
		return $fully_paid_loan_register;
	} */
	function get_total_fully_paid_loan($branch_id=null,$product_id=null,$from_date=null)
	{
		$total_fully_paid_loan_register_sql ="SELECT SUM(loans.loan_amount) as total_pre_loan_principal
			FROM loans JOIN members ON members.id=loans.member_id
				JOIN samities ON loans.samity_id=samities.id
				JOIN loan_products ON loan_products.id=loans.product_id    
				JOIN loan_purposes ON loan_purposes.id=loans.purpose_id
			WHERE loans.product_id=? AND loans.loan_fully_paid_date<? ";
			if($branch_id>0)
			{
				$total_fully_paid_loan_register_sql .=" AND loans.branch_id= ?";				
			}				
			if($branch_id>0)
			{
				$total_fully_paid_loan_register_sql=$this->db->query($total_fully_paid_loan_register_sql, array($product_id,$from_date,$branch_id,));
			}
			else
			{			
				$total_fully_paid_loan_register_sql=$this->db->query($total_fully_paid_loan_register_sql, array($product_id,$from_date));
			}
		$total_fully_paid_loan_register=array();			
		foreach ($total_fully_paid_loan_register_sql->result_array() as $fully_paid_loan_register_row)
		{			
			$total_fully_paid_loan_register['total_pre_loan_principal']=$fully_paid_loan_register_row['total_pre_loan_principal'];													
		}
		//echo "<pre>";print_r($admission_register_information);die;
		return $total_fully_paid_loan_register;
	}
	
	// ****************************************************************************Savings Refund Register****************************************************************************
	function get_savings_refund_register_general_info($branch_id=null,$product_id=null,$from_date=null,$to_date=null)
	{
		$product_cond = '';
		$branch_cond = '';
		if(!is_null($branch_id)){$branch_cond = " AND savings.branch_id = '$branch_id'";}
		if(!is_null($product_id)){$product_cond = " AND savings.saving_products_id = '$product_id'";}
		$savings_refund_general_info_sql =	
			"SELECT A.*, B.*, C.* 
			FROM ( 
				SELECT members.id AS a_id,saving_deposits.transaction_date AS savings_s_transaction_date, saving_deposits.transaction_type AS saving_s_transactions_type, members.code AS members_s_code,members.name AS members_s_name, samities.id AS smities_s_id, samities.code AS samities_s_code, samities.name AS samities_s_name, SUM(saving_deposits.amount) AS deposit_amount
				FROM members JOIN savings ON members.id = savings.member_id 
				JOIN samities ON samities.id = members.samity_id 
				JOIN saving_deposits ON saving_deposits.savings_id = savings.id 
				JOIN saving_products ON saving_products.id = savings.saving_products_id 
				WHERE saving_deposits.transaction_date BETWEEN '$from_date' AND '$to_date'  
				AND saving_deposits.transaction_type = 'DEP' 
				$branch_cond $product_cond
				GROUP BY members_s_name,savings_s_transaction_date,members.id,saving_deposits.transaction_type,members.code,samities.id,samities.code,samities.name,savings.saving_products_id
				ORDER BY savings_s_transaction_date,members_s_name ASC 
			) AS A LEFT JOIN ( 
				SELECT members.id AS b_id,members.name AS members_w_name, saving_withdraws.transaction_date AS savings_w_transaction_date, saving_withdraws.transaction_type AS saving_w_transactions_type, SUM(saving_withdraws.amount) AS wdithdrawl_amount 
				FROM members JOIN savings ON members.id = savings.member_id 
				JOIN samities ON samities.id = members.samity_id 
				JOIN saving_withdraws ON saving_withdraws.savings_id = savings.id 
				JOIN saving_products ON saving_products.id = savings.saving_products_id 
				WHERE saving_withdraws.transaction_type = 'WIT' 
				AND saving_withdraws.transaction_date BETWEEN '$from_date' AND '$to_date' 
				$branch_cond $product_cond
				GROUP BY members.name,savings_w_transaction_date,members.id,members.name,saving_withdraws.transaction_date,saving_withdraws.transaction_type 
				ORDER BY savings_w_transaction_date,members_w_name,saving_w_transactions_type ASC 
			) AS B ON A.a_id = B.b_id LEFT JOIN ( 
				SELECT members.id AS c_id,members.name AS members_i_name, SUM(saving_products.interest_rate) AS interest_amount,saving_products.id,savings.saving_products_id
				FROM members JOIN savings ON members.id = savings.member_id 
				JOIN samities ON samities.id = members.samity_id 
				JOIN saving_deposits ON saving_deposits.savings_id = savings.id 
				JOIN saving_products ON saving_products.id = savings.saving_products_id 
				WHERE saving_deposits.transaction_date BETWEEN '$from_date' AND '$to_date' 
				AND saving_deposits.transaction_type = 'INT' 
				$branch_cond $product_cond
				GROUP BY savings.id,members.id,members.name,saving_products.interest_rate,saving_products.id,savings.saving_products_id
				ORDER BY saving_products.id ASC 
			) AS C ON B.b_id = C.c_id 
			ORDER BY A.savings_s_transaction_date,A.members_s_name ASC";
			
		$savings_refund_general_info_result = $this->db->query($savings_refund_general_info_sql);
		$savings_refund_information=array();
		$i=0;
		foreach ($savings_refund_general_info_result->result_array() as $savings_refund_information_row)
		{	
			$i++;					
			$savings_refund_information[$i]['a_id']=$savings_refund_information_row['a_id'];	
			$savings_refund_information[$i]['savings_s_transaction_date']=$savings_refund_information_row['savings_s_transaction_date'];
			$savings_refund_information[$i]['members_s_code']=$savings_refund_information_row['members_s_code'];
			$savings_refund_information[$i]['members_s_name']=$savings_refund_information_row['members_s_name'];
			$savings_refund_information[$i]['smities_s_id']=$savings_refund_information_row['smities_s_id'];
			$savings_refund_information[$i]['samities_s_code']=$savings_refund_information_row['samities_s_code'];
			$savings_refund_information[$i]['samities_s_name']=$savings_refund_information_row['samities_s_name'];
			$savings_refund_information[$i]['saving_s_transactions_type']=$savings_refund_information_row['saving_s_transactions_type'];
			$savings_refund_information[$i]['deposit_amount']=$savings_refund_information_row['deposit_amount'];
			
			$savings_refund_information[$i]['b_id']=$savings_refund_information_row['b_id'];	
			$savings_refund_information[$i]['members_w_name']=$savings_refund_information_row['members_w_name'];	
			$savings_refund_information[$i]['savings_w_transaction_date']=$savings_refund_information_row['savings_w_transaction_date'];	
			$savings_refund_information[$i]['saving_w_transactions_type']=$savings_refund_information_row['saving_w_transactions_type'];	
			$savings_refund_information[$i]['wdithdrawl_amount']=$savings_refund_information_row['wdithdrawl_amount'];
			
			$savings_refund_information[$i]['c_id']=$savings_refund_information_row['c_id'];	
			$savings_refund_information[$i]['members_i_name']=$savings_refund_information_row['members_i_name'];	
			//$savings_refund_information[$i]['savings_i_transaction_date']=$savings_refund_information_row['savings_i_transaction_date'];	
			//$savings_refund_information[$i]['saving_i_transactions_type']=$savings_refund_information_row['saving_i_transactions_type'];	
			$savings_refund_information[$i]['interest_amount']=$savings_refund_information_row['interest_amount'];
		}
		return $savings_refund_information;
	}
	// ********************** ****************** ****************** ****************
	// ********************** ****************** ****************** ****************
	//get_samity_branch_loan_init_info
	function get_samity_branch_loan_init_info($branch_id = null,$samity_id = null,$member_id = null,$month = null,$year = null)
	{
		$init_info_sql = "SELECT samities.name as samity_name,samities.code as samity_code,
							po_branches.name as branch_name,po_branches.code as branch_code,
							members.name as member_name,members.code as member_code,
							members.fathers_spouse_name as member_fathers_spouse_name,
							members.mothers_name as member_mothers_name,
							loans.loan_amount as loan_amount,
							loans.installment_amount as loan_installment_amount,
							loans.interest_rate as loan_interest_rate,
							loans.disburse_date as loan_disburse_date,
							loans.first_repayment_date as loan_first_repayment_date,
							loans.number_of_installment as number_of_loan_installment,
							loan_purposes.name as loan_purposes_name,
							loan_products.name as loan_product_name,
							members.*,samities.*,po_branches.*,loans.*
					FROM members JOIN samities ON members.samity_id = samities.id 
						JOIN po_branches ON po_branches.id = members.branch_id
						JOIN loans ON loans.member_id = members.id
						JOIN loan_products ON loan_products.id = loans.product_id
						JOIN loan_purposes ON loan_purposes.id = loans.purpose_id 
					WHERE members.id = '$member_id' 
					AND members.samity_id = '$samity_id' 
					/*AND members.branch_id = '$branch_id'*/";
		$init_info_result = $this->db->query($init_info_sql, array($branch_id,$samity_id,$member_id));
		//print_r($init_info_result);
		$samity_branch_loan_init_info = array();			
		foreach ($init_info_result->result_array() as $init_info)
		{			
			$samity_branch_loan_init_info['samity_name'] = $init_info['samity_name'];
			$samity_branch_loan_init_info['samity_code'] = $init_info['samity_code'];
			$samity_branch_loan_init_info['branch_name'] = $init_info['branch_name'];
			$samity_branch_loan_init_info['branch_code'] = $init_info['branch_code'];
			$samity_branch_loan_init_info['member_name'] = $init_info['member_name'];
			$samity_branch_loan_init_info['member_code'] = $init_info['member_code'];
			$samity_branch_loan_init_info['member_fathers_spouse_name'] = $init_info['member_fathers_spouse_name'];
			$samity_branch_loan_init_info['member_mothers_name'] = $init_info['member_mothers_name'];
			$samity_branch_loan_init_info['loan_amount'] = $init_info['loan_amount'];
			$samity_branch_loan_init_info['loan_installment_amount'] = $init_info['loan_installment_amount'];
			$samity_branch_loan_init_info['loan_interest_rate'] = $init_info['loan_interest_rate'];
			$samity_branch_loan_init_info['loan_disburse_date'] = $init_info['loan_disburse_date'];
			$samity_branch_loan_init_info['loan_first_repayment_date'] = $init_info['loan_first_repayment_date'];
			$samity_branch_loan_init_info['number_of_loan_installment'] = $init_info['number_of_loan_installment'];
			$samity_branch_loan_init_info['loan_purposes_name'] = $init_info['loan_purposes_name'];
			$samity_branch_loan_init_info['loan_product_name'] = $init_info['loan_product_name'];	
			$samity_branch_loan_init_info['repayment_frequency'] = $init_info['repayment_frequency'];	
			$samity_branch_loan_init_info['installment_amount'] = $init_info['installment_amount'];	
			$samity_branch_loan_init_info['loan_closing_date'] = $init_info['loan_closing_date'];
			$samity_branch_loan_init_info['samity_day'] = $init_info['samity_day'];
		}
		//print_r($samity_branch_loan_init_info);
		return $samity_branch_loan_init_info;
	}
	//get_loan_transaction_info
	function get_loan_transaction_info($branch_id = null,$samity_id = null,$member_id = null,$month = null,$year = null)
	{
		
		$loan_transaction_info_sql = 
						"SELECT members.id,members.name,loan_transactions.* 
						FROM members JOIN loans ON members.id = loans.member_id 
						JOIN loan_transactions ON loan_transactions.loan_id = loans.id 
						WHERE loans.member_id = '$member_id'
						AND loans.branch_id = '$branch_id'
						AND loans.samity_id = '$samity_id'
						AND loan_transactions.samity_id = '$samity_id'
						AND loan_transactions.branch_id = '$branch_id'
						AND loans.current_status = '1' 
						AND DATE_FORMAT(loan_transactions.transaction_date,'%Y-%m') BETWEEN DATE_FORMAT('2011-03-01','%Y-%m') AND DATE_FORMAT('2011-03-30','%Y-%m') 
						GROUP BY loan_transactions.transaction_date,loan_transactions.id,loan_transactions.loan_id,
						loan_transactions.product_id,loan_transactions.branch_id,loan_transactions.samity_id,
						loan_transactions.transaction_amount,loan_transactions.transaction_principal_amount,
						loan_transactions.transaction_interest_amount,loan_transactions.current_total_collection_amount,
						loan_transactions.current_outstanding_amount,loan_transactions.installment_number
						,loan_transactions.entry_by,loan_transactions.entry_date,loan_transactions.is_authorized,
						loan_transactions.authorization_date,loan_transactions.authorized_by,
						loan_transactions.is_auto_process,members.id,members.name 
						ORDER BY loan_transactions.transaction_date ASC";
		
						/*"SELECT members.id,members.name,loan_transactions.*
						FROM members JOIN loans ON members.id = loans.member_id
							JOIN loan_transactions ON loan_transactions.loan_id = loans.id
						WHERE loans.member_id = '$member_id'
						AND loans.branch_id = '$branch_id'
						AND loans.samity_id = '$samity_id'
						AND loan_transactions.samity_id = '$samity_id' 
						AND loan_transactions.branch_id = '$branch_id'
						AND loans.current_status = '1'
						GROUP BY loan_transactions.transaction_date
						ORDER BY loan_transactions.transaction_date ASC";*/
		$loan_transaction_info_result = $this->db->query($loan_transaction_info_sql, array($branch_id,$samity_id,$member_id));
		//echo '<pre>';
		//print_r($loan_transaction_info_result->result_array());
		//print_r($loan_transaction_info_result);
		$samity_branch_loan_init_info = array();			
		/*foreach ($init_info_result->result_array() as $init_info)
		{			
			$samity_branch_loan_init_info['samity_name'] = $init_info['samity_name'];
			$samity_branch_loan_init_info['samity_code'] = $init_info['samity_code'];
			$samity_branch_loan_init_info['branch_name'] = $init_info['branch_name'];
			$samity_branch_loan_init_info['branch_code'] = $init_info['branch_code'];
			$samity_branch_loan_init_info['member_name'] = $init_info['member_name'];
			$samity_branch_loan_init_info['member_code'] = $init_info['member_code'];
			$samity_branch_loan_init_info['member_fathers_spouse_name'] = $init_info['member_fathers_spouse_name'];
			$samity_branch_loan_init_info['member_mothers_name'] = $init_info['member_mothers_name'];
			$samity_branch_loan_init_info['loan_amount'] = $init_info['loan_amount'];
			$samity_branch_loan_init_info['loan_installment_amount'] = $init_info['loan_installment_amount'];
			$samity_branch_loan_init_info['loan_interest_rate'] = $init_info['loan_interest_rate'];
			$samity_branch_loan_init_info['loan_disburse_date'] = $init_info['loan_disburse_date'];
			$samity_branch_loan_init_info['loan_first_repayment_date'] = $init_info['loan_first_repayment_date'];
			$samity_branch_loan_init_info['number_of_loan_installment'] = $init_info['number_of_loan_installment'];
			$samity_branch_loan_init_info['loan_purposes_name'] = $init_info['loan_purposes_name'];
			$samity_branch_loan_init_info['loan_product_name'] = $init_info['loan_product_name'];	
		}
		//print_r($samity_branch_loan_init_info);*/
		return $loan_transaction_info_result;
	}
	
	// get holidays information as per
	// branch_id, samity_id, month, year
	function get_holiday_info($branch_id = null,$samity_id = null,$month = null,$year = null)
	{
		$start_date = $year.'-'.$month.'-'.'01';
		$end_date = $year.'-'.$month.'-'.'30';
		$holiday_info_sql =	" SELECT * FROM config_holidays 
							WHERE ((branch_id IS NULL) OR (branch_id = '$branch_id'))
							AND ((samity_id IS NULL) OR (samity_id = '$samity_id'))
							AND (holiday_date BETWEEN '$start_date' AND '$end_date')
							ORDER BY holiday_date ASC ";
		$holiday_info_result = $this->db->query($holiday_info_sql, array($branch_id,$samity_id,$start_date,$end_date));
		//echo '<pre>';
		//print_r($holiday_info_result->result_array());
		$holiday_info = array();
		$i = 0;
		foreach ($holiday_info_result->result_array() as $init_info)
		{
			$holiday_info[$i]['id'] = $init_info['id'];
			$holiday_info[$i]['branch_id'] = $init_info['branch_id'];
			$holiday_info[$i]['samity_id'] = $init_info['samity_id'];
			$holiday_info[$i]['holiday_date'] = $init_info['holiday_date'];
			$holiday_info[$i]['holiday_type'] = $init_info['holiday_type'];
			//$holiday_info[$i]['Description'] = $init_info['Description'];
			$i++;
		}
		return $holiday_info;
	}
	
	//get loan transaction information as per
	// 
	function get_loan_transaction_information($branch_id = null,$samity_id = null,$member_id = null,$month = null, $year = null)
	{
		$start_date = $year.'-'.$month.'-'.'01';
		$end_date = $year.'-'.$month.'-'.'30';
		$loan_transaction_sql =	
				"SELECT members.id,members.name,loan_transactions.* -- ,loans.*
				FROM members JOIN loans ON members.id = loans.member_id
					JOIN loan_transactions ON loan_transactions.loan_id = loans.id
				WHERE loans.member_id = '$member_id'
				AND loans.branch_id = '$branch_id'
				AND loans.samity_id = '$samity_id'
				AND loan_transactions.samity_id = '$samity_id' 
				AND loan_transactions.branch_id = '$branch_id'
				AND loans.current_status = '1'
				AND DATE_FORMAT(loan_transactions.transaction_date,'%Y-%m') BETWEEN DATE_FORMAT('$start_date','%Y-%m') AND DATE_FORMAT('$end_date','%Y-%m')
				GROUP BY loan_transactions.transaction_date,loan_transactions.id,loan_transactions.loan_id,
						loan_transactions.product_id,loan_transactions.branch_id,loan_transactions.samity_id,
						loan_transactions.transaction_amount,loan_transactions.transaction_principal_amount,
						loan_transactions.transaction_interest_amount,loan_transactions.current_total_collection_amount,
						loan_transactions.current_outstanding_amount,loan_transactions.installment_number
						,loan_transactions.entry_by,loan_transactions.entry_date,loan_transactions.is_authorized,
						loan_transactions.authorization_date,loan_transactions.authorized_by,
						loan_transactions.is_auto_process,members.id,members.name
				ORDER BY loan_transactions.transaction_date ASC";
		$loan_transaction_result = $this->db->query($loan_transaction_sql, array($branch_id,$samity_id,$start_date,$end_date));
		//echo '<pre>';
		//print_r($loan_transaction_result->result_array());
		$loan_transaction_info = array();
		$i = 0;
		foreach ($loan_transaction_result->result_array() as $init_info)
		{
			//print_r($init_info);
			$loan_transaction_info[$i]['name'] = $init_info['name'];
			$loan_transaction_info[$i]['loan_id'] = $init_info['loan_id'];
			$loan_transaction_info[$i]['product_id'] = $init_info['product_id'];
			$loan_transaction_info[$i]['branch_id'] = $init_info['branch_id'];
			$loan_transaction_info[$i]['samity_id'] = $init_info['samity_id'];
			$loan_transaction_info[$i]['transaction_date'] = $init_info['transaction_date'];
			$loan_transaction_info[$i]['transaction_amount'] = $init_info['transaction_amount'];
			$loan_transaction_info[$i]['transaction_principal_amount'] = $init_info['transaction_principal_amount'];
			$loan_transaction_info[$i]['transaction_interest_amount'] = $init_info['transaction_interest_amount'];
			$loan_transaction_info[$i]['current_total_collection_amount'] = $init_info['current_total_collection_amount'];
			$loan_transaction_info[$i]['current_outstanding_amount'] = $init_info['current_outstanding_amount'];
			$loan_transaction_info[$i]['installment_number'] = $init_info['installment_number'];
			$i++;
		}
		//print_r($loan_transaction_info);
		return $loan_transaction_info;
	}
	//get loan transaction information as per
	// 
	function get_loan_schedule_information($branch_id = null,$samity_id = null,$member_id = null,$month = null, $year = null)
	{	
		//echo $branch_id;echo '<br/>';
		//echo $member_id;echo '<br/>';
		//echo $samity_id;echo '<br/>';
		$start_date = $year.'-'.$month.'-'.'01';
		$end_date = $year.'-'.$month.'-'.'30';
		/*$branch_id=2;
		$samity_id=2559;
		$member_id = 38241;
		$loan_id = 1;*/
		/*$start_date = $year.'-'.$month.'-'.'01';
		$end_date = $year.'-'.$month.'-'.'30';
		$lloan_schedule_sql =	
				"SELECT members.id,members.name,loan_schedules.*
					FROM members JOIN loans ON members.id = loans.member_id
						JOIN loan_schedules ON loan_schedules.loan_id = loans.id
					WHERE loans.member_id = '39312'
					AND loans.branch_id = '2'
					AND loans.samity_id = '2596'
					AND loan_schedules.member_id = '39312' 
					AND loan_schedules.branch_id = '2'
					AND loans.current_status = '1'
					AND DATE_FORMAT(loan_schedules.schedule_date,'%Y-%m') BETWEEN DATE_FORMAT('2009-12-01','%Y-%m') AND DATE_FORMAT('2009-12-31','%Y-%m')
					GROUP BY loan_schedules.schedule_date
					ORDER BY loan_schedules.schedule_date ASC";
		$loan_schedule_result = $this->db->query($lloan_schedule_sql, array($branch_id,$samity_id,$start_date,$end_date));
		//echo '<pre>';
		//print_r($loan_schedule_result->result_array());
		$loan_schedule_info = array();
		$i = 0;
		foreach ($loan_schedule_result->result_array() as $init_info)
		{
			//print_r($init_info);
			$loan_schedule_info[$i]['name'] = $init_info['name'];
			$loan_schedule_info[$i]['loan_id'] = $init_info['loan_id'];
			$loan_schedule_info[$i]['member_id'] = $init_info['member_id'];
			$loan_schedule_info[$i]['branch_id'] = $init_info['branch_id'];
			$loan_schedule_info[$i]['samity_id'] = $init_info['samity_id'];
			$loan_schedule_info[$i]['installment_number'] = $init_info['installment_number'];
			$loan_schedule_info[$i]['installment_amount'] = $init_info['installment_amount'];
			$loan_schedule_info[$i]['principal_installment_amount'] = $init_info['principal_installment_amount'];
			$loan_schedule_info[$i]['interest_installment_amount'] = $init_info['interest_installment_amount'];
			$loan_schedule_info[$i]['schedule_date'] = $init_info['schedule_date'];
			$i++;
		}
		//print_r($loan_transaction_info);
		return $loan_schedule_info;*/
		//print_r($this->scheduler1->get_loan_schedules($branch_id,$samity_id,$member_id,$loan_id));
		$scheduler_res = $this->scheduler1->get_loan_schedules($branch_id,$samity_id,$member_id,null,$start_date,$end_date);
		//print_r($scheduler_res);
		//if(empty($scheduler_res)){echo 'empty';$scheduler_res='';die;}
		//$scheduler_res='';
		return $scheduler_res;
	}
	
	//get savings deposit transaction information as per
	// 
	function get_savings_transaction_information($branch_id = null,$samity_id = null,$member_id = null,$month = null, $year = null)
	{
		$start_date = $year.'-'.$month.'-'.'01';
		$end_date = $year.'-'.$month.'-'.'30';
		$sav_dep_transaction_sql =	
				"SELECT saving_deposits.*
				FROM savings JOIN saving_deposits ON savings.id = saving_deposits.savings_id
				WHERE savings.member_id = '$member_id'
				AND savings.samity_id = '$samity_id'
				AND savings.branch_id = '$branch_id'
				AND saving_deposits.transaction_type = 'DEP'
				AND DATE_FORMAT(saving_deposits.transaction_date,'%Y-%m') BETWEEN DATE_FORMAT('$start_date','%Y-%m') AND DATE_FORMAT('$end_date','%Y-%m')
				ORDER BY saving_deposits.transaction_date ASC";
		$sav_dep_transaction_result = $this->db->query($sav_dep_transaction_sql, array($branch_id,$samity_id,$start_date,$end_date));
		//echo '<pre>';
		//print_r($sav_dep_transaction_result->result_array());
		$sav_dep_transaction = array();
		$i = 0;
		foreach ($sav_dep_transaction_result->result_array() as $init_info)
		{
			//print_r($init_info);
			//$sav_dep_transaction[$i]['name'] = $init_info['name'];
			$sav_dep_transaction[$i]['savings_id'] = $init_info['savings_id'];
			$sav_dep_transaction[$i]['member_id'] = $init_info['member_id'];
			$sav_dep_transaction[$i]['branch_id'] = $init_info['branch_id'];
			$sav_dep_transaction[$i]['samity_id'] = $init_info['samity_id'];
			$sav_dep_transaction[$i]['transaction_date'] = $init_info['transaction_date'];
			$sav_dep_transaction[$i]['transaction_type'] = $init_info['transaction_type'];
			$sav_dep_transaction[$i]['amount'] = $init_info['amount'];
			$sav_dep_transaction[$i]['mode_of_payment'] = $init_info['mode_of_payment'];
			$i++;
		}
		//print_r($sav_dep_transaction);
		return $sav_dep_transaction;
	}
}
