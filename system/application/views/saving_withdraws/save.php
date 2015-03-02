<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
$(function(){
	$("#txt_transaction_date").datepicker({dateFormat: 'yy-mm-dd'});	
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
			$("#branch_id").attr('value',tmp[5]);
			$("#samity_id").attr('value',tmp[6]);
			$("#member_id").attr('value',tmp[0]);
			$("#member_primary_product_id").attr('value',tmp[7]);

			//alert(tmp[7]);
			// Product information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_member_id = tmp[0];
			$.post("<?php echo site_url('savings/ajax_for_get_member_savings_code') ?>", { member_id: selected_member_id },
			function(data)
			{
				$('#status').html("");
				$('#cbo_savings_code').empty();
				$('#cbo_savings_code').append('<option value = "">--Select--</option>');
				if( data.status == 'failure' )
				{
					//alert(data.message);
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.savings.id.length; i++)
					{
						$('#cbo_savings_code').append('<option value = \"' + data.savings.id[i] + '\">' + data.savings.code[i] + ' (' + data.product.short_name[i] +')</option>');
					}
				}
			}, "json");
		});
		// end member info

		// start savings code change
		$("#cbo_savings_code").change(
					function()
					{
			// start json
			// savings information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var selected_savings_id = $("#cbo_savings_code").val();
			$.post("<?php echo site_url('savings/ajax_for_get_product_info') ?>", { savings_id: selected_savings_id},
			function(data)
			{
				//alert(data.status)
				$('#status').html("");
				$('#savings_id').attr('value',"");

				if( data.status == 'failure' )
				{
					//alert(data.message);
				}
				else
				{
					$('#saving_products_id').attr('value',data.savings.saving_products_id);
					//$('#txt_amount').attr('value',data.savings.weekly_savings);
				}
			}, "json");
		});
		// END product change
});
</script>
<?php
	//savings list
	$savings_options = array(""=>"--Select--");
	foreach($savings_code as $saving_row)
	{					
		$savings_options[$saving_row->id]=$saving_row->code;
	}
	//Payment type list
	$payment_type_options[''] = "--Select--";
	foreach($payments as $payment_row)
	{					
		$payment_type_options[$payment_row]=$payment_row;
	}	
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('saving_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("saving_withdraws/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('saving_withdraws')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="cbo_member">Member:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<input type="hidden" name="branch_id" id="branch_id" value="<?php echo isset($row->branch_id)?$row->branch_id:""?>" />
							<input type="hidden" name="samity_id" id="samity_id" value="<?php echo isset($row->samity_id)?$row->samity_id:""?>" />
							<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />	
							<input type="hidden" name="member_primary_product_id" id="member_primary_product_id" value="<?php echo isset($row->member_primary_product_id)?$row->member_primary_product_id:""?>" />	
							<input type="hidden" name="saving_products_id" id="saving_products_id" value="<?php echo isset($row->saving_products_id)?$row->saving_products_id:""?>" />
							<input type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>	
							</div>
						</li>		
						<li>
							<label for="txt_transaction_date">Transaction Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php $current_date=$this->session->userdata('system.software_date');?>
							<?php echo form_input(array('name' => 'txt_transaction_date', 'id' => 'txt_transaction_date-1','readonly'=>'readonly'),set_value('txt_transaction_date',isset($row->transaction_date)?$row->transaction_date:date('Y-m-d',strtotime( $current_date['current_date']))));?><?php echo form_error('txt_transaction_date'); ?>
							</div>
						</li>
						<li>
							<label for="cbo_savings_code">Savings Code:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_savings_code',$savings_options,set_value('cbo_savings_code',(isset($row->savings_id)?$row->savings_id:"")),'id="cbo_savings_code"','calss="input_select"');?><?php echo form_error('cbo_savings_code'); ?>
							</div>
						</li>			
						<li>			
							<label for="cbo_payment_type">Payment Type:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_payment_type', $payments,set_value('cbo_payment_type',(isset($row->mode_of_payment)?$row->mode_of_payment:"")),'id="cbo_payment_type"','calss="input_select"');?><?php echo form_error('cbo_payment_type'); ?>	
							</div>
						</li> 
						<li>
							<label for="txt_amount">Amount:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_amount','id'=>'txt_amount'),set_value('txt_amount',isset($row->amount)?$row->amount:""));?><?php echo form_error('txt_amount'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('saving_withdraws')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
<?php echo form_close(); ?>
</fieldset>
