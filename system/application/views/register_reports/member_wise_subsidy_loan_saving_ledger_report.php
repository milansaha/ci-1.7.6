<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
<table class="report-header" border="0">
		<tbody>
		<tr>
			<th colspan="0" width="15%"><div align="left">Branch Name &amp; Code </div></th>
			<td colspan="2"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['branch_name']))?$get_samity_branch_loan_init_info['branch_name']:'';?><?php echo (isset($get_samity_branch_loan_init_info['branch_code']))?'&nbsp;&nbsp;(&nbsp;'.$get_samity_branch_loan_init_info['branch_code'].'&nbsp;)':'';?></div></td>
		</tr>
		<tr>
			<th colspan="0" width="15%"><div align="left">Name of Samity &amp; Code</div></th>
			<td width="53%"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['samity_name']))?$get_samity_branch_loan_init_info['samity_name']:'';?><?php echo (isset($get_samity_branch_loan_init_info['samity_code']))?'&nbsp;&nbsp;(&nbsp;'.$get_samity_branch_loan_init_info['samity_code'].'&nbsp;)':'';?></div></td>
		</tr>
		<tr>
			<th colspan="0"><div align="left">Name of Member </div></th>
			<td><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['member_name']))?$get_samity_branch_loan_init_info['member_name']:'';?><?php echo (isset($get_samity_branch_loan_init_info['member_code']))?'&nbsp;&nbsp;(&nbsp;'.$get_samity_branch_loan_init_info['member_code'].'&nbsp;)':'';?>&nbsp;</div></td>
		</tr>	
		<tr>
			<th><div align="left">Father or Husband Name </div></th>
			<td><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['member_fathers_spouse_name']))?$get_samity_branch_loan_init_info['member_fathers_spouse_name']:'';?></div></td>
		</tr>  
		<tr>
			<th colspan="0" width="15%"><div align="left">Address </div></th>
			<td width="53%"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['member_fathers_spouse_name']))?$get_samity_branch_loan_init_info['member_fathers_spouse_name']:'';?></div></td>
			<th width="16%"><div align="left">Print Date </div></th>
			<td width="16%"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo date("d-m-Y");?></div></td>
		</tr>
	</tbody>
</table>
<table class="report-header" width="100%" border="0">
  <tbody>
  <tr>
    <th colspan="0" width="15%"><div align="left">Loan Component </div></th>
    <td width="16%"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_product_name']))?$get_samity_branch_loan_init_info['loan_product_name']:'';?></div></td>
    <th colspan="0" width="16%"><div align="left">Loan Purpose </div></th>
    <td colspan="2"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_purposes_name']))?$get_samity_branch_loan_init_info['loan_purposes_name']:'';?></div></td>
    <th colspan="0" width="16%"><div align="left">Dafa No. </div></th>
    <td width="16%"><div align="left"><b>:</b>&nbsp;&nbsp;11</div></td>
  </tr>
  <tr>
    <th colspan="0" width="15%"><div align="left">Loan Amount </div></th>
    <td><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_amount']))?$get_samity_branch_loan_init_info['loan_amount']:'';?></div></td>
    <th colspan="0" width="16%"><div align="left">Service Charge </div></th>
    <td colspan="2"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_interest_rate']))?$get_samity_branch_loan_init_info['loan_interest_rate']:'';?>%</div></td>
    <th colspan="0" width="16%"><div align="left">Disbursement Date </div></th>
	<td width="16%"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_disburse_date']))?$get_samity_branch_loan_init_info['loan_disburse_date']:'';?></div></td>
  </tr>
  <tr>
    <th colspan="0" width="15%"><div align="left">Installment Amount </div></th>
    <td><div align="left">
      <b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_installment_amount']))?$get_samity_branch_loan_init_info['loan_installment_amount']:'';?></div></td>
    <th colspan="0" width="16%"><div align="left">No. of Loan Installment  </div></th>
    <td colspan="2"><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['number_of_loan_installment']))?$get_samity_branch_loan_init_info['number_of_loan_installment']:'';?></div></td>
    <th colspan="0" width="16%"><div align="left">1st Installment Date  </div></th>
	    <td><div align="left"><b>:</b>&nbsp;&nbsp;<?php echo (isset($get_samity_branch_loan_init_info['loan_first_repayment_date']))?$get_samity_branch_loan_init_info['loan_first_repayment_date']:'';?></div></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
