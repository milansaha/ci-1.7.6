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
				calculateSum("total_loan_amount","txt_loan_amount");
			});						
			$("#ch_loan_zero_all").click(function()				
			{
				jqCheckAll (this.checked,'loan','zero');
				calculateSum("total_loan_amount","txt_loan_amount");
			});
			// Savings start	
			$("#ch_savings_full_all").click(function()				
			{
				jqCheckAll (this.checked,'savings','full');						
			});					
			$("#ch_savings_partial_all").click(function()				
			{
				jqCheckAll (this.checked,'savings','partial');
				calculateSum("total_savings_amount","txt_savings_amount");
				
			});						
			$("#ch_savings_zero_all").click(function()				
			{
				jqCheckAll (this.checked,'savings','zero');
				calculateSum("total_savings_amount","txt_savings_amount");
			});	
			
			$("#ch_present_all").click(function()				
			{
				   var chkval = $("#ch_present_all").is(':checked');				  
					
					if(chkval){
						$(".ch_attendence").attr("checked",true);
					}else{
						$(".ch_attendence").attr("checked",false);
					}				
			});	
			
			$(".ch_attendence").click(function()				
			{
				$("#ch_present_all").attr("checked",false);					
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
    
	
		});
		
		</script>
<h3 style="text-align:center;">Samity Name: <?php  echo (isset($samity_info[0]))?$samity_info[0]->name.'('.$samity_info[0]->code.')<br>Samity Day:'.$samity_info[0]->samity_day:''?> </h3>
<?php
	//Open employee Add form	
	echo form_open('transactions/auto_process_add');
