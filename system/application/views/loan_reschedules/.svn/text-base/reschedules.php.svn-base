<script type="text/javascript">
	$(function(){
	$("#txt_date_from").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_date_to").datepicker({dateFormat: 'yy-mm-dd'});	
	});
</script>
<fieldset>
	<!--<div id="execute_div">
		<div id="execute_link">
			<?php echo anchor('loans/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan')).'Add Loan',array('class'=>'','title'=>'Add Loan'));  ?>
		</div>
		<div id="execute_link">
			<?php echo anchor('loan_reschedules/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan Shedules')).'Add Loan Shedule',array('class'=>'','title'=>'Add Loan Shedule'));  ?>
		</div>
	</div>-->
	<table class="uiInfoTableConfig" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr>
				<th>
					<img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;Loan Details
				</th>
				<th style="padding:3px 0px 1px 0px;margin:0px 0px 0px 0px;" align="right" valign="top">
					<div style="float:right;width:145px;border:solid 0px red;">
						<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Back to list page','class'=>'back_button','onclick'=>"window.location.href='".site_url('loan_reschedules')."'"));?>
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
				<td class="field-items"><?php echo $loan->loan_amount?$loan->loan_amount:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Interest Calculation Method:</td>
				<td class="field-items"><?php echo $loan->interest_calculation_method?$loan->interest_calculation_method:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Interest Rate:</td>
				<td class="field-items"><?php echo $loan->interest_rate?$loan->interest_rate:''?></td>
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
				<td class="field-items"><?php echo $loan->mode_of_interest?$loan->mode_of_interest:''?></td>
			</tr>
		</tbody>
	</table>
<br/>
	<table class="uiInfoTableConfig" border="0" cellspacing="1px" cellpadding="0px">
		<tbody>
			<tr>
				<th align="left" colspan="7" class="field-header">
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
				<th class="field-title" width="15%">Transaction</th>
			</tr>
			<?php 
			//print_r($schedules);
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
					<td>
						<?php 
							if(isset($transcantions[$row["installment_number"]])){
								echo '<img src="'.base_url().'media/images/paid_button.png" border="0" alt="paid" />&nbsp;<span style="color:#76A514;font-size:11px;font-weight:bold;">Paid</span>';
							}else{
								echo anchor('loan_reschedules/add_reschedules/'.$row['loan_id'].'/'.$row["installment_number"],img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Reschedule','width'=>'12px')).'&nbsp;&nbsp;<span style="color:#07A4E7;font-size:12px;font-weight:italic;">Reschedule</span>',array('class'=>'imglink','title'=>'Add Reschedule'));
							}
						?>
						<!--<input type="checkbox" id="is_given_installment_no<?php echo $row['installment_number'];?>" <?php if(isset($transcantions[$row["installment_number"]])) echo 'checked="true"';?> name="is_given_installment_no[<?php echo $row['installment_number'];?>]" value="1" style="margin:0px;width:20px;border:none;">Yes-->
					</td>
					<?php /*if(!isset($transcantions[$row["installment_number"]])):?>
					<td><?php echo ajax_form_for_report('register_reports/ajax_admission_register','#report_container');?></td>
					<td>
					<label for="txt_date_from">Date from:<em>&nbsp;</em></label>			
					<?php $txt_date_from = array('name'=>'txt_date_from','id'=>'txt_date_from','readonly'=> 'readonly');
					echo form_input($txt_date_from,set_value('txt_date_from'));?><?php echo form_error('txt_date_from'); ?>
					</td>
					<td>
					<label for="txt_date_to">Date to:<em>&nbsp;</em></label>			
					<?php $txt_date_to = array('name'=>'txt_date_to','id'=>'txt_date_to','readonly'=> 'readonly');
					echo form_input($txt_date_to,set_value('txt_date_to'));?><?php echo form_error('txt_date_to'); ?>		
					</td>
					<td>
					<?php echo form_submit('submit','Reschedule');?>
					</td>
					<?php endif;*/?>
				</tr>
			<?php endforeach;?>
			<tr>
				<th class="field-values">&nbsp;</td>
				<th class="field-values">&nbsp;</td>
				<th class="field-values"><?php echo number_format($total_amount,2,'.',',');?></td>
				<th class="field-values"><?php echo number_format($total_principal_amount,2,'.',',');?></td>
				<th class="field-values"><?php echo number_format($total_interest_amount,2,'.',',');?></td>
				<th class="field-values"><?php echo number_format($total_principal_amount+$total_interest_amount,2,'.',',');?></td>
				<th class="field-values">&nbsp;</td>
			</tr>
		</tbody>
	</table>
</fieldset>
