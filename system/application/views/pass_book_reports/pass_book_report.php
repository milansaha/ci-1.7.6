<div class="scroll-report">
	<div class="report-header">	
		<div align="center"><?php $this->load->view('/elements/report_header');?></div>
		<br>
		<h2><div align="center"><?php echo $headline;?></div></h2>
		<table width="100%" border="0" cellspacing="0"> 
		 		<?php if(!empty($branch_and_samity_info)):?>
				<tr>
		  			<th align='left' width="20%">Branch Name & Code </th>
		  			<td colspan="3"  align='left'  ><strong>: </strong><?php echo $branch_and_samity_info[0]['branch_name']."(".$branch_and_samity_info[0]['branch_code'].")";?></td></tr>
				<tr>
					<th align='left' width="20%">Samity Name & Code </th>
                                         <td colspan="3"  align='left'><strong>: </strong><?php echo $branch_and_samity_info[0]['samity_name']."(".$branch_and_samity_info[0]['samity_code'].")";?></td>
				<td></td>
				<?php endif;?>
                                <th  align='left'  width="20%">1st Installment Date</th>
				<td colspan="3" class="align-left" ><strong>: </strong><?php echo date('d/m/Y',strtotime($member_and_loan_info[0]['1st_installment_date']));?></td></tr> 
				<tr>
		  			<th align='left'  width="20%">Component</th>
		  			<td colspan="3"  align='left'  ><strong>: </strong><?php isset($products_info['short_name'])?$products_info['short_name']:"";echo $products_info['short_name'];?></td>
					<td></td>
                                        <th  align='left' width="20%">Rate of Service Charge</th> 
                                        <td colspan="3"  align='left' ><strong>: </strong><?php echo isset($member_and_loan_info[0]['rate_of_service_change'])?$member_and_loan_info[0]['rate_of_service_change']:"";?></td></tr>
				 <tr>
		  			<th  align='left'  width="20%">Date of Disbursement</th>
		  			<td colspan="3" class="align-left" ><strong>: </strong><?php echo isset($member_and_loan_info[0]['disburse_date'])?$member_and_loan_info[0]['disburse_date']:"";?></td><td></td>
				       <th  align='left'  width="20%">Amount of Installment</th>
                                       <td colspan="3" class="align-left" ><strong>: </strong><?php echo isset($member_and_loan_info[0]['amount_of_installment'])?$member_and_loan_info[0]['amount_of_installment']:"";?></td> </tr> 
				<tr>
		  			<th  align='left'  width="20%">Disbursement Amount</th>
		  			<td colspan="3" class="align-left" ><strong>: </strong><?php echo isset($member_and_loan_info[0]['disbursement_amount'])?$member_and_loan_info[0]['disbursement_amount']:"";?></td><td></td>
					<th  align='left'  width="20%">No. of Installment</th>
					<td colspan="3"  align='left'  ><strong>: </strong><?php echo isset($member_and_loan_info[0]['number_of_installment'])?$member_and_loan_info[0]['number_of_installment']:"";?></td> </tr>
                 		<tr>
		  			<th  align='left'  width="20%">Purpose</th>
		  			<td colspan="3"  align='left'  ><strong>: </strong><?php echo isset($member_and_loan_info[0]['loan_purposes_name'])?$member_and_loan_info[0]['loan_purposes_name']:"";?></td><td></td>
					<th  align='left'  width="20%">Dafa No</th>
                                        <td colspan="3"  align='left'  ><strong>: </strong><?php echo isset($member_and_loan_info[0]['dafa_no'])?$member_and_loan_info[0]['dafa_no']:"";?></td> </tr>	
                                 <tr>
					<th  align='left'  width="20%"></th>
		  			<td colspan="3"  align='left'  ></td><td></td>
					<th  align='left' >Print Date</th>
		 			<td  align='left' ><strong>: </strong><?php echo date("d/m/Y");?></td></tr>
			</table>  
		<table width="100%" border="1" cellspacing="0"> 
				<tr>				
				<td rowspan="2">Week </td>
				<td rowspan="2">Date </td>
				<td colspan="4">Savings </td>
				<td colspan="9">Loan </td>	
				<td rowspan="2">Sign of F/W</td>					
			</tr>
			<tr>
				<td>Weekly Deposit</td>
				<td>Interest</td>
				<td>Saving Refund</td>
				<td>Balance</td>
				<td>Recoverable</td>
				<td>Weekly Recovery</td>
				<td>Repay Week No</td>
				<td>Current Repay Week No</td>
				<td>Cumulative Recovery</td>
				<td>Due Collection</td>
				<td>Advance Collection</td>
				<td>Due</td>
				<td>Outstanding</td>						
			</tr>
			<?php $i=1; $balance=0; $cumulative_recovery=0;$cumulative_recoverable=0;$due=0; if(!empty($pass_book_info)): foreach ($pass_book_info as $pass_book_info):
			//$balance=$balance+isset($pass_book_info['weekly_deposit'])?$pass_book_info['weekly_deposit']:""-isset($pass_book_info['saving_refund'])?$pass_book_info['saving_refund']:""; 
			$balance=$balance+$pass_book_info['weekly_deposit']-$pass_book_info['saving_refund'];
			$cumulative_recovery=$cumulative_recovery+$pass_book_info['weekly_recovery'];
			$cumulative_recoverable=$cumulative_recoverable+$pass_book_info['installment_amount'];
			$due=($cumulative_recoverable)-($cumulative_recovery+$pass_book_info['advance_collection_amount']+$pass_book_info['due_collection_amount']);
			
			?>
			<?php
			if (date('d/m/Y',strtotime($pass_book_info['date']))!='01/01/1970')
			{
				?>
			 
			<tr>
			  <td><?php echo $i++?></td>
			 
				<td><?php echo date('d/m/Y',strtotime($pass_book_info['date']));?></td>
				<td align='right'><?php echo isset($pass_book_info['weekly_deposit'])?number_format($pass_book_info['weekly_deposit'], 2, '.', ','):"";?></td>
				<td><?php echo 0 ?></td>
				<td align='right'><?php echo isset($pass_book_info['saving_refund'])?number_format($pass_book_info['saving_refund'], 2, '.', ','):"";?></td>
				<td align='right'><?php echo isset($balance)?number_format($balance, 2, '.', ','):""?></td>
				<td align='right'><?php echo isset($pass_book_info['installment_amount'])?number_format($pass_book_info['installment_amount'], 2, '.', ','):"";?></td>
				<td align='right'><?php echo isset($pass_book_info['weekly_recovery'])?number_format($pass_book_info['weekly_recovery'], 2, '.', ','):"";?></td> 
				<td align='right'><?php echo isset($pass_book_info['installment_number'])?$pass_book_info['installment_number']:"";?> </td>
				<td align='right'><?php echo isset($pass_book_info['current_repay_week_no'])?$pass_book_info['current_repay_week_no']:"";?> </td>
				<td align='right'><?php echo isset($cumulative_recovery)?number_format($cumulative_recovery, 2, '.', ','):"";?> </td>
				<td align='right'><?php echo isset($pass_book_info['advance_collection_amount'])?number_format($pass_book_info['advance_collection_amount'], 2, '.', ','):"";?></td>
				<td align='right'><?php echo isset($pass_book_info['due_collection_amount'])?number_format($pass_book_info['due_collection_amount'], 2, '.', ','):"";?></td>
				<td align='right'><?php echo isset($due)?number_format($due, 2, '.', ','):""?> </td>
				<td align='right'><?php echo isset($pass_book_info['current_outstanding_amount'])?number_format($pass_book_info['current_outstanding_amount'], 2, '.', ','):"";?></td>
				<td align='right'> </td>			
			</tr>
			<?php
		}
		?><?php endforeach;endif; ?>
		</table>
		<br>
		<br>
		<br>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
