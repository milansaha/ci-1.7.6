<?php 
//Combo data for employess
	$employees_options[-1] = "---Select Employee---";
	foreach($employee_list as $emp_info)
	{					
		$employees_options[$emp_info->id]=$emp_info->name;
	}

	//Combo data for employess
	$branch_options[-1] = "---Select Branch---";
	foreach($branches as $branch_info)
	{					
		$branch_options[$branch_info->id]=$branch_info->name;
	}

	$session_data = $this->session->userdata('employee_branch_transfers.index');
	//print_r($session_data);
?>
<?php 	
	$attribute = array('id'=>'myform','name'=>'myform');
	echo form_open('employee_branch_transfers/index',$attribute); 
?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>				
			<td>
					<?php  echo form_dropdown('cbo_emp', $employees_options,isset($session_data['emp_id'])?$session_data['emp_id']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_branch', $branch_options,isset($session_data['emp_branch'])?$session_data['emp_branch']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('employee_branch_transfers/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Employee Branch Transfer')).'Add',array('class'=>'addbutton','title'=>'Add Employee Branch Transfer'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>
	<th>Employee Name</th>
	<th>Employee Code</th>
	<th>Old Branch</th>
	<th>New Branch</th>
	<th>Effective Date</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($employee_branch_transfer_info as $row):
	$i++;
?>
 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->employee_name;?></td>
	<td><?php echo $row->employee_code;?></td>
	<td><?php echo $row->employee_old_branch_name;?></td>
	<td><?php echo $row->employee_new_branch_name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->effective_date));?></td>
	<!-- <td><?php echo $row->effective_date;?></td> -->
	<td>
	<?php echo anchor('employee_branch_transfers/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('employee_branch_transfers/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','title'=>'Delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>
	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
