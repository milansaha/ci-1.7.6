<?php //print_r($loan_info);?>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">


<title>POMIS Report 2 </title>
<link rel="stylesheet" type="text/css" href="<?php //echo base_url();?>media/css/report.css" />
</head><body>
	        
   
       
<div class="scroll-report">      
   
<table class="report-header" width="100%" border="0">	
	<tr>
		<td align="center" colspan="4"><?php $this->load->view('/elements/report_header');?></td></tr>
	<tr>
		<td align="center"  colspan="4"><?php //echo $headline ?></td></tr>   
   	<tr><td colspan="4">&nbsp;</td></tr>	
 	<?php if(!empty($branch_info)): ?>
		<tr>
  			<th><div align="left">Branch Name</div></th>
  			<td class="align-left"><strong>:</strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td>		
			<th><div align="left">Branch Address</div></th>
 			<td class="align-left"><strong>:</strong><?php echo $branch_info['address'];?></td></tr>  
 		<?php else :?>
		<p>All Branch </p>	
		<?php endif;?>
		<tr>
 			<th><div align="left">Reporting Month</div></th>
 			<td class="align-left"><strong>:</strong><?php $date=$year.'-'.$month; $date = new DateTime($date);	echo $date->format('F').','.$year;?></td>
 			<th><div align="left">Print Date</div></th>
 			<td class="align-left"><strong>:</strong><?php echo date("d-m-Y");?></td></tr>			
	</table>	 
 
 <br>
 <table width="100%"><tbody><tr>
   <th class="report-sub-name">1. Loan Statement</th>
 </tr></tbody></table>
 <br>

 
