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
	  var txt_date_from = form.txt_date_from.value;
	  var txt_date_to = form.txt_date_to.value;
	  var cbo_branch = form.cbo_branch.value;
	  var cbo_product = form.cbo_product.value;
          var dateRegex = /^\d{4}-\d{2}-\d{2}$/;

	firstDate = Date.parse(txt_date_from);
	secondDate= Date.parse(txt_date_to);
	msPerDay = 24 * 60 * 60 * 1000
	dbd = Math.round((secondDate.valueOf()-firstDate.valueOf())/ msPerDay);

	  if(cbo_branch == "") {
		inlineMsg('cbo_branch','<strong>Error</strong><br />You must select one branch.',2);
		return false;
	  }
	  if(cbo_product == "") {
		inlineMsg('cbo_product','<strong>Error</strong><br />You must select one product.',2);
		return false;
	  }
          if(txt_date_from == "")
	  {
		inlineMsg('txt_date_from','<strong>Error</strong><br />Enter Date From.',2);
		return false;
	  }else if(!txt_date_from.match(dateRegex))
		{
			inlineMsg('txt_datetxt_date_from_from','<strong>Error</strong><br />You have entered an invalid Date for Date From.',2);
			return false;
		}
          if(txt_date_to == "") {
		inlineMsg('txt_date_to','<strong>Error</strong><br />Enter Date To.',2);
		return false;
	  }else if(!txt_date_to.match(dateRegex)) {
		inlineMsg('txt_date_to','<strong>Error</strong><br />You have entered an invalid Date for Date To.',2);
		return false;
	  }

if(dbd < 0)
{
	inlineMsg('txt_date_from','<strong>Error</strong><br />Your selected to date is smaller than from date. Please select from & to date correctly.',2);
	return false;
}
}
</script>
<?php
	$branches_options['-1'] = 'All';
	foreach($branch_info as $branch_info)
	{					
		$branches_options[$branch_info->branch_id]=$branch_info->branch_name;
	}
	
	$product_options = array(''=>"--Select--");
	foreach($products_info as $product_row)
	{		
		$product_options[$product_row->product_id]=$product_row->product_mnemonic;		
	}	
        echo ajax_form_for_report('register_reports/ajax_fully_paid_loan_register_report','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));
?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">
		<tr>
                    <td>
			<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_branch', $branches_options,"",'id="cbo_branch"'); ?>			
		 </td>
		<td>
			<label for="cbo_product">Component:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product', $product_options,"",'id="cbo_product"'); ?>			
		 </td>
		<td>
			<label for="txt_date_from">From Date:<em>&nbsp;</em></label>			
			<?php $txt_date_from = array('name'=>'txt_date_from','id'=>'txt_date_from','readonly'=> 'readonly');
				echo form_input($txt_date_from,set_value('txt_date_from'));?><?php echo form_error('txt_date_from'); ?>			
		 </td>
		<td>
			<label for="txt_date_to">To Date:<em>&nbsp;</em></label>			
			<?php $txt_date_to = array('name'=>'txt_date_to','id'=>'txt_date_to','readonly'=> 'readonly');
				echo form_input($txt_date_to,set_value('txt_date_to'));?><?php echo form_error('txt_date_to'); ?>			
		 </td>
		<td>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Show Report');?>
		 </td>
	</tr>
</table>
</div>
</div>
<?php echo form_close(); ?>