<?php 
	//Member list	
	$member_options = "";

	foreach($member_infos as $member_row)

	{					

		$member_options[$member_row->member_id]=$member_row->member_name;

	}
	

	//Form start
	echo form_open('member_discontinuouses/add');
?>
<fieldset>
	<legend>
		Member's Discontinuouses Information
	</legend>
	<ol>  
		<li>	
			<label for="cbo_member">Member Name:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_member', $member_options);?>			
		</li> 
		<li>
			<label for="txt_discontinue_date">Discontinue Date:</label>
			<?php echo form_input('txt_discontinue_date',set_value('txt_discontinue_date'));?><?php echo form_error('txt_discontinue_date'); ?>		
		</li> 
		<li>
			<?php echo form_submit('submit','Save');?>
		</li>
	</ol>
</fieldset>
<?php echo form_close(); ?>
