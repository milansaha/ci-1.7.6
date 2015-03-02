<div id="filter">
	<h3>Division's Information</h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('po_divisions/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Division')).'Add',array('class'=>'addbutton','title'=>'Add Division'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width='5%'>#</th>
		<th>Division Name</th>	
		<th width='10%'>Action</th>
	</tr>
	<?php 	$i=$counter;
			foreach ($po_divisions as $row):
			$i++; ?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->name;?></td>	
		<td>
		<?php echo anchor('po_divisions/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('title'=>'Edit','class'=>'imglink'));   ?>
		<?php echo anchor('po_divisions/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
						array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
		</td>		
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
