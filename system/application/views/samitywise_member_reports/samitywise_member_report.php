<div class="scroll-report">
		<div class="report-header">
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>
			<table width="100%" border="0" cellspacing="0"> 
		 		<?php if(!empty($samity_info)): ?>
				<tr>
		  			<th width="15%"><div align="left">Samity Name & Code</div></th>
		  			<td><strong>: </strong><?php echo $samity_info->name ." (".$samity_info->code.")";?></td></tr>
				<?php else:?>
				<tr>
		  			<th width="15%"><div align="left">Samity Name & Code</div></th>
		  			<td><strong>: </strong><?php echo 'All';?></td>
		  		</tr>
				<?php endif;?>
				<tr>
					<th width="15%"><div align="left">Print Date</div></th>
		 			<td><strong>: </strong><?php echo date("d-m-Y");?></td>
		 		</tr>
		 	</table>
			<table width="100%" border="1" cellspacing="0"> 
			<tr>
				<th class="center">S/N</th>
				<th class="center">Code</th>
				<th class="center">Name</th>
				<th class="center">Registration No.</th>
				<th class="center">Registration Date</th>
				<th class="center">Status</th>
			</tr>
			<?php $counter=0;$pre_branch="";//echo "<pre>";print_r($member_infos);?>
			<?php foreach($member_infos as $member_info):?>
			<?php if($i=0){
				$pre_branch=$member_info->samity_id;$i++;}
				if($pre_branch!=$member_info->samity_id){
                     $counter=0;
					$i=0;$pre_branch=$member_info->samity_id;$i++;
					}
			$counter++;?>
			<?php if($i>0 and empty($samity_info)):?>
			<tr><td class="center" colspan="10" style="font-weight: bold;font-size: 12px;"><?php echo $member_info->samity_name . ' (' . $member_info->samity_code .')';?></td></tr>
			<?php endif;?>
			<tr>
				<td class="align-left"><?php echo $counter;?></td>
				<td class="align-left"><?php echo $member_info->code;?></td>
				<td class="align-left"><?php echo $member_info->name;?></td>
				<td class="align-left"><?php echo $member_info->registration_no;?></td>
				<td class="align-left"><?php echo date('d/m/Y', strtotime($member_info->registration_date));?></td>
				<td class="align-left"><?php echo $member_info->member_status;?></td>
			</tr>
			<?php endforeach;?>
		  	</table>
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>
</div></div>
