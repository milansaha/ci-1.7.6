<?php echo anchor('/user_roles/', 'Back To Roles');?>
<?php 
if($single_role_id==-1){
echo form_open('user_roles/permissions');
}
else{
	echo form_open('user_roles/permissions/'.$single_role_id);
}

?>
<table>
<tr>

<?php 
	
	foreach ($permissions as $permission):?>
	<th colspan="3"><?php echo $permission['controller_alias'];?></th>
	<?php
	foreach ($roles as $role):?>
	<th ><?php echo $role['role_name'];?></th>
	<?php endforeach;?>
	</tr>
	<?php
		foreach ($permission['actions'] as $action):
		?>
		<tr>
			<td colspan="3"><?php echo $action['action_alias'];?></td>
			<?php
			foreach ($action['roles'] as $role):
			$checkbox_data = array(
									'name'        => $role['id'].":".$permission['controller'].":".$action['action'],
									'value'       => $role['id'].":".$permission['controller'].":".$action['action'],
									'checked'     => $role['checked'],
			);?>

			<td><?php echo form_checkbox($checkbox_data);?></td>
			<?php endforeach;?>
		</tr>
		<?php endforeach;?>

<?php endforeach;?>

</table>
<?php echo form_submit('submit','Save');?>
