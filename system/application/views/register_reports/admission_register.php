<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>		
			<table border="0"> 
		 		<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code </th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th><div align="left">Branch Address</div></th>
		 			<td colspan="3" class="align-left"><strong>: </strong><?php echo $branch_info['address'];?></td></tr>   		
				<?php else:?>
				<tr>
		  			<th class="align-left" width="20%">Branch Name & Code</th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo 'All';?></td></tr> 
				<?php endif;?>
				<tr>
		 			<th class="align-left">Reporting Date</th>
		 			<td class="align-left"><strong>: </strong>
					<?php echo date('d-m-Y',strtotime($date_from)). ' to ' .date('d-m-Y',strtotime($date_to));?></td>		 			
					<th class="align-left">Print Date</th>
		 			<td class="align-left"><strong>: </strong><?php echo date("d-m-Y");?></td></tr></table>
			
			<table class="report-body" width="100%" border="1" cellspacing="0">  
		  	<tr>
				<th rowspan="2" width="1%"><div align="center"><b>SL. No.</b></div></th>
				<th rowspan="2" width="5%"><div align="center">Samity Code</div></th>
				<th rowspan="2"><div align="center">Samity Name</div></th>
				<th colspan="2"><div align="center">Member</div></th>
				<th rowspan="2" width="5%"><div align="center">Spouse</div></th>
				<th rowspan="2" width="5%"><div align="center">Village Name </div></th>
				<th rowspan="2" width="10%"><div align="center">Union-Name </div></th>
				<th rowspan="2" width="5%"><div align="center">Thana Name </div></th>
				<th rowspan="2" width="4%"><div align="center">Age </div></th>
				<th rowspan="2" width="5%"><div align="center">Profession</div></th>
				<th rowspan="2" width="5%"><div align="center">Education</div></th>
				<th rowspan="2" width="4%"><div align="center">Application No.</div></th>
				<th rowspan="2" width="9%"><div align="center">Approval Date </div></th>
				<th rowspan="2" width="6%"><div align="center">Approved By </div></th>
				<th rowspan="2" width="8%"><div align="center">Admission Date </div></th>
				<th rowspan="2" width="6%"><div align="center">Status Active/ Inactive </div></th></tr>
		  	<tr>
				<th width="4%"><div align="center">Code</div></th>
				<th width="5%"><div align="center">Name</div></th></tr>
			<?php $i=0; if(!empty($admission_register_information)):  foreach ($admission_register_information as $row): $i++;?>
			<tr>
				<th><?php echo $i;?></td>
				<td><?php echo $row['samity_code'];?></td>
				<td align="left"><?php echo $row['samity_name'];?></td>
				<td><?php echo $row['member_code'];?></td>
				<td align="left"><?php echo $row['member_name'];?></td>
				<td align="left"><?php echo $row['fathers_spouse_name'];?></td>
				<td align="left"><?php echo isset($row['village_name'])?$row['village_name']:"";?></td>
				<td align="left"><?php echo isset($row['union_name'])?$row['union_name']:"";?></td>
				<td align="left"><?php echo isset($row['thana_name'])?$row['thana_name']:"";?></td>				
				<td><?php echo $row['age'];?></td>
				<td align="left"><?php echo isset($row['profession'])?$row['profession']:"-";?></td>
				<td><?php echo $row['last_achieved_degree'];?></td>
				<td><?php echo $row['form_application_no'];?></td>
				<td><?php if(!empty($row['approved_date'])) {echo date('d-m-Y',strtotime($row['approved_date']));} else { echo '-';}?></td>
				<td><?php echo $row['approved_by'];?></td>
				<td><?php if(!empty($row['admission_date'])) {echo date('d-m-Y',strtotime($row['admission_date']));} else { echo '-';}?></td>
				<td><?php echo $row['member_status'];?></td></tr>
			<?php endforeach;endif; ?>	
			<tr>
				<th>Total</th>
				<th colspan="2"><?php echo $admission_register_total_information['total_samity'];?></th>
				<th colspan="2"><?php echo $i;?></th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<?php if ($admission_register_total_information['total_approved_by']>0){ ?>
				<th><?php echo $admission_register_total_information['total_approved_by'];}?></th>
				<th>&nbsp;</th>
				<th>&nbsp;</th></tr></table>			
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
