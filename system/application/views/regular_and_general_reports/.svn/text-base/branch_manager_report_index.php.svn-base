<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
	<script type="text/javascript">
	$(function(){
	$("#txt_date_from").datepicker({dateFormat: 'yy-mm-dd'});	
	$("#txt_date_to").datepicker({dateFormat: 'yy-mm-dd'});	
	});
</script>
<script type="text/javascript">
$(document).ready(function() {
		// year change
		$("#cbo_year").change(
		function() 
		{			
			// start json
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_branch = $("#cbo_branch").val();
			var selected_year = $("#cbo_year").val();
			var selected_month = $("#cbo_month").val();					
			//alert(selected_branch);
			$.post("<?php echo site_url('regular_and_general_reports/ajax_for_get_week_list') ?>", { branch_id:selected_branch, year: selected_year, month:selected_month},
			function(data)
			{
				//alert(data.status);
				$('#status').html("");				
				$('#cbo_week_list').empty();
				if( data.status == 'failure' )
				{
					//alert(data.message);	
					$('#cbo_week_list').append('<option value = "">--Select--</option>');						
				}
				else
				{
					//alert(data.week.id);
					for(var i = 0; i < data.week.id.length; i++)
					{
						$('#cbo_week_list').append('<option value = \"' + data.week.name[i] + '\">' + data.week.name[i] + '</option>');					
					}
				}
			}, "json");
		});		
		// END year change

		// month change
		$("#cbo_month").change(
		function() 
		{			
			// start json
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_branch = $("#cbo_branch").val();
			var selected_year = $("#cbo_year").val();
			var selected_month = $("#cbo_month").val();					
			//alert(selected_branch);
			$.post("<?php echo site_url('regular_and_general_reports/ajax_for_get_week_list') ?>", { branch_id:selected_branch, year: selected_year, month:selected_month},
			function(data)
			{
				//alert(data.status);
				$('#status').html("");				
				$('#cbo_week_list').empty();
				if( data.status == 'failure' )
				{
					//alert(data.message);	
					$('#cbo_week_list').append('<option value = "">--Select--</option>');						
				}
				else
				{
					//alert(data.week.id);
					for(var i = 0; i < data.week.id.length; i++)
					{
						$('#cbo_week_list').append('<option value = \"' + data.week.name[i] + '\">' + data.week.name[i] + '</option>');					
					}
				}
			}, "json");
		});		
		// END month change
		
});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
	<script type="text/javascript">
	$(function(){
	$("#txt_date").datepicker({dateFormat: 'yy-mm-dd'});	
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
	var cbo_year = form.cbo_year.value;		
	//alert(cbo_month);
	var cbo_month = form.cbo_month.value;		
	//alert(cbo_month);
	var cbo_week_list = form.cbo_week_list.value;		
	//alert(cbo_month);
	
	if(cbo_branch == "") {		
		inlineMsg('cbo_branch','<strong>Error</strong><br />You must select a branch.',2);
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
	else if(cbo_week_list == "") {		
		inlineMsg('cbo_week_list','<strong>Error</strong><br />You must select a week.',2);
		return false;
	}
}
</script>
<?php
	$branches_options= array(''=>'--Select--');
	foreach($branch_info as $branch_info)
	{					
		$branches_options[$branch_info->branch_id]=$branch_info->branch_name;
	}
	
	$product_options= array(''=>'--Select--');
	foreach($products_info as $product_row)
	{		
		$product_options[$product_row->product_id]=$product_row->product_mnemonic;		
	}
	//Month list 
	$month_options =array(''=>'--Select--');
	foreach($months_info as $key => $value)
	{					
		$month_options[$key] = $value;
	}
	//Year list
	$year_options = array(''=>'--Select--');
	foreach($year_info as $key => $value)
	{					
		$year_options[$key] = $value;
	}
	$week_list = array(''=>'--Select--');	
?>
<?php echo ajax_form_for_report('regular_and_general_reports/ajax_branch_manager_report','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
		<tr>	
			<td>
				<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_branch', $branches_options,"",'id="cbo_branch"');?>	
		</td> 
		<td>
			<label for="cbo_product">Product:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product', $product_options,"",'id="cbo_product"'); ?>			
		</td> 
		<td>
			<label for="cbo_year">Year:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_year', $year_options,"",'id="cbo_year"'); ?><?php echo form_error('cbo_year'); ?>					
		</td>
		<td>
			<label for="cbo_month">Month:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_month', $month_options,"",'id="cbo_month"'); ?><?php echo form_error('cbo_month'); ?>					
		</td> 
		<td>
			<label for="cbo_week_list">Week:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_week_list',$week_list,"",'id="cbo_week_list"'); ?><?php echo form_error('cbo_week_list'); ?>					
		</td> 					
		<td>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Show Report');?>
		</td>		
	</tr>
</table>
</div>
</div>
<?php echo form_close();?>