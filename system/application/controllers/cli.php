<?php
/** 
	* Auths Controller Class.
	* @pupose		Manage user authentication
	*		
	* @filesource	\app\controllers\auths.php	
	* @package		microfin 
	* @subpackage	microfin.controller.auts
	* @version      $Revision: 1 $
	* @author       $Author: Saroj Roy $	
	* @lastmodified $Date: 2011-04-02 $	 
*/ 
	
class Cli extends Controller {

	var $birth_date="";
	var $start_date="";
	var $end_date="";
	var $degree=array();
	
	var $interest_calculation_method=array();
	var $interest_rate=array();
	var $minimum_loan_amount=array();
	var $default_loan_amount=array();
	var $maximum_loan_amount=array();
	
	var $days=array();
	var $gender_type=array();
	
	var $member_type=array();
	var $member_status=array();
	
	var $bulk_insert_no=0;
	
	function __construct()
	{
		if (isset($_SERVER['REMOTE_ADDR'])) {  
			die('Command Line Only!');  
		}
		set_time_limit(0);
		parent::__construct();
		$this->start_date = date("Y-m-d",strtotime("-1 year"));
		$this->end_date = date("Y-m-d");
		$this->birth_date=date("Y-m-d",strtotime("-20 year"));
		$this->degree=array('S.S.C','H.S.C','Bachelors','Masters');
		
		$this->interest_calculation_method=array('DECLINING_METHOD','FLAT');
		$this->interest_rate=array(10,12,12.5,15,33);
		$this->minimum_loan_amount=array(0,500,1000,5000);
		$this->default_loan_amount=array(2500,3500,5000,7500);
		$this->maximum_loan_amount=array(5000,7500,10000,15000);
		
		$this->days=array('Sat','Sun','Mon','Tue','Wed','Thu');
		$this->gender_type=array('M','F');
		
		$this->member_type=array('General','Group Leader','Samity Leader');
		$this->member_status=array('Active','Inactive');
		
		$this->bulk_insert_no=10000;
		
		$this->load->model(array('Po_branch','Po_division','Po_district','Po_thana','Po_unions_or_ward','Po_village_or_block','Employee_department','Employee_designation','Loan_product_category','Po_funding_organization','Loan_product','Po_working_area','Employee','Samity','Member','Saving_product','Loan_purpose'),'',TRUE);
	}
	
	function cli_index($data=null)
	{
		echo "CLI text".$data."\n";
	}
	
	function create_ALL($input){
		$this->branch_entry($input);
		$this->division_entry($input);
		$this->district_entry($input);
		$this->thana_entry($input);
		$this->union_or_ward_entry($input);
		$this->village_or_block_entry($input);
		$this->working_area_entry($input);
		$this->employee_department_entry($input);
		$this->employee_designations_entry($input);
		$this->loan_product_category_entry($input);
		$this->funding_organization_entry($input);
		
		$this->loan_product_entry($input);
		//$this->employee_designations_entry($input);
		$this->employee_entry($input);
		$this->samity_entry($input);
		
		$this->loan_purpose_entry($input);
		$this->member_entry($input);
		
		
	}
	
	
	function create_ALL_S(){
		$this->branch_entry(100);
		$this->division_entry(8);
		$this->district_entry(8);
		$this->thana_entry(8);
		$this->union_or_ward_entry(10);
		$this->village_or_block_entry(10);
		$this->working_area_entry(1);
		$this->employee_department_entry(10);
		$this->employee_designations_entry(2);
		$this->loan_product_category_entry(10);
		$this->funding_organization_entry(5);
		
		$this->loan_product_entry(1);
		//$this->employee_designations_entry($input);
		$this->employee_entry(2);
		$this->samity_entry(1);
		
		$this->loan_purpose_entry(10);
		$this->member_entry(2);
		
		$this->savings_product_entry(10);
		$this->savings_entry(2);
	}
	
