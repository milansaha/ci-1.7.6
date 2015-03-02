<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>		
			<table width="100%" border="0" cellspacing="0"> 
		 		<?php if(!isset($report_header_info[0])): ?>	
				<tr> 
					<th align="left" width='15%'>Branch Name &amp; Code </th>
					<td align="left" width='20%'><b>:</b><?php echo "{$report_header_info['branch_name']} ({$report_header_info['branch_code']})" ?></td>
					<th align="left" width='15%'>Samity Name</th>
					<td align="left" width='20%'><b>:</b><?php echo "{$report_header_info['samity_name']} ({$report_header_info['samity_code']})" ?></td>
					<td rowspan="2" width="30%">
						<table width="100%" border="1" cellspacing="0"> 
							<tr>
								<td  width="30%">&nbsp;</td>
								<td width="15%">1st</td>
								<td width="15%">2nd</td>
								<td width="15%">3rd</td>
								<td width="150%">4th</td>
								<td width="150%">5th</td></tr>
							<tr>
								<td>Savings Depositor:</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td></tr>
							<tr>
								<td>No of Attendence:</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;</td></tr>
							</table></td></tr>
				<tr>			
					<th align="left">Field Worker Name</th>
					<td><b>:</b><?php echo "{$report_header_info['field_officer_name']}" ?></td>
					<th align="left">Product Name</th>
					<td><b>:</b><?php echo "{$report_header_info['product_mnemonic']['short_name']}" ?></td></tr>
				<tr>
					<th align="left" >Month</th>
					<td ><b>:</b><?php echo "{$report_header_info['report_month']}" ?></td>					
					<th align="left" >Samity Day</th>
					<td ><b>:</b><?php echo "{$report_header_info['samity_day']}" ?></td>				
					<th align="left" >Print Date&nbsp;</th>
					<td ><b>:</b><?php echo  date('d-m-Y',strtotime($report_header_info['print_date'])); ?></td></tr>
				<tr><td>&nbsp;</td></tr></table>
			<?php endif;?>
	<?php 
		$this->load->helper('number');
		$working_days =array();
		$working_days = array_diff($working_list,$holiday_list);
		// array re-index
		$working_days = array_values($working_days);
		//print_r(array_splice($working_days));
	?> 
