<h3><?php //echo $headline;?></h3>
<script type="text/javascript">
	$(function(){	
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php 	
	$session_data = $this->session->userdata('member_transfers.index');
	//print_r($session_data);
?>

<?php echo form_open('member_transfers/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="By member name"'; ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
                <?php $attribute = 'class="search_input" title="From Date "'; ?>
				<?php	
                    $from_date_attr = array('name'=>'txt_from_date','id'=>'txt_from_date','maxlength'=> '10');
                    echo form_input($from_date_attr,set_value('txt_from_date',isset($session_data['from_date'])?$session_data['from_date']:""),$attribute);?>
			</td>
			<td>
                <?php $attribute = 'class="search_input" title="To Date "'; ?>
				<?php
                    $to_date_attr = array('name'=>'txt_to_date','id'=>'txt_to_date','maxlength'=> '10');
					echo form_input($to_date_attr,set_value('txt_to_date',isset($session_data['to_date'])?$session_data['to_date']:""),$attribute);?>
				<?php echo form_error('txt_to_date'); ?>
				
			</td>			
			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('member_transfers/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Member Transfer')).'Add',array('class'=>'addbutton','title'=>'Add Member Transfer'));  ?>
	</div>	
</div>


<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Member Name</th>
	<th>Transfer Date</th>
	<th>Previous Samity</th>
	<th>Current Samity</th>
	<th>Is Approved</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($member_transfers as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->transfer_date));?></td>
	<td><?php echo $row->previous_samity_name;?></td>
	<td><?php echo $row->current_samity_name;?></td>
	<td><?php echo ($row->is_approved)?"Yes":"No";?></td>
	<td>
	<?php if(0) { ?>
	<?php echo anchor('member_transfers/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));  ?>
	<?php echo anchor('member_transfers/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
					<?php } ?>
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
