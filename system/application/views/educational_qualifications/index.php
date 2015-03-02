<div id="filter">
	<h3><?php echo $headline;?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('educational_qualifications/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Educational Qualification')).'Add',array('class'=>'addbutton','title'=>'Add Educational Qualification'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width='5%'>#</th>
		<th>Qualification Name</th>
		<th width='10%'>Action</th>
	</tr>
	<?php 	$i=$counter;
			foreach ($educational_qualifications as $row):
			$i++; ?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->name;?></td>
		<td>
		<?php echo anchor('educational_qualifications/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('title'=>'Edit','class'=>'imglink'));   ?>
		<?php echo anchor('educational_qualifications/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
						array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
