<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
	<script type="text/javascript">
	$(function(){
	$("#txt_first_repayment_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_disburse_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>	
<script type="text/javascript">
$(document).ready(function() {
      //  $('#cbo_product').empty();
      //  $('#cbo_product').append('<option value = "">--Select--</option>');
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
			
			$.post("<?php echo site_url('loans/ajax_for_get_loan_product_list_by_member') ?>", { member_id: selected_member_id },
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
					function() 
					{
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
				//	alert(data.interest_calculation_method);		
					$('#cbo_interest_calculation_method').attr('value',data.product.interest_calculation_method);
					
					var interest_rate = $("#txt_interest_rate").val();
					var mode_of_interest = $("#cbo_mode_of_interest").val();				
					var period_in_month = $("#txt_loan_period_in_month").val();
					var loan_amount = $("#txt_loan_amount").val();
					if(loan_amount>0 && mode_of_interest=='PER_HUNDRED')
					{
						//var interest_amount= ((loan_amount*(interest_rate/100))/12)*period_in_month;
						var interest_amount=(loan_amount*interest_rate*(period_in_month/12))/100;
						$('#txt_interest_amount').attr('value',interest_amount);	
						$('#txt_interest_amount').attr('readonly',"readonly");
					
						var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
						$('#txt_total_payable_amount').attr('value',total_repay);
						$('#txt_total_payable_amount').attr('readonly',"readonly");		

						var repayment_no = $("#txt_number_of_installment").val();
						var installment_amount=total_repay/repayment_no;
						if(repayment_no>0)		
						{
							$('#txt_installment_amount').attr('value',installment_amount);
							$('#txt_installment_amount').attr('readonly',"readonly");
						}			
					}
					if(loan_amount>0 && mode_of_interest=='PER_THOUSAND')
					{
						var interest_amount=(loan_amount*interest_rate*(period_in_month*30/360))/1000;
						$('#txt_interest_amount').attr('value',interest_amount);	
						$('#txt_interest_amount').attr('readonly',"readonly");
					
						var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
						$('#txt_total_payable_amount').attr('value',total_repay);
						$('#txt_total_payable_amount').attr('readonly',"readonly");		

						var repayment_no = $("#txt_number_of_installment").val();
						var installment_amount=total_repay/repayment_no;
						if(repayment_no>0)		
						{
							$('#txt_installment_amount').attr('value',installment_amount);
							$('#txt_installment_amount').attr('readonly',"readonly");
						}
					}									
				}
			}, "json");
			
			// Start Loan Auto Code
			$('#txt_customized_loan_no').html("");
			$.post("<?php echo site_url('loans/ajax_for_get_loan_auto_id_by_samity_id_and_member_id') ?>", { product_id: selected_product_id,member_id: selected_member_id},
			function(data)
			{
				$('#status').html("");
				$('#txt_customized_loan_no').val(data.loan_code);
				$('#txt_customized_loan_no').attr('readonly',"readonly");
			}, "json");
			// End Loan Auto Code 
			
			
		});		
		// END product change
		
		// interest rate change
		$("#txt_interest_rate").change(
			function() 
			{							
				var loan_amount = $("#txt_loan_amount").val();
				var interest_rate = $("#txt_interest_rate").val();
				var mode_of_interest = $("#cbo_mode_of_interest").val();				
				var period_in_month = $("#txt_loan_period_in_month").val();
				
				if(loan_amount>0 && mode_of_interest=='PER_HUNDRED')
				{
					//var interest_amount= ((loan_amount*(interest_rate/100))/12)*period_in_month;
					var interest_amount=(loan_amount*interest_rate*(period_in_month/12))/100;
					$('#txt_interest_amount').attr('value',interest_amount);	
					$('#txt_interest_amount').attr('readonly',"readonly");
					
					var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
					$('#txt_total_payable_amount').attr('value',total_repay);
					$('#txt_total_payable_amount').attr('readonly',"readonly");		

					var repayment_no = $("#txt_number_of_installment").val();
					var installment_amount=total_repay/repayment_no;
					if(repayment_no>0)		
					{
						$('#txt_installment_amount').attr('value',installment_amount);
						$('#txt_installment_amount').attr('readonly',"readonly");
					}			
				}
				if(loan_amount>0 && mode_of_interest=='PER_THOUSAND')
				{
					var interest_amount=(loan_amount*interest_rate*(period_in_month*30/360))/1000;
					$('#txt_interest_amount').attr('value',interest_amount);	
					$('#txt_interest_amount').attr('readonly',"readonly");
					
					var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
					$('#txt_total_payable_amount').attr('value',total_repay);
					$('#txt_total_payable_amount').attr('readonly',"readonly");		

					var repayment_no = $("#txt_number_of_installment").val();
					var installment_amount=total_repay/repayment_no;
					if(repayment_no>0)		
					{
						$('#txt_installment_amount').attr('value',installment_amount);
						$('#txt_installment_amount').attr('readonly',"readonly");
					}
				}											
			});		
		// END interest rate change
		
		// period in month change
		$("#txt_loan_period_in_month").change(
			function() 
			{							
				var loan_amount = $("#txt_loan_amount").val();
				var interest_rate = $("#txt_interest_rate").val();
				var mode_of_interest = $("#cbo_mode_of_interest").val();				
				var period_in_month = $("#txt_loan_period_in_month").val();
				
				if(loan_amount>0 && mode_of_interest=='YEARLY_PER_HUNDRED')
				{
					//var interest_amount= ((loan_amount*(interest_rate/100))/12)*period_in_month;
					var interest_amount=(loan_amount*interest_rate*(period_in_month/12))/100;
					$('#txt_interest_amount').attr('value',interest_amount);	
					$('#txt_interest_amount').attr('readonly',"readonly");
					
					var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
					$('#txt_total_payable_amount').attr('value',total_repay);
					$('#txt_total_payable_amount').attr('readonly',"readonly");	

					var repayment_no = $("#txt_number_of_installment").val();
					var installment_amount=total_repay/repayment_no;
					if(repayment_no>0)		
					{
						$('#txt_installment_amount').attr('value',installment_amount);
						$('#txt_installment_amount').attr('readonly',"readonly");
					}						
				}
				if(loan_amount>0 && mode_of_interest=='DAILY_PER_THOUSAND')
				{
					var interest_amount=(loan_amount*interest_rate*(period_in_month*30/360))/1000;
					$('#txt_interest_amount').attr('value',interest_amount);	
					$('#txt_interest_amount').attr('readonly',"readonly");
					
					var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
					$('#txt_total_payable_amount').attr('value',total_repay);
					$('#txt_total_payable_amount').attr('readonly',"readonly");		

					var repayment_no = $("#txt_number_of_installment").val();
					var installment_amount=total_repay/repayment_no;
					if(repayment_no>0)		
					{
						$('#txt_installment_amount').attr('value',installment_amount);
						$('#txt_installment_amount').attr('readonly',"readonly");
					}
				}																
			});		
		// END period in month change

		// loan amount change
		$("#txt_loan_amount").change(
			function() 
			{							
				var loan_amount = $("#txt_loan_amount").val();
				var interest_rate = $("#txt_interest_rate").val();
				var mode_of_interest = $("#cbo_mode_of_interest").val();				
				var period_in_month = $("#txt_loan_period_in_month").val();					
				
				if(loan_amount>0 && mode_of_interest=='PER_THOUSAND')
				{
					//var interest_amount= ((loan_amount*(interest_rate/100))/12)*period_in_month;
					var interest_amount=(loan_amount*interest_rate*(period_in_month/12))/100;
					$('#txt_interest_amount').attr('value',interest_amount);	
					$('#txt_interest_amount').attr('readonly',"readonly");
				
					var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
					$('#txt_total_payable_amount').attr('value',total_repay);
					$('#txt_total_payable_amount').attr('readonly',"readonly");						
										
					var repayment_no = $("#txt_number_of_installment").val();
					var installment_amount=total_repay/repayment_no;
					if(repayment_no>0)		
					{
						$('#txt_installment_amount').attr('value',installment_amount);
						$('#txt_installment_amount').attr('readonly',"readonly");
					}													
				}
				if(loan_amount>0 && mode_of_interest=='PER_HUNDRED')
				{
					var interest_amount=(loan_amount*interest_rate*(period_in_month*30/360))/1000;
					$('#txt_interest_amount').attr('value',interest_amount);	
					$('#txt_interest_amount').attr('readonly',"readonly");
				
					var total_repay=parseInt(loan_amount)+parseFloat(interest_amount);			
					$('#txt_total_payable_amount').attr('value',total_repay);
					$('#txt_total_payable_amount').attr('readonly',"readonly");						
										
					var repayment_no = $("#txt_number_of_installment").val();
					var installment_amount=total_repay/repayment_no;
					if(repayment_no>0)		
					{
						$('#txt_installment_amount').attr('value',installment_amount);
						$('#txt_installment_amount').attr('readonly',"readonly");
					}													
				}																		
			});		
		// END loan amount change	

		// loan repay no change
		$("#txt_number_of_installment").change(
			function() 
			{							
				var total_payable_amount = $("#txt_total_payable_amount").val();				
				var repayment_no = $("#txt_number_of_installment").val();				
				
				if(total_payable_amount>0)
				{
					var installment_amount=total_payable_amount/repayment_no;			
					$('#txt_installment_amount').attr('value',installment_amount);
					$('#txt_installment_amount').attr('readonly',"readonly");			
				}									
			});		
		// END loan amount change	
});
</script>
<style>
</style>
<?php

	$loan_products = array(""=>"--Select--");
	 if(isset($products)){                
            foreach($products as $product_row)
            {                   
                //print_r($product_row->product_id);die;
                $loan_products[$product_row->product_id]=$product_row->product_name.'-'.$product_row->funding_organization_name;
            }            
        }
	$loan_purpose_options = array(""=>"--Select--");
	foreach($loan_purposes as $loan_purpose_row)
	{					
		$loan_purpose_options[$loan_purpose_row->id]=$loan_purpose_row->name;
	}
	//
	//$interest_calculation_method_options = array(""=>"");
	foreach($interest_calculation_methods as $key=>$interest_calculation_method_row)
	{					
		$interest_calculation_method_options[$key]=$interest_calculation_method_row;
	}
	//
	//$po_funding_organization_options = array(""=>"--Select--");
	foreach($repayment_frequencies as $key=>$repayment_frequency_row)
	{					
		$repayment_frequency_options[$key]=$repayment_frequency_row;
	}
	//
	//$po_funding_organization_options = array(""=>"--Select--");
	foreach($mode_of_interest as $key=>$mode_of_interest_row)
	{					
		$mode_of_interest_options[$key]=$mode_of_interest_row;
	}
	foreach($current_status as $key=>$current_status_row)
	{					
		$current_status_options[$key]=$current_status_row;
	}	
	//
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
	echo form_open("loans/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('loans')."'"));?>
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
				<td><label for="txt_customized_loan_no">Loan Code:<em>*</em></label></td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:""?>" />
                    <?php if($action=='edit'):?>
                    <input readonly="readonly" type="text" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>
                    <?php else:?>
					<input style="padding: 0pt 0pt 0pt 20px; width: 160px;" type="text" id="member_info" value="<?php echo isset($row->member_info)?$row->member_info:""?>" /><?php echo form_error('member_id'); ?>
                    <?php endif;?>
				</td>				
				<td>
                    <?php $current_date=$this->session->userdata('system.software_date');?>
					<?php echo form_input(array('name'=>'txt_disburse_date','id'=>'txt_disburse_dat','readonly'=>'readonly'),set_value('txt_disburse_date',isset($row->disburse_date)?$row->disburse_date:date('Y-m-d',strtotime( $current_date['current_date'])),'id="disburse_date"'));?>
					<?php echo form_error('txt_disburse_date'); ?>
					
				</td>
				<td>
                    <?php if($action=='edit'):?>
                    <?php $pro_name = $row->product_short_name . ' - ' . $row->funding_organization_name;?>
                    <?php echo form_hidden('cbo_product',isset($row->product_id)?$row->product_id:"");?>
                    <?php echo form_input(array('name'=>'txt_product_name','id'=>'txt_product_name','readonly'=>'readonly','class'=>'input_select'),set_value('txt_product_name',$pro_name));?><?php echo form_error('cbo_product');?>
                    <?php else:?>
					<?php echo form_dropdown('cbo_product', $loan_products,set_value('cbo_product',isset($row->product_id)?$row->product_id:""),'id="cbo_product"','class="input_select"'); ?><?php echo form_error('cbo_product');?>
                    <?php endif;?>
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_customized_loan_no','id'=>'txt_customized_loan_no','readonly'=>'readonly'),set_value('txt_customized_loan_no',isset($row->customized_loan_no)?$row->customized_loan_no:""));?><?php echo form_error('txt_customized_loan_no'); //echo $row->customized_loan_no?>
				</td>				
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>

		<tbody class="aaa">
			<tr><th colspan="4">Loan Configuration</th></tr>
			<tr>
				<td><label for="txt_loan_application_no">Loan Application No:<em>*</em></label></td>
				<td><label for="txt_loan_amount">Loan Amount:<em>*</em></label></td>
				<td><label for="txt_first_repayment_date">First Repay Date:<em>*</em></label></td>
			</tr>
			<tr>
				<td>
					<?php echo form_input(array('name'=>'txt_loan_application_no','id'=>'txt_loan_application_no'),set_value('txt_loan_application_no',isset($row->loan_application_no)?$row->loan_application_no:""));?><?php echo form_error('txt_loan_application_no'); ?>			
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_loan_amount','id'=>'txt_loan_amount'),set_value('txt_loan_amount',isset($row->loan_amount)?$row->loan_amount:""));?><?php echo form_error('txt_loan_amount'); ?>		
				</td>
				<td>			
					<?php echo form_input(array('name'=>'txt_first_repayment_date','id'=>'txt_first_repayment_date','class'=>'date_picker'),set_value('txt_first_repayment_date',isset($row->first_repayment_date)?$row->first_repayment_date:""));?><?php echo form_error('txt_first_repayment_date');?>
				</td>
			</tr>
			<tr>
				<td><label for="cbo_repayment_frequency">Repayment Frequency:<em>*</em></label></td>
				<td><label for="txt_number_of_installment">No Of Repayment:<em>*</em></label></td>
				<td><label for="txt_loan_period_in_month">Loan Period in Month:<em>*</em></label></td>
				<td><label for="cbo_loan_purpose">Loan Purpose:<em>*</em></label></td>
			</tr>
			<tr>
				<td>
					<?php echo form_dropdown('cbo_repayment_frequency', $repayment_frequency_options,set_value('cbo_repayment_frequency',isset($row->repayment_frequency)?$row->repayment_frequency:""),'id="cbo_repayment_frequency"'); ?><?php echo form_error('cbo_repayment_frequency'); ?>
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_number_of_installment','id'=>'txt_number_of_installment'),set_value('txt_number_of_installment',isset($row->number_of_installment)?$row->number_of_installment:""));?><?php echo form_error('txt_number_of_installment'); ?>			
					<!--
					<?php echo form_dropdown('cbo_po_funding_organization', $po_funding_organization_options,set_value('cbo_po_funding_organization',isset($row->funding_org_id)?$row->funding_org_id:""),'id="cbo_po_funding_organization"'); ?><?php echo form_error('cbo_po_funding_organization');?>	
					-->
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_loan_period_in_month','id'=>'txt_loan_period_in_month'),set_value('txt_loan_period_in_month',isset($row->loan_period_in_month)?$row->loan_period_in_month:""));?><?php echo form_error('txt_loan_period_in_month');?>			
				</td>
				<td>
					<?php echo form_dropdown('cbo_loan_purpose', $loan_purpose_options,set_value('cbo_loan_purpose',isset($row->purpose_id)?$row->purpose_id:""),'id="cbo_loan_purpose"'); ?><?php echo form_error('cbo_loan_purpose');?>	
				</td>
				
			</tr>
			<tr>
				
				<td><label for="txt_insurance_amount">Insurance Amount:</label></td>
				<td><label for="txt_cycle">Loan Cycle:</label></td>
				<td></td>
				<td></td>
			</tr>
			<tr>				
				<td>
					<?php echo form_input(array('name'=>'txt_insurance_amount','id'=>'txt_insurance_amount'),set_value('txt_insurance_amount',isset($row->insurance_amount)?$row->insurance_amount:""));?><?php echo form_error('txt_insurance_amount');?>			
				</td>
				<td><?php echo form_input(array('name'=>'txt_cycle','id'=>'txt_cycle','readonly'=>'readonly'),set_value('txt_cycle',isset($row->cycle)?$row->cycle:""));?><?php echo form_error('txt_cycle'); ?>			</td>
				<td>
					
				</td>
				<td>
					
				</td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>
		
		<tbody>
			<tr><th colspan="4">Interest Calculation</th></tr>
			<tr>
				<td><label for="cbo_mode_of_interest">Mode of Interest:<em>*</em></label></td>
				<td><label for="cbo_interest_calculation_method">Interest Calculation Method:<em>*</em></label></td>
				<td><label for="txt_interest_rate">Interest Rate:<em>*</em></label></td>
				<td><label for="txt_discount_interest_amount">Interest Discount Amount:<em>&nbsp;</em></label></td>
			</tr>
			<tr>
				<td>			
					<?php echo form_dropdown('cbo_mode_of_interest', $mode_of_interest_options,set_value('cbo_mode_of_interest',isset($row->mode_of_interest)?$row->mode_of_interest:""),'id="cbo_mode_of_interest"'); ?><?php echo form_error('cbo_mode_of_interest'); ?>	
				</td>
				<td>
					<?php //echo form_dropdown('cbo_interest_calculation_method', $interest_calculation_method_options,set_value('cbo_mode_of_interest',isset($row->interest_calculation_method)?$row->interest_calculation_method:""),'id="cbo_interest_calculation_method"'); ?>
                    <?php echo form_input(array('name'=>'cbo_interest_calculation_method','id'=>'cbo_interest_calculation_method','readonly'=>'readonly'),set_value('cbo_interest_calculation_method',isset($row->interest_calculation_method)?$row->interest_calculation_method:""));?>
					<?php echo form_error('cbo_interest_calculation_method');?>
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_interest_rate','id'=>'txt_interest_rate','readonly'=>'readonly'),set_value('txt_interest_rate',isset($row->interest_rate)?$row->interest_rate:""));?><?php echo form_error('txt_interest_rate');?>
				</td>
				<td>			
					<?php echo form_input(array('name'=>'txt_discount_interest_amount','id'=>'txt_discount_interest_amount'),set_value('txt_discount_interest_amount',isset($row->discount_interest_amount)?$row->discount_interest_amount:""));?><?php echo form_error('txt_discount_interest_amount');?>		
				</td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>
		
		<tbody>
			<tr><th colspan="4">Payments</th></tr>
			<tr>
				<td><label for="txt_total_payable_amount">Total Repay Amount:</label></td>
				<td><label for="txt_interest_amount">Interest Amount:</label></td>
				<td><label for="txt_installment_amount">Installment Amount:</label></td>
				<td><label for="txt_interest_amount"><em>&nbsp;</em></label></td>
			</tr>
			<tr>
				<td>			
					<?php echo form_input(array('name'=>'txt_total_payable_amount','id'=>'txt_total_payable_amount'),set_value('txt_total_payable_amount',isset($row->total_payable_amount)?$row->total_payable_amount:""));?><?php echo form_error('txt_total_payable_amount'); ?>			
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_interest_amount','id'=>'txt_interest_amount'),set_value('txt_interest_amount',isset($row->interest_amount)?$row->interest_amount:""));?><?php echo form_error('txt_interestxt_interest_amountt_amount');?>		
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_installment_amount','id'=>'txt_installment_amount'),set_value('txt_installment_amount',isset($row->installment_amount)?$row->installment_amount:""));?><?php echo form_error('txt_installment_amount');?>		
				</td>
				<td></td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>
		
		<tbody>
			<tr><th colspan="4">Guarantor's Details</th></tr>
			<tr><td rowspan="2" style="font-size:11px;color: #666666;font-weight:bold;font-family: lucida grande,tahoma,verdana,arial,sans-serif;border-bottom:solid 1px #dadada;">Guarantor#1</td>
				<td><label for="txt_guarantor_name_1">Name:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_relationship_1">Relation:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_address_1">Address:<em>&nbsp;</em></label></td>
			</tr>
			<tr>
				<td>			
					<?php echo form_input(array('name'=>'txt_guarantor_name_1','id'=>'txt_guarantor_name_1','maxlength'=>'200'),set_value('txt_guarantor_name_1',isset($row->guarantor_name_1)?$row->guarantor_name_1:""));?><?php echo form_error('txt_guarantor_name_1'); ?>			
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_guarantor_relationship_1','id'=>'txt_guarantor_relationship_1','maxlength'=>'200'),set_value('txt_guarantor_relationship_1',isset($row->guarantor_relationship_1)?$row->guarantor_relationship_1:""));?><?php echo form_error('txt_guarantor_relationship_1');?>			
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_guarantor_address_1','id'=>'txt_guarantor_address_1','maxlength'=>'200'),set_value('txt_guarantor_address_1',isset($row->guarantor_address_1)?$row->guarantor_address_1:""));?><?php echo form_error('txt_guarantor_address_1');?>			
				</td>
			</tr>			
			<tr>
				<td rowspan="2" style="font-size:11px;color: #666666;font-weight:bold;font-family: lucida grande,tahoma,verdana,arial,sans-serif;border-bottom:solid 1px #dadada;">Guarantor#2</td>
				<td><label for="txt_guarantor_name_2">Name:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_relationship_2">Relation:<em>&nbsp;</em></label></td>
				<td><label for="txt_guarantor_address_2">Address:<em>&nbsp;</em></label></td>				
			</tr>
			<tr>
				<td>			
					<?php echo form_input(array('name'=>'txt_guarantor_name_2','id'=>'txt_guarantor_name_2','class'=>'input_textbox'),set_value('txt_guarantor_name_2',isset($row->guarantor_name_2)?$row->guarantor_name_2:""));?><?php echo form_error('txt_guarantor_name_2'); ?>			
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_guarantor_relationship_2','id'=>'txt_guarantor_relationship_2','class'=>'input_textbox'),set_value('txt_guarantor_relationship_2',isset($row->guarantor_relationship_2)?$row->guarantor_relationship_2:""));?><?php echo form_error('txt_guarantor_relationship_2');?>			
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_guarantor_address_2','id'=>'txt_guarantor_address_2','class'=>'input_textarea'),set_value('txt_guarantor_address_2',isset($row->guarantor_address_2)?$row->guarantor_address_2:""));?><?php echo form_error('txt_guarantor_address_2');?>		
				</td>				
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
				</div>
				</td>
			</tr>
		</tbody>
		
	</table>
</fieldset>
<?php echo form_close(); ?>
