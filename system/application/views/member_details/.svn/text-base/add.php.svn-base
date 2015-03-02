<?php 
	//Member list	
	$member_options = "";
	foreach($members as $member_row)
	{					
		$member_options[$member_row->id]=$member_row->name;
	}
	
	//Working area list	
	$working_areas_options = "";
	foreach($working_areas as $working_area_row)
	{					
		$working_areas_options[$working_area_row->id]=$working_area_row->name;
	}

	//Form start
	echo form_open('member_details/add');
?>
<fieldset>
	<legend>
		Member's Detail Information
	</legend>
	<ol>  
		<li>			
			<label for="cbo_member">Member:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_member', $member_options);?>			
		</li> 
		<li>
			<label for="txt_fathers_name">Father's Name:</label>
			<?php echo form_input('txt_fathers_name',set_value('txt_fathers_name'));?><?php echo form_error('txt_fathers_name'); ?>		
		</li> 
		<li>
			<label for="txt_mothers_name">Mother's Name:</label>
			<?php echo form_input('txt_mothers_name',set_value('txt_mothers_name'));?><?php echo form_error('txt_mothers_name'); ?>			
		</li>
		<li>
			<label for="txt_spouse_name">Spouse's Name:</label>
			<?php echo form_input('txt_spouse_name',set_value('txt_spouse_name'));?><?php echo form_error('txt_spouse_name'); ?>			
		</li>
		<li>
			<label for="txt_date_of_birth">Date of Birth:</label>
			<?php echo form_input('txt_date_of_birth',set_value('txt_date_of_birth'));?><?php echo form_error('txt_date_of_birth'); ?>			
		</li>
		<li>			
			<label for="cbo_working_area">Working Area:</label>			
			<?php echo form_dropdown('cbo_working_area', $working_areas_options);?>			
		</li> 
		<li>
			<label for="txt_present_addresse">Mother's Name:</label>
			<?php echo form_input('txt_present_address',set_value('txt_present_address'));?><?php echo form_error('txt_present_address'); ?>			
		</li>
		<li>
			<label for="txt_contact_number">Contact Number:</label>
			<?php echo form_input('txt_contact_number',set_value('txt_contact_number'));?><?php echo form_error('txt_contact_number'); ?>			
		</li>		
		<li>
			<label for="txt_last_achieved_degree">Achieved Degree:</label>
			<?php echo form_input('txt_last_achieved_degree',set_value('txt_last_achieved_degree'));?><?php echo form_error('txt_last_achieved_degree');?>		
		</li> 
		<li>
			<label for="txt_no_of_family_member">No of Family Member:</label>
			<?php echo form_input('txt_no_of_family_member',set_value('txt_no_of_family_member'));?><?php echo form_error('txt_no_of_family_member');?>			
		</li> 
		<li>
			<label for="txt_yearly_income">Yearly Income:</label>
			<?php echo form_input('txt_yearly_income',set_value('txt_yearly_income'));?><?php echo form_error('txt_yearly_income');?>			
		</li> 
		<li>
			<label for="txt_national_id">National Id:</label>
			<?php echo form_input('txt_national_id',set_value('txt_national_id'));?><?php echo form_error('txt_national_id');?>			
		</li> 
		<li>
			<label for="txt_nominee_name">Nominee Name:</label>
			<?php echo form_input('txt_nominee_name',set_value('txt_nominee_name'));?><?php echo form_error('txt_nominee_name');?>			
		</li> 
		<li>
			<label for="txt_nominee_relation">Nominee Relation:</label>
			<?php echo form_input('txt_nominee_relation',set_value('txt_nominee_relation'));?><?php echo form_error('txt_nominee_relation');?>			
		</li> 
		<li>
			<label for="txt_nominee_picture">Nominee Picture:</label>
			<?php echo form_input('txt_nominee_picture',set_value('txt_nominee_picture'));?><?php echo form_error('txt_nominee_picture');?>			
		</li> 		
		<li>
			<label for="txt_guarantor_name_1">Guarantor Name:</label>
			<?php echo form_input('txt_guarantor_name_1',set_value('txt_guarantor_name_1'));?><?php echo form_error('txt_guarantor_name_1');?>			
		</li> 
		<li>
			<label for="txt_guarantor_address_1">Guarantor Address:</label>
			<?php echo form_input('txt_guarantor_address_1',set_value('txt_guarantor_address_1'));?><?php echo form_error('txt_guarantor_address_1');?>			
		</li>
		<li>
			<label for="txt_guarantor_relationship_1">Guarantor Relation:</label>
			<?php echo form_input('txt_guarantor_relationship_1',set_value('txt_guarantor_relationship_1'));?><?php echo form_error('txt_guarantor_relationship_1');?>			
		</li>
		<li>
			<label for="txt_guarantor_name_2">Guarantor Name:</label>
			<?php echo form_input('txt_guarantor_name_2',set_value('txt_guarantor_name_2'));?><?php echo form_error('txt_guarantor_name_2');?>			
		</li>
		<li>
			<label for="txt_guarantor_address_2">Guarantor Address:</label>
			<?php echo form_input('txt_guarantor_address_2',set_value('txt_guarantor_address_2'));?><?php echo form_error('txt_guarantor_address_2');?>			
		</li>
		<li>
			<label for="txt_guarantor_relationship_2">Guarantor Relation:</label>
			<?php echo form_input('txt_guarantor_relationship_2',set_value('txt_guarantor_relationship_2'));?><?php echo form_error('txt_guarantor_relationship_2');?>			
		</li>
		<li>
			<label for="txt_member_picture">Member Picture:</label>
			<?php echo form_input('txt_member_picture',set_value('txt_member_picture'));?><?php echo form_error('txt_member_picture');?>			
		</li>
		<li>
			<label for="txt_remarks">Remarks:</label>
			<?php echo form_input('txt_remarks',set_value('txt_remarks'));?><?php echo form_error('txt_remarks');?>			
		</li>
		<li>
			<label for="txt_date_of_death">Date of death:</label>
			<?php echo form_input('txt_date_of_death',set_value('txt_date_of_death'));?><?php echo form_error('txt_date_of_death');?>			
		</li>
		<li>
			<label for="txt_reason_of_death">Reason of death:</label>
			<?php echo form_input('txt_reason_of_death',set_value('txt_reason_of_death'));?><?php echo form_error('txt_reason_of_death');?>			
		</li>
		<li>
			<label for="txt_cancel_date">Cancel Date:</label>
			<?php echo form_input('txt_cancel_date',set_value('txt_cancel_date'));?><?php echo form_error('txt_cancel_date');?>			
		</li>
		<li>
			<label for="txt_cancel_reason">Cancel Reason:</label>
			<?php echo form_input('txt_cancel_reason',set_value('txt_cancel_reason'));?><?php echo form_error('txt_cancel_reason');?>			
		</li>
		<li>
			<label for="txt_cancel_registration_no">Cancel Registration No:</label>
			<?php echo form_input('txt_cancel_registration_no',set_value('txt_cancel_registration_no'));?><?php echo form_error('txt_cancel_registration_no');?>
		</li>
		<li>
			<?php echo form_submit('submit','Save');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
