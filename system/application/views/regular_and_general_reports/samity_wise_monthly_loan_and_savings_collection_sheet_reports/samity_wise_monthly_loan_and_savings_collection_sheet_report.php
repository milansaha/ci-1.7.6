<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>		
			<table width="100%" border="0" cellspacing="0"> 
		 		<?php if(!isset($report_header_info[0])): ?>	
				<tr> 
					<th align="left" width="16%">Branch Name &amp; Code </th>
						<td align="left"><b>: </b><?php echo "{$report_header_info['branch_name']} ({$report_header_info['branch_code']})";?></td>
						<th align="left"  width="12%">Samity Name & Code </th>
						<td align="left"><b>: </b><?php echo "{$report_header_info['samity_name']} ({$report_header_info['samity_code']})";?></td>
						<th align="left"  width="10%">Samity Day</th>
						<td align="left" width="10%"><b>:</b><?php echo "{$report_header_info['samity_day']}";?></td></tr>
					<tr>	
						<th align="left"  width="16%">Field Worker Name</th>
						<td align="left"><b>: </b><?php echo "{$report_header_info['field_officer_name']}";?></td>
						<th align="left"  width="12%">Product Name</th>
						<td align="left"><b>: </b><?php echo "{$report_header_info['product_mnemonic']['short_name']}";?></td></tr>
					<tr>
						<th align="left"  width="16%">Month</th>
						<td align="left"><b>: </b><?php echo "{$report_header_info['report_month']}";?></td>	
						<th align="left"  width="12%">Print Date&nbsp;</th>
						<td align="left"><b>: </b><?php echo date('d-m-Y', strtotime($report_header_info['print_date']));?></td></tr>	
					<tr><td>&nbsp;</td></tr>
				<?php endif;?></table>
<?php 	$this->load->helper('number');
		$working_days =array();
		$working_days = array_diff($working_list,$holiday_list);
		// array re-index
		$working_days = array_values($working_days);
		//print_r(array_splice($working_days));?>

