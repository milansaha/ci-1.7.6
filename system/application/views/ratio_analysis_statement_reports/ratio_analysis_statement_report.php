<link href="RatioAnalysisStatementReport.php_files/report.css" rel="stylesheet" type="text/css">

<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
<table width="100%" border="0" cellspacing="0"> 
    <tbody>
	  <tr>
		<th class="align-left">Branch Name(Code) </th>
		<td class="align-left"><strong>:</strong>&nbsp;&nbsp;<?php echo $get_selected_branches_info['name'];?> (<?php echo $get_selected_branches_info['code'];?>)</td>
		<th class="align-right" colspan="1" width="94">&nbsp;</th>
		<td class="align-left" colspan="1" width="118">&nbsp;</td>
	  </tr>
	  <tr>
		<th class="align-left">Address </th>
		<td class="align-left"><strong>:</strong>&nbsp;&nbsp;<?php echo $get_selected_branches_info['address'];?></td>
	  </tr>
	  <tr>
		<th class="align-left" width="188">Reporting Date</th>
		<td class="align-left" width="551"><strong>:</strong>&nbsp;&nbsp;<?php echo $reporting_date; ?></td>
		<th class="align-right" colspan="1">Print Date </th>
		<td class="align-left" colspan="1"><strong>:</strong>&nbsp;&nbsp;<?php echo date("d-m-Y"); ?></td>
	  </tr>
	</tbody>
</table>
  <br>
