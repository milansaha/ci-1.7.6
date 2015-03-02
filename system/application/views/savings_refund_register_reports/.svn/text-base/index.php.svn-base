<?php

	$branches_options[''] = '--------SELECT--------';
	foreach($branches_info as $branches_info)
	{					
		$branches_options[$branches_info->branch_id]=$branches_info->branch_name;
	}
	
	$products_options['all'] = 'All Components';
	foreach($products_info as $products_info)
	{					
		$products_options[$products_info->product_code]=$products_info->product_mnemonic;
	}
	
echo form_open('savings_refund_register_reports/savings_refund_report');
?>
<fieldset>
	<legend>
		Savings Refund Regsiter Report
	</legend>
	<ol> 		
		<li>
			<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_branch', $branches_options); ?>			
		</li> 
		<li>
			<label for="cbo_product_code">Components:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product_code', $products_options); ?>			
		</li> 
		<li>
			<label for="txt_date_from">From Date:<em>&nbsp;</em></label>			
			<?php echo form_input('txt_date_from'); ?>			
		</li> 
		<li>
			<label for="txt_date_to">To Date:<em>&nbsp;</em></label>			
			<?php echo form_input('txt_date_to'); ?>			
		</li> 		
		<li>
			<?php echo form_submit('submit','Show Report');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
