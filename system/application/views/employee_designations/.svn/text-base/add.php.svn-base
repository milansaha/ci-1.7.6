<?php
$is_manager= array(1=>"Yes",0=>"No");
	//Combo data for Department
	$options[""] = "--------SELECT---------";
	foreach($departments as $department)
	{					
		$options[$department->department_id]=$department->department_name;
	}
	//Open form
	echo form_open('employee_designations/add');
	$class_name = 'class="formTitleBar_add"';
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2>Add Designation</h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_designations')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="cbo_department">Department:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_department', $options); ?>
							<?php //echo anchor('employee_departments/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Department')),array('class'=>'addimglink','alt'=>'Add Department','title'=>'Add Department'));  ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Department','width'=>'12px')), 'add_department', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Department','onclick'=>"window.location.href='".site_url('employee_departments/add')."'"));?></div>
							<?php echo form_error('cbo_department'); ?>	
							</div>			
						</li>
						<li>
							<label for="txt_name">Designation Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','maxlenght'=>'100','class'=>'input_textbox'),set_value('txt_name'));?>
								<?php echo form_error('txt_name'); ?>
							</div>
						</li>
						<li>
							<label for="cbo_is_manager">Is Manager:</label>
                            <div class="form_input_container">
								<?php echo form_dropdown('cbo_is_manager', $is_manager,isset($row->is_manager)?$row->is_manager:"",'id="cbo_is_manager"');?>
								<?php echo form_error('cbo_is_manager'); ?>
                            </div>
						</li>
						<li>
							<label for="txt_code">Code:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_input(array('name'=>'txt_code','id'=>'txt_code','maxlenght'=>'100','class'=>'input_textbox'),set_value('txt_code'));?>
								<?php echo form_error('txt_code'); ?>
							</div>
						</li>
						<li>
							<label for="txt_short_name">Short Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_input(array('name'=>'txt_short_name','id'=>'txt_short_name','maxlenght'=>'100','class'=>'input_textbox'),set_value('txt_short_name'));?>
								<?php echo form_error('txt_short_name'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_designations')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
