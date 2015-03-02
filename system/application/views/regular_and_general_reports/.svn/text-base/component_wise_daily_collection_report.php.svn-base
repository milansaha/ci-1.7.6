<div class="scroll-report">
	<div class="report-header">	
		<div align="center"><?php $this->load->view('/elements/report_header');?></div>
		<br>				
		<table width="100%" border="0" cellspacing="0"> 
			<tr>
				<td align="center" colspan='4'><h2><?php echo $headline;?></h2></td></tr> 
				<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th width='15%'><div align="left">Branch Name & Code </div></th>
		  			<td><div align="left"><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></div></td></tr> 
		 		<tr>
					<th><div align="left">Branch Address</div></th>
		 			<td><div align="left"><strong>:</strong><?php echo $branch_info['address'];?></div></td></tr>   		
				<?php else:?>
				<tr>
		  			<th><div align="left">Branch Name & Code</div></th>
		  			<td><div align="left"><strong>: </strong><?php echo 'All';?></div></td></tr> 
				<?php endif;?>
				<tr>
		  			<th><div align="left">Component</div></th>
		  			<td><div align="left"><strong>: </strong><?php echo $product['short_name'];?></div></td></tr> 
				<tr>
		 			<th><div align="left">Reporting Date</div></th>
		 			<td><div align="left"><strong>: </strong><?php echo date('d-m-Y',strtotime($date));?></div></td>		 			
					<th width='10%'><div align="left">Print Date</div></th>
		 			<td><div align="left"><strong>: </strong><?php echo date("d-m-Y");?></div></td></tr></table>
		<table  width="100%" border="1" cellspacing="0">  
			<tr>
				<th colspan="2"><div align="center">Field Worker </div></th>
				<th colspan="2"><div align="center">Samity</div></th>
				<th  rowspan="2"><div align="center">Component</div></th>
				<?php 
					$total_saving_withdraw_collection_amount=0;
					$total_loan_disburse_collection_amount=0;
					$total_recoverable_collection_amount=0;
					$total_loan_due_collection_amount=0;
					$total_loan_advance_collection_amount=0;
					$total_principal_collection_amount=0;
					$total_interest_collection_amount=0;
					$total_SKT_collection_collection_amount=0;
				foreach ($savings_product_type as $savings_product_type_row):?>
					<th  rowspan="2"><div align="center"><?php echo $savings_product_type_row['name'];?></div></th>
				<?php endforeach;?>			
				<th rowspan="2"><div align="center">Savings Refund</div></th>
				<th rowspan="2"><div align="center">Disbursement Amount </div></th>
				<th rowspan="2"><div align="center">Loan Recoverable</div></th>
				<th rowspan="2"><div align="center">Loan Overdue</div></th>
				<th rowspan="2"><div align="center">Loan Advance</div></th>
				<th rowspan="2"><div align="center">Loan Received (Pri.) </div></th>
				<th rowspan="2"><div align="center">Service Charge</div></th>
				<th rowspan="2"><div align="center">SKT Collection</div></th>
				<th rowspan="2"><div align="center">Ins. Claim </div></th></tr>
			<tr>
				<th ><div align="center">ID</div></th>
				<th ><div align="center">Name</div></th>
				<th ><div align="center">ID</div></th>
				<th ><div align="center">Name</div></th></tr>  
				<?php 	$i=0;				
					if(!empty($component_wise_daily_collection)):					
					foreach ($component_wise_daily_collection as $row):
					$i++;?>
			<tr>
				<?php if($i==1):							
					$previous_employee_code=$row['employee_code'];?>
					<td align="left"><?php echo $row['employee_code'];?></td> 
					<td align="left"><?php echo $row['employee_name'];?></td> 
				<?php else:			
					if($previous_employee_code==$row['employee_code']):?>
					<td align="left"><?php echo "";?></td> 
					<td align="left"><?php echo "";?></td> 
				<?php else:
					$previous_employee_code=$row['employee_code'];?>
					<td align="left"><?php echo $row['employee_code'];?></td> 
					<td align="left"><?php echo $row['employee_name'];?></td> 
				<?php endif; endif;?>			
				<td align="left"> <?php echo $row['samity_code'];?></td> 
				<td align="left"><?php echo $row['samity_name'];?></td>
				<td ><?php echo $product['short_name'];?></td>
				<?php foreach ($savings_product_type as $savings_product_type_row):?>
					<td align="right"><?php if(isset($row['saving_deposit_collection_amount'][$savings_product_type_row['id']])):					
							echo number_format($row['saving_deposit_collection_amount'][$savings_product_type_row['id']],'2','.',',');	
						
							if(empty($total[$savings_product_type_row['id']])):
							$total[$savings_product_type_row['id']]=$row['saving_deposit_collection_amount'][$savings_product_type_row['id']];
							else:
							$total[$savings_product_type_row['id']]=$total[$savings_product_type_row['id']]+$row['saving_deposit_collection_amount'][$savings_product_type_row['id']];
							endif;

							else: 
							echo "0.00";	

							if(empty($total[$savings_product_type_row['id']])):
							$total[$savings_product_type_row['id']]=0;
							else:
							$total[$savings_product_type_row['id']]=$total[$savings_product_type_row['id']]+0;				
							endif;endif;?>
					</td> 
				<?php endforeach;?>
				<td align="right"><?php echo number_format($row['saving_withdraw_collection_amount'],'2','.',',');
								$total_saving_withdraw_collection_amount=$total_saving_withdraw_collection_amount+$row['saving_withdraw_collection_amount'];?></td> 
				<td align="right"><?php echo number_format($row['loan_disburse_collection_amount'],'2','.',',');
								$total_loan_disburse_collection_amount=$total_loan_disburse_collection_amount+$row['loan_disburse_collection_amount'];?></td> 
				<td align="right"><?php echo number_format($row['recoverable_collection_amount'],'2','.',',');
								$total_recoverable_collection_amount=$total_recoverable_collection_amount+$row['recoverable_collection_amount'];?></td> 
				<td align="right"><?php echo number_format($row['loan_due_collection_amount'],'2','.',',');
								$total_loan_due_collection_amount=$total_loan_due_collection_amount+$row['loan_due_collection_amount'];?></td>
				<td align="right"><?php echo number_format($row['loan_advance_collection_amount'],'2','.',',');
								$total_loan_advance_collection_amount=$total_loan_advance_collection_amount+$row['loan_advance_collection_amount'];?></td>
				<td align="right"><?php echo number_format($row['principal_collection_amount'],'2','.',',');
								$total_principal_collection_amount=$total_principal_collection_amount+$row['principal_collection_amount'];?></td> 
				<td align="right"><?php echo number_format($row['interest_collection_amount'],'2','.',',');
								$total_interest_collection_amount=$total_interest_collection_amount+$row['interest_collection_amount'];?></td> 
				<td align="right"><?php echo number_format($row['SKT_collection_collection_amount'],'2','.',',');
								$total_SKT_collection_collection_amount=$total_SKT_collection_collection_amount+$row['SKT_collection_collection_amount'];?></td> 
				<td align="right"><?php echo "0.00";?></td></tr>	
			<?php endforeach; endif;?>
			<tr>
				<th colspan=5>Total</th>			
					<?php foreach ($savings_product_type as $savings_product_type_row):?>
				<th><div align="right"><?php if(isset($row['saving_deposit_collection_amount'][$savings_product_type_row['id']])):						
						if(!empty($total[$savings_product_type_row['id']])):
							echo number_format($total[$savings_product_type_row['id']],'2','.',',');						
						endif;else: 
						if(!empty($total[$savings_product_type_row['id']])):
							echo number_format($total[$savings_product_type_row['id']],'2','.',',');			
						endif;endif;?></div></th> 			
				<?php endforeach;?>
				<th><div align="right"><?php if(!empty($total_saving_withdraw_collection_amount)):
												echo  number_format($total_saving_withdraw_collection_amount,'2','.',','); endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_loan_disburse_collection_amount)):
												echo  number_format($total_loan_disburse_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_recoverable_collection_amount)):
												echo  number_format($total_recoverable_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_loan_due_collection_amount)):
												echo  number_format($total_loan_due_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_loan_advance_collection_amount)):
												echo  number_format($total_loan_advance_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_principal_collection_amount)):
												echo  number_format($total_principal_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_interest_collection_amount)):
												echo  number_format($total_interest_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php if(!empty($total_SKT_collection_collection_amount)):
												echo  number_format($total_SKT_collection_collection_amount,'2','.',',');endif;?></div></th>
				<th><div align="right"><?php echo "";?></div></th></tr>
		</table><br><br><br>
	<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>