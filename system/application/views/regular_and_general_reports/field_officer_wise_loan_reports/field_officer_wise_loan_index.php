	<script type="text/javascript">
	$(function(){
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});	
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});	
	});
</script>
<?php
	$branches_options[''] = '------Select------';
	foreach($branch_info as $branch_info)
	{					
		$branches_options[$branch_info->branch_id]=$branch_info->branch_name;
	}
	
	$product_options[''] = "------Select------";	
	foreach($products_info as $product_row)
	{		
		$product_options[$product_row->product_id]=$product_row->product_mnemonic;		
	}
	echo form_open('regular_and_general_reports/field_officer_wise_loan_reports');
?>
<fieldset>
	<legend>Component Wise Daily Collection Report</legend>
	<ol> 		
		<li>
			<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_branch', $branches_options); ?>			
		</li> 
		<li>
			<label for="cbo_product">Product:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product', $product_options); ?>			
		</li> 
		<li>
			<label for="txt_date">From Date:<em>&nbsp;</em></label>			
			<?php $txt_date = array('name'=>'txt_from_date','id'=>'txt_from_date','readonly'=> 'readonly');
				echo form_input($txt_date,set_value('txt_from_date'));?><?php echo form_error('txt_from_date'); ?>			
		</li>
		<li>
			<label for="txt_date">To Date:<em>&nbsp;</em></label>			
			<?php $txt_date = array('name'=>'txt_to_date','id'=>'txt_to_date','readonly'=> 'readonly');
				echo form_input($txt_date,set_value('txt_to_date'));?><?php echo form_error('txt_to_date'); ?>			
		</li> 				
		<li>
			<?php echo form_submit('submit','Show Report');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
