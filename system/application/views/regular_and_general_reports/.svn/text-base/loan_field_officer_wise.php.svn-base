<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>		
			<table border="0"> 
		 		<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code </th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th><div align="left">Branch Address</div></th>
		 			<td colspan="3" class="align-left"><strong>: </strong><?php echo $branch_info['address'];?></td></tr>   		
				<?php else:?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code</th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo 'All';?></td></tr> 
				<?php endif;?>
				<tr>
		 			<th class="align-left">Reporting Date</th>
		 			<td class="align-left"><strong>: </strong>
					<?php echo date('d-m-Y',strtotime($from_date)). ' to ' .date('d-m-Y',strtotime($to_date));?></td>		 			
					<th class="align-left">Print Date</th>
		 			<td class="align-left"><strong>: </strong><?php echo date("d-m-Y");?></td></tr></table>
			
			<table class="report-body" width="100%" border="1" cellspacing="0">  
		  	<tr>
				<th rowspan="2" width="1%"><div align="center"><b>SL. No.</b></div></th>
				<th rowspan="2" width="10%"><div align="center">Field Worker's Name</div></th>
				<th colspan="3" width="10%"><div align="center">Current Loan</div></th>
				<th colspan="3" width="10%"><div align="center">Outstanding Opening Balance</div></th>
				<th colspan="3" width="10%"><div align="center">Disbursement</div></th>
				<th colspan="3" width="10%"><div align="center">Recovery</div></th>
				<th colspan="3" width="10%"><div align="center">Outstanding Closing Balance</div></th>
				<th colspan="3" width="10%"><div align="center">Outstanding Principle</div></th>
				<th colspan="3" width="10%"><div align="center">Outstanding Service Charge</div></th></tr>
		  	<tr>
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>				
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>
				<th width="4%"><div align="center">Male</div></th>
				<th width="4%"><div align="center">Female</div></th>
				<th width="5%"><div align="center">Total</div></th>
			</tr>
			<?php 
			
			$grand_m_current_loan = 0.00;
			$grand_f_current_loan = 0.00;
			$total_current_loan = 0.00;
			$grand_total_current_loan = 0.00;
			
			$m_outstanding_opening_balance = 0.00;
			$grand_m_outstanding_opening_balance = 0.00;
			$f_outstanding_opening_balance = 0.00;
			$grand_f_outstanding_opening_balance = 0.00;
			$total_outstanding_opening_balance = 0.00;
			$grand_total_outstanding_opening_balance = 0.00;
			$m_current_disburse = 0.00;
			$grand_m_current_disburse = 0.00;
			$f_current_disburse = 0.00;
			$grand_f_current_disburse = 0.00;
			$total_current_disburse = 0.00;
			$grand_total_current_disburse = 0.00;
			$m_recovery = 0.00;	
			$grand_m_recovery = 0.00;		
			$f_recovery = 0.00;	
			$grand_f_recovery = 0.00;	
			$total_recovery = 0.00;
			$grand_total_recovery = 0.00;
			$m_outstanding_closing_balance = 0.00;
			$grand_m_outstanding_closing_balance = 0.00;
			$f_outstanding_closing_balance = 0.00;
			$grand_f_outstanding_closing_balance = 0.00;
			$total_outstanding_closing_balance = 0.00;
			$grand_total_outstanding_closing_balance = 0.00;
			$m_outstanding_principle = 0.00;
			$grand_m_outstanding_principle = 0.00;
			$f_outstanding_principle = 0.00;
			$grand_f_outstanding_principle = 0.00;
			$total_outstanding_principle = 0.00;
			$grand_total_outstanding_principle = 0.00;
			$m_outstanding_service_charge = 0.00;
			$grand_m_outstanding_service_charge = 0.00;
			$f_outstanding_service_charge = 0.00;
			$grand_f_outstanding_service_charge = 0.00;
			$total_outstanding_service_charge = 0.00;
			$grand_total_outstanding_service_charge = 0.00;
			
			$i=0; if(!empty($loan_field_officer_wise_info)){  
				foreach ($loan_field_officer_wise_info as $row){
					
			$grand_m_current_loan += $row['m_current_loan'];
			$grand_f_current_loan += $row['f_current_loan'];
			$total_current_loan = $row['m_current_loan']+$row['f_current_loan'];
			$grand_total_current_loan += $total_current_loan;
			
			$m_outstanding_opening_balance = $row['m_outstanding_opening_balance_principle']+$row['m_outstanding_opening_balance_service_charge'];
			$grand_m_outstanding_opening_balance += $m_outstanding_opening_balance;
			$f_outstanding_opening_balance = $row['f_outstanding_opening_balance_principle']+$row['f_outstanding_opening_balance_service_charge'];
			$grand_f_outstanding_opening_balance += $f_outstanding_opening_balance;
			$total_outstanding_opening_balance = $m_outstanding_opening_balance + $f_outstanding_opening_balance;
			$grand_total_outstanding_opening_balance += $total_outstanding_opening_balance;
			
			$m_current_disburse = $row['m_current_disburse_principle'];
			$grand_m_current_disburse += $m_current_disburse;
			$f_current_disburse = $row['f_current_disburse_principle'];
			$grand_f_current_disburse += $f_current_disburse;
			$total_current_disburse = $m_current_disburse + $f_current_disburse;
			$grand_total_current_disburse += $total_current_disburse;
			
			$m_recovery = $row['m_recovery_principle']+$row['m_recovery_services_charge'];
			$grand_m_recovery += $m_recovery;
			$f_recovery = $row['f_recovery_principle']+$row['f_recovery_services_charge'];
			$grand_f_recovery += $f_recovery;
			$total_recovery = $m_recovery + $f_recovery;
			$grand_total_recovery += $total_recovery;
			
			$m_outstanding_closing_balance = $m_outstanding_opening_balance+$m_current_disburse+$row['m_current_disburse_services_charge'] - $m_recovery;
			$grand_m_outstanding_closing_balance += $m_outstanding_closing_balance;
			$f_outstanding_closing_balance = $f_outstanding_opening_balance+$f_current_disburse+$row['f_current_disburse_services_charge'] - $f_recovery;
			$grand_f_outstanding_closing_balance += $f_outstanding_closing_balance;
			$total_outstanding_closing_balance = $m_outstanding_closing_balance + $f_outstanding_closing_balance;
			$grand_total_outstanding_closing_balance += $total_outstanding_closing_balance;
			
			$m_outstanding_principle = $row['m_outstanding_opening_balance_principle']+$row['m_current_disburse_principle']-$row['m_recovery_principle'];
			$grand_m_outstanding_principle += $m_outstanding_principle;
			$f_outstanding_principle = $row['f_outstanding_opening_balance_principle']+$row['f_current_disburse_principle']-$row['f_recovery_principle'];
			$grand_f_outstanding_principle += $f_outstanding_principle;
			$total_outstanding_principle = $m_outstanding_principle + $f_outstanding_principle;
			$grand_total_outstanding_principle += $total_outstanding_principle;
			
			$m_outstanding_service_charge = $row['m_outstanding_opening_balance_service_charge']+$row['m_current_disburse_services_charge']-$row['m_recovery_services_charge'];
			$grand_m_outstanding_service_charge += $m_outstanding_service_charge;
			$f_outstanding_service_charge =  $row['f_outstanding_opening_balance_service_charge']+$row['f_current_disburse_services_charge']-$row['f_recovery_services_charge'];
			$grand_f_outstanding_service_charge += $f_outstanding_service_charge;
			$total_outstanding_service_charge = $m_outstanding_service_charge + $f_outstanding_service_charge;
			$grand_total_outstanding_service_charge += 	$total_outstanding_service_charge;
				?>
			<tr>
				<th><?php echo ++$i;?></td>
				<td align="left"><?php echo $row['field_officer_name'];?></td>
				<td><?php echo $row['m_current_loan'];?></td>
				<td><?php echo $row['f_current_loan'];?></td>
				<td><?php echo $total_current_loan;?></td>
				<td><?php echo $m_outstanding_opening_balance;?></td>
				<td><?php echo $f_outstanding_opening_balance;?></td>
				<td><?php echo $total_outstanding_opening_balance;?></td>
				<td><?php echo $m_current_disburse;?></td>				
				<td><?php echo $f_current_disburse;?></td>
				<td><?php echo $total_current_disburse;?></td>
				<td><?php echo $m_recovery;?></td>
				<td><?php echo $f_recovery;?></td>
				<td><?php echo $total_recovery;?></td>
				<td><?php echo $m_outstanding_closing_balance;?></td>				
				<td><?php echo $f_outstanding_closing_balance;?></td>
				<td><?php echo $total_outstanding_closing_balance;?></td>
				<td><?php echo $m_outstanding_principle;?></td>
				<td><?php echo $f_outstanding_principle;?></td>
				<td><?php echo $total_outstanding_principle;?></td>
				<td><?php echo $m_outstanding_service_charge;?></td>
				<td><?php echo $f_outstanding_service_charge;?></td>
				<td><?php echo $total_outstanding_service_charge;?></td></tr>
			<?php }
		}
			
			//print_r($loan_field_officer_wise_info);
			 ?>	
			<tr>
				<th colspan="2">Total</th>
				<th><?php echo $grand_m_current_loan;?></th>
				<th><?php echo $grand_f_current_loan;?></th>
				<th><?php echo $grand_total_current_loan;?></th>
				<th><?php echo $grand_m_outstanding_opening_balance;?></th>
				<th><?php echo $grand_f_outstanding_opening_balance;?></th>
				<th><?php echo $grand_total_outstanding_opening_balance;?></th>
				<th><?php echo $grand_m_current_disburse;?></th>
				<th><?php echo $grand_f_current_disburse;?></th>
				<th><?php echo $grand_total_current_disburse;?></th>
				<th><?php echo $grand_m_recovery;?></th>
				<th><?php echo $grand_f_recovery;?></th>
				<th><?php echo $grand_total_recovery;?></th>
				<th><?php echo $grand_m_outstanding_closing_balance;?></th>
				<th><?php echo $grand_f_outstanding_closing_balance;?></th>
				<th><?php echo $grand_total_outstanding_closing_balance;?></th>
				<th><?php echo $grand_m_outstanding_principle;?></th>
				<th><?php echo $grand_f_outstanding_principle;?></th>
				<th><?php echo $grand_total_outstanding_principle;?></th>
				<th><?php echo $grand_m_outstanding_service_charge;?></th>
				<th><?php echo $grand_f_outstanding_service_charge;?></th>
				<th><?php echo $grand_total_outstanding_service_charge;?></th></tr></table>			
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
