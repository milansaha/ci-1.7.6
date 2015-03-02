<table class="sortable" cellspacing="0px" cellpadding="0px">
<h3>Member Types</h3>
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Action</th>
</tr>
<?php 
$i=$counter;
foreach ($member_types as $row):
$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td>
	<?php echo anchor('member_types/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('member_types/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<br/><br/>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
