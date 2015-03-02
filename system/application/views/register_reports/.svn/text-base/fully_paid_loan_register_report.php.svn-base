<div class="scroll-report">
		<div class="report-header">
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
			<table border="0" >
		 		<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code </th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th><div align="left">Branch Address</div></th>
		 			<td colspan="3" class="align-left"><strong>:</strong><?php echo $branch_info['address'];?></td></tr>   		
				<?php else:?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code</th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo 'All';?></td></tr> 
				<?php endif;?>
				<tr>
		  			<th class="align-left" width="20%">Component</th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo $product['short_name'];?></td></tr> 
				<tr>
		 			<th class="align-left">Reporting Date</th>
		 			<td class="align-left"><strong>: </strong><?php echo date('d-m-Y',strtotime($date_from)). ' to ' .date('d-m-Y',strtotime($date_to));?></td>		 			
					<th class="align-left">Print Date</th>
		 			<td class="align-left"><strong>: </strong><?php echo date("d-m-Y");?></td></tr>
			</table>
  		<table width="100%" border="1" cellspacing="0">  
			<tr>
				<th rowspan="2" width="57"><div align="center">SL. No.</div></th>
				<th colspan="2" style="text-align: center;">Borrower</th>
				<th colspan="2" style="text-align: center;">Samity </th>
				<th rowspan="2" width="87"><div align="center">Paid Loan Principal</div></th>
				<th rowspan="2" width="87"><div align="center">Cumm. Paid Loan Principal</div></th>
				<th rowspan="2" width="105"><div align="center">Fully Paid Date</div></th>
				<th rowspan="2" width="94"><div align="center">Date of Disbursement</div></th>
				<th colspan="2" rowspan="2" width="111"><div align="center">Remarks</div></th></tr>
			  <tr>
				<th width="10%">Name</th>
				<th style="text-align: center;" width="10%">Code </th>
				<th width="10%">Name</th>
				<th style="text-align: center;" width="10%">Code</th></tr>
  	  		<?php $i=0; $total_loan_principal=0; $total_cumu_loan_principal=0;
				if(!empty($total_fully_paid_loan_register_information['total_pre_loan_principal']))
				{
					$total_cumu_loan_principal=$total_fully_paid_loan_register_information['total_pre_loan_principal'];
				}
				if(!empty($fully_paid_loan_register_information)):  foreach ($fully_paid_loan_register_information as $row): $i++;
				$total_loan_principal +=$row['loan_amount'];
				$total_cumu_loan_principal+=$row['loan_amount'];?>
			<tr>
				<td><?php echo $i;?></td>
				<td class="align-left"><?php echo $row['member_name'];?></td>
				<td class="align-center"><?php echo $row['member_code'];?></td>			
				<td class="align-left"><?php echo $row['samity_name'];?></td>
				<td class="align-center"><?php echo $row['samity_code'];?></td>
				<td class="align-right"><?php echo number_format($row['loan_amount'],'2','.',',');?></td>
				<td class="align-right"><?php echo number_format($total_cumu_loan_principal,'2','.',',');?></td>
				<td><?php if(!empty($row['loan_fully_paid_date'])) {echo date('d-m-Y',strtotime($row['loan_fully_paid_date']));} else { echo '-';}?></td>
				<td><?php if(!empty($row['disburse_date'])) {echo date('d-m-Y',strtotime($row['disburse_date']));} else { echo '-';}?></td>	
				<td colspan="2">&nbsp;</td></tr> 
  		<?php endforeach;endif; ?>	
			<tr>
				<th>Total</th>
				<th colspan="2"><?php echo $i;?></th>
				<td colspan="2">&nbsp;</td>
				<th><div align='right'><?php echo number_format($total_loan_principal,2,'.',',');?></div></th>
				<th><div align='right'><?php echo number_format($total_cumu_loan_principal,2,'.',',');?></div></th>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td></tr>
		</table><br><br><br>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
