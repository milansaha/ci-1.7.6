<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
    $is_head_office= array(0=>"No",1=>"Yes");
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('po_branch_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("po_branches/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_branches')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>	
						<li>
							<label for="txt_code">Branch ID:<span class="required_field_indicator">*</span></label>
								<?php 
							$readonly = ($branch_code>1)?"'readonly'='readonly'":"";
							$code_attr = array('name'=>'txt_code','id'=>'txt_code','class'=>'input_textbox','maxlength'=>'50');
							echo form_input($code_attr,set_value('txt_code',isset($row->code)?$row->code:$branch_code),$readonly);?><?php echo form_error('txt_code'); ?>
						</li>
						<li>
							<label for="txt_name">Name:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name',isset($row->name)?$row->name:""));?><?php echo form_error('txt_name'); ?>
							</div>
						</li> 		
						<li>
							<label for="txt_opening_date">Opnening Date:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
							<?php
							if($action=='edit')
								{
									echo form_input(array('name' => 'txt_opening_date', 'readonly'=>'readonly'),set_value('txt_opening_date',isset($row->opening_date)?$row->opening_date:""));
								}
							else{
							echo form_input(array('name' => 'txt_opening_date', 'id' => 'datepicker','class'=>'date_picker'),set_value('txt_opening_date',isset($row->opening_date)?$row->opening_date:""));
							}
							?>
<?php echo form_error('txt_opening_date'); ?>
							</div>
						</li>
						<!--
						<li>
							<label for="txt_branch_images">Branch Image:<em> &nbsp;</em></label>
							<?php //echo form_input('txt_branch_images',set_value('txt_branch_images'));?><?php //echo form_error('txt_branch_images',isset($row->branch_images)?$row->branch_images:""); ?>
						</li>
						-->
                        <li>
							<label for="cbo_is_head_office">Is Head Office:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_is_head_office', $is_head_office,set_value('cbo_is_head_office',isset($row->is_head_office)?$row->is_head_office:""),'id="cbo_is_head_office"');?><?php echo form_error('cbo_is_head_office'); ?>
                            </div>
						</li>
						<li>
							<label for="txt_land_phone">Land Phone:</label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_land_phone','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_land_phone',isset($row->land_phone)?$row->land_phone:""));?><?php echo form_error('txt_land_phone'); ?>
							</div>
						</li>
						<li>
							<label for="txt_mobile_phone">Mobile:</label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_mobile_phone','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_mobile_phone',isset($row->mobile_phone)?$row->mobile_phone:""));?><?php echo form_error('txt_mobile_phone'); ?>
							</div>
						</li>
						<li>
							<label for="txt_email">Email:</label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_email','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_email',isset($row->email)?$row->email:""));?><?php echo form_error('txt_email'); ?>
							</div>
						</li>
						<li>
							<label for="txt_address">Address:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
							<?php echo form_textarea(array('name' => 'txt_address','rows'=>2,'cols'=>50,'class'=>'input_textarea','maxlength'=>'255'),set_value('txt_address', (isset($row->address)?$row->address:"")));?><?php echo form_error('txt_address'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_branches')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
