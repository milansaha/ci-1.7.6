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
		// employee wise Branch
		$("#employee_id").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_from_employee = $("#employee_id").val();
			$.post("<?php echo site_url('employee_branch_transfers/ajax_for_get_old_branch_list') ?>", { employee_id: selected_from_employee },
			function(data)
			{
				$('#status').html("");
				$('#old_branch_name').attr('value',"");
				$('#old_branch_id').attr('value',"");
				if( data.status == 'failure' )
				{
					alert(data.message);
				}
				else
				{
					$('#old_branch_name').attr('value',data.branch_name);
					$('#old_branch_id').attr('value',data.branch_id);										
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
    	$employee_options[$employee_row->id]=$employee_row->name.'-'.$employee_row->code; 	
	}
    //Current Branch list
	$new_branch_options= array(""=>"--Select--");
	foreach($new_branch as $new_branch_row)
	{					
		$new_branch_options[$new_branch_row->id]=$new_branch_row->name;
	}
	
	echo form_open('employee_branch_transfers/add');	
    $img_name = '/media/images/add_big.png';
    $class_name = 'class="formTitleBar_add"';
?>
<fieldset>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_branch_transfers')."'"));?>
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
							<?php $js = 'id="employee_id"';
							 echo form_dropdown('cbo_employee', $employee_options,set_value('cbo_employee', (isset($row->employee_name)?$row->employee_name:"")),$js);?>							 
							 <?php //echo anchor('employees/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee')),array('class'=>'addimglink','alt'=>'Add Employee','title'=>'Add Employee'));  ?>
							 <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee','width'=>'12px')), 'add_employee', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Employee','onclick'=>"window.location.href='".site_url('employees/add')."'"));?></div>
							 <?php echo form_error('cbo_employee'); ?>
							 </div>
						</li> 
						<li>	
							<label for="txt_old_branch">Old Branch:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">	
							<?php echo form_input(array('id'=>'old_branch_name', 'name'=>'txt_old_branch_name', 'readonly'=>'readonly','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_old_branch_name',(isset($row->old_branch_id)?$new_branch_options[$row->old_branch_id]:"")));?>
							<input type="hidden" name="txt_old_branch_id" id="old_branch_id" value="<?php echo isset($row->old_branch_id)?$row->old_branch_id:""?>"/> 
							<?php //echo anchor('po_branches/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Branch')),array('class'=>'addimglink','alt'=>'Add Branch','title'=>'Add Branch'));  ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Branch','width'=>'12px')), 'add_branch', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Branch','onclick'=>"window.location.href='".site_url('po_branches/add')."'"));?></div>
							<?php echo form_error('txt_old_branch_id'); ?>
							</div>
						</li>	
								 
						<li>	
							<label for="cbo_new_branch">Current Branch:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_new_branch', $new_branch_options);?>
							<?php //echo anchor('po_branches/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Branch')),array('class'=>'addimglink','alt'=>'Add Branch','title'=>'Add Branch'));  ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Branch','width'=>'12px')), 'add_branch', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Branch','onclick'=>"window.location.href='".site_url('po_branches/add')."'"));?></div>
							<?php echo form_error('cbo_new_branch'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_effective_date">Effective Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_effective_date','id' => 'datepicker','class'=>"date_picker",'maxlength'=>'100','class'=>'input_textbox'),set_value('txt_effective_date'));?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_branch_transfers')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
				
</fieldset>
<?php echo form_close(); ?>