	function branch_entry($no_of_branches){
		$insert_data=array();
		for($index=1;$index<=$no_of_branches;$index++){
			$branch=array('name'=>'Branch_'.$index,'code'=>'Branch_code_'.$index,'opening_date'=>$this->start_date,'address'=>'Branch_'.$index.'_address');
			//$this->Po_branch->add($branch);
			array_push($insert_data,$branch);
		}
		$this->db->insert_batch('po_branches', $insert_data);
	}
	
	function division_entry($no_of_divisions){
		$insert_data=array();
		for($index=1;$index<=$no_of_divisions;$index++){
			$division=array('name'=>'Division_'.$index);
			//$this->Po_division->add($division);
			array_push($insert_data,$division);
		}
		//print_r($insert_data);die;
		$this->db->insert_batch('po_divisions', $insert_data);
	}
	
	function district_entry($no_of_districts_per_division){
		$insert_data=array();
		$divisions=$this->Po_division->get_list(null,null,null);
		foreach($divisions as $key=>$division){
			for($index=1;$index<=$no_of_districts_per_division;$index++){
				$district=array('division_id'=>$division->id,'name'=>'District_'.$key.'_'.$index);
				//$this->Po_district->add($district);
				array_push($insert_data,$district);
			}
		}
		$this->db->insert_batch('po_districts', $insert_data);
	}
	
	function thana_entry($no_of_thana_per_districts){
		$insert_data=array();
		$districts=$this->Po_district->get_list(null,null,null);
		foreach($districts as $key=>$district){
			for($index=1;$index<=$no_of_thana_per_districts;$index++){
				$thana=array('division_id'=>$district->division_id,'district_id'=>$district->id,'name'=>'Thana_'.$key.'_'.$index);
				//$this->Po_thana->add($thana);
				array_push($insert_data,$thana);
			}
		}
		$this->db->insert_batch('po_thanas', $insert_data);
	}
	
	function union_or_ward_entry($no_of_union_or_ward_per_thana){
		$insert_data=array();
		$thanas=$this->Po_thana->get_list(null,null,null);
		foreach($thanas as $key=>$thana){
			for($index=1;$index<=$no_of_union_or_ward_per_thana;$index++){
				$union_or_ward=array('division_id'=>$thana->division_id,'district_id'=>$thana->district_id,'thana_id'=>$thana->id,'name'=>'Union_or_Ward_'.$key.'_'.$index);
				//$this->Po_unions_or_ward->add($union_or_ward);
				array_push($insert_data,$union_or_ward);
			}
		}
		$this->db->insert_batch('po_unions_or_wards', $insert_data);
	}
	
	
	function village_or_block_entry($no_village_or_block_per_union_or_ward){
		$insert_data=array();
		$union_or_wards=$this->Po_unions_or_ward->get_list(null,null,null);
		foreach($union_or_wards as $key=>$union_or_ward){
			for($index=1;$index<=$no_village_or_block_per_union_or_ward;$index++){
				$village_or_block=array('division_id'=>$union_or_ward->division_id,'district_id'=>$union_or_ward->district_id,'thana_id'=>$union_or_ward->thana_id,'union_or_ward_id'=>$union_or_ward->id,'name'=>'Village_or_Block_'.$key.'_'.$index);
				//$this->Po_village_or_block->add($village_or_block);
				array_push($insert_data,$village_or_block);
			}
		}
		$this->db->insert_batch('po_village_or_blocks', $insert_data);
	}
	
