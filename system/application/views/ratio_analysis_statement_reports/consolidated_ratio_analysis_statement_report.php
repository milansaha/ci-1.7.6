<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
			
<table width="100%" border="0" cellspacing="0"> 
    <tbody>
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
    <th rowspan="8">A.</th>
    <th rowspan="8"><p>Productive Ratio </p></th>
    <td><div align="left">1.Member Per Samity</div></td>	
    <td>
	<div align="center"><?php echo (isset($get_productive_ratio['1']['member_per_samity']))?number_format($get_productive_ratio['1']['member_per_samity'], 2, '.', ','):'0.00'; ?></div>	
	</td>
    <td></td>
    <td rowspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">2.Member Per Field Worker</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['2']['member_per_field_worker']))?number_format($get_productive_ratio['2']['member_per_field_worker'], 2, '.', ','):'0.00'; ?></div>
	</td>
    <td></td>
  </tr>
  <tr>
    <td><div align="left">3.Borrower Per Field Worker</div></td>
    <td>
	<div align="center"><?php echo (isset($get_productive_ratio['3']['borrower_per_field_worker']))?number_format($get_productive_ratio['3']['borrower_per_field_worker'], 2, '.', ','):'0.00'; ?></div>
	</td>
    <td></td>
  </tr>
  <tr>
    <td><div align="left">4.Borrower Coverage %</div></td>
    <td>
	<div align="center"><?php echo (isset($get_productive_ratio['4']['borrower_coverage']))?number_format($get_productive_ratio['4']['borrower_coverage'], 2, '.', ','):'0.00'; ?>%</div>
	</td>
    <td></td>
  </tr> 
  <tr>
    <td><div align="left">5.PortFolio Per Field Worker </div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['7']['portfolio_per_field_worker']))?number_format($get_productive_ratio['7']['portfolio_per_field_worker'], 2, '.', ','):'0.00'; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td><div align="left">6.Average Loan Size</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['5']['average_laon_size']))?number_format($get_productive_ratio['5']['average_laon_size'], 2, '.', ','):'0.00'; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td><div align="left">7.Outstanding per Borrower</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['8']['outstanding_per_borrower']))?number_format($get_productive_ratio['8']['outstanding_per_borrower'], 2, '.', ','):'0.00'; ?></div></td>
    <td></td>
  </tr>
  <tr>
    <td><div align="left">8.Total Staff:Field Worker</div></td>
    <td><div align="center"><?php echo (isset($get_productive_ratio['6']['total_staff_vs_field_worker']))?number_format($get_productive_ratio['6']['total_staff_vs_field_worker'], 2, '.', ','):'0.00'; ?></div></td>
    <td></td>
  </tr>  
  <tr>
    <th rowspan="3">B.</th>
    <th rowspan="3">Portfolio Quality Ratios </th>
    <td><div align="left">
	1.Cumulative Recovery Ratio(CRR)
    </div></td>
    <td align="center">&nbsp;</td>
    <td></td>
    <td rowspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">2.On Time Recovery(OTR)</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left">3.Portfolio at Risk </td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<tr>
		<th rowspan="14">C.</th>
		<th rowspan="14">Financial Ratios</th>
		<td align="left">1. Debt:Capital</td>
		<td align="center">&nbsp;</td>
		<td>&nbsp;</td>
		<td rowspan="14">&nbsp;</td>
	</tr>
	<tr>
		<td align="left">2.Debt Service Cover Ratio</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">3.Capital Adequacy Ratio</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">4.Current Ratio</td>
	    <td align="center">&nbsp;</td>
	    <td align="center">&nbsp;</td>
	</tr>
	<tr>
		<td align="left">5.Liquidity to Saving Ratio</td>
	    <td align="center">&nbsp;</td>		
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">6.Return on Capital</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">7.Loan:Saving</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">8.Return on Total Asset</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">9.Operating Self Sufficiency</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">10.Surplus as a % of Total Income</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">11.DMR Coverage %</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">12.Cost Per Average Portfolio</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">13.Salary as a % of Total Expenditure</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left">14.Saving Interest as a % of Total Expenditure</td>
	    <td align="center">&nbsp;</td>
	    <td>&nbsp;</td>
	</tr>
</tbody>
</table>

<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
