<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('loan_product_category_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("loan_product_categories/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_product_categories')."'"));?>
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
							<?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_name',isset($row->name)?$row->name:""));?><?php echo form_error('txt_name'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_short_name">Short Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_short_name','id'=>'txt_short_name','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_short_name',isset($row->short_name)?$row->short_name:""));?><?php echo form_error('txt_short_name'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_product_categories')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	<?php if (form_error('txt_name') != '') { ?>
		$("#txt_name").focus();
	<?php } elseif (form_error('txt_short_name') != '') { ?>
		$("#txt_short_name").focus();
	<?php } else { ?>
		$("#txt_name").focus();
	<?php } ?>
});
</script>
