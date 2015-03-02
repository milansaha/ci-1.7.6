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
		// branch wise samity
		$("#employee_id").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var current_product=[];
			var selected_employee_id = $("#employee_id").val();
			//alert(selected_employee_id);
			$.post("<?php echo site_url('employee_product_transfers/ajax_for_get_product_list_by_employee') ?>", { employee_id: selected_employee_id },
			
			function(data)
			{
				if($('input[type=checkbox]'))
				{
					$('input[type=checkbox]').attr('checked',false);
				}
				$('#status').html("");
				//$(".chekbox_renew").attr('checked',false);
				if( data.status == 'failure' )
				{
					alert(data.message);				
				}
				else
				{					
					for(var i = 1; i < data.product_code.length; i++)
					{
						$('#'+ data.product_code[i]).attr('value',data.product_code[i]);
						$('#'+ data.product_code[i]).attr('checked',true);	
															
					}				
				}
			}, "json");
		});
});
</script>
<?php 
	//Employee list	
	$employee_options = array(""=>"--Select--");
	foreach($employee_list as $employee_row)
	{					
        $employee_options[$employee_row->id]=$employee_row->name;
	}
	echo form_open('employee_product_transfers/edit');
	echo form_hidden('employee_product_transfer_id',$row->id);
	$img_name = '/media/images/add_big.png';
	$class_name = 'class="formTitleBar_edit"';
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_product_transfers')."'"));?>
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
							<?php //echo form_dropdown('cbo_employee', $employee_options,$row->employee_id);?>
							<input type="text" readonly="readonly" name="cbo_employee" id="employee_id" value="<?php echo $employee_options[$row->employee_id];?>"/> 
							<input type="hidden" name="cbo_employee" id="employee_id" value="<?php echo $row->employee_id;?>"/> 
							<?php //echo anchor('employees/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee')),array('class'=>'addimglink','alt'=>'Add Employee','title'=>'Add Employee'));?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Employee','width'=>'12px')), 'add_employee', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Employee','onclick'=>"window.location.href='".site_url('employees/add')."'"));?></div>
							<?php echo form_error('cbo_employee'); ?>
							</div>			
						</li>
						<li>	
							<label for="checkbox_product">Product Name:<em>&nbsp;</em></label>
							<table><?php $i=1;foreach ($loan_products as $new_product_row):
										$checked = FALSE;
										if(!empty($current_product))
										{
											if (array_key_exists($new_product_row->code, $current_product))
											{
												$checked = TRUE;
											} 
										}
							?>
							<td><?php $checkbox_data = array('name'=>"chk_product[$i]",'id'=>$new_product_row->code,'value'=>$new_product_row->code,'style'=> 'margin:10px','checked'=>$checked);
							echo form_checkbox($checkbox_data); $i++;?></td><td><?php echo $new_product_row->short_name;?></td>
							<?php endforeach;?></table>							
						</li>
						<li>
							<label for="txt_effective_date">Effective Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_effective_date','id' => 'datepicker','class'=>'date_picker','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_effective_date',$row->date_of_operation));?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employee_product_transfers')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
