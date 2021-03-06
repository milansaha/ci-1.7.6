<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
    $(function(){
   // $("#txt_disburse_date").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>	
<script type="text/javascript">
$(document).ready(function() {
        $('#txt_first_repayment_date').attr('readonly',"readonly");
        //$('#cbo_product').empty();
        $("#txt_mode_of_interest").attr('value','PER_THOUSAND (DAILY)');
        $("#txt_interest_calculation_method").attr('value','Flat');
        $('#txt_total_payable_amount').attr('readonly',"readonly");
        $('#txt_interest_amount').attr('readonly',"readonly");
        $('#txt_installment_amount').attr('readonly',"readonly");
        //$('#cbo_product').append('<option value = "">--Select--</option>');
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
			$("#member_id").attr('value',tmp[0]);
			
			// Product information
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_member_id = tmp[0];
			
			$.post("<?php echo site_url('one_time_loan_accounts/ajax_for_get_loan_product_list_by_member') ?>", { member_id: selected_member_id },
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
					//$('#from_samity_row').removeAttr('style');
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
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_product_id = $("#cbo_product").val();
			var selected_member_id = $("#member_id").val();
			$.post("<?php echo site_url('loans/ajax_for_get_loan_cycle_by_product_and_member') ?>", { product_id: selected_product_id,member_id: selected_member_id},
			function(data)
			{
				//alert(data.status)
				$('#status').html("");
				$('#txt_cycle').attr('value',"");
				$('#txt_interest_rate').attr('value',"");
				$('#cbo_interest_calculation_method').attr('value',"");
				if( data.status == 'failure' )
				{
					//alert(data.message);
				}
				else
				{
					$('#txt_cycle').attr('value',data.loan.cycle_no);
					$('#txt_cycle').attr('readonly',"readonly");
					$('#txt_interest_rate').attr('value',data.product.interest_rate);
				}
			}, "json");

			// Start Loan Auto Code
			$('#txt_customized_loan_no').html("");
			$.post("<?php echo site_url('one_time_loan_accounts/ajax_for_get_loan_auto_id_by_samity_id_and_member_id') ?>", { product_id: selected_product_id,member_id: selected_member_id},
			function(data)
			{
				$('#status').html("");
				$('#txt_customized_loan_no').val(data.loan_code);
				$('#txt_customized_loan_no').attr('readonly',"readonly");
			}, "json");
			// End Loan Auto Code 		
		});		
		// END product change			

                // loan period in month
		$("#txt_loan_amount").change(
			function()
			{
                                var loan_amount = $("#txt_loan_amount").val();
                                $('#txt_total_payable_amount').attr('value',loan_amount);                              
                                $('#txt_interest_amount').attr('value','0');                                
                                $('#txt_installment_amount').attr('value',loan_amount);                               
			});
		// END loan period in month

                // loan period in month
		$("#cbo_loan_period_in_month").change(
			function()
			{
				
                                var loan_amount = $("#txt_loan_amount").val();
                                $('#txt_first_repayment_date').empty();
                                var loan_period_in_month = $("#cbo_loan_period_in_month").val();
				var disburse_date = $("#txt_disburse_date").val();
                                var month=0;
                                var day=disburse_date.substring(8,10);
                                var year=disburse_date.substring(0,4);				
				
                                if(loan_period_in_month=='1')
				{                                
                                    month=parseInt(disburse_date.substring(5,7))+1;
                                }
                                if(loan_period_in_month=='3')
				{
                                     month=parseInt(disburse_date.substring(5,7))+3;
                                }
                                if(loan_period_in_month=='4')
				{
                                    month=parseInt(disburse_date.substring(5,7))+4;
                                }
                                if(loan_period_in_month=='6')
				{
                                    month=parseInt(disburse_date.substring(5,7))+6;
                                }
                                if(loan_period_in_month=='12')
				{
                                    month=parseInt(disburse_date.substring(5,7))+12;
                                }
                                if(month>12)
                                {
                                    year=parseInt(disburse_date.substring(0,4))+1;
                                    month=month-12;
                                }

				if(month=='04'|| month=='06'||month=='09'||month=='11'){
					day=30;
				}
				else if(month=='02'){
					if(year%4==0)
						day=29;
					else
						day=28; 
				} 
				else{
					day=31;
				}
				
                                first_repayment_date = year+'-'+month+'-'+day;
                                $('#txt_first_repayment_date').attr('value',first_repayment_date);
                                $('#txt_first_repayment_date').attr('readonly',"readonly");                                
			});
		// END loan period in month
});
</script>
<style>
</style>
<?php

	$loan_purpose_options = array(""=>"--Select--");
	foreach($loan_purposes as $loan_purpose_row)
	{					
		$loan_purpose_options[$loan_purpose_row->id]=$loan_purpose_row->name;
	}
         $loan_products = array(""=>"--Select--");
	 if(isset($products)){                
            foreach($products as $product_row)
            {                   
                //print_r($product_row->product_id);die;
                $loan_products[$product_row->product_id]=$product_row->product_name.'-'.$product_row->funding_organization_name;
            }            
        }
        foreach($loan_period_in_month as $key=>$loan_period_in_month_row)
	{
		$loan_period_in_month_options[$key]=$loan_period_in_month_row;
	}
	foreach($current_status as $key=>$current_status_row)
	{					
		$current_status_options[$key]=$current_status_row;
	}	
	$po_funding_organization_options = array(""=>"--Select--");
	foreach($po_funding_organizations as $po_funding_organization_row)
	{					
		$po_funding_organization_options[$po_funding_organization_row->id]=$po_funding_organization_row->name;
	}
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('loan_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("one_time_loan_accounts/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('one_time_loan_accounts')."'"));?>
				</div>
			</td>
		</tr>
    </table>
	<table class="uiInfoTable" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr><th colspan="4">Member and Loan Details</th></tr>
			<tr>
                            <td><label for="cbo_member">Member:<em>*</em></label></td>
                            <td><label for="txt_disburse_date">Disbursement Date:<em>*</em></label></td>
                            <td><label for="cbo_product">Product:<em>*</em></label></td>
                            <td><label for="txt_customized_loan_no">Loan Code:<em>*</em></label></td></tr>
			<tr>
                            <td><input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />
                                <?php if($action=='edit'):?>
                                <input readonly="readonly" type="text" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>
                                <?php else:?>
                                <input style="padding: 0pt 0pt 0pt 20px; width: 160px;" type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>
                                <?php endif;?></td>
			    <td>
                                <?php $current_date=$this->session->userdata('system.software_date');?>
				<?php echo form_input(array('name'=>'txt_disburse_date','id'=>'txt_disburse_date','readonly'=>'readonly'),set_value('txt_disburse_date',isset($row->disburse_date)?$row->disburse_date:date('Y-m-d',strtotime( $current_date['current_date'])),'id="disburse_date"'));?>
				<?php echo form_error('txt_disburse_date'); ?></td>
				<td>
                                    <?php if($action=='edit'):?>
                                    <?php $pro_name = $row->product_short_name . ' - ' . $row->funding_organization_name;?>
                                    <?php echo form_hidden('cbo_product',isset($row->product_id)?$row->product_id:"");?>
                                    <?php echo form_input(array('name'=>'txt_product_name','id'=>'txt_product_name','readonly'=>'readonly','class'=>'input_select'),set_value('txt_product_name',$pro_name));?><?php echo form_error('cbo_product');?>
                                    <?php else:?>
                                    <?php //echo $row->product_id;
                                          echo form_dropdown('cbo_product', $loan_products,set_value('cbo_product',isset($row->product_id)?$row->product_id:""),'id="cbo_product"','class="input_select"'); ?><?php echo form_error('cbo_product');?>
                                    <?php endif;?></td>
                            <td><?php echo form_input(array('name'=>'txt_customized_loan_no','id'=>'txt_customized_loan_no','readonly'=>'readonly'),set_value('txt_customized_loan_no',isset($row->customized_loan_no)?$row->customized_loan_no:""));?><?php echo form_error('txt_customized_loan_no'); //echo $row->customized_loan_no?></td></tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>
		<tbody class="aaa">
			<tr><th colspan="4">Loan Configuration</th></tr>
			<tr>
                            <td><label for="txt_loan_application_no">Loan Application No:<em>*</em></label></td>
                            <td><label for="txt_loan_amount">Loan Amount:<em>*</em></label></td>
                            <td><label for="cbo_loan_period_in_month">Loan Period in Month:<em>*</em></label></td>
                            <td><label for="txt_first_repayment_date">First Repay Date:<em>*</em></label></td></tr>
			<tr>
                            <td><?php echo form_input(array('name'=>'txt_loan_application_no','id'=>'txt_loan_application_no'),set_value('txt_loan_application_no',isset($row->loan_application_no)?$row->loan_application_no:""));?><?php echo form_error('txt_loan_application_no'); ?></td>
                            <td><?php echo form_input(array('name'=>'txt_loan_amount','id'=>'txt_loan_amount'),set_value('txt_loan_amount',isset($row->loan_amount)?$row->loan_amount:""));?><?php echo form_error('txt_loan_amount'); ?></td>
                            <td><?php echo form_dropdown('cbo_loan_period_in_month', $loan_period_in_month_options,set_value('cbo_loan_period_in_month',isset($row->loan_period_in_month)?$row->loan_period_in_month:""),'id="cbo_loan_period_in_month"'); ?><?php echo form_error('cbo_loan_period_in_month'); ?></td>
                            <td><?php echo form_input(array('name'=>'txt_first_repayment_date','id'=>'txt_first_repayment_date','class'=>'date_picker'),set_value('txt_first_repayment_date',isset($row->first_repayment_date)?$row->first_repayment_date:""));?><?php echo form_error('txt_first_repayment_date');?></td></tr>
			<tr>
                            <td><label for="cbo_loan_purpose">Loan Purpose:<em>*</em></label></td>
                            <td><label for="txt_insurance_amount">Insurance Amount:</label></td>
                            <td><label for="txt_cycle">Loan Cycle:</label></td></tr>
			<tr>
                            <?php //echo form_input(array('name'=>'txt_loan_period_in_month','id'=>'txt_loan_period_in_month'),set_value('txt_loan_period_in_month',isset($row->loan_period_in_month)?$row->loan_period_in_month:""));?><?php echo form_error('txt_loan_period_in_month');?>
                            <td><?php echo form_dropdown('cbo_loan_purpose', $loan_purpose_options,set_value('cbo_loan_purpose',isset($row->purpose_id)?$row->purpose_id:""),'id="cbo_loan_purpose"'); ?><?php echo form_error('cbo_loan_purpose');?></td>
                            <td><?php echo form_input(array('name'=>'txt_insurance_amount','id'=>'txt_insurance_amount'),set_value('txt_insurance_amount',isset($row->insurance_amount)?$row->insurance_amount:""));?><?php echo form_error('txt_insurance_amount');?></td>
                            <td><?php echo form_input(array('name'=>'txt_cycle','id'=>'txt_cycle','readonly'=>'readonly'),set_value('txt_cycle',isset($row->cycle)?$row->cycle:""));?><?php echo form_error('txt_cycle'); ?></td></tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>		
		<tbody>
			<tr><th colspan="4">Interest Calculation</th></tr>
			<tr>
                            <td><label for="txt_mode_of_interest">Mode of Interest:<em>*</em></label></td>
                            <td><label for="txt_interest_calculation_method">Interest Calculation Method:<em>*</em></label></td>
                            <td><label for="txt_interest_rate">Interest Rate:<em>*</em></label></td>
                            <td><label for="txt_discount_interest_amount">Interest Discount Amount:<em>&nbsp;</em></label></td></tr>
			<tr>
                            <td><?php //echo form_dropdown('cbo_mode_of_interest', $mode_of_interest_options,set_value('cbo_mode_of_interest',isset($row->mode_of_interest)?$row->mode_of_interest:""),'id="cbo_mode_of_interest"'); ?><?php //echo form_error('cbo_mode_of_interest'); ?>
                                <?php echo form_input(array('name'=>'txt_mode_of_interest','id'=>'txt_mode_of_interest','readonly'=>'readonly'),set_value('txt_mode_of_interest',isset($row->interest_calculation_method)?$row->interest_calculation_method:""));?><?php echo form_error('txt_mode_of_interest');?></td>
                            <td><?php echo form_input(array('name'=>'txt_interest_calculation_method','id'=>'txt_interest_calculation_method','readonly'=>'readonly'),set_value('txt_interest_calculation_method',isset($row->interest_calculation_method)?$row->interest_calculation_method:""));?><?php echo form_error('txt_interest_calculation_method');?></td>
                            <td><?php echo form_input(array('name'=>'txt_interest_rate','id'=>'txt_interest_rate','readonly'=>'readonly'),set_value('txt_interest_rate',isset($row->interest_rate)?$row->interest_rate:""));?><?php echo form_error('txt_interest_rate');?></td>
                            <td><?php echo form_input(array('name'=>'txt_discount_interest_amount','id'=>'txt_discount_interest_amount'),set_value('txt_discount_interest_amount',isset($row->discount_interest_amount)?$row->discount_interest_amount:""));?><?php echo form_error('txt_discount_interest_amount');?></td></tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>		
		<tbody>
			<tr><th colspan="4">Payments</th></tr>
			<tr><td><label for="txt_total_payable_amount">Total Repay Amount:</label></td>
                            <td><label for="txt_interest_amount">Interest Amount:</label></td>
                            <td><label for="txt_interest_rate">Installment Amount:</label></td>
                            <td></td></tr>
			<tr>
				<td><?php echo form_input(array('name'=>'txt_total_payable_amount','id'=>'txt_total_payable_amount'),set_value('txt_total_payable_amount',isset($row->total_payable_amount)?$row->total_payable_amount:""));?><?php echo form_error('txt_total_payable_amount'); ?></td>
				<td><?php echo form_input(array('name'=>'txt_interest_amount','id'=>'txt_interest_amount'),set_value('txt_interest_amount',isset($row->interest_amount)?$row->interest_amount:""));?><?php echo form_error('txt_interestxt_interest_amountt_amount');?></td>
                                <td><?php echo form_input(array('name'=>'txt_installment_amount','id'=>'txt_installment_amount'),set_value('txt_installment_amount',isset($row->installment_amount)?$row->installment_amount:""));?><?php echo form_error('txt_installment_amount');?></td>
				<td></td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>		
		<tbody>
			<tr><th colspan="4">Guarantor's Details</th></tr>
			<tr><td rowspan="2" style="font-size:11px;color: #666666;font-weight:bold;font-family: lucida grande,tahoma,verdana,arial,sans-serif;border-bottom:solid 1px #dadada;">Guarantor#1</td>
				<td><label for="txt_guarantor_name_1">Name:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_relationship_1">Relation:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_address_1">Address:<em>&nbsp;</em></label></td></tr>
			<tr>
				<td><?php echo form_input(array('name'=>'txt_guarantor_name_1','id'=>'txt_guarantor_name_1','maxlength'=>'200'),set_value('txt_guarantor_name_1',isset($row->guarantor_name_1)?$row->guarantor_name_1:""));?><?php echo form_error('txt_guarantor_name_1'); ?></td>
				<td><?php echo form_input(array('name'=>'txt_guarantor_relationship_1','id'=>'txt_guarantor_relationship_1','maxlength'=>'200'),set_value('txt_guarantor_relationship_1',isset($row->guarantor_relationship_1)?$row->guarantor_relationship_1:""));?><?php echo form_error('txt_guarantor_relationship_1');?></td>
				<td><?php echo form_input(array('name'=>'txt_guarantor_address_1','id'=>'txt_guarantor_address_1','maxlength'=>'200'),set_value('txt_guarantor_address_1',isset($row->guarantor_address_1)?$row->guarantor_address_1:""));?><?php echo form_error('txt_guarantor_address_1');?></td></tr>			
			<tr>
				<td rowspan="2" style="font-size:11px;color: #666666;font-weight:bold;font-family: lucida grande,tahoma,verdana,arial,sans-serif;border-bottom:solid 1px #dadada;">Guarantor#2</td>
				<td><label for="txt_guarantor_name_2">Name:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_relationship_2">Relation:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_address_2">Address:<em>&nbsp;</em></label></td></tr>
			<tr>
				<td><?php echo form_input(array('name'=>'txt_guarantor_name_2','id'=>'txt_guarantor_name_2','class'=>'input_textbox'),set_value('txt_guarantor_name_2',isset($row->guarantor_name_2)?$row->guarantor_name_2:""));?><?php echo form_error('txt_guarantor_name_2'); ?></td>
				<td><?php echo form_input(array('name'=>'txt_guarantor_relationship_2','id'=>'txt_guarantor_relationship_2','class'=>'input_textbox'),set_value('txt_guarantor_relationship_2',isset($row->guarantor_relationship_2)?$row->guarantor_relationship_2:""));?><?php echo form_error('txt_guarantor_relationship_2');?></td>
				<td><?php echo form_input(array('name'=>'txt_guarantor_address_2','id'=>'txt_guarantor_address_2','class'=>'input_textarea'),set_value('txt_guarantor_address_2',isset($row->guarantor_address_2)?$row->guarantor_address_2:""));?><?php echo form_error('txt_guarantor_address_2');?></td>				
			</tr>
		</tbody>
		<style>
		loan_submit_button{
			    
				border-color: #EEEEEE #DEDEDE #DEDEDE #EEEEEE;
				border-style: solid;
				border-width: 1px;
				color: #529214;
				cursor: pointer;
				display: block;
				float: left;
				font-family: "Lucida Grande",Tahoma,Arial,Verdana,sans-serif;
				font-size: 12px;
				font-weight: bold;
				margin: 0 7px 0 0;
				padding: 6px 9px 6px 26px;
				text-decoration: none;
				width: 100px;
			}
		.loan_submit_button:hover{
				background-color:#E6EFC2;
				border:1px solid #C6D880;
				color:#529214;
			}
		</style>
                <tbody>
			<tr class="spacer"><td colspan="4"><hr></td></tr>
			<tr>
			<td colspan="4" align="left" class="formBottomBar">
                            <div class="buttons" style="margin:0px 0px 0px 20px;">
                            <?php //echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'loan_submit_button','style'=>'background: url("../images/apply2.png") no-repeat scroll 5px 6px;background-color:#F5F5F5;width:100px;padding:6px 9px 6px 26px;'),'Save');?>
                            <?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive','style'=>'width:auto;padding: 6px 9px 6px 26px;border-color: #EEEEEE #DEDEDE #DEDEDE #EEEEEE;border-style: solid;border-width: 1px;'),'Save');?>
                            <?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
                            <?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loans')."'"));?>
			</div></td></tr>
		</tbody>		
	</table>
</fieldset>
<?php echo form_close(); ?>