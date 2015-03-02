<div id="filter">
	<h3><?php echo $headline?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('samity_closings/close',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Samity Closing')).'Add',array('class'=>'addbutton','title'=>'Add Samity Closing'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width='5%'>#</th>
		<th>Samity Name</th>	
		<th>Code</th>
		<th>Field Officer</th>
		<th>Samity Day</th>
		<th>Samity Type</th>
        <th>Opening Date</th>
		<th>Closing Date</th>
	</tr>
	<?php 	$i=$counter;
			foreach ($closed_samities as $row):
			$i++; ?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->name;?></td>
		<td><?php echo $row->code;?></td>
		<td><?php echo $row->field_officer_name;?></td>
		<td><?php 
			$sday = ucfirst(strtolower($row->samity_day));
			if(array_key_exists($sday, $samity_days)){echo $samity_days[$sday];}?></td>
		<td>
			<?php if($row->samity_type=='F')
					{
						echo "Female";
					} 
				   elseif($row->samity_type=='M') {
						echo "Male";
					}
			?>
		</td>
        <td><?php echo date('d/m/Y', strtotime($row->opening_date));?></td>
		<td><?php echo date('d/m/Y', strtotime($row->closing_date));?></td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
