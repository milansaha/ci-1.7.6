<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
	$samity_options = array(''=>"--------Select--------");
	foreach($samities as $samity_row)
	{					
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	
		$class_name = 'class="formTitleBar_add"';

			
	echo form_open("samity_closings/close");
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_closings')."'"));?>
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
							<?php 	echo form_dropdown('cbo_samity',$samity_options,set_value('cbo_samity',isset($row->samity_id)?$row->samity_id:""),'id="cbo_samity"','calss="input_select"');?>
							<?php echo form_error('cbo_samity'); ?>
							</div>
						</li> 		
						<li>
							<label for="txt_closing_date">Closing Date:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">                               
                                <?php echo form_input(array('name' => 'txt_closing_date', 'id' => 'datepicker','class'=>"date_picker"),set_value('txt_closing_date', (isset($row->closing_date)?$row->closing_date:"")));?>	
                                <div class="hints"> YYYY-MM-DD</div>
                                <?php echo form_error('txt_closing_date'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_closings')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
<!--
<script type="text/javascript">
	var txt_name = new LiveValidation('txt_name', { validMessage: " ", onlyOnBlur: false });
	txt_name.add( Validate.Presence );
</script>	
-->
