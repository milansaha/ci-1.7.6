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
		<table width="100%" border="0" cellspacing="0"> 
			<tr><th class="report-sub-name">1. Loan Statement</th></tr></table>
		<br>
		<table width="100%" border="1" cellspacing="0">  
			<tr>
				<th colspan="2" rowspan="2"><div align="center"><strong>Component</strong></div></th>
				<th colspan="2"><div align="center"><strong>At the End of Last Month </strong></div></th>
				<th colspan="2"><div align="center"><strong>Loan Disbursement Current Month </strong></div></th>
				<th rowspan="2"><div align="center"><strong>Total Loan Recovery Amount(Current Month) </strong></div></th>
				<th rowspan="2"><div align="center"><strong>Fully Paid Borrower(Current Month) </strong></div></th>
				<th colspan="2"><div align="center"><strong>At the End of the Month </strong></div></th></tr>
			<tr>
				<th><div align="center"><strong>Borrower No. </strong></div></th>
				<th><div align="center"><strong>Loan Outstanding </strong></div></th>
				<th><div align="center"><strong>Borrower No. </strong></div></th>
				<th><div align="center"><strong>Amount</strong></div></th>
				<th><div align="center"><strong>Borrower No. </strong></div></th>
				<th><div align="center"><strong>Amount</strong></div></th></tr>
			<tr>
				<th><div align="center">1</div></th>
				<th><div align="center"></div></th>
				<th><div align="center">2</div></th>
				<th><div align="center">3</div></th>
				<th><div align="center">4</div></th>
				<th><div align="center">5</div></th>
				<th><div align="center">6</div></th>
				<th><div align="center">7</div></th>
				<th><div align="center">8=2+4-7</div></th>
				<th><div align="center">9=3+5-6</div></th></tr>
			<?php 
					$fopening_borrower_no = 0;
					$fopening_outstanding_amount = 0;
					$fcurrent_month_borrower_no=0;
					$floan_disbursed_amount = 0;				
					$ftotal_loan_recovery_amount=0;
					$ffully_paid_borrower_no =0; 
					$fend_of_month_borrower_no=0;
					$fend_of_month_amount=0;
					
					$mopening_borrower_no = 0;
					$mopening_outstanding_amount = 0;
					$mcurrent_month_borrower_no=0;	
					$mloan_disbursed_amount = 0;			
					$mtotal_loan_recovery_amount=0;
					$mfully_paid_borrower_no =0; 
					$mend_of_month_borrower_no=0;
					$mend_of_month_amount=0;
					
					$grand_total_opening_borrower_no =0;
					$grand_total_opening_outstanding_amount =0;
					$grand_total_current_month_borrower_no=0;	
					$grand_total_loan_disbursed_amount = 0;		
					$grand_total_total_loan_recovery_amount=0;		
					$grand_total_fully_paid_borrower_no =0; 		
					$grand_total_end_of_month_borrower_no=0;		
					$grand_total_end_of_month_amount=0;	
			 // print_r($loan_info);
			 $tmp_product= "";
				foreach($loan_info as $loan){
						$fopening_borrower_no = 0;
					$fopening_outstanding_amount = 0;
					$fcurrent_month_borrower_no=0;
					$floan_disbursed_amount = 0;				
					$ftotal_loan_recovery_amount=0;
					$ffully_paid_borrower_no =0; 
					$fend_of_month_borrower_no=0;
					$fend_of_month_amount=0;
					
					$mopening_borrower_no = 0;
					$mopening_outstanding_amount = 0;
					$mcurrent_month_borrower_no=0;	
					$mloan_disbursed_amount = 0;			
					$mtotal_loan_recovery_amount=0;
					$mfully_paid_borrower_no =0; 
					$mend_of_month_borrower_no=0;
					$mend_of_month_amount=0;
					
						if($loan->TYPE=='F'){
							$gender = "Female";
							$fopening_borrower_no = $loan->opening_borrower_no;
							$fopening_outstanding_amount = $loan->opening_outstanding_amount;
							$fcurrent_month_borrower_no=$loan->borrower_no;		
							$floan_disbursed_amount = $loan->disbursed_amount;						
							$ftotal_loan_recovery_amount=$loan->principal_recoverable_amount+$loan->interest_recoverable_amount;				
							$ffully_paid_borrower_no =$loan->fully_paid_borrower_no; 				
							$fend_of_month_borrower_no=$loan->opening_borrower_no+$loan->borrower_no-$loan->fully_paid_borrower_no;
							$fend_of_month_amount=$loan->closing_outstanding_amount;			
						}
						if($loan->TYPE=='M'){
							$gender = "Male";
							$mopening_borrower_no = $loan->opening_borrower_no;
							$mopening_outstanding_amount = $loan->opening_outstanding_amount;
							$mcurrent_month_borrower_no=$loan->borrower_no;
							$mloan_disbursed_amount = $loan->disbursed_amount;								
							$mtotal_loan_recovery_amount=$loan->principal_recoverable_amount+$loan->interest_recoverable_amount;				
							$mfully_paid_borrower_no =$loan->fully_paid_borrower_no; 				
							$mend_of_month_borrower_no=$loan->opening_borrower_no+$loan->borrower_no-$loan->fully_paid_borrower_no;
							$mend_of_month_amount=$loan->closing_outstanding_amount;				
						}
					//Total
					$opening_borrower_no = $fopening_borrower_no+$mopening_borrower_no;
					$opening_outstanding_amount =$fopening_outstanding_amount+$mopening_outstanding_amount;
					$current_month_borrower_no=$fcurrent_month_borrower_no+$mcurrent_month_borrower_no;	
					$loan_disbursed_amount = $floan_disbursed_amount+$mloan_disbursed_amount;		
					$total_loan_recovery_amount=$ftotal_loan_recovery_amount+$mtotal_loan_recovery_amount;		
					$fully_paid_borrower_no =$ffully_paid_borrower_no+$mfully_paid_borrower_no; 		
					$end_of_month_borrower_no=$fend_of_month_borrower_no+$mend_of_month_borrower_no;		
					$end_of_month_amount=$fend_of_month_amount+$mend_of_month_amount;
						
			  ?>
			<tr>
				<td><?php echo ($tmp_product ==  $loan->short_name)? "":$loan->short_name;?></td>
				<td><?php echo $gender ?></td>   
				<td><div align="center"><?php echo $loan->opening_borrower_no;?></div></td>
				<td class="align-right"><div align="right"><?php printf("%0.2f",$loan->opening_outstanding_amount);?></div></td>
				<td><div align="center"><?php echo $loan->borrower_no;?></div></td>
				<td class="align-right"><div align="right"><?php printf("%0.2f",$loan->disbursed_amount);?></div></td>
				<td class="align-right"><div align="right"><?php printf("%0.2f",$loan->principal_recoverable_amount+$loan->interest_recoverable_amount);?></div></td>
				<td class="align-center"><div align="center"><?php echo $loan->fully_paid_borrower_no;?><div></td>
				<td><div align="center"><?php printf("%d",$loan->opening_borrower_no+$loan->borrower_no-$loan->fully_paid_borrower_no);?></div></td>
				<td class="align-right">
				<div align="right"><?php printf("%0.2f",$loan->closing_outstanding_amount);?></div></td></tr>
			<?php if($tmp_product ==  $loan->short_name) { ?>
			<tr>
				<th>&nbsp;
				</th><th><strong>Total</strong>
				</th><th><div align="center"><?php echo $opening_borrower_no;?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$opening_outstanding_amount);?></div></th>
				<th><div align="center"><?php echo $current_month_borrower_no;?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$loan_disbursed_amount);?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$total_loan_recovery_amount);?></div></th>
				<th class="align-center"><div align="center"><?php echo $fully_paid_borrower_no;?></div></th>
				<th><div align="center"><?php echo $end_of_month_borrower_no;?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$mend_of_month_amount);?></div></th></tr>	
				<?php }
				$tmp_product = $loan->short_name;
				 ?>
			<?php 
				$grand_total_opening_borrower_no +=$opening_borrower_no;
				$grand_total_opening_outstanding_amount +=$opening_outstanding_amount;
				$grand_total_current_month_borrower_no +=$current_month_borrower_no;	
				$grand_total_loan_disbursed_amount +=$loan_disbursed_amount;		
				$grand_total_total_loan_recovery_amount +=$total_loan_recovery_amount;		
				$grand_total_fully_paid_borrower_no +=$fully_paid_borrower_no; 		
				$grand_total_end_of_month_borrower_no +=$end_of_month_borrower_no;		
				$grand_total_end_of_month_amount +=$end_of_month_amount;
			}?>
 
			<tr>
				<th><strong>Grand Total</strong></th>
				<th>&nbsp;</th>
				<th><div align="center"><?php echo $grand_total_opening_borrower_no;?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$grand_total_opening_outstanding_amount);?></div></th>
				<th><div align="center"><?php echo $grand_total_current_month_borrower_no;?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$grand_total_loan_disbursed_amount);?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$grand_total_total_loan_recovery_amount);?></div></th>
				<th class="align-center"><div align="center"><?php echo $grand_total_fully_paid_borrower_no;?></div></th>
				<th><div align="center"><?php echo $grand_total_end_of_month_borrower_no;?></div></th>
				<th class="align-right"><div align="right"><?php printf("%0.2f",$grand_total_end_of_month_amount);?></div></th></tr>
		</table>
		<br>
		<table width="100%">
			<tr><td class="report-sub-name">2. Loan Due Statement</td></tr></table>
		<br>	
		<table width="100%" border="1" cellspacing="0">  
		<tr>
			<th colspan="2" rowspan="2"><div class="align-right"><strong>Component</strong></div></th>
			<th rowspan="2"><div align="center"><strong>Due at the end of the Last Month </strong></div></th>
			<th rowspan="2"><div align="center"><strong>Reg.Loan Recoverable ( Current Month) </strong></div></th>
			<th colspan="4"><div align="center"><strong>Current Month Recovered </strong></div></th>
			<th rowspan="2"><div align="center"><strong>New Due Amount ( Current Month) </strong></div></th>
			<th rowspan="2"><div align="center"><strong>Total Due at the end of the Month </strong></div></th></tr>
		<tr>
			<th><div align="center"><strong>Regular</strong></div></th>
			<th><div align="center"><strong>&nbsp;&nbsp;&nbsp;Due&nbsp;&nbsp;&nbsp;</strong></div></th>
			<th><div align="center"><strong>Advance</strong></div></th>
			<th><div align="center"><strong>Total</strong></div></th></tr>
		<tr>
			<th colspan="2" rowspan="2"><div class="align-right"><strong>1</strong></div></th>
			<th rowspan="2"><div align="center"><strong>2</strong></div></th>
			<th rowspan="2"><div align="center"><strong>3</strong></div></th>
			<th colspan="4"><div align="center"><strong></strong></div></th>
			<th rowspan="2"><div align="center"><strong>8=(3-4)</strong></div></th>
			<th rowspan="2"><div align="center"><strong>9=(2-5+8) </strong></div></th></tr>
		<tr>
			<th><div align="center"><strong>4</strong></div></th>
			<th><div align="center"><strong>5</strong></div></th>
			<th><div align="center"><strong>6</strong></div></th>
			<th><div align="center"><strong>7=(4+5+6)</strong></div></th></tr>
			 <?php 
					$fopening_due_amount = 0;
					$floan_recoverable_amount =0;
					$fregular_amount=0;						
					$fdue_amount = 0;						
					$fadvance_amount =0;	
					$ftotal_cur_mnth_recover = 0;
					$fnew_due_amount = 0;
					$ftotal_due_end_month = 0;	
					$f_principal_recovery_amount = 0;
					
					$mopening_due_amount = 0;
					$mloan_recoverable_amount =0;
					$mregular_amount=0;						
					$mdue_amount = 0;						
					$madvance_amount =0;	
					$mtotal_cur_mnth_recover = 0;
					$mnew_due_amount = 0;
					$mtotal_due_end_month = 0;
					$m_principal_recovery_amount = 0;
					
					$grand_total_opening_due_amount =0;
					$grand_total_loan_recoverable_amount =0;
					$grand_total_regular_amount=0;	
					$grand_total_due_amount= 0;		
					$grand_total_advance_amount=0;		
					$grand_total_total_cur_mnth_recover =0; 		
					$grand_total_new_due_amount=0;		
					$grand_total_total_due_end_month=0;	
					$grand_principal_recovery_amount = 0;		
			$tmp_product = "";
				foreach($loan_due_info as $loan_due){
					$fopening_due_amount = 0;
					$floan_recoverable_amount =0;
					$fregular_amount=0;						
					$fdue_amount = 0;						
					$fadvance_amount =0;	
					$ftotal_cur_mnth_recover = 0;
					$fnew_due_amount = 0;
					$ftotal_due_end_month = 0;	
					$f_principal_recovery_amount = 0;
					
					$mopening_due_amount = 0;
					$mloan_recoverable_amount =0;
					$mregular_amount=0;						
					$mdue_amount = 0;						
					$madvance_amount =0;	
					$mtotal_cur_mnth_recover = 0;
					$mnew_due_amount = 0;
					$mtotal_due_end_month = 0;
					$m_principal_recovery_amount = 0;
					//Female
					if($loan_due->TYPE=='F'){
							$gender = "Female";
						$fopening_due_amount = $loan_due->opening_due_amount;
						$floan_recoverable_amount = $loan_due->principal_recoverable_amount+$loan_due->interest_recoverable_amount;	
						
						$f_principal_recovery_amount = $loan_due->principal_recovery_amount;						
						$fdue_amount = $loan_due->principal_due_amount+$loan_due->interest_due_amount;						
						$fadvance_amount = $loan_due->principal_advance_amount+$loan_due->interest_advance_amount;			
						$fregular_amount=$f_principal_recovery_amount - $fdue_amount - $fadvance_amount;	
						$ftotal_cur_mnth_recover = $fregular_amount+$fdue_amount+$fadvance_amount;
						$fnew_due_amount = $floan_recoverable_amount-$fregular_amount;
						$ftotal_due_end_month = $fopening_due_amount-$fdue_amount+$fnew_due_amount;				
					}
					//Male
					if($loan_due->TYPE=='M'){
						$gender = "Male";
						$mopening_due_amount = $loan_due->opening_due_amount;
						$mloan_recoverable_amount = $loan_due->principal_recoverable_amount+$loan_due->interest_recoverable_amount;		
						$m_principal_recovery_amount = $loan_due->principal_recovery_amount;					
						$mdue_amount = $loan_due->principal_due_amount+$loan_due->interest_due_amount;						
						$madvance_amount = $loan_due->principal_advance_amount+$loan_due->interest_advance_amount;			
						$mregular_amount= $m_principal_recovery_amount - $mdue_amount - $madvance_amount;		
						$mtotal_cur_mnth_recover = $mregular_amount+$mdue_amount+$madvance_amount;
						$mnew_due_amount = $mloan_recoverable_amount-$mregular_amount;
						$mtotal_due_end_month = $mopening_due_amount-$mdue_amount+$mnew_due_amount;					
					}
				   //Total
						$opening_due_amount = $mopening_due_amount+$fopening_due_amount;
						$loan_recoverable_amount = $mloan_recoverable_amount+$floan_recoverable_amount;		
						//$principal_recovery_amount = $m_principal_recovery_amount+$f_principal_recovery_amount;			
						$regular_amount=$mregular_amount+$fregular_amount;							
						$due_amount = $mdue_amount+$fdue_amount;				
						$advance_amount = $madvance_amount+$fadvance_amount;	
						$total_cur_mnth_recover = $mtotal_cur_mnth_recover+$ftotal_cur_mnth_recover;	
						$new_due_amount = $mnew_due_amount+$fnew_due_amount;	
						$total_due_end_month = $mtotal_due_end_month+$ftotal_due_end_month; ?>
			<tr>									  
				<td><?php echo ($tmp_product ==  $loan_due->short_name)? "":$loan_due->short_name;?></td>
				<td><?php echo $gender ?></td>  
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$loan_due->opening_due_amount);?></div></td>
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$loan_due->principal_recoverable_amount+$loan_due->interest_recoverable_amount);?></div></td>	   
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$fregular_amount);?></div></td>
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$fdue_amount);?></div></td>
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$fadvance_amount);?></div></td>
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$ftotal_cur_mnth_recover);?></div></td>
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$fnew_due_amount);?></div></td>
				<td class="align-right"><div align="right"><?php  printf("%0.2f",$ftotal_due_end_month);?></div></td></tr>
			<?php if($tmp_product ==  $loan_due->short_name) { ?>
			<tr>
				<th>&nbsp;</th>
				<th>Total</th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$opening_due_amount);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$loan_recoverable_amount);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$regular_amount);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$due_amount);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$advance_amount);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$total_cur_mnth_recover);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$new_due_amount);?></div></th>
				<th class="align-right"><div align="right"><?php  printf("%0.2f",$total_due_end_month);?></div></th></tr>
			<?php 
		}
		///echo " $grand_total_loan_recoverable_amount +=$loan_recoverable_amount<br>";
					$grand_total_opening_due_amount +=$opening_due_amount;
					$grand_total_loan_recoverable_amount +=$loan_recoverable_amount;
					$grand_total_regular_amount +=$regular_amount;	
					$grand_total_due_amount +=$due_amount ;		
					$grand_total_advance_amount +=$advance_amount;		
					$grand_total_total_cur_mnth_recover +=$total_cur_mnth_recover; 		
					$grand_total_new_due_amount +=$new_due_amount;		
					$grand_total_total_due_end_month +=$total_due_end_month;
					$tmp_product = $loan_due->short_name;
				}
			?>	
		<tr>
			<th>Grand Total</th>
			<th>&nbsp;</th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_opening_due_amount);?></div></th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_loan_recoverable_amount);?></div></th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_regular_amount);?></div></th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_due_amount);?></div></th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_advance_amount);?></div></th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_total_cur_mnth_recover);?></div></th>
			<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_new_due_amount);?></div></th>
		<th class="align-right"><div align="right"><?php  printf("%0.2f",$grand_total_total_due_end_month);?></div></th></tr>
	</table>
	<br><br><br>
	<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div>
</div>
