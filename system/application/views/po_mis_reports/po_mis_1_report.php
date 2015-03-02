<div class="scroll-report">
	<div class="report-header">	
		<div align="center"><?php $this->load->view('/elements/report_header');?></div>
		<br>				
		<table width="100%" border="0" cellspacing="0"> 
			<tr>
				<td align="center" colspan='4'><h2><?php echo $headline;?></h2></td></tr> 
			<?php if(!empty($branch_info)): ?>
			<tr>
				<th><div align="left">Branch Name & Code</div></th>
				<td class="align-left"><strong>:</strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td>		
				<th><div align="left">Branch Address</div></th>
				<td class="align-left"><strong>:</strong><?php echo $branch_info['address'];?></td></tr>  
			<?php else :?>
			<tr>
				<th><div align="left">Branch Name</div></th>
				<td class="align-left"><strong>:</strong><?php echo "All Branch";?></td>		
				<th><div align="left"></div></th>
				<td class="align-left"><strong></strong></td></tr> 	
			<?php endif;?>
			<tr>
				<th><div align="left">Reporting Month</div></th>
				<td class="align-left"><strong>:</strong><?php $date=$year.'-'.$month; $date = new DateTime($date);	echo $date->format('F').','.$year;?></td>
				<th><div align="left">Print Date</div></th>
				<td class="align-left"><strong>:</strong><?php echo date("d-m-Y");?></td></tr></table>			
		<br><b>01. Statement of Samity and Member</b><br>
		<table  width="100%" border="1" cellspacing="0">  
			<tr>
				<th rowspan="2" colspan="2"><div align="center" width="96">Component</div></th>
				<th rowspan="2" colspan="2"><div align="center" width="96">No. of Branch </div></th>
				<th colspan="9"><div align="center">No. of Samity </div></th>
				<th colspan="9"><div align="center">No. of Member </div></th></tr>
			<tr>
				<th colspan="3"><div align="center" width="96">Male</div></th>
				<th colspan="3"><div align="center" width="96">Female</div></th>
				<th colspan="3"><div align="center" width="96">Total</div></th>
				<th colspan="3"><div align="center" width="96">Male</div></th>
				<th colspan="3"><div align="center" width="96">Female</div></th>
				<th colspan="3"><div align="center" width="96">Total</div></th></tr>
			<tr>
				<th colspan="2"><div align="center">1</div></th>
				<th colspan="2"><div align="center">2</div></th>
				<th colspan="3"><div align="center">3</div></th>
				<th colspan="3"><div align="center">4</div></th>
				<th colspan="3"><div align="center">5=3+4</div></th>
				<th colspan="3"><div align="center">6</div></th>
				<th colspan="3"><div align="center">7</div></th>
				<th colspan="3"><div align="center">8=6+7</div></th></tr>
			<?php 
					if(!empty($branch_member_info)):
					$total_branch=0;$f_samity_total=0;$m_samity_total=0;$f_member_total=0;$m_member_total=0;				
					foreach ($branch_member_info as $row):
					$m_samity_total=$row['no_of_samity_male']+$m_samity_total;
					$f_samity_total=$row['no_of_samity_female']+$f_samity_total;
					$m_member_total=$row['no_of_member_total_male']+$m_member_total;
					$f_member_total=$row['no_of_member_total_female']+$f_member_total;
			?>
			<tr>
				<td colspan="2"><?php echo $row['mnemonic'];?></td>
				<td colspan="2"><div align="center"><?php if($branch_id!=-1) {echo '1';} else { echo $row['no_of_branch']; $total_branch=$total_branch+$row['no_of_branch'];}?></div></td>
				<td colspan="3"><div align="center"><?php echo number_format($row['no_of_samity_male'], 0, ',', ',');?></div></td>
				<td colspan="3"><div align="center"><?php echo number_format($row['no_of_samity_female'], 0, ',', ',');?></div></td>
				<td colspan="3"><div align="center"><?php echo number_format($row['no_of_samity_male']+ $row['no_of_samity_female'], 0, ',', ',');?></div></td>
				<td colspan="3"><div align="center"><?php echo number_format($row['no_of_member_total_male'], 0, ',', ',');?></div></td>
				<td colspan="3"><div align="center"><?php echo number_format($row['no_of_member_total_female'], 0, ',', ',');?></div></td>
				<td colspan="3"><div align="center"><?php echo number_format($row['no_of_member_total_male']+$row['no_of_member_total_female'], 0, ',', ',');?></div></td></tr>
			<?php endforeach;?>
			<tr> 
				<th colspan="2">Total</th>
				<th colspan="2"><div align="center"><?php if($branch_id!=-1) {echo '1';} else { echo $total_branch;}?></div></th>
				<th colspan="3"><div align="center"><?php echo number_format($m_samity_total, 0, ',', ',');?></div></th>
				<th colspan="3"><div align="center"><?php echo number_format($f_samity_total, 0, ',', ',');?></div></th>
				<th colspan="3"><div align="center"><?php echo number_format($m_samity_total+$f_samity_total, 0, ',', ',');?></div></th>
				<th colspan="3"><div align="center"><?php echo number_format($m_member_total, 0, ',', ',');?></div></th>
				<th colspan="3"><div align="center"><?php echo number_format($f_member_total, 0, ',', ',');?></div></th>
				<th colspan="3"><div align="center"><?php echo number_format($m_member_total+$f_member_total, 0, ',', ',');?></div></th></tr>
			<?php endif;?></table>
		<br><b>02. Statement of Savings</b><br>	
		<table width="100%" border="1" cellspacing="0">  
			<tr>
				<th colspan="4" rowspan="2" ><div align="center">Component</div></th>
				<th colspan="4" ><div align="center">Opening Balance </div></th>
				<th colspan="4" ><div align="center">Current Month Savings Collection </div></th>
				<th colspan="4" ><div align="center">Current Month Savings Refund </div></th>
				<th colspan="6" ><div align="center">Closing Balance </div></th></tr>
			<tr>
				<th colspan="2"><div align="center">Male</div></th>
				<th  colspan="2"><div align="center">Female</div></th>
				<th  colspan="2"><div align="center">Male</div></th>
				<th  colspan="2"><div align="center">Female</div></th>
				<th  colspan="2"><div align="center">Male</div></th>
				<th  colspan="2"><div align="center">Female</div></th>
				<th  colspan="2"><div align="center">Male</div></th>
				<th  colspan="2"><div align="center">Female</div></th>
				<th  colspan="2"><div align="center">Total</div></th></tr>
			<?php if(!empty($savings_statement)):			
					$opening_balance_male_total=0;$opening_balance_female_total=0;
					$total_deposit_male_total=0;$total_deposit_female_total=0;
					$total_withdraw_male_total=0;$total_withdraw_female_total=0;
					$closing_balance_male_total=0;$closing_balance_female_total=0;			
					
					foreach ($savings_statement as $row):				
					$opening_balance_male_total +=$row['opening_balance_male'];	
					$opening_balance_female_total +=$row['opening_balance_female'];	
					$total_deposit_male_total +=$row['deposit_collection_male'];	
					$total_deposit_female_total +=$row['deposit_collection_female'];	
					$total_withdraw_male_total +=$row['saving_refund_male'];	
					$total_withdraw_female_total +=$row['saving_refund_female'];	
					$closing_balance_male_total +=$row['closing_balance_male'];
					$closing_balance_female_total +=$row['closing_balance_female'];		
					$total_closing_balance=$closing_balance_male_total+$closing_balance_female_total;?>
			<tr >
				<td colspan="4"><?php echo $row['mnemonic'];?></td>			
				<td colspan="2"><div align="right"><?php echo number_format($row['opening_balance_male'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['opening_balance_female'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['deposit_collection_male'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['deposit_collection_female'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['saving_refund_male'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['saving_refund_female'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['closing_balance_male'], 2, '.', ',');?></div></td>
				<td  colspan="2"><div align="right"><?php echo number_format($row['closing_balance_female'], 2, '.', ',');?></div></td>
				<td colspan="2"><div align="right"><?php echo number_format($row['closing_balance_male']+$row['closing_balance_female'], 2, '.', ',');?></div></td></tr>
			<?php endforeach;
				$opening_balance_grand_total=$opening_balance_male_total+$opening_balance_male_total;
				$deposit_grand_total=$total_deposit_male_total+$total_deposit_female_total;
				$withdraw_grand_total=$total_withdraw_male_total+$total_withdraw_female_total;
				$closing_balance_grand_total=$closing_balance_male_total+$closing_balance_female_total;	
			?>
			<tr>
				<th colspan="4">Total</th>
				<th colspan="2"><div align="right"><?php echo number_format($opening_balance_male_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($opening_balance_female_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($total_deposit_male_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($total_deposit_female_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($total_withdraw_male_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($total_withdraw_female_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($closing_balance_male_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($closing_balance_female_total, 2, '.', ',');?></div></th>
				<th colspan="2"><div align="right"><?php echo number_format($total_closing_balance, 2, '.', ',');?></div></th></tr>
			<tr>
				<th colspan="4"><div align="left">Grand Total</div></th>
				<th colspan="4"><div align="center"><?php echo number_format($opening_balance_grand_total, 2, '.', ',');?></div></th>
				<th colspan="4"><div align="center"><?php echo number_format($deposit_grand_total, 2, '.', ',');?></div></th>
				<th colspan="4"><div align="center"><?php echo number_format($withdraw_grand_total, 2, '.', ',');?></div></th>
				<th colspan="6"><div align="center"><?php echo number_format($closing_balance_grand_total, 2, '.', ',');?></div></th></tr>
			<?php endif;?></table>
		<br><b>03. Statement Of Member Admission, Cancellation, Deposit &amp; Attendance</b><br>
		<table width="100%" border="1" cellspacing="0">  
			<tr>
				<th colspan="2" width='96'>Component</th>
				<th colspan="4"><div align="center">Total Member End of Last Month </div></th>
				<th colspan="4"><div align="center">New Member Admission (Current Month) </div></th>
				<th colspan="4"><div align="center">Member Cancellation (Current Month) </div></th>
				<th colspan="4"><div align="center">Total Member (End of Current Month) </div></th>
				<th colspan="2"><div align="center">Avg. No. of Savings Depositor </div></th>
				<th colspan="2"><div align="center">Average Attendance (Current Month)</div></th></tr>
			<tr>
				<th colspan="2" width='96'>&nbsp;</th>
				<th colspan="2" ><div align="center">Male</div></th>
				<th colspan="2" ><div align="center">Female</div></th>
				<th colspan="2"><div align="center">Male</div></th>
				<th colspan="2"><div align="center">Female</div></th>
				<th colspan="2" ><div align="center">Male</div></th>
				<th colspan="2" ><div align="center">Female</div></th>
				<th colspan="2"><div align="center">Male</div></th>
				<th colspan="2"><div align="center">Female</div></th>
				<th colspan="2">&nbsp;</th>
				<th colspan="2">&nbsp;</th></tr>
			<tr>
				<th colspan="2" width='96'><div align="center">1</div></th>
				<th colspan="2"><div align="center">2</div></th>
				<th colspan="2"><div align="center">3</div></th>
				<th colspan="2"><div align="center">4</div></th>
				<th colspan="2"><div align="center">5</div></th>
				<th colspan="2"><div align="center">6</div></th>
				<th colspan="2"><div align="center">7</div></th>
				<th colspan="2"><div align="center">8=2+4-6</div></th>
				<th colspan="2"><div align="center">9=3+5-7</div></th>
				<th colspan="2"><div align="center">10</div></th>
				<th colspan="2"><div align="center">11</div></th></tr>
			<?php 
					if(!empty($branch_member_info)):
					$previous_male_member_total=0;$previous_female_member_total=0;
					$current_male_member_total=0;$current_female_member_total=0;	
					$canceled_male_member_total=0;$canceled_female_member_total=0;	
					$total_male=0;$total_female=0;	$total_depositor=0;$total_attendanc=0;
					$grand_total_previous_male_member=0;$grand_total_previous_female_member=0;	
					$grand_total_current_male_member=0;$grand_total_current_female_memberr=0;	
					$grand_total_canceled_male_member=0;$grand_total_canceled_female_member=0;		
					foreach ($branch_member_info as $row):
					$previous_male_member_total=$row['prev_month_no_of_member_male']+$previous_male_member_total;
					$previous_female_member_total=$row['prev_month_no_of_member_female']+$previous_female_member_total;
					$current_male_member_total=$row['no_of_new_member_admission_male']+$current_male_member_total;
					$current_female_member_total=$row['no_of_new_member_admission_female']+$current_female_member_total;
					$canceled_male_member_total=$row['no_of_member_cancellation_male']+$canceled_male_member_total;
					$canceled_female_member_total=$row['no_of_member_cancellation_female']+$canceled_female_member_total;
					$total_male=$row['no_of_member_total_male'];
					$total_female=$row['no_of_member_total_female'];
					$total_depositor=$row['avg_savings_depositor']+$total_depositor;	
					$total_attendanc=$row['avg_attendance']+$total_attendanc;			
			?>
			<tr>
				<td colspan="2" width='96'><?php echo $row['mnemonic'];?></td>			
				<td colspan="2"><div align="center"><?php echo number_format($row['prev_month_no_of_member_male'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['prev_month_no_of_member_female'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['no_of_new_member_admission_male'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['no_of_new_member_admission_female'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['no_of_member_cancellation_male'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['no_of_member_cancellation_female'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['no_of_member_total_male'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['no_of_member_total_female'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['avg_savings_depositor'], 0, ',', ',');?></div></td>
				<td colspan="2"><div align="center"><?php echo number_format($row['avg_attendance'], 0, ',', ',');?></div></td></tr>
			<?php endforeach;
					$grand_total_previous_male_member=$previous_male_member_total+$previous_female_member_total;				
					$grand_total_current_male_member=$current_male_member_total+$current_female_member_total;
					$grand_total_canceled_female_member=$canceled_male_member_total+$canceled_female_member_total;					
					$grand_total=$total_male+$total_female;	?>
		<tr>
				<th colspan="2" width='96'>Total</th>
				<th colspan="2"><div align="center"><?php echo number_format($previous_male_member_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($previous_female_member_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($current_male_member_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($current_female_member_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($canceled_male_member_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($canceled_female_member_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($total_male, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($total_female, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($total_depositor, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($total_attendanc, 0, ',', ',');?></div></th></tr>
			<tr>
				<th colspan="2" width='96'><div align="left">Grand Total</div></th>
				<th colspan="4"><div align="center"><?php echo number_format($grand_total_previous_male_member, 0, ',', ',');?></div></th>
				<th colspan="4"><div align="center"><?php echo number_format($grand_total_current_male_member, 0, ',', ',');?></div></th>
				<th colspan="4"><div align="center"><?php echo number_format($grand_total_canceled_female_member, 0, ',', ',');?></div></th>
				<th colspan="4"><div align="center"><?php echo number_format($grand_total, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($total_depositor, 0, ',', ',');?></div></th>
				<th colspan="2"><div align="center"><?php echo number_format($total_attendanc, 0, ',', ',');?></div></th></tr>
			<?php endif;?></table>
		<br><b>Note : </b>Double counting is avoided in all cases*<br><br><br>
	<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>