	function working_area_entry($no_working_area_per_village_or_block){
		$insert_data=array();
		$village_or_blocks=$this->Po_village_or_block->get_list(null,null,null);
		foreach($village_or_blocks as $key=>$village_or_block){
			for($index=1;$index<=$no_working_area_per_village_or_block;$index++){
				$working_area=array('village_or_block_id'=>$village_or_block->id,'name'=>'Working_Area_'.$key.'_'.$index);
				//$this->Po_working_area->add($working_area);
				array_push($insert_data,$working_area);
			}
		}
		$this->db->insert_batch('po_working_areas', $insert_data);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function employee_department_entry($no_of_employee_department){
		$insert_data=array();
		for($index=1;$index<=$no_of_employee_department;$index++){
			$employee_department=array('name'=>'Employee_Department_'.$index,'code'=>'Employee_Department_code_'.$index,'mnemonic'=>'EDep_'.$index);
			//$this->Employee_department->add($employee_department);
			array_push($insert_data,$employee_department);
		}
		$this->db->insert_batch('employee_departments', $insert_data);
	}
	
	
	function employee_designations_entry($no_of_employee_designations_per_employee_department){
		//$no_of_employee_designations_per_employee_department=1;
		$insert_data=array();
		$employee_departments=$this->Employee_department->get_list(null,null,null);
		foreach($employee_departments as $key=>$employee_department){
			for($index=1;$index<=$no_of_employee_designations_per_employee_department;$index++){
				$is_manager=mt_rand(0,1);
				$report_sorting_order=mt_rand(1,$no_of_employee_designations_per_employee_department*count($employee_departments));
				
			
				$employee_designation=array('department_id'=>$employee_department->id,'name'=>'Employee_Designation_'.$key.'_'.$index,'code'=>'Employee_Designation_code_'.$key.'_'.$index,'mnemonic'=>'EDes_'.$key.'_'.$index,'is_manager'=>$is_manager,'report_sorting_order'=>$report_sorting_order);
								
				//$this->Employee_designation->add($employee_designation);
				array_push($insert_data,$employee_designation);
			}
		}
		//print_r($insert_data);die;
		$this->db->insert_batch('employee_designations', $insert_data);
		
	}
		
	function loan_product_category_entry($no_of_loan_product_category){
		
		$insert_data=array();
		for($index=1;$index<=$no_of_loan_product_category;$index++){
			
			$loan_product_category=array('name'=>'Loan_Product_Category'.$index,'short_name'=>'Lo_Pro_Cat'.$index);
			//$this->Loan_product_category->add($loan_product_category);
			array_push($insert_data,$loan_product_category);
		}
		$this->db->insert_batch('loan_product_categories', $insert_data);
	}
	
	function funding_organization_entry($no_of_funding_organizations){
		
		$insert_data=array();
		for($index=1;$index<=$no_of_funding_organizations;$index++){
			$funding_organization=array('name'=>'Funding_Organization'.$index,'concern_person'=>'Concern_Person'.$index,'address'=>'Concern_Person'.$index,'land_phone'=>$index.$index,'mobile_phone'=>$index.$index,'email'=>'Concern_Person'.$index.'@Concern_Person'.$index.'com');
			//$this->Po_funding_organization->add($funding_organization);
			array_push($insert_data,$funding_organization);
		}
		$this->db->insert_batch('po_funding_organizations', $insert_data);
	}
	
	function loan_product_entry($no_of_loan_product_per_category){
		$insert_data=array();
		$loan_product_categories=$this->Loan_product_category->get_list(null,null,null);
		$funding_organizations=$this->Po_funding_organization->get_list(null,null,null);
		foreach($funding_organizations as $key1=>$funding_organization){
			foreach($loan_product_categories as $key2=>$loan_product_category){
				for($index=1;$index<=$no_of_loan_product_per_category;$index++){
					
					$interest_calculation_method_index=mt_rand(0,count($this->interest_calculation_method)-1);
					$loan_info_index=mt_rand(0,count($this->minimum_loan_amount)-1);
					$loan_product=array('name'=>'Loan_Product_'.$key2.'_'.$index,'short_name'=>'Lo_Pro_'.$key2.'_'.$index,'code'=>'Loan_Product_code_'.$key2.'_'.$index,'loan_product_category_id'=>$loan_product_category->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date,'interest_calculation_method'=>$this->interest_calculation_method[$interest_calculation_method_index],'minimum_loan_amount'=>$this->minimum_loan_amount[$loan_info_index],'default_loan_amount'=>$this->default_loan_amount[$loan_info_index],'maximum_loan_amount'=>$this->maximum_loan_amount[$loan_info_index],'funding_organization_id'=>$funding_organization->id);
					//$this->Loan_product->add($loan_product);
					array_push($insert_data,$loan_product);
				}
			}
		}
		$this->db->insert_batch('loan_products', $insert_data);
	}
	
	
	function employee_entry($no_of_employees_per_branch){
		$insert_data=array();
		$branches=$this->Po_branch->get_list(null,null,null);
		$employee_designations=$this->Employee_designation->get_list(null,null,null);
		$loan_products=$this->Loan_product->get_list(null,null,null);
		foreach($branches as $key1=>$branch){
			foreach($employee_designations as $key2=>$employee_designation){
				for($index=1;$index<=$no_of_employees_per_branch;$index++){
					$starting_salary=mt_rand(1,5000);
					$current_salary=$starting_salary+mt_rand(500,5000);
					$national_id='100000000'.mt_rand(1000,9999);
					$status=mt_rand(0,1);
					$is_field_officer=mt_rand(0,1);
					$degree_index=mt_rand(0,count($this->degree)-1);
					
					$employee=array('branch_id'=>$branch->id,'designation_id'=>$employee_designation->id,'name'=>'Employee_'.$key2.'_'.$index,'code'=>'Employee_code_'.$key2.'_'.$index,
					'fathers_name'=>'Employee_'.$key2.'_'.$index.'Father','mothers_name'=>'Employee_'.$key2.'_'.$index.'Mother',
					'date_of_joining'=>$this->start_date,'date_of_birth'=>$this->birth_date,
					'secuirity_money'=>0,'starting_salary'=>$starting_salary,'current_salary'=>$current_salary,'national_id'=>$national_id,
					'status'=>$status,'permanent_address'=>'Employee_'.$key2.'_'.$index.'Permanent_Address',
					'present_address'=>'Employee_'.$key2.'_'.$index.'Present_Address','last_achieved_degree'=>$this->degree[$degree_index],
					'is_field_officer'=>$is_field_officer
					);
					//$this->Employee->add($employee);
					array_push($insert_data,$employee);
				}
			}
		}
		//print_r($insert_data);die;
		$this->db->insert_batch('employees', $insert_data);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function samity_entry($no_of_samities_per_branch){
		$insert_data=array();
		$today = date("Y-m-d");
		$branches=$this->Po_branch->get_list(null,null,null);
		$working_areas=$this->Po_working_area->get_list(null,null,null);
		$field_officers=$this->Employee->get_field_officer_info();
		$loan_products=$this->Loan_product->get_list(null,null,null);
		$employees=$this->Employee->get_list(null,null,null);
		
		foreach($branches as $key1=>$branch){
			//foreach($working_areas as $key2=>$working_area){
				//foreach($field_officers as $key3=>$field_officer){
					foreach($loan_products as $key4=>$loan_product){
						//foreach($employees as $key5=>$employee){
							
							for($index=1;$index<=$no_of_samities_per_branch;$index++){
								$key5=mt_rand(0,count($employees)-1);
								$employee=$employees[$key5];
								
								$key2=mt_rand(0,count($working_areas)-1);
								$working_area=$working_areas[$key2];
								
								$key3=mt_rand(0,count($field_officers)-1);
								$field_officer=$field_officers[$key3];
								
								//$report_sorting_order=mt_rand(1,$no_of_employee_designations_per_employee_department*count($employee_departments));
								$day_index=mt_rand(0,count($this->days)-1);
								$type_index=mt_rand(0,count($this->gender_type)-1);
								$skt_amnt=0.00;
								if($this->gender_type[$type_index]=='F'){
									$skt_amnt=mt_rand(1,10);
								}
								$status=mt_rand(0,1);
								$samity=array(
								'branch_id'=>$branch->id,'working_area_id'=>$working_area->id,
								'field_officer_id'=>$field_officer->field_officer_id,
								'product_id'=>$loan_product->id,
								'name'=>'Samity_'.$key2.'_'.$key3.'_'.$key4.'_'.$key5.'_'.$index,'code'=>'Samity_code_'.$key2.'_'.$key3.'_'.$key4.'_'.$key5.'_'.$index,'samity_day'=>$this->days[$day_index],'samity_type'=>$this->gender_type[$type_index],
								'opening_date'=>$this->start_date,'skt_amount'=>$skt_amnt,'created_by'=>$employee->id,'created_date'=>$this->start_date,'status'=>$status,
								'id_sequence_no'=>mt_rand(1,$no_of_samities_per_branch));
								//$this->Samity->add($samity);
								array_push($insert_data,$samity);
							}
						//}
					}
				//}
			//}
		}
		$this->db->insert_batch('samities', $insert_data);
	}
	
	function loan_purpose_entry($no_of_loan_purpose){
		
		$insert_data=array();
		for($index=1;$index<=$no_of_loan_purpose;$index++){
			$sort_order=mt_rand(1,$no_of_loan_purpose);
			$loan_purpose=array('name'=>'Loan_Purpose_'.$index,'code'=>'Loan_Purpose_code_'.$index,
			'description'=>'Loan_Purpose_des_'.$index,'sort_order'=>$sort_order);
			//$this->Loan_product_category->add($loan_product_category);
			array_push($insert_data,$loan_purpose);
		}
		$this->db->insert_batch('loan_purposes', $insert_data);
	}
	
	function member_entry($no_of_members){
		echo "<pre>In member_entry</pre>";
		
		$branches=$this->Po_branch->get_list(null,null,null);
		$samities=$this->Samity->get_list(null,null,null);
		$loan_products=$this->Loan_product->get_list(null,null,null);
		$employees=$this->Employee->get_list(null,null,null);
		
		$villages=$this->Po_village_or_block->get_list(null,null,null);
		
		$insert_data=array();
		//foreach($branches as $key1=>$branch){
			foreach($samities as $key2=>$samity){
				foreach($loan_products as $key3=>$loan_product){
					for($index=1;$index<=$no_of_members;$index++){
						$member_type_index=mt_rand(0,count($this->member_type)-1);
						$marital_status=array('Married','Unmarried');
						$father_spouse_name=array('father','spouse');
						$marital_status_index=mt_rand(0,1);
						$father_spouse_name_index=0;
						if($marital_status_index==0){
							$father_spouse_name_index=mt_rand(0,1);
						}
						$gender_index=mt_rand(0,1);
						$status_index=0;//mt_rand(0,1);
						$degree_index=mt_rand(0,count($this->degree)-1);
						
						$income=mt_rand(1000,30000);
						$national_id='100000000'.mt_rand(1000,9999);
						
						$created_by_index=mt_rand(0,count($employees)-1);
						//print_r($samity);die;
						
						$village_index=mt_rand(0,count($villages)-1);
						$member=array('branch_id'=>$samity->branch_id,'samity_id'=>$samity->id,'primary_product_id'=>$loan_product->id,
						'member_type'=>$this->member_type[$member_type_index],'marital_status'=>$marital_status[$marital_status_index],
						'fathers_spouse_name'=>'Member_'.$key2.'_'.$key3.'_'.$index.'_'.$father_spouse_name[$father_spouse_name_index],
						'mothers_name'=>'Member_'.$key2.'_'.$key3.'_'.$index.'_mother','fathers_spouse_relationship'=>$father_spouse_name[$father_spouse_name_index],
						'date_of_birth'=>$this->birth_date,'name'=>'Member_'.$key2.'_'.$key3.'_'.$index,'code'=>'Member_'.$key2.'_'.$key3.'_'.$index.'_code',
						'registration_no'=>'Member_'.$key2.'_'.$key3.'_'.$index.'_reg','registration_date'=>$this->start_date,'form_application_no'=>mt_rand(1,999).$key2.$key3,
						'gender'=>$this->gender_type[$gender_index],'member_status'=>$this->member_status[$status_index],
						'last_achieved_degree'=>mt_rand(0,14),'no_of_family_member'=>mt_rand(1,8),'yearly_income'=>$income,
						'national_id'=>$national_id,'created_by'=>$employees[$created_by_index]->id,'created_on'=>$this->start_date,
						'id_sequence_no'=>mt_rand(1,$no_of_members),'present_village_ward'=>$villages[$village_index]->id);
						array_push($insert_data,$member);
						if(count($insert_data)>$this->bulk_insert_no){
							$this->db->insert_batch('members', $insert_data);
							$insert_data=array();
						}
						
					}
				}
			}
		//}
		
		$this->db->insert_batch('members', $insert_data);
	}
	
	function savings_product_entry($no_of_savings_product){
	
		$insert_data=array();
		$type_of_deposit=array('MANDATORY','VOLUNTARY');
		for($index=1;$index<=$no_of_savings_product;$index++){
			$type_of_deposit_index=mt_rand(0,1);
			$savings_product=array('name'=>'Savings_Product_'.$index,'short_name'=>'S_P_'.$index,'start_date'=>$this->start_date,
			'type_of_deposit'=>$type_of_deposit[$type_of_deposit_index],'mandatory_amount_for_deposit'=>mt_rand(0,20),
			'interest_rate'=>mt_rand(0,25)
			);
			array_push($insert_data,$savings_product);
		}
		$this->db->insert_batch('saving_products', $insert_data);
	
	}
	
	function savings_entry($no_of_savings){
		echo "<pre>In Savings Entry</pre>";
				
		$insert_data=array();

		$members=$this->Member->get_list(null,null,null);
		$saving_products=$this->Saving_product->get_list(null,null,null);
		$funding_organizations=$this->Po_funding_organization->get_list(null,null,null);
		$employees=$this->Employee->get_list(null,null,null);
		
		
		foreach($members as $key=>$member){
			for($index=1;$index<=$no_of_savings;$index++){
				$saving=array(
				'code'=>'Savings_'.$key.'_'.$index,'branch_id'=>$member->branch_id,'samity_id'=>$member->samity_id,
				'member_id'=>$member->id,'saving_products_id'=>mt_rand(0,count($saving_products)-1),'funding_organization_id'=>mt_rand(0,count($funding_organizations)-1),
				'opening_date'=>$this->start_date,'created_by'=>mt_rand(0,count($employees)-1)
				);
				
				array_push($insert_data,$saving);
				if(count($insert_data)>$this->bulk_insert_no){
					$this->db->insert_batch('savings', $insert_data);
					$insert_data=array();
				}
			}
		}
		$this->db->insert_batch('savings', $insert_data);
	}
	
	
	
	function loan_entry($no_of_savings){
		echo "<pre>In Loan Entry</pre>";
				
		$insert_data=array();

		$members=$this->Member->get_list(null,null,null);
		$loan_products=$this->Loan_product->get_list(null,null,null);
		$loan_purposes=$this->Loan_purpose->get_list(null,null,null);
		$funding_organizations=$this->Po_funding_organization->get_list(null,null,null);
		
		$interest_calculation_method=array('FLAT','DECLINING_METHOD');
		$repayment_frequency=array('DAILY','WEEKLY','MONTHLY','YEARLY');
		$mode_of_interest=array('YEARLY_PER_HUNDRED','YEARLY_PER_THOUSAND');
		
		
		$employees=$this->Employee->get_list(null,null,null);
		
		
		foreach($members as $key=>$member){
			for($index=1;$index<=$no_of_savings;$index++){
				
				$loan_purposes_index=mt_rand(0,count($loan_purposes)-1);
				$loan_products_index=mt_rand(0,count($loan_products)-1);
				$funding_organizations_index=mt_rand(0,count($funding_organizations)-1);
				
				$interest_calculation_method_index=mt_rand(0,count($interest_calculation_method)-1);
				$loan_amount=mt_rand(1000,10000);
				$interest_rate=mt_rand(10,35);
				$interest_amount=($loan_amount*$interest_rate)/100;
				$number_of_installment=mt_rand(23,68);
				
				$repayment_frequency_index=mt_rand(0,count($repayment_frequency)-1);
				$loan_period_in_month=mt_rand(1,18);
				$mode_of_interest_index=mt_rand(0,count($mode_of_interest)-1);
				$total_payable=$loan_amount+$interest_amount;
				$principal_installment_amount=$loan_amount/$number_of_installment;
				$installment_amount=$total_payable/$number_of_installment;
				
				$is_authorized=mt_rand(0,1);
				$authorized_by=NULL;
				if($is_authorized){
					$authorized_by=mt_rand(0,count($employees)-1);
				}
				
				$loans=array(
				'customized_loan_no'=>'Cus_Loan_No_'.$key.'_'.$index,'loan_application_no'=>'Loan_App_No_'.$key.'_'.$index,
				'branch_id'=>$member->branch_id,'samity_id'=>$member->samity_id,'product_id'=>$loan_products[$loan_products_index]->id,
				'member_id'=>$member->id,'purpose_id'=>$loan_purposes[$loan_purposes_index]->id,'funding_org_id'=>$funding_organizations[$funding_organizations_index]->id,
				'interest_calculation_method'=>$interest_calculation_method[$interest_calculation_method_index],
				'loan_amount'=>$loan_amount,'interest_rate'=>$interest_rate,'interest_amount'=>$interest_amount,'discount_interest_amount'=>0,
				'insurance_amount'=>0,'total_payable_amount'=>$total_payable,'number_of_installment'=>$number_of_installment,
				'principal_installment_amount'=>$principal_installment_amount,'installment_amount'=>$installment_amount,
				'repayment_frequency'=>$repayment_frequency[$repayment_frequency_index],'loan_period_in_month'=>$loan_period_in_month,
				'mode_of_interest'=>$mode_of_interest[$mode_of_interest_index],'interest_rate_calculation_amount'=>0,
				'cycle'=>1,'first_repayment_date'=>$this->start_date,'is_authorized'=>$is_authorized,'disburse_registration_no'=>0,
				'disbursed_by'=>mt_rand(0,count($employees)-1),'disburse_date'=>$this->start_date,'authorized_by'=>$authorized_by,
				'authorization_date'=>$this->start_date,'fully_paid_registration_no'=>0,'is_loan_fully_paid'=>0,'current_status'=>1
				);
				
				array_push($insert_data,$loans);
				if(count($insert_data)>$this->bulk_insert_no){
					$this->db->insert_batch('loans', $insert_data);
					$insert_data=array();
				}
			}
		}
		$this->db->insert_batch('loans', $insert_data);
	}
	
	function holiday_entry($no_of_holiday){
		
		$insert_data=array();
		
		$branches=$this->Po_branch->get_list(null,null,null);
		$samities=$this->Samity->get_list(null,null,null);
		
		$holiday=$this->start_date;
		$today=date("Y-m-d");
		
		while($holiday<=$today){
			$date=strtotime($holiday);
			$date=strtotime('next Firday',$date);
			echo $date;
			$holiday=date('Y-m-d',$date);
			print $date;die;
			array_push($insert_data,array('holiday_date'=>$holiday,'holiday_type'=>'Weekly','description'=>'Friday'));
			echo $holiday.'<br/>';
		}
		
		$this->db->insert_batch('config_holidays', $insert_data);
		
	}
	
	function savings_transaction_entry($no_of_savings_transaction){
	}
	
	function loan_transaction_entry($no_of_loan_transaction){
	}
	
	
	
}
