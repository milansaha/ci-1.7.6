<?php
	$samity_options = array(''=>"---Samity---");
    if(!empty($samities_info))
    {
        foreach($samities_info as $samity_row)
        {            
            $samity_options[$samity_row->id] = $samity_row->name;
        }
    }
	$session_data = $this->session->userdata('samity_groups.index');
?>
<?php 	$attribute = array('id'=>'myform','name'=>'myform');
		echo form_open('samity_groups/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="Search by name "'; ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('samity_groups/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Samity Group')).'Add',array('class'=>'addbutton','title'=>'Add Samity Group'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>
	<th>Name</th>
	<th>Samity</th>
	<th width="10%">Action</th>
</tr>
<?php 
$i=$counter;
foreach ($samity_groups as $row):
$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->samity_name;?></td>
	<td>
	<?php echo anchor('samity_groups/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink'));   ?>
	<?php echo anchor('samity_groups/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
