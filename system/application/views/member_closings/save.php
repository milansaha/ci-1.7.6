<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
$(function(){
	$("#txt_closing_date").datepicker({dateFormat:'yy-mm-dd'});
});
</script>	
<script type="text/javascript">
$(document).ready(function() {
$("#member_info").autocomplete('<?php echo site_url("members/ajax_get_member_list_auto/")?>', {
		minChars: 0,
		width: 310,
		matchContains: "word",
		highlightItem: true,
		formatItem: function(row, i, max, term) {
			var tmp;
			tmp=row[0].split(",");
			return "<strong>"+tmp[1]+"</strong>" + "<br><span style='font-size: 80%;'>Branch: " + tmp[2] + "<br>Samity: " + tmp[3] + "<br>Working area: " + tmp[4] + "</span>";
		},
		formatResult: function(row) {
			var tmp;
			tmp=row[0].split(",");
			return tmp[1];
		}
		}).result(function(e, item) 
		{
			//myCallback();
			var tmp;
			tmp=item[0].split(",");
			$("#member_id").attr('value',tmp[0]);
			// JSON part
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_member_id = tmp[0];
			//alert(selected_member_id);
			$.post("<?php echo site_url('members/ajax_for_get_member_info_by_id') ?>", { member_id: selected_member_id },
			function(data)
			{
				$('#status').html("");
				$('#test').empty();
				$('#current_saving_info').empty();
				$('#loan_info').empty();
				//$('#new_samity').empty();
				if( data.status == 'failure' )
				{
					alert(data.message);
					//$('#cbo_samity').append('<option value = "">--Select--</option>');
				}
				else
				{
					//alert(data.status);
					// new samity text box attribute change
					$('#new_samity_name').removeAttr('readonly');
					$('#new_samity_name').attr('value','');
					//$('#from_samity_row').removeAttr('style');
					$('#loan_info').append("<p>Member Name : <b>" + data.member.name + "</b>, Member Code : <b>" + data.member.code + "</b><br> Samity Name : <b>" + data.samity.name + "</b>, Samity Code : <b>" + data.samity.code + "</b><br> Working area : <b>" + data.working_area.name + "</b>, Village : <b>" + data.village.name + "</b>, Branch : <b>" + data.branch.name + "</b> </p>");
					if(data.loan.id.length > 0) {
						// Loan Information
						$('#test').append('<tr><th>Loan No</th><th>Loan Amount</th><th>Interest Amount</th><th>Discount Amount</th><th>Total Payable Amount</th><th>Total Instalment</th><th>Last Installment No</th><th>Last Repayment Date</th><th>Total Repayment Amount</th><th>Due Amount</th></tr>');
						for(var i = 0; i < data.loan.id.length; i++)
						{					
							$('#test').append("<tr><td>"+data.loan.customized_loan_no[i]+"</td><td>"+data.loan.loan_amount[i]+"</td><td>"+data.loan.interest_amount[i]+"</td><td>"+data.loan.discount_interest_amount[i]+"</td><td>"+data.loan.total_payable_amount[i]+"</td><td>"+data.loan.number_of_installment[i]+"</td><td>"+data.loan.last_installment_number[i]+"</td><td>"+data.loan.last_repayment_date[i]+"</td><td>"+data.loan.total_repayment_amount[i]+"</td><td><input type='hidden' name='loan_id[]' id='loan_id_"+data.loan.id[i]+"' value='"+data.loan.id[i]+"' /><input type='text' name='loan_paid_amount[]' id='loan_paid_amount_"+data.loan.id[i]+"' value='"+(data.loan.total_payable_amount[i] - data.loan.total_repayment_amount[i])+"' /></td></tr>");
						}
					}
					if(data.saving.id.length > 0) {
						// Current Saving Information
						$('#current_saving_info').append('<tr><th>Saving Code</th><th>Product</th><th>Opening Date</th><th>Weekly Savings</th><th>Total Deposit</th><th>Total Withdraw</th><th>Total Saving</th><th>Remaining Amount</th></tr>');
						for(var i = 0; i < data.saving.id.length; i++)
						{					
							$('#current_saving_info').append("<tr><td>"+data.saving.code[i]+"</td><td>"+data.saving.product_mnemonic[i]+"</td><td> "+data.saving.opening_date[i]+"</td><td> "+data.saving.weekly_savings[i]+"</td><td> "+data.saving.deposit_amount[i]+"</td><td> "+data.saving.withdraw_amount[i]+"</td><td> "+(data.saving.deposit_amount[i] - data.saving.withdraw_amount[i])+"</td><td><input type='hidden' name='saving_id[]' id='saving_id_"+data.saving.id[i]+"' value='"+data.saving.id[i]+"' /><input type='text' name='saving_withdraw_amount[]' id='saving_withdraw_amount_"+data.saving.id[i]+"' value='"+(data.saving.deposit_amount[i] - data.saving.withdraw_amount[i])+"' /></td></tr>");
						}
					}
				}
			}, "json");
		});
		// end member info
});
</script>

