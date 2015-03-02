<?php echo anchor('/users/', 'Back To Users');?>
<?php 
//echo "<pre>";print_r($checked_branch);die;
	$hidden = array('user_id' => $user_id);

	echo form_open('user_roles/user_wise_branch_access', '', $hidden);
?>
<table>
<tr>
	<th align="left">Branch Name</th>
	<th></th>
</tr>
	<?php 
		foreach ($branches as $branches):
		$checked = FALSE;
		if(!empty($checked_branch))
		{
			if (array_key_exists($branches->branch_id, $checked_branch))
			{
				$checked = TRUE;	
			}
		}				
	?>	
		<tr>
			<td><?php echo $branches->branch_name;?></td>	
				
			<td>
			<?php 
				$checkbox_data = array(
				'name'        => $branches->branch_id,
				'id'          => $branches->branch_id,
				'value'       => $branches->branch_id,
				'checked'     => $checked,
				'style'       => 'margin:10px',
				);

				//echo form_checkbox($data);
				echo form_checkbox($checkbox_data);?>
			</td>			
		</tr>
<?php endforeach;?>

</table>
<?php echo form_submit('submit','Save');?>
