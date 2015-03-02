<?php
	//Branch
	$branch_options[''] = '--------SELECT--------';
	foreach($branches_info as $branches_info)
	{					
		$branch_options[$branches_info->branch_id]=$branches_info->branch_name;
	}
	//Samities
	$samity_options[''] = '--------SELECT--------';
	foreach($samities_info as $samities_info)
	{					
		$samity_options[$samities_info->samity_id]=$samities_info->samity_name;
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
	
echo form_open('register_reports/balancing_register_member_wise_report');
?>
<fieldset>
	<legend>
		Balancing Register Member Wise
	</legend>
	<ol> 
		<li>
			<label for="cbo_branch_id">Branch Id:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_branch_id', $branch_options); ?>			
		</li> 
		<li>
			<label for="cbo_samity_id">Samity ID:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_samity_id', $samity_options); ?>			
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
