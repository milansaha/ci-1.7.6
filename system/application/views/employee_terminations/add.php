<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	$("#joining_datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	$("#discontinue_datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>

<?php 
	//employee list	
	$employee_options = array(''=>'--------Select-------');

	foreach($employee_info as $employee_row)
	{					

		$employee_options[$employee_row->id]=$employee_row->name.' - '.$employee_row->code;

	}
	//Form start
	echo form_open('employee_terminations/add');
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_terminations')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
				<ol>  
					<li>	
						<label for="cbo_employee">employee Name:<span class="required_field_indicator">*</span></label>
						<div class="form_input_container">
						<?php echo form_dropdown('cbo_employee', $employee_options);?><?php echo form_error('cbo_employee'); ?>							
						<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee','width'=>'12px')), 'add_employee', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Employee','onclick'=>"window.location.href='".site_url('employees/add')."'"));?></div>
						</div>
					</li> 
					<li>
						<label for="txt_transfer_date">Termination Date:<span class="required_field_indicator">*</span></label>
						<div class="form_input_container">
						<?php echo form_input(array('name' => 'txt_effective_date','id' => 'datepicker','class'=>'date_picker','class'=>"date_picker",'maxlength'=>'100','class'=>'input_textbox'),set_value('txt_effective_date'));?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_terminations')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
