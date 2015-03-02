<?php 
//Combo data for employess
	$employees_options[-1] = "---Employee Name---";
	foreach($employee_list as $emp_info)
	{					
		$employees_options[$emp_info->id]=$emp_info->name;
	}

	//status_info
	$session_data = $this->session->userdata('employee_product_transfers.index');
	//print_r($session_data);

	//Combo data for Product
	$products_options[-1] = "---Select product---";
	foreach($loan_products as $product_info)
	{					
		$products_options[$product_info->id]=$product_info->name;
	}
	//status_info
	$session_data = $this->session->userdata('employee_product_transfers.index');
	//print_r($session_data);

	$attribute = array('id'=>'myform','name'=>'myform');
	echo form_open('employee_product_transfers/index',$attribute); 
?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>				
			<td>
					<?php  echo form_dropdown('cbo_emp', $employees_options,isset($session_data['emp_id'])?$session_data['emp_id']:""); ?>
			</td>
			<td>
				<?php  //echo form_dropdown('cbo_products', $products_options,isset($session_data['emp_product'])?$session_data['emp_product']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('employee_product_transfers/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Employee Product Transfer')).'Add',array('class'=>'addbutton','title'=>'Add Employee Product Transfer'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>
	<th>Employee Name</th>
	<th>Old product</th>
	<th>New product</th>
	<th>Effective Date</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($employee_product_transfer_info as $row):
	$i++;
?>
 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->employee_name;?></td>
	<td><?php echo $row->employee_old_product_name;?></td>
	<td><?php echo $row->employee_new_product_name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->date_of_operation));?></td>
	<td>
	<?php echo anchor('employee_product_transfers/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('employee_product_transfers/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
