<?php
	//Combo data for Designation
	$designation_options[-1] = "---All---";
	foreach($employee_designation_infos as $employee_designation_info)
	{					
		$designation_options[$employee_designation_info->designation_id]=$employee_designation_info->designation_name;
	}
	$session_data = $this->session->userdata('employee.index');
	//print_r($session_data);die;
	$attribute = 'class="search_input" title="By Name or Code"';
    $active = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'Active'));
	$inactive = img(array('src'=>base_url().'media/images/dimed_ok.png','border'=>'0','alt'=>'Inactive'));
?>
<?php echo form_open('employees/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter"><p>Filter:</p>
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="1" class="filter">
		<tr>
			<td>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute );?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_employee_designation', $designation_options,isset($session_data['employee_designation'])?$session_data['employee_designation']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('employees/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Employee')).'Add',array('class'=>'addbutton','title'=>'Add Employee'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width="5%">#</th>
	<th>Name</th>
	<th>Employee Code</th>
	<th>Designation</th>
	<th>Joining Date</th>
    <th width="5%" align="center">Status</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($employees_info as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->code;?></td>	
	<td><?php echo $row->designation_name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->date_of_joining));?></td>
    <td width="5%" align="center"><?php echo ($row->current_status == 0)?$inactive:$active; ?></td>
	<td>
	<?php echo anchor('employees/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('title'=>'Edit'));?>
	<?php echo anchor('employees/view/'.$row->id,img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'view','width'=>'16px')),array('title'=>'View'));?>
	<?php echo anchor('employees/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
