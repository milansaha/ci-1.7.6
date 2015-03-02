<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>			
			<table width="100%" border="0" cellspacing="0"> 
		 		<tr><td colspan='4'><h2><div align="center"><?php echo $headline;?></div></h2></td></tr>
				<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th width='15%'><div align='left'>Branch Name & Code </div></th>
		  			<td ><div align='left'><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th width='15%'><div align='left'>Branch Address</div></th>
		 			<td ><div align='left'><strong>: </strong><?php echo $branch_info['address'];?></div></td></tr>   		
				<?php else:?>
				<tr>
		  			<th width='15%'><div align='left'>Branch Name</div></th>
		  			<td><div align='left'><strong>: </strong><?php echo 'All';?></div></td></tr> 
				<?php endif;?>
				<tr>
		 			<th width='15%'><div align="left">Reporting Date</div></th>
		 			<td ><div align="left"><strong>: </strong><?php echo date('F,Y',strtotime("$year_name-$month_name-01"));?></div></td>		 			
					<th width='15%'><div align="left">Print Date</div></th>
		 			<td ><div align="left"><strong>: </strong><?php echo date("d-m-Y");?></div></td></tr></table>
			
			<table width="100%" border="1" cellspacing="0"> 
		  	<tr>
				<th rowspan="2" width="1%"><div align="center">Component</div></th>
				<th rowspan="2" width="10%"><div align="center">Total Loan Outstanding</div></th>
				<th rowspan="2" width="10%"><div align="center">Total Overdue</div></th>
				<th rowspan="2" width="10%"><div align="center">Current Overdue</div></th>
				<th colspan="3" width="10%"><div align="center">Required DRM</div></th>
				<th rowspan="2" width="10%"><div align="center">Total</div></th>
				<th rowspan="2" width="10%"><div align="center">DMR Investment</div></th>
				<th rowspan="2" width="10%"><div align="center">Surplus/Deficit</div></th></tr>
		  	<tr>
				<th width="4%"><div align="center">Good Loan Outstanding GLO 1%</div></th>
				<th width="4%"><div align="center">Doubtful Loan Outstanding(181-365 Days) DLO 75%</div></th>
				<th width="5%"><div align="center">Bad Loan Outstanding(365+) BLO 100%</div></th>
			</tr>
			<?php 
			$net_total_outstanding = 0.00;
			$net_total_overdue = 0.00;
			$net_current_overdue = 0.00;
			$net_good_loan_outstanding = 0.00;
			$net_doubtful_loan_outstanding = 0.00;
			$net_bad_loan_outstanding = 0.00;
			//echo "<pre>";
			//print_r($loan_field_officer_wise_info);
			$i=0; if(!empty($loan_field_officer_wise_info)){  
				foreach ($loan_field_officer_wise_info as $row){
					$net_total_outstanding += $row['total_outstanding'];
					$net_total_overdue += $row['total_overdue'];
					$net_current_overdue += $row['current_overdue'];
					$net_good_loan_outstanding += $row['good_loan_outstanding'];
					$net_doubtful_loan_outstanding += $row['doubtful_loan_outstanding'];
					$net_bad_loan_outstanding += $row['bad_loan_outstanding'];
				?>
			<tr>
				<td><?php echo $row['product_name'];?></td>
				<td align="right"><?php printf('%.2f',$row['total_outstanding']);?></td>
				<td align="right"><?php printf('%.2f', $row['total_overdue']);?></td>
				<td align="right"><?php printf('%.2f',$row['current_overdue']);?></td>
				<td align="right"><?php printf('%.2f',$row['good_loan_outstanding']);?></td>
				<td align="right"><?php printf('%.2f',$row['doubtful_loan_outstanding']);?></td>
				<td align="right"><?php printf('%.2f',$row['bad_loan_outstanding']);?></td>
				<td align="right"><?php printf('%.2f',$row['good_loan_outstanding']+$row['doubtful_loan_outstanding']+$row['bad_loan_outstanding']);?></td>				
				<td align="right"></td>
				<td align="right"></td></tr>
			<?php }
		}
			
			//print_r($loan_field_officer_wise_info);
			 ?>	
			<tr>
				<th>Total</th>
				<th><div align="right"><?php printf('%.2f',$net_total_outstanding);?></div></th>
				<th><div align="right"><?php printf('%.2f',$net_total_overdue);?></div></th>
				<th><div align="right"><?php printf('%.2f',$net_current_overdue);?></div></th>
				<th><div align="right"><?php printf('%.2f',$net_good_loan_outstanding);?></div></th>
				<th><div align="right"><?php printf('%.2f',$net_doubtful_loan_outstanding);?></div></th>
				<th><div align="right"><?php printf('%.2f',$net_bad_loan_outstanding);?></div></th>
				<th><div align="right"><?php printf('%.2f',$net_good_loan_outstanding+$net_bad_loan_outstanding+$net_bad_loan_outstanding);?></div></th>
				<th></th>
				<th></th></tr></table>
<br><br><br>				
<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
