<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<script type="text/javascript">
// dropdown list by JSON
$(document).ready(function()
	{	
		// employee wise Branch
		$("#employee_id").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_from_employee = $("#employee_id").val();
			$.post("<?php echo site_url('employee_promotions/ajax_for_get_old_designation_list') ?>", { employee_id: selected_from_employee },
			function(data)
			{
				$('#status').html("");
				$('#old_designation_name').attr('value',"");
				$('#old_designation_id').attr('value',"");
				if( data.status == 'failure' )
				{
					alert(data.message);
				}
				else
				{
					//$('#from_samity_row').removeAttr('style');
					$('#old_designation_name').attr('value',data.designation_name);
					$('#old_designation_id').attr('value',data.designation_id);										
				}	
			}, "json");
		});
	});
</script>
<?php 
	//Employee list	
	$employee_options = array(""=>"--select--");
	foreach($employee_list as $employee_row)
	{					
    	$employee_options[$employee_row->id]=$employee_row->name; 		
	}	
	
	$new_designation_options = array(""=>"--select--");
	foreach($new_designation as $new_designation_row)
	{					
		$new_designation_options[$new_designation_row->id]=$new_designation_row->name;
	}
	echo form_open('employee_promotions/edit');
	echo form_hidden('employee_promotion_id',$row->id);	
    $img_name = '/media/images/edit_big.png';
    $class_name = 'class="formTitleBar_edit"';
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_promotions')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>	
							<label for="cbo_employee">Employee Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<input type="text" readonly="readonly" name="cbo_employee" id="employee_id" maxlength="100" class="input_textbox" value="<?php echo $employee_options[$row->employee_id];?>"/> 
							<input type="hidden" name="cbo_employee" id="employee_id" value="<?php echo $row->employee_id;?>"/> 
							<?php //$js = 'id="employee_id"'; echo  form_dropdown('cbo_employee', $employee_options,$row->employee_id,$js);?>
							<?php //echo anchor('employees/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee')),array('class'=>'addimglink','alt'=>'Add Employee','title'=>'Add Employee'));  ?>	
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee','width'=>'12px')), 'add_employee', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Employee','onclick'=>"window.location.href='".site_url('employees/add')."'"));?></div>
							<?php echo form_error('cbo_employee'); ?>
							</div>		
						</li>
						<li>	
							<label for="txt_old_designation">Old Designation:<em>&nbsp;</em></label>			
							<?php echo form_input(array('id'=>'old_designation_name','name'=>'cbo_new_designation', 'readonly'=>'readonly','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_new_designation_id',$new_designation_options[$row->old_designation_id]));?>
							<input type="hidden" name="txt_old_designation_id" id="old_designation_id" value="<?php echo $row->old_designation_id;?>"/> 
							<?php //echo anchor('employee_designations/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Designation')),array('class'=>'addimglink','alt'=>'Add Designation','title'=>'Add Designation'));  ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Designation','width'=>'12px')), 'add_designation', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Designation','onclick'=>"window.location.href='".site_url('employee_designations/add')."'"));?></div>
						</li> 					
						<li>	
							<label for="cbo_new_designation">New Designation:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_new_designation', $new_designation_options,$row->new_designation_id);?>
							<?php //echo anchor('employee_designations/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Designation')),array('class'=>'addimglink','alt'=>'Add Designation','title'=>'Add Designation'));  ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Designation','width'=>'12px')), 'add_designation', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Designation','onclick'=>"window.location.href='".site_url('employee_designations/add')."'"));?></div>
							<?php echo form_error('cbo_new_designation'); ?>
							</div>			
						</li> 
						<li>
							<label for="txt_effective_date">Effective Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_effective_date','id' => 'datepicker','class'=>'date_picker','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_effective_date',$row->effective_date));?>
							<div class="hints"> YYYY-MM-DD</div>
							<?php echo form_error('txt_effective_date'); ?>	
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_promotions')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
