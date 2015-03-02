<?php 
	$division_options = array(''=>"---Division---");
	foreach($divisions as $division_row)
	{	
		$division_options[$division_row->id]=$division_row->name;
	}	
	$session_data = $this->session->userdata('po_districts.index');	
?>	
<?php echo form_open('po_districts/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td><?php $attribute = 'class="search_input" title="By Name "';  ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_division', $division_options, isset($session_data['cbo_division'])?$session_data['cbo_division']:""); ?>
			</td>			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('po_districts/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add District')).'Add',array('class'=>'addbutton','title'=>'Add District'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width='5%'>#</th>	
	<th>District Name</th>	
	<th>Division Name</th>
	<th width='10%'>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($po_districts as $row):
	$i++;
?>
 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>	
	<td><?php echo $row->division_name;?></td>	
	<td>
	<?php echo anchor('po_districts/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('title'=>'Edit','class'=>'imglink'));   ?>
	<?php echo anchor('po_districts/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
