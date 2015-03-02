<?php
	//user roles
	$user_role_options = array();
	foreach($user_roles as $user_role)
	{					
		$user_role_options[$user_role->id]=$user_role->role_name;
	}
	//Branches	
	$user_default_branch_options = array();
	foreach($user_default_branches as $branch)
	{					
		$user_default_branch_options[$branch->branch_id]=$branch->branch_name;
	}
	//User status
	$current_status_options=array();
	$current_status_options['active']='Active';
	$current_status_options['inactive']='Inactive';
	$class_name = 'class="formTitleBar_edit"';
	$select_class = 'class="input_select"';
	echo form_open('users/edit');
	echo form_hidden('user_id',$row->id);
?>
<fieldset style="">
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2><?php echo $headline;?></h2>
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
							<label for="full_name">Full Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_full_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_full_name',$row->full_name));?><?php echo form_error('txt_full_name'); ?>
                            </div>
						</li> 
						<li>
							<label for="user_name">Login:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_login','class'=>'input_textbox','maxlength'=>'40'),set_value('txt_login',$row->login));?><?php echo form_error('txt_login'); ?>
                            </div>
						</li>
						<li>
							<label for="password">Password:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_password(array('name'=>'txt_password','class'=>'input_textbox','maxlength'=>'40'),set_value('txt_password',$row->password));?><?php echo form_error('txt_password'); ?>
                            </div>
						</li>
						<li>
							<label for="verify_password">Verify Password:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_password(array('name'=>'txt_verify_password','class'=>'input_textbox','maxlength'=>'40'),set_value('txt_verify_password',$row->password));?><?php echo form_error('txt_verify_password'); ?>
                            </div>
						</li>  	
						<li>
							<label for="cbo_role_id">Role:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_role_id', $user_role_options,set_value('cbo_role_id',$row->role_id),$select_class); ?>
                            </div>
						</li>
						<li>
							<label for="cbo_default_branch_id">Default Branch:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_default_branch_id', $user_default_branch_options,set_value('cbo_default_branch_id',$row->default_branch_id),$select_class); ?>
                            </div>
						</li>
						<li>
						<label for="current_status">Current Status:<span class="required_field_indicator">*</span></label>
                        <div class="form_input_container">
						<?php echo form_dropdown('cbo_current_status',$current_status_options,set_value('cbo_current_status',$row->current_status),$select_class);?><?php echo form_error('cbo_current_status'); ?>
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
