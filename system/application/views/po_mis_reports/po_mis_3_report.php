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
			<tr>
				<td class="report-sub-name">01. Loan Overdue Classification</td></tr></table>

		<table width="100%" border="1" cellspacing="0"> 
			<tr>
				<td rowspan="2" width="97"><b></b><center><b>Component</b></center></td>
				<td rowspan="2" width="114"><b></b><center><b>Total Loan Outstanding</b></center></td>
				<td colspan="2"><b></b><center><b>Substandard(1-180 Days)</b></center></td>
				<td colspan="2"><b></b><center><b>Doubtful(181-365)</b></center></td>
				<td colspan="2"><b></b><center><b>Bad Loan(365+ )</b></center></td>
				<td rowspan="2"><b></b><center><b>No of Due Loanee</b></center></td>
				<td rowspan="2"><b></b><center><b>Total Outstanding of Overdue Loanee</b></center></td>
				<td rowspan="2" width="66"><b></b><center><b>Total Overdue</b></center></td>
				<td rowspan="2" width="129"><b></b><center><b>Good Loan Outstanding</b></center></td>
				<td rowspan="2" width="159"><b></b><center><b>Saving Balance Of Overdue Loanee</b></center></td></tr>

			<tr>
				<td width="98"><b></b><center><b>Loan Outstanding</b></center></td>
				<td width="62"><b></b><center><b>Overdue</b></center></td>
				<td width="98"><b></b><center><b>Loan Outstanding</b></center></td>
				<td width="62"><b></b><center><b>Overdue</b></center></td>
				<td width="93"><b><b>Loan Outstanding</b></b></td>
				<td width="62"><b></b><center><b>Overdue</b></center></td></tr>
			<?php	  
				$opening_outstanding_amount = 0;
				$substandard_outstanding = 0;
				$substandard_overdue = 0;
				$doubtfull_outstanding = 0;	
				$doubtfull_overdue = 0;
				$substandard_overdue = 0;
				$bad_outstanding = 0;
				$bad_overdue= 0;
				$no_of_due_loanee = 0;	
				$saving_balance_of_overdue_loanee = 0;
				
				$pksf_total_opening_outstanding_amount =0;
				$pksf_total_substandard_outstanding =0;
				$pksf_total_substandard_overdue = 0;
				$pksf_total_doubtfull_outstanding =0;
				$pksf_total_doubtfull_overdue =0;
				$pksf_total_bad_outstanding =0;
				$pksf_total_bad_overdue =0;
				$pksf_total_no_of_due_loanee =0;
				$pksf_total_saving_balance_of_overdue_loanee = 0;		

				$non_pksf_total_opening_outstanding_amount = 0;
				$non_pksf_total_substandard_outstanding = 0;
				$non_pksf_total_substandard_overdue = 0;
				$non_pksf_total_doubtfull_outstanding =0;
				$non_pksf_total_doubtfull_overdue =0;
				$non_pksf_total_bad_outstanding =0;
				$non_pksf_total_bad_overdue =0;
				$non_pksf_total_no_of_due_loanee =0;
				$non_pksf_total_saving_balance_of_overdue_loanee = 0;	
				
				$grand_total_opening_outstanding_amount =0;
				$grand_total_substandard_outstanding = 0;
				$grand_total_substandard_overdue = 0;
				$grand_total_doubtfull_outstanding =0;	
				$grand_total_doubtfull_overdue = 0;
				$grand_total_bad_outstanding = 0;
				$grand_total_bad_overdue =0;
				$grand_total_no_of_due_loanee = 0;
				$grand_total_saving_balance_of_overdue_loanee = 0;		
	
				foreach($loan_info as $loan){
					$opening_outstanding_amount = $loan->opening_outstanding_amount;
					$substandard_outstanding = $loan->substandard_outstanding;
					$substandard_overdue = $loan->substandard_overdue;
					$doubtfull_outstanding =$loan->doubtfull_outstanding;
					$doubtfull_overdue =$loan->doubtfull_overdue;
					$bad_outstanding =$loan->bad_outstanding;
					$bad_overdue =$loan->bad_overdue;
					$no_of_due_loanee =$loan->no_of_due_loanee;
					$saving_balance_of_overdue_loanee = $loan->no_of_due_loanee;
		
					if($loan->fundname=='PKSF'){			
						$pksf_total_opening_outstanding_amount += $loan->opening_outstanding_amount;
						$pksf_total_substandard_outstanding += $loan->substandard_outstanding;
						$pksf_total_substandard_overdue += $loan->substandard_overdue;
						$pksf_total_doubtfull_outstanding +=$loan->doubtfull_outstanding;
						$pksf_total_doubtfull_overdue +=$loan->doubtfull_overdue;
						$pksf_total_bad_outstanding +=$loan->bad_outstanding;
						$pksf_total_bad_overdue +=$loan->bad_overdue;
						$pksf_total_no_of_due_loanee +=$loan->no_of_due_loanee;
						$pksf_total_saving_balance_of_overdue_loanee += $loan->no_of_due_loanee;		
					}elseif($loan->fundname=='NonPKSF'){
						$non_pksf_total_opening_outstanding_amount += $loan->opening_outstanding_amount;
						$non_pksf_total_substandard_outstanding += $loan->substandard_outstanding;
						$non_pksf_total_substandard_overdue += $loan->substandard_overdue;
						$non_pksf_total_doubtfull_outstanding +=$loan->doubtfull_outstanding;
						$non_pksf_total_doubtfull_overdue +=$loan->doubtfull_overdue;
						$non_pksf_total_bad_outstanding +=$loan->bad_outstanding;
						$non_pksf_total_bad_overdue +=$loan->bad_overdue;
						$non_pksf_total_no_of_due_loanee +=$loan->no_of_due_loanee;
						$non_pksf_total_saving_balance_of_overdue_loanee += $loan->no_of_due_loanee;	
					}?>  
			<tr>
				<td><?PHP echo $loan->short_name?></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$opening_outstanding_amount)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$substandard_outstanding)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$substandard_overdue)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$doubtfull_outstanding)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$doubtfull_overdue)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$bad_outstanding)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$bad_overdue)?></div></td>
				<td class="align-center" align="center"><?PHP echo $no_of_due_loanee?></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$substandard_outstanding+$doubtfull_outstanding+$bad_outstanding)?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$substandard_overdue+$doubtfull_overdue+$bad_overdue) ?></div></td>
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$opening_outstanding_amount - ($substandard_outstanding+$doubtfull_outstanding+$bad_outstanding)) ?></div></td>			
				<td class="align-right" align="right"><div align="right"><?php printf("%0.2f",$saving_balance_of_overdue_loanee)?></div></td></tr>
					   
				<?php 
					$grand_total_opening_outstanding_amount +=$opening_outstanding_amount;
					$grand_total_substandard_outstanding +=$substandard_outstanding;
					$grand_total_substandard_overdue  +=$substandard_overdue;
					$grand_total_doubtfull_outstanding  +=$doubtfull_outstanding;
					$grand_total_doubtfull_overdue  +=$doubtfull_overdue;
					$grand_total_bad_outstanding  +=$bad_outstanding;	
					$grand_total_bad_overdue  +=$bad_overdue;		
					$grand_total_no_of_due_loanee +=$no_of_due_loanee;
					$grand_total_saving_balance_of_overdue_loanee += $saving_balance_of_overdue_loanee;	
			}?>		
	
		<tr>
			<td><b></b><center><b>PKSF:Total</b></center></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_opening_outstanding_amount)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_substandard_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_substandard_overdue)?> </td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_doubtfull_outstanding)?> </td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_doubtfull_overdue)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_bad_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$pksf_total_bad_overdue)?></td>
			<td class="align-center" align="center"><?PHP echo $pksf_total_no_of_due_loanee?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$pksf_total_substandard_outstanding+$pksf_total_doubtfull_outstanding+$pksf_total_bad_outstanding) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$pksf_total_substandard_overdue+$pksf_total_doubtfull_overdue+$pksf_total_bad_overdue) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$pksf_total_opening_outstanding_amount- ($pksf_total_substandard_outstanding+$pksf_total_doubtfull_outstanding+$pksf_total_bad_outstanding)) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$pksf_total_saving_balance_of_overdue_loanee)?></td></tr>
		<tr>
			<td colspan="13" align="left">
			<b>NON PKSF :</b></td></tr>
		<tr>
			<td><center><b>Non PKSF:Total</b></center></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_opening_outstanding_amount)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_substandard_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_substandard_overdue)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_doubtfull_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_doubtfull_overdue)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_bad_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$non_pksf_total_bad_overdue)?></td>
			<td class="align-center" align="center"><?PHP echo $non_pksf_total_no_of_due_loanee?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$non_pksf_total_substandard_outstanding+$non_pksf_total_doubtfull_outstanding+$non_pksf_total_bad_outstanding) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$non_pksf_total_substandard_overdue+$non_pksf_total_doubtfull_overdue+$non_pksf_total_bad_overdue) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$non_pksf_total_opening_outstanding_amount- ($non_pksf_total_substandard_outstanding+$non_pksf_total_doubtfull_outstanding+$non_pksf_total_bad_outstanding)) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$non_pksf_total_saving_balance_of_overdue_loanee)?></td></tr>
		<tr>
			<td><center><b>Grand Total</b></center></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_opening_outstanding_amount)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_substandard_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_substandard_overdue)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_doubtfull_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_doubtfull_overdue)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_bad_outstanding)?></td>
			<td class="align-right" align="right"><?PHP printf("%0.2f",$grand_total_bad_overdue)?></td>
			<td class="align-center" align="center"><?PHP echo $grand_total_no_of_due_loanee?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$grand_total_substandard_outstanding+$grand_total_doubtfull_outstanding+$grand_total_bad_outstanding) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$grand_total_substandard_overdue+$grand_total_doubtfull_overdue+$grand_total_bad_overdue) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$grand_total_opening_outstanding_amount- ($grand_total_substandard_outstanding+$grand_total_doubtfull_outstanding+$grand_total_bad_outstanding)) ?></td>
			<td class="align-right" align="right"><?php printf("%0.2f",$grand_total_saving_balance_of_overdue_loanee)?></td></tr>
	</table>
	<p>02. Statement on Staff</p>	
	<br>
	<?php 
	$staffs = $staff_info['staffs'];
	$products = array_keys($staff_info['staffs']);
	$designations = $staff_info['designations'];
	$total_designation_employees = $staff_info['total_designation_employees'];
		//print_r($products);
		//print_r($staff_info);
	?>
	<table width="100%" border="1" cellspacing="0"> 
  		<tr>
			<th rowspan="2" width="70">SL. No.</th>  
			<th rowspan="2" width="125">Name of Component </th>
			<th colspan="<?php echo count($designations) ?>">Branch</th>
			<th rowspan="2" width="91"> Total </th> 
			<th rowspan="2" width="91"> Head Office </th>  
			<th rowspan="2" width="98"> Total Staff </th></tr>  
		<tr>
		  	<?php 
		  
		  	
		  	if(!empty($designations)){ foreach ($designations as $row){?>
				<th width="94"><?php echo  $row['short_name']?></th>
			<?php }}?></tr> 
		<?php 
		$total_emp = 0;
		if(!empty($staffs)): $i=0;foreach ($staffs as $row):
		//print_r( $row);
		$total_emp = 0;
		?>
		<tr>
			<td><strong><div align="center"><?php echo $i++;?></div></strong></td>
			<td><strong><div align="center"><?php echo $row['short_name']?></div></strong></td>
		<?php	foreach ($designations as $designation){ 
			$total_emp += isset($row["{$designation['short_name']}"])?$row["{$designation['short_name']}"]:0;
			 ?> <td><strong><div align="center"><?php  echo isset($row["{$designation['short_name']}"])?$row["{$designation['short_name']}"]:0; ?></div></strong></td> <?php } ?>
		<td><strong><div align="center"><?php echo $total_emp;?></div></strong></td>
		<td><strong><div align="center"></div></strong></td>
		<td><strong><div align="center"><?php echo $total_emp;?></div></strong></td>
		</tr>
		<?php endforeach;endif;?>		
		<tr>
			<th>Total</th>
			<th><strong><div align="center"><?php echo count($staffs) ?></div></strong></th>
		<?php	
		$grand_total_emp = 0;
		if(!empty($designations)) { foreach ($designations as $row) {
			$grand_total_emp += $total_designation_employees["{$row['short_name']}"];
			 ?>
				<th width="94"><?php echo  $total_designation_employees["{$row['short_name']}"] ?></th>
				<?php }} ?>
				<th><strong><div align="center"><?php echo $grand_total_emp;?></div></strong></th>
				<th><strong><div align="center"></div></strong></th>
				<th><strong><div align="center"><?php echo $grand_total_emp;?></div></strong></th>
				</tr>		
	</table>
	<p>03. Statement on Working Area</p>	
	<table width="100%" border="1" cellspacing="0"> 
	  	<tr>
			<th><div align="center"><strong>SL. No. </strong></div></th>
			<th><div align="center"><strong>Component</strong></div></th>
			<th><div align="center"><strong>No. of Branch</strong></div></th>
			<th><div align="center"><strong>Name of District</strong></div></th>
			<th><div align="center"><strong>Name of Thana/Upazilla</strong></div></th>
			<th><div align="center"><strong>No. of Union/Pouroshava</strong></div></th>
			<th><div align="center"><strong>No. of Village/Wards</strong></div></th></tr> 
		<?php 	if(!empty($statement_of_workingarea)):	
				$i=0;			
				foreach ($statement_of_workingarea as $row):
				$total_product=$row['total_ptoduct'];
				$i++;?>
		<tr>
			<td><strong><div align="center"><?php echo $i;?></div></strong></td>
			<td><strong><div align="center"><?php echo $row['product_mnemonic'];?></div></strong></td> 
			<td><div align="center"><strong><?php echo $row['branch'];?></strong></div></td> 
			<td><strong><div align="center"><?php echo $row['district_name'];?></div></strong></td>
			<td><div align="center"><strong><?php echo $row['thana_name'];?></strong></div></td>
			<td><div align="center"><strong><?php echo $row['union_no'];?></strong></div></td> 
			<td><div align="center"><strong><?php echo $row['village_no'];?></strong></div></td></tr>	
		<?php endforeach; if(!empty($statement_of_total_workingarea)):?>
		<tr>
			<th><div align="center"><strong>Total</strong></div></th>
			<th><div align="center"><strong><?php echo $total_product;?></div></strong></strong></div></th>
			<th><div align="center"><strong><?php echo '1';?></div></strong></strong></div></th>
			<th><div align="center"><strong><?php echo $statement_of_total_workingarea['total_district'];?></div></strong></strong></div></th>
			<th><div align="center"><strong><?php echo $statement_of_total_workingarea['total_thana'];?></div></strong></strong></div></th>
			<th><div align="center"><strong><?php echo $statement_of_total_workingarea['total_union'];?></div></strong></strong></div></th>
			<th><div align="center"><strong><?php echo $statement_of_total_workingarea['total_village'];?></div></strong> </strong></div></th></tr>
		<?php endif; endif;?>	
	</table>
	<br><br><br>
	<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
	
