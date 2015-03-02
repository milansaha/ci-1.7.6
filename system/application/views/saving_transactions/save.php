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
			$("#member_id").attr('value',tmp[0]);
			// start json
			// savings information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_member_id = tmp[0];
			
			$.post("<?php echo site_url('saving_transactions/ajax_for_get_savings_information') ?>", { member_id: selected_member_id },
			function(data)
			{
				$('#status').html("");
				$('#cbo_savings').empty();
				$('#cbo_savings').append('<option value = "">--Select--</option>');
				if( data.status == 'failure' )
				{
					alert(data.message);
					
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.saving.id.length; i++)
					{
						$('#cbo_savings').append('<option value = \"' + data.saving.id[i] + '\">' + data.saving.code[i] + ' - ' + data.product.mnemonic[i] + '</option>');
					
					}
				}
			}, "json");
		});
		// end member info
		
		// start savings change
		$("#cbo_savings").change(
					function() 
					{
			// start json
			// savings information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_saving_id = $("#cbo_savings").val();
			//alert(this.val());
			$.post("<?php echo site_url('saving_transactions/ajax_for_get_savings_information_by_savings_id') ?>", { saving_id: selected_saving_id },
			function(data)
			{
				$('#status').html("");
				$('#weekly_savings').attr('value',"");
				if( data.status == 'failure' )
				{
					alert(data.message);
					
				}
				else
				{
					$('#weekly_savings').attr('value',data.saving.weekly_savings);
				}
			}, "json");
		});
		
		// END savings change
});
</script>
<?php 
	//Members list
	//$members_options[''] = "--Select--";
//	foreach($members as $member_row)
//	{					
//		$member_options[$member_row->id]=$member_row->name;
//	}
		
	//Savings list
	$savings_options[''] = "--Select--";
	//print_r($row);
	foreach($savings as $savings_row)
	{					
		$savings_options[$savings_row->savings_id]=$savings_row->savings_code.' - '.$savings_row->product_mnemonic;
	}
	
//	//Transaction type list
//	$transaction_type_options[''] = "--Select--";
//	foreach($transactions as $transaction_row)
//	{					
//		$transaction_type_options[$transaction_row]=$transaction_row;
//	}
//
//	//Payment type list
//	$payment_type_options[''] = "--Select--";
//	foreach($payments as $payment_row)
//	{					
//		$payment_type_options[$payment_row]=$payment_row;
//	}

	//Form Start
	echo form_open('saving_transactions/'.(isset($row->id)?"edit":"add"));
	echo form_hidden('saving_transaction_id',(isset($row->id)?$row->id:""));
?>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
	<p>Savings information</p>	
	<table>  
		<tr >
			<td width="20%"><label for="cbo_member">Member:<em>&nbsp;</em></label></td>			
			<td><?php $js = 'id="member_id"';
					//	echo form_dropdown('cbo_member', $member_options,null,$js);?>
				<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />
			<input type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>		
					</td>	
		</tr>
		<tr>
			<td width="20%"><label for="txt_savings">Savings ID:<em>&nbsp;</em></label></td>			
			<td><?php //$js = 'id="savings_id" readonly="readonly"'; echo form_input('txt_savings',set_value('txt_savings'),$js);?>
			<?php //echo form_error('txt_savings'); ?>
			<?php echo form_dropdown('cbo_savings',$savings_options,isset($row->savings_id)?$row->savings_id:"",'id="cbo_savings"');?><?php echo form_error('cbo_savings'); ?>
			</td>	
		</tr> 
		<tr>
			<td><label for="txt_transaction_code">Transaction Code:<em>&nbsp;</em></label></td>
			<td><?php echo form_input(array('name'=>'txt_transaction_code','id'=>'txt_transaction_code'),set_value('txt_transaction_code',isset($row->transaction_code)?$row->transaction_code:""));?><?php echo form_error('txt_transaction_code'); ?></td>		
		</tr>
		<tr>
			<td><label for="txt_transaction_date">Transaction Date:<em>&nbsp;</em></label></td>
			<td><?php echo form_input(array('name'=>'txt_transaction_date','id'=>'txt_transaction_date','readonly'=>'readonly'),set_value('txt_transaction_date',isset($row->transaction_date)?$row->transaction_date:""));?><?php echo form_error('txt_transaction_date'); ?></td>		
		</tr>
		<tr>			
			<td><label for="cbo_transaction_type">Transaction Type:</label></td>			
			<td><?php echo form_dropdown('cbo_transaction_type', $transactions,isset($row->transaction_type)?$row->transaction_type:"",'id="cbo_transaction_type"');?><?php echo form_error('cbo_transaction_type'); ?></td>			
		</tr>
		<tr>			
			<td><label for="cbo_payment_type">Payment Type:</label></td>			
			<td><?php echo form_dropdown('cbo_payment_type', $payments,isset($row->payment_type)?$row->payment_type:"",'id="cbo_payment_type"');?><?php echo form_error('cbo_payment_type'); ?></td>			
		</tr>
		<tr >
			<td><label for="txt_amount">Amount:<em>&nbsp;</em></label></td>
			<td><?php $js = 'id="weekly_savings"'; echo form_input('txt_amount',set_value('txt_amount',isset($row->amount)?$row->amount:""),$js);?><?php echo form_error('txt_amount'); ?></td>		
		</tr>										
	</table>
	<p><?php echo form_submit('submit','Save');?></p>
<?php echo form_close(); ?>
<script type="text/javascript">
	var member_info = new LiveValidation('member_info', { validMessage: " ", onlyOnBlur: true });
	member_info.add( Validate.Presence );
	var cbo_savings = new LiveValidation('cbo_savings', { validMessage: " ", onlyOnBlur: true });
	cbo_savings.add( Validate.Presence );
	var txt_transaction_code = new LiveValidation('txt_transaction_code', { validMessage: " ", onlyOnBlur: true });
	txt_transaction_code.add( Validate.Presence );
	txt_transaction_code.add( Validate.Length, { maximum: 50 } );
	
	var cbo_transaction_type = new LiveValidation('cbo_transaction_type', { validMessage: " ", onlyOnBlur: true });
	cbo_transaction_type.add( Validate.Presence );
	
	var cbo_payment_type = new LiveValidation('cbo_payment_type', { validMessage: " ", onlyOnBlur: true });
	cbo_payment_type.add( Validate.Presence );
	
	var weekly_savings = new LiveValidation('weekly_savings', { validMessage: " ", onlyOnBlur: true });
	weekly_savings.add( Validate.Numericality, { minimum: 0, maximum: 999999 } );
	weekly_savings.add( Validate.Length, { maximum: 10 } );
</script>
