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
			<tr><th rowspan="2" width="41"><p align="center">SL. No. </p></th>
				<th rowspan="2" width="68"><div align="center">Date</div></th>
				<th colspan="2"><div align="center">Borrower</div></th>
				<th colspan="2"><div align="center">Samity</div></th>
				<th rowspan="2" width="72"><div align="center">Name of Spouse/Guardian</div></th>
				<th rowspan="2" width="62"><div align="center">Village</div></th>
				<th rowspan="2" width="51"><div align="center">Purpose</div></th>
				<th rowspan="2" width="34"><div align="center">Cycle </div></th>
				<th rowspan="2" width="60"><div align="center"><p>Loan Amount</p></div></th>
				<th rowspan="2" width="60"><div align="center"><p>Cum. Loan Amount</p></div></th>
				<th colspan="2"><div align="center">Signature</div></th></tr>
  			<tr>
				<th width="80"><div align="center">Name </div></th>
				<th width="77"> Code </th>
				<th width="75"><div align="center">Name </div></th>
				<th width="79">Code</th>
				<th width="99"><div align="center">Borrower</div></th>
				<th width="106"><div align="center">AC/BR. Manager </div></th></tr>

  	  	<?php 	$i=0; $total_loan=0; $cumulative_loan=0;
				if($loan_disbursement_total['total_loan']>0)
				{
					$cumulative_loan=$loan_disbursement_total['total_loan'];
				}								
				if(!empty($loan_disbursement_information)):  foreach ($loan_disbursement_information as $row): $i++; 
				$cumulative_loan+=$row['loan_amount'];
				$total_loan+=$row['loan_amount'];?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php if(!empty($row['disburse_date'])) {echo date('d-m-Y',strtotime($row['disburse_date']));} else { echo '-';}?></td>
		   	 	<td class="align-left"><?php echo $row['member_name'];?></td>
		   		<td><?php echo $row['member_code'];?></td>
				<td class="align-left"><?php echo $row['samity_name'];?></td>
				<td><?php echo $row['samity_code'];?></td>			   
		   		<td class="align-left"><?php echo $row['fathers_spouse_name'];?></td>
				<td class="align-left"><?php echo $row['village_name'];?></td>
				<td><?php echo $row['loan_purposes'];?></td>
				<td><?php echo $row['cycle'];?></td>
				<td class="align-right"><?php echo number_format($row['loan_amount'],'2','.',',');?></td>
				<td class="align-right"><?php echo number_format($cumulative_loan,'2','.',',');?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td></tr> 
  		<?php endforeach;endif; ?>	
			<tr>
				<th>Total</th>
				<th>&nbsp;</th>
				<th colspan="2"><?php echo $i;?></th>
				<th colspan="2">&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th class="align-right"><?php echo number_format($total_loan,'2','.',',');?></th>
				<th class="align-right"><?php echo number_format($cumulative_loan,'2','.',',');?></th>
				<th>&nbsp;</th>
				<th>&nbsp;</th></tr>

		</table>
		<br>
		<br>
		<br>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>	
</div></div>	