</tbody>
</table>
<?php //echo $cbo_month;?>
<?php //echo $cbo_year;echo '<br/>';?>
<?php
$holiday_array = array();
$monthday_array = array();
$working_day = array();
$counter = 0;
$workdays = array();
$count = 0;
$inc = 0;
for($i=1;$i<=30;$i++)
{
	$day = $cbo_year.'-'.$cbo_month.'-'.$i;
	$day_date = date("D",strtotime($day));
	
	if($day_date != 'Fri')
	{
		$monthday_array[$i] = date("j",strtotime($day));
	}
	elseif($day_date == 'Fri')
	{
		array_push($holiday_array,date("j",strtotime($day)));
		$monthday_array[$i] = 'Fri';
		if($counter == 0 )
		{
			$working_day[$i]['start'] = $counter + 1;
		}
		elseif($counter > 0 )
		{
			$working_day[$i]['start'] = $holiday_array[$counter]+1;
			$counter++;
		}
		$working_day[$i]['end'] = date("j",strtotime($day))-1;
	}
}

for($k=1;$k<=count($monthday_array);$k++)
{
	if($monthday_array[$k] != 'Fri')
	{
		if(strlen($monthday_array[$k]) == 1){		
			$dates = '0'.$monthday_array[$k];
		}else{
			$dates = $monthday_array[$k];
		}
		$workdays[$count][$inc] = $cbo_year.'-'.$cbo_month.'-'.$dates;
	}
	elseif($monthday_array[$k] == 'Fri')
	{
		$count++;
		$inc = -1;
	}
	$inc++;
}

