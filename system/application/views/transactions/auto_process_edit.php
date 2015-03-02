<script type="text/javascript">
		// Added By: Anisur Rahman Alamgir
		// date: 09-Jan-2011
		// last updated: 11-Jan-2011
// source: http://viralpatel.net/blogs/2009/07/sum-html-textbox-values-using-jquery-javascript.html
		// calculate sum of loan/savings amount
		// calculateSum( total amount ID , loan/savings amount text field);
		function calculateSum(total_amount,amount) {
				var sum = 0;
				$("input[name^=" + amount + "]").each(function() {

					if(!isNaN(this.value) && this.value.length!=0) {
						sum += parseFloat(this.value);
					}
				});
				$("#"+total_amount).html(sum.toFixed(2));
			}
		// check indivitual check field by ID
		// jqCheck( integer value of check field suffix name, loan/savings, full/partial/zero);
		function jqCheck(sl, type,cat )
		{					
			if(cat == 'full'){
				$("#ch_" + type + "_partial_member_"+sl).attr('checked',false);
				$("#ch_" + type + "_zero_member_"+sl).attr('checked',false);
				if($("#ch_" + type + "_" + cat + "_member_"+sl).is(':checked')){
					$("#txt_" + type + "_amount_"+sl).attr('value',parseFloat($("#h_" + type + "_amount_"+sl).val()).toFixed(2));
				}
				else{
					$("#txt_" + type + "_amount_"+sl).attr('value','0.00');	
				}
				$("#txt_" + type + "_amount_"+sl).attr('readonly',true);
			}
			else if(cat == 'partial'){
				$("#ch_" + type + "_full_member_"+sl).attr('checked',false);
				$("#ch_" + type + "_zero_member_"+sl).attr('checked',false);
				$("#txt_" + type + "_amount_"+sl).attr('value','0');	
				if($("#ch_" + type + "_" + cat + "_member_"+sl).is(':checked')){
					$("#txt_" + type + "_amount_"+sl).attr('readonly',false);
				} else{
					$("#txt_" + type + "_amount_"+sl).attr('readonly',true);
				}
			}
			else if(cat == 'zero'){
				$("#ch_" + type + "_full_member_"+sl).attr('checked',false);
				$("#ch_" + type + "_partial_member_"+sl).attr('checked',false);
				$("#txt_" + type + "_amount_"+sl).attr('value','0.00');				
				$("#txt_" + type + "_amount_"+sl).attr('readonly',true);
			}
			if(!$("#ch_" + type + "_" + cat + "_member_"+sl).is(':checked')){
					$("#txt_" + type + "_amount_"+sl).attr('readonly',true);
					$("#txt_" + type + "_amount_"+sl).attr('value',"");
			}
			
			$("#ch_" + type + "_full_all").attr('checked',false);
			$("#ch_" + type + "_partial_all").attr('checked',false);
			$("#ch_" + type + "_zero_all").attr('checked',false);
			calculateSum("total_"+ type +"_amount","txt_"+ type +"_amount");		
		}
		// check All check field
		// jqCheck( integer value of check field suffix name, loan/savings, full/partial/zero);
		function jqCheckAll(sl,type,cat){
			var checked_status = sl;
			var c = 1;
			var total_loan = 0.00;
			var txt_amount = 0.00;
			$("input[name^=ch_" + type + "_" + cat + "_member]").each(function()
			{
				if(!this.disabled){						
					this.checked = checked_status;
					
					if(cat == "partial") {
						$("#txt_" + type + "_amount_"+c).attr("disabled",false);
						$("#txt_" + type + "_amount_"+c).attr("readonly",false);
					}
					if (!this.checked) {
					$("#txt_" + type + "_amount_"+c).attr("value","0.00");
				    } else {
				    	if(this.value == "") {
							txt_amount = 0.00;
						} else {
							txt_amount = $("#h_" + type + "_amount_"+c).val();
						}
						if(cat == "partial") {
				        	$("#txt_" + type + "_amount_"+c).attr("value",'0');
						} 
						else if(cat == "zero") {
				        	$("#txt_" + type + "_amount_"+c).attr("value",'0.00');
						}
						else {
							$("#txt_" + type + "_amount_"+c).attr("value",parseFloat(txt_amount).toFixed(2));
						}
				        total_loan += parseFloat(txt_amount);
				    }
				} else {
					$("#txt_" + type + "_amount_"+c).attr("value","0.00");	
				}					
			    c++;
			});
			// Total Loan
			$("#total_" + type + "_amount").html(total_loan.toFixed(2));
			// checked false
			if(cat == "full") {
			$("#ch_" + type + "_partial_all").attr("checked",false);
			$("input[name^=ch_" + type + "_partial_member]").attr("checked",false);
			$("#ch_" + type + "_zero_all").attr("checked",false);
			$("input[name^=ch_" + type + "_zero_member]").attr("checked",false);
			$("input[name^=txt_" + type + "_amount]").attr("readonly",true);
			}
			else if(cat == "partial") {
			$("#ch_" + type + "_full_all").attr("checked",false);
			$("input[name^=ch_" + type + "_full_member]").attr("checked",false);
			$("#ch_" + type + "_zero_all").attr("checked",false);
			$("input[name^=ch_" + type + "_zero_member]").attr("checked",false);
			//txt_----_amount
			//$("input[name^=txt_" + type + "_amount]").attr("disabled",false);
			}
			else if(cat == "zero") {
			$("#ch_" + type + "_full_all").attr("checked",false);
			$("input[name^=ch_" + type + "_full_member]").attr("checked",false);
			$("#ch_" + type + "_partial_all").attr("checked",false);
			$("input[name^=ch_" + type + "_partial_member]").attr("checked",false);
			$("input[name^=txt_" + type + "_amount]").attr("readonly",true);
			}
		}
		
		$(document).ready(function()
		{
			$("#ch_loan_full_all").click(function()				
			{
				jqCheckAll (this.checked,'loan','full');						
			});					
			$("#ch_loan_partial_all").click(function()				
			{
				jqCheckAll (this.checked,'loan','partial');
			});						
			$("#ch_loan_zero_all").click(function()				
			{
				jqCheckAll (this.checked,'loan','zero');
			});
			// Savings start	
			$("#ch_savings_full_all").click(function()				
			{
				jqCheckAll (this.checked,'savings','full');						
			});					
			$("#ch_savings_partial_all").click(function()				
			{
				jqCheckAll (this.checked,'savings','partial');
			});						
			$("#ch_savings_zero_all").click(function()				
			{
				jqCheckAll (this.checked,'savings','zero');
			});	
			// Amount change
			
			$("input[name^=txt_loan_amount]").each(function() {
				$(this).keyup(function(){
					calculateSum("total_loan_amount","txt_loan_amount");
				});
			});
			$("input[name^=txt_savings_amount]").each(function() {

				$(this).keyup(function(){
					calculateSum("total_savings_amount","txt_savings_amount");
				});
			});		
    
       jQuery.validator.messages.required = "";
		$("form").validate({
			invalidHandler: function(e, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					var message = errors == 1
						? 'You missed 1 field. It has been highlighted below'
						: 'You missed ' + errors + ' fields.  They have been highlighted below';
					$("div.error").html(message);
					$("div.error").show();
				} else {
					$("div.error").hide();
				}
			}
		});	
	
		});
		
		</script>
