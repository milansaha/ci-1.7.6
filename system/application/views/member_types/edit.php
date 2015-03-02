<?php
echo form_open('member_types/edit');
echo form_hidden('member_id',$row->id);
?>
<fieldset>
	<legend>
		Edit Member type
	</legend>
	<ol>  
		<li>
			<label for="txt_name">Name:<em>&nbsp;</em></label>
			<?php echo form_input('txt_name',set_value('txt_name',$row->name));?><?php echo form_error('txt_name'); ?>
		</li> 
		<li>			
			<?php echo form_submit('submit','Save');?>
		</li>
	</ol>
</fieldset>
<?php 
echo form_close();
?>
