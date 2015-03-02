<?php if(empty($skt_collections)):
echo "No SKT Collection Available for Authorization";
else:?>
<h3>SKT Collection Authorization</h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}	
	$session_data=$this->session->userdata('skt_collections.authorization_index');?>
<?php echo form_open('skt_collections/authorization_index'); ?>
<div id="filter">
<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>					
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
</div>
<?php echo form_close(); ?>
<?php echo form_open('skt_collections/authorization_index');?>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th>Member Name</th>	
	<th>Member Code</th>	
	<th>Transaction Date</th>		
	<th>Mode of Payment</th>	
	<th><div align="center">Amount</div></th>
	<th width="3%">Is Authorized</th>	
</tr>
<?php $i=$counter; $i=0;foreach ($skt_collections as $row): $i++;?>	
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->member_name;?></td>
	<td><?php echo $row->member_code;?></td>	
	<td><?php echo date('d/m/Y',strtotime($row->transaction_date));?></td>	
	<td><?php echo $row->mode_of_payment;?></td>
	<td align="center"><?php echo $row->amount;?></td>
	<input type="hidden" name="sktcollectiondata[<?php echo $i;?>][id]" id="loan_id_[<?php echo $i;?>]" value="<?php echo $row->id;?>" />
	<td><input type="checkbox" id="is_authorized<?php echo $i;?>"  name="sktcollectiondata[<?php echo $i;?>][is_authorized]" value="1" style="margin:0px;width:20px;border:none;">Yes</td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<br/><br/><br/><br/>
<?php echo form_submit(array('name'=>'submit_1','id'=>'submit_1','class'=>'save_button'),'Authorize Selected SKT Collections');?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo form_submit(array('name'=>'submit_2','id'=>'submit_2','class'=>'save_button'),'Authorize All SKT Collections');?>
<?php echo form_close(); endif;?>
