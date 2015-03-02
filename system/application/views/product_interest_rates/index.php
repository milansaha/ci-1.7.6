<div id="filter">
	<h3><?php echo $headline?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('product_interest_rates/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Product Interest Rates')).'Add',array('class'=>'addbutton','title'=>'Add Product Interest Rates'));  ?>
	</div>
</div>
<?php //echo anchor('product_interest_rates/add', 'Add Interest Rate');?>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Product Name</th>
	<th>Interest Rate</th>
	<th>Interest Provision Rate</th>
	<th>Effective Date</th>
	<th>End Date</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($product_interest_rate as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->product_name;?></td>
	<td><?php echo $row->interest_rate;?></td>
	<td><?php echo $row->interest_provision_rate;?></td>
	<td><?php echo $row->effective_date;?></td>
	<td><?php echo $row->end_date;?></td>
	<td>
		<?php echo anchor('product_interest_rates/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink')); ?>	
		<?php echo anchor('product_interest_rates/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
