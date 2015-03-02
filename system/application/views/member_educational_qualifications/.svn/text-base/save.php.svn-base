<?php
	$action = $this->uri->segment(2);
	$hidden_input = null;
	if($action == 'edit')
	{
		$hidden_input = array('txt_id'=>$row->id);
	}
	echo form_open("member_educational_qualifications/$action",'',$hidden_input);
?>
<fieldset>
	<legend>Member Educational Qualifications's details</legend>
	<ol>  
		<li>
			<label for="name">Name:<em>&nbsp;</em></label>
			<?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','class'=>'required'),set_value('txt_name',isset($row->name)?$row->name:""));?><?php echo form_error('txt_name'); ?>	
		</li> 		
		<li>
			<?php echo form_submit('submit','Save');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
	var txt_name = new LiveValidation('txt_name', { validMessage: " ", onlyOnBlur: false });
	txt_name.add( Validate.Presence );
</script>	
