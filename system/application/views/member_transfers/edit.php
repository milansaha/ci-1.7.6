<?php 
	//Member list	
	$member_options = "";

	foreach($member_infos as $member_row)

	{					

		$member_options[$member_row->member_id]=$member_row->member_name;

	}
	
	//Working area list	
	$samity_options = "";
//	echo "<pre>";
//	print_r($samity_infos);die;

	foreach($samity_infos as $samity_row)

	{					

		$samity_options[$samity_row->samity_id]=$samity_row->samity_name;		
	}

//	echo "<pre>";
//         print_r($samity_options);die;

	//Form start
	echo form_open('member_transfers/edit');
	echo form_hidden('member_transfer_id',$row->id);
?>
<fieldset>
	<legend>
		Member's Transfer Information
	</legend>
	<ol>  
		<li>	
			<label for="cbo_member">Member Name:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_member', $member_options,$row->member_id);?>			
		</li> 
		<li>	
			<label for="cbo_previous_samity">New Samity Name:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_previous_samity', $samity_options,$row->previous_samity_id);?>			
		</li> 
		<li>	
			<label for="cbo_current_samity">Current Samity Name:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_current_samity', $samity_options,$row->current_samity_id);?>			
		</li> 
		<li>
			<label for="txt_transfer_date">Transfer Date:</label>
			<?php echo form_input('txt_transfer_date',set_value('txt_transfer_date',$row->transfer_date));?><?php echo form_error('txt_transfer_date'); ?>		
		</li> 
		<li>
			<?php echo form_submit('submit','Save');?>
		</li>
	</ol>
</fieldset>
<?php echo form_close(); ?>
