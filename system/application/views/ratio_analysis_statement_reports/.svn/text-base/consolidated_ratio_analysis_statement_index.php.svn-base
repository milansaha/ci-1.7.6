<style>
#msg {display:none; position:abstableute; z-index:200; background:url(<?php echo base_url()?>media/images/msg_arrow.gif) left center no-repeat; padding-left:7px}
#msgcontent {display:block; background:#f3e6e6; border:2px stableid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}
</style>
<script src="<?php echo base_url()?>media/js/livevalidation_standalone.compressed.js"></script>
<script src="<?php echo base_url()?>media/js/messages.js"></script>
<script type="text/javascript">
function validate(form) 
{
	var cbo_year = form.cbo_year.value;		
	//alert(cbo_year);
	var cbo_month = form.cbo_month.value;		
	//alert(cbo_month);
	
	if(cbo_month == "") {		
		inlineMsg('cbo_month','<strong>Error</strong><br />You must select a month.',2);
		return false;
	}	
	else if(cbo_year == "") {		
		inlineMsg('cbo_year','<strong>Error</strong><br />You must select a year.',2);
		return false;
	}
}
</script>
<?php	
	//
	$branches_options[''] = '--Select--';
	foreach($branches_info as $branches_info)
	{					
		$branches_options[$branches_info->branch_id]=$branches_info->branch_name;
	}
	//
	$project_options[''] = '--Select--';
	$project_options['All'] = 'All';
	foreach($projects_info as $projects_info)
	{					
		$project_options[$projects_info->project_id]=$projects_info->project_name;
	}
	//
	$month_options = "";
	foreach($months_info as $key => $value)
	{					
		$month_options[$key] = $value;
	}
	//
	$year_options = "";
	foreach($year_info as $key => $value)
	{					
		$year_options[$key] = $value;
	}
?>
<?php echo ajax_form_for_report('additional_reports/ajax_consolidated_ratio_analysis_statement_report','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
		<tr><td>
			<label for="cbo_month">Month:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_month', $month_options,"",'id="cbo_month"'); ?>			
		</td> 
		<td>
			<label for="cbo_year">Year:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_year', $year_options,"",'id="cbo_year"'); ?>			
		</td> 		
		<td>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Show Report');?>
		</td>		
	</tr>
</table>
</div>
</div>
<?php echo form_close();?>