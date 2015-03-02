<?php	
	//
	$branches_options[''] = '--------SELECT--------';
	foreach($branches_info as $branches_info)
	{					
		$branches_options[$branches_info->branch_id]=$branches_info->branch_name;
	}
	//
	$product_options[''] = '--------SELECT--------';	
	foreach($products_info as $products_info)
	{					
		$product_options[$products_info->product_id]=$products_info->product_mnemonic;
	}
	
echo form_open('register_reports/fully_paid_loan_register_report');
?>
<fieldset>
	<legend>
		Ratio Analysis Statement
	</legend>
	<ol> 	
		<li>
			<label for="cbo_branch">Branch Name:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_branch', $branches_options); ?>			
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
			<label for="cbo_product">Component:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product', $product_options); ?>			
		</li> 
		<li>
			<?php echo form_submit('submit','Show Report');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
