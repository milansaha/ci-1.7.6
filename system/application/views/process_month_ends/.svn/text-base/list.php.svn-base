<div id="filter"><h3>Month End Process List</h3></div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width='5%'>#</th>
		<th>Date</th>
		<th>Branch</th>
		<th width='10%'>Action</th>
	</tr>
	<?php 	$i=$counter;
			foreach ($month_end_process as $row):
			$i++; ?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->date;?></td>
		<td><?php echo $row->branch_code.' - '.$row->branch_name;?></td>	
		<td>
		<?php 
		//echo $day_end_valid_deletable_date."----------";
		if(isset($day_end_valid_deletable_date) && $day_end_valid_deletable_date == $row->date) {
				echo anchor('process_month_ends/delete/'.$row->date, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
						array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));
			}			
						?>	
		</td>		
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
