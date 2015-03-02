<style>
/*#execute_div{float: left;font-size: 12px;margin-left: 13px;padding-top: 4px;width:960px;}
#execute_link{-moz-border-radius: 4px 4px 0 0;-webkit-border-radius: 4px 4px 0 0;-khtml-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;background-color: #F4F4F4;border-left: 1px solid #B4AEAE;border-right: 1px solid #B4AEAE;border-top: 1px solid #B4AEAE;padding: 8px 15px 3px;width:auto;float: left;}
#execute_link a{color:#2e2e2e;}
#execute_link a:hover{color:#000;}
#loading{float:left;border: 1px solid #3399CC;display: none;font-size: 12px;padding: 0px 0px 0px;text-align:left;width: 988px;margin-top:0px;}
.loading_p_body{margin:0px; padding:0px 20px 0px 20px;}
.loading_p_head{font-family: arial;border-bottom:solid 1px #2D82AB;background:url(../images/dashboard_images/errormsgicon28_128.gif) no-repeat 250px 5px #3B9ECC;margin:0px;padding:6px 17px;}
#ajax_list{border:solid 0px red;width:100%;float:left;}*/

#execute_div{float: left;font-size: 12px;margin-left: 13px;padding-top: 4px;width:960px;}
#execute_link{-moz-border-radius: 4px 4px 0 0;-webkit-border-radius: 4px 4px 0 0;-khtml-border-radius: 4px 4px 0 0;border-radius: 4px 4px 0 0;background-color: #F4F4F4;border-left: 1px solid #B4AEAE;border-right: 1px solid #B4AEAE;border-top: 1px solid #B4AEAE;padding: 8px 15px 3px;width:auto;float: left;}
#execute_link a{color:#2e2e2e;}
#execute_link a:hover{color:#000;}
#loading{float:left;border:1px solid #D2C300;display: none;font-size: 12px;padding: 0px 0px 0px;text-align:left;width: 988px;margin:0px 0px 10px 0px;}
.loading_p_body{margin:0px; padding:0px 20px 0px 20px;}
.loading_p_head{background:url(../images/dashboard_images/errormsgicon28_128.gif) no-repeat 250px 5px #FFFFFF;border-bottom: 1px solid #D2C300;font-family: arial;margin: 0;padding: 6px 17px;}
#ajax_list{border:solid 0px red;width:100%;float:left;}
</style>

<div id='loading'>
	<p class="loading_p_head"><?php echo img(array('src'=>base_url().'media/images/progressbar.gif','border'=>'0','alt'=>'loading'));?></p>
	<h4 style="background:url(<?php echo base_url()?>media/images/dashboard_images/errormsgicon28_128.gif) no-repeat 5px 3px #F9F9A3;color: #2e2e2e;font-size: 14px;margin: 0;padding: 8px 8px 8px 40px;">Please do not close this page. A process is being executing...</h4>
	<!--<p class="loading_p_body">
	Please do not close this page. A process is being executing... Please do not close this page. A process is being executing... Please do not close this page.
	<br/>
	</p>-->
</div>

<h2>Day end process</h2>
<div id="execute_div">
	<div id="execute_link">
		<?php echo ajax_anchor('#ajax_list','#loading',"process_day_ends/ajax_execute","Execute"); ?>
	</div>
</div>
<div id="filter">
	<?php 
	$session_data = $this->session->userdata('process_day_ends.index');
	//print_r($session_data);
	echo ajax_form('process_day_ends/index','#ajax_list','#loading');?>
	<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
		<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
			<tr>	
				<td>
					<label for="cbo_month">Month:<em>&nbsp;</em></label>			
					<?php echo form_dropdown('cbo_month', $months_info,set_value('cbo_month',isset($session_data['cbo_month'])?$session_data['cbo_month']:""),'id="cbo_month"'); ?>
				</td>
				<td>
					<label for="cbo_year">Year:<em>&nbsp;</em></label>			
					<?php echo form_dropdown('cbo_year', $year_info,set_value('cbo_year',isset($session_data['cbo_year'])?$session_data['cbo_year']:""),'id="cbo_year"'); ?>
				</td>
				<td>
					<?php echo form_submit('submit','Preview');?>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php echo form_close(); ?>
<div id='ajax_list' name='ajax_list' style="">
	<?php $this->load->view('process_day_ends/list');?>
</div>
<script type="text/javascript">
/*
// Ajax activity indicator bound to ajax start/stop document events
$(document).ajaxStart(function(){
  $('#loading').show();
}).ajaxStop(function(){
  $('#loading').hide();
  $('#dateinfo').val('<?php $software_date;?>');
});
*/
function ajax_load_anchor_callback(data)
{
	alert("called");
}
/*
$('#loading').hide()  // hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    });
*/
</script>