<h3 style="text-align:center;">Samity Name: <?php  echo (isset($samity_info[0]))?$samity_info[0]->name.'('.$samity_info[0]->code.')<br>Samity Day:'.$samity_info[0]->samity_day:''?> </h3>
<?php
	//Open employee Add form	
	echo form_open('transactions/auto_process_add');
//	print_r($samity_info);
?>
<fieldset>
	<legend>Auto Process</legend>
	<?php echo form_error('txt_loan_amount[]'); ?>
	<?php echo form_error('txt_savings_amount[]'); ?>
	<table  border="1" style="font-size:10px;">
		<tr>
			<th colspan="2">Member Info</th>
			<th colspan="9">Loan Information</th>
			<th colspan="6">Savings Information</th>
		</tr>
		<tr>
			<th>Custom Member ID</th>
			<th>Member Name</th>
			
			<th>Loan ID</th>
			<th>Installment Amount</th>
			<th>Due</th>
			<th>Advance</th>
			<th>&nbsp;Full&nbsp;</th>
			<th>&nbsp;Partial&nbsp;</th>
			
			<th>&nbsp;Zero&nbsp;</th>
			<th>Amount</th>
			<th>|</th>
			<th>Account ID</th>
			<th>Fixed Savings</th>
			<th>&nbsp;Full&nbsp;</th>
			
			<th>&nbsp;Partial&nbsp;</th>
			<th>&nbsp;Zero&nbsp;</th>
			<th>Amount</th>
		</tr>
		<tr>
			<td  colspan="6">&nbsp;</td>
			<td><input type="checkbox" id="ch_loan_full_all" value="loan_all" ></td>
			<td><input type="checkbox" id="ch_loan_partial_all" value="loan_partial"></td>
			<td><input type="checkbox" id="ch_loan_zero_all" value="loan_zero"></td>
			<td colspan="4">&nbsp;</td>
			<td><input type="checkbox" id="ch_savings_full_all" value="savings_all"></td>
			<td><input type="checkbox" id="ch_savings_partial_all" value="savings_partial"></td>
			<td><input type="checkbox" id="ch_savings_zero_all" value="savings_zero"></td>
			<td>&nbsp;</td>			
		</tr>
		<?php
		$row = 1;
		$loan_disabled = "";
		$savings_disabled = "";
		$loan_readonly = "";
		$savings_readonly= "";
		$total_installment_amount = 0.00;
		$total_fixed_savings = 0.00;
		// After submitted form
		$loan_amount_value = set_value("txt_loan_amount[]");
		$savings_amount_value = set_value("txt_savings_amount[]");
		$loan_reset_value = "0.00";
		$savings_reset_value = "0.00";
		
		$submit_disable = "";
		if(isset($auto_process) and !empty($auto_process)){
			foreach($auto_process as $member_info)
			{
				$loan_disabled = ($member_info->loan_id <= 0)?'disabled="disabled" ':'';
				$savings_disabled = ($member_info->savings_id <= 0)?'disabled="disabled" ':'';
				$loan_readonly = ($member_info->loan_id <= 0)?'readonly="readonly" ':'';
				$savings_readonly = ($member_info->savings_id <= 0)?'readonly="readonly" ':'';
				$total_installment_amount += $member_info->installment_amount;
				$total_fixed_savings += $member_info->weekly_savings;
				$loan_reset_value = ($loan_disabled === "")?'':'0.00';
				$savings_reset_value = ($savings_disabled === "")?'':'0.00';
				?>
				<tr>
				<input name="member_id[]" value="<?php echo $member_info->member_id?>" type="hidden">
				<input name="member_name[]" value="<?php echo $member_info->member_name?>" type="hidden">
				<input name="samity_id" value="<?php echo $member_info->samity_id?>" type="hidden">
				<input name="samity_date" value="<?php echo date('Y-m-d');?>" type="hidden">
				<input name="loan_id[]" value="<?php echo $member_info->loan_id?>" type="hidden">
				<input name="savings_id[]" value="<?php echo $member_info->savings_id?>" type="hidden">
				<input name="h_loan_amount[]" id="h_loan_amount_<?php echo $row?>" value="<?php echo $member_info->installment_amount?>" type="hidden">
				<input name="h_savings_amount[]" id="h_savings_amount_<?php echo $row?>" value="<?php echo $member_info->weekly_savings?>" type="hidden">
				<td><?php echo $member_info->member_id?></td>
				<td><?php echo $member_info->member_name?></td>  
	            <td><?php echo empty($member_info->loan_id)?'---':$member_info->loan_id?></td>
			    <td><?php echo ($member_info->installment_amount <= 0 )  ?'---':$member_info->installment_amount?></td>
	            <td><?php echo empty($member_info->loan_id)?'---':$member_info->loan_id?></td>
				<td><?php echo empty($member_info->loan_id)?'---':$member_info->loan_id?></td>
				<td><input name="ch_loan_full_member[]" id="ch_loan_full_member_<?php echo $row?>" value="<?php echo $row?>" <?php echo set_checkbox('ch_loan_full_member[]', $row); ?> <?php echo $loan_disabled?> type="checkbox" onclick="jqCheck('<?php echo $row?>','loan','full');" ></td>
				<td><input name="ch_loan_partial_member[]"  id="ch_loan_partial_member_<?php echo $row?>" value="<?php echo $row?>" <?php echo $loan_disabled?> <?php echo set_checkbox('ch_loan_partial_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','loan','partial');"></td>
				<td><input name="ch_loan_zero_member[]" id="ch_loan_zero_member_<?php echo $row?>" value="<?php echo $row?>" <?php echo $loan_disabled?> <?php echo set_checkbox('ch_loan_zero_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','loan','zero');"></td>
				<td>
				<input id="txt_loan_amount_<?php echo $row?>" name="txt_loan_amount[]" size="3" type="text" readonly="readonly" value="<?php echo isset($loan_amount_value[$row - 1])?$loan_amount_value[$row - 1]:$loan_reset_value; ?>"></td>
			    <td>|</td>
				<td><?php echo empty($member_info->savings_id)?'---':$member_info->savings_id?></td> 
				<td><?php echo ($member_info->weekly_savings <= 0 )  ?'---':$member_info->weekly_savings?></td> 
				<td><input id="ch_savings_full_member_<?php echo $row?>" name="ch_savings_full_member[]" <?php echo set_checkbox('ch_savings_full_member[]', $row); ?> value="<?php echo $row?>" <?php echo $savings_disabled?> type="checkbox" onclick="jqCheck('<?php echo $row?>','savings','full');"></td>
				<td><input id="ch_savings_partial_member_<?php echo $row?>" name="ch_savings_partial_member[]"  <?php echo $savings_disabled?>  value="<?php echo $row?>" <?php echo set_checkbox('ch_savings_partial_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','savings','partial');"></td>
				<td><input id="ch_savings_zero_member_<?php echo $row?>" name="ch_savings_zero_member[]" <?php echo $savings_disabled?> value="<?php echo $row?>" <?php echo set_checkbox('ch_savings_zero_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','savings','zero');"></td>
				<td><input id="txt_savings_amount_<?php echo $row?>" name="txt_savings_amount[]" readonly="readonly" size="3" type="text" class="required"  value="<?php echo isset($savings_amount_value[$row - 1])?$savings_amount_value[$row - 1]:$savings_reset_value; ?>"></td>
				</tr>
				<?php
				$row++;
			}
		} 
		else {
			$submit_disable = ' disabled="disabled" ';
			 ?>
			<tr><td colspan="17"><div class="error">No Member fountd</div></td></tr>
		<?php }
		?>
		
		<tr>
			<th colspan="3" align="right">Total Installment Amount:</th> 
			<th><div id="total_installment_amount"><?php printf("%.2f",$total_installment_amount)?></div></th>
			<th colspan="5" align="right">Total Repayment Collection:</th> 
			<th><div id="total_loan_amount"><?php printf("%.2f",(is_array($loan_amount_value))? array_sum($loan_amount_value):'0.00')?></div></th>
			<th colspan="2" align="right">Total Fixed Savings</th>
			<th><div id="total_fixed_savings"><?php printf("%.2f",$total_fixed_savings)?></div></th>
			<th colspan="3" align="right">Total Savings Collection</th>
			<th><div id="total_savings_amount"><?php printf("%.2f",(($savings_amount_value))? array_sum($savings_amount_value):'0.00')?></div></th>
		</tr>
		<tr><td colspan="17" style="text-align:center;"><?php echo form_submit('submit','Save',$submit_disable);?></td></tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
