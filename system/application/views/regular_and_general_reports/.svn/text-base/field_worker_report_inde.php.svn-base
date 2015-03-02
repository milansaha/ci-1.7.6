<table class="report-header" width="100%" border="0">	
	<tbody><tr>
		  	<td align="center" colspan="16"><?php $this->load->view('/elements/report_header');?></td>
	</tr>
	<tr>
		<td align="center"  colspan="16"><?php echo $headline ?></td>
	</tr>   
   	<tr>
		<td width="14%">&nbsp;</td>
	</tr>
	
    <tr> 
    		<th class="align-left">Branch Name &amp; Code </th>
		<td class="align-left"><b>:</b><?php echo "{$report_header_info['branch_name']} ({$report_header_info['branch_code']})" ?></td>
			<th class="align-left">Samity Name</th>
		<td class="align-left"><b>:</b><?php echo "{$report_header_info['samity_name']} ({$report_header_info['samity_code']})" ?></td>
		<th class="align-left">Samity Day</th>
		<td class="align-left"><b>:</b><?php echo "{$report_header_info['samity_day']}" ?></td>
	</tr>
	<tr>
	
			<th class="align-left">Field Worker Name</th>
		<td class="align-left"><b>:</b><?php echo "{$report_header_info['field_officer_name']}" ?></td>
		<th class="align-left">Product Name</th>
		<td class="align-left"><b>:</b><?php echo "{$report_header_info['product_mnemonic']}" ?></td>
	</tr>
	<tr>
		<th class="align-left">Month</th>
	<td class="align-left"><b>:</b><?php echo "{$report_header_info['report_month']}" ?></td>
	
			<th class="align-left">Print Date&nbsp;</th>
		<td class="align-left"><b>:</b><?php echo "{$report_header_info['print_date']}" ?></td>
	</tr>
	
  <tr>
    <td>&nbsp;</td>
  </tr>
</tbody></table>
<?php 
$this->load->helper('number');
$working_days =array();

//print_r(array_splice($working_days));
 ?>
