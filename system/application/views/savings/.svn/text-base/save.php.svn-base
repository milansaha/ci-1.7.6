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
			$("#samity_id").attr('value',tmp[6]);
			$("#member_id").attr('value',tmp[0]);	
			$('#type_of_deposite').attr('value','');
			$('#interest_rate').attr('value','');
			$('#txt_weekly_savings').attr('value','');
			$('#txt_code').attr('value','');	

			// Product information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var selected_member_id = tmp[0];

			$.post("<?php echo site_url('savings/ajax_for_get_savings_product_list_by_member') ?>", { member_id: selected_member_id },
			function(data)
			{
				$('#status').html("");
				$('#cbo_product').empty();
				$('#cbo_product').append('<option value = "">--Select--</option>');
				if( data.status == 'failure' )
				{
					//alert(data.message);					
				}
				else
				{
					//alert(data.status);
					for(var i = 0; i < data.product.id.length; i++)
					{
						$('#cbo_product').append('<option value = \"' + data.product.id[i] + '\">' + data.product.name[i] + '</option>');					
					}										
				}
			}, "json");			
		});
		// end member info	

		// start product change
		$("#cbo_product").change(
			function(){
			// start json
			// savings information

			var selected_member_id = $("#member_id").val();				
			var selected_product_id = $("#cbo_product").val();
			
			$.post("<?php echo site_url('savings/ajax_for_get_savings_product_info') ?>", { product_id: selected_product_id,member_id: selected_member_id},
			function(data)
			{
				//alert(data.status)
				$('#status').html("");
				$('#savings_id').attr('value',"");
				if( data.status == 'failure' )
				{
					//alert(data.message);					
				}
				else
				{
					$('#txt_code').attr('value',data.savings.savings_code);
					$('#txt_code').attr('readonly','');
					if(data.savings.savings_code != '')
					{
						$('#txt_code').attr('value',data.savings.savings_code);
						$('#txt_code').attr('readonly','readonly');
					}
					$('#type_of_deposite').attr('value',data.savings_product.type_of_deposite);
					$('#type_of_deposite').attr('readonly','readonly');	
					$('#interest_rate').attr('value',data.savings_product.interest_rate);	
					$('#interest_rate').attr('readonly','readonly');					
					$('#txt_weekly_savings').attr('value',data.savings_product.mandatory_amount_for_deposite);			
					$('#txt_weekly_savings').attr('readonly','');
					if(data.savings_product.type_of_deposite == 'MANDATORY')
					{				
						$('#txt_weekly_savings').attr('value',data.savings_product.mandatory_amount_for_deposite);
						//$('#txt_weekly_savings').attr('readonly','readonly');											
					}																									
				}
			}, "json");
		});		
		// END product change
});
</script>
<?php
	//Product list
	$product_options = array(""=>"--Select--");
	foreach($products as $product_row)
	{					
		$product_options[$product_row->id]=$product_row->name;
	}
	//Funding organization list
	$funding_organization_options = array(""=>"--Select--");
	foreach($funding_organizations as $funding_organization_row)
	{					
		$funding_organization_options[$funding_organization_row->id]=$funding_organization_row->name;
	}
	//Form Start
	//echo form_open('savings/'.(isset($row->id)?"edit":"add"));
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('saving_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("savings/$action",'',$hidden_input);
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2><?php echo $headline?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('savings')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="cbo_member">Member:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<input type="hidden" name="branch_id" id="branch_id" value="<?php echo isset($row->branch_id)?$row->branch_id:""?>" />
							<input type="hidden" name="samity_id" id="samity_id" value="<?php echo isset($row->samity_id)?$row->samity_id:""?>" />
							<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />			
							<input type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>	
							</div>
						</li> 
						<li>
							<label for="cbo_product">Product:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_product', $product_options,set_value('cbo_product',(isset($row->saving_products_id)?$row->saving_products_id:"")),'id="cbo_product"','class=" input_select"');?><?php echo form_error('cbo_product'); ?>			
							<?php //echo form_dropdown('cbo_product', $product_options,set_value('cbo_product',(isset($row->saving_products_id)?$row->saving_products_id:"")),'id="cbo_product"');?><?php //echo form_error('cbo_product'); ?>	
							</div>
						</li> 
						<li>
							<label for="type_of_deposite">Deposite Type:<em>&nbsp;</em></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'type_of_deposite','id'=>'type_of_deposite','class'=> 'input_select','maxlength="100"'),set_value('type_of_deposite',isset($row->type_of_deposite)?$row->type_of_deposite:""));?>	
							</div>
						</li> 
						<li>
							<label for="interest_rate">Interest Rate:<em>&nbsp;</em></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'interest_rate','id'=>'interest_rate','class'=> 'input_textbox'),set_value('interest_rate',isset($row->interest_rate)?$row->interest_rate:""));?>	
							</div>
						</li> 
						<li>
							<label for="cbo_funding_organization">Funding Organization:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_dropdown('cbo_funding_organization', $funding_organization_options,set_value('cbo_funding_organization',(isset($row->funding_organization_id)?$row->funding_organization_id:"")),'id="cbo_funding_organization"','class=> "input_select"');?><?php echo form_error('cbo_funding_organization'); ?>
							</div>
						</li> 		
						<li>
							<label for="txt_code">Code:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php if(isset($row->id)):?>
							<?php echo form_input(array('name'=>'txt_code','id'=>'txt_code','readonly'=>'readonly','class'=> 'input_textbox','maxlength'=>'100'),set_value('txt_code',isset($row->code)?$row->code:""));?><?php echo form_error('txt_code');?>	
							<?php else: echo form_input(array('name'=>'txt_code','id'=>'txt_code','class'=> 'input_textbox','maxlength'=>'100'),set_value('txt_code',isset($row->code)?$row->code:""));?><?php echo form_error('txt_code'); endif;?>
							</div>
						</li> 
						<li>
							<label for="txt_weekly_savings">Weekly Savings Amount:<em>&nbsp;</em></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_weekly_savings','id'=>'txt_weekly_savings','class'=> 'input_textbox'),set_value('txt_weekly_savings',isset($row->weekly_savings)?$row->weekly_savings:""));?><?php echo form_error('txt_weekly_savings'); ?>
							</div>
						</li> 
						<li>
							<label for="txt_opening_date">Opening Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_opening_date','id'=>'txt_opening_date','class'=>"date_picker"),set_value('txt_opening_date',isset($row->opening_date)?$row->opening_date:""));?><?php echo form_error('txt_opening_date'); ?>
							<div class="hints"> YYYY-MM-DD</div>
							</div>
						</li>				
					</ol>
				</div>
			</td>
			<td valign="top" style="background:url(<?php echo base_url();?>media/images/alpona.gif) no-repeat bottom right;">
				<p class="helper"></p>
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('savings')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
