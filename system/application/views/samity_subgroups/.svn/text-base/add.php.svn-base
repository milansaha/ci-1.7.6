<?php
$img_name = '/media/images/add_big.png';
$group_options = array("" => "------Select------");
	foreach($samity_group_infos as $subgroup_info)
	{					
		$group_options[$subgroup_info->group_id]=$subgroup_info->group_name;
	}
echo form_open('samity_subgroups/add');
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_subgroups')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  		
						<li>
							<label for="cbo_group">Group Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_group', $group_options,'calss="input_select"');?>
							<?php echo anchor('samity_subgroups/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Group')),array('class'=>'addimglink','alt'=>'Add Group','title'=>'Add Group'));  ?>
							<?php echo form_error('cbo_group'); ?>
							</div>			
						</li> 
						<li>
							<label for="txt_name">Subgroup Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input('txt_name',set_value('txt_name'),'calss="input_textbox"','maxlength="100"');?><?php echo form_error('txt_name'); ?>
							</div>	
						</li> 
						<li>
							<label for="txt_subgroup_code">Subgroup Code:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input('txt_subgroup_code',set_value('txt_subgroup_code'),'calss="input_textbox"','maxlength="20"');?><?php echo form_error('txt_subgroup_code'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_subgroups')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
