<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
//echo $this->validation->error_string;
echo form_open('po_organizations/add');
?>
<fieldset>
	<legend>
		PO Organization Details
	</legend>
	<ol>  
		<li>
			<label for="txt_name">Name:<em>&nbsp;</em></label>
			<?php echo form_input('txt_name',set_value('txt_name'));?><?php echo form_error('txt_name'); ?>		
		</li> 
		<li>
			<label for="txt_organaization_code">Organization Code:<em> &nbsp;</em></label>
			<?php echo form_input('txt_organaization_code',set_value('txt_organaization_code'));?><?php echo form_error('txt_organaization_code'); ?>			
		</li>	
		<li>
			<label for="txt_head_of_the_po">Head of the PO:<em> &nbsp;</em></label>
			<?php echo form_input('txt_head_of_the_po',set_value('txt_head_of_the_po'));?><?php echo form_error('txt_head_of_the_po'); ?>			
		</li>	
		<li>
			<label for="txt_established_date">Established Date:</label>
			<?php echo form_input(array('name' => 'txt_established_date', 'id' => 'datepicker'),set_value('txt_established_date'));?><?php echo form_error('txt_established_date'); ?>			
		</li>	
		<li>
			<label for="file_logo">Logo:<em> &nbsp;</em></label>
			<?php echo form_input('file_logo',set_value('file_logo'));?><?php echo form_error('file_logo'); ?>			
		</li>	
		<li>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Save');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
