<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
	<script type="text/javascript">
	$(function(){
	$("#txt_date").datepicker({dateFormat: 'yy-mm-dd'});	
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
	echo form_open('regular_and_general_reports/component_wise_daily_collection_report');
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
			<label for="txt_date">Date:<em>&nbsp;</em></label>			
			<?php $txt_date = array('name'=>'txt_date','id'=>'txt_date','readonly'=> 'readonly');
				echo form_input($txt_date,set_value('txt_date'));?><?php echo form_error('txt_date'); ?>			
		</li>				
		<li>
			<?php echo form_submit('submit','Show Report');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
