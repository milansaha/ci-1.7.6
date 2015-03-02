<?php
	$samity_group_options = array(''=>"---Samity Group---");
    //echo "<pre>";print_r($samity_group_infos);die;
    if(!empty($samity_group_infos))
    {
        foreach($samity_group_infos as $samity_group_info)
        {          
            $samity_group_options[$samity_group_info->group_id]=$samity_group_info->group_name;
        }
    }
    //echo "<pre>";print_r($samity_options);die;
	$session_data = $this->session->userdata('samity_subgroups.index');	
	echo form_open('samity_subgroups/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="Search by subgroup name "'; ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_samity_group', $samity_group_options, isset($session_data['cbo_samity_group'])?$session_data['cbo_samity_group']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('samity_subgroups/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Samity SubGropup')).'Add',array('class'=>'addbutton','title'=>'Add Union Ward'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>	
	<th>Sub Group Name</th>
    <th>Group Name</th>
	<th>Sub Group Code</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($subgroups as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>	
	<td><?php echo $row->subgroup_name;?></td>
    <td><?php echo $row->group_name;?></td>
	<td><?php echo $row->subgroup_code;?></td>
	<td>
	<?php echo anchor('samity_subgroups/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('samity_subgroups/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
