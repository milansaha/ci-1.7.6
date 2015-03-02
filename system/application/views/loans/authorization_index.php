<?php if(empty($loans)):
echo "No loan available for authorization";
else:?>
<h3>Loan Authorization</h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}	
	$session_data=$this->session->userdata('loans.authorization_index');?>
<?php echo form_open('loans/authorization_index'); ?>
<div id="filter">
<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>					
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
</div>
<?php echo form_close(); ?>
<?php echo form_open('loans/authorization_index');?>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th width="10%">Customized loan No</th>
	<th width="10%">Loan Application No</th>	
	<th width="5%">Member Code</th>	
	<th width="15%">Member Name</th>
	<th width="5%">Product</th>	
	<th width="8%">Int Rate</th>	
	<th width="5%">Loan Period in Month</th>
	<th width="5%">Loan Amount</th>			
	<th width="5%">Total Repay</th>		
	<th width="5%">Disburse Date</th>
	<th width="5%">First Repay Date</th>
	<th width="5%">Repayment Fre.</th>
	<th width="4%">No. Of Repay.</th>			
	<th width="5%">Cycle</th>	
	<th width="3%">Is Authorized</th>	
</tr>
<?php $i=$counter; $i=0;foreach ($loans as $row): $i++;?>	
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->customized_loan_no;?></td>	
	<td><?php echo $row->loan_application_no;?></td>	
	<td><?php echo $row->member_code;?></td>	
	<td><?php echo $row->member_name;?></td>	
	<td><?php echo $row->mnemonic;?></td>	
	<td><?php echo number_format($row->interest_rate,'2','.',',')." % ".$row->interest_calculation_method;?></td>	
	<td><?php echo $row->loan_period_in_month;?></td>
	<td align="center"><?php echo number_format($row->loan_amount,'2','.',',');?></td>
	<td align="center"><?php echo number_format($row->total_payable_amount,'2','.',',');?></td>	
	<td align="center"><?php echo date('d/m/y', strtotime($row->disburse_date));?></td>
	<td align="center"><?php echo date('d/m/y', strtotime($row->first_repayment_date));?></td>	
	<td align="center"><?php echo $row->repayment_frequency;?></td>
	<td align="center"><?php echo anchor('loan_schedules/index/'.$row->id,$row->number_of_installment);?></td>
	<td align="center"><?php echo $row->cycle;?></td>
	<input type="hidden" name="loandata[<?php echo $i;?>][id]" id="loan_id_[<?php echo $i;?>]" value="<?php echo $row->id;?>" />
	<td><input type="checkbox" id="is_authorized<?php echo $i;?>"  name="loandata[<?php echo $i;?>][is_authorized]" value="1" style="margin:0px;width:20px;border:none;">Yes</td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<br/><br/><br/><br/>
<?php echo form_submit(array('name'=>'submit_1','id'=>'submit_1','class'=>'save_button'),'Authorize selected loans');?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo form_submit(array('name'=>'submit_2','id'=>'submit_2','class'=>'save_button'),'Authorize all loans');?>
<?php echo form_close(); endif;?>