//	print_r($samity_info);
?>
<style>
.auto_process{border:solid 1px #C5C5C5;align:center;background-color:#f5f5f5;}
.auto_process th{    background-color: #676767;
    border-right: 1px solid #BFBFBF;
    border-bottom: 1px solid #BFBFBF;
    font-weight:bold;
    color: #F1F1F1;
    font-family: "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
    font-size:11px;
    font-weight: bold;
    padding: 2px;}
.auto_process td{padding:2px;background-color:#fff;border-bottom:solid 1px #676767;border-right:solid 1px #676767;font-weight:normal;font: 11px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;}
.auto_process_input{width:50px;}
</style>
<fieldset>
	<center>
	<h2>Auto Process</h2>
	<?php echo form_error('txt_loan_amount[]'); ?>
	<?php echo form_error('txt_savings_amount[]'); ?>
	<table class="auto_process" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th colspan="2">Member Info</th>
			<th colspan="9">Loan Information</th>
			<th colspan="8">Savings Information</th>
		</tr>
		<tr>
			<th>Custom Member ID</th>
			<th>Member Name</th>
			<th>Is Present?</th>
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
			<th>Sokot</th>
		</tr> 
		<tr>
			<td  colspan="2">&nbsp;</td>
			<td align="center"><input type="checkbox" id="ch_present_all" value="present_all" ></td>
			<td  colspan="4">&nbsp;</td>
			<td><input type="checkbox" id="ch_loan_full_all" value="loan_all" ></td>
			<td><input type="checkbox" id="ch_loan_partial_all" value="loan_partial"></td>
			<td><input type="checkbox" id="ch_loan_zero_all" value="loan_zero"></td>
			<td colspan="4">&nbsp;</td>
			<td><input type="checkbox" id="ch_savings_full_all" value="savings_all"></td>
			<td><input type="checkbox" id="ch_savings_partial_all" value="savings_partial"></td>
			<td><input type="checkbox" id="ch_savings_zero_all" value="savings_zero"></td>
			<td>&nbsp;</td>
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
		$total_skt_amount = "0.00";
		$member_id_old = "";
		$member_id_new = "";		
		$submit_disable = "";
		
		if(isset($auto_process) and !empty($auto_process)){
			foreach($auto_process as $member_info)
			{
/*
				if($member_id_old!=$member_info->member_id){
					echo $member_id_new = $member_info->member_id;
				}
*/
				$loan_disabled = ($member_info->loan_id <= 0)?'disabled="disabled" ':'';
				$savings_disabled = ($member_info->savings_id <= 0)?'disabled="disabled" ':'';
				$loan_readonly = ($member_info->loan_id <= 0)?'readonly="readonly" ':'';
				$savings_readonly = ($member_info->savings_id <= 0)?'readonly="readonly" ':'';
				$total_installment_amount += $member_info->installment_amount;
				$total_fixed_savings += $member_info->weekly_savings;
				$loan_reset_value = ($loan_disabled === "")?'':'0.00';
				$savings_reset_value = ($savings_disabled === "")?'':'0.00';
				$loan_due = ($member_info->loan_id <= 10)?300:'';
				$loan_advance = ($member_info->loan_id >10)?200:'';				
			?>
				<tr>
				<input name="branch_id" value="<?php echo $member_info->branch_id?>" type="hidden">
				<input name="primary_product_id[]" value="<?php echo $member_info->primary_product_id?>" type="hidden">
				<input name="member_id[]" value="<?php echo $member_info->member_id?>" type="hidden">
				<input name="member_name[]" value="<?php echo $member_info->member_name?>" type="hidden">
				<input name="samity_id" value="<?php echo $member_info->samity_id?>" type="hidden">
				<input name="loan_id[]" value="<?php echo $member_info->loan_id?>" type="hidden">
				<input name="savings_id[]" value="<?php echo $member_info->savings_id?>" type="hidden">
				<input name="loan_acc_id[]" value="<?php echo $member_info->customized_loan_no?>" type="hidden">
				<input name="savings_acc_id[]" value="<?php echo $member_info->savings_acc?>" type="hidden">
				<input name="loan_due[]" value="<?php echo empty($member_info->loan_id)?'0':$loan_due?>" type="hidden">
				<input name="loan_advance[]" value="<?php echo empty($member_info->loan_id)?'0':$loan_advance?>" type="hidden">
				<input name="h_loan_amount[]" id="h_loan_amount_<?php echo $row?>" value="<?php echo $member_info->installment_amount?>" type="hidden">
				<input name="h_savings_amount[]" id="h_savings_amount_<?php echo $row?>" value="<?php echo $member_info->weekly_savings?>" type="hidden">
				<input name="loan_product_id[]" value="<?php echo $member_info->product_id?>" type="hidden">
				<input name="savings_product_id[]" value="<?php echo $member_info->saving_products_id?>" type="hidden">
				<td width="60px"><?php echo $member_info->member_id?></td>
				<td width="100px"><?php echo $member_info->member_name?></td>
				<td width="20px" align="center">
					<?php 
					if($member_id_old!=$member_info->member_id){
						 $member_id_new = $member_info->member_id;
					?>
					<input type="checkbox" id="ch_attendence" class="ch_attendence" name="ch_attendence[]" value="1">
				<?php }else{?>
					----
					<input type="hidden" class="ch_attendence" name="ch_attendence[]" value="0">
				<?php }?>
				</td>	            
	            <td width="50px"><?php echo empty($member_info->customized_loan_no)?'---':$member_info->customized_loan_no?></td>
			    <td width="30px"><?php echo ($member_info->installment_amount <= 0 ) ?'---':$member_info->installment_amount?></td>
	            <td width="30px"><?php echo empty($member_info->loan_id)?'---':$loan_due?></td>
				<td width="30px"><?php echo empty($member_info->loan_id)?'---':$loan_advance?></td>
				<td width="20px"><input name="ch_loan_full_member[]" id="ch_loan_full_member_<?php echo $row?>" value="<?php echo $row?>" <?php echo set_checkbox('ch_loan_full_member[]', $row); ?> <?php echo $loan_disabled?> type="checkbox" onclick="jqCheck('<?php echo $row?>','loan','full');" ></td>
				<td width="20px"><input name="ch_loan_partial_member[]" id="ch_loan_partial_member_<?php echo $row?>" value="<?php echo $row?>" <?php echo $loan_disabled?> <?php echo set_checkbox('ch_loan_partial_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','loan','partial');"></td>
				<td width="20px"><input name="ch_loan_zero_member[]" id="ch_loan_zero_member_<?php echo $row?>" value="<?php echo $row?>" <?php echo $loan_disabled?> <?php echo set_checkbox('ch_loan_zero_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','loan','zero');"></td>
				<td width="30px"><input id="txt_loan_amount_<?php echo $row?>" class="auto_process_input" name="txt_loan_amount[]" size="3" type="text" readonly="readonly" value="<?php echo isset($loan_amount_value[$row - 1])?$loan_amount_value[$row - 1]:$loan_reset_value; ?>"></td>
			    <td width="8px">|</td>
				<td width="40px"><?php echo empty($member_info->savings_id)?'---':$member_info->savings_acc?></td> 
				<td width="25px"><?php echo ($member_info->weekly_savings <= 0 )  ?'---':$member_info->weekly_savings?></td> 
				<td width="20px"><input id="ch_savings_full_member_<?php echo $row?>" name="ch_savings_full_member[]" <?php echo set_checkbox('ch_savings_full_member[]', $row); ?> value="<?php echo $row?>" <?php echo $savings_disabled?> type="checkbox" onclick="jqCheck('<?php echo $row?>','savings','full');"></td>
				<td width="20px"><input id="ch_savings_partial_member_<?php echo $row?>" name="ch_savings_partial_member[]"  <?php echo $savings_disabled?>  value="<?php echo $row?>" <?php echo set_checkbox('ch_savings_partial_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','savings','partial');"></td>
				<td width="20px"><input id="ch_savings_zero_member_<?php echo $row?>" name="ch_savings_zero_member[]" <?php echo $savings_disabled?> value="<?php echo $row?>" <?php echo set_checkbox('ch_savings_zero_member[]',$row); ?> type="checkbox" onclick="jqCheck('<?php echo $row?>','savings','zero');"></td>
				<td width="40px"><input id="txt_savings_amount_<?php echo $row?>" name="txt_savings_amount[]" readonly="readonly" size="3" type="text" class="required auto_process_input"  value="<?php echo isset($savings_amount_value[$row - 1])?$savings_amount_value[$row - 1]:$savings_reset_value; ?>"></td>
				
				<td width="10px">
					<?php 
					if($member_id_old!=$member_info->member_id){
						 $member_id_new = $member_info->member_id;
						 $total_skt_amount += $member_info->skt_amount;
					?>
					<input id="txt_skt_amount_<?php echo $row?>" name="txt_skt_amount[]" readonly="readonly" size="2" type="text" value="<?php echo isset($member_info->skt_amount)?$member_info->skt_amount:0; ?>">
				   <?php }else{?>
				   ---- 
				   <input id="txt_skt_amount_<?php echo $row?>" name="txt_skt_amount[]"  type="hidden" value="0">
				   <?php }?>
				</td>				
				</tr>
				<?php
				$row++;
				$member_id_old=$member_id_new;
			}
		} 
		else {
			$submit_disable = ' disabled="disabled" ';
			 ?>
			<tr><td colspan="18"><div class="error">No Member fountd</div></td></tr>
		<?php }
		?>
		
		<tr>
			<th colspan="4" align="right">Total Installment Amount:</th> 
			<th><div id="total_installment_amount"><?php printf("%.2f",$total_installment_amount)?></div></th>
			<th colspan="5" align="right">Total Repayment Collection:</th> 
			<th><div id="total_loan_amount"><?php printf("%.2f",(is_array($loan_amount_value))? array_sum($loan_amount_value):'0.00')?></div></th>
			<th colspan="2" align="right">Total Fixed Savings</th>
			<th><div id="total_fixed_savings"><?php printf("%.2f",$total_fixed_savings)?></div></th>
			<th colspan="3" align="right">Total Savings Collection</th>
			<th><div id="total_savings_amount"><?php printf("%.2f",(($savings_amount_value))? array_sum($savings_amount_value):'0.00')?></div></th>
			<th>Total:&nbsp;<?php printf("%.2f",(($total_skt_amount))?$total_skt_amount:'0.00')?></th>
		</tr>
		<tr><td colspan="19" style="text-align:center;border:none;background-color:#f5f5f5;">		
		<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
		</td></tr>
	</table>
	</center>
</fieldset>
<?php echo form_close(); ?>
