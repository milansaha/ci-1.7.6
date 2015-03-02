<?php
/** 
 * main menu configuration 
 * Copyright 2008-2009, DataSoft Systems Bangladesh Limited (http://www.datasoft-bd.com)
 *
 * Redistributions of files is not allowed without written permission from DataSoft.
 *
 * @filesource    \app\views\elements\main_menu.php
 * @copyright     Copyright 2008-2009, DataSoft Systems Bangladesh Limited (http://www.datasoft-bd.com)
 * @link          http://www.datasoft-bd.com
 * @package       mra-mfi-mis
 * @since         mra-mfi-mis v 0.1
 * @version       $Revision: 1167 $
 * @author        $Author: Saroj Roy
 * @modifiedby    $LastChangedBy: $
 * @lastmodified  $Date: 20011-04-12$
 * @license       Commercial License
 */

 ?>
<!-- Navigation item -->
<ul>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/administration_24.png" border="0" alt="administrator" />&nbsp;Admin</a>
		<ul>
			<li><?php echo anchor('/users/','Manage User')?></li>
			<li><?php echo anchor('/user_roles/','Manage User Role')?></li>
			<li><?php echo anchor('/users/change_password','Change Password')?></li>					
			<li><?php echo anchor('/user_audit_trails/','User Audit Trail')?></li>
			<li><?php echo anchor('/user_access_logs/','User Access Log')?></li>
			<li><?php echo anchor('/auths/logout/','Logout')?></li>		
		</ul>
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/configuration_16.png" border="0" alt="configuration" />&nbsp;Config</a>
		<ul>
			<li><?php echo anchor('/config_generals/','General Configuration')?></li>
			<li><?php echo anchor('/config_holidays/','Holiday Configuration')?></li>
			<li><?php echo anchor('#','Address configuration',array( 'onclick'=>'return false;'))?>
				<ul>
					<li><?php echo anchor('/po_divisions/','Divisions')?></li>
					<li><?php echo anchor('/po_districts/','Districts')?></li>
					<li><?php echo anchor('/po_thanas/','Thanas')?></li>
					<li><?php echo anchor('/po_unions_or_wards/','Unions/Wards')?></li>
					<li><?php echo anchor('/po_village_or_blocks/','Villages/blocks')?></li>
					<li><?php echo anchor('/po_working_areas/','Working Areas')?></li>
				</ul>
			</li>
			<li><?php echo anchor('/po_branches/','Branches')?></li>
			<li><?php echo anchor('/po_funding_organizations/','Funding Organizations')?></li>
			<li><?php echo anchor('/loan_product_categories/','Loan Product Category')?></li>
			<li><?php echo anchor('/loan_products/','Loan Products')?></li>
			<li><?php echo anchor('/saving_products/','Savings Product')?></li>
			<li><?php echo anchor('educational_qualifications','Educational Qualifications');?></li>		
			<li><?php echo anchor('/po_areas/','Areas')?></li>
			<li><?php echo anchor('/po_zones/','Zones')?></li>
			<li><?php echo anchor('/po_regions/','Regions')?></li>										
		</ul>		
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/user_16.png" border="0" alt="staffs" />&nbsp;Employees</a>
		<ul>
			<li><?php echo anchor('/employee_departments/','Employee Departments')?></li>	
			<li><?php echo anchor('/employee_designations/','Employee Designations')?></li>
			<li><?php echo anchor('/employees/','Employees')?></li>					
			<li><?php echo anchor('/employee_promotions/','Employee Promotion')?></li>
			<li><?php echo anchor('/employee_branch_transfers','Employee Branch Transfer')?></li>
			<li><?php echo anchor('/employee_terminations','Employee Termination')?></li>
		</ul>		
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/loan_24.png" border="0" alt="loans" />&nbsp;Samity</a>
		<ul>
			<li><?php echo anchor('/samities/','Samities')?></li>
			<li><?php echo anchor('/samity_groups/','Samity Groups')?></li>			
			<li><?php echo anchor('/samity_subgroups/','Samity SubGroups')?></li>	
			<li><?php echo anchor('/samity_employee_changes/','Samity Field Officer Change')?></li>	
			<li><?php echo anchor('/samity_day_changes/','Samity Day Change')?></li>	
			<li><?php echo anchor('samity_closings','Samity Closings')?></li>		
		</ul>              
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/organization_16.png" border="0" alt="Members" />&nbsp;Members</a>
		<ul>
			<li><?php echo anchor('/members/','Member Information')?></li>						
			<li><?php echo anchor('/member_transfers/','Member Samity Transfer')?></li>
			<li><?php echo anchor('/member_products/','Member Primary Product Transfer')?></li>
			<li><?php echo anchor('/member_closings/','Member Closing')?></li>							
		</ul>		
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/savings_24.png" border="0" alt="Loan & Savings" />&nbsp;Loan & Savings</a>
		<ul>
			<li><?php echo anchor('/savings/','Savings')?></li>
			<li><?php echo anchor('/saving_deposits/','Savings Deposit')?></li>
			<li><?php echo anchor('/saving_withdraws/','Savings Withdraw')?></li>
			<li><?php echo anchor('/skt_collections/','SKT Collection')?></li>
			<li><?php echo anchor('/product_interest_rates/','Product Interest Rate')?></li>
			<li><?php echo anchor('/one_time_loan_accounts/','One Time Loan Accounts')?></li> 
			<li><?php echo anchor('/loans/','Regular Loan Accounts')?></li> 
			<li><?php echo anchor('/loan_reschedules/','Loan Reschedule')?></li>
			<li><?php echo anchor('/loan_purposes/','Loan Purposes')?></li>
			<li><?php echo anchor('/loan_transactions/','Loan Transactions')?></li>
		</ul>             
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/transaction_20.png" border="0" alt="Process" />&nbsp;Process</a>
		<ul>
			<li><?php echo anchor('/transactions/auto_process/','Auto Process')?></li>				
			<li><?php echo anchor('/transaction_authorizations/authorization_index','Transaction Authorization')?></li>				
			<li><?php echo anchor('/saving_deposits/authorization_index','Savings Deposit Authorization')?></li>				
			<li><?php echo anchor('/saving_withdraws/authorization_index','Savings Withdraw Authorization')?></li>				
			<li><?php echo anchor('/skt_collections/authorization_index','SKT Collection Authorization')?></li>				
			<li><?php echo anchor('/loans/authorization_index','Loan Authorization')?></li>				
			<li><?php echo anchor('/loan_transactions/authorization_index','Loan Transaction Authorization')?></li>				
			<li><?php echo anchor('/process_day_ends/','Day End Process')?></li>				
			<li><?php echo anchor('/process_month_ends/','Month End Process')?></li>			
		</ul>             
	</li>
	<li><a href="#" onclick='return false;'><img src="<?php echo base_url();?>media/images/report_16.png" border="0" alt="Reports" />&nbsp;Reports</a>
		<ul>
			<li><?php echo anchor('#','POMIS Reports',array( 'onclick'=>'return false;'))?>
				<ul>
					<li><?php echo anchor('/po_mis_reports/po_mis_1_index/','POMIS 1 report')?></li>
					<li><?php echo anchor('/po_mis_reports/po_mis_2_index/','POMIS 2 report')?></li>
					<li><?php echo anchor('/po_mis_reports/po_mis_3_index/','POMIS 3 report')?></li>
				</ul>
			</li>
			<li><?php echo anchor('#','Regular & General Report - (Branch Level)',array( 'onclick'=>'return false;'))?>
				<ul>
					<li><?php echo anchor('/regular_and_general_reports/component_wise_daily_collection_report_index/','Daily collection report')?></li>
					<li><?php echo anchor('/regular_and_general_reports/branch_manager_report_index/',"Branch Managers reports")?></li>
					<li><?php echo anchor('/regular_and_general_reports/field_worker_report_index/',"Field officers reports")?>	</li>
					<li><?php echo anchor('/regular_and_general_reports/loan_field_officer_wise_index/',"Loan Report (Officer Wise)")?></li>
					<li><?php echo anchor('/regular_and_general_reports/loan_classification_and_dmr_index/',"Loan Classification & DMR")?></li>
					<li><?php echo anchor('/regular_and_general_reports/samity_wise_monthly_loan_and_savings_collection_sheet_index/','Monthly collection sheet')?></li>
					<li><?php echo anchor('/regular_and_general_reports/samity_wise_monthly_loan_and_savings_working_sheet_index/','Monthly working sheet')?></li>
				</ul>
			</li>		
			<li><?php echo anchor('#','Register Report - (Branch Level)',array( 'onclick'=>'return false;'))?>
				<ul>
					<li><?php echo anchor('/register_reports/admission_register_index/','Admission register')?></li>
					<li><?php echo anchor('/register_reports/savings_refund_register_report_index/','Savings refund register')?></li>
					<li><?php echo anchor('/register_reports/loan_disbursement_master_report_index/','Loan disbursement register')?></li>
					<li><?php echo anchor('/register_reports/fully_paid_loan_register_index/','Fully paid loan register')?></li>
					<li><?php echo anchor('/register_reports/member_cancellation_register_index/','Member cancellation register')?></li>
					<li><?php echo anchor('/register_reports/member_wise_subsidy_loan_saving_ledger_index/','Loan and savings ledger')?></li>
				</ul>
			</li>
			<li><?php echo anchor('consolidated_reports/consolidated_balancing_report_index/','Consolidated Balancing')?></li>
			<li><?php echo anchor('additional_reports/ratio_analysis_statement_index/','Ratio analysis statement')?></li>
			<li><?php echo anchor('additional_reports/consolidated_ratio_analysis_statement_index/','Consolidated ratio analysis')?></li>
			<li><?php echo anchor('pass_book_reports','Pass Book Report');?></li>
			<li><?php echo anchor('branchwise_samity_reports','Branch Wise Samity List');?></li>
			<li><?php echo anchor('samitywise_member_reports','Samity Wise Member List');?></li>
		</ul>             
	</li>
</ul>
          
