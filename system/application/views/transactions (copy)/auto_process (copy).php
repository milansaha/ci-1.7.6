<?php
	//$user=$this->session->userdata('system.user');
	//print_r($samity_infos);
	//Combo data for Sanity
	$samity_options[""] = "- - - - - SELECT - - - - -";
	foreach($samity_infos as $samity_info)
	{					
		$samity_options[$samity_info->samity_id]=$samity_info->samity_name;
	}
	//Open employee Add form	
	echo form_open('transactions/auto_process');
?>
<!-- 
<fieldset>
	<legend>Auto Process</legend>
	<ol> 
		<li>
			<label for="cbo_samity">Samity ID:<em>&nbsp;</em></label>
			<?php echo form_dropdown('cbo_samity',$samity_options);?><?php echo form_error('cbo_samity'); ?>		
		</li> 
		<li>
			<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'save_button'),'Auto Process');?>
		</li>		
	</ol>
</fieldset> -->


<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th width="10%">Samity Id</th>	
	<th width="40%">Samity Name</th>		
	<th width="10%" align='center'>Status</th>
	<th width="20%" align='center'>Action</th>
</tr>
<?php 
	$i=1;
	foreach($samity_infos as $samity_info):	
	
	$authorized = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
	$unauthorized = img(array('src'=>base_url().'media/images/button_fewer.png','border'=>'0','alt'=>'OK'));	
?>
<tr <?php //if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $samity_info->samity_id;?></td>	
	<td><?php echo $samity_info->samity_name;?></td>	
	<td align='center'>
	 	<?php if(1==0): echo $unauthorized; else: echo $authorized.$unauthorized; endif;?>
	</td>	
	<td align="center">
		<?php 
			echo anchor('transactions/auto_process/'.$samity_info->samity_id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink')); 
	 ?>	
	</td>	
</tr>
<?php $i++; endforeach;?>
</table>

<?php echo form_close();?>
