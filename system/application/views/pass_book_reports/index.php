<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
	<script type="text/javascript">
	$(function(){
	$("#txt_opening_date").datepicker({dateFormat: 'yy-mm-dd'});	
	});
</script>	
<script type="text/javascript">
$(document).ready(function() {
		$("#member_info").autocomplete('<?php echo site_url("members/ajax_get_member_list_auto/")?>', {
			minChars: 0,
			width: 310,
			matchContains: "word",
			highlightItem: true,
			formatItem: function(row, i, max, term) {
				var tmp;
				tmp=row[0].split(",");
				return "<strong>"+tmp[1]+"</strong>" + "<br><span style='font-size: 80%;'>Branch: " + tmp[2] + "<br>Samity: " + tmp[3] + "<br>Working area: " + tmp[4] + "</span>";
			},
			
			formatResult: function(row) {
				var tmp;
				tmp=row[0].split(",");
				return tmp[1];
			}
		}).result(function(e, item) {
			//myCallback();
			var tmp;
			tmp=item[0].split(",");
			$("#branch_id").attr('value',tmp[5]);
			$("#cbo_samitiy").attr('value',tmp[6]);
			$("#member_id").attr('value',tmp[0]);				

			// Product information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_member_id = tmp[0];
			
			$.post("<?php echo site_url('pass_book_reports/ajax_for_get_product_info') ?>", { member_id: selected_member_id},
			function(data)
			{
				//alert(data.status)
				$('#status').html("");
				$('#cbo_product').empty();				
				
				if( data.status == 'failure' )
				{
					//alert(data.message);					
				}
				else
				{
					//$('#cbo_product').attr('value',data.product.name);
					//$('#cbo_product').attr('readonly','');	
					for(var i = 0; i < data.product.id.length; i++)
					{
						$('#cbo_product').append('<option value = \"' + data.product.id[i] + '\">' + data.product.name[i] + '</option>');					
					}																																		
				}
			}, "json");			
		});
		// end member info			
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
	var member_info = form.member_info.value;	
	//alert(cbo_branch);
	var cbo_samitiy = form.cbo_samitiy.value;		
	//alert(cbo_year);
	var cbo_product = form.cbo_product.value;		
	//alert(cbo_month);
	
	if(member_info == "") {		
		inlineMsg('member_info','<strong>Error</strong><br />You must select a member.',2);
		return false;
	}	
	else if(cbo_samitiy == "") {		
		inlineMsg('cbo_samitiy','<strong>Error</strong><br />You must select a samity.',2);
		return false;
	}	
	else if(cbo_product == "") {		
		inlineMsg('cbo_product','<strong>Error</strong><br />You must select a product.',2);
		return false;
	}
}
</script>
<?php
	$samities_options[''] = '--Select--';
	foreach($samities_info as $samities_info)
	{					
		$samities_options[$samities_info->samity_id]=$samities_info->samity_name;
	}
	
	$products_options[''] ='--Select--';
	foreach($products_info as $products_info)
	{					
		$products_options[$products_info->product_id]=$products_info->product_mnemonic.'-'.$products_info->funding_org_name;
	}	
?>
<?php echo ajax_form_for_report('pass_book_reports/ajax_pass_book_report','#report_container',null,array('onsubmit'=>'if(validate(this)==false) return false;'));?>
<div style="border-bottom:solid 0px #dedede;width:100%;float:left;">
	<div class="toggle" style="display:none;width:100%;float:left;display:block;border:solid 0px red;">
	<table border="0" class="reportLayout" width="auto" cellspacing="0px" cellpadding="0">	
		<tr><td>
			<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />
			<label for="cbo_member">Member Name:<em>&nbsp;</em></label>			
			<input size='100' type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>				
		</td> 	
		<td>
			<label for="cbo_samitiy">Samity Name:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_samitiy', $samities_options,"",'id="cbo_samitiy"'); ?>			
		</td> 
		<td>
			<label for="cbo_product">Components:<em>&nbsp;</em></label>			
			<?php echo form_dropdown('cbo_product', $products_options,"",'id="cbo_product"'); ?>			
		</td> 
		<td>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Show Report');?>
		</td>		
	</tr>		
	</table>
	</div>
</div>
<?php echo form_close();?>