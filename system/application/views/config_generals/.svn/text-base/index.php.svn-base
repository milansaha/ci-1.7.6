<style>
	label {
	    display: block;
	    float: left;
	    height: 20px;
	    width: 35%;
	    font-weight: bold;
	}
	ol li {
		min-height: 20px!important;
	}
</style>
<fieldset>
	<div id="execute_div">
		<div id="execute_link">
			<?php echo anchor('/config_generals/edit','Edit Configuration')?>
		</div>
	</div>
	<table class="uiInfoTableConfig" width="650px" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr><th colspan="2"><img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;<?php echo $headline;?></th></tr>
			<tr>
				<td width="40%" align="left" class="field-label">Organization Name:</td>
				<td class="field-items"><?php echo empty($config_general->po_name)?'':$config_general->po_name;?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Organization Code:</label></td>
				<td class="field-items"><?php echo empty($config_general->po_code)?'':$config_general->po_code;?></td>
			</tr>	
			<tr>
				<td width="40%" align="left" class="field-label">Organization Establishment Date:</label></td>
				<td class="field-items"><?php echo empty($config_general->po_establishment_date)?'':$config_general->po_establishment_date;?></td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Software Start date of Operation:</label></td>
				<td class="field-items"><?php  echo empty($config_general->sw_start_date_of_operation)?'':$config_general->sw_start_date_of_operation;?></td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Default Interest Calculation Method:</label></td>
				<td class="field-items">
					<?php 
						$method = "";
						if(!empty($config_general->default_interest_calculation_method)){
							if($config_general->default_interest_calculation_method == 'FLAT') {
								$method = 'FLAT METHOD';
							}
							elseif($config_general->default_interest_calculation_method == 'REDUCING') {
								$method = 'DECLINING BALANCE';
							}
						}
						echo $method;
					?>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Is Other Interest Calculation Method Allowed?</b></td>
				<td class="field-items">
					<span>
						<?php 
							if(isset($config_general->is_other_interest_calculation_method_allowed))					
								echo $config_general->is_other_interest_calculation_method_allowed?"Yes":"No";
						?>
					</span>
				</td>	
			</tr>	
			<tr>
				<td width="40%" align="left" class="field-label">Is Loan Allowed for Multiple Primary Product?</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->is_multiple_loan_allowed_for_primary_products))
							echo ($config_general->is_multiple_loan_allowed_for_primary_products)?"Yes":"No";
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Financial Year Start Month</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->financial_year_start_month))
							echo ($config_general->financial_year_start_month);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Saving Balance used for Interest Calculation</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_balance_used_for_interest_calculation))
							echo ($config_general->savings_balance_used_for_interest_calculation);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Minimum Balance required for Interest Calculation</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_minimum_balance_required_for_interest_calculation))
							echo ($config_general->savings_minimum_balance_required_for_interest_calculation);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Minimum Account Duration to receive interest</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_minimum_account_duration_to_receive_interest))
							echo ($config_general->savings_minimum_account_duration_to_receive_interest).' Month';
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Is Inactive member eligible to receive interest?</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_is_inactive_member_eligible_to_receive_interest))
							echo ($config_general->savings_is_inactive_member_eligible_to_receive_interest)?"Yes":"No";;
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Frequency of Interest Posting to Accounts</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_frequency_of_interest_posting_to_accounts))
							echo ($config_general->savings_frequency_of_interest_posting_to_accounts).' Month';
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Interest Calculation Closing Month</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_interest_calculation_closing_month))
							echo ($config_general->savings_interest_calculation_closing_month);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Interest Disbursment Month</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->savings_interest_disbursment_month))
							echo ($config_general->savings_interest_disbursment_month);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Report Header Line #1</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->report_header_line_1))
							echo ($config_general->report_header_line_1);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Report Header Line #2</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->report_header_line_2))
							echo ($config_general->report_header_line_2);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Report Header Line #3</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->report_header_line_3))
							echo ($config_general->report_header_line_3);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Report Footer Line #1</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->report_footer_line_1))
							echo ($config_general->report_footer_line_1);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Report Footer Line #2</b></td>
				<td class="field-items">
				<span>
					<?php
						if(isset($config_general->report_footer_line_2))
							echo ($config_general->report_footer_line_2);
					 ?>
				</span>
				</td>	
			</tr>
			<tr>
				<td width="40%" align="left" valign="top" class="field-label">Organization Logo:</label></td>
				<td class="field-items">
					<?php if(isset($config_general->po_logo)): ?>
					<img src="<?php  echo 'http://localhost/microfin/'.IMAGE_UPLOAD_PATH.$config_general->po_logo;?>" alt="Logo">				
					<?php endif; ?>
				</td>	
			</tr>
		</tbody>
    </table>
</fieldset>
