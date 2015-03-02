<style>
.formContainer	label {
	    display: block;
	    float: left;
	    height: 20px;
	    width: 35%;
		}
.formContainer	ol{width:auto;}
.formContainer	ol li {
		/*min-height: 20px!important;*/
	}
</style>
<script type="text/javascript">
	//datepicker
	$(function(){
		$("#txt_po_establishment_date").datepicker({dateFormat: 'yy-mm-dd'});
		$("#txt_sw_start_date_of_operation").datepicker({dateFormat: 'yy-mm-dd'});	
	});
</script>
<?php                                   
echo form_open_multipart('config_generals/edit');
$img_name = '/media/images/add_big.png';
$class_name = 'class="formTitleBar_edit"';
$select_class = 'class="input_select"';
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2><?php echo $headline;?></h2>
				</div>				
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('config_generals')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan=2>
				<div class="formContainer" style="border:none;width:98%">
					<ol> 
						<li>
							<label for="txt_po_name">Organization Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								$attr = array('name'=>'txt_po_name','id'=>'txt_po_name','class'=>'input_textbox','maxlength'=>'150');
								echo form_input($attr,set_value('txt_po_name',isset($row->po_name)?$row->po_name:""));
								echo form_error('txt_po_name'); 
							?>
                            </div>
						</li>  
						<li>
							<label for="txt_po_code">Organization Code:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								$attr = array('name'=>'txt_po_code','id'=>'txt_po_code','class'=>'input_textbox','maxlength'=>'50');
								echo form_input($attr,set_value('txt_po_code',isset($row->po_code)?$row->po_code:""));
								echo form_error('txt_po_code'); 
							?>
                            </div>
						</li>  
						<li>
							<label for="txt_po_establishment_date">Organization Establishment Date:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								$attr = array('name'=>'txt_po_establishment_date','id'=>'txt_po_establishment_date','class'=>'input_textbox','maxlength'=>'10');
								echo form_input($attr,set_value('txt_po_establishment_date',isset($row->po_establishment_date)?$row->po_establishment_date:""));
								echo form_error('txt_po_establishment_date'); 
							?>
                            </div>
						</li>  
						<li>
							<label for="txt_po_logo">Organization Logo:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_hidden('txt_po_logo_edit',isset($row->po_logo)?$row->po_logo:"");	?>
								<input type="file" id="txt_po_logo"  name="txt_po_logo" size="20" />
								<span class="explain" id="explain">File must be .jpg, .gif or .png</span>				<span style="float:right;"><?php if (isset($row->po_logo)) echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->po_logo,'border'=>'0','alt'=>'','width'=>'25','height'=>'25'))?></span>	<?php echo form_error('txt_po_logo'); ?>
                            </div>
						</li>  
						<li>
							<label for="txt_sw_start_date_of_operation">Software Start date of Operation:</label>
                            <div class="form_input_container">
							<?php 
								$attr = array('name'=>'txt_sw_start_date_of_operation','id'=>'txt_sw_start_date_of_operation','class'=>'input_textbox','maxlength'=>'10');
								echo form_input($attr,set_value('txt_sw_start_date_of_operation',isset($row->sw_start_date_of_operation)?$row->sw_start_date_of_operation:""));
								echo form_error('txt_sw_start_date_of_operation'); 
							?>
                            </div>
						</li>  
						<li>
							<label for="txt_default_interest_calculation_method">Default Interest Calculation Method:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_default_interest_calculation_method',$interest_calculation_methods,set_value('cbo_default_interest_calculation_method',isset($row->default_interest_calculation_method)?$row->default_interest_calculation_method:"",'id="cbo_default_interest_calculation_method"'));
								echo form_error('cbo_default_interest_calculation_method'); 
							?>
                            </div>
						</li>  
						<li>
							<label for="txt_is_other_interest_calculation_method_allowed">Is Other Interest Calculation Method Allowed?<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_is_other_interest_calculation_method_allowed',$options,set_value('cbo_is_other_interest_calculation_method_allowed',isset($row->is_other_interest_calculation_method_allowed)?$row->is_other_interest_calculation_method_allowed:"",'id="cbo_is_other_interest_calculation_method_allowed"'));
								echo form_error('cbo_is_other_interest_calculation_method_allowed'); 
							?>
                            </div>
						</li>  
						<li>
							<label for="cbo_is_multiple_loan_allowed_for_primary_products">Is Multiple Loan Allowed for Primary Products?<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_is_multiple_loan_allowed_for_primary_products',$options,set_value('cbo_is_multiple_loan_allowed_for_primary_products',isset($row->is_multiple_loan_allowed_for_primary_products)?$row->is_multiple_loan_allowed_for_primary_products:""));
								echo form_error('cbo_is_multiple_loan_allowed_for_primary_products'); 
							?>
                            </div>
						</li>
						<li>
							<label for="cbo_financial_year_start_month">Financial Year Start Month<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								
								echo form_dropdown('cbo_financial_year_start_month',$financial_year_start_month,set_value('cbo_financial_year_start_month',isset($row->financial_year_start_month)?$row->financial_year_start_month:"",'id="cbo_financial_year_start_month"'));
								echo form_error('cbo_financial_year_start_month'); 
							?>
                            </div>
						</li>
						<li>
							<label for="cbo_savings_balance_used_for_interest_calculation">Saving Balance used for Interest Calculation<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_savings_balance_used_for_interest_calculation',$savings_balance_used,set_value('cbo_savings_balance_used_for_interest_calculation',isset($row->savings_balance_used_for_interest_calculation)?$row->savings_balance_used_for_interest_calculation:"",'id="cbo_savings_balance_used_for_interest_calculation"'));
								echo form_error('cbo_savings_balance_used_for_interest_calculation'); 
							?>
                            </div>
						</li>
						<li>
							<label for="txt_savings_minimum_balance_required_for_interest_calculation">Minimum Balance required for Interest Calculation<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								$attr = array('name'=>'txt_savings_minimum_balance_required_for_interest_calculation','id'=>'txt_savings_minimum_balance_required_for_interest_calculation');
								echo form_input($attr,set_value('txt_savings_minimum_balance_required_for_interest_calculation',isset($row->savings_minimum_balance_required_for_interest_calculation)?$row->savings_minimum_balance_required_for_interest_calculation:""));
								echo form_error('txt_savings_minimum_balance_required_for_interest_calculation'); 
							?>
                            </div>
						</li>						
						<li>
							<label for="txt_savings_minimum_account_duration_to_receive_interest">Minimum Account Duration to receive interest<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								
								echo form_dropdown('cbo_savings_minimum_account_duration_to_receive_interest',$frequency_in_months,set_value('cbo_savings_minimum_account_duration_to_receive_interest',isset($row->savings_minimum_account_duration_to_receive_interest)?$row->savings_minimum_account_duration_to_receive_interest:""));
								echo form_error('cbo_savings_minimum_account_duration_to_receive_interest'); 
							?>
                            </div>
						</li>
						<li>
							<label for="cbo_savings_is_inactive_member_eligible_to_receive_interest">Is Inactive member eligible to receive interest?<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_savings_is_inactive_member_eligible_to_receive_interest',$options,set_value('cbo_savings_is_inactive_member_eligible_to_receive_interest',isset($row->savings_is_inactive_member_eligible_to_receive_interest)?$row->savings_is_inactive_member_eligible_to_receive_interest:"",'id="cbo_savings_is_inactive_member_eligible_to_receive_interest"'));
								echo form_error('cbo_savings_is_inactive_member_eligible_to_receive_interest'); 
							?>
                            </div>
						</li>
						<li>
							<label for="cbo_savings_frequency_of_interest_posting_to_accounts">Frequency of Interest Posting to Accounts<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_savings_frequency_of_interest_posting_to_accounts',$frequency_in_months,set_value('cbo_savings_frequency_of_interest_posting_to_accounts',isset($row->savings_frequency_of_interest_posting_to_accounts)?$row->savings_frequency_of_interest_posting_to_accounts:"",'id="cbo_savings_frequency_of_interest_posting_to_accounts"'));
								echo form_error('cbo_savings_frequency_of_interest_posting_to_accounts');
							?>
                            </div>
						</li>
						
						
						<li>
							<label for="cbo_savings_interest_calculation_closing_month">Interest Calculation Closing Month<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_savings_interest_calculation_closing_month',$month_list,set_value('cbo_savings_interest_calculation_closing_month',isset($row->savings_interest_calculation_closing_month)?$row->savings_interest_calculation_closing_month:""));
								echo form_error('cbo_savings_interest_calculation_closing_month');
							?>
                            </div>
						</li>
						<li>
							<label for="cbo_savings_interest_disbursment_month">Interest Dsibursment Month<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_dropdown('cbo_savings_interest_disbursment_month',$month_list,set_value('cbo_savings_interest_disbursment_month',isset($row->savings_interest_disbursment_month)?$row->savings_interest_disbursment_month:""));
								echo form_error('cbo_savings_interest_disbursment_month');
							?>
                            </div>
						</li>
						
						<li>
							<label for="txt_report_header_line_1">Report Header Line #1<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php 
								echo form_input(array('name'=>'txt_report_header_line_1','class'=>'input_textbox','maxlength'=>'50'),set_value('txt_report_header_line_1',isset($row->report_header_line_1)?$row->report_header_line_1:""));
								echo form_error('txt_report_header_line_1'); 
							?>
                            </div>
						</li>
						<li>
							<label for="txt_report_header_line_2">Report Header Line #2<span class="required_field_indicator"></span></label>
                            <div class="form_input_container">
							<?php 
								echo form_input(array('name'=>'txt_report_header_line_2','class'=>'input_textbox','maxlength'=>'50'),set_value('txt_report_header_line_2',isset($row->report_header_line_2)?$row->report_header_line_2:""));
								echo form_error('txt_report_header_line_2'); 
							?>
                            </div>
						</li>
						<li>
							<label for="txt_report_header_line_3">Report Header Line #3<span class="required_field_indicator"></span></label>
                            <div class="form_input_container">
							<?php 
								echo form_input(array('name'=>'txt_report_header_line_3','class'=>'input_textbox','maxlength'=>'50'),set_value('txt_report_header_line_3',isset($row->report_header_line_3)?$row->report_header_line_3:""));
								echo form_error('txt_report_header_line_3'); 
							?>
                            </div>
						</li>
						<li>
							<label for="txt_report_footer_line_1">Report Footer Line #1<span class="required_field_indicator"></span></label>
                            <div class="form_input_container">
							<?php 
								echo form_input(array('name'=>'txt_report_footer_line_1','class'=>'input_textbox','maxlength'=>'50'),set_value('txt_report_footer_line_1',isset($row->report_footer_line_1)?$row->report_footer_line_1:""));
								echo form_error('txt_report_footer_line_1'); 
							?>
                            </div>
						</li>
						<li>
							<label for="txt_report_footer_line_2">Report Footer Line #2<span class="required_field_indicator"></span></label>
                            <div class="form_input_container">
							<?php 
								echo form_input(array('name'=>'txt_report_footer_line_2','class'=>'input_textbox','maxlength'=>'50'),set_value('txt_report_footer_line_2',isset($row->report_footer_line_2)?$row->report_footer_line_2:""));
								echo form_error('txt_report_footer_line_2'); 
							?>
                            </div>
						</li>
					</ol>
				</div>
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
                    <?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('config_generals')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>

