<?php 
	$session_data = $this->session->userdata('po_working_areas.index');
	$attribute = 'class="search_input" title="By Name "'; 	
	echo form_open('po_working_areas/index',array('id'=>'search_form','name'=>'search_form')); 
 ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>			
				<?php
					echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute );
				?>	
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('po_working_areas/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Working Area')).'Add',array('class'=>'addbutton','title'=>'Add Working Area'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width='5%'>#</th>
	<th>Working Area Name</th>
	<th>Village/Block</th>
    <th>Union/Ward</th>
    <th>Thana</th>
    <th>District</th>
	<th width='10%'>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($po_working_areas as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
    <td class="serial"><?php echo $i;?></td>
    <td><?php echo $row->name;?></td>
    <td><?php echo $row->village_name;?></td>
    <td><?php echo $row->union_name;?></td>
    <td><?php echo $row->thana_name;?></td>
    <td><?php echo $row->district_name;?></td>
	<td>
		<?php echo anchor('po_working_areas/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
		<?php echo anchor('po_working_areas/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
						array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
