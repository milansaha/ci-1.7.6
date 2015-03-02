<div class="scroll-report">
	<div class="report-header">	
		<div align="center"><?php $this->load->view('/elements/report_header');?></div>
		<br>				
		<table width="100%" border="0" cellspacing="0"> 
			<tr>
				<td align="center" colspan='4'><h2><?php echo $headline;?></h2></td></tr>
		 		<?php 	if(isset($branch_data)): ?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code </th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo $branch_data['name']."(".$branch_data['code'].")";?></td></tr> 
		 		<tr>
					<th class="align-left" width="20%">Branch Address</th>
		 			<td colspan="3" class="align-left"><strong>: </strong><?php echo $branch_data['address'];?></td></tr> 			
				<?php endif;?>
				<tr>
		 			<th class="align-left">Reporting Date</th>
		 			<td class="align-left"><strong>: </strong>
					<?php echo date('d-m-Y',strtotime($from)). ' to ' .date('d-m-Y',strtotime($to));?></td>		 			
					<th class="align-left">Print Date</th>
		 			<td class="align-left"><strong>: </strong><?php echo date("d-m-Y");?></td></tr></table>
	<center><h3>Part-A</h3></center>
	<table  width="100%" border="1" cellspacing="0">  
  		<tr>
			<th colspan="4"><div align="center">Branch Manager ID : <?php  if(isset($branch_manager[0])):  echo $branch_manager[0]->employee_code; endif;?></div></th>
			<th colspan="11"><div align="center">Branch Manager Name : <?php  if(isset($branch_manager[0])):  echo $branch_manager[0]->employee_name; endif;?></div></th></tr>
  		<tr>
			<th rowspan="2" width="3%"><div align="center">SL. No.</div></th>
			<th rowspan="2" width="6%"><div align="center">Field Officer Code</div></th>
			<th rowspan="2" width="8%"><div align="center">Field Officer Name</div></th>
			<th colspan="12"><div align="center">Beginning of The Week </div></th></tr> 		
		<tr>
			<th width="4%"><div align="center">Member</div></th>
			<th width="5%"><div align="center">Savings</div></th>
			<th width="5%"><div align="center">Total Cum. Disburse No</div></th>
			<th width="7%"><div align="center">Total Cum. Disbursement </div></th>
			<th width="7%"><div align="center">Cum. Fully Paid Borrower</div></th>
			<th width="7%"><div align="center">Cum. Fully Paid Amount </div></th>
			<th width="5%"><div align="center">Cum. Expaired Borrower</div></th>
			<th width="5%"><div align="center">Cum. Expaired Loan Amount </div></th>
			<th width="5%"><div align="center">Current Borrower</div></th>
			<th width="7%"><div align="center">Current Loan Amount </div></th>
			<th width="4%"><div align="center">Overdue</div></th>
			<th width="6%"><div align="center">Outstanding</div></th></tr>
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
			<th><div align="center">12=(6-8-10)</div></th>
			<th><div align="center">13=(7-9-11)</div></th>
			<th><div align="center">14</div></th>
			<th><div align="center">15</div></th></tr>
		<?php $i=0;
			if(isset($branch_manager_report_data_beginning_week)):				
			foreach($branch_manager_report_data_beginning_week as $row):?>
		<tr>
			<th><div align="center"><?php echo $i++;?></div></th>
			<th><div align="center"><?php echo $row['employee_code'];?></div></th>
			<th><div align="left"><?php echo $row['employee_name'];?></div></th>
			<th><div align="center"><?php echo $row['member_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row['savings'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row['cum_disbursement_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row['cum_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row['cum_fully_paid_loan_disbursement_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row['cum_fully_paid_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row['cum_exp_borrower'];?></div></th>
			<th><div align="right"><?php echo number_format($row['cum_exp_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row['current_borrower'];?></div></th>
			<th><div align="right"><?php echo number_format($row['current_loan_amount'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row['due'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row['outstanding'],'2','.',',');?></div></th></tr>
		<?php endforeach; endif;?>
		<tr>
			<th>Total</th>
			<th colspan="2"><div align="center"><?php echo $i++;?></div></th> 
			<th><div align="center"><?php echo $total_member_beginning_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_savings_beginning_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_disbursement_no_beginning_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_loan_amount_beginning_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_fully_paid_loan_disbursement_no_beginning_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_fully_paid_loan_amount_beginning_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_exp_borrower_beginning_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_exp_loan_amount_beginning_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_current_borrower_beginning_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_current_loan_amount_beginning_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_due_beginning_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_outstanding_beginning_week,'2','.',',');?></div></th></tr></table>
	<center><h3>Part-B</h3></center>
	<table  width="100%" border="1" cellspacing="0">  
		<tr>
			<th colspan="4"><div align="center">Branch Manager ID : <?php  if(isset($branch_manager[0])):  echo $branch_manager[0]->employee_code; endif;?></div></th>
			<th colspan="13"><div align="center">Branch Manager Name : <?php  if(isset($branch_manager[0])):  echo $branch_manager[0]->employee_name; endif;?></div></th></tr>
		<tr>
			<th colspan="17"><div align="center">For The Week </div></th></tr>
		<tr>
			<th rowspan="2" width="4%"><div align="center">Field Officer ID </div></th>
			<th rowspan="2" width="5%"><div align="center">Member Admission </div></th>
			<th rowspan="2" width="5%"><div align="center">Member Dropout </div></th>
			<th rowspan="2" width="7%"><div align="center">Savings Collection </div></th>
			<th rowspan="2" width="6%"><div align="center">Savings Refund </div></th>
			<th rowspan="2" width="6%"><div align="center">Disbursement Borrower</div></th>
			<th rowspan="2" width="7%"><div align="center">Disbursement Taka </div></th>
			<th rowspan="2" width="5%"><div align="center">Fully Paid Borrower</div></th>
			<th rowspan="2" width="8%"><div align="center">Fully Paid Amount</div></th>
			<th rowspan="2" width="5%"><div align="center">Expaired Borrower</div></th>
			<th rowspan="2" width="7%"><div align="center">Expaired Loan Amount</div></th>
			<th rowspan="2" width="8%"><div align="center">Regular Recoverable</div></th>
			<th colspan="4"><div align="center">Recovery</div></th>
			<th rowspan="2" width="5%"><div align="center">This Week New Due/ Less Rec.</div></th></tr>
		<tr>
			<th height="26" width="5%"><div align="center">Regular</div></th>
			<th width="5%"><div align="center">Overdue</div></th>
			<th width="5%"><div align="center">Advance</div></th>
			<th width="7%"><div align="center">Total</div></th></tr>
		<tr>
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
			<th><div align="center">31=28+29+30</div></th>
			<th><div align="center">32=27-28</div></th></tr>	
		<?php $i=0; 
			if(isset($branch_manager_report_data_for_this_week)):				
			foreach($branch_manager_report_data_for_this_week as $row1):?>
		<tr>
			<th><div align="center"><?php echo $row1['employee_code'];?></div></th>			
			<th><div align="center"><?php echo $row1['member_no'];?></div></th>
			<th><div align="center"><?php echo $row1['admission_member_no'];?></div></th>
			<th><div align="center"><?php echo $row1['closing_member_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row1['savings'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row1['cum_disbursement_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row1['cum_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row1['cum_fully_paid_loan_disbursement_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row1['cum_fully_paid_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row1['cum_exp_borrower'];?></div></th>
			<th><div align="right"><?php echo number_format($row1['cum_exp_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row1['loan_recoverable_amount'];?></div></th>			
			<th><div align="right"><?php echo number_format($row1['transaction_amount'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row1['due'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row1['advance'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row1['recovery_total'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row1['new_due'],'2','.',',');?></div></th></tr>
		<?php endforeach; endif;?>		
		<tr>
			<th>Total</th>
			<th colspan="2"><div align="center"><?php echo $i++;?></div></th> 
			<th><div align="center"><?php echo $total_member_between_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_savings_between_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_disbursement_no_between_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_loan_amount_between_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_fully_paid_loan_disbursement_no_between_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_fully_paid_loan_amount_between_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_exp_borrower_between_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_exp_loan_amount_between_week,'2','.',',');?></div></th>			
			<th><div align="right"><?php echo number_format($total_loan_recoverable_amount_between_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_transaction_amount_between_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_due_between_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_advance_between_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_recovery_total_between_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_new_due_between_week,'2','.',',');?></div></th></tr></table>
	<center><h3>Part-C</h3></center>
	<table  width="100%" border="1" cellspacing="0">  
	<tr>
		<th colspan="4"><div align="center">Branch Manager ID : <?php if(isset($branch_manager[0])): echo $branch_manager[0]->employee_code; endif;?></div></th>
		<th colspan="11"><div align="center">Branch Manager Name : <?php  if(isset($branch_manager[0])): echo $branch_manager[0]->employee_name; endif;?></div></th></tr>
	<tr>
		<th colspan="15"><div align="center">End of The Week </div></th></tr>
	<tr>
		<th rowspan="2" width="4%"><div align="center">Field Officer ID</div></th>
		<th rowspan="2" width="4%"><div align="center">Member</div></th>
		<th rowspan="2" width="3%"><div align="center">Savings</div></th>
		<th rowspan="2" width="8%"><div align="center">Total Cum. Disburse No</div></th>
		<th rowspan="2" width="10%"><div align="center">Total Cum. Disbursement</div></th>
		<th rowspan="2" width="9%"><div align="center">Cum. Fully Paid Borrower</div></th>
		<th rowspan="2" width="8%"><div align="center">Cum. Fully Paid Amount</div></th>
		<th rowspan="2" width="9%"><div align="center">Cum. Expaired Borrower</div></th>
		<th rowspan="2" width="10%"><div align="center">Cum. Expaired Loan Amount</div></th>
		<th rowspan="2" width="5%"><div align="center">Current Borrower</div></th>
		<th rowspan="2" width="9%"><div align="center">Current Loan Amount</div></th>
		<th colspan="3"><div align="center">Overdue</div></th>
		<th rowspan="2" width="6%"><div align="center">Outstanding</div></th></tr>	
	<tr>
		<th width="6%"><div align="center">Current Due</div></th>
		<th width="5%"><div align="center">Expired Due</div></th>
		<th width="4%"><div align="center">Total</div></th></tr>	
	<tr>
		<th><div align="center">33</div></th>
		<th><div align="center">34=4+17-18</div></th>
		<th><div align="center">35=5+19-20</div></th>
		<th><div align="center">36=6+21</div></th>
		<th><div align="center">37=7+22</div></th>
		<th><div align="center">38=8+23</div></th>
		<th><div align="center">39=9+24</div></th>
		<th><div align="center">40=10+25</div></th>
		<th><div align="center">41=11+26</div></th>
		<th><div align="center">42=36-38-40</div></th>
		<th><div align="center">43=37-39-41</div></th>
		<th><div align="center">44</div></th>
		<th><div align="center">45</div></th>
		<th><div align="center">46=44+45</div></th>
		<th><div align="center">47=15+22(With Sc)-31</div></th></tr>	
	<tr>
	<?php if(isset($branch_manager_report_data_end_week)):
			$i=0;	
			foreach($branch_manager_report_data_end_week as $row3):?>
		<tr>
			<th><div align="center"><?php echo $row3['employee_code'];?></div></th>			
			<th><div align="center"><?php echo $row3['member_no'];?></div></th>			
			<th><div align="right"><?php echo number_format($row3['savings'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row3['cum_disbursement_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row3['cum_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row3['cum_fully_paid_loan_disbursement_no'];?></div></th>
			<th><div align="right"><?php echo number_format($row3['cum_fully_paid_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row3['cum_exp_borrower'];?></div></th>
			<th><div align="right"><?php echo number_format($row3['cum_exp_loan_amount'],'2','.',',');?></div></th>
			<th><div align="center"><?php echo $row3['current_borrower'];?></div></th>
			<th><div align="right"><?php echo number_format($row3['current_loan_amount'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row3['due'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row3['overdue'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row3['total_overdue'],'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($row3['total_outstanding'],'2','.',',');?></div></th></tr>
		<?php endforeach; endif;?>
		<tr>
			<th>Total</th>			
			<th><div align="center"><?php echo $total_member_end_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_savings_end_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_disbursement_no_end_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_loan_amount_end_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_fully_paid_loan_disbursement_no_end_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_fully_paid_loan_amount_end_week,'2','.',',');?></div></th>
			<th><div align="center"><?php echo $total_cum_exp_borrower_end_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_cum_exp_loan_amount_end_week,'2','.',',');?></div></th>			
			<th><div align="center"><?php echo $total_current_borrower_end_week;?></div></th>
			<th><div align="right"><?php echo number_format($total_current_loan_amount_end_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_due_end_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_overdue_end_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_total_overdue_end_week,'2','.',',');?></div></th>
			<th><div align="right"><?php echo number_format($total_total_outstanding_end_week,'2','.',',');?></div></th></tr></table>
<br><br><br>			
<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>