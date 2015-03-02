<?php
	//Members
	$members_options[''] = '--------SELECT--------';
	foreach($members_info as $members_info)
	{					
		$members_options[$members_info->member_id] = $members_info->member_name;
	}
	//Samities
	$samity_options[''] = '--------SELECT--------';
	foreach($samities_info as $samities_info)
	{					
		$samity_options[$samities_info->samity_id]=$samities_info->samity_name;
	}
	//Products
	$branch_options[''] = '--------SELECT--------';
	foreach($products_info as $products_info)
	{					
		$branch_options[$products_info->product_id]=$products_info->product_mnemonic;
	}
	
	//Months
	$month_options = "";
	foreach($months_info as $key => $value)
	{					
		$month_options[$key] = $value;
	}
	//Years
	$year_options = "";
	foreach($year_info as $key => $value)
	{					
		$year_options[$key] = $value;
	}
	
echo form_open('register_reports/member_wise_subsidy_loan_saving_ledger_report');
?>
<fieldset>
	<legend>
		Member Wise Subsidiary Loan and Savings Ledger
	</legend>
	<ol> 
		<li>
			<label for="branch_id">Branch Id:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('branch_id', $branch_options); ?>			
		</li> 
		<li>
			<label for="cbo_samity_id">Samity ID:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_samity_id', $samity_options); ?>			
		</li> 
		<li>
			<label for="cbo_member_id">Member:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_member_id', $members_options); ?>			
		</li> 
		<li>
			<label for="cbo_month">For Month:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_month', $month_options); ?>			
		</li> 
		<li>
			<label for="cbo_year">Year:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_year', $year_options); ?>			
		</li> 			
		<li>
			<?php echo form_submit('submit','Show Report');?>
		</li>		
	</ol>
</fieldset>
<?php echo form_close(); ?>
