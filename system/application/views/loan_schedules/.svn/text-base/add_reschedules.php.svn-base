<script type="text/javascript">
	$(function(){
	$("#date_to").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;	
	if($action=='edit')
	{
		$hidden_input=array('txt_id'=>$row->id);		
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}		
	echo form_open("loan_schedules/$action",'',$hidden_input);
	echo form_input(array('name' => 'loan_id','id' => 'loan_id','type'=>'hidden','value'=>$loan_id));
	echo form_input(array('name' => 'installment_no','id' => 'installment_no','type'=>'hidden','value'=>$installment_no));
							
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_schedules')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="date_from">Date from:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'date_from','id' => 'date_from','class'=>'date_picker input_textbox','maxlength'=>'100', 'readonly'=>'readonly','value'=>$date_from));?>
							<div class="hints">YYYY-MM-DD</div>
							<?php echo form_error('date_from'); ?>
							</div>
						</li>
						<li>
							<label for="date_to">Date To:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'date_to','id' => 'date_to','class'=>'date_picker input_textbox','maxlength'=>'100'));?>
							<div class="hints"> YYYY-MM-DD</div>
							<?php echo form_error('date_to'); ?>
							</div>
						</li> 								
					</ol>
				</div>
			</td>
			<td valign="top" style="background:url(<?php echo base_url();?>media/images/alpona.gif) no-repeat bottom right;">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
					
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loan_schedules')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
