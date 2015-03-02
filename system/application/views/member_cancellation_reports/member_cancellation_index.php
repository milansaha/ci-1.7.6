<?php
	//Branches
	$branch_options[''] = '--------SELECT--------';
	foreach($branches_info as $branches_info)
	{					
		$branch_options[$branches_info->branch_id]=$branches_info->branch_name;
	}
		
	echo form_open('register_reports/member_cancellation_report');
?>
<fieldset>
	<legend>
		Member Cancellation Regsiter
	</legend>
	<ol> 
		<li>
			<label for="branch_id">Branch Id:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('branch_id', $branch_options); ?>			
		</li> 
		<li>
			<label for="txt_date_from">Cancellation From:<em>&nbsp;</em></label>			
			<?php echo form_input('txt_date_from'); ?>			
		</li> 
		<li>
			<label for="txt_date_to">Cancellation To:<em>&nbsp;</em></label>			
			<?php echo form_input('txt_date_to'); ?>			
		</li> 
		<li>
			<?php echo form_submit('submit','Show Report');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
