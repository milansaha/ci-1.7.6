<?php
	$branch_options['-1'] = 'All';
	foreach($branch_info as $branch_info)
	{					
		$branch_options[$branch_info->branch_id]=$branch_info->branch_code."  (".$branch_info->branch_name.")";
	}	
	echo ajax_form_for_report('branchwise_samity_reports/ajax_get_branchwise_samities','#report_container');
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
				<?php echo form_submit('submit','Preview');?>
			</td>
		</tr>
	</table>
	</div>
</div>
<?php echo form_close(); ?>

