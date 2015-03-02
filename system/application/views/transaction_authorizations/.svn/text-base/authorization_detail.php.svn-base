<h3><div align='center'><?php if(isset($samity[0])): echo "Samity Name (Code): ".$samity[0]->samity_name.'('. $samity[0]->samity_code.')'; endif;?></div></h3>
<?php echo form_open('transaction_authorizations/authorization_index',array('name'=>'authorization'));?>
<div id="filter"><h3>Transaction Authorization Detail</h3></div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th>Member Name</th>	
	<th width="10%">Member Code</th>		
	<th width="10%"><div align="right">Loan Disbursement Amount</div></th>	
	<th width="10%"><div align="right">Savings Collection Amount</div></th>
	<th width="10%"><div align="right">SKT Collection Amount</div></th>
	<th width="10%"><div align="right">Withdraw Amount</div></th>		
	<th width="10%"><div align="right">Loan Transaction Amount</div></th>	
</tr>
<?php $i=$counter; $i=0;foreach ($transaction_authorizations_detail as $row): $i++;?>	
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>	
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->code;?></td>	
	<td align="right"><?php if($row->loan_amount>0): echo number_format($row->loan_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($row->deposit_amount>0): echo number_format($row->deposit_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($row->skt_collection_amount>0): echo number_format($row->skt_collection_amount,'2','.',','); else: echo '-'; endif;?></td>
	<td align="right"><?php if($row->withdraw_amount>0): echo number_format($row->withdraw_amount,'2','.',','); else: echo '-'; endif;?></td>		
	<td align="right"><?php if($row->loan_transaction_amount>0): echo number_format($row->loan_transaction_amount,'2','.',','); else: echo '-'; endif;?></td>		
	<input type="hidden" name="transactiondata[<?php echo $i;?>][samity_id]" id="samity_id" value="<?php echo $samity[0]->samity_id;?>" />
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<br/><br/><br/><br/>
<?php echo form_submit(array('name'=>'submit_2','id'=>'submit_2','class'=>'save_button'),'Authorize All Information');?>
<?php echo form_close(); ?>