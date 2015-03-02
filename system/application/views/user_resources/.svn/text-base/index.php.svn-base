<table class="sortable" cellspacing="0px" cellpadding="0px">
<h3>User Resources</h3>
<tr>
	<th width="5%">#</th>
	<th width="20%">Group</th>
	<th width="20%">Title</th>
	<th width="20%">Controller Name</th>
	<th width="20%">Action Name</th>
	<th width="5%">Status</th>
	<th width="10%">Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($designations as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->resource_group_name;?></td>
	<td><?php echo $row->title;?></td>
	<td><?php echo $row->controller;?></td>
	<td><?php echo $row->action;?></td>
	<td><?php echo $row->is_enabled;?></td>
	<td>
	<?php echo anchor('user_resources/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('user_resources/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<br/><br/>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
