<?php echo anchor('member_details/add', 'Add New Member Detail');?>
<table>
	<tr>
		<th>Sl. No.</th>
		<th>Name</th>			
		<th>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($member_details as $row):
		$i++;
	?>
	<tr>
		<td><?php echo $i;?></td>
		<td><?php echo $row->name;?></td>	
		<td><?php echo anchor('member_details/edit/'.$row->id, 'Edit');?> <?php echo anchor('member_details/is_delete/'.$row->id, 'Delete',array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
	</tr>
	<?php endforeach;?>
</table>
<br/><br/>
<div align="center"><?php echo $this->pagination->create_links(); ?></div>
