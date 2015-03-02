<script type="text/javascript">
$(function(){
	$("#txt_date_from").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_date_to").datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<style>
#msg {display:none; position:absolute; z-index:200; background:url(<?php echo base_url()?>media/images/msg_arrow.gif) left center no-repeat; padding-left:7px}
#msgcontent {display:block; background:#f3e6e6; border:2px solid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}
</style>

<script src="<?php echo base_url()?>media/js/messages.js"></script>
<script type="text/javascript">
// form validation function //
function validate(form)
{
	  var cbo_product = form.cbo_product.value;
	  var cbo_year = form.cbo_year.value;
	  var cbo_month = form.cbo_month.value;
          var cbo_samity_id = form.cbo_samity_id.value;
          var cbo_member_id = form.cbo_member_id.value;
	  
	  if(cbo_product == "") {
		inlineMsg('cbo_product','<strong>Error</strong><br />You must select a product.',2);
		return false;
	  }        
          if(cbo_samity_id == "") {
		inlineMsg('cbo_samity_id','<strong>Error</strong><br />You must select a samity.',2);
		return false;
	  }
          if(cbo_member_id == "") {
		inlineMsg('cbo_member_id','<strong>Error</strong><br />You must select a member.',2);
		return false;
	  }
           if(cbo_month == "") {
		inlineMsg('cbo_month','<strong>Error</strong><br />You must select a month.',2);
		return false;
	  }
          if(cbo_year == "") {
		inlineMsg('cbo_year','<strong>Error</strong><br />You must select a year.',2);
		return false;
	  }
}
</script>
<?php
	//Members
	$members_options = array(''=>"--Select--");
	foreach($members_info as $members_info)
	{					
		$members_options[$members_info->member_id] = $members_info->member_name;
	}
	//Samities
	$samity_options =  array(''=>"--Select--");
	foreach($samities_info as $samities_info)
	{					
		$samity_options[$samities_info->samity_id]=$samities_info->samity_name;
	}
	//Products
	$product_options =  array(''=>"--Select--");
	foreach($products_info as $products_info)
	{					
		$product_options[$products_info->product_id]=$products_info->product_mnemonic;
	}
	
	//Months
	$month_options =  array(''=>"--Select--");
	foreach($months_info as $key => $value)
	{					
		$month_options[$key] = $value;
	}
	//Years
	$year_options =  array(''=>"--Select--");
	foreach($year_info as $key => $value)
	{					
		$year_options[$key] = $value;
	}
	
//echo form_open('register_reports/member_wise_subsidy_loan_saving_ledger_report');
echo ajax_form_for_report('register_reports/ajax_member_wise_subsidy_loan_saving_ledger_report','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));
?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">
		<tr>
                    <td>
			<label for="cbo_product">Component:<em>&nbsp;</em></label>
			<?php echo form_dropdown('cbo_product', $product_options,"",'id="cbo_product"'); ?>
		 </td>
		<td>
			<label for="cbo_samity_id">Samity:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_samity_id', $samity_options,"",'id="cbo_samity_id"'); ?>			
		 </td>
		<td>
			<label for="cbo_member_id">Member:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_member_id', $members_options,"",'id="cbo_member_id"'); ?>			
		 </td>
		<td>
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
<?php echo form_close(); ?>