<?php
    if(isset($member_samity_info[0])) {
		$member_samity_info = $member_samity_info[0];
	}
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('member_closing_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("member_closings/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('member_closings')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="txt_closing_date">Member Closing Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<input type="text" id="txt_closing_date" name="txt_closing_date"  value="<?php echo isset($row->closing_date)?$row->closing_date:""?>" maxlength='100' class='input_textbox' />
							<?php echo form_error('txt_closing_date'); ?>
							</div>
						</li> 
						<li>
							<label for="cbo_department">Member:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($member_samity_info->member_id)?$member_samity_info->member_id:""?>" />
							<input type="text" id="member_info" value="<?php echo isset($member_samity_info->member_name)?$member_samity_info->member_name:""?>" maxlength='255' class='input_textbox' />
							<?php //echo anchor('members/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Member')),array('class'=>'addimglink','alt'=>'Add Member','title'=>'Add Member')); ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Member','width'=>'12px')), 'add_member', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Member','onclick'=>"window.location.href='".site_url('members/add')."'"));?></div>
							<?php echo form_error('member_id'); ?>
							</div>			
						</li>
						<li>
							<div>
								<div id="loan_info">
									<?php 
										if(isset($member_samity_info)) 
										{
											//print_r($member_samity_info);
										?>
										<p>Member Name : <b><?php echo $member_samity_info->member_name?></b>, Member Code : <b><?php echo $member_samity_info->member_code?></b><br> Samity Name : <b><?php echo $member_samity_info->samity_name?></b>, Samity Code : <b><?php echo $member_samity_info->samity_code?></b><br> Working area : <b><?php echo $member_samity_info->working_area_name?></b>, Village : <b><?php echo $member_samity_info->village_name?></b>, Branch : <b><?php echo $member_samity_info->branch_name?></b> </p>
									<?php }?>
								</div>
								<table id="test" class="sortable" cellspacing="0px" cellpadding="0">
								<?php
									if(isset($member_loan_info[0]->loan_id))
									{
										?>
										<tr><th>Loan No</th><th>Loan Amount</th><th>Interest Amount</th><th>Discount Amount</th><th>Total Payable Amount</th><th>Total Instalment</th><th>Last Installment No</th><th>Last Repayment Date</th><th>Total Repayment Amount</th><th>Due Amount</th></tr>
										<?php
										foreach($member_loan_info as $member_loan)
										{
											?>
											<tr><td><?php echo $member_loan->customized_loan_no?></td><td><?php echo $member_loan->loan_amount?></td><td><?php echo $member_loan->interest_amount?></td><td><?php echo $member_loan->discount_interest_amount?></td><td><?php echo $member_loan->total_payable_amount?></td><td><?php echo $member_loan->number_of_installment?></td><td><?php echo $member_loan->last_installment_number?></td><td><?php echo $member_loan->last_repayment_date?></td><td><?php echo $member_loan->total_repayment_amount?></td><td><input type='hidden' name='loan_id[]' id='loan_id_<?php echo $member_loan->loan_id?>' value='<?php echo $member_loan->loan_id?>' /><input type='text' name='loan_paid_amount[]' id='loan_paid_amount_<?php echo $member_loan->loan_id?>' value='<?php echo $member_loan->total_payable_amount - $member_loan->total_repayment_amount?>' /></td></tr>
											<?php
										}
									}
								?>
								</table>
								<table id="current_saving_info" class="sortable" cellspacing="0px" cellpadding="0">
								<?php
									if(isset($member_saving_info[0]->saving_id))
									{
										?>
										<tr><th>Saving Code</th><th>Product</th><th>Opening Date</th><th>Weekly Savings</th><th>Total Deposit</th><th>Total Withdraw</th><th>Total Saving</th><th>Remaining Amount</th></tr>
										<?php
										foreach($member_saving_info as $member_saving)
										{
											?>
											<tr><td><?php echo $member_saving->saving_code?></td><td><?php echo $member_saving->product_mnemonic?></td><td><?php echo $member_saving->opening_date?></td><td><?php echo $member_saving->weekly_savings?></td><td><?php echo $member_saving->deposit_amount?></td><td><?php echo $member_saving->withdraw_amount?></td><td> <?php echo $member_saving->deposit_amount - $member_saving->withdraw_amount?></td><td><input type='hidden' name='saving_id[]' id='saving_id_<?php echo $member_saving->saving_id?>' value='<?php echo $member_saving->saving_id?>' /><input type='text' name='saving_withdraw_amount[]' id='saving_withdraw_amount_<?php echo $member_saving->saving_id?>' value='<?php echo $member_saving->deposit_amount - $member_saving->withdraw_amount?>' /></td></tr>
											<?php
											
										}
									}
								?>
								</table>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('member_closings')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
