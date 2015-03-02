<?php
	echo form_open('users/change_password');
	$user=$this->session->userdata('system.user');
	$class_name = 'class="formTitleBar_change_pwd"';
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2>Change Password</h2>
				</div>				
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('users')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>
						<li>
							<label for="login">User Login:<span class="required_field_indicator"></span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'login','class'=>'input_textbox','readonly'=>''),$user['login']);?>
							</div>
                        </li>
                        <li>
							<label for="old_password">User Full Name:<span class="required_field_indicator"></span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'full_name','class'=>'input_textbox','readonly'=>''),$user['name']);?>
							</div>
                        </li>
						<li>
							<label for="old_password">Old Password:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_password(array('name'=>'old_password','class'=>'input_textbox','maxlength'=>'40'),set_value('old_password'));?><?php echo form_error('old_password'); ?>
							</div>
                        </li>
						<li>
							<label for="password">New Password:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_password(array('name'=>'password','class'=>'input_textbox','maxlength'=>'40'),set_value('password'));?><?php echo form_error('password'); ?>
							</div>
						</li>  
						<li>
							<label for="verify_password">Verify New Password:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_password(array('name'=>'verify_password','class'=>'input_textbox','maxlength'=>'40'),set_value('verify_password'));?><?php echo form_error('verify_password'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('users')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
