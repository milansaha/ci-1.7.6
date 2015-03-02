<style type="text/css">
.migration_members { width:100%; }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(function(){
		$("#txt_approved_date").datepicker({dateFormat:'yy-mm-dd'});
	});
</script>
<?php
	//Samity list	
	$samity_options = array(''=>"--Select--");
	foreach($current_samities as $samity_row)
	{					
		$samity_options[$samity_row->samity_id] = $samity_row->samity_name;
	}
	//Gender list	
	$gender_options = array();
	//print_r($genders);
	foreach($genders as $gender_row)
	{					
		$gender_options[$gender_row] = $gender_row;
	}
	
	//Field Officer list	
	$field_officer_options = array(''=>"--Select--");
	foreach($field_officer as $field_officer_row)
	{					
		$field_officer_options[$field_officer_row->field_officer_name] = $field_officer_row->field_officer_name;
	}
?>
<h1>Migrations Members</h1>
<table width="100%" border="0" cellspacing="6px" cellpadding="3px" class="migration_members">
<?php
	//Form start
	echo form_open_multipart('migrations_members/add');
?>
  <tr>
    <td bgcolor="#E1E1E1"><strong></strong></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>Samity Name:</td><td><?php echo form_dropdown('cbo_samities_option',$samity_options,'');?></td>
		  </tr>		  
		  <tr>
			<td>Sex:</td>
			<td>
				<?php echo form_dropdown('migration_sex',$gender_options,'');?>
			</td>
		  </tr>
		  <tr>
			<td>Approved By Name:</td><td><?php echo form_dropdown('txt_approved_name',$field_officer_options,'');?></td>
		  </tr>
		  <tr>
			<td>Approved Date:</td><td><?php $approved_date_attr = array('name'=>'txt_approved_date','id'=>'txt_approved_date','maxlength'=> '10');
					echo form_input($approved_date_attr,set_value('txt_approved_date'));?><?php echo form_error('txt_approved_date');?></td>
		  </tr>
		  <tr>
			<td>Number of Members:</td><td><?php echo form_input(array('name' => 'txt_number_of_members','id' => 'txt_number_of_members','maxlength'=> '50'),set_value('txt_number_of_members'));?></td>
		  </tr>		  
		  <tr>
			<td></td><td><?php echo form_submit('submit','Start Entry');?></td>
		  </tr>
		</table>
	</td>
  </tr>

</table>


