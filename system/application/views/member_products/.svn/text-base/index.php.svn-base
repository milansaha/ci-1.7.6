<?php 
	//Samity list	
	$samity_options = array(''=>"--Select--");	
	foreach($samities as $samity_row)
	{					
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$session_data = $this->session->userdata('member_products.index');	
	?>
<?php echo form_open('member_products/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="By Name or Code"'; ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options,isset($session_data['cbo_samity'])?$session_data['cbo_samity']:"",'id="cbo_samity"'); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('member_products/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Member Products')).'Add',array('class'=>'addbutton','title'=>'Add Member Products'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width='5%'>#</th>
		<th >Member Name</th>
		<th width='25%'>Old Product Name</th>
		<th width='25%'>New Product Name</th>
		<th width='10%'>Transfer Date</th>
	<th width='10%'>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($member_products as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
    <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->member_name." ( ".$row->member_code." )";?></td>
	<td><?php echo $row->old_product_name;?></td>
	<td><?php echo $row->new_product_name;?></td>
	<td><?php echo date('d-m-Y',strtotime($row->transfer_date));?></td>
    <td>
        <?php echo anchor('member_products/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
        <?php //echo anchor('member_products/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')), array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
    </td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
