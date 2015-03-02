<script type="text/javascript">
	$(function(){
	$("#txt_date_from").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_date_to").datepicker({dateFormat: 'yy-mm-dd'});	
	});
</script>
<?php
	$branch_options['-1'] = 'All';
	foreach($branch_info as $branch_info)
	{					
		$branch_options[$branch_info->branch_id]=$branch_info->branch_code."  (".$branch_info->branch_name.")";
	}
	
	$product_options['-1'] = 'All';
	foreach($products_info as $product_info)
	{					
		$product_options[$product_info->product_id]=$product_info->product_code."  (".$product_info->product_mnemonic.")";
	}
	
	//echo form_open('register_reports/admission_register');
	echo ajax_form_for_report('regular_and_general_reports/ajax_loan_field_officer_wise','#report_container');
?>
<style>
.reportLayout{padding:15px;}
.reportLayout label{width:auto;border-bottom:solid 0px #dadada;color: #444444;font: 11px/20px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;}
.reportLayout input[type="submit"] {
    background: none repeat scroll 0 0 #FFFFFF;
    border-color: #D0D8D8 #D0D8D8 #AABBBB;
    border-style: solid;
    border-width: 1px;
    padding: 2px;
   color: #444444;
    font: 11px/20px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
    font-weight: normal;
    cursor: pointer;
    height: 25px;
    line-height: 25px;
    overflow: hidden;
    padding: 2px 5px 3px;
    width:auto;text-shadow: none;
    margin:0px;
    }
.reportLayout input:hover[type="submit"] {background:#f1f1f1; color:#2e2e2e;}
.reportLayout input {
	background: url("./media/images/date_pickerIcon.gif") no-repeat scroll right 2px white;
	border-color: #999999 #CCCCCC #CCCCCC;
    border-right: 1px solid #CCCCCC;
    border-style: solid;
    border-width: 1px; 
    background-color:white;
	padding:3px; 
	font-size:11px; 
	width:75px; 
	font-family:'Trebuchet MS',Verdana,Arial,Helvetica,sans-serif; 
}
.reportLayout select{
    background: none repeat scroll 0 0 #FFFFFF;
    border-color: #999999 #CCCCCC #CCCCCC;
    border-right: 1px solid #CCCCCC;
    border-style: solid;
    border-width: 1px;
    color: #333333;
    width:150px;padding: 3px;
    }
/*.toggleLink{-moz-border-radius: 4px;
    -webkit-border-radius: 0 0 8px 0;
    -khtml-border-radius: 0 0 8px 0;
    border-radius: 0 0 8px 0;
    background: none repeat scroll 0 0 #FFFFFF;
    border-color: #D0D8D8 #D0D8D8 #AABBBB;
    border-style: solid;
    border-width: 1px;
    color: #444444;
    cursor: pointer;
    font: 11px/25px "Trebuchet MS","Lucida Grande",Verdana,sans-serif;
    height: 25px;
    overflow: hidden;
    padding: 4px 20px 4px 20px;
    text-shadow: none;
    width: auto;
    }
.toggleLink:hover{
	background: none repeat scroll 0 0 #2e2e2e;
    border-color: #D0D8D8 #D0D8D8 #AABBBB;
    color:#f1f1f1;
    }
.context-links {
    -moz-border-radius: 4px 4px 0 0;
    background-color: #F4F4F4;
    border-left: 1px solid #B4AEAE;
    border-right: 1px solid #B4AEAE;
    border-top: 1px solid #B4AEAE;
    float: left;
    padding: 8px 10px 3px 28px;
    width: auto;
    margin: 0 3px 0 0;
    color:#4e4e4e;
    font-size:11px;
}*/
</style>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">
		<tr>
			<td>
				<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_branch', $branch_options); ?>
			</td>
			<td>
			<label for="txt_date_from">Date from:<em>&nbsp;</em></label>			
				<?php $txt_date_from = array('name'=>'txt_date_from','id'=>'txt_date_from','readonly'=> 'readonly');
					echo form_input($txt_date_from,set_value('txt_date_from'));?><?php echo form_error('txt_date_from'); ?>
			</td>
			<td>
				<label for="txt_date_to">Date to:<em>&nbsp;</em></label>			
				<?php $txt_date_to = array('name'=>'txt_date_to','id'=>'txt_date_to','readonly'=> 'readonly');
					echo form_input($txt_date_to,set_value('txt_date_to'));?><?php echo form_error('txt_date_to'); ?>		
			</td>
			<td>
				<label for="cbo_product">Product:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_product', $product_options); ?>
			</td>
			<td>
				<?php echo form_submit('submit','Preview');?>
			</td>
		</tr>
	</table>
	</div>
</div>
<?php echo form_close(); ?>

