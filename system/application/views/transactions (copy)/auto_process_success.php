<?php //print_r($last_id); 
if($is_saved) {
?><div class="message">All Transaction has been added successfully.</div>
<?php
echo anchor("transactions/auto_process", "Back to Auto Process"); 
//echo " | ";
//echo anchor("transactions/auto_process_edit/{$samity_info[0]->id}/{$samity_date}", "Edit this  Auto Process");
//echo site_url("transactions/auto_process/$samity_info[0]->name");
 }
 ?>
<br>
<h3 style="text-align:center;">Samity Name: <?php echo $samity_info[0]->name.'('.$samity_info[0]->code.')<br>Samity Day:'.$samity_info[0]->samity_day?> </h3>

	<table  border="1" style="font-size:10px;">
		<tr>
			<th colspan="3">Member Info</th>
			<th colspan="6">Loan Information</th>
			<th colspan="6">Savings Information</th>
		</tr>
		<tr>
			<th>Custom Member ID</th>
			<th>Member Name</th>
			<th>Is present?</th>
			<th>Loan ID</th>
			<th>Installment Amount</th>
			<th>Due</th>
			<th>Advance</th>
			<th>Payment</th>
			<th>Amount</th>
			<th>Account ID</th>
			<th>Fixed Savings</th>
			<th>Payment</th>
			<th>Amount</th>
			<th colspan='2'>Sokot</th>			
		</tr>
		<?php
		//print_r($member_sokot);
		//print_r($member_attendence);
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
		$loan_payment_type = "---";
		$saving_payment_type = "---";
		$member_id_old = "";
		$member_id_new = "";		
		
		for($i=0;$i<$total;$i++)
		{
			$total_installment_amount += $posted['h_loan_amount'][$i];
			$total_fixed_savings += $posted['h_savings_amount'][$i];
			
			$loan_payment_type = "---";
			$saving_payment_type = "---";
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
		<tr> 
			<td><?php echo $posted['member_id'][$i]?></td>
			<td><?php echo $posted['member_name'][$i]?></td>  
			<td>
				<?php //echo isset($posted['ch_attendence'][$i])?'Yes':'No' ; ?>
				<?php 
					if($member_id_old!=$posted['member_id'][$i]){
						$member_id_new = $posted['member_id'][$i];											
					?>			
					<?php echo ($posted['ch_attendence'][$i]=='1')?'Yes':'No' ;?>
				<?php }else{?>
					----
				<?php }?>			
			</td> 							
			<td><?php echo $posted['loan_acc_id'][$i]?></td> 
		    <td><?php echo ($posted['h_loan_amount'][$i] <= 0 )  ?'---':$posted['h_loan_amount'][$i]?></td>
		    <td><?php echo isset($posted['loan_due'][$i])?$posted['loan_due'][$i]:0;?></td>
		    <td><?php echo isset($posted['loan_advance'][$i])?$posted['loan_advance'][$i]:0;?></td>
			<td><?php echo $loan_payment_type?></td>  
			<td><?php echo $posted['txt_loan_amount'][$i]?></td> 
			<td><?php echo $posted['savings_acc_id'][$i]?></td> 
			<td><?php echo ($posted['h_savings_amount'][$i] <= 0 )  ?'---':$posted['h_savings_amount'][$i]?></td> 
			<td><?php echo $saving_payment_type?></td>
			<td><?php echo ($posted['txt_savings_amount'][$i] <= 0 )  ?'---':$posted['txt_savings_amount'][$i]?></td>
			<!--
<td><?php //echo (isset($last_id['saving_trans_id'][$i]))? anchor("transactions/auto_process_edit/{$last_id['saving_trans_id'][$i]}", "Saving Edit"):'---';?></td>
-->
			<td colspan="2">
			<?php if($member_id_old!=$posted['member_id'][$i]){
					 $member_id_new = $posted['member_id'][$i];										
			?>			
			<?php echo isset($posted['txt_skt_amount'][$i])?$posted['txt_skt_amount'][$i]:0;?>
			<?php }else{?>
					----
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
	</table>
