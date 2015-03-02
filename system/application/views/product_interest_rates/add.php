<script type="text/javascript">
	$(function(){
	$("#txt_effective_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_end_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<script type="text/javascript">
$(document).ready(function() {		
		$("#cbo_product").change(
		function() 
		{
			// start json			
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var selected_product_id = $("#cbo_product").val();					
			$.post("<?php echo site_url('loan_products/ajax_for_get_product_info') ?>", { product_id: selected_product_id},
			function(data)
			{
				//alert(data.status)
				$('#status').html("");
				$('#txt_interest_provision_rate').attr('value',"");

				if( data.status == 'failure')
				{
					//alert(data.message);					
				}
				else
				{					
					$('#txt_interest_provision_rate').attr('value',data.loan_products.interest_rate);														
				}
			}, "json");
		});		
		// END product change
});
</script>
<?php
//echo $this->validation->error_string;
$options_product_name = array(""=>"--Select--");
foreach($product_infos as $product_info)
{					
	$options_product_name[$product_info->product_id]=$product_info->product_name;
}
echo form_open('product_interest_rates/add');
$img_name = '/media/images/add_big.png';
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('product_interest_rates')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="cbo_product"> Product Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_product',$options_product_name,set_value('cbo_product',(isset($row->product_id)?$row->product_id:"")),'id="cbo_product"','calss="input_select"');?>
							<?php echo form_error('cbo_product'); ?>	
							<?php echo anchor('loan_products/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add New Product')),array('class'=>'addimglink','alt'=>'Add New Product','title'=>'Add New Product'));  ?>
							</div>
						</li> 
						<li>
							<label for="txt_interest_provision_rate">Provision Interest Rate:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_interest_provision_rate','id'=>'txt_interest_provision_rate','readonly'=>'readonly','calss="input_textbox"'),
									set_value('txt_interest_provision_rate'));?><?php echo form_error('txt_interest_provision_rate'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_interest_rate">New Interest Rate:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input('txt_interest_rate',set_value('txt_interest_rate'),'calss="input_textbox"');?>
							<?php echo form_error('txt_interest_rate'); ?>
							</div>
						</li> 						
						<li>
							<label for="txt_effective_date">Effective Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_effective_date','id'=>'txt_effective_date','class'=>"date_picker"),set_value('txt_effective_date'));?>
							 <div class="hints"> YYYY-MM-DD</div>
							<?php echo form_error('txt_effective_date'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_end_date">End Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_end_date','id'=>'txt_end_date','class'=>"date_picker"),set_value('txt_end_date'));?>
							 <div class="hints"> YYYY-MM-DD</div>
							<?php echo form_error('txt_end_date'); ?>
							<div class="form_input_container">
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('product_interest_rates')."'"));?>
				</div>
			</td>
			<td class="formBottomBar">&nbsp;</td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
