<div id="filter"><h3>PO Organization Information</h3></div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Organization Code</th>
	<th>Head of the PO</th>
	<th>Established Date</th>
	<th>Logo</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($po_organizations_info as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->organaization_code;?></td>
	<td><?php echo $row->head_of_the_po;?></td>
	<td><?php echo date('d-m-Y', strtotime($row->established_date));?></td>
	<td><?php echo "<b>Should be modified for logo</b>"; ?></td>
	<td>
	<?php echo anchor('po_organizations/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('po_organizations/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
