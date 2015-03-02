<h3><?php //echo $headline;?></h3>
<script type="text/javascript">
	$(function(){	
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
	//Combo data for Branches
	$branches_options[-1] = "---Select Branch---";
	foreach($branch_infos as $user_branch_info)
	{					
		$branches_options[$user_branch_info->branch_id]=$user_branch_info->branch_name;
	}
	//status_info
	$session_data = $this->session->userdata('Config_holiday.index');
	//print_r($session_data);
?>
<?php echo form_open('config_holidays/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php 
					$attribute = 'class="search_input" title="From Date "'; 
					$from_date_attr = array('name'=>'txt_from_date','id'=>'txt_from_date','maxlength'=> '10');
					echo form_input($from_date_attr,set_value('txt_from_date',isset($session_data['from_date'])?$session_data['from_date']:""),$attribute);
				?>
			</td>
			<td>
				<?php 	
					$attribute = 'class="search_input" title="To Date "'; 
					$to_date_attr = array('name'=>'txt_to_date','id'=>'txt_to_date','maxlength'=> '10');
					echo form_input($to_date_attr,set_value('txt_to_date',isset($session_data['to_date'])?$session_data['to_date']:""),$attribute);
				?>
			</td>			
			<td>
				<?php  echo form_dropdown('cbo_user_branch', $branches_options,isset($session_data['user_branch'])?$session_data['user_branch']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_holiday_type', $search_holiday_types,isset($session_data['holiday_type'])?$session_data['holiday_type']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('/config_holidays/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Holiday Configuration')).'Add',array('class'=>'addbutton','title'=>'Add Holiday Configuration'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Holiday date</th>
	<th>Holiday Type</th>
	<th>Org.</th>
	<th>Branch</th>
	<th>Samity</th>
	<th>Applicable For</th>
    <th>Description</th>
	<th>Action</th>
</tr>
<?php
	$i=$counter;
	//echo "<pre>";
	//print_r($config_holiday);
	foreach ($config_holiday as $row):
	$i++;
	$str = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo date('d/m/Y', strtotime($row->holiday_date));?></td>
	<td><?php echo $row->holiday_type;?></td>
	<td><?php echo (empty($row->branch_name) and empty($row->samity_name) )?$str:""?></td>
	<td><?php echo (!empty($row->branch_name) and empty($row->samity_name) )?$str:""?></td>
	<td><?php echo (!empty($row->samity_name) )?$str:""?></td>
	<td><?php echo (!empty($row->samity_name) )?("Samity: $row->samity_name"):((!empty($row->branch_name) and empty($row->samity_name) )?("Branch: $row->branch_name"):"Organization")?></td>
    <td><?php echo $row->description;?></td>
	<td>
	<?php echo anchor('config_holidays/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('config_holidays/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
