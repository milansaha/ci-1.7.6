<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	$("#joining_datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	$("#discontinue_datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});

</script>
	<script type="text/javascript">
// dropdown list by JSON
$(document).ready(function()
	{	
		// Samity wise Field Officer Name
		$("#samity_id").change(function()
		{
			$("#status").html("<center></center><img border='0' src='<?php echo base_url();?>/media/images/loading.gif' /><br/>Loading... Please wait ...</center>");
			var selected_from_employee = $("#samity_id").val();
			$.post("<?php echo site_url('samity_employee_changes/ajax_for_get_old_field_officer_list') ?>", { samity_id: selected_from_employee },
			//alert($.post);
			function(data)
			{
				$('#status').html("");
				$('#old_field_officer').attr('value',"");
				$('#old_field_officer_id').attr('value',"");
				if( data.status == 'failure' )
				{
					alert(data.message);
				}
				else
				{
					//alert(data);
					$('#old_field_officer').attr('value',data.emp_name);
					$('#old_field_officer_id').attr('value',data.emp_id);
				}	
			}, "json");
		});
	});
</script>

<?php 
	//Employee list	
	$employee_options= array(""=>"--Select--");
	foreach($employee_list as $employee_row)
	{					
    	$employee_options[$employee_row->id]=$employee_row->name; 	
	}
	//Samity list	
	//echo '<pre>';print_r($samities);
	$samity_options= array(""=>"--Select--");
	foreach($samities as $samity_row)
	{					
    	$samity_options[$samity_row->samity_id]=$samity_row->samity_name; 	
	}
    //Current Branch list
	$new_branch_options= array(""=>"--Select--");
	foreach($new_branch as $new_branch_row)
	{					
		$new_branch_options[$new_branch_row->id]=$new_branch_row->name;
	}
	
	echo form_open('samity_employee_changes/edit');	
    $img_name = '/media/images/edit_big.png';
    $class_name = 'class="formTitleBar_edit"';
?>
<fieldset>
<div id="status" style="/*background-color: #2E2E2E;
    color: white;
    font-size: 24px;
    height: 900px;
    left: 0;
    opacity: 0.6;
    position: absolute;
    text-align: center;
    top: 0;
    width: 100%;*/position:absolute;top:50%;left:45%;"></div>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_employee_changes')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="cbo_employee">Samity Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php //echo form_hidden(array('id'=>'samity_employee_changes_id', 'name'=>'samity_employee_changes_id'),set_value('samity_employee_changes_id',(isset($row->id)?$row->id:"")));?>
							<input type="hidden" name="samity_employee_changes_id" id="samity_employee_changes_id" value="<?php echo isset($row->id)?$row->id:""?>"/> 
							<?php echo form_dropdown('cbo_samity',$samity_options,set_value('cbo_samity',isset($row->samity_id)?$row->samity_id:""),'id="samity_id"','calss="input_select"'); ?>
							 </div>
						</li> 
						<li>	
							<label for="txt_old_field_officer">Old Field Officer:<em>&nbsp;</em></label>	
							<?php echo form_input(array('id'=>'old_field_officer', 'name'=>'txt_old_field_officer', 'readonly'=>'readonly'),set_value('txt_old_field_officer',(isset($row->previous_employee_name)?$row->previous_employee_name:"")));?>
							<input type="hidden" name="txt_old_field_officer_id" id="old_field_officer_id" value="<?php echo isset($row->previous_employee_id)?$row->previous_employee_id:""?>"/> 
							<?php echo anchor('po_branches/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Branch')),array('class'=>'addimglink','alt'=>'Add Branch','title'=>'Add Branch'));  ?>
							<?php echo form_error('txt_old_branch_name'); ?>
						</li>	 
						<li>	
							<label for="cbo_new_field_officer">New Field Officer:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_new_field_officer', $employee_options,set_value('cbo_new_field_officer', (isset($row->new_employee_id)?$row->new_employee_id:"")),'calss="input_select"');?>
							<?php echo anchor('po_branches/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Branch')),array('class'=>'addimglink','alt'=>'Add Branch','title'=>'Add Branch'));  ?>
							<?php echo form_error('cbo_new_branch'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_effective_date">Effective Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_effective_date','id' => 'datepicker'),set_value('txt_effective_date',(isset($row->effective_date)?$row->effective_date:"")));?>
							<?php echo form_error('txt_effective_date'); ?>
							</div>
						</li>
						<li>
							<label for="txt_comments">Comments:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_textarea(array('name' => 'txt_comments','id' => 'txt_comments','calss'=>"input_textarea",'maxlength'=>"200",'rows'=> '1','cols'=>'8','style'=>'width:277px;height:50px;'),set_value('txt_comments',isset($row->comment)?$row->comment:""));?>
							<?php echo form_error('txt_comments'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samity_employee_changes')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
				
</fieldset>
<?php echo form_close(); ?>
