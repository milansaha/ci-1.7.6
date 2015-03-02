<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(function(){
		$("#txt_registration_date").datepicker({dateFormat: 'yy-mm-dd'});
		$("#txt_date_of_birth").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<script type="text/javascript">
// dropdown list by JSON
$(document).ready(function()
	{	
		// Samity wise group
		$("#cbo_samity").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var selected_samity = $("#cbo_samity").val();
			// samity type
			$.post("<?php echo site_url('samities/ajax_for_get_samity_type_by_samity_id') ?>", { samity_id: selected_samity },
			function(data)
			{
				$('#status').html("");
				$('#txt_gender').val((data.samity_type == 'F')?"Female":"Male");
				$('#txt_gender').attr('readonly',"readonly");
			}, "json");
			// auto id congif

			$('#txt_code').val("");
			$('#txt_id_sequence_no').val("");

			$.post("<?php echo site_url('members/ajax_for_get_member_auto_id_by_samity_id') ?>", { samity_id: selected_samity },
			function(data)
			{
				$('#status').html("");
				$('#txt_code').val(data.members_code);
				$('#txt_id_sequence_no').val(data.id_sequence_no);
				$('#txt_code').attr('readonly',"readonly");
			}, "json");
			// samity group
			$.post("<?php echo site_url('samity_groups/ajax_for_get_samity_group_list_by_samity') ?>", { samity_id: selected_samity },
			function(data)
			{
				$('#status').html("");
				$('#cbo_group').empty();
				if( data.status == 'failure' )
				{
					//alert(data.message);
					$('#cbo_group').append('<option value = "">--Select--</option>');
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.samity_group_id.length; i++)
					{
						$('#cbo_group').append('<option value = \"' + data.samity_group_id[i] + '\">' + data.samity_group_name[i] + '</option>');
					}
				}
			}, "json");
		});
		// group wise subgroup
		$("#cbo_group").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");

			var selected_group = $("#cbo_group").val();

			$.post("<?php echo site_url('samity_subgroups/ajax_for_get_samity_sub_group_list_by_samity_group') ?>", { samity_group_id: selected_group },
			function(data)
			{
				$('#status').html("");
				$('#cbo_sub_group').empty();
				if( data.status == 'failure' )
				{
					//alert(data.message);
					$('#cbo_sub_group').append('<option value = "">--Select--</option>');
				}
				else
				{
					//alert(data.status);
					for(var i = 0; i < data.samity_sub_group_id.length; i++)
					{
						$('#cbo_sub_group').append('<option value = \"' + data.samity_sub_group_id[i] + '\">' + data.samity_sub_group_name[i] + '</option>');
					}
				}
			}, "json");
		});	
		//marital_status
		$("#txt_marital_status").change(function()
		{
			if($("#txt_gender").val() == 'Female' && $("#txt_marital_status").val() == 'Married') {
				$("#cbo_fathers_spouse_relationship").val('Spouse');
			} else {
				$("#cbo_fathers_spouse_relationship").val('Father');
			}
		});
		//end marital_status
	});	
