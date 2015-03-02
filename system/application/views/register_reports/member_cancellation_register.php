<div class="scroll-report">
		<div class="report-header">
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
			<table border="0" >
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
			
			<table width="100%" border="1" cellspacing="0">  
		  	<tr>
				<th rowspan="2" width="1%"><div align="center"><b>SL. No.</b></div></th>
				<th rowspan="2"><div align="center">Cancellation Register No</div></th>
				<th rowspan="2" width="5%"><div align="center">Samity Code</div></th>
				<th rowspan="2"><div align="center">Samity Name</div></th>
				<th colspan="2"><div align="center">Member</div></th>
				<th rowspan="2" width="5%"><div align="center">Opening Date</div></th>
				<th rowspan="2" width="5%"><div align="center">Cancellation Date </div></th>
				<th rowspan="2" width="10%"><div align="center">Cancellation Reason</div></th>
				<th rowspan="2" width="5%"><div align="center">Field officer</div></th>
				<th rowspan="2" width="4%"><div align="center">Manager</div></th>
				<th rowspan="2" width="5%"><div align="center">Status</div></th>
				<th rowspan="2" width="5%"><div align="center">Product</div></th></tr>
				
		  	<tr>
				<th width="4%"><div align="center">Code</div></th>
				<th width="5%"><div align="center">Name</div></th></tr>
			<?php $i=0; if(!empty($member_cancellation_register_information)):  foreach ($member_cancellation_register_information as $row): $i++;?>
			<tr>
				<th><?php echo $i;?></td>
				<td><?php echo isset($row['cancel_registration_no'])?$row['cancel_registration_no']:"";?></td>
				<td align="left"><?php echo isset($row['samity_code'])?$row['samity_code']:"";?></td>
				<td><?php echo isset($row['samity_name'])?$row['samity_name']:"";?></td>
                                <td align="left"><?php echo isset($row['member_code'])?$row['samity_name']:"";?></td> 
				<td align="left"><?php echo isset($row['member_name'])?$row['member_name']:"";?></td>
				<td align="left"><?php echo isset($row['opening_date'])?$row['opening_date']:"";?></td>
				<td align="left"><?php echo isset($row['cancellation_date'])?$row['cancellation_date']:"";?></td>
				<td align="left"><?php echo isset($row['cancel_reason'])?$row['cancel_reason']:"";?></td>
				<td align="left"><?php echo isset($row['field_officer_name'])?$row['field_officer_name']:"";?></td>				
				<td align="left"><?php echo isset($row['manager_name'])?$row['manager_name']:"";?></td>
				<td align="left"><?php echo isset($row['member_status'])?$row['member_status']:"";?></td>
				<td><?php echo isset($row['short_name'])?$row['short_name']:"";?></td></tr>
			<?php endforeach;endif; ?>	
			<tr>
				<th>Total</th>
                                <th colspan="2"><?php echo $i;?></th>
				<th colspan="2"><?php echo $cancel_register_total_information['total_samity'];?></th>
				
				<th>&nbsp;</th></tr>		
		</table><br><br><br>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
