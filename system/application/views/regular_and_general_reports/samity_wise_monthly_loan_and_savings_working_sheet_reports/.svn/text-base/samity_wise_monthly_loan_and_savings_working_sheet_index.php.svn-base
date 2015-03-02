<script type="text/javascript">
// dropdown list by JSON
$(document).ready(function()
	{	
		//  samity day
		$("#cbo_samity_day").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_from_branch = $("#cbo_branch").val();
			var selected_from_samity_day = $("#cbo_samity_day").val();
			
			$.post("<?php echo site_url('samities/ajax_for_get_samity_list_by_branch_samity_day') ?>", { branch_id: selected_from_branch,samity_day: selected_from_samity_day },
			function(data)
			{
				$('#status').html("");
				$('#cbo_samity').empty();
				if( data.status == 'failure' )
				{
					//alert(data.message);
					$('#cbo_samity').append('<option value = "">--Select--</option>');
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.samity_id.length; i++)
					{
						$('#cbo_samity').append('<option value = \"' + data.samity_id[i] + '\">' + data.samity_name[i] + '</option>');
					
					}
				}
			}, "json");
		});
		
		// branch wise samity
		$("#cbo_branch").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_from_branch = $("#cbo_branch").val();
			var selected_from_samity_day = $("#cbo_samity_day").val();
			
			$.post("<?php echo site_url('samities/ajax_for_get_samity_list_by_branch_samity_day') ?>", { branch_id: selected_from_branch,samity_day: selected_from_samity_day },
			function(data)
			{
				$('#status').html("");
				$('#cbo_samity').empty();
				if( data.status == 'failure' )
				{
					//alert(data.message);
					$('#cbo_samity').append('<option value = "">--Select--</option>');
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.samity_id.length; i++)
					{
						$('#cbo_samity').append('<option value = \"' + data.samity_id[i] + '\">' + data.samity_name[i] + '</option>');
					
					}
				}
			}, "json");
		});
	});	
</script>
<style>
#msg {display:none; position:abstableute; z-index:200; background:url(<?php echo base_url()?>media/images/msg_arrow.gif) left center no-repeat; padding-left:7px}
#msgcontent {display:block; background:#f3e6e6; border:2px stableid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}
</style>
<script src="<?php echo base_url()?>media/js/livevalidation_standalone.compressed.js"></script>
<script src="<?php echo base_url()?>media/js/messages.js"></script>
<script type="text/javascript">
function validate(form) 
{
	var cbo_branch = form.cbo_branch.value;	
	//alert(cbo_branch);
	var cbo_product = form.cbo_product.value;		
	//alert(cbo_year);
	var cbo_samity = form.cbo_samity.value;		
	//alert(cbo_year);
	var cbo_year = form.cbo_year.value;		
	//alert(cbo_month);
	var cbo_month = form.cbo_month.value;		
	//alert(cbo_month);	
	
	if(cbo_branch == "") {		
		inlineMsg('cbo_branch','<strong>Error</strong><br />You must select a branch.',2);
		return false;
	}	
	else if(cbo_samity == "") {		
		inlineMsg('cbo_samity','<strong>Error</strong><br />You must select an samity.',2);
		return false;
	}
	else if(cbo_product == "") {		
		inlineMsg('cbo_product','<strong>Error</strong><br />You must select a product.',2);
		return false;
	}
	else if(cbo_year == "") {		
		inlineMsg('cbo_year','<strong>Error</strong><br />You must select a year.',2);
		return false;
	}	 
	else if(cbo_month == "") {		
		inlineMsg('cbo_month','<strong>Error</strong><br />You must select a month.',2);
		return false;
	}	
}
</script>
<?php
	//Samity Day
	$samity_day_options = "";
	foreach($samity_day_info as $key => $value)
	{					
		$samity_day_options[$key] = $value;
	}
	
	//branch_info
	$branch_options[''] = '---SELECT---';
	foreach($branch_info as $branch)
	{					
		$branch_options[$branch->branch_id]=$branch->branch_name;
	}
	//Samities
	$samity_options[''] = '---SELECT---';
	foreach($samities_info as $samities_info)
	{					
		$samity_options[$samities_info->samity_id]=$samities_info->samity_name;
	}
	//Products
	$product_options[''] = '---SELECT---';
	foreach($products_info as $products_info)
	{					
		$product_options[$products_info->product_id]=$products_info->product_mnemonic;
	}
	
	//Months
	$month_options[''] = '---SELECT---';
	foreach($months_info as $key => $value)
	{					
		$month_options[$key] = $value;
	}
	//Years
	$year_options[''] = '---SELECT---';
	foreach($year_info as $key => $value)
	{					
		$year_options[$key] = $value;
	}
?><div id="status" style="position:absolute;top:50%;left:45%;"></div>
<?php echo ajax_form_for_report('regular_and_general_reports/ajax_samity_wise_monthly_loan_and_savings_working_sheet_reports','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
		<tr>	
			<td>
				<label for="cbo_samity_day">Samity Day:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_samity_day', $samity_day_options,"",'id="cbo_samity_day"'); ?><?php echo form_error('cbo_samity_day'); ?>			
		</td>  
		<td>
			<label for="cbo_branch_id">Branch :<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_branch', $branch_options,"",'id="cbo_branch"'); ?><?php echo form_error('cbo_branch'); ?>			
		</td> 
		<td>
			<label for="cbo_samity_id">Samity :<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_samity', $samity_options,"",'id="cbo_samity"'); ?><?php echo form_error('cbo_samity'); ?>			
		</td> 
		<td>
			<label for="cbo_product_id">Product :<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product', $product_options,"",'id="cbo_product"'); ?><?php echo form_error('cbo_product'); ?>			
		</td> 
		<td>
			<label for="cbo_month">Month:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_month', $month_options,"",'id="cbo_month"'); ?><?php echo form_error('cbo_month'); ?>			
		</td> 
		<td>
			<label for="cbo_year">Year:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_year', $year_options,"",'id="cbo_year"'); ?><?php echo form_error('cbo_year'); ?>			
		</td> 			
		<td>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Show Report');?>	
		</td>
	</tr>
	</table>	
</div></div>
<?php echo form_close();?>