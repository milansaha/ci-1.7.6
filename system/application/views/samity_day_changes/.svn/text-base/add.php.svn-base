<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/test.css" />-->
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script><script type="text/javascript">
$(document).ready(function() {
		$("#samity_info").autocomplete('<?php echo site_url("samities/ajax_get_samity_list_auto/")?>', {
			minChars: 0,
			width: 310,
			matchContains: "word",
			highlightItem: true,
			formatItem: function(row, i, max, term) {
				var tmp;
				tmp=row[0].split(",");
				return "<strong>"+tmp[2]+' - '+tmp[1]+"</strong>" + "</span>";
			},
			
			formatResult: function(row) {
				var tmp;
				tmp=row[0].split(",");
				return tmp[2]+' - '+tmp[1];
			}
		}).result(function(e, item) {
			//myCallback();
			var tmp;
			tmp=item[0].split(",");
			// JSON part
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_samity_id = tmp[0];
			//alert(selected_samity_id);
			$.post("<?php echo site_url('samities/ajax_for_get_samity_info_by_id') ?>", { samity_id: selected_samity_id },
			function(data)
			{
				//alert(data);	
				$('#status').html("");
				$('#test').empty();
				$('#current_saving_info').empty();
				$('#samity_info1').empty();				
				if( data.status == 'failure' )
				{
					alert(data.message);					
				}
				else
				{
					//alert(data.samity.samity_day);				
					$('#samity_id').attr('value',data.samity.id);									
					$('#old_samity_day').attr('value',data.samity.samity_day);				
					$('#samity_info1').append("<p>Current Samity Day : <b>" + data.samity.samity_day+"</b> </p>");									
				}
			}, "json");
		});		
});
</script>
<script type="text/javascript">
	$(function(){
	$("#txt_effective_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>	
<?php
//Samity list
	$samity_options = array("" => "------Select------");
	foreach($samities_info as $samities_info)
	{					
		$samity_options[$samities_info->id]=$samities_info->name;
	}
	//Combo data for Samity Day
	$samity_day_options[''] = '--------SELECT--------';	
	foreach($samity_days as $kay=>$value)
	{		
		$samity_day_options[$kay]=$value;
	}
    $img_name = '/media/images/add_big.png';
	echo form_open('samity_day_changes/add');
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_day_changes')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  		
						<li>	
							<label for="cbo_samity">Samity Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">			
							<input type="hidden" name="samity_id" id="samity_id" 'calss="input_textbox"' value="<?php echo isset($row->samity_id)?$row->samity_id:'' ?>" />					
							<input type="hidden" name="old_samity_day" id="old_samity_day" value="" />
							<input type="text" id="samity_info" value="" />
							<?php echo form_error('samity_id'); ?>	
							</div>
							<!--<div><div id="samity_info1"></div></div>-->
						</li> 
						<li>
							<label for="cbo_samity_day">New Samity Day:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">		
							<?php echo form_dropdown('cbo_samity_day', $samity_day_options,'calss="input_select"'); ?>
							<?php echo form_error('cbo_samity_day'); ?>	
							</div>
						</li>
						<li>
							<label for="txt_effective_date">Effective Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_effective_date','id'=>'txt_effective_date','class'=>'date_picker'),set_value('txt_effective_date'));?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_day_changes')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
