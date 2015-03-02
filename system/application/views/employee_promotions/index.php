<div id="filter">
	<h3><?php echo $headline;?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('employee_promotions/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Employee Promotion')).'Add',array('class'=>'addbutton','title'=>'Add Employee Promotion'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Employee Name</th>
	<th>Employee Code</th>
	<th>Old Designation</th>
	<th>New Designation</th>
	<th>Promotion Date</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($employee_promotions as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->employee_name;?></td>
	<td><?php echo $row->employee_code;?></td>
	<td><?php echo $row->employee_old_designation_name;?></td>
	<td><?php echo $row->employee_new_designation_name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->effective_date));?></td>
	<td>
	<?php echo anchor('employee_promotions/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('employee_promotions/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
