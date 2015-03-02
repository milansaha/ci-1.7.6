<?php //print_r($loan); ?>
<fieldset>
	<!--<div id="execute_div">
		<div id="execute_link">
			<?php echo anchor('loans/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan')).'Add Loan',array('class'=>'','title'=>'Add Loan'));  ?>
		</div>
		<div id="execute_link">
			<?php 
			echo anchor('loan_schedules/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan Shedules')).'Add Loan Shedule',array('class'=>'','title'=>'Add Loan Shedule'));  ?>
		</div>
	</div>-->
	<table class="uiInfoTableConfig" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr>
				<th>
					<img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;Loan Details
				</th>
				<th style="padding:0;margin:0;" align="right" valign="top">
					<div style="float:right;width:145px;border:solid 0px red;">
						<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Back to list page','class'=>'back_button','onclick'=>"window.location.href='".site_url('loans')."'"));?>
					</div>
				</th>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Loan ID:</td>
				<td class="field-items"><?php echo $loan->customized_loan_no?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Member Name:</td>
				<td class="field-items"><?php echo $loan->member_name?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Member Code:</td>
				<td class="field-items"><?php echo $loan->member_code?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Loan Amount:</td>
				<td class="field-items"><?php echo $loan->loan_amount?(number_format($loan->loan_amount,2,'.',',')):''?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Disbursement Date:</td>
				<td class="field-items"><?php echo isset($loan->disburse_date)?(date("F d,Y l",strtotime($loan->disburse_date))):''?></td>
			</tr>  
			<tr>
				<td width="40%" align="left" class="field-label">Product:</td>
				<td class="field-items"><?php echo (isset($loan->product_short_name)?$loan->product_short_name:'').''.(isset($loan->funding_organization_name)? '-'.$loan->funding_organization_name:'')?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Loan Application No:</td>
				<td class="field-items"><?php echo isset($loan->loan_application_no)?$loan->loan_application_no:''?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">First Repay Date:</td>
				<td class="field-items"><?php echo isset($loan->first_repayment_date)?(date("F d,Y l",strtotime($loan->first_repayment_date))):''?></td>
			</tr>   
			<tr>
				<td width="40%" align="left" class="field-label">Interest Calculation Method:</td>
				<td class="field-items"><?php echo $loan->interest_calculation_method?$loan->interest_calculation_method:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Interest Rate:</td>
				<td class="field-items"><?php echo $loan->interest_rate?(number_format($loan->interest_rate,2,'.',',')):''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Number of Installment:</td>
				<td class="field-items"><?php echo $loan->number_of_installment?$loan->number_of_installment:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Repayment Frequency:</td>
				<td class="field-items"><?php echo $loan->repayment_frequency?$loan->repayment_frequency:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Mode of interest:</td>
				<td class="field-items"><?php echo isset($loan->mode_of_interest)?$loan->mode_of_interest:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Loan Period in Month:</td>
				<td class="field-items"><?php echo isset($loan->loan_period_in_month)?$loan->loan_period_in_month:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Loan Purpose:</td>
				<td class="field-items"><?php echo isset($loan->purpose_name)?$loan->purpose_name:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Insurance Amount:</td>
				<td class="field-items"><?php echo isset($loan->insurance_amount)?(number_format($loan->insurance_amount,2,'.',',')):'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Loan Cycle:</td>
				<td class="field-items"><?php echo isset($loan->cycle)?$loan->cycle:'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Interest Discount Amount:</td>
				<td class="field-items"><?php echo isset($loan->discount_interest_amount)?(number_format($loan->discount_interest_amount,2,'.',',')):'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Total Repay Amount:</td>
				<td class="field-items"><?php echo isset($loan->total_payable_amount)?(number_format($loan->total_payable_amount,2,'.',',')):'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Interest Amount:</td>
				<td class="field-items"><?php echo isset($loan->interest_amount)?(number_format($loan->interest_amount,2,'.',',')):'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Installment Amount:</td>
				<td class="field-items"><?php echo isset($loan->installment_amount)?(number_format($loan->installment_amount,2,'.',',')):'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Guarantor's Name:</td>
				<td class="field-items"><?php echo isset($loan->guarantor_name_1)?$loan->guarantor_name_1:'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Guarantor's Relationship:</td>
				<td class="field-items"><?php echo isset($loan->guarantor_relationship_1)?$loan->guarantor_relationship_1:'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Guarantor's Address:</td>
				<td class="field-items"><?php echo isset($loan->guarantor_address_1)?$loan->guarantor_address_1:'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Guarantor's Name:</td>
				<td class="field-items"><?php echo isset($loan->guarantor_name_2)?$loan->guarantor_name_2:'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Guarantor's Relationship:</td>
				<td class="field-items"><?php echo isset($loan->guarantor_relationship_2)?$loan->guarantor_relationship_2:'-'?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Guarantor's Address:</td>
				<td class="field-items"><?php echo isset($loan->guarantor_address_2)?$loan->guarantor_address_2:'-'?></td>
			</tr> 
		</tbody>
	</table>
<br/>
	<table class="uiInfoTableConfig" border="0" cellspacing="1px" cellpadding="0px">
		<tbody>
			<tr>
				<th align="left" colspan="6" class="field-header">
					<img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;Loan Schedule
				</th>
			</tr>
			<tr>
				<th class="field-title" width="8%">#</th>
				<th class="field-title" width="15%">Date</th>
				<th class="field-title" width="15%">Installment Amount</th>
				<th class="field-title" width="15%">Principal Amount (P)</th>
				<th class="field-title" width="15%">Interest Amount (I)</th>
				<th class="field-title" width="15%">Total Amount (P+I)</th>
			</tr>
			<?php 
			$total_amount=0;
			$total_principal_amount=0;
			$total_interest_amount=0;
			foreach($schedules as $row):
				$total_amount+=$row["installment_amount"];
				$total_principal_amount+=$row["principal_installment_amount"];
				$total_interest_amount+=$row["interest_installment_amount"];
			?>
				<tr>
					<td class="field-values" align="left"><?php echo $row["installment_number"]?$row["installment_number"]:'';?></td>
					<td class="field-values" align="middle"><?php echo $row["schedule_date"]." ".date('l',strtotime($row["schedule_date"]));?></td>
					<td class="field-values" align="middle"><?php echo $row["installment_amount"]?number_format($row["installment_amount"],2,'.',','):'';?></td>
					<td class="field-values" align="middle"><?php echo $row["principal_installment_amount"]?number_format($row["principal_installment_amount"],2,'.',','):'';?></td>
					<td class="field-values" align="middle"><?php echo $row["interest_installment_amount"]?number_format($row["interest_installment_amount"],2,'.',','):'';?></td>
					<td class="field-values" align="middle"><?php echo number_format($row["principal_installment_amount"]+$row["interest_installment_amount"],2,'.',',');?></td>
				</tr>
			<?php endforeach;?>
			<tr>
				<th class="field-values">&nbsp;</td>
				<th class="field-values">&nbsp;</td>
				<th class="field-values"><?php echo number_format($total_amount,2,'.',',');?></td>
				<th class="field-values"><?php echo number_format($total_principal_amount,2,'.',',');?></td>
				<th class="field-values"><?php echo number_format($total_interest_amount,2,'.',',');?></td>
				<th class="field-values"><?php echo number_format($total_principal_amount+$total_interest_amount,2,'.',',');?></td>
			</tr>
		</tbody>
	</table>
</fieldset>
