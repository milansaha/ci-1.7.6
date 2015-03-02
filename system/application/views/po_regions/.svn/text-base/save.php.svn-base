<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('txt_region_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("po_regions/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_regions')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>
						<li>
							<label for="name">Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name',isset($row->name)?$row->name:""));?><?php echo form_error('txt_name'); ?>
                            </div>
						</li>
                        <li>
							<label for="name">Code:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_code','id'=>'txt_code','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_code',isset($row->code)?$row->code:""));?><?php echo form_error('txt_code'); ?>
                            </div>
						</li>
						<li>
							<label for="cbo_zone_list">Zone:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_multiselect('cbo_zone_list[]', $zone_infos, set_value('cbo_zone_list', (isset ($selected_zone)?$selected_zone:'')),'id="cbo_zone_list" class="input_select" size="10"'); ?>
                            <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Zone','width'=>'12px')), 'add_zone', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Zone','onclick'=>"window.location.href='".site_url('po_zones/add')."'"));?></div>
							<?php echo form_error('cbo_zone_list[]'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_regions')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