</script>
<?php 
	//Samity list	
	$samity_options = array(''=>"--Select--");
	foreach($samities as $samity_row)
	{					
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	//Educational Qualification list	
	$educational_qualification_options = array(''=>"--Select--");
	foreach($educational_qualification as $educational_qualification_row)
	{					
		$educational_qualification_options[$educational_qualification_row->id]=$educational_qualification_row->name;
	}

	//Group list
	$group_options = array(''=>"--Select--");
	foreach($groups as $group_row)
	{					
		$group_options[$group_row->id]=$group_row->name;
	}
	//Sub Group list
	$group_sub_options = array(''=>"--Select--");
	foreach($sub_groups as $sub_group_row)
	{					
		$group_sub_options[$sub_group_row->id]=$sub_group_row->name;
	}
	//Member type list
	$i=0;
	foreach($member_types as $type_row)
	{					
		$i++;
		$type_options[$i]=$type_row;
	}
	//Gender list
	$gender_options = $genders;
	//Religious list
	$religious_options = $religious;
	?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('member_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open_multipart("members/$action",'',$hidden_input);
    echo form_hidden('txt_id_sequence_no',isset($row->id_sequence_no)?$row->id_sequence_no:"","'id'='txt_id_sequence_no'");
?>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
<fieldset class="loans_form">
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('members')."'"));?>
				</div>
			</td>
		</tr>
    </table>
	<table class="uiInfoTable" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr><th colspan="4">Member</th></tr>
			<tr>
				<td><label for="txt_name">Member Name:<em>*</em></label></td>
				<td><label for="cbo_samity">Samity Name:<em>*</em></label></td>
				<td><label for="cbo_group">Group:<em></em></label></td>
				<td><label for="cbo_sub_group">Sub Group:<em></em></label></td>
			</tr>
			<tr>
				<td>	
					<?php echo form_input(array('name' => 'txt_name','id' => 'txt_name','maxlength'=> '100','class'=>'input_textbox'),set_value('txt_name',isset($row->name)?$row->name:""));?>
					<?php echo form_error('txt_name'); ?>
				</td>				
				<td>	
					<?php 	echo form_dropdown('cbo_samity',$samity_options,set_value('cbo_samity',isset($row->samity_id)?$row->samity_id:""),'id="cbo_samity"');?>
					<?php echo form_error('cbo_samity'); ?>
				</td>
				<td>
					<?php 	echo form_dropdown('cbo_group',$group_options,set_value('cbo_group',isset($row->group_id)?$row->group_id:""),'id="cbo_group"');?>
					<?php echo form_error('cbo_group'); ?>
				</td>
				<td>
					<?php 	echo form_dropdown('cbo_sub_group',$group_sub_options,set_value('cbo_sub_group',isset($row->sub_group_id)?$row->sub_group_id:""),'id="cbo_sub_group"');?>
					<?php echo form_error('cbo_sub_group'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="txt_code">Member Code:<em>*</em></label></td>
				<td><label for="txt_registration_no">Admission No:<em>*</em></label></td>
				<td><label for="txt_registration_date">Admission Date:<em>*</em></label></td>
				<td><label for="txt_form_application_no">Form Application No:<em>*</em></label></td>
			</tr>
			<tr>
				<td>
					<?php 
					$readonly = ($is_members_code_auto_id_need)?"'readonly'='readonly'":"";
					echo form_input(array('name' => 'txt_code','id' => 'txt_code','maxlength'=> '50','class'=>'input_textbox'),set_value('txt_code',isset($row->code)?$row->code:$members_code),$readonly);?><?php echo form_error('txt_code'); ?>
				</td>	
				<td>
					<?php echo form_input(array('name'=>'txt_registration_no','id'=>'txt_registration_no','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_registration_no',isset($row->registration_no)?$row->registration_no:""));?>
					<?php echo form_error('txt_registration_no'); ?>
				</td>
				<td>
					<?php 
						$registration_date_attr = array('name'=>'txt_registration_date','id'=>'txt_registration_date','maxlength'=> '10','class'=>'input_textbox');
						echo form_input($registration_date_attr,set_value('txt_registration_date',isset($row->registration_date)?$row->registration_date:""));?><?php echo form_error('txt_registration_date'); 
					?>
				</td>
				<td>
					<?php echo form_input(array('name'=>'txt_form_application_no','id'=>'txt_form_application_no','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_form_application_no',isset($row->form_application_no)?$row->form_application_no:""));?>
					<?php echo form_error('txt_form_application_no'); ?>				
				</td>			
			</tr>
			<tr>
				<td><label for="txt_date_of_birth">Date of Birth:<em>*</em></label></td>
				<td><label for="txt_gender">Gender:<em>*</em></label></td>
				<td><label for="txt_marital_status">Maritial Status:<em>*</em></label></td>
				<td><label for="txt_last_achieved_degree">Education Level:<em>*</em></label></td>
			</tr>
			<tr>
				<td>	
					<?php
						$date_of_birth_attr = array('name'=>'txt_date_of_birth','id'=>'txt_date_of_birth','maxlength'=> '10','class'=>'input_textbox');
						echo form_input($date_of_birth_attr,set_value('txt_date_of_birth',isset($row->date_of_birth)?$row->date_of_birth:""));?><?php echo form_error('txt_date_of_birth'); 
					?>
				</td>
				<td><?php
					$gender_attr = array('name'=>'txt_gender','id'=>'txt_gender','readonly'=>'readonly','maxlength'=>'100','class'=>'input_textbox');
					echo form_input($gender_attr,set_value('txt_gender',isset($row->gender)?(($row->gender == 'F')?"Female":"Male"):""));?><?php echo form_error('txt_gender'); ?>
				</td>
				<td>
					<?php echo form_dropdown('txt_marital_status',$marital_status_list,set_value('txt_marital_status',isset($row->marital_status)?$row->marital_status:""),'id="txt_marital_status"');?>
					<?php echo form_error('txt_marital_status'); ?>
				</td>
				<td>
					<?php echo form_dropdown('txt_last_achieved_degree',$educational_qualification_options,set_value('txt_last_achieved_degree',isset($row->last_achieved_degree)?$row->last_achieved_degree:""),'id="txt_last_achieved_degree"');?>
					<?php echo form_error('txt_last_achieved_degree');?>
				</td>				
			</tr>
			<tr>
				<td><label for="txt_fathers_spouse_name">Spouse/Father's Name:<em>*</em></label></td>
				<td><label for="cbo_fathers_spouse_relationship">Relationship:<em>*</em></label></td>
				<td><label for="txt_national_id">National ID:<em></em></label></td>
				<td><label for="cbo_primary_product">Primary Product:<em>*</em></label></td>
			</tr>
			<tr>
				<td>
					<?php echo form_input(array('name' => 'txt_fathers_spouse_name','id' => 'txt_fathers_spouse_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_fathers_spouse_name',isset($row->fathers_spouse_name)?$row->fathers_spouse_name:""));?>
					<?php echo form_error('txt_fathers_spouse_name'); ?>
				</td>
				<td>	
					<?php echo form_dropdown('cbo_fathers_spouse_relationship',$fathers_spouse_relationships,set_value('cbo_fathers_spouse_relationship',isset($row->fathers_spouse_relationship)?$row->fathers_spouse_relationship:""),'id="cbo_fathers_spouse_relationship"');?>
					<?php echo form_error('cbo_fathers_spouse_relationship'); ?>
				</td>
				<td>
					<?php echo form_input(array('name' => 'txt_national_id','id' => 'txt_national_id','maxlength'=> '20','class'=>'input_textbox'),set_value('txt_national_id',isset($row->national_id)?$row->national_id:""));?>
					<?php echo form_error('txt_national_id');?>
				</td>				
				<td>
					<?php echo form_dropdown('cbo_primary_product',$loan_products,set_value('cbo_primary_product',isset($row->primary_product_id)?$row->primary_product_id:""),'id="cbo_primary_product"');?>
					<?php echo form_error('cbo_primary_product'); ?>
				</td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>
		
		<tbody class="aaa">
			<tr><th colspan="4">Contact Details</th></tr>
			<tr>
				<td><label><em></em></label></td>
				<td><label for="txt_present_village_ward">Village/Ward<em>*</em></label></td>
				<td><label for="txt_present_post_office_area">Post Office + Area<em></em></label></td>
				<td><label for="txt_present_contact_no">Contact No.<em></em></label></td>
			</tr>
			<tr>
				<td align="center"><strong>Present</strong></td>
				<td>
					<input type="hidden" name="txt_present_village_ward" id="txt_present_village_ward" value="<?php echo isset($row->present_village_ward)?$row->present_village_ward:'' ?>" />		
					<input type="text" id="present_village_ward_name" name="present_village_ward_name" value="<?php echo isset($row->present_village_ward_name)?$row->present_village_ward_name:'' ?>" style="padding: 0 0 0 20px;width:160px;" maxlength='255' class='input_textbox' />
					<?php echo form_error('txt_present_village_ward'); ?>
					<script type="text/javascript">
					$(document).ready(function() {
							$("#present_village_ward_name").autocomplete('<?php echo site_url("po_working_areas/ajax_get_working_area_list_auto/")?>', {
								minChars: 0,
								width: 179,
								matchContains: "word",
								highlightItem: true,
								formatItem: function(row, i, max, term) {
									var tmp;
									tmp=row[0].split(",");
									return "<strong>"+tmp[1]+"</strong>" + "<br><span style='font-size: 80%;'>Village: " + tmp[2] + "<br>Thana: " + tmp[3] + "<br>District: " + tmp[4] + "</span>";
								},

								formatResult: function(row) {
									var tmp;
									tmp=row[0].split(",");
									return tmp[1];
								}
							}).result(function(e, item) {
								//myCallback();
								var tmp;
								tmp=item[0].split(",");
								//$("#district_details").html("<p>Selected District => <b>"+tmp[1]+"</b>, ID: "+tmp[2]+" </p>");
								$("#txt_present_village_ward").val(tmp[0]);
								$("#txt_present_village_ward_detail_info").html( tmp[2] +', ' + tmp[3] + ', ' + tmp[4]);
							});
					});
					</script>
					<p style="margin:0;padding:0;font-size:10px;font-family:arial;color:#4a4a4a;"><i id="txt_present_village_ward_detail_info"><?php echo isset($row->present_village_ward_detail_info)?$row->present_village_ward_detail_info:'' ?></i></p>
				</td>
				<td>
					<?php echo form_input(array('name' => 'txt_present_post_office_area','id' => 'txt_present_post_office_area','maxlength'=> '300'),set_value('txt_present_post_office_area',isset($row->present_post_office_area)?$row->present_post_office_area:""));?><?php echo form_error('txt_present_post_office_area'); ?>
				</td>
				<td>
					<?php echo form_input(array('name' => 'txt_present_contact_no','id' => 'txt_present_contact_no','maxlength'=> '200'),set_value('txt_present_contact_no',isset($row->present_contact_no)?$row->present_contact_no:""));?><?php echo form_error('txt_present_contact_no'); ?>
				</td>
			</tr>
			<tr class="spacer"><td colspan="4"><hr style="width:800px;"></td></tr>
            <tr class="spacer">
                <td><?php echo "<b>Same as present address</b>";?></td>
                <td colspan="4">
                    <?php
                    $data = array(
                        'name'        => 'cb_address',
                        'id'          => 'cb_address',
                        'style'       => 'margin:10px',
                        );
                    echo form_checkbox($data);
                    ?>
                    <script type="text/javascript">
                        /*Start of copying present address to perment address*/
                        $(document).ready(function() {
                            $("#cb_address").click(function () {
                            if ($('#cb_address:checked').val() !== undefined) {
                                $('#permanent_village_ward_name').val($('#present_village_ward_name').val());
                                $("#txt_permanent_village_ward").val($("#txt_present_village_ward").val());
                                $("#txt_permanent_village_ward_detail_info").val($("#txt_present_village_ward_detail_info").val());
                                $("#txt_permanent_post_office_area").val($("#txt_present_post_office_area").val());
                                $("#txt_permanent_contact_no").val($("#txt_present_contact_no").val());
                            } else {
                                $('#permanent_village_ward_name').val(null);
                                $("#txt_permanent_village_ward").val(null);
                                $("#txt_permanent_village_ward_detail_info").val(null);
                                $("#txt_permanent_post_office_area").val(null);
                                $("#txt_permanent_contact_no").val(null);
                            }
                            });
                        });
                        /*End of copying present address to perment address*/
                    </script>
             </td></tr>
			<tr>
				<td align="center"><strong>Permanent</strong></td>
				<td>
					<input type="hidden" name="txt_permanent_village_ward" id="txt_permanent_village_ward" value="<?php echo isset($row->permanent_village_ward)?$row->permanent_village_ward:'' ?>" />		
					<input type="text" id="permanent_village_ward_name" name="permanent_village_ward_name" value="<?php echo isset($row->permanent_village_ward_name)?$row->permanent_village_ward_name:'' ?>" style="padding: 0 0 0 20px;width:160px;" maxlength='100' class='input_textbox' />
					<?php echo form_error('txt_permanent_village_ward'); ?>
					<script type="text/javascript">
					$(document).ready(function() {
							$("#permanent_village_ward_name").autocomplete('<?php echo site_url("po_working_areas/ajax_get_working_area_list_auto/")?>', {
								minChars: 0,
								width: 179,
								matchContains: "word",
								highlightItem: true,
								formatItem: function(row, i, max, term) {
									var tmp;
									tmp=row[0].split(",");
									return "<strong>"+tmp[1]+"</strong>" + "<br><span style='font-size: 80%;'>Village: " + tmp[2] + "<br>Thana: " + tmp[3] + "<br>District: " + tmp[4] + "</span>";
								},
								
								formatResult: function(row) {
									var tmp;
									tmp=row[0].split(",");
									return tmp[1];
								}
							}).result(function(e, item) {
								//myCallback();
								var tmp;
								tmp=item[0].split(",");
								$("#txt_permanent_village_ward").val(tmp[0]);
								$("#txt_permanent_village_ward_detail_info").html( tmp[2] +', ' + tmp[3] + ', ' + tmp[4]);
							});
					});
					</script>
					<p style="margin:0;padding:0;font-size:10px;font-family:arial;color:#4a4a4a;"><i id="txt_permanent_village_ward_detail_info"><?php echo isset($row->permanent_village_ward_detail_info)?$row->permanent_village_ward_detail_info:'' ?></i></p>
				</td>
				<td>
					<?php echo form_input(array('name' => 'txt_permanent_post_office_area','id' => 'txt_permanent_post_office_area','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_permanent_post_office_area',isset($row->permanent_post_office_area)?$row->permanent_post_office_area:""));?><?php echo form_error('txt_permanent_post_office_area'); ?>                    
				</td>
				<td>
					<?php echo form_input(array('name' => 'txt_permanent_contact_no','id' => 'txt_permanent_contact_no','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_permanent_contact_no',isset($row->permanent_contact_no)?$row->permanent_contact_no:""));?><?php echo form_error('txt_permanent_contact_no'); ?>
				</td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>		

		<tbody>
			<tr><th colspan="4">Nominee Details</th></tr>
			<tr>
				<td><label for="txt_nominee_name">Nominee Name<em>*</em></label></td>
				<td><label for="txt_nominee_relation">Relation<em>*</em></label></td>
				<td><label for="txt_nominee_address">Address<em>*</em></label></td>
				<td><label>&nbsp;<em></em></label></td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo form_input(array('name' => 'txt_nominee_name','id' => 'txt_nominee_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_nominee_name',isset($row->nominee_name)?$row->nominee_name:""));?>
					<?php echo form_error('txt_nominee_name');?>
				</td>
				<td valign="top">
					<?php echo form_input(array('name' => 'txt_nominee_relation','id' => 'txt_nominee_relation','maxlength'=>'50','class'=>'input_textbox'),set_value('txt_nominee_relation',isset($row->nominee_relation)?$row->nominee_relation:""));?>
					<?php echo form_error('txt_nominee_relation');?>
				</td>
				<td colspan="2">
					<?php echo form_textarea(array('name' => 'txt_nominee_address','id' => 'txt_nominee_address','rows'=> '1','cols'=>'8','style'=>'width:410px;height:50px;'),set_value('txt_nominee_address',isset($row->nominee_address)?$row->nominee_address:""));?>
					<?php echo form_error('txt_nominee_address');?>
				</td>
			</tr>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>

		<tbody>
			<tr><th colspan="4">Other Information</th></tr>
			<tr>
				<td><label for="cbo_member_type">Member Type<em></em></label></td>
				<td><label for="txt_no_of_family_member">No of Family Member<em></em></label></td>
				<td><label for="txt_yearly_income">Yearly Income<em></em></label></td>
				<td><label>Profession<em></em></label></td>
			</tr>
			<tr>
				<td>
					<?php echo form_dropdown('cbo_member_type', $type_options,set_value('cbo_member_type',isset($row->member_type)?$row->member_type:""),'id="cbo_member_type"');?>
					<?php echo form_error('cbo_member_type'); ?>
				</td>
				<td>
					<?php $no_of_family_member_attr = array('name'=>'txt_no_of_family_member','id'=>'txt_no_of_family_member','maxlength'=>'2','class'=>'input_textbox');
					echo form_input($no_of_family_member_attr,set_value('txt_no_of_family_member',isset($row->no_of_family_member)?$row->no_of_family_member:""));?>
					<?php echo form_error('txt_no_of_family_member');?>
				</td>
				<td>
					<?php 
					$yearly_income_attr = array('name'=>'txt_yearly_income','id'=>'txt_yearly_income','maxlength'=> '13','class'=>'input_textbox');
					echo form_input($yearly_income_attr,set_value('txt_yearly_income',isset($row->yearly_income)?$row->yearly_income:""));?>
					<?php echo form_error('txt_yearly_income');?>
				</td>
				<td>
					<?php echo form_dropdown('cbo_profession', $activities,set_value('cbo_profession',isset($row->profession)?$row->profession:""),'id="cbo_profession"');?>
					<?php echo form_error('cbo_profession'); ?>
				</td>
			</tr>			
			<tr>
				<td><label for="txt_mothers_name">Mother's Name<em></em></label></td>
				<td><label for="cbo_religious">Religion:<em></em></label></td>
				<td><label for="txt_mobile_no">Mobile No.<em></em></label></td>
				<td><label>Picture<em></em></label></td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo form_input(array('name' => 'txt_mothers_name','id' => 'txt_mothers_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_mothers_name',isset($row->mothers_name)?$row->mothers_name:""));?>
					<?php echo form_error('txt_mothers_name'); ?>
				</td>
				<td valign="top">
					<?php echo form_dropdown('cbo_religious', $religious_options,set_value('cbo_religious',isset($row->religion)?$row->religion:""),'id="cbo_religious" readonly="readonly"');?><?php echo form_error('cbo_religious'); ?>
				</td>
				<td valign="top">
					<?php echo form_input(array('name' => 'txt_mobile_no','id' => 'txt_mobile_no','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_mobile_no',isset($row->txt_mobile_no)?$row->txt_mobile_no:""));?>
					<?php echo form_error('txt_mobile_no'); ?>	
				</td>
				<td valign="top">
					<?php echo form_hidden('txt_member_picture_edit',isset($row->member_picture)?$row->member_picture:""); ?>
					<input type="file" name="txt_member_picture" size="20" />
					<span class="explain" id="explain">File must be .jpg, .gif or .png</span>
					<span style="float:right;"><?php if (isset($row->member_picture)) echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->member_picture,'border'=>'0','alt'=>'','width'=>'25','height'=>'25'))?></span>
					<?php echo form_error('txt_member_picture'); ?>
				</td>
			</tr>
		</tbody>

		<tbody>
			<tr class="spacer"><td colspan="4"><hr></td></tr>
			<tr>
				<td colspan="4" align="left" class="formBottomBar">
                    <?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive','style'=>'width:auto;padding: 6px 9px 6px 26px;border-color: #EEEEEE #DEDEDE #DEDEDE #EEEEEE;border-style: solid;border-width: 1px;'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('members')."'"));?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	<?php if (form_error('txt_name') != '') { ?>
		$("#txt_name").focus();
	<?php } elseif (form_error('cbo_samity') != '') { ?>
		$("#cbo_samity").focus();
	<?php } elseif (form_error('cbo_group') != '') { ?>
		$("#cbo_group").focus();
	<?php } elseif (form_error('cbo_sub_group') != '') { ?>
		$("#cbo_sub_group").focus();
	<?php } elseif (form_error('txt_code') != '') { ?>
		$("#txt_code").focus();
	<?php } elseif (form_error('txt_registration_no') != '') { ?>
		$("#txt_registration_no").focus();
	<?php } elseif (form_error('txt_registration_date') != '') { ?>
		$("#txt_registration_date").focus();
	<?php } elseif (form_error('txt_registration_no') != '') { ?>
		$("#txt_registration_no").focus();
	<?php } elseif (form_error('txt_date_of_birth') != '') { ?>
		$("#txt_date_of_birth").focus();
	<?php } elseif (form_error('txt_gender') != '') { ?>
		$("#txt_gender").focus();
	<?php } elseif (form_error('txt_marital_status') != '') { ?>
		$("#txt_marital_status").focus();
	<?php } elseif (form_error('txt_present_village_ward') != '') { ?>
		$("#present_village_ward_name").focus();
	<?php } elseif (form_error('txt_present_post_office_area') != '') { ?>
		$("#txt_present_post_office_area").focus();
	<?php } elseif (form_error('txt_present_contact_no') != '') { ?>
		$("#txt_present_contact_no").focus();
	<?php } elseif (form_error('txt_permanent_village_ward') != '') { ?>
		$("#permanent_village_ward_name").focus();
	<?php } elseif (form_error('txt_permanent_post_office_area') != '') { ?>
		$("#txt_permanent_post_office_area").focus();
	<?php } elseif (form_error('txt_permanent_contact_no') != '') { ?>
		$("#txt_permanent_contact_no").focus();
	<?php } elseif (form_error('cbo_member_type') != '') { ?>
		$("#cbo_member_type").focus();
	<?php } elseif (form_error('txt_no_of_family_member') != '') { ?>
		$("#txt_no_of_family_member").focus();
	<?php } elseif (form_error('txt_yearly_income') != '') { ?>
		$("#txt_yearly_income").focus();
	<?php } elseif (form_error('cbo_profession') != '') { ?>
		$("#cbo_profession").focus();
	<?php } elseif (form_error('txt_mothers_name') != '') { ?>
		$("#txt_mothers_name").focus();
	<?php } elseif (form_error('cbo_religious') != '') { ?>
		$("#cbo_religious").focus();
	<?php } elseif (form_error('txt_mobile_no') != '') { ?>
		$("#txt_mobile_no").focus();
	<?php } elseif (form_error('txt_member_picture') != '') { ?>
		$("#txt_member_picture").focus();
	<?php } else { ?>
		$("#txt_name").focus();
	<?php } ?>
});
</script>
<script type="text/javascript">
	var cbo_branch = new LiveValidation('cbo_branch', { validMessage: " ", onlyOnBlur: true });
	cbo_branch.add( Validate.Presence );
	
	var cbo_samity = new LiveValidation('cbo_samity', { validMessage: " ", onlyOnBlur: true });
	cbo_samity.add( Validate.Presence );
	

	var txt_gender = new LiveValidation('txt_gender', { validMessage: " ", onlyOnBlur: true });
	txt_gender.add( Validate.Presence );
	txt_gender.add( Validate.Inclusion, { within: [ 'Male' , 'Female' ] } );
	
	var cbo_profession = new LiveValidation('cbo_profession', { validMessage: " ", onlyOnBlur: true });
	cbo_profession.add( Validate.Presence );
	cbo_profession.add( Validate.Inclusion, { within: [ 'Active' , 'Inactive', 'Transfered' ] } );
	
	var txt_name = new LiveValidation('txt_name', { validMessage: " ", onlyOnBlur: true });
	txt_name.add( Validate.Presence );
	txt_name.add( Validate.Length, { maximum: 200 } );
	
	var txt_registration_no = new LiveValidation('txt_registration_no', { validMessage: " ", onlyOnBlur: true });
	txt_registration_no.add( Validate.Presence );	
	txt_registration_no.add( Validate.Length, { maximum: 200 } );
	
	var txt_registration_date = new LiveValidation('txt_registration_date', { validMessage: " " });
	//txt_registration_date.add( Validate.Presence );
	txt_registration_date.add( Validate.Length, { maximum: 10 } );
	
	var txt_code = new LiveValidation('txt_code', { validMessage: " ", onlyOnBlur: true });
	txt_code.add( Validate.Length, { maximum: 50 } );
	
	//var txt_registration_no = new LiveValidation('txt_registration_no', { validMessage: " " });
	var txt_form_application_no = new LiveValidation('txt_form_application_no', { validMessage: " ", onlyOnBlur: true });
	txt_form_application_no.add( Validate.Length, { maximum: 50 } );
	
	var txt_fathers_name = new LiveValidation('txt_fathers_name', { validMessage: " ", onlyOnBlur: true });
	txt_fathers_name.add( Validate.Length, { maximum: 200 } );
	
	var txt_mothers_name = new LiveValidation('txt_mothers_name', { validMessage: " ", onlyOnBlur: true });
	txt_mothers_name.add( Validate.Length, { maximum: 200 } );
	
	var txt_spouse_name = new LiveValidation('txt_spouse_name', { validMessage: " ", onlyOnBlur: true });
	txt_spouse_name.add( Validate.Length, { maximum: 200 } );
	
	var txt_date_of_birth = new LiveValidation('txt_date_of_birth', { validMessage: " ", onlyOnBlur: true });
	txt_date_of_birth.add( Validate.Length, { maximum: 10 } );
	
	var txt_present_address = new LiveValidation('txt_present_address', { validMessage: " ", onlyOnBlur: true });
	txt_present_address.add( Validate.Length, { maximum: 500 } );
	
	var txt_permanent_address = new LiveValidation('txt_permanent_address', { validMessage: " ", onlyOnBlur: true });
	txt_permanent_address.add( Validate.Length, { maximum: 500 } );
	
	var txt_contact_number = new LiveValidation('txt_contact_number', { validMessage: " ", onlyOnBlur: true });
	txt_contact_number.add( Validate.Length, { maximum: 200 } );
	
	var txt_last_achieved_degree = new LiveValidation('txt_last_achieved_degree', { validMessage: " ", onlyOnBlur: true });
	txt_last_achieved_degree.add( Validate.Length, { maximum: 100 } );
	
	var txt_national_id = new LiveValidation('txt_national_id', { validMessage: " ", onlyOnBlur: true });
	txt_national_id.add( Validate.Length, { maximum: 20 } );
	
	var txt_nominee_name = new LiveValidation('txt_nominee_name', { validMessage: " ", onlyOnBlur: true });
	txt_nominee_name.add( Validate.Length, { maximum: 200 } );
	
	var txt_nominee_relation = new LiveValidation('txt_nominee_relation', { validMessage: " ", onlyOnBlur: true });
	txt_nominee_relation.add( Validate.Length, { maximum: 50 } );
	
	var txt_guarantor_name_1 = new LiveValidation('txt_guarantor_name_1', { validMessage: " ", onlyOnBlur: true });
	txt_guarantor_name_1.add( Validate.Length, { maximum: 200 } );
	
	var txt_guarantor_address_1 = new LiveValidation('txt_guarantor_address_1', { validMessage: " ", onlyOnBlur: true });
	txt_guarantor_address_1.add( Validate.Length, { maximum: 500 } );
	
	var txt_guarantor_relationship_1 = new LiveValidation('txt_guarantor_relationship_1', { validMessage: " ", onlyOnBlur: true });
	txt_guarantor_relationship_1.add( Validate.Length, { maximum: 50 } );
	
	var txt_guarantor_name_2 = new LiveValidation('txt_guarantor_name_2', { validMessage: " ", onlyOnBlur: true });
	txt_guarantor_name_2.add( Validate.Length, { maximum: 200 } );
	
	var txt_guarantor_address_2 = new LiveValidation('txt_guarantor_address_2', { validMessage: " ", onlyOnBlur: true });
	txt_guarantor_address_2.add( Validate.Length, { maximum: 500 } );
	
	var txt_guarantor_relationship_2 = new LiveValidation('txt_guarantor_relationship_2', { validMessage: " ", onlyOnBlur: true });
	txt_guarantor_relationship_2.add( Validate.Length, { maximum: 50 } );
		
	var txt_no_of_family_member = new LiveValidation('txt_no_of_family_member', { validMessage: " ", onlyOnBlur: true });
	txt_no_of_family_member.add( Validate.Numericality, { minimum: 0, maximum: 50, onlyInteger: true } );
	var txt_yearly_income = new LiveValidation('txt_yearly_income', { validMessage: " ", onlyOnBlur: true });
	txt_yearly_income.add( Validate.Numericality, { minimum: 0, maximum: 999999 } );
</script>	

