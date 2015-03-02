<div id="filter">
	<h3><?php echo $headline?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('loan_products/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan Products')).'Add',array('class'=>'addbutton','title'=>'Add Loan Products'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width="5%">#</th>
		<th>Name</th>
		<th>Short Name</th>
        <th width='15%'>Is Primary Product</th>
		<th>Start Date</th>
		<th>End Date</th>	
		<th width='10%'>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($loan_products as $row):
		$i++;
	?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?>>
		<td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->name;?></td>
		<td><?php echo $row->short_name;?></td>
        <td><?php echo ($row->is_primary_product==1)?'Yes':'No';?></td>
		<td><?php if(($row->start_date != NULL)){echo date('d/m/Y', strtotime($row->start_date));}?></td>
        <td><?php if(($row->end_date != NULL)){echo date('d/m/Y', strtotime($row->end_date));}?></td>
		<td>
			<?php //echo anchor('loan_products/view/'.$row->id,img(array('src'=>base_url().'media/images/view.png','border'=>'0','alt'=>'View')),array('class'=>'imglink'));   ?>
			<?php echo anchor('loan_products/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
			<?php echo anchor('loan_products/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
				  array('class'=>'delete','title'=>'Delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));
			?>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
