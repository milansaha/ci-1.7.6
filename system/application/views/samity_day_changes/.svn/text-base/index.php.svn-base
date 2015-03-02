<div id="filter">
	<h3><?php echo $headline;?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('samity_day_changes/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Samity Day Change')).'Add',array('class'=>'addbutton','title'=>'Add Samity Day Change'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th>Samity</th>
	<th>Previous Samity Day</th>
	<th>New Samity Day</th>
	<th>Effective Date</th>
	<th width="10%">Action</th>
</tr>
<?php 
$i=$counter;
foreach ($samity_day_changes as $row):
$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>	
	<td><?php echo $row->samity_name;?></td>
	<td><?php echo $row->previous_samity_day;?></td>
	<td><?php echo $row->new_samity_day;?></td>
	<td><?php echo date('d/m/Y',strtotime($row->effective_date));?></td>
	<td>
	<?php echo anchor('samity_day_changes/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('samity_day_changes/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
