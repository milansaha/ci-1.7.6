<script type="text/javascript">
$(document).ready(function() {
$("#cbo_division").change(
	function(){
		// start json
		// savings information
		
		var selected_division_id = $("#cbo_division").val();				
		//alert(selected_division_id);
		
		$.post("<?php echo site_url('po_thanas/ajax_for_get_district_by_division') ?>", { division_id: selected_division_id},
			function(data)
				{
					$('#status').html("");
					$('#cbo_district').empty();
					$('#cbo_district').append('<option value = "">--Select--</option>');
					if( data.status == 'failure' )
					{
						//alert(data.message);					
					}
					else
					{
						//alert(data.district.id);
						//$('#from_samity_row').removeAttr('style');
						for(var i = 0; i < data.district.id.length; i++)
						{
							$('#cbo_district').append('<option value = \"' + data.district.id[i] + '\">' + data.district.name[i] + '</option>');
						
						}
					}
				}, "json")
		});		
});
</script>		
<?php 
	//Division list
	$division_options = array("" => "--Select--");
	foreach($divisions as $division_row)
	{					
		$division_options[$division_row->id]=$division_row->name;
	}
	$district_options = array(""=>"--Select--");
	//print_r($districts);
	foreach($districts as $district)
	{					
		$district_options[$district->id]=$district->name;
	}
?>
	<?php
	$img_name = '/media/images/add_big.png';
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('thana_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("po_thanas/$action",'',$hidden_input);
?>
<style>
.label_adder{float:left;}
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_thanas')."'"));?>
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
							<?php echo form_input(array('name'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name', (isset($row->name)?$row->name:"")));?><?php echo form_error('txt_name'); ?>
                            </div>
						</li> 
						<li>
							<label 	for="cbo_division">Division:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_division', $division_options, set_value('cbo_division', (isset($row->division_id)?$row->division_id:"")),'id="cbo_division" class="input_select"'); ?>
							<?php //echo anchor('po_divisions/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Division')),array('class'=>'addimglink','alt'=>'Add Division','title'=>'Add Division'));  ?>
                             <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Division','width'=>'12px')), 'add_division', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Division','onclick'=>"window.location.href='".site_url('po_divisions/add')."'"));?></div>
							<?php echo form_error('cbo_division'); ?>
                            </div>
						</li> 
						<li>
							<label 	for="cbo_district">District:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_dropdown('cbo_district', $district_options, set_value('cbo_district', (isset($row->district_id)?$row->district_id:"")),'id="cbo_district" class="input_select"'); ?>
                            <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add District','width'=>'12px')), 'add_district', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add District','onclick'=>"window.location.href='".site_url('po_districts/add')."'"));?></div>
							<?php echo form_error('cbo_district'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_thanas')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
