<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/report.css" />
<div class="scroll-report">
<title>Component Wise Daily Collection Report</title>	
	<div class="report-header">
	<table border="0"> 		
		<tr><td class="organization-name-po" colspan="26"><div align="center">Centre for Community Development Assistance (CCDA)</div></td></tr>
		<tr><td class="organization-name" colspan="25">Adampur,Raipur,Daudkandi,Comilla</td></tr>
		<tr><td class="organization-name" colspan="25"><div align="center">Dhaka Office : House:109,Park Road,New DOHS,Mohakhali,Dhaka-1206</div></td></tr>
		<tr><td class="report-name" colspan="25"><div align="center">Component Wise Daily Collection Report</div></td></tr></table></div>		
	<table border="0"> 
 		<?php if(!empty($branch_info)): ?>
		<tr>
  			<th class="align-left" width="20%">Branch Name</th>
  			<td colspan="3" class="align-left" width="49%"><strong>:</strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
 		<tr>
			<th><div align="left">Branch Address</div></th>
 			<td colspan="3" class="align-left"><strong>:</strong><?php echo $branch_info['address'];?></td></tr>   		
		<?php endif;?>
		<tr>
 			<th class="align-left">Reporting Month</th>
 			<td class="align-left"><strong>:</strong><?php $date = new DateTime($date);	echo $date->format('F j, Y');?></td>
 			<th class="align-left">Print Date</th>
 			<td class="align-left"><strong>:</strong><?php echo date("F j, Y");?></td></tr>
	</table>
	<table class="report-body"  border="1" style="border-width: 1.0px" bordercolor="black" cellpadding="0" cellspacing="0" >
		<tr>
			<th colspan="2"><div align="center">Field Worker </div></th>
			<th colspan="2"><div align="center">Samity</div></th>
			<th  rowspan="2"><div align="center">Component</div></th>
			<th  rowspan="2"><div align="center">Savings Received (Compulsory) </div></th>
			<th  rowspan="2"><div align="center">Savings  Received (Voluntary)</div></th>
			<th rowspan="2"><div align="center">Savings Refund</div></th>
			<th  rowspan="2"><div align="center">Disbursement Amount </div></th>
			<th rowspan="2"><div align="center">Loan Recoverable</div></th>
			<th rowspan="2"><div align="center">Loan Overdue</div></th>
			<th rowspan="2"><div align="center">Loan Advance</div></th>
			<th  rowspan="2"><div align="center">Loan Received (Pri.) </div></th>
			<th  rowspan="2"><div align="center">Service Charge</div></th>
			<th rowspan="2"><div align="center">SKT Collection</div></th>
			<th  rowspan="2"><div align="center">Ins. Claim </div></th></tr>
		<tr>
			<th ><div align="center">ID</div></th>
			<th ><div align="center">Name</div></th>
			<th ><div align="center">ID</div></th>
			<th ><div align="center">Name</div></th></tr>  
	  	<?php 	$total_c_amount=0;$total_v_amount=0;$total_w_amount=0;$total_loan_amount=0;$total_loan_recv_amount=0;
				if(!empty($component_wise_daily_collection)):					
				foreach ($component_wise_daily_collection as $row):
				$total_c_amount+=$row['c_amount'];$total_v_amount+=$row['v_amount'];$total_w_amount+=$row['w_amount'];
				$total_loan_amount+=$row['loan_amount'];$total_loan_recv_amount+=$row['loan_recv_amount'];?>
		<tr>
			<td><?php echo $row['employee_code'];?></td> 
			<td><?php echo $row['employee_name'];?></td> 
			<td><?php echo $row['samity_code'];?></td> 
			<td><?php echo $row['samity_name'];?></td>
			<td><?php echo $product['mnemonic'];?></td>
			<td><?php echo $row['c_amount'];?></td> 
			<td><?php echo $row['v_amount'];?></td> 
			<td><?php echo $row['w_amount'];?></td> 
			<td><?php echo $row['loan_amount'];?></td> 
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			<td><?php echo $row['loan_recv_amount'];?></td> 
			<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			</tr>	
		<?php endforeach; endif;?>
		<tr>
			<th colspan=5>Total</th>			
			<th class="align-right"><?php echo $total_c_amount;?></th> 
			<th class="align-right"><?php echo $total_v_amount;?></th> 
			<th class="align-right"><?php echo $total_w_amount;?></th>
			<th class="align-right"><?php echo $total_loan_amount;?></th>
			<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
			<th class="align-right"><?php echo $total_loan_recv_amount;?></th>
			<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>
	</table>
	<br><br><br>
	<table class="report-footer" align="center" border="0">
	  	<tr>  
		  	<td width="4%">&nbsp;</td>
			<td class="report-footer-margin" width="19%"><strong>Prepared By</strong></td>
			<td width="17%">&nbsp;</td>
			<td class="report-footer-margin" width="20%"><strong>Verified By </strong></td>
			<td width="18%">&nbsp;</td>
			<td class="report-footer-margin" width="17%"><strong>Approved By</strong> </td>
			<td width="5%">&nbsp;</td></tr></table>
<div><div>