$samity_day = (isset($get_samity_branch_loan_init_info['samity_day']))?$get_samity_branch_loan_init_info['samity_day']:'0.00';
$first_repay_week_date = (isset($get_samity_branch_loan_init_info['loan_first_repayment_date']))?$get_samity_branch_loan_init_info['loan_first_repayment_date']:'0.00';
$repayment_frequency = (isset($get_samity_branch_loan_init_info['repayment_frequency']))?$get_samity_branch_loan_init_info['repayment_frequency']:'0.00';
$installment_amount = (isset($get_samity_branch_loan_init_info['installment_amount']))?(int)($get_samity_branch_loan_init_info['installment_amount']):'0.00';
//echo '<h1>'.$first_repay_week_date.$repayment_frequency.$installment_amount.'</h1>';
$total_savings_amount = 0.00;
$total_loan_overdue_amount = 0.00;
$total_loan_advance_amount = 0.00;
//echo '<pre>';
//echo '<h3>Work Days</h3>';
//print_r($workdays);
//echo '<h3>Loan Transaction</h3>';
//print_r($get_loan_transaction_info);
//echo '<h3>Savings Transaction</h3>';
//print_r($get_savings_transaction_info);
//echo count($workdays);
?>
<table class="report-body" width="100%" border="1" bordercolor="#000000" cellpadding="0" cellspacing="0">
   <tbody>
	   <tr>
		<th rowspan="2" width="8%">Date</th>
		<th rowspan="2" width="2%">Week No</th>
		<th colspan="8">Loan</th>
		<th colspan="4">Savings</th>
		<th colspan="3">Insurance</th>
		<th width="30%">Signature</th>
	  </tr>
	  <tr>
		<th width="4%">Repay Week No.</th>
		<th width="4%">Current <br/>Repay Week <br/>No.</th>
		<th width="8%">Loan <br/>Recoverable <br/>(Incl. O/D)</th>
		<th width="6%">Actual <br/>Recovery</th>
		<th width="6%">Cum.Loan <br/>Recovery</th>
		<th width="6%">Loan <br/>Outstanding <br/>(Pr.+Sc)</th>
		<th width="5%">Loan Overdue</th>
		<th width="5%">Loan Advance</th>
		<th width="6%">Collection</th>
		<th width="5%">Refund</th>
		<th width="5%">Interest</th>
		<th width="5%">Balance</th>
		<th width="6%">Collection</th>
		<th width="5%">Refund</th>
		<th width="5%">Balance</th>
		<th>(FW)</th>
	  </tr>
	  <tr>
		<th align="center">1</th>
		<th align="center">2</th>
		<th align="center">3</th>
		<th align="center">4</th>
		<th align="center">5</th>
		<th align="center">6</th>
		<th align="center">7</th>
		<th align="center">8</th>
		<th align="center">9</th>
		<th align="center">10</th>
		<th align="center">11</th>
		<th align="center">12</th>
		<th align="center">13</th>
		<th align="center">14</th>
		<th align="center">15</th>
		<th align="center">16</th>
		<th align="center">17</th>
		<th align="center">18</th>
	  </tr>
	<?php
		$saving_storage = array();
		$total_installment_paid_amount = 0.00;
		//echo '<pre>';print_r($get_loan_schedule_info);
		for($a=0;$a<count($workdays);$a++)
		{
			$holidayStatus = 0;
	?>
	<?php 
			$lastDayAsHoliday = array();
			$lastindex = count($workdays[$a]); 
			$lastDayOfWeek = $workdays[$a][$lastindex-1];
			foreach($get_holiday_info as $holi)
			{
				if($lastDayOfWeek == $holi['holiday_date'])
				{
					//echo $lastDayOfWeek . '===>' .$holi['holiday_date'];echo '<br/>';
					array_push($lastDayAsHoliday,$holi['holiday_date']);
					$holidayStatus = 1;
				}else{
					$holidayStatus = 0;
				}
			}//echo '<pre>';
			//print_r($lastDayAsHoliday);
			//print_r($holi);
		?>
		<tr>
			<td><?php echo $workdays[$a]['0'];?> to <?php $lastindex = count($workdays[$a]); echo $workdays[$a][$lastindex-1];?></td>
			<td><?php echo ($a+1); ?></td>
			<td>
				<?php
					echo $a;
					//print_r($get_loan_schedule_info);
					if(in_array($a, $get_loan_schedule_info,true)) 
					{
						echo (iiset($get_loan_schedule_info['0'][$a]['installment_number']))?$get_loan_schedule_info['0'][$a]['installment_number']:''; 
					}else{ echo '&nbsp;';}
				?>
			<?php /*echo $lastDayOfWeek;echo '<br/>';
				//echo $get_holiday_info[$a]['holiday_date'];
				foreach($get_holiday_info as $holi)
				{
					if($lastDayOfWeek == $holi['holiday_date'])
					{
						echo $lastDayOfWeek . '===>' .$holi['holiday_date'];echo '<br/>';
						$holidayStatus = 1;
					}
				}
			//echo $holidayStatus; */?></td>
			<?php
			//$total_installment_paid_amount = 0.00;
			for($b=0;$b<count($workdays[$a]);$b++)
			{	
				if (array_key_exists($a, $get_loan_transaction_info)) 
				{ 
					if($get_loan_transaction_info[$a]['transaction_date'] == $workdays[$a][$b])
					{
						?>
						 <td><?php if(array_key_exists($a, $get_loan_transaction_info)) { echo $get_loan_transaction_info[$a]['installment_number']; }else{ echo '&nbsp;';} ?></td>
						 <td><?php if(array_key_exists($a, $get_loan_transaction_info)) { echo number_format($get_samity_branch_loan_init_info['installment_amount'], 2, '.', ','); }else{ echo '&nbsp;';} ?></td> 
						 <td><?php if($holidayStatus == 1){ echo '0.00';}else{if(array_key_exists($a, $get_loan_transaction_info)) { echo number_format($get_loan_transaction_info[$a]['transaction_amount'], 2, '.', ','); } }?></td>
						 <td><?php if(array_key_exists($a, $get_loan_transaction_info)) { echo number_format($get_loan_transaction_info[$a]['current_total_collection_amount'], 2, '.', ','); } ?></td>
						 <td><?php if(array_key_exists($a, $get_loan_transaction_info)) { echo number_format($get_loan_transaction_info[$a]['current_outstanding_amount'], 2, '.', ','); } ?></td>
						 <td><?php 
							if(array_key_exists($a, $get_loan_transaction_info)) 
							{ 
								// total no of given installment	
								$installment_number = $get_loan_transaction_info[$a]['installment_number'];
								//echo $installment_number;echo '<br/>';
								// given installed amount
								$transaction_amount = (int)($get_loan_transaction_info[$a]['transaction_amount']);
								//echo $transaction_amount;echo $installment_amount;echo '<br/>';
								//current Total Collection Amount static
								$current_total_collection_amount = $get_loan_transaction_info[$a]['current_total_collection_amount'];
								// check if total given installemt amount is equal to total_have_to_be_given_installed_amount
								if($transaction_amount < $installment_amount)
								{
									$total_installment_paid_amount = ($installment_amount * $installment_number)-($installment_amount - $transaction_amount);
									$total_installment_advanced_paid_amount = 0.00;
								}elseif($transaction_amount == $installment_amount){
									$total_installment_paid_amount = $transaction_amount * $installment_number ;
									$total_installment_advanced_paid_amount = 0.00;
								}elseif($transaction_amount > $installment_amount){
									$total_installment_advanced_paid_amount = (($installment_amount * ($installment_number-1)) + $transaction_amount) - $current_total_collection_amount ;
								}else{
									$total_installment_paid_amount = 0.00;
									$total_installment_advanced_paid_amount = 0.00;
								}
								$loan_overdue_amount = $get_loan_transaction_info[$a]['current_total_collection_amount'] - $total_installment_paid_amount;
								$loan_current_transaction_date = strtotime($get_loan_transaction_info[$a]['transaction_date']);
								$loan_payment_last_date = strtotime($get_samity_branch_loan_init_info['last_repayment_date']);
								if($loan_current_transaction_date >  $loan_payment_last_date){
									echo number_format($loan_overdue_amount, 2, '.', ',');
								}else{
									echo '0.00';
								}
							} 
							?>
							</td>
							<td>
								<?php 
									if(isset($total_installment_advanced_paid_amount) && !empty($total_installment_advanced_paid_amount))
									{ 
										echo number_format($total_installment_advanced_paid_amount, 2, '.', ','); 
									}else{ 
										echo '0.00';$total_installment_advanced_paid_amount=0.00;
									}
								?>
							</td>
						<?php
						}
					}
					// for savings deposit transaction
					if (array_key_exists($a, $get_savings_transaction_info)) 
					{ 
						if($get_savings_transaction_info[$a]['transaction_date'] == $workdays[$a][$b])
						{
							?>
							 <td><?php if (array_key_exists($a, $get_savings_transaction_info)) { echo number_format($get_savings_transaction_info[$a]['amount'], 2, '.', ','); $total_savings_amount = $total_savings_amount + $get_savings_transaction_info[$a]['amount'];} ?></td>
							 <td><?php echo number_format('0.00', 2, '.', ','); ?></td>
							 <td><?php echo number_format('0.00', 2, '.', ','); ?></td>
							 <td><?php echo number_format($total_savings_amount, 2, '.', ','); ?></td>
							<?php
						}
					}			
				}
				?>
		 <td>&nbsp;</td>
		 <td>&nbsp;</td>
		 <td>&nbsp;</td>
		 <td>&nbsp;</td>
	  </tr>
		<?php 
			} //end of for loop --- for loan transaction
		?>
</tbody>
</table><br><br><br>
<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
