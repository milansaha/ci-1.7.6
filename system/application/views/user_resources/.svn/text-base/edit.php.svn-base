<?php
	echo form_open('user_resources/edit');
	echo form_hidden('id',$row->id);
?>
<fieldset>
	<legend>
		Edit User Resource
	</legend>
	<ol>  
		<li>
			<label for="txt_title">Title:<em>*</em></label>
			<?php echo form_input('txt_title',set_value('txt_title',$row->title));?><?php echo form_error('txt_title'); ?>
		</li> 
		<li>
			<label for="cbo_resource_group">Resource Group:<em>*</em></label>			
			<?php echo form_dropdown('cbo_resource_group', $resource_gruop_list,$row->user_resource_group_id); ?><?php echo form_error('cbo_resource_group'); ?>			
		</li> 
		<li>
			<label for="cbo_controller">Controller Name:<em>*</em></label>			
			<?php echo form_dropdown('cbo_controller', $controller_list,$row->controller); ?><?php echo form_error('cbo_controller'); ?>			
		</li>
		<li>
			<label for="txt_action">Action Name:<em>*</em></label>
			<?php echo form_input('txt_action',set_value('txt_action',$row->action));?><?php echo form_error('txt_action'); ?>
		</li>
		<li>
			<label for="txt_order">Display Order:<em>*</em></label>
			<?php echo form_input('txt_order',set_value('txt_order',$row->order));?><?php echo form_error('txt_order'); ?>
		</li>  
		<li>
			<label for="chk_enabled">Enabled:<em> &nbsp;</em></label>
			<?php echo form_checkbox('chk_enabled','TRUE',set_value('chk_enabled',$row->is_enabled));?><?php echo form_error('chk_enabled'); ?>			
		</li>		
		<li>			
			<?php echo form_submit('submit','Save');?>
		</li>
	</ol>
</fieldset>
<?php 
echo form_close();
?>