<table  width="100%" border="1" cellspacing="0">  
	<tr>
		<th rowspan="5" width="15"><div align="center">SL No</div></th>
		<th rowspan="5" width="80"><div align="center">Member ID</div></th>
		<th rowspan="5" width="80"><div align="center">Member-Name </div></th>
		<th colspan="4"><div align="center">Opening information </div></th>
		<th colspan="6"><div align="center">Disbursemnet Information </div></th>
		<th colspan="3"><div align="center">Weekly Realisable </div></th>
		<th colspan="30" width="80">This Month Collection</th>
		<th rowspan="4" colspan="2" width="80">This Month Savings Refund</th></tr>
	<tr>
		<th rowspan="4" width="56"><div align="center">Savings Balance </div></th>
		<th rowspan="4" width="56"><div align="center">SKT Balance </div></th>
		<th rowspan="4" width="56"><div align="center">Loan Outstanding </div></th>
		<th rowspan="4" width="56"><div align="center">Loan Due </div></th>
		<th rowspan="4" width="56"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
		<th rowspan="4" width="56"><div align="center">Amount</div></th>
		<th rowspan="4" width="56"><div align="center">Cycle </div></th>
		<th rowspan="4" width="56"><div align="center">Purpose Code </div></th>
		<th rowspan="4" width="56"><div align="center">Pre Matuired Week</div></th>
		<th rowspan="4" width="56"><div align="center">No. of Installment Paid</div></th>
		<th rowspan="4" width="56"><div align="center">Savings </div></th>
		<th rowspan="4" width="56"><div align="center">SKT </div></th>
		<th rowspan="4" width="56"><div align="center">Loan </div></th></tr>
	<tr>
		<th colspan="6"><div align="center">1st Week </div></th>
		<th colspan="6"><div align="center">2nd Week </div></th>
		<th colspan="6"><div align="center">3rd Week </div></th>
		<th colspan="6"><div align="center">4th Week </div></th>
		<th colspan="6"><div align="center">5th Week </div></th></tr>
	<tr> 
	<?php 
		// print working date
		$number_of_weeks = 0;
		for($i=0;$i<5;$i++) { ?>     
 		<th colspan="6"><div align="center"><?php if(isset($working_days[$i])){
	 	echo "Date: ".date('d-m-Y',strtotime($working_days[$i])); } ?> </div></th><?php 
	 	$number_of_weeks++;
	 } ?></tr>
	<tr>
		<th width="34">Savings</th>
		<th width="36">SKT</th>
		<th width="36">&nbsp;&nbsp;Loan&nbsp;&nbsp; </th>
		<th width="26">&nbsp;Due&nbsp;</th>
		<th width="45">&nbsp;&nbsp;Adv&nbsp;&nbsp;</th>
		<th width="45">M Week</th>
		<th width="34">Savings</th>
		<th width="36">SKT</th>
		<th width="36">&nbsp;&nbsp;Loan&nbsp;&nbsp;</th>
		<th width="26">&nbsp;Due&nbsp;</th>
		<th width="45">&nbsp;&nbsp;Adv&nbsp;&nbsp;</th>
		<th width="45">M Week</th>
		<th width="34">Savings</th>
		<th width="36">SKT</th>
		<th width="36">&nbsp;&nbsp;Loan&nbsp;&nbsp;</th>
		<th width="26">&nbsp;Due&nbsp;</th>
		<th width="45">&nbsp;&nbsp;Adv&nbsp;&nbsp;</th>
		<th width="45">M Week</th>
		<th width="34">Savings</th>
		<th width="36">SKT</th>
		<th width="36">&nbsp;&nbsp;Loan&nbsp;&nbsp;</th>
		<th width="26">&nbsp;Due&nbsp;</th>
		<th width="45">&nbsp;&nbsp;Adv&nbsp;&nbsp;</th>
		<th width="45">M Week</th>
		<th width="34">Savings</th>
		<th width="36">SKT</th>
		<th width="36">&nbsp;&nbsp;Loan&nbsp;&nbsp;</th>
		<th width="26">&nbsp;Due&nbsp;</th>
		<th width="45">&nbsp;&nbsp;Adv&nbsp;&nbsp;</th>
		<th width="45">M Week</th>
		<th width="60">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th width="20">Amount</th></tr>
	<tr>
		<th height="23"><div align="center">1</div></th>
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
		<th><div align="center">24</div></th>
		<th><div align="center">25</div></th>
		<th><div align="center">26</div></th>
		<th><div align="center">27</div></th>
		<th><div align="center">28</div></th>
		<th><div align="center">29</div></th>
		<th><div align="center">30</div></th>
		<th><div align="center">31</div></th>
		<th><div align="center">32</div></th>
		<th><div align="center">33</div></th>
		<th><div align="center">34</div></th>
		<th><div align="center">35</div></th>
		<th><div align="center">36</div></th>
		<th><div align="center">37</div></th>
		<th><div align="center">38</div></th>
		<th><div align="center">39</div></th>
		<th><div align="center">40</div></th>
		<th><div align="center">41</div></th>
		<th><div align="center">42</div></th>
		<th><div align="center">43</div></th>
		<th><div align="center">44</div></th>
		<th><div align="center">45</div></th>
		<th><div align="center">46</div></th>
		<th><div align="center">47</div></th>
		<th><div align="center">48</div></th></tr>  
		<?php	if(!empty($loan_saving_collection_data)):
			$total_previous_savings_balance = 0.00;
			$total_previous_skt_balance = 0.00;
			$total_previous_month_outstanding = 0.00;
			$total_preious_month_due = 0.00;
			$i=1;
			foreach($loan_saving_collection_data as $savings_loan) :
			$total_previous_savings_balance += $savings_loan['previous_savings_balance'];
			$total_previous_skt_balance += $savings_loan['previous_skt_balance'];
			$total_previous_month_outstanding += $savings_loan['previous_month_outstanding'];
			$total_preious_month_due += $savings_loan['preious_month_due'];?>
	<tr>
		  <td align="center"><?php echo $i++;?></td>
		  <td align="center"><?php echo $savings_loan['member_code'];?></td>
		  <td align="left" height="20"><?php echo $savings_loan['member_name'];?></td>
		  <td align="right"><?php if($report_header_info['product_mnemonic']['is_primary_product']==1 && $savings_loan['previous_savings_balance']>0):echo number_format($savings_loan['previous_savings_balance'],'2','.',','); else: echo " "; endif;?></td>
		  <td align="right"><?php if($report_header_info['product_mnemonic']['is_primary_product']==1 && $savings_loan['previous_skt_balance']>0):echo number_format($savings_loan['previous_skt_balance'],'2','.',','); else: echo " "; endif;?></td>
		  <td align="right"><?php if($savings_loan['previous_month_outstanding']>0):echo number_format($savings_loan['previous_month_outstanding'],'2','.',','); else: echo ""; endif;?></td>
		  <td align="right"><?php if($savings_loan['preious_month_due']>0):echo number_format($savings_loan['preious_month_due'],'2','.',','); else: echo ""; endif;?></td>
		  <td align="center"><?php if(!empty($savings_loan['loan_disbuse_date'])): echo date('d-m-Y', strtotime($savings_loan['loan_disbuse_date'])); else : echo ""; endif;?></td>
		  <td align="right"><?php if($savings_loan['loan_amount']>0):echo number_format($savings_loan['loan_amount'],'2','.',','); else : echo ""; endif;?></td>
		  <td align="center"><?php if($savings_loan['cycle']>0):echo $savings_loan['cycle']; else : echo ""; endif;?></td>
		  <td align="center"><?php if($savings_loan['purpose_code']>0):echo $savings_loan['purpose_code']; else : echo ""; endif;?></td>
		  <td align="center"><?php if($savings_loan['pre_matuired_week']>0):echo $savings_loan['pre_matuired_week']; else : echo ""; endif;?></td>
		  <td align="center"><?php if($savings_loan['repay_week']>0):echo $savings_loan['repay_week']; else : echo ""; endif;?></td>
		  <td align="center"><?php if($savings_loan['savings_auto']>0):echo $savings_loan['savings_auto'];else : echo ""; endif;?></td>
		  <td align="center"><?php if($report_header_info['skt_amount']>0):echo $report_header_info['skt_amount'];else : echo ""; endif;?></td>
		  <td align="right"><?php if($savings_loan['loan_auto']>0):echo number_format($savings_loan['loan_auto'],'2','.',',');else : echo ""; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="center"><?php if($savings_loan['repay_week']>0):echo ++$savings_loan['repay_week']; else : echo ""; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="center"><?php if($savings_loan['repay_week']>0):echo ++$savings_loan['repay_week']; else : echo ""; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="center"><?php if($savings_loan['repay_week']>0):echo ++$savings_loan['repay_week']; else : echo ""; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="center"><?php if($savings_loan['repay_week']>0):echo ++$savings_loan['repay_week']; else : echo ""; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td></tr>
	<?php endforeach;?>  
	<tr>
	  	<td colspan="4" class="align-center"> SKT Balance Of Cancellation Member</td> 
	  	<td align="right"><?php if(!empty($cancellation_member_skt_amount)):
				$total_previous_skt_balance=$total_previous_skt_balance+$cancellation_member_skt_amount[0]->canceled_member_skt_amount;
				echo $cancellation_member_skt_amount[0]->canceled_member_skt_amount; endif;?></td>  
	  	<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td><td align="right">&nbsp;</td><td align="right">&nbsp;</td></tr>
	<tr>
		<td colspan="3" align="center">Total</th>
		<td align="right"><?php if($report_header_info['product_mnemonic']['is_primary_product']==1 && $total_previous_savings_balance>0):echo number_format($total_previous_savings_balance,'2','.',',');else : echo " "; endif;?></td>
		<td align="right"><?php if($report_header_info['product_mnemonic']['is_primary_product']==1  && $total_previous_skt_balance>0):echo number_format($total_previous_skt_balance,'2','.',',');else : echo " "; endif;?></td>   
		<td align="right"><?php if($total_previous_month_outstanding>0):echo number_format($total_previous_month_outstanding,'2','.',',');else : echo " "; endif;?></td>
		<td align="right"><?php if($total_preious_month_due>0):echo number_format($total_preious_month_due,'2','.',',');else : echo " "; endif;?></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td></tr>
	<?php endif;?>
</table>
<br><br>
<table  width="100%" border="1" cellspacing="0">  
	<tr>
		<td align="left" width="150"><strong>FW Signature:</strong></td>
		<td width="150">&nbsp;</td>
		<td align="left" width="150"><strong>FW Signature: </strong></td>
		<td width="150">&nbsp;</td>
		<td align="left" width="150"><strong>FW Signature:</strong></td>
		<td width="150">&nbsp;</td>
		<td align="left" width="150"><strong>FW Signature:</strong></td>
		<td width="150">&nbsp;</td>
		<td align="left" width="150"><strong>FW Signature:</strong></td>
		<td width="150">&nbsp;</td>
	</tr></table><br><br><br>
<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>