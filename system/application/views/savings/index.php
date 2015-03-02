<h3><?php //echo $headline;?></h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}	
	$session_data=$this->session->userdata('savings.index');	
	?>
	
<?php echo form_open('savings/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="Savings Code Member Code"'; ?>
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
		<?php echo anchor('savings/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Savings')).'Add',array('class'=>'addbutton','title'=>'Add Savings'));  ?>
	</div>
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width="5%">#</th>	
		<th>Savings Code</th>	
		<th>Member Code</th>
		<th>Member Name</th>
		<th>Samity Code</th>
		<th>Samity Name</th>
		<th>Weekly Savings</th>			
		<th>Opening Date</th>	
		<th width='10%'>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($savings as $row):
		$i++;
	?>
	<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?>>
		<td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->code;?></td>
		<td><?php echo $row->member_code;?></td>
		<td><?php echo $row->member_name;?></td>
		<td><?php echo $row->samity_code;?></td>
		<td><?php echo $row->samity_name;?></td>
		<td><?php echo $row->weekly_savings;?></td>		
		<td><?php echo date('d/m/Y',strtotime($row->opening_date));?></td>	
		<td>
			<?php echo anchor('savings/view/'.$row->id,img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'View')),array('class'=>'imglink','title'=>'View'));?>
			<?php echo anchor('savings/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'Edit')),array('class'=>'imglink','title'=>'Edit'));?>
			<?php echo anchor('savings/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','title'=>'Delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>


