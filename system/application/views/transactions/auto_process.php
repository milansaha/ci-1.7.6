<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>		
	<th width="40%">Samity Name</th>		
	<!--<th width="10%" align='center'>Status</th>-->
	<th width="20%" align='center'>Action</th>
</tr>
<?php 
	$i=1;
	//echo '<pre>';
	//print_r($samity_infos);
	foreach($samity_infos as $samity_info):		
	?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>	
	<td><?php echo $samity_info->samity_name;?></td>	
	<td align="left">
		<?php 
		if(isset($samity_info->total_member)){
			echo anchor('transactions/auto_process_add/'.$samity_info->samity_id,img(array('src'=>base_url().'media/images/execute.png','border'=>'0','alt'=>'auto process')),array('class'=>'imglink','title'=>'Auto process')); 
	    }else{
			//echo 'No member !';
			echo img(array('src'=>base_url().'media/images/dimed_ok.png','border'=>'0','alt'=>'auto process'),array('class'=>'imglink','title'=>'Auto process'));
			}
	     ?>	
	</td>	
</tr>
<?php $i++; endforeach;	
		unset($samity_infos);
?>
</table>
