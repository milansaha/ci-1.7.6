<div id="filter">
    <h3><?php echo $headline;?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('po_funding_organizations/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Funding Organization')).'Add',array('class'=>'addbutton','title'=>'Add Funding Organization'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Concern Person</th>
	<th>Address</th>
	<th>Phone</th>
	<th>Mobile</th>
	<th>Email</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($po_funding_organizations_info as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->concern_person;?></td>
	<td><?php echo $row->address;?></td>
	<td><?php echo $row->land_phone;?></td>
	<td><?php echo $row->mobile_phone;?></td>
	<td><?php echo $row->email;?></td>
	<td>
	<?php echo anchor('po_funding_organizations/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('po_funding_organizations/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>		
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
