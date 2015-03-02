<?php
$img_name = '/media/images/add_big.png';
echo form_open('po_funding_organizations/add');
$class_name = 'class="formTitleBar_add"';
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2><?php echo $headline?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_funding_organizations')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="txt_name">Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name'));?><?php echo form_error('txt_name'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_concern_person">Concern Person:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_concern_person','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_concern_person'));?><?php echo form_error('txt_concern_person'); ?>
							</div>
						</li>	
						<li>
							<label for="txt_address">Address:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_address','class'=>'input_textbox','maxlength'=>'255'),set_value('txt_address'));?><?php echo form_error('txt_address'); ?>
							</div>
						</li>	
						<li>
							<label for="txt_land_phone">Phone:</label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_land_phone','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_land_phone'));?><?php echo form_error('txt_land_phone'); ?>
							</div>	
						</li>	
						<li>
							<label for="txt_mobile_phone">Mobile:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_mobile_phone','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_mobile_phone'));?><?php echo form_error('txt_mobile_phone'); ?>
							</div>
						</li>	
						<li>
							<label for="txt_email">Email:</label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_email','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_email'));?><?php echo form_error('txt_email'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_funding_organizations')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
