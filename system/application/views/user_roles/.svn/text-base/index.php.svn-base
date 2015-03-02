<h3><?php //echo $headline;?></h3>

<?php echo form_open('user_roles/index',array('id'=>'search_form','name'=>'search_form')); ?>

<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php 
					$attribute = 'class="search_input" title="By name or Description"'; 
					echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);
				?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>				
			</td>
		</tr>		
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('/user_roles/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add User Role')).'Add',array('class'=>'addbutton','title'=>'Add User Role'));  ?>
	</div>
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>
	<th width="35%">Role Name</th>
	<th width="45%">Role Description</th>	
	<th>Action</th>
</tr>
<?php 
	$i=0;
	foreach ($user_roles as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->role_name;?></td>
	<td><?php echo $row->role_description;?></td>
	<td>
	<?php echo anchor('user_role_wise_privileges/index/'.$row->id, 'Edit Permission');?> 
	<?php echo anchor('user_roles/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('title'=>'Edit','class'=>'imglink'));   ?>
	<?php echo anchor('user_roles/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>	
</tr>
<?php endforeach;?>
</table>

<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?>
</div>
<?php echo form_close(); ?>
