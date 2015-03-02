<?php
	echo anchor("transactions/auto_process", "Back to Auto Process");  
 ?>
<?php 
	if($is_preview) {
?>
<div><h4>PREVIEW DATA:</h4></div>
<h3 style="text-align:center;">Samity Name: <?php echo $samity_info[0]->name.'('.$samity_info[0]->code.')<br>Samity Day:'.$samity_info[0]->samity_day?> </h3>
 <?php 
	}
 ?>
 <?php
	echo form_open('transactions/auto_process_add');
?>
	<table  border="1" style="font-size:10px;">
		<tr>
			<th colspan="3">Member Info</th>
			<th colspan="6">Loan Information</th>
			<th colspan="6">Savings Information</th>
		</tr>
		<tr>
			<th>Member ID</th>
			<th>Member Name</th>
			<th>Is present?</th>
			<th>Loan ID</th>
			<th>Installment Amount</th>
			<th>Due</th>
			<th>Advance</th>
			<th>Payment</th>
			<th>Amount</th>
			<th>Savings ID</th>
			<th>Fixed Savings</th>
			<th>Payment</th>
			<th>Amount</th>
			<th colspan='2'>Sokot</th>			
		</tr>
		<?php
		//echo '<pre>';		
		//print_r($posted);
		//die();
		$row = 1;
		$loan_disabled = "";
		$savings_disabled = "";
		$loan_readonly = "";
		$savings_readonly= "";
		$total_installment_amount = 0.00;
		$total_fixed_savings = 0.00;
		$total_skt_amount = 0.00;
		// After submitted form
		$loan_amount_value = set_value("txt_loan_amount[]");
		$savings_amount_value = set_value("txt_savings_amount[]");
		$skt_amount_value = set_value("txt_skt_amount[]");
		$loan_reset_value = "0.00";
		$savings_reset_value = "0.00";
		$total = count($posted['member_id']);
		$loan_payment_type = "-";
		$saving_payment_type = "-";
		$member_id_old = "";
		$member_id_new = "";		
		
		for($i=0;$i<$total;$i++)
		{
			$total_installment_amount += $posted['h_loan_amount'][$i];
			$total_fixed_savings += $posted['h_savings_amount'][$i];
			
			$loan_payment_type = "-";
			$saving_payment_type = "-";
			$total_skt_amount +=isset($posted['txt_skt_amount'][$i])?$posted['txt_skt_amount'][$i]:0;
			
		if(isset($posted['ch_loan_full_member']) and in_array($i+1,$posted['ch_loan_full_member'] ) ){
			$loan_payment_type = "Full";
		} elseif(isset($posted['ch_loan_partial_member']) and in_array($i+1,$posted['ch_loan_partial_member'] ) ){
			$loan_payment_type = "Partial";
		}elseif(isset($posted['ch_loan_zero_member']) and in_array($i+1,$posted['ch_loan_zero_member'] ) ){
			$loan_payment_type = "Zero";
		}
		
		if(isset($posted['ch_savings_full_member']) and in_array($i+1,$posted['ch_savings_full_member'] ) ){
			$saving_payment_type = "Full";
		} elseif(isset($posted['ch_savings_partial_member']) and in_array($i+1,$posted['ch_savings_partial_member'] ) ){
			$saving_payment_type = "Partial";
		}elseif(isset($posted['ch_savings_zero_member']) and in_array($i+1,$posted['ch_savings_zero_member'] ) ){
			$saving_payment_type = "Zero";
		}	
			
		?>
		<input name="branch_id" value="<?php echo $posted['branch_id']?>" type="hidden">
		<input name="primary_product_id[]" value="<?php echo $posted['primary_product_id'][$i]?>" type="hidden">
		<input name="member_id[]" value="<?php echo $posted['member_id'][$i]?>" type="hidden">	
		<input name="member_name[]" value="<?php echo $posted['member_name'][$i]?>" type="hidden">	
		<input name="samity_id" value="<?php echo $posted['samity_id']?>" type="hidden">
		<input name="loan_id[]" value="<?php echo $posted['loan_id'][$i]?>" type="hidden">
		<input name="savings_id[]" value="<?php echo $posted['savings_id'][$i]?>" type="hidden">
		<input name="loan_acc_id[]" value="<?php echo $posted['loan_acc_id'][$i]?>" type="hidden">
		<input name="savings_acc_id[]" value="<?php echo $posted['savings_acc_id'][$i]?>" type="hidden">
		<input name="loan_due[<?php echo $posted['loan_id'][$i]?>]" value="<?php echo $posted['loan_due'][$posted['loan_id'][$i]]?>" type="hidden">
		<input name="loan_advance[<?php echo $posted['loan_id'][$i]?>]" value="<?php echo $posted['loan_advance'][$posted['loan_id'][$i]]?>" type="hidden"> 
		<input name="h_loan_amount[]" id="h_loan_amount_<?php echo $row?>" value="<?php echo $posted['h_loan_amount'][$i]?>" type="hidden">
		<input name="h_savings_amount[]" id="h_savings_amount_<?php echo $row?>" value="<?php echo $posted['h_savings_amount'][$i]?>" type="hidden">
		<input name="loan_product_id[]" value="<?php echo $posted['loan_product_id'][$i]?>" type="hidden">
		<input name="savings_product_id[]" value="<?php echo $posted['savings_product_id'][$i]?>" type="hidden">
				
		<tr> 
			<td><?php echo $posted['member_id'][$i]?></td>
			<td><?php echo $posted['member_name'][$i]?></td>  
			<td>				
				<?php 
					if($member_id_old!=$posted['member_id'][$i]){
						$member_id_new = $posted['member_id'][$i];											
					?>
					<?php 					
						echo (isset($posted['ch_attendence'][$posted['member_id'][$i]])?$posted['ch_attendence'][$posted['member_id'][$i]]:'0'=='1')?'Yes':'No' ;
					?>
					<input name="ch_attendence[<?php echo $posted['member_id'][$i]?>]" value="<?php echo isset($posted['ch_attendence'][$posted['member_id'][$i]])?$posted['ch_attendence'][$posted['member_id'][$i]]:'0';?>" type="hidden">
				<?php }else{?>
					-
				<?php }?>			
			</td> 							
			<td><?php echo $posted['loan_acc_id'][$i]?></td> 
		    <td><?php echo ($posted['h_loan_amount'][$i] <= 0 )  ?'-':$posted['h_loan_amount'][$i]?></td>
		    <td><?php echo isset($posted['loan_due'][$posted['loan_id'][$i]])?$posted['loan_due'][$posted['loan_id'][$i]]:'-';?></td>
		    <td><?php echo isset($posted['loan_advance'][$posted['loan_id'][$i]])?$posted['loan_advance'][$posted['loan_id'][$i]]:'-';?></td>
			<td><?php echo $loan_payment_type?></td>  
			<td>
				<input name="txt_loan_amount[<?php echo $posted['loan_id'][$i]?>]" value="<?php echo isset($posted['txt_loan_amount'][$posted['loan_id'][$i]])?$posted['txt_loan_amount'][$posted['loan_id'][$i]]:'0'?>" type="hidden">
				<?php echo isset($posted['txt_loan_amount'][$posted['loan_id'][$i]])?$posted['txt_loan_amount'][$posted['loan_id'][$i]]:'-';?>
			
			</td> 
			<td><?php echo $posted['savings_acc_id'][$i]?></td> 
			<td><?php echo ($posted['h_savings_amount'][$i] <= 0 )  ?'-':$posted['h_savings_amount'][$i]?></td> 
			<td><?php echo $saving_payment_type?></td>
			<td>
				<input name="txt_savings_amount[<?php echo $posted['savings_id'][$i]?>]" value="<?php echo isset($posted['txt_savings_amount'][$posted['savings_id'][$i]])?$posted['txt_savings_amount'][$posted['savings_id'][$i]]:'0'?>" type="hidden">
				<?php echo isset($posted['txt_savings_amount'][$posted['savings_id'][$i]])?$posted['txt_savings_amount'][$posted['savings_id'][$i]]:'-';?>
			</td>
			<td colspan="2">
			<?php if($member_id_old!=$posted['member_id'][$i]){
					 $member_id_new = $posted['member_id'][$i];										
			?>	
			<input name="txt_skt_amount[]" value="<?php echo $posted['txt_skt_amount'][$i]?>" type="hidden">		
			<?php echo isset($posted['txt_skt_amount'][$i])?$posted['txt_skt_amount'][$i]:0;?>
			<?php }else{?>
			 <input name="txt_skt_amount[]"  type="hidden" value="0">
					-
			<?php }?>
			</td>
			</tr>
			<?php
			$row++;
			$member_id_old=$member_id_new;
		}
		?>
		
		<tr>
			<th colspan="4" align="right">Total Installment Amount:</th> 
			<th><div id="total_installment_amount"><?php printf("%.2f",$total_installment_amount)?></div></th>
			<th colspan="3" align="right">Total Repayment Collection:</th> 
			<th><div id="total_loan_amount"><?php printf("%.2f",(is_array($loan_amount_value))? array_sum($loan_amount_value):'0.00')?></div></th>
			<th colspan="1" align="right">Total Fixed Savings</th>
			<th><div id="total_fixed_savings"><?php printf("%.2f",$total_fixed_savings)?></div></th>
			<th colspan="1" align="right">Total Savings Collection</th>
			<th><div id="total_savings_amount"><?php printf("%.2f",(($savings_amount_value))? array_sum($savings_amount_value):'0.00')?></div></th>
			<th colspan="1" align="right">Total Sokot Collection</th>
			<th><div id="total_skt_amount"><?php printf("%.2f",(($total_skt_amount))? $total_skt_amount:'0.00')?></div></th>
		
		</tr>
		<tr>
			<td colspan="10" style="text-align:center;border:none;background-color:#f5f5f5;">		
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
