<?php
	$img_name = '/media/images/add_big.png';
	echo form_open('employee_departments/add');
	$class_name = 'class="formTitleBar_add"';
?>
<script src="<?php echo base_url()?>media/js/livevalidation_standalone.compressed.js"></script>
<script type="text/javascript">
	var f1 = new LiveValidation('txt_name');
	f1.add(Validate.Presence);
	//Validate.Presence( 'hello world', { failureMessage: "Supply a value!" } );
</script>
<style type="text/css"> 
.LV_validation_message{
	font-weight:bold;
	margin:0 0 0 5px;
	background-color: #FFFFFF;
}
 
.LV_valid {
	color:#00CC00;
	
}
	
.LV_invalid {
	color:#CC0000;
	
	}
    
.LV_valid_field,
input.LV_valid_field:hover, 
input.LV_valid_field:active,
textarea.LV_valid_field:hover, 
textarea.LV_valid_field:active {
    border: 2px solid #00CC00;
}
    
.LV_invalid_field, 
input.LV_invalid_field:hover, 
input.LV_invalid_field:active,
textarea.LV_invalid_field:hover, 
textarea.LV_invalid_field:active {
    border: 2px solid #CC0000;
}
  
 </style> 
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_departments')."'"));?>
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
								<?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_name'));?>
								<?php echo form_error('txt_name'); ?>	
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_departments')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