<table class="report-body" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
	    <th colspan="2" rowspan="2"><div align="center"><strong>Component</strong></div></th>
	    <th colspan="2"><div align="center"><strong>At the End of Last Month </strong></div></th>
	    <th colspan="2"><div align="center"><strong>Loan Disbursement Current Month </strong></div></th>
	    <th rowspan="2"><div align="center"><strong>Total Loan Recovery Amount(Current Month) </strong></div></th>
	    <th rowspan="2"><div align="center"><strong>Fully Paid Borrower(Current Month) </strong></div></th>
	    <th colspan="2"><div align="center"><strong>At the End of the Month </strong></div></th>
	</tr>
	<tr>
	    <th><div align="center"><strong>Borrower No. </strong></div></th>
	    <th><div align="center"><strong>Loan Outstanding </strong></div></th>
	    <th><div align="center"><strong>Borrower No. </strong></div></th>
	    <th><div align="center"><strong>Amount</strong></div></th>
	    <th><div align="center"><strong>Borrower No. </strong></div></th>
	    <th><div align="center"><strong>Amount</strong></div></th>
	</tr>
	<tr>
	    <th><div align="center">1</div></th>
	    <th><div align="center"></div></th>
	    <th><div align="center">2</div></th>
	    <th><div align="center">3</div></th>
	    <th><div align="center">4</div></th>
	    <th><div align="center">5</div></th>
	    <th><div align="center">6</div></th>
	    <th><div align="center">7</div></th>
	    <th><div align="center">8=2+4-7</div></th>
	    <th><div align="center">9=3+5-6</div></th>
	</tr>
  
	
	<tr>
	    <td>RMC</td>
	    <td>Female</td>  
	    <td>1274</td>
	    <td class="align-right">11189600.00</td>
	    <td>161</td>
	    <td class="align-right">2944000.00</td>
	    <td class="align-right">1765933.00</td>
		<td class="align-center">115</td>
	    <td>1320</td>
	    <td class="align-right">
			12367667.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>34</td>
	    <td class="align-right">637378.00</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">118311.00</td>
	    <td class="align-center">3</td>
	    <td>31</td>
	    <td class="align-right">
			519067.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>1308</th>
	    <th class="align-right">11826978.00</th>
	    <th>161</th>
	    <th class="align-right">2944000.00</th>
	    <th class="align-right">1884244.00</th>
	    <th class="align-center">118</th>
	    <th>
			1351		</th>
	    <th class="align-right">12886734.00		</th>
	</tr>
  
	
	<tr>
	    <td>ME</td>
	    <td>Female</td>  
	    <td>113</td>
	    <td class="align-right">4248111.00</td>
	    <td>19</td>
	    <td class="align-right">1395000.00</td>
	    <td class="align-right">748289.00</td>
		<td class="align-center">12</td>
	    <td>120</td>
	    <td class="align-right">
			4894822.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>4</td>
	    <td class="align-right">279284.00</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">25222.00</td>
	    <td class="align-center">0</td>
	    <td>4</td>
	    <td class="align-right">
			254062.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>117</th>
	    <th class="align-right">4527395.00</th>
	    <th>19</th>
	    <th class="align-right">1395000.00</th>
	    <th class="align-right">773511.00</th>
	    <th class="align-center">12</th>
	    <th>
			124		</th>
	    <th class="align-right">5148884.00		</th>
	</tr>
  
	
	<tr>
	    <td>UP</td>
	    <td>Female</td>  
	    <td>32</td>
	    <td class="align-right">73318.00</td>
	    <td>1</td>
	    <td class="align-right">8000.00 </td>
	    <td class="align-right">20136.00</td>
		<td class="align-center">2</td>
	    <td>31</td>
	    <td class="align-right">
			61182.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
	    <td class="align-center">0</td>
	    <td>0</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>32</th>
	    <th class="align-right">73318.00</th>
	    <th>1</th>
	    <th class="align-right">8000.00 </th>
	    <th class="align-right">20136.00</th>
	    <th class="align-center">2</th>
	    <th>
			31		</th>
	    <th class="align-right">61182.00		</th>
	</tr>
  
	
	<tr>
	    <td>FC</td>
	    <td>Female</td>  
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-center">0</td>
	    <td>0</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>584</td>
	    <td class="align-right">28405000.00</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">5480000.00</td>
	    <td class="align-center">112</td>
	    <td>472</td>
	    <td class="align-right">
			22925000.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>584</th>
	    <th class="align-right">28405000.00</th>
	    <th>0</th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">5480000.00</th>
	    <th class="align-center">112</th>
	    <th>
			472		</th>
	    <th class="align-right">22925000.00		</th>
	</tr>
  
	
	<tr>
	    <td>ASM</td>
	    <td>Female</td>  
	    <td>30</td>
	    <td class="align-right">590000.00</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">235000.00</td>
		<td class="align-center">12</td>
	    <td>18</td>
	    <td class="align-right">
			355000.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>213</td>
	    <td class="align-right">6995000.00</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">1130000.00</td>
	    <td class="align-center">42</td>
	    <td>171</td>
	    <td class="align-right">
			5865000.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>243</th>
	    <th class="align-right">7585000.00</th>
	    <th>0</th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">1365000.00</th>
	    <th class="align-center">54</th>
	    <th>
			189		</th>
	    <th class="align-right">6220000.00		</th>
	</tr>
  
	
	<tr>
	    <td>BSM</td>
	    <td>Female</td>  
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-center">0</td>
	    <td>0</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>4</td>
	    <td class="align-right">222000.00</td>
	    <td>4</td>
	    <td class="align-right">290000.00</td>
	    <td class="align-right">33778.00</td>
	    <td class="align-center">0</td>
	    <td>8</td>
	    <td class="align-right">
			478222.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>4</th>
	    <th class="align-right">222000.00</th>
	    <th>4</th>
	    <th class="align-right">290000.00</th>
	    <th class="align-right">33778.00</th>
	    <th class="align-center">0</th>
	    <th>
			8		</th>
	    <th class="align-right">478222.00		</th>
	</tr>
  
	
	<tr>
	    <td>COW</td>
	    <td>Female</td>  
	    <td>8</td>
	    <td class="align-right">57333.00</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">14667.00</td>
		<td class="align-center">0</td>
	    <td>8</td>
	    <td class="align-right">
			42666.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
	    <td class="align-center">0</td>
	    <td>0</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>8</th>
	    <th class="align-right">57333.00</th>
	    <th>0</th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">14667.00</th>
	    <th class="align-center">0</th>
	    <th>
			8		</th>
	    <th class="align-right">42666.00		</th>
	</tr>
  
	
	<tr>
	    <td>SL</td>
	    <td>Female</td>  
	    <td>77</td>
	    <td class="align-right">1373000.00</td>
	    <td>60</td>
	    <td class="align-right">864000.00</td>
	    <td class="align-right">1373000.00</td>
		<td class="align-center">77</td>
	    <td>60</td>
	    <td class="align-right">
			864000.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
	    <td class="align-center">0</td>
	    <td>0</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>77</th>
	    <th class="align-right">1373000.00</th>
	    <th>60</th>
	    <th class="align-right">864000.00</th>
	    <th class="align-right">1373000.00</th>
	    <th class="align-center">77</th>
	    <th>
			60		</th>
	    <th class="align-right">864000.00		</th>
	</tr>
  
	
	<tr>
	    <td>LRP</td>
	    <td>Female</td>  
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-center">0</td>
	    <td>0</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td>Male</td>
	    <td>1</td>
	    <td class="align-right">2135.00 </td>
	    <td>0</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">577.00  </td>
	    <td class="align-center">0</td>
	    <td>1</td>
	    <td class="align-right">
			1558.00 		</td>
	</tr>
	<tr>
	    <th>&nbsp;
	    </th><th><strong>Total</strong>
	    </th><th>1</th>
	    <th class="align-right">2135.00 </th>
	    <th>0</th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">577.00  </th>
	    <th class="align-center">0</th>
	    <th>
			1		</th>
	    <th class="align-right">1558.00 		</th>
	</tr>
	
	<tr>
	    <th rowspan="2"><strong>Total</strong></th>
	    <th height="20">&nbsp;Female&nbsp;
	    </th><th class="align-center">1449</th>
	    <th class="align-right">17531362.00</th>
	    <th class="align-center">181</th>
	    <th class="align-right"> 5211000.00</th>
	    <th class="align-right">4157025.00</th>
	    <th class="align-center">141</th>
		<th class="align-center">1489</th>
		<th class="align-right">19128512.00</th>
	</tr>
	<tr>
	    <th height="20">Male&nbsp;
	    
	    </th><th class="align-center">839</th>
	    <th class="align-right">36540797.00</th>
	    <th class="align-center">4</th>
	    <th class="align-right"> 290000.00</th>
	    <th class="align-right">6787888.00</th>
	    <th class="align-center">157</th>
		<th class="align-center">686</th>
		<th class="align-right">30079159.00</th>
	</tr>
 
	<tr>
	    <th><strong>Grand Total</strong></th>
	    <th>&nbsp;
	    </th><th>2288</th>
	    <th class="align-right">54072159.00</th>
	    <th>185</th>
	    <th class="align-right"> 5501000.00</th>
	    <th class="align-right">10944913.00</th>
	    <th class="align-center">298</th>
		<th>2175</th>
		<th class="align-right">48628246.00</th>
	</tr>
