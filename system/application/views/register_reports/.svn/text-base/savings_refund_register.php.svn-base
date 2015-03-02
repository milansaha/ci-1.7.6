<div class="scroll-report">
		<div class="report-header">
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
			<table border="0"> 
		 		<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code </th>
		  			<td colspan="3" class="align-left" width="49%"><strong>:</strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th><div align="left">Branch Address</div></th>
		 			<td colspan="3" class="align-left"><strong>:</strong><?php echo $branch_info['address'];?></td></tr>   		
				<?php else:?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code</th>
		  			<td colspan="3" class="align-left" width="49%"><strong>:</strong><?php echo 'All';?></td></tr> 
				<?php endif;?>
				<tr>
		  			<th class="align-left" width="20%">Component</th>
		  			<td colspan="3" class="align-left" width="49%"><strong>:</strong><?php echo $product_id;?></td></tr> 
				<tr>
		 			<th class="align-left">Reporting Date</th>
		 			<td class="align-left"><strong>:</strong>
					<?php echo date('d F, Y',strtotime($date_from)). ' to ' .date('d F, Y',strtotime($date_to));?></td>		 			
					<th class="align-left">Print Date</th>
		 			<td class="align-left"><strong>:</strong><?php echo date("j F, Y");?></td></tr>
			</table>
		<table width="100%" border="1" cellspacing="0">  
			<tr>
				<th rowspan="2" width="41"><p align="center">Sl No.</p></th>
				<th rowspan="2" width="68"><div align="center">Date</div></th>
				<th colspan="2"><div align="center">Member</div></th>
				<th colspan="2"><div align="center">Samity</div></th>
				<th rowspan="2" width="72"><div align="center">Savings Deposit</div></th>
				<th rowspan="2" width="62"><div align="center">Account Interest(Tk.)</div></th>
				<th rowspan="2" width="51"><div align="center">Savings Outstanding</div></th>
				<th colspan="5" width="34"><div align="center">Savings Refund / Withdrawal</div></th>
				<th rowspan="2" width="60"><div align="center"><p>Signature of Member</p></div></th>
				<th rowspan="2" width="60"><div align="center"><p>Signature of Field Officer</p></div></th>
			</tr>
  			<tr>
				<th width="80"><div align="center">Code</div></th>
				<th width="77">Name</th>
				<th width="75"><div align="center">Code</div></th>
				<th width="79">Name</th>
				<th width="99"><div align="center">Full Refund</div></th>
				<th width="106"><div align="center">Partial Refund</div></th>
				<th width="106"><div align="center">Loan Adjust</div></th>
				<th width="106"><div align="center">Total Savings Refund / Withdrawal</div></th>
				<th width="106"><div align="center">Savings Balance</div></th>
			</tr>
		<?php
			//echo '<pre>';
			//print_r($savings_general_info);
			$i = 0;
			foreach($savings_general_info as $sv_refund_register)
			{
				$i++;
				?>
				<tr><?php ?>
					<td><?php echo $i;?></td>
					<td><?php echo $sv_refund_register['savings_s_transaction_date'];?></td>
					<td><?php echo $sv_refund_register['members_s_code'];?></td>
					<td><?php echo $sv_refund_register['members_s_name'];?></td>
					<td><?php echo $sv_refund_register['samities_s_code'];?></td>
					<td><?php echo $sv_refund_register['samities_s_name'];?></td>
					<td><?php echo $sv_refund_register['deposit_amount'];?></td>
					<td><?php if(!empty($sv_refund_register['interest_amount'])){echo number_format($sv_refund_register['interest_amount'],2,'.',',');}else{echo'0.00';}?></td>
					<td><?php $savings_outstanding = $sv_refund_register['deposit_amount']+$sv_refund_register['interest_amount']; echo number_format($savings_outstanding,2,'.',',');?></td>
					<td><?php if($savings_outstanding == $sv_refund_register['wdithdrawl_amount']){echo number_format($sv_refund_register['wdithdrawl_amount'],2,'.',','); }else{echo '0.00';} ?></td>
					<td><?php if($savings_outstanding != $sv_refund_register['wdithdrawl_amount']){echo number_format($sv_refund_register['wdithdrawl_amount'],2,'.',','); }else{echo '0.00';} ?></td>
					<td><?php echo $loan_adjustment = '0.00';?></td>
					<td><?php $total_savings_withdrawl = $sv_refund_register['wdithdrawl_amount']+$loan_adjustment; echo number_format($total_savings_withdrawl,2,'.',',');?></td>
					<td><?php $savings_balance = $savings_outstanding - $total_savings_withdrawl; echo number_format($savings_balance,2,'.',',');?></td>
					<td><?php echo '';?></td>
					<td><?php echo '';?></td>
				</tr>
				<?php
				
				/*echo $sv_refund_register['a_id'];
				echo '<br/>';				
				echo $sv_refund_register['savings_s_transaction_date'];
				echo '<br/>';
				echo $sv_refund_register['members_s_code'];
				echo '<br/>';
				echo $sv_refund_register['members_s_name'];
				echo '<br/>';
				echo $sv_refund_register['smities_s_id'];
				echo '<br/>';
				echo $sv_refund_register['samities_s_code'];
				echo '<br/>';
				echo $sv_refund_register['samities_s_name'];
				echo '<br/>';
				echo $sv_refund_register['saving_s_transactions_type'];
				echo '<br/>';
				echo $sv_refund_register['deposit_amount'];
				echo '<br/>';
				echo $sv_refund_register['b_id'];
				echo '<br/>';
				echo $sv_refund_register['members_w_name'];
				echo '<br/>';
				echo $sv_refund_register['savings_w_transaction_date'];
				echo '<br/>';
				echo $sv_refund_register['saving_w_transactions_type'];
				echo '<br/>';
				echo $sv_refund_register['wdithdrawl_amount'];
				echo '<br/>';
				echo $sv_refund_register['c_id'];
				echo '<br/>';
				echo $sv_refund_register['members_i_name'];
				echo '<br/>';
				echo $sv_refund_register['savings_i_transaction_date'];
				echo '<br/>';
				echo $sv_refund_register['saving_i_transactions_type'];
				echo '<br/>';
				echo $sv_refund_register['interest_amount'];
				echo '<br/>';*/

			}
		?>
  		</table><br><br><br>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>

