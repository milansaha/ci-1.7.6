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
	var txt_date = form.txt_date.value;		
	//alert(cbo_month);
	
	if(cbo_branch == "") {		
		inlineMsg('cbo_branch','<strong>Error</strong><br />You must select a branch.',2);
		return false;
	}	
	else if(cbo_product == "") {		
		inlineMsg('cbo_product','<strong>Error</strong><br />You must select a product.',2);
		return false;
	}	
	else if(txt_date == "") {		
		inlineMsg('txt_date','<strong>Error</strong><br />You must select a date.',2);
		return false;
	}
}
</script>
<?php
	$branches_options = array(''=>'------Select------');
	foreach($branch_info as $branch_info)
	{					
		$branches_options[$branch_info->branch_id]=$branch_info->branch_name;
	}
	
	$product_options= array(''=>'------Select------');
	foreach($products_info as $product_row)
	{		
		$product_options[$product_row->product_id]=$product_row->product_mnemonic;		
	}	
?>
<?php echo ajax_form_for_report('regular_and_general_reports/ajax_component_wise_daily_collection_report','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
		<tr>	
			<td>
				<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_branch', $branches_options,"",'id="cbo_branch"'); ?><?php echo form_error('cbo_branch'); ?></td> 
			<td>
				<label for="cbo_product">Product:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_product', $product_options,"",'id="cbo_product"'); ?><?php echo form_error('cbo_product'); ?></td> 
			<td>
				<label for="txt_date">Date:<em>&nbsp;</em></label>			
				<?php $txt_date = array('name'=>'txt_date','id'=>'txt_date','readonly'=> 'readonly');
					echo form_input($txt_date,set_value('txt_date',"",'id="txt_date"'));?><?php echo form_error('txt_date'); ?></td>				
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Show Report');?></td>		
		</tr>
	</table>
</div>
</div>
<?php echo form_close();?>