<div class="scroll-report">
	<div class="report-header">	
		<div align="center"><?php $this->load->view('/elements/report_header');?></div>
		<br>				
		<table width="100%" border="0" cellspacing="0"> 
			<tr>
				<td align="center" colspan='4'><h2><?php echo $headline;?></h2></td></tr> 			
		 		<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th width='15%'><div align="left">Branch Name & Code</div></th>
		  			<td><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th  width='15%'><div align="left">Branch Address</div></th>
		 			<td ><strong>: </strong><?php echo $branch_info['address'];?></td></tr>   		
				<?php else:?>
				<tr>
		  			<th  width='15%'><div align="left">Branch Name & Code</div></th>
		  			<td ><strong>: </strong><?php echo 'All';?></td></tr> 
				<?php endif;?>
				<tr>
		 			<th  width='15%'><div align="left">Reporting Date</div></th>
		 			<td class="align-left"><strong>: </strong><?php echo date('d-m-Y',strtotime($first_date)). ' to ' .date('d-m-Y',strtotime($last_date));?></td>		 			
					<th  width='10%'><div align="left">Print Date</div></th>
		 			<td class="align-left"><strong>: </strong><?php echo date("d-m-Y");?></td></tr></table>			
			<table width="100%" border="1" cellspacing="0"> 
		  	<tr>
				<th rowspan="3" width="3%"><div align="center">SL. No. </div></th>
				<th colspan="2"><div align="center">Branch</div></th>
				<th rowspan="2" width="11%"><div align="center">No. of Members </div></th>
				<th rowspan="2" width="10%"><div align="center">No. of Borrower </div></th>
				<th rowspan="2" width="10%"><div align="center">Current Loan </div></th>
				<th rowspan="2" width="10%"><div align="center">Loan Outstanding </div>      <div align="center"></div></th>
				<th rowspan="2" width="7%"><div align="center">Overdue</div>      <div align="center"></div></th>
				<th rowspan="2" width="9%"><div align="center">Savings Balance </div></th>
				<th rowspan="2" width="17%"><div align="center">Name of Branch Manager </div></th></tr>
			<tr>
				<th width="4%">Code</th>
				<th width="19%"><div align="center">Name  </div></th>
			</tr>
			<tr>
				<th><div align="center">1</div></th>    
				<th><div align="center">2</div></th>
				<th><div align="center">3</div></th>
				<th><div align="center">4</div></th>
				<th><div align="center">5</div></th>
				<th><div align="center">6</div></th>
				<th><div align="center">7</div></th>
				<th><div align="center">8</div></th>
				<th><div align="center">9</div></th></tr>
			<?php $i=0; if(isset($consolidated_banalce_data)):	
				$total_member_no=0;$total_borrower_no=0;$total_current_loan=0;$total_loan_outstanding=0;$total_loverdue=0;$total_savings=0;
				foreach ($consolidated_banalce_data as $row): 
				$total_member_no+=$row->member_no;
				$total_borrower_no+=$row->borrower_no;
				$total_current_loan+=$row->current_loan;
				$total_loan_outstanding+=$row->loan_outstanding;
				$total_loverdue+=$row->overdue;
				$total_savings+=$row->savings;
				$i++;?>
			<tr>
				<td align="center"><?php echo $i;?></td>
				<td align="center"><?php echo $row->code;?></td>
				<td><?php echo $row->name;?></td>
				<td align="center"><?php echo number_format($row->member_no,'0','.',',');?></td>
				<td align="center"><?php echo number_format($row->borrower_no,'0','.',',');?></td>
				<td align="right"><?php echo number_format($row->current_loan,'2','.',',');?></td>
				<td align="right"><?php echo number_format($row->loan_outstanding,'2','.',',');?></td>
				<td align="right"><?php echo number_format($row->overdue,'2','.',',');?></td>
				<td align="right"><?php echo number_format($row->savings,'2','.',',');?></td>	
				<td align="right"><?php echo $row->employee_name;?></td></tr>		
			<?php endforeach;endif; ?>
			<tr>
				<th colspan="2">Total</th>
				<th><div align="center"><?php echo $i;?></div></th>
				<th><div align="center"><?php echo number_format($total_member_no,'0','.',',');?></div></th>
				<th><div align="center"><?php echo number_format($total_borrower_no,'0','.',',');?></div></th>
				<th><div align="right"><?php echo number_format($total_current_loan,'2','.',',');?></div></th>
				<th><div align="right"><?php echo number_format($total_loan_outstanding,'2','.',',');?></div></th>
				<th><div align="right"><?php echo number_format($total_loverdue,'2','.',',');?></div></th>
				<th><div align="right"><?php echo number_format($total_savings,'2','.',',');?></div></th>
				<th>&nbsp;</th></tr>	
			</table>	<br><br><br>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>