<center><b>Part-A</b></center>
<table width="100%" border="1" cellspacing="0"> 
    <tr>
	  	<th rowspan="5"><div align="center">SL No</div></th>
      	<th rowspan="5"><div align="center">Member ID</div></th>
      	<th rowspan="5"><div align="center">Member-Name </div></th>
      	<th rowspan="5"><div align="center">Ledger Page No.</div></th>
      	<th colspan="26"><div align="center">Savings Related Information </div></th></tr>
    <tr>
      	<th rowspan="4" width="56"><div align="center">Previous Savings Balance </div></th>
      	<th rowspan="4" width="56"><div align="center">Previous SKT Balance </div></th>
	 	<th colspan="15"><div align="center">This Month Savings Collection </div></th>
      	<th colspan="3"><div align="center">This Month Total Savings Collection </div></th>
      	<th colspan="2"><div align="center">Savings Withdrawal</div></th>
      	<th rowspan="4" width="80"><div align="center">Savings Balance End of Month </div></th>
	  	<th rowspan="4" width="80"><div align="center">SKT Balance End of Month </div></th></tr>
    <tr>
     	<th colspan="3"><div align="center">1st Week</div></th>
      	<th colspan="3"><div align="center">2nd Week</div></th>
      	<th colspan="3"><div align="center">3rd Week</div></th>
      	<th colspan="3"><div align="center">4th Week</div></th>
      	<th colspan="3"><div align="center">5th Week</div></th>
      	<th rowspan="3">Auto</th>
      	<th rowspan="3">Actual</th>
	  	<th rowspan="3">SKT Amt</th>
	  	<th rowspan="3">Amount</th>
	  	<th rowspan="3">Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>
    <tr>
		<?php 
			// print working date
			$number_of_weeks = 0;
			for($i=0;$i<5;$i++) { ?>     
 		<th colspan="3"><div align="left"><?php if(isset($working_days[$i])){
	 		echo "Date: " . date('d-m-Y', strtotime($working_days[$i])); }?> </div></th><?php 
	 		$number_of_weeks++;
	 	} ?></tr>
    <tr>
      	<th>Auto</th>
		<th>Actual</th>
		<th>SKT Amt</th>
		<th>Auto</th>
		<th>Actual</th>
		<th>SKT Amt</th>
		<th>Auto</th>
		<th>Actual</th>
		<th>SKT Amt</th>
		<th>Auto</th>
		<th>Actual</th>
		<th>SKT Amt</th>
		<th>Auto</th>
		<th>Actual</th>
		<th>SKT Amt</th></tr>
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
	  	<th><div align="center">24</div></th>
	  	<th><div align="center">25</div></th>
	  	<th><div align="center">26</div></th>
	  	<th><div align="center">27</div></th>
	  	<th><div align="center">28</div></th></tr>
	<?php if(!empty($savings_collection_data)):
		//print_r($savings_collection_data);
		$all_previous_savings_balance = 0.00;
		$all_previous_skt_balance = 0.00;
		$all_savings_auto = 0.00;
		$all_skt_auto = 0.00;
		$temp_member_code = "";
		$savings = array();
		$c = 0;
		foreach($savings_collection_data as $savings_collection) { 
			if($temp_member_code == $savings_collection['member_code']) {
				$savings[$c-1]['previous_savings_balance'] += $savings_collection['previous_savings_balance'];
				$savings[$c-1]['previous_skt_balance'] += $savings_collection['previous_skt_balance'];
				$savings[$c-1]['savings_auto'] += $savings_collection['savings_auto'];
				$savings[$c-1]['skt_auto'] +=  $report_header_info['skt_amount'];
				continue;	
			} else {
				$savings[$c]['member_code'] = $savings_collection['member_code'];
				$savings[$c]['member_name'] = $savings_collection['member_name'];
				$savings[$c]['previous_savings_balance'] = $savings_collection['previous_savings_balance'];
				$savings[$c]['previous_skt_balance'] = $savings_collection['previous_skt_balance'];
				$savings[$c]['savings_auto'] = $savings_collection['savings_auto'];
				$savings[$c]['skt_auto'] =  $report_header_info['skt_amount'];
			}
			$c++;
			$temp_member_code = $savings_collection['member_code'];
		}		
		$i=1;
		$total_previous_savings_balance = 0.00;
		$total_previous_skt_balance = 0.00;
		$total_savings_auto = 0.00;
		$total_skt_auto = 0.00;	
		$temp_member_code = "";
		foreach($savings as $saving) {		
			$total_previous_savings_balance += $saving['previous_savings_balance'];
			$total_previous_skt_balance += $saving['previous_skt_balance'];
			$total_savings_auto += $saving['savings_auto'];
			$total_skt_auto += $saving['skt_auto'];?>
		<tr>
			<td align="left"><?php echo $i ;?></td>
			<td align="left"><?php echo $saving['member_code']; ?></td>
			<td align="left"><?php echo $saving['member_name']; ?></td>
			<td>&nbsp;</td>
			<td align="right"><?php echo number_format($saving['previous_savings_balance'],'2','.',',');?></td>
			<td align="right"><?php echo number_format($saving['previous_skt_balance'],'2','.',',');?></td>
			<td align="right"><?php echo number_format($saving['savings_auto'],'2','.',',');?></td>
			<td>&nbsp;</td>
			<td align="right"><?php echo number_format($saving['skt_auto'],'2','.',',');?></td>
			<td align="right"><?php echo number_format($saving['savings_auto'],'2','.',',');?></td>
			<td>&nbsp;</td>
			<td align="right"><?php echo number_format($saving['skt_auto'],'2','.',',');?></td>
			<td align="right"><?php echo number_format($saving['savings_auto'],'2','.',',');?></td>
			<td>&nbsp;</td>
			<td align="right"><?php echo number_format($saving['skt_auto'],'2','.',',');?></td>
			<td align="right"><?php echo number_format($saving['savings_auto'],'2','.',',');?></td>
			<td>&nbsp;</td>
			<td align="right"><?php echo number_format($saving['skt_auto'],'2','.',',');?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><?php $auto=$saving['savings_auto']*$number_of_weeks; echo number_format($auto,'2','.',',');?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td></tr>
		<?php $temp_member_code = $savings_collection['member_code'];$i++; } ?>
    	<tr>
		  	<th colspan="4" class="align-center"> SKT Balance Of Cancellation Member</th> 
		  	<td>&nbsp;</td> 
		  	<td align="right"><?php if(!empty($cancellation_member_skt_amount)):
				$total_previous_skt_balance=$total_previous_skt_balance+$cancellation_member_skt_amount[0]->canceled_member_skt_amount;
				echo $cancellation_member_skt_amount[0]->canceled_member_skt_amount; endif;?></td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td> 
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td> 
		  	<td>&nbsp;</td> 
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td> 
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td> 
		  	<td>&nbsp;</td>  
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td></tr>	
    	<tr>	
      		<td colspan="4" align="left"> Total</th>
      		<td align="right"><?php echo number_format($total_previous_savings_balance,'2','.',','); ?></td>
	  		<td align="right"><?php echo number_format($total_previous_skt_balance,'2','.',','); ?></td>
            <td align="right"><?php echo number_format($total_savings_auto,'2','.',','); ?></td>
      		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
            <td align="right"><?php echo number_format($total_savings_auto,'2','.',','); ?></td>
      		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
            <td align="right"><?php echo number_format($total_savings_auto,'2','.',','); ?></td>
      		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
            <td align="right"><?php echo number_format($total_savings_auto,'2','.',','); ?></td>
      		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
      		<td>&nbsp;</th><th>&nbsp;</td><td>&nbsp;</td>
			<td align="right"><?php $total_savings_auto=$total_savings_auto*$number_of_weeks; echo  number_format($total_savings_auto,'2','.',','); ?></td>
      		<td align="right">&nbsp;</td>
      		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td>
	  		<td align="right">&nbsp;</td></tr>
		<?php endif;?>
	</table>
	<br>	  
	<center><b>Part-B</b></center>
	<table width="100%" border="1" cellspacing="0"> 
		<tr>
	  		<th rowspan="5"><div align="center">SL No</div></th>
	  		<th rowspan="5"><div align="center">Member ID</div></th>
	  		<th colspan="27"><div align="center">Loan Related Information</div></th>
      		<th rowspan="4" colspan="2"><div align="center">This Month </div><div align="center">Total Loan </div><div align="center">Coll</div></th>
      		<th rowspan="5"><div align="center">Month End Due </div></th>
     		<th rowspan="5"><div align="center">Month End Out. </div></th></tr>	  
	  <tr>
	  		<th rowspan="4"><div align="center">Loan Disburs. Date </div></th>
      		<th rowspan="4"><div align="center">Loan Amount </div></th>
	  		<th rowspan="4"><div align="center">Cycle</div></th>
      		<th rowspan="4"><div align="center">Purpose Code</div></th>
	  		<th rowspan="4"><div align="center">Repay Week</div></th>
      		<th rowspan="4"><div align="center">Prev. Month Out. </div></th>
      		<th rowspan="4"><div align="center">Prev. Month Due </div></th>
      		<th colspan="20"><div align="center">This Month Loan Coll</div></th></tr>	  
	  <tr>
	  		<th colspan="4"><div align="center">1st Week</div></th>
      		<th colspan="4"><div align="center">2nd Week</div></th>
      		<th colspan="4"><div align="center">3rd Week</div></th>
      		<th colspan="4"><div align="center">4th Week</div></th>
     		<th colspan="4"><div align="center">5th Week</div></th></tr>	  
	  <tr>
	  	<?php 
			// print working date
			$number_of_weeks = 0;
			for($i=0;$i<5;$i++) { ?>     
 			<th colspan="4"><div align="left"><?php if(isset($working_days[$i])){
	 		echo "Date: " . date('d-m-Y', strtotime($working_days[$i])); }?> </div></th><?php 
	 		$number_of_weeks++;
	 	} ?></tr>	  
	  <tr>	  
		  <th><div align="center">Auto</div></th>
		  <th><div align="center">Actual</div></th>
		  <th><div align="center">Due </div></th>
		  <th><div align="center">Adv </div></th>
		  <th><div align="center">Auto</div></th>
		  <th><div align="center">Actual</div></th>
		  <th><div align="center">Due </div></th>
		  <th><div align="center">Adv </div></th>
		  <th><div align="center">Auto</div></th>
		  <th><div align="center">Actual</div></th>
		  <th><div align="center">Due </div></th>
		  <th><div align="center">Adv </div></th>
		  <th><div align="center">Auto</div></th>
		  <th><div align="center">Actual</div></th>
		  <th><div align="center">Due </div></th>
		  <th><div align="center">Adv </div></th>
		  <th><div align="center">Auto</div></th>
		  <th><div align="center">Actual</div></th>
		  <th><div align="center">Due </div></th>
		  <th><div align="center">Adv </div></th>
		  <th><div align="center">Auto</div></th>
		  <th><div align="center">Actual</div></th></tr>	  
	  <tr>
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
		  <th><div align="center">48</div></th>
		  <th><div align="center">49</div></th>
		  <th><div align="center">50</div></th>
		  <th><div align="center">51</div></th>
		  <th><div align="center">52</div></th>
		  <th><div align="center">53</div></th>
		  <th><div align="center">54</div></th>
		  <th><div align="center">55</div></th>
		  <th><div align="center">56</div></th>
		  <th><div align="center">57</div></th>
		  <th><div align="center">58</div></th>
		  <th><div align="center">59</div></th>
		  <th><div align="center">60</div></th>
		  <th><div align="center">61</div></th></tr>
	  <?php	 if(!empty($loan_collection_data)): 
	  	//print_r($loan_collection_data);
	  	$total_loan_amount= 0.00; 
	 	$total_previous_month_outstanding = 0.00;
	  	$total_previous_month_due = 0.00;
	  	$total_loan_auto = 0.00;
		$i=0;
	  	foreach($loan_collection_data as $loan_data) {
			$i++;
	  		$total_loan_amount += $loan_data['loan_amount'];
	  		$total_previous_month_outstanding += $loan_data['previous_month_outstanding'];
	  		$total_previous_month_due += $loan_data['preious_month_due'];
	  		$total_loan_auto += $loan_data['auto'];?>
	  <tr>
	  	  <td><center><?php echo $i;?></center></td>
		  <td align="center"><?php echo $loan_data['member_code'];?></td>	  
		  <td align="center"><?php if(!empty($loan_data['loan_disbuse_date'])): echo date('d-m-Y', strtotime($loan_data['loan_disbuse_date'])); else : echo "-"; endif;?></td>
		  <td align="right"><?php if($loan_data['loan_amount']>0): echo number_format($loan_data['loan_amount'],'2','.',','); else : echo "-"; endif;?></td>
		  <td align="center"><?php if($loan_data['cycle']>0): echo $loan_data['cycle'];else : echo "-"; endif;?></td>
		  <td align="center"><?php if($loan_data['purpose_code']>0): echo $loan_data['purpose_code'];else : echo "-"; endif;?></td>
		  <td align="center"><?php if($loan_data['repay_week']>0): echo $loan_data['repay_week'];else : echo "-"; endif;?></td>
		  <td align="right"><?php if($loan_data['previous_month_outstanding']>0): echo number_format($loan_data['previous_month_outstanding'],'2','.',',');else : echo "-"; endif;?></td>
		  <td align="right"><?php if($loan_data['preious_month_due']>0): echo number_format($loan_data['preious_month_due'],'2','.',',');else : echo "-"; endif;?></td>
		  <td align="right"><?php if($loan_data['auto']>0): echo number_format($loan_data['auto'],'2','.',',');else : echo "-"; endif;?></td>
		  <td><center>&nbsp;</center></td>
		  <td><center>&nbsp;</center></td>
		  <td><center>&nbsp;</center></td>
		  <td align="right"><?php if($loan_data['auto']>0): echo number_format($loan_data['auto'],'2','.',',');else : echo "-"; endif;?></td>
		  <td><center>&nbsp;</center></td>
		  <td><center>&nbsp;</center></td>
		  <td><center>&nbsp;</center></td>
		  <td><center><?php if($loan_data['auto']>0): echo number_format($loan_data['auto'],'2','.',',');else : echo "-"; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td align="center">-</td>
		  <td align="center">-</td>
		  <td align="center">-</td>
		  <td align="center">-</td>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <th>&nbsp;</th>
		  <td align="right"><?php $total_auto=$loan_data['auto'] * $number_of_weeks; if($loan_data['auto']>0): echo $total_auto; else : echo "-"; endif;?></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td></tr>
	  	<?php } ?>	 	
 		<tr>
			 <th colspan="3" class="align-center"> Total</th>
			 <th class="align-right"><?php echo number_format($total_loan_amount,'2','.',','); ?></th>
			 <th class="align-right">&nbsp;</th>
			 <th class="align-right">&nbsp;</th>
			 <th class="align-right">&nbsp;</th>
			 <th class="align-right"><?php echo number_format($total_previous_month_outstanding,'2','.',','); ?></th>
			 <th class="align-right"><?php echo number_format($total_previous_month_due,'2','.',','); ?></th>
			 <th class="align-center"><?php echo number_format($total_loan_auto,'2','.',','); ?></th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center"><?php echo number_format($total_loan_auto,'2','.',','); ?></th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center"><?php echo number_format($total_loan_auto,'2','.',','); ?></th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center"><?php echo number_format($total_loan_auto,'2','.',','); ?></th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
			 <th class="align-center"><?php $total=$total_loan_auto * $number_of_weeks; echo number_format($total,'2','.',',');?></th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th>
			 <th class="align-center">&nbsp;</th></tr>
		<?php endif;?>
</table>
<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>