<table class="report-body" border="1" cellspacing="0">
  <tbody><tr>
    <th rowspan="2" width="34"><div align="center">SL. No. </div></th>
    <th rowspan="2" width="61"><div align="center">Field Worker's Name </div></th>
    <th colspan="3"><div align="center">Current Loan </div></th>

    <th colspan="3"><div align="center">Outstanding Opening Balance </div></th>
    <th colspan="3"><div align="center">Disbursement</div></th>
    <th colspan="3"><div align="center">Recovery</div></th>
    <th colspan="3"><div align="center">Outstanding Closing Balance</div></th>
    <th colspan="3"><div align="center">Outstanding Principal</div></th>
    <th colspan="3"><div align="center">Outstanding Service Charge</div></th>

  </tr>
  <tr>
    <th width="34"><div align="center">Male</div></th>
    <th width="46"><div align="center">Female</div></th>
    <th width="40"><div align="center">Total</div></th>
    <th width="38"><div align="center">Male</div></th>
    <th width="49"><div align="center">Female</div></th>

    <th><div align="center">Total</div></th>
    <th width="34"><div align="center">Male</div></th>
    <th width="48"><div align="center">Female</div></th>
    <th width="31"><div align="center">Total</div></th>
    <th width="31"><div align="center">Male</div></th>
    <th width="44"><div align="center">Female</div></th>

    <th width="31"><div align="center">Total</div></th>
    <th><div align="center">Male</div></th>
    <th><div align="center">Female</div></th>
    <th><div align="center">Total</div></th>
    <th><div align="center">Male</div></th>
    <th><div align="center">Female</div></th>

    <th><div align="center">Total</div></th>
    <th width="13"><div align="center">Male</div></th>
    <th width="48"><div align="center">Female</div></th>
    <th width="43"><div align="center">Total</div></th>
  </tr>
  <tr>
    <th><div align="center">1</div></th>

    <th><div align="center">2</div></th>
    <th><div align="center">3</div></th>
    <th><div align="center">4</div></th>
    <th><div align="center">5</div></th>
    <th><div align="center">6</div></th>
    <th><div align="center">7</div></th>

    <th><div align="center">8</div></th>
    <th><div align="center">9</div></th>
    <th><div align="center">10</div></th>
    <th><div align="center">11</div></th>
    <th><div align="center">12</div></th>
    <th><div align="center">13</div></th>

    <th><div align="center">14</div></th>
    <th><div align="center">15</div></th>
    <th><div align="center">16</div></th>
    <th><div align="center">17</div></th>
    <th><div align="center">18</div></th>
    <th><div align="center">19</div></th>

    <th><div align="center">20</div></th>
    <th><div align="center">21</div></th>
    <th><div align="center">22</div></th>
    <th><div align="center">23</div></th>
  </tr>
  <?php
  $opening_recoverable_amount_m = 0.0;
  $opening_recovered_amount_m = 0.0;
  foreach($officer_wise_loan_info as $officer_wise_loan) {
  	
	$opening_recoverable_amount_m = $officer_wise_loan->op_current_loan_m + $officer_wise_loan->op_interest_amount_f - $officer_wise_loan->op_discount_interest_amount_f;
	
	$opening_recovered_amount_m = $officer_wise_loan->op_paid_amount_m;
   ?>
    <tr>
      <td>1</td>

    <td class="align-left"><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>
    <td class="align-right"><?php printf("%-8.2f",$officer_wise_loan->op_current_loan_m)?></td>
    <td class="align-right"><?php printf("%-8.2f",$officer_wise_loan->op_current_loan_f)?></td>
		    <td><?php printf("%-8.2f",$officer_wise_loan->op_current_loan_m+$officer_wise_loan->op_current_loan_f+$officer_wise_loan->op_current_loan_m+$officer_wise_loan->op_current_loan_m)?></td>
		    <td class="align-right"><?php printf("%-8.2f",$officer_wise_loan->op_current_loan_f)?></td>
    <td class="align-right"><?php printf("%-8.2f",$officer_wise_loan->op_current_loan_f)?></td>
	<td><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>
	    <td class="align-right"><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>
	<td class="align-right"><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>
		<td><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>
	   <td class="align-right"><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>
    <td class="align-right"><?php printf("%s",$officer_wise_loan->field_officer_name)?></td>

	    <td>0.00    </td>
		
    <td>0.00    </td>
    <td>0.00    </td>
    <td>0.00    </td>
    <td>
	0.00    </td>

    <td>
	0.00    </td>
    <td>
	0.00    	
	</td>
    <td>0.00    </td>
    <td>0.00    </td>
    <td>0.00    </td>

  </tr>
    <?php
	}
   ?>
    <tr>
    <th colspan="2">Total </th>
	<td>65445000.00</td>
    <td>37656000.00</td>
    <td>103101000.00</td>
    <td>29614390.00</td>

    <td>10295360.00</td>
    <td>39909750.00</td>
    <td>16000.00</td>
    <td>442000.00</td>
    <td>458000.00</td>
	<td>225700.00</td>

	<td>131675.00</td>
    <td>357375.00</td>
   <td>29404690.00</td>
   <td>10605685.00</td>
    <td>40010375.00</td>
    <td>26137502.22</td>

    <td>9427275.56</td>
    <td>35564777.78</td>
    <td>3267187.78</td>
    <td>1178409.44</td>
    <td>4445597.22</td>
  </tr>

  
  </tbody></table>
  
  <br>
<br>
<br>
<br>
<table class="report-footer" align="center">

  <tbody><tr>
  
  <td width="4%">&nbsp;</td>
    <td class="report-footer-margin" width="19%"><strong>Prepared By</strong></td>
	<td width="17%">&nbsp;</td>

    <td class="report-footer-margin" width="20%"><strong>Verified By </strong></td>
	<td width="18%">&nbsp;</td>
    <td class="report-footer-margin" width="17%"><strong>Approved By</strong> </td>
	<td width="5%">&nbsp;</td>
  </tr>
</tbody></table>
  