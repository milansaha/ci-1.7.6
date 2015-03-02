<?php 
//Combo data for employess
	$employees_options[] = "---Select Employee---";
	foreach($employee_list as $emp_info)
	{					
		$employees_options[$emp_info->id]=$emp_info->name;
	}
	//Samity list
	$samity_options = array(""=>"--Select--");
	foreach($samities as $samity_row)
	{					
    	$samity_options[$samity_row->samity_id]=$samity_row->samity_name; 	
	}
	$session_data = $this->session->userdata('samity_employee_changes.index');
	//print_r($session_data);
?>
<?php 	
	$attribute = array('id'=>'myform','name'=>'myform');
	echo form_open('samity_employee_changes/index',$attribute); 
?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>				
			<td>
				<?php echo form_dropdown('cbo_samity',$samity_options,isset($session_data['samity_id'])?$session_data['samity_id']:""); ?>
			</td>
			<td>
				<?php echo form_dropdown('cbo_emp', $employees_options,isset($session_data['emp_id'])?$session_data['emp_id']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('samity_employee_changes/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Samity Employee Changes')).'Add',array('class'=>'addbutton','title'=>'Add Samity Employee Changes'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>
	<th>Samity Name</th>
	<th>Previous Field Officer</th>
	<th>New Field Officer</th>
	<th>Effective Date</th>
	<th>Action</th>
</tr>
<?php
	$i=0;
	foreach ($samity_employee_transfers as $row):
	$i++;
?>
 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->samity_name;?></td>
	<td><?php echo $row->previous_employee_name;?></td>
	<td><?php echo $row->new_employee_name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->effective_date));?></td>
	<td>
	<?php echo anchor('samity_employee_changes/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('samity_employee_changes/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')",'title'=>'Delete'));?>	
	</td>
	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
