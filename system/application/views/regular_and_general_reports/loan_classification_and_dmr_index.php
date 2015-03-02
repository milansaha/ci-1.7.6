<script type="text/javascript">
	$(function(){
	$("#txt_date_from").datepicker({dateFormat: 'yy-mm'});
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
	var cbo_year = form.cbo_year.value;		
	//alert(cbo_month);
	var cbo_month = form.cbo_month.value;		
	//alert(cbo_month);	
	
	if(cbo_branch == "") {		
		inlineMsg('cbo_branch','<strong>Error</strong><br />You must select a branch.',2);
		return false;
	}		 
	else if(cbo_month == "") {		
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
	$branch_options['-1'] = 'All';
	foreach($branch_info as $branch_info)
	{					
		$branch_options[$branch_info->branch_id]=$branch_info->branch_code."  (".$branch_info->branch_name.")";
	}
	
	//echo form_open('register_reports/admission_register');
	//echo ajax_form_for_report('regular_and_general_reports/loan_classification_and_dmr','#report_container');
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
<?php echo ajax_form_for_report('regular_and_general_reports/ajax_loan_classification_and_dmr','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
		<tr>	
			<td>
				<label for="cbo_branch">Branch:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_branch', $branch_options,"",'id="cbo_branch"'); ?>
			</td>
			<td>
				<label for="cbo_month">Month:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_month', $months_info,"",'id="cbo_month"'); ?>
			</td>
			<td>
				<label for="cbo_year">Year:<em>&nbsp;</em></label>			
				<?php echo form_dropdown('cbo_year', $year_info,"",'id="cbo_year"'); ?>
			</td>
			<td>
				<?php echo form_submit('submit','Preview');?>
			</td>
		</tr>
	</table>
	</div>
</div>
<?php echo form_close(); ?>

