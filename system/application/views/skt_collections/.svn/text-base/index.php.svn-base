<script type="text/javascript">
$(function(){
	$("#txt_transaction_date").datepicker({dateFormat: 'yy-mm-dd'});	
});
</script>
<h3><?php //echo $headline?></h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$session_data=$this->session->userdata('skt_collections.index');
?>
<?php echo form_open('skt_collections/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php 
				$attribute = 'class="search_input" title="By Code"'; 
				echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>		
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>			
			<td>
				<?php 
				$attribute = 'class="search_input" title="Transaction Date"'; 
				echo form_input(array('name'=>'txt_transaction_date','id'=>'txt_transaction_date'),set_value('txt_transaction_date', isset($session_data['txt_transaction_date'])?$session_data['txt_transaction_date']:""),$attribute);?>
			</td>				
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('skt_collections/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add SKT Collections')).'Add',array('class'=>'addbutton','title'=>'Add New SKT Collections'));  ?>
	</div>
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width="5%">#</th>				
		<th>Member Name</th>	
		<th width='12%'>Member Code</th>		
		<th width='12%'>Transaction Date</th>			
		<th width='12%'>Mode of Payment</th>	
		<th><div align="right">Amount</div></th>	
		<th width="5%">Status</th>
		<th width='5%'>Action</th>	
	</tr>
	<?php 
		$i=$counter;
		foreach ($skt_collections as $row):
		$i++;
		$authorized = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
		$unauthorized = img(array('src'=>base_url().'media/images/dimed_ok.png','border'=>'0','alt'=>'OK'));
	?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?>>
		<td class="serial"><?php echo $i;?></td>			
		<td><?php echo $row->member_name;?></td>
		<td><?php echo $row->member_code;?></td>		
		<td><?php echo date('d/m/Y',strtotime($row->transaction_date));?></td>	
		<td><?php echo $row->mode_of_payment;?></td>
		<td align="right"><?php echo $row->amount;?></td>		
		<td><?php if($row->is_authorized==0): echo $unauthorized; else: echo $authorized; endif;?></td>
		<td><?php if($row->is_authorized==0): echo anchor('skt_collections/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
					<?php echo anchor('skt_collections/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')")); endif;?></td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
