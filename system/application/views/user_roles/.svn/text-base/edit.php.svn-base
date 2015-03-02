<?php
echo form_open('user_roles/edit');
echo form_hidden('role_id',$row->id);
?>
<fieldset style="">
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div>
					<?php echo img(array('src'=>base_url().'media/images/edit_big.png','border'=>'0','width'=>'24'))?>
					<h2><?php echo $headline;?></h2>
				</div>				
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('user_roles')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="role_name">Role Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_role_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_role_name',$row->role_name));?><?php echo form_error('txt_role_name'); ?>
                            </div>
						</li> 
						<li>
							<label for="role_description">Role Description:</label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_role_description','class'=>'input_textbox','maxlength'=>'255'),set_value('txt_role_description',$row->role_description));?><?php echo form_error('txt_role_description'); ?>
                            </div>
						</li> 
					</ol>
				</div>
			</td>
			<td valign="top" style="background:url(<?php echo base_url();?>media/images/alpona.gif) no-repeat bottom right;">
				<p class="helper"></p>
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('user_roles')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
