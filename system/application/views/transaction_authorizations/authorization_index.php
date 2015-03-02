<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<!--<script type="text/javascript">
function submitForm(val)
{	
	alert(val);
	document.authorization.submit(val);	
}
</script>-->
<script type="text/javascript">
$(document).ready(function() {
		// start savings code change
		$("#submit_1").click(		
		function() 
		{
			alert('Mitu');
			// start json
			// savings information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var selected_savings_id = $("#samity_id").val();					
			alert(selected_savings_id);
			
			$.post("<?php echo site_url('transaction_authorizations/ajax_authorization_index') ?>", { savings_id: selected_savings_id},
			function(data)
			{
				alert('Mitu');				
			}, "json");
			alert('Rabeya');
		});		
		// END product change
});
</script>
<?php if(empty($transaction_authorizations)):
echo "No Transaction Information Available for Authorization";
else:?>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}	
	$session_data=$this->session->userdata('transaction_authorizations.authorization_index');?>
<?php echo form_open('transaction_authorizations/authorization_index',array('name'=>'authorization'));?>
<div id="filter"><h3>Transaction Authorization</h3></div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th width="8%">Samity Code</th>
	<th>Samity Name</th>	
	<th width="10%"><div align="right">Loan Disbursement Amount</div></th>	
	<th width="10%"><div align="right">Savings Collection Amount</div></th>
	<th width="10%"><div align="right">SKT Collection Amount</div></th>
	<th width="10%"><div align="right">Withdraw Amount</div></th>		
	<th width="10%"><div align="right">Loan Transaction Amount</div></th>
	<th width="10%">Action</th>	
</tr>
<?php $i=$counter; $i=0;
	$total_loan_amount=0;$total_deposit_amount=0;$total_skt_collection_amount=0;$total_withdraw_amount=0;$total_loan_transaction_amount=0;
	foreach ($transaction_authorizations as $row): 
	$total_loan_amount+=$row->loan_amount;
	$total_deposit_amount+=$row->deposit_amount;
	$total_skt_collection_amount+=$row->skt_collection_amount;
	$total_withdraw_amount+=$row->withdraw_amount;
	$total_loan_transaction_amount+=$row->loan_transaction_amount;
	$i++;?>	
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->samity_code;?></td>
	<td><?php echo $row->samity_name;?></td>
	<td align="right"><?php if($row->loan_amount>0): echo number_format($row->loan_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($row->deposit_amount>0): echo number_format($row->deposit_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($row->skt_collection_amount>0): echo number_format($row->skt_collection_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($row->withdraw_amount>0): echo number_format($row->withdraw_amount,'2','.',','); else: echo '-'; endif;?></td>		
	<td align="right"><?php if($row->loan_transaction_amount>0): echo number_format($row->loan_transaction_amount,'2','.',','); else: echo '-'; endif;?></td>	
	<input type="hidden" name="transactiondata[<?php echo $i;?>][samity_id]" id="samity_id" value="<?php echo $row->samity_id;?>" />
	<td>
	<?php  //echo anchor('transaction_authorizations/authorization_index/', 'Authorize',array('title'=>'Authorize','id'=>'submit_1','name'=>'submit_1','value'=>$row->samity_id));?>
	<?php echo anchor('transaction_authorizations/authorization_detail/'.$row->samity_id,img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'View')),array('class'=>'imglink','title'=>'View')); ?></td>
</tr>
<?php endforeach;?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo 'Total'?></td>
	<td colspan='2' align="center"><?php echo $i;?></td>	
	<td align="right"><?php if($total_loan_amount>0): echo number_format($total_loan_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($total_deposit_amount>0): echo number_format($total_deposit_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($total_skt_collection_amount>0): echo number_format($total_skt_collection_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($total_withdraw_amount>0): echo number_format($total_withdraw_amount,'2','.',','); else: echo '-'; endif;?></td>		
	<td align="right"><?php if($total_loan_transaction_amount>0): echo number_format($total_loan_transaction_amount,'2','.',','); else: echo '-'; endif;?></td>		
	<td></td>
</tr>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<br/><br/><br/><br/>
<?php echo form_submit(array('name'=>'submit_2','id'=>'submit_2','class'=>'save_button'),'Authorize All Information');?>
<?php echo form_close(); endif;?>