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
					$('#cbo_union').empty();
					$('#cbo_district').append('<option value = "">--------SELECT----------</option>');
					$('#cbo_thana').append('<option value = "">--------SELECT----------</option>');
					$('#cbo_union').append('<option value = "">--------SELECT----------</option>');
					if( data.status == 'failure' )
					{
						//alert(data.message);					
					}
					else
					{						
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
		
		var selected_district_id = $("#cbo_district").val();				
		
		$.post("<?php echo site_url('po_unions_or_wards/ajax_for_get_thana_by_district') ?>", { district_id: selected_district_id},
			function(data)
				{
					$('#status').html("");
					$('#cbo_thana').empty();
					$('#cbo_union').empty();
					$('#cbo_thana').append('<option value = "">--------SELECT----------</option>');
					$('#cbo_union').append('<option value = "">--------SELECT----------</option>');
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
//Java Script to get list Union by thana
$(document).ready(function() {
$("#cbo_thana").change(
	function(){
		// start json
		
		var selected_thana_id = $("#cbo_thana").val();				
		
		$.post("<?php echo site_url('po_village_or_blocks/ajax_for_get_union_by_thana') ?>", { thana_id: selected_thana_id},
			function(data)
				{
					$('#status').html("");
					$('#cbo_union').empty();
					$('#cbo_union').append('<option value = "">--------SELECT----------</option>');
					if( data.status == 'failure' )
					{
						//alert(data.message);					
					}
					else
					{
						for(var i = 0; i < data.union.id.length; i++)
						{
							$('#cbo_union').append('<option value = \"' + data.union.id[i] + '\">' + data.union.name[i] + '</option>');
						
						}
					}
				}, "json")
		});		
});
</script>		

<?php 
	//Division list
	$division_options = array("" => "--------SELECT----------");
	foreach($divisions as $division_row)
	{					
		$division_options[$division_row->id]=$division_row->name;
	}

	//District list
	$district_options =  array(''=>"--------SELECT----------");
	foreach($districts as $district_row)
	{					
		$district_options[$district_row->id]=$district_row->name;
	}
	
	//Thana list
	$thana_options =  array(''=>"--------SELECT----------");
	foreach($thanas as $thana_row)
	{					
		$thana_options[$thana_row->id]=$thana_row->name;
	}

	//Union list
	$union_options =  array(''=>"--------SELECT----------");
	foreach($unions as $union_row)
	{					
		$union_options[$union_row->id]=$union_row->name;
	}
?>
	<?php
		$action=$this->uri->segment(2);
		$hidden_input=null;
		if($action=='edit')
		{
			$hidden_input=array('txt_village_id'=>$row->id);
			$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
		echo form_open("po_village_or_blocks/$action",'',$hidden_input);
	?>
<fieldset style="">
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div <?php echo $class_name?>>
					<h2><?php echo $headline?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_village_or_blocks')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
				<ol>  
					<li>
						<label for="name">Name:<span class="required_field_indicator">*</span></label>
                        <div class="form_input_container">
						<?php echo form_input(array('name'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name', (isset($row->name)?$row->name:"")));?><?php echo form_error('txt_name'); ?>
                        </div>
					</li> 
					<li>
						<label 	for="cbo_division">Division:<span class="required_field_indicator">*</span></label>
                        <div class="form_input_container">
						<?php echo form_dropdown('cbo_division', $division_options, set_value('cbo_division', (isset($row->division_id)?$row->division_id:"")),'id="cbo_division" class="input_select"'); ?>
                        <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Division','width'=>'12px')), 'add_division', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Division','onclick'=>"window.location.href='".site_url('po_divisions/add')."'"));?></div>						
						<?php echo form_error('cbo_division'); ?>
                        </div>
					</li> 
					<li>
						<label 	for="cbo_district">District:<span class="required_field_indicator">*</span></label>
                        <div class="form_input_container">
						<?php echo form_dropdown('cbo_district', $district_options, set_value('cbo_district', (isset($row->district_id)?$row->district_id:"")),'id="cbo_district" class="input_select"'); ?>
                        <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add District','width'=>'12px')), 'add_district', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add District','onclick'=>"window.location.href='".site_url('po_districts/add')."'"));?></div>						
						<?php echo form_error('cbo_district'); ?>
                        </div>
					</li>		
					<li>
						<label 	for="cbo_thana">Thana:<span class="required_field_indicator">*</span></label>
                        <div class="form_input_container">
						<?php echo form_dropdown('cbo_thana', $thana_options, set_value('cbo_thana', (isset($row->thana_id)?$row->thana_id:"")),'id="cbo_thana" class="input_select"'); ?>
                        <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Thana','width'=>'12px')), 'add_thana', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Thana','onclick'=>"window.location.href='".site_url('po_thanas/add')."'"));?></div>						
						<?php echo form_error('cbo_thana'); ?>
                        </div>
					</li>
					<li>
						<label 	for="cbo_union">Union/Ward:<span class="required_field_indicator">*</span></label>
                        <div class="form_input_container">
						<?php echo form_dropdown('cbo_union', $union_options, set_value('cbo_union', (isset($row->union_or_ward_id)?$row->union_or_ward_id:"")),'id="cbo_union" class="input_select"'); ?>
                        <div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Union/Ward','width'=>'12px')), 'add_unions_or_ward', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Union/Ward','onclick'=>"window.location.href='".site_url('po_unions_or_wards/add')."'"));?></div>
						
						<?php echo form_error('cbo_union');?>
                        </div>
					</li>					
				</ol>
				</div>
			</td>
			<td valign="top" style="background:url(<?php echo base_url();?>media/images/alpona.gif) no-repeat bottom right;">
				<p class="helper"></p>
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('po_village_or_blocks')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
