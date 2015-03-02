<script type="text/javascript">
	$(function(){
	$("#txt_start_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_end_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
    $is_primary_products = array(1=>"Yes",0=>"No");
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('loan_product_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("loan_products/$action",'',$hidden_input);
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2><?php echo $headline?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_products')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>
                        <li>
							<label for="txt_name">Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name',isset($row->name)?$row->name:""));?><?php echo form_error('txt_name'); ?>
							</div>
						</li>
						<li>			
							<label for="cbo_loan_product_category">Loan Product Category:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_loan_product_category', $loan_product_categories,set_value('cbo_loan_product_category',isset($row->loan_product_category_id)?$row->loan_product_category_id:""),'id="cbo_loan_product_category" class="input_select"');?><?php echo form_error('cbo_loan_product_category');?>
							</div>
						</li>
						<li>
							<label for="txt_short_name">Short Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_short_name','id'=>'txt_short_name','class'=>'input_textbox','maxlength'=>'10'),set_value('txt_short_name',isset($row->short_name)?$row->short_name:""));?><?php echo form_error('txt_short_name'); ?>			
                            </div>
                        </li>
						<li>
							<label for="txt_code">Code:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_code','id'=>'txt_code','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_code',isset($row->code)?$row->code:""));?><?php echo form_error('txt_code'); ?>
                            </div>
						</li>						
						<li>
							<label for="txt_start_date">Start Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_start_date','id'=>'txt_start_date','class'=>"date_picker"),set_value('txt_start_date',isset($row->start_date)?$row->start_date:""));?><?php echo form_error('txt_start_date'); ?>
							 <div class="hints"> YYYY-MM-DD</div>
							</div>
						</li>
						<li>
							<label for="txt_end_date">End Date:</label>
                            <div class="form_input_container">
                            <?php echo form_input(array('name' => 'txt_end_date','id' => 'txt_end_date','class'=> 'date_picker'),set_value('txt_end_date', (isset($row->end_date))?$row->end_date:""));?>							
							<div class="hints"> YYYY-MM-DD</div>
                            </div>
                        </li>
						<li>
							<label for="cbo_is_primary_product">Is Primary Product:</label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_is_primary_product', $is_primary_products,isset($row->is_primary_product)?$row->is_primary_product:"",'id="cbo_is_primary_product" class="input_select"');?><?php echo form_error('cbo_is_primary_product'); ?>
                            </div>
						</li>
						<li>			
							<label for="cbo_interest_calculation_method">Interest Calculation Method:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_interest_calculation_method', $interest_calculation_methods,set_value('cbo_interest_calculation_method',isset($row->interest_calculation_method)?$row->interest_calculation_method:""),'id="cbo_interest_calculation_method"','class="input_select"');?><?php echo form_error('cbo_interest_calculation_method'); ?>			
                            </div>
                        </li>
						<li>
							<label for="txt_interest_rate">Interest Rate:</label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_interest_rate','id'=>'txt_interest_rate'),set_value('txt_interest_rate',isset($row->interest_rate)?$row->interest_rate:""));?><?php echo form_error('txt_interest_rate'); ?>			
                            </div>
                        </li>
						<li>
							<label for="txt_minimum_loan_amount">Minimum Loan Amount:</label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_minimum_loan_amount','id'=>'txt_minimum_loan_amount'),set_value('txt_minimum_loan_amount',isset($row->minimum_loan_amount)?$row->minimum_loan_amount:""));?><?php echo form_error('txt_minimum_loan_amount'); ?>			
                            </div>
                        </li>
						<li>
							<label for="txt_maximum_loan_amount">Maximum Loan Amount:</label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_maximum_loan_amount','id'=>'txt_maximum_loan_amount'),set_value('txt_maximum_loan_amount',isset($row->maximum_loan_amount)?$row->maximum_loan_amount:""));?><?php echo form_error('txt_maximum_loan_amount'); ?>			
                            </div>
                        </li>
						<li>
							<label for="txt_default_loan_amount">Default Loan Amount:</label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_default_loan_amount','id'=>'txt_default_loan_amount','class'=>'input_textbox'),set_value('txt_default_loan_amount',isset($row->default_loan_amount)?$row->default_loan_amount:""));?><?php echo form_error('txt_default_loan_amount'); ?>
                            </div>
                        </li>
						<li>			
							<label for="cbo_funding_organization">Funding Organization:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_funding_organization', $funding_organizations,set_value('cbo_funding_organization',isset($row->funding_organization_id)?$row->funding_organization_id:""),'id="cbo_funding_organization"','class="input_check"');?><?php echo form_error('cbo_funding_organization'); ?>
							</div>
						</li>
					</ol>
				</div>
			</td>
			<td valign="top" style="background:url(<?php echo base_url();?>media/images/alpona.gif) no-repeat bottom right;">
				<p class="helper"></p>
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_products')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	<?php if (form_error('txt_name') != '') { ?>
		$("#txt_name").focus();
	<?php } elseif (form_error('txt_short_name') != '') { ?>
		$("#txt_short_name").focus();
	<?php } elseif (form_error('txt_code') != '') { ?>
		$("#txt_code").focus();
	<?php } elseif (form_error('cbo_loan_product_category') != '') { ?>
		$("#cbo_loan_product_category").focus();
	<?php } elseif (form_error('txt_start_date') != '') { ?>
		$("#txt_start_date").focus();
	<?php } elseif (form_error('txt_end_date') != '') { ?>
		$("#txt_end_date").focus();
	<?php } elseif (form_error('cbo_interest_calculation_method') != '') { ?>
		$("#cbo_interest_calculation_method").focus();
	<?php } elseif (form_error('txt_interest_rate') != '') { ?>
		$("#txt_interest_rate").focus();
	<?php } elseif (form_error('txt_minimum_loan_amount') != '') { ?>
		$("#txt_minimum_loan_amount").focus();
	<?php } elseif (form_error('txt_maximum_loan_amount') != '') { ?>
		$("#txt_maximum_loan_amount").focus();
	<?php } elseif (form_error('txt_default_loan_amount') != '') { ?>
		$("#txt_default_loan_amount").focus();
	<?php } elseif (form_error('cbo_funding_organization') != '') { ?>
		$("#cbo_funding_organization").focus();
	<?php } else { ?>
		$("#txt_name").focus();
	<?php } ?>
});
</script>
