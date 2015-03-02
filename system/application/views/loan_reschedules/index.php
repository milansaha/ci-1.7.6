<div id="filter">
	<h3><?php echo $headline?></h3>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('loan_reschedules/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loan Reschedule')).'Add',array('class'=>'addbutton','title'=>'Add Loan Reschedule'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>
	<th>Samity Code</th>
	<th>customized Loan No</th>
	<th>Member Name</th>
	<th>Loan Amount</th>
	<th>Installment No</th>
	<th>Rescheduled From</th>	
	<th>Rescheduled To</th>		
	<th width="10%">Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($loan_reschedules_infos as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->code;?></td>
	<td><?php echo $row->customized_loan_no;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->loan_amount;?></td>
	<td><?php echo $row->installment_no;?></td>
	<td><?php echo $row->reschedule_from;?></td>
	<td><?php echo $row->reschedule_to;?></td>
	<td>
	<?php echo anchor('loan_reschedules/add_reschedules/'.$row->loan_id.'/'.$row->installment_no.'/'.$row->reschedule_from.'/'.$row->reschedule_to,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('loan_reschedules/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
