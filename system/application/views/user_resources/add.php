<?php
	//Open form
	echo form_open('user_resources/add');
?>
<fieldset>
	<legend>
		Add User Resource
	</legend>
	<ol>  
		<li>
			<label for="txt_title">Title:<em>*</em></label>
			<?php echo form_input('txt_title',set_value('txt_title'));?><?php echo form_error('txt_title'); ?>		
		</li>
		<li>
			<label for="cbo_resource_group">Resource Group:<em>*</em></label>			
			<?php echo form_dropdown('cbo_resource_group', $resource_gruop_list); ?><?php echo form_error('cbo_resource_group'); ?>				
		</li>
		<li>
			<label for="cbo_controller">Controller:<em>*</em></label>			
			<?php echo form_dropdown('cbo_controller', $controller_list); ?><?php echo form_error('cbo_controller'); ?>				
		</li>
		<li>
			<label for="chk_action">Create Default Actions (index,add,edit,delete): <em>*</em></label>
			<?php echo form_checkbox(array('id'=>'chk_action','name'=>'chk_action','value' => 'accept','checked'=> FALSE));?>		
		</li> 
		<li>
			<label for="txt_action">Action: <em>*</em></label>
			<?php echo form_input('txt_action',set_value('txt_action'),'id=txt_action');?><?php echo form_error('txt_action'); ?>			
		</li> 
		<li>
			<label for="txt_order">Dispaly order:<em> &nbsp;</em></label>
			<?php echo form_input('txt_order',set_value('txt_order'));?><?php echo form_error('txt_order'); ?>			
		</li>
		<li>
			<label for="chk_enabled">Enabled:<em> &nbsp;</em></label>
			<?php echo form_checkbox('chk_enabled',null,TRUE,set_value('chk_enabled'));?><?php echo form_error('chk_enabled'); ?>			
		</li>
		<li>
			<?php echo form_submit('submit','Save');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close();?>

<script type="text/javascript">
$(document).ready(function(){
	$('#chk_action').click(function(){
		if ($('#txt_action').attr('readonly')==false){
			$('#txt_action').val('index,add,edit,delete');
			$('#txt_action').attr('readonly', true);
		}else{
			$('#txt_action').attr('readonly', false);
			$('#txt_action').val('');
		}
	});
});
</script>
