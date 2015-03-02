<script type="text/javascript">
	$(function(){
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<h3><?php //echo $headline?></h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$session_data=$this->session->userdata('loan_transactions.index');
	$attribute = 'class="search_input" title="Loan Id or Member Code"'; 
	?>
	<?php echo form_open('loan_transactions/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>		
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>	
			
			<td>
				<?php 
				$attribute = 'class="search_input" title="From Date"'; 
				$from_date_attr = array('name'=>'txt_from_date','id'=>'txt_from_date');
				echo form_input($from_date_attr,set_value('txt_from_date'),$attribute);?>
			</td>	
			<td>
				<?php 
				$attribute = 'class="search_input" title="To date"'; 
				$to_date_attr = array('name'=>'txt_to_date','id'=>'txt_to_date');
				echo form_input($to_date_attr,set_value('txt_to_date'),$attribute);?>
			</td>			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('loan_transactions/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan Transaction')).'Add',array('class'=>'addbutton','title'=>'Add Loan Transaction'));  ?>
	</div>	
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width="5%">#</th>	
		<th >Loan ID</th>
        <th >Samity ID</th>
        <th >Member ID</th>
		<th >Transaction Date</th>		
		<th width="8%">Installment Amount</th>
        <th width="8%">Paid Amount</th>
        <th width="8%">Outstanding Amount</th>
		<th width="5%">Status</th>
		<th width='5%'>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($loan_transactions as $row):
		$i++;
		$authorized = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
		$unauthorized = img(array('src'=>base_url().'media/images/button_fewer.png','border'=>'0','alt'=>'OK'));        
	?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
		<td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->customized_loan_no;?></td>
        <td><?php echo $row->samity_code;?></td>
        <td><?php echo $row->member_code;?></td>
		<td><?php echo date('d/m/Y', strtotime($row->transaction_date));?></td>	
		<td align="right"><?php echo number_format($row->transaction_amount,'2','.',',');?></td>
        <td align="right"><?php echo number_format($row->current_total_collection_amount,'2','.',',');?></td>
        <td align="right"><?php echo number_format($row->current_outstanding_amount,'2','.',',');?></td>
		<td><?php if($row->is_authorized==0): echo $unauthorized; else: echo $authorized; endif;?></td>		
		<td>
			<?php if($row->is_authorized==0): echo anchor('loan_transactions/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
			<?php echo anchor('loan_transactions/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
				  array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));
			 endif;
			?>
	</td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
