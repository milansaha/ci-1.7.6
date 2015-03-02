<div id="filter">
	<h3><?php echo $headline?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('saving_products/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Union Ward')).'Add',array('class'=>'addbutton','title'=>'Add Union Ward'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Short Name</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Type of Deposit</th>
    <th>Mandatory Amount for Deposit</th>
    <th>Interest Rate</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($Saving_products_info as $row):
	$i++;
?>
 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->short_name;?></td>
	<td><?php if(($row->start_date != NULL)){echo date('d/m/Y', strtotime($row->start_date));}?></td>
	<td><?php if(($row->end_date != NULL)){echo date('d/m/Y', strtotime($row->end_date));}?></td>
    <td><?php echo $row->type_of_deposit;?></td>
    <td align="right" width="10%"><?php echo number_format($row->mandatory_amount_for_deposit,'2','.',',');?></td>
    <td align="right" width="10%"><?php echo $row->interest_rate . " %";?></td>
	<td>
	<?php echo anchor('saving_products/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('saving_products/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>
	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
