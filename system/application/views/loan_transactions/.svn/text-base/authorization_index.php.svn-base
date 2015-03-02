<?php if(empty($loan_transactions)):
echo "No Loan Transaction Information Available for Authorization";
else:?>
<script type="text/javascript">
	$(function(){
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<h3><?php echo $headline?></h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$session_data=$this->session->userdata('loan_transactions.authorization_index');?>
<?php echo form_open('loan_transactions/authorization_index'); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""));?>
			</td>		
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>
			<td>To</td><td>
				<?php 
				$to_date_attr = array('name'=>'txt_to_date','id'=>'txt_to_date');
				echo form_input($to_date_attr,set_value('txt_to_date'));?>
			</td>
			<td>From</td><td>
				<?php 
				$from_date_attr = array('name'=>'txt_from_date','id'=>'txt_from_date');
				echo form_input($from_date_attr,set_value('txt_from_date'));?>
			</td>				
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
</div>
<?php echo form_close(); ?>
<?php echo form_open('loan_transactions/authorization_index'); ?>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width="5%">#</th>	
		<th >Loan ID</th>		
		<th >Transaction Date</th>		
		<th width="8%">Amount</th>		
		<th width="5%">Status</th>
		<th width='10%'>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($loan_transactions as $row):
		$i++;
		$authorized = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
		$unauthorized = img(array('src'=>base_url().'media/images/button_fewer.png','border'=>'0','alt'=>'OK'));	
	?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
		<td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->customized_loan_no;?></td>	
		<td><?php echo date('d/m/Y', strtotime($row->transaction_date));?></td>	
		<td><?php echo $row->transaction_amount;?></td>			
		<td><?php if($row->is_authorized==0): echo $unauthorized; else: echo $authorized; endif;?></td>
		<input type="hidden" name="loantransactionsdata[<?php echo $i;?>][id]" id="loan_transaction_id_[<?php echo $i;?>]" value="<?php echo $row->id;?>" />
	<td><input type="checkbox" id="is_authorized<?php echo $i;?>"  name="loantransactionsdata[<?php echo $i;?>][is_authorized]" value="1" style="margin:0px;width:20px;border:none;">Yes</td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<br/><br/><br/><br/>
<?php echo form_submit(array('name'=>'submit_1','id'=>'submit_1','class'=>'save_button'),'Authorize Selected Loan Transaction');?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo form_submit(array('name'=>'submit_2','id'=>'submit_2','class'=>'save_button'),'Authorize All Loan Transaction');?>
<?php echo form_close(); endif;?>