</tbody></table>
<br>
<table width="100%">
	<tbody><tr>
		<td class="report-sub-name">2. Loan Due Statement</td>
	</tr>
</tbody></table>
<br>

<table class="report-body" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
	    <th colspan="2" rowspan="2"><div class="align-right"><strong>Component</strong></div></th>
	    <th rowspan="2"><div align="center"><strong>Due at the end of the Last Month </strong></div></th>
	    <th rowspan="2"><div align="center"><strong>Reg.Loan Recoverable ( Current Month) </strong></div></th>
	    <th colspan="4"><div align="center"><strong>Current Month Recovered </strong></div></th>
	    <th rowspan="2"><div align="center"><strong>New Due Amount ( Current Month) </strong></div></th>
	    <th rowspan="2"><div align="center"><strong>Total Due at the end of the Month </strong></div></th>
	</tr>
	<tr>
	    <th><div align="center"><strong>Regular</strong></div></th>
	    <th><div align="center"><strong>&nbsp;&nbsp;&nbsp;Due&nbsp;&nbsp;&nbsp;</strong></div></th>
	    <th><div align="center"><strong>Advance</strong></div></th>
	    <th><div align="center"><strong>Total</strong></div></th>
	</tr>
	<tr>
	    <th colspan="2" rowspan="2"><div class="align-right"><strong>1</strong></div></th>
	    <th rowspan="2"><div align="center"><strong>2</strong></div></th>
	    <th rowspan="2"><div align="center"><strong>3</strong></div></th>
	    <th colspan="4"><div align="center"><strong></strong></div></th>
	    <th rowspan="2"><div align="center"><strong>8=(3-4)</strong></div></th>
	    <th rowspan="2"><div align="center"><strong>9=(2-5+8) </strong></div></th>
	</tr>
	<tr>
	    <th><div align="center"><strong>4</strong></div></th>
	    <th><div align="center"><strong>5</strong></div></th>
	    <th><div align="center"><strong>6</strong></div></th>
	    <th><div align="center"><strong>7=(4+5+6)</strong></div></th>
	</tr>
 
	<tr>									  
	    <td>RMC</td>
	    <td>Female</td>
	    <td class="align-right">29911.00</td>
	    <td class="align-right">1702956.00</td>	   
	    <td class="align-right">1697511.00</td>
	    <td class="align-right">533.00  </td>
		<td class="align-right">67889.00</td>
		<td class="align-right">1765933.00</td>
		<td class="align-right">
			5445.00 		</td>
	    <td class="align-right">
			34823.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">70178.00</td>
	    <td class="align-right">108800.00</td>
		<td class="align-right">104356.00</td>
	    <td class="align-right">2667.00 </td>
		<td class="align-right">11289.00</td>
		<td class="align-right">118312.00</td>
		<td class="align-right">
			4444.00 		</td>
	    <td class="align-right">
			71955.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">100089.00</th>
	    <th class="align-right">1811756.00</th>
	    <th class="align-right">1801867.00</th>
		<th class="align-right">3200.00 </th>
		<th class="align-right">79178.00</th>
		<th class="align-right">1884245.00</th>
		<th class="align-right">9889.00 </th>
	    <th class="align-right">106778.00</th>
	</tr>

	<tr>									  
	    <td>ME</td>
	    <td>Female</td>
	    <td class="align-right">24333.00</td>
	    <td class="align-right">710667.00</td>	   
	    <td class="align-right">710667.00</td>
	    <td class="align-right">178.00  </td>
		<td class="align-right">37444.00</td>
		<td class="align-right">748289.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			24155.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">164284.00</td>
	    <td class="align-right">23889.00</td>
		<td class="align-right">23889.00</td>
	    <td class="align-right">1333.00 </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">25222.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			162951.00		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">188617.00</th>
	    <th class="align-right">734556.00</th>
	    <th class="align-right">734556.00</th>
		<th class="align-right">1511.00 </th>
		<th class="align-right">37444.00</th>
		<th class="align-right">773511.00</th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">187106.00</th>
	</tr>

	<tr>									  
	    <td>UP</td>
	    <td>Female</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">20136.00</td>	   
	    <td class="align-right">20136.00</td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">20136.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">0.00    </th>
	    <th class="align-right">20136.00</th>
	    <th class="align-right">20136.00</th>
		<th class="align-right">0.00    </th>
		<th class="align-right">0.00    </th>
		<th class="align-right">20136.00</th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
	</tr>

	<tr>									  
	    <td>FC</td>
	    <td>Female</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>	   
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">5480000.00</td>
		<td class="align-right">5480000.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
		<th class="align-right">0.00    </th>
		<th class="align-right">5480000.00</th>
		<th class="align-right">5480000.00</th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
	</tr>

	<tr>									  
	    <td>ASM</td>
	    <td>Female</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">55000.00</td>	   
	    <td class="align-right">30000.00</td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">180000.00</td>
		<td class="align-right">210000.00</td>
		<td class="align-right">
			25000.00		</td>
	    <td class="align-right">
			25000.00		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">345000.00</td>
		<td class="align-right">345000.00</td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">785000.00</td>
		<td class="align-right">1130000.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">0.00    </th>
	    <th class="align-right">400000.00</th>
	    <th class="align-right">375000.00</th>
		<th class="align-right">0.00    </th>
		<th class="align-right">965000.00</th>
		<th class="align-right">1340000.00</th>
		<th class="align-right">25000.00</th>
	    <th class="align-right">25000.00</th>
	</tr>

	<tr>									  
	    <td>BSM</td>
	    <td>Female</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>	   
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">33778.00</td>
		<td class="align-right">33778.00</td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">33778.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">0.00    </th>
	    <th class="align-right">33778.00</th>
	    <th class="align-right">33778.00</th>
		<th class="align-right">0.00    </th>
		<th class="align-right">0.00    </th>
		<th class="align-right">33778.00</th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
	</tr>

	<tr>									  
	    <td>COW</td>
	    <td>Female</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">14667.00</td>	   
	    <td class="align-right">14667.00</td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">14667.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">0.00    </th>
	    <th class="align-right">14667.00</th>
	    <th class="align-right">14667.00</th>
		<th class="align-right">0.00    </th>
		<th class="align-right">0.00    </th>
		<th class="align-right">14667.00</th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
	</tr>

	<tr>									  
	    <td>SL</td>
	    <td>Female</td>
	    <td class="align-right">5000.00 </td>
	    <td class="align-right">0.00    </td>	   
	    <td class="align-right">0.00    </td>
	    <td class="align-right">5000.00 </td>
		<td class="align-right">1368000.00</td>
		<td class="align-right">1373000.00</td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">5000.00 </th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
		<th class="align-right">5000.00 </th>
		<th class="align-right">1368000.00</th>
		<th class="align-right">1373000.00</th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
	</tr>

	<tr>									  
	    <td>LRP</td>
	    <td>Female</td>
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>	   
	    <td class="align-right">0.00    </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			0.00    		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td><p>Male</p></td>
	    <td class="align-right">2135.00 </td>
	    <td class="align-right">0.00    </td>
		<td class="align-right">0.00    </td>
	    <td class="align-right">577.00  </td>
		<td class="align-right">0.00    </td>
		<td class="align-right">577.00  </td>
		<td class="align-right">
			0.00    		</td>
	    <td class="align-right">
			1558.00 		</td>
	</tr>
	<tr>
	    <th>&nbsp;</th>
	    <th>Total
	    </th><th class="align-right">2135.00 </th>
	    <th class="align-right">0.00    </th>
	    <th class="align-right">0.00    </th>
		<th class="align-right">577.00  </th>
		<th class="align-right">0.00    </th>
		<th class="align-right">577.00  </th>
		<th class="align-right">0.00    </th>
	    <th class="align-right">1558.00 </th>
	</tr>

  
 	<tr>
	    <th rowspan="2"><strong>Total</strong></th>
	    <th height="20">&nbsp;Female&nbsp;
	    </th><th class="align-right">59244.00</th>
		<th class="align-right">2503426.00</th>
	    <th class="align-right">2472981.00</th>
	    <th class="align-right">5711.00 </th>
	    <th class="align-right">1653333.00</th>
		<th class="align-right">4132025.00</th>
	    <th class="align-right">30445.00</th>
		<th class="align-right">83978.00</th>
		
	</tr>
	<tr>
	    <th height="20">Male&nbsp;  
	    </th><th class="align-right">236597.00</th>
		<th class="align-right">511467.00</th>
	   <th class="align-right">507023.00</th>
	    <th class="align-right">4577.00 </th>
	    <th class="align-right">6276289.00</th>
		<th class="align-right">6787889.00</th>
	    <th class="align-right">4444.00 </th>
		<th class="align-right">236464.00</th>
	</tr>
	<tr>
	    <th>Grand Total</th>
		<th>&nbsp;</th>
	    <th class="align-right">295841.00</th>
	    <th class="align-right">3014893.00</th>
		<th class="align-right">2980004.00</th>
		<th class="align-right">10288.00</th>
		<th class="align-right">7929622.00</th>
		<th class="align-right">10919914.00</th>
	    <th class="align-right">34889.00</th>
	    <th class="align-right">320442.00</th>
	</tr>	

</tbody></table>

<br>
<br>
<br>
<br>
<table class="report-footer" align="center" border="0">

  <tbody><tr>
	<td width="4%" height="30">&nbsp;</td>
    <td class="report-footer-margin" width="19%"><strong>Prepared By</strong></td>
	<td width="17%">&nbsp;</td>
    <td class="report-footer-margin" width="20%"><strong>Verified By </strong></td>
	<td width="18%">&nbsp;</td>
    <td class="report-footer-margin" width="17%"><strong>Approved By</strong> </td>
	<td width="5%">&nbsp;</td>
  </tr>
</tbody></table>
</div>
</body></html>