<table width="100%" border="1" cellspacing="0"> 
  <tbody><tr>
    <th width="6%"><div align="center">SL. No. </div></th>
    <th width="17%"><div align="center">Ratio</div></th>
    <th width="40%"><div align="center">Name of Ratio </div></th>
    <th width="10%"><div align="center">Result</div></th>
    <th width="14%"><div align="center">Standard</div></th>
    <th width="13%"><div align="center">Remarks</div></th>
  </tr> 
  <tr>
    <th><div align="center">1</div></th>
    <th><div align="center">2</div></th>
    <th><div align="center">3</div></th>
    <th><div align="center">4</div></th>
    <th><div align="center">5</div></th>
    <th><div align="center">6</div></th>
  </tr>
	<tr>
    <th rowspan="11">A.</th>
    <th rowspan="11"><p>Productive Ratio </p>    </th>
    <td><div align="left">1.Member Per Samity 
	</div></td>	
    <td>
	<div align="center"><?php echo (isset($get_productive_ratio['1']['member_per_samity']))?number_format($get_productive_ratio['1']['member_per_samity'], 2, '.', ','):'0.00'; ?></div>	
	</td>
    <td>30</td>
    <td rowspan="11">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">2.Member Per Field Worker </div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['2']['member_per_field_worker']))?number_format($get_productive_ratio['2']['member_per_field_worker'], 2, '.', ','):'0.00'; ?></div>
	</td>
    <td>300</td>
  </tr>
  <tr>
    <td><div align="left">3.Borrower Per Field Worker</div></td>
    <td>
	<div align="center"><?php echo (isset($get_productive_ratio['3']['borrower_per_field_worker']))?number_format($get_productive_ratio['3']['borrower_per_field_worker'], 2, '.', ','):'0.00'; ?></div>
	</td>
    <td>270 (90% of 300)</td>
  </tr>
  <tr>
    <td><div align="left">4.Borrower  Coverage %</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['4']['borrower_coverage']))?number_format($get_productive_ratio['4']['borrower_coverage'], 2, '.', ','):'0.00'; ?>%</div></td>
    <td>85% - 90%</td>
  </tr>
  <tr>
    <td><div align="left">5.CM/LO/Field Worker Per Samity</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['11']['field_worker_per_samity']))?number_format($get_productive_ratio['11']['field_worker_per_samity'], 2, '.', ','):'0.00'; ?></div></td>
    <td>15</td>
  </tr>
  <tr>
    <td><div align="left">6.PortFolio Per Field Worker </div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['7']['portfolio_per_field_worker']))?number_format($get_productive_ratio['7']['portfolio_per_field_worker'], 2, '.', ','):'0.00'; ?></div></td>
    <td> 
	    TK. 20,00,000	</td>
  </tr>
  <tr>
    <td><div align="left">7.Average Loan Size</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['5']['average_laon_size']))?number_format($get_productive_ratio['5']['average_laon_size'], 2, '.', ','):'0.00'; ?></div></td>
    <td>
	    TK. 12,500	</td>
  </tr>
  <tr>
    <td><div align="left">8.Outstanding per Borrower</div></td>
    <td>
	<div align="center">
	    <?php echo (isset($get_productive_ratio['8']['outstanding_per_borrower']))?number_format($get_productive_ratio['8']['outstanding_per_borrower'], 2, '.', ','):'0.00'; ?></div>
	</td>
    <td>
	    TK. 8,000	</td>
  </tr>
  <tr>
    <td><div align="left">9.Total Staff:Field Worker</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['6']['total_staff_vs_field_worker']))?number_format($get_productive_ratio['6']['total_staff_vs_field_worker'], 2, '.', ','):'0.00'; ?></div></td>
    <td>10 : 6</td>
  </tr>
  <tr>
    <td><div align="left">10.Portfolio Per Staff</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['9']['portfolio_per_staff']))?number_format($get_productive_ratio['9']['portfolio_per_staff'], 2, '.', ','):'0.00'; ?></div></td>
    <td>TK. 10,00,000</td>
  </tr>
  <tr>
    <td><div align="left">11.Portfolio Per Branch</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['10']['portfolio_per_branch']))?number_format($get_productive_ratio['10']['portfolio_per_branch'], 2, '.', ','):'0.00'; ?></div></td>
    <td>TK. 100,00,000</td>
  </tr>
  <tr>
    <th rowspan="5">B.</th>
    <th rowspan="5">Portfolio Quality Ratios </th>
    <td><div align="left">
	1.Cumulative Recovery Ratio(CRR)
    </div></td>
    <td align="center">
	    99.67 % 	</td>
    <td>
	    Min 99%	</td>
    <td rowspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">2.On Time Recovery(OTR)</td>
    <td align="center">
		99.43 % 	</td>
    <td>
	    Min 99%	</td>
  </tr>
   <tr>
    <td align="left">3.Delinquency Ratio</td>
    <td align="center">
		2.03 % 	</td>
    <td>
	    Max  0.5%	</td>
  </tr>
   <tr>
    <td align="left">4.Savings &amp; Loan Outstanding Ratio</td>
    <td align="center">
		73.97 % 	</td>
    <td>
	    25% - 30%	</td>
  </tr>
  <tr>
    <td align="left">5.Portfolio at Risk </td>
    <td align="center">
		1.77 % 	</td>
    <td>
	    Max 2%	</td>
  </tr>
	<tr>
		<th rowspan="14">C.</th>
		<th rowspan="14">Financial Ratios</th>
		<td align="left">1. Debt:Capital</td>
		<td align="center">0:1</td>
		<td>5:1</td>
		<td rowspan="14">&nbsp;</td>
	</tr>
	<tr>
		<td align="left">2.Debt Service Cover Ratio</td>
	    <td align="center">0:1		</td>
	    <td>Min 1.25:1</td>
	</tr>
	<tr>
		<td align="left">3.Capital Adequacy Ratio</td>
	    <td align="center">0%		
		</td>
	    <td>Min 15%</td>
	</tr>
	<tr>
		<td align="left">4.Current Ratio</td>
	    <td align="center">-</td>
	    <td align="center">2:01</td>
	</tr>
	<tr>
		<td align="left">5.Liquidity to Saving Ratio</td>
	    <td align="center">0%</td>		
	    <td>Min 25%</td>
	</tr>
	<tr>
		<td align="left">6.Return on Capital</td>
	    <td align="center">0%</td>
	    <td>Min 1%</td>
	</tr>
	<tr>
		<td align="left">7.Loan:Saving</td>
	    <td align="center">0:1</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">8.Return on Total Asset</td>
	    <td align="center">0</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">9.Operating Self Sufficiency</td>
	    <td align="center">0</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">10.Surplus as a % of Total Income</td>
	    <td align="center">0%</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">11.DMR Coverage %</td>
	    <td align="center">0%</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">12.Cost Per Average Portfolio</td>
	    <td align="center">0</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">13.Salary as a % of Total Expenditure</td>
	    <td align="center">0%</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">14.Saving Interest as a % of Total Expenditure</td>
	    <td align="center">0%</td>
	    <td>&nbsp;</td>
	</tr>
</tbody></table>
<br><br><br>
<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
