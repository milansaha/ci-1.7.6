<script type="text/javascript">
//Java Script for district list by division list
$(document).ready(function() {
$("#cbo_division").change(
	function(){
		// start json
		// savings information
		
		var selected_division_id = $("#cbo_division").val();				
		//alert(selected_division_id);
		
		$.post("<?php echo site_url('po_thanas/ajax_for_get_district_by_division') ?>", { division_id: selected_division_id},
			function(data)
				{
					$('#status').html("");
					$('#cbo_district').empty();
					$('#cbo_thana').empty();
					$('#cbo_district').append('<option value = "">-----District-----</option>');
					$('#cbo_thana').append('<option value = "">-----Thana-----</option>');
					if( data.status == 'failure' )
					{
						//alert(data.message);					
					}
					else
					{
						//alert(data.district.id);
						//$('#from_samity_row').removeAttr('style');
						for(var i = 0; i < data.district.id.length; i++)
						{
							$('#cbo_district').append('<option value = \"' + data.district.id[i] + '\">' + data.district.name[i] + '</option>');
						
						}
					}
				}, "json")
		});		
});
//Java Script for Thana list by district
$(document).ready(function() {
$("#cbo_district").change(
	function(){
		// start json
		// savings information
		
		var selected_district_id = $("#cbo_district").val();				
		//alert(selected_district_id);
		
		$.post("<?php echo site_url('po_unions_or_wards/ajax_for_get_thana_by_district') ?>", { district_id: selected_district_id},
			function(data)
				{
					$('#status').html("");
					$('#cbo_thana').empty();
					$('#cbo_thana').append('<option value = "">-----Thana-----</option>');
					if( data.status == 'failure' )
					{
						//alert(data.message);					
					}
					else
					{						
						for(var i = 0; i < data.thana.id.length; i++)
						{
							$('#cbo_thana').append('<option value = \"' + data.thana.id[i] + '\">' + data.thana.name[i] + '</option>');
						
						}
					}
				}, "json")
		});		
});

</script>


<?php 	
	$division_options =  array(''=>"-----Division-----");	
	foreach($divisions as $division_row)
	{					
		$division_options[$division_row->id]=$division_row->name;
	}
	//District list
	$district_options =  array(''=>"-----District-----");
	if(!empty($districts))
	{
		foreach($districts as $district_row)
		{					
			$district_options[$district_row->id]=$district_row->name;
		}
	}
	
	$thana_options = array(''=>"-----Thana-----");
	if(!empty($thanas))
	{
		foreach($thanas as $thana_row)
		{	
			$thana_options[$thana_row->id]=$thana_row->name;
		}
	}	
	$session_data = $this->session->userdata('po_unions_or_wards.index');		
?>
<?php echo form_open('po_unions_or_wards/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php $attribute = 'class="search_input" title="By Name "'; ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>				
				<?php echo form_dropdown('cbo_division', $division_options, set_value('cbo_division', (isset($session_data['cbo_division'])?$session_data['cbo_division']:"")),'id="cbo_division"'); ?>
			</td>
			<td>				
				<?php echo form_dropdown('cbo_district', $district_options, set_value('cbo_district', (isset($session_data['cbo_district'])?$session_data['cbo_district']:"")),'id="cbo_district"'); ?>
			</td>	
			<td>
				<?php echo form_dropdown('cbo_thana', $thana_options, set_value('cbo_thana', (isset($session_data['cbo_thana'])?$session_data['cbo_thana']:"")),'id="cbo_thana"'); ?>
			</td>		
			<td>				
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('po_unions_or_wards/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Union Ward')).'Add',array('class'=>'addbutton','title'=>'Add Union Ward'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
	<tr>
		<th width='5%'>#</th>	
		<th>Union/Ward Name</th>
		<th>Thana Name</th>	
		<th>District Name</th>
		<th>Division Name</th>		
		<th width='10%'>Action</th>
	</tr>
	<?php 
		$i=$counter;
		foreach ($po_unions_or_wards as $row):
		$i++;
	?>
	 <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
		<td><?php echo $row->name;?></td>
		<td><?php echo $row->thana_name;?></td>	
		<td><?php echo $row->district_name;?></td>
		<td><?php echo $row->division_name;?></td>
		<td>
		<?php echo anchor('po_unions_or_wards/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'','title'=>'Edit'));   ?>
		<?php echo anchor('po_unions_or_wards/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
						array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>
		</td>		
	</tr>
	<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
