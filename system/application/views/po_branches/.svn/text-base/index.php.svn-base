<h3><?php //echo $headline?></h3>
<script type="text/javascript">
	$(function(){	
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php 
	$session_data = $this->session->userdata('po_branches.index');	
?>
<?php 	echo form_open('po_branches/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				
				<?php 
					$attribute = 'class="search_input" title="By Name or Code "'; 
					echo form_input('txt_name',set_value('txt_name',isset($session_data['txt_name'])?$session_data['txt_name']:""),$attribute);
				?>		
			</td>
			<td>
				
				<?php 
						$attribute = 'class="search_input" title="From Date "'; 
						$from_date_attr = array('name'=>'txt_from_date','id'=>'txt_from_date','maxlength'=> '10');
						echo form_input($from_date_attr,set_value('txt_from_date',isset($session_data['from_date'])?date('Y-m-d',$session_data['from_date']):""),$attribute);?>
				<?php echo form_error('txt_from_date'); ?>		
			</td>
			<td>
				<?php 
						$attribute = 'class="search_input" title="To Date "'; 
						$to_date_attr = array('name'=>'txt_to_date','id'=>'txt_to_date','maxlength'=> '10');
						echo form_input($to_date_attr,set_value('txt_to_date',isset($session_data['to_date'])?date('Y-m-d',$session_data['to_date']):""),$attribute);?>
				<?php echo form_error('txt_to_date'); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('po_branches/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Branch')).'Add',array('class'=>'addbutton','title'=>'Add Branch'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>	
	<th>Branch ID</th>
	<th>Name</th>	
	<th>Opnening Date</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($po_branches_info as $row):
	$i++;
?>
 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>	
	<td><?php echo $row->code;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->opening_date));?></td>
	<td>
	<?php echo anchor('po_branches/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('po_branches/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
