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
            //alert(tmp[5]);
			$("#member_id").attr('value',tmp[0]);
			$("#branch_id").attr('value',tmp[5]);
			$("#samity_id").attr('value',tmp[6]);
			// start json
			// Loan information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_member_id = tmp[0];
			
			$.post("<?php echo site_url('loan_transactions/ajax_for_get_loan_information') ?>", { member_id: selected_member_id },
			function(data)
			{
				$('#status').html("");
				$('#cbo_loan_id').empty();
				$('#cbo_loan_id').append('<option value = "">--Select--</option>');
				if( data.status == 'failure' )
				{
					//alert(data.message);
					
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.loan.id.length; i++)
					{
						$('#cbo_loan_id').append('<option value = \"' + data.loan.id[i] + '\">' + data.loan.code[i] + ' - ' + data.product.mnemonic[i] + '</option>');					
					}
				}
			}, "json");
		});
		// end member info
		
		// start savings change
		$("#cbo_loan_id").change(
		function() {
			// start json
			// savings information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_loan_id = $("#cbo_loan_id").val();
			//alert(this.val());
			$.post("<?php echo site_url('loan_transactions/ajax_for_get_loan_information_by_loan_id') ?>", { loan_id: selected_loan_id },
			function(data)
			{
				$('#status').html("");
				$('#product_id').attr('value',"");				
				$('#txt_amount').attr('value',"");
				$('#txt_installment_number').attr('value',"");				
				if( data.status == 'failure' ) 
				{
					alert(data.message);
				}
				else
				{					
					$('#txt_installment_number').attr('value',data.loan_schedules.installment_number);
					$('#txt_amount').attr('value',data.loan_schedules.installment_amount);				
					$('#product_id').attr('value',data.loan.product_id);								
				}
			}, "json");
		});		
		// END savings change		
});
</script>
<?php
	$loan_options[''] = '--------SELECT--------';
	//print_r($loans);
	foreach($loans as $loan)
	{
		$loan_options[$loan->loan_id]=$loan->loan_code.' - '.$loan->product_mnemonic;
	}
?>
    <?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('loan_transaction_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("loan_transactions/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_transactions')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol> 
						<li>
							<label for="cbo_loan_id">Member Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />
							<input type="hidden" name="branch_id" id="branch_id" value="<?php echo isset($row->branch_id)?$row->branch_id:""?>" />
							<input type="hidden" name="samity_id" id="samity_id" value="<?php echo isset($row->samity_id)?$row->samity_id:""?>" />
							<input type="hidden" name="product_id" id="product_id" value="<?php echo isset($row->product_id)?$row->product_id:""?>" />			
							<input type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>	
							</div>
						</li>
						<li>
							<label for="cbo_loan_id">Loan ID:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_loan_id', $loan_options,isset($row->loan_id)?$row->loan_id:"",'id="cbo_loan_id"'); ?>	<?php echo form_error('cbo_loan_id'); ?>
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
							<label for="txt_amount">Amount:<em>*</em></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_amount', 'id' => 'txt_amount'),set_value('txt_amount',isset($row->transaction_amount)?$row->transaction_amount:""));?><?php echo form_error('txt_amount'); ?>
							</div>
						</li>	
						<li>
							<label for="txt_installment_number">Installment Number:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_installment_number', 'id' => 'txt_installment_number','readonly'=>'readonly'),set_value('txt_installment_number',isset($row->installment_number)?$row->installment_number:""));?><?php echo form_error('txt_installment_number'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_transactions')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>	
</fieldset>
<?php echo form_close(); ?>
