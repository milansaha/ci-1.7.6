<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/test.css" />-->
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(function(){
	$("#txt_transfer_date").datepicker({dateFormat: 'yy-mm-dd'});
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
		}).result(function(e, item) {
			//myCallback();
			var tmp;
			tmp=item[0].split(",");
			
			$("#member_id").attr('value',tmp[0]);			
			$("#old_branch_id").attr('value',tmp[5]);
			$("#old_samity_id").attr('value',tmp[6]);
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
				$('#member_info1').empty();
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
					
					$('#member_info1').append("<p>Member Name : <b>" + data.member.name + "</b>, Member Code : <b>" + data.member.code + "</b><br> Samity Name : <b>" + data.samity.name + "</b>, Samity Code : <b>" + data.samity.code + "</b><br> Working area : <b>" + data.working_area.name + "</b>, Village Code : <b>" + data.village.name + "</b>, Branch Code : <b>" + data.branch.name + "</b> </p>");
					//primary_product_id
					$('#primary_product_id').attr('value',data.product.id );
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
		// new samity
		$("#new_samity_name").autocomplete('<?php echo site_url("samities/ajax_for_get_samity_auto_search/")?>', {
			minChars: 0,
			width: 310,
			matchContains: "word",
			highlightItem: true,
			formatItem: function(row, i, max, term) {
				var tmp;
				tmp=row[0].split(",");
				return "<strong>"+tmp[2]+"</strong> - "+tmp[1]+"" + "<br><span style='font-size: 80%;'>Working area: " + tmp[3] + "<br>Thana: " + tmp[4] + "<br>District :" + tmp[5] + "</span>";
			},
			
			formatResult: function(row) {
				var tmp;
				tmp=row[0].split(",");
				return tmp[2]+ " - " + tmp[1];
			}
		}).result(function(e, item) {
			//myCallback();
			var tmp;
			tmp=item[0].split(",");
			$("#new_samity_id").attr('value',tmp[0])
			$("#new_branch_id").attr('value',tmp[7]);
		});
});
</script>
<?php
	if(isset($member_samity_info[0]))
	{
		$member_samity_info = $member_samity_info[0];
	}
	if(isset($new_saving_info[0]))
	{
		$new_saving_info = $new_saving_info[0];
	}
	//echo form_open('member_transfers/add');
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('member_transfer_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
	}$class_name = 'class="formTitleBar_add"';
	echo form_open("member_transfers/$action",'',$hidden_input);
?>
<!--<div id="status" style="position:absolute;top:50%;left:45%;"></div>-->
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('member_transfers')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>	
							<label for="cbo_member">Member Name:<span class="required_field_indicator">*</span></label>			
							<div class="form_input_container">
								<?php //echo form_dropdown('cbo_member', $member_options);?>	
								<input type="hidden" name="old_branch_id" id="old_branch_id" value="<?php echo isset($member_samity_info->branch_id)?$member_samity_info->branch_id:""?>" />
								<input type="hidden" name="old_samity_id" id="old_samity_id" value="<?php echo isset($member_samity_info->samity_id)?$member_samity_info->samity_id:""?>" />
								<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($member_samity_info->member_id)?$member_samity_info->member_id:'' ?>" />
								<input type="hidden" name="primary_product_id" id="primary_product_id" value="<?php echo isset($member_samity_info->primary_product_id)?$member_samity_info->primary_product_id:'' ?>" />
								<input type="hidden" name="new_samity_id" id="new_samity_id" value="<?php echo isset($new_saving_info->samity_id)?$new_saving_info->samity_id:'' ?>" />	
								<input type="hidden" name="new_branch_id" id="new_branch_id" value="<?php echo isset($new_saving_info->branch_id)?$new_saving_info->branch_id:'' ?>" />		
								<input type="text" id="member_info" value="<?php echo isset($member_samity_info->member_name)?$member_samity_info->member_name:""?>" maxlength="255" class="input_textbox" />	
								<?php //echo anchor('members/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Member')),array('class'=>'addimglink','alt'=>'Add Member','title'=>'Add Member'));  ?>
								<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Member','width'=>'12px')), 'add_member', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Member','onclick'=>"window.location.href='".site_url('members/add')."'"));?></div>
								<?php echo form_error('member_id'); ?>
							</div>
						</li>
						<li>
							<div>
								<div id="member_info1"></div>
								<!--<table id="test" class="sortable" cellspacing="0px" cellpadding="0"></table>
								<table id="current_saving_info" class="sortable" cellspacing="0px" cellpadding="0"></table>-->
							</div>
						</li>
						<li id="new_samity">
							<label for="cbo_member">New Samity Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<input type="text" id="new_samity_name" readonly="readonly"  name="new_samity_name" value="<?php echo (isset($new_saving_info->samity_name)?$new_saving_info->samity_name:'').'-'.(isset($new_saving_info->samity_code)?$new_saving_info->samity_code:'') ?>" maxlength="255" class="input_textbox" />
								<?php //echo anchor('samities/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Samity')),array('class'=>'addimglink','alt'=>'Add Samity','title'=>'Add Samity'));  ?>
								<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Samity','width'=>'12px')), 'add_samity', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Samity','onclick'=>"window.location.href='".site_url('samities/add')."'"));?></div>
								<?php echo form_error('new_samity_id'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_transfer_date">Transfer Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_input(array('name'=>'txt_transfer_date','id'=>'txt_transfer_date','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_transfer_date'));?>
								<?php echo form_error('txt_transfer_date'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('member_transfers')."'"));?>
				</div>
			</td>
			<td class="formBottomBar">&nbsp;</td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
