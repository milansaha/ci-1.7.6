<div class="scroll-report">
		<div class="report-header">			
			<div align="center"><?php $this->load->view('/elements/report_header');?></div>
			<br>
			<h2><div align="center"><?php echo $headline;?></div></h2>		
			<table width="100%" border="0" cellspacing="0"> 
		 		<?php if(!empty($branch_info)): ?>
				<tr>
		  			<th width="15%"><div align="left">Branch Name & Code </div></th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo $branch_info['name']."(".$branch_info['code'].")";?></td></tr> 
		 		<tr>
					<th><div align="left">Branch Address</div></th>
		 			<td colspan="3" class="align-left"><strong>: </strong><?php echo $branch_info['address'];?></td></tr>   		
				<?php else:?>
				<tr>
		  			<th width="15%"><div align="left">Branch Name & Code</div></th>
		  			<td colspan="3" class="align-left" width="49%"><strong>: </strong><?php echo 'All';?></td>
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
				<th class="center">Type</th>
				<th class="center">Samity Day</th>
				<th class="center">Opening Date</th>
				<th class="center">Status</th>
			</tr>
			<?php $counter=0;$pre_branch="";?>
			<?php foreach($samity_infos as $samity_info):?>
			<?php if($i=0){               
				$pre_branch=$samity_info->branch_id;$i++;}
				if($pre_branch!=$samity_info->branch_id){
                     $counter=0;
					$i=0;$pre_branch=$samity_info->branch_id;$i++;
					}
			$counter++;?>
			<?php if($i>0 and empty($branch_info)):?>
			<tr><td class="center" colspan="10" style="font-weight: bold;font-size: 12px;"><?php echo $samity_info->branch_name . ' (' . $samity_info->branch_code .')';?></td></tr>
			<?php endif;?>
			<tr>
				<td class="align-left"><?php echo $counter;?></td>				
				<td class="align-left"><?php echo $samity_info->code;?></td>
				<td class="align-left"><?php echo $samity_info->name;?></td>
				<td class="align-left"><?php if(isset($samity_types[$samity_info->samity_type])){echo $samity_types[$samity_info->samity_type];}?></td>
				<td class="align-left">
					<?php $sday = ucfirst(strtolower($samity_info->samity_day));
						if(isset($samity_days[$sday])){echo $samity_days[$sday];}
					?>	
				</td>
				<td class="align-left"><?php echo date('d/m/Y', strtotime($samity_info->opening_date));?></td>
				<td class="align-left"><?php if(isset($status[$samity_info->status])){echo $status[$samity_info->status];}?></td>
			</tr>
			<?php endforeach;?>
		  	</table>			
		<div class="report-footer" align="center" border="0"><?php $this->load->view('/elements/report_footer');?></div>		
</div></div>
