<?php echo anchor('po_zone_area_details/add', 'Add New Zone Area Details');?>
<table>
<tr>
	<th>S/N</th>
	<th>Zone</th>
	<th>Area</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($po_zone_area_detail_infos as $row):
	$i++;
?>
<tr>
	<td><?php echo $i;?></td>
	<td><?php echo $row->zone_name;?></td>
	<td><?php echo $row->area_name;?></td>
	<td><?php echo anchor('po_zone_area_details/edit/'.$row->id, 'Edit');?> <?php echo anchor('po_zone_area_details/delete/'.$row->id, 'Delete',array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
</tr>
<?php endforeach;?>
</table>
<br/><br/>
<div align="center"><?php echo $this->pagination->create_links(); ?></div>
