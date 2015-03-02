<table class="sortable" cellspacing="0px" cellpadding="0px">
<h3>Member Discontinue Information</h3>
<tr>
	<th>#</th>
	<th>Member Name</th>
	<th>Discontinue Date</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($member_discontinues as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->member_name;?></td>
	<td><?php echo date('d-m-Y', strtotime($row->discontinue_date));?></td>
	<td>
	<?php echo anchor('member_discontinuouses/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('member_discontinuouses/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<br/><br/>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
