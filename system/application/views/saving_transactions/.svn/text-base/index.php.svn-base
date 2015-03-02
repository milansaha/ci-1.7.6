<?php echo anchor('saving_transactions/add', 'Add New Saving Transaction');?>
<table>
	<tr>
		<th width='5%'>Sl. No.</th>
		<th>Savings ID</th>	
		<th>Transaction Code</th>	
		<th>Transaction Date</th>	
		<th>Transaction Type</th>	
		<th>Payment Type</th>	
		<th>Amount</th>		
		<th width='10%'>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($saving_transactions as $row):
		$i++;
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php echo $row->savings_id;?></td>
		<td><?php echo $row->transaction_code;?></td>	
		<td><?php echo $row->transaction_date;?></td>	
		<td><?php echo $row->transaction_type;?></td>
		<td><?php echo $row->payment_type;?></td>
		<td><?php echo $row->amount;?></td>			
		<td><?php echo anchor('saving_transactions/edit/'.$row->id, 'Edit');?> <?php echo anchor('saving_transactions/is_delete/'.$row->id, 'Delete',array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
	</tr>
	<?php endforeach;?>
</table>
<br/><br/>
<div align="center"><?php echo $this->pagination->create_links(); ?></div>
