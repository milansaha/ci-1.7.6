<?php 
	//Combo data for Roles
	$role_options[-1] = "---Select Role---";
	foreach($user_roles as $user_role_info)
	{					
		$role_options[$user_role_info->id]=$user_role_info->role_name;
	}
	//Combo data for Branches
	$branches_options[-1] = "---Select Branch---";
	foreach($user_branches as $user_branch_info)
	{					
		$branches_options[$user_branch_info->id]=$user_branch_info->name;
	}
	//status_info
	$session_data = $this->session->userdata('user.index');
	//print_r($session_data);
?>
<?php $attribute = array('id'=>'myform','name'=>'myform');
		echo form_open('users/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php 
					$attribute = 'class="search_input" title="By name "'; 
				?>
				
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_user_role', $role_options,isset($session_data['user_role'])?$session_data['user_role']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_user_branch', $branches_options,isset($session_data['user_branch'])?$session_data['user_branch']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_user_status', $status_info,isset($session_data['user_status'])?$session_data['user_status']:""); ?>
			</td>
			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>				
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('/users/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add User')).'Add',array('class'=>'addbutton','title'=>'Add User'));  ?>
	</div>
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Login</th>
	<th>Full Name</th>	
	<th>User Role</th>
	<th>Default Branch</th>
	<th>Status</th>
	<th>Action</th>
</tr>
<?php 
	$i=0;
	foreach ($users as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->login;?></td>
	<td><?php echo $row->full_name;?></td>	
	<td><?php echo $row->role_name;?></td>
	<td><?php echo $row->branch_name;?></td>
	<td><?php echo ($row->current_status=='active')?img(array('src'=>base_url().'media/images/apply2.png','border'=>'0','alt'=>'Active')):img(array('src'=>base_url().'media/images/dimed_ok.png','border'=>'0','alt'=>'Inactive'));?></td>
	<td>
	<?php echo anchor('users/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('users/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>		
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
