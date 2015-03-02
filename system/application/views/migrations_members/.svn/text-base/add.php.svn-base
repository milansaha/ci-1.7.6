<style type="text/css">
.migration_members { width:100%; }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(function(){
		//alert($("#educational_qualification").val(educational_qualification));
		for($j=0;$j<50;$j++){
			$("#txt_registration_date"+$j).datepicker({dateFormat:'yy-mm-dd'});
			$("#txt_date_of_birth"+$j).datepicker({dateFormat:'yy-mm-dd'});
			$("#txt_approved_date"+$j).datepicker({dateFormat:'yy-mm-dd'});
		}
	});
</script>
<?php
	//Working area list	
	$working_areas_options = array(''=>"--Select--");
	foreach($working_areas as $working_area_row)
	{					
		$working_areas_options[$working_area_row->id]=$working_area_row->name;
	}
	//Educational Qualification list	
	$educational_qualification_options = array(''=>"--Select--");
	foreach($educational_qualification as $educational_qualification_row)
	{					
		$educational_qualification_options[$educational_qualification_row->id]=$educational_qualification_row->name;
	}
	//Member type list
	$type_options = array(''=>"--Select--");
	$i=0;
	foreach($member_types as $type_row)
	{					
		$i++;
		$type_options[$i]=$type_row;
	}
	//Gender list
	$group_sub_options = array(''=>"--Select--");
	foreach($genders as $gender_row)				
	{							
		$gender_options[$gender_row]=$gender_row;
	}
	//Primary - Product Name drop down list	
	$options_product_name = array(''=>"--Select--");
	foreach($product_infos as $product_info)
	{					
		$options_product_name[$product_info->product_id]=$product_info->product_mnemonic;
	}
	//Loan Products - Product Name drop down list
	$options_loan_product_name = array();
	foreach($loan_product_infos as $loan_product_info)
	{					
		$options_loan_product_name[$loan_product_info->product_id]=$loan_product_info->product_mnemonic;
	}
?>
<h1>Migrations Members</h1>
<?php echo form_open_multipart('migrations_members/save'); ?>
<p> Samity Name:<?php echo $get_samity_name[0]->name.' ( '.$get_samity_name[0]->code.' )'; 
				echo form_hidden(array('name' => 'samity_id_hidden','id' => 'samity_id_hidden','value'=>$get_samity_name[0]->id));
				echo form_hidden(array('name' => 'samity_name_hidden','id' => 'samity_name_hidden','value'=>$get_samity_name[0]->name));
				?><br/>
	Member Sex: <?php if($get_migration_sex == 'M'){echo 'Male';}elseif($get_migration_sex == 'Female'){echo 'Female';}
				echo form_hidden(array('name' => 'migration_sex_hidden','id' => 'migration_sex_hidden','value'=>$get_migration_sex));
				?><br/>
	Approved By: <?php echo $get_approved_name; echo form_hidden(array('name' => 'approved_name_hidden','id' => 'approved_name_hidden','value'=>$get_approved_name));?><br/>
	Approved Date: <?php echo $get_approved_date; echo form_hidden(array('name' => 'approved_date_hidden','id' => 'approved_date_hidden','value'=>$get_approved_date));?><br/>
</p>
<table width="100%" border="0" cellspacing="10px" cellpadding="3px" class="migration_members">
<?php for($i=1;$i<=$get_member_numbers;$i++) { ?>
  <tr>
    <td bgcolor="#ababab"><strong>Member#<?php echo $i; ?></strong></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellspacing="0px" cellpadding="0px">
		  <tr>
			<td width="130px">Name</td>
			<td width="130px">Cum. Admission Reg No.</td>
			<td width="130px">Admission Date</td>
			<td width="130px">Customer Member ID </td>
			<td width="130px">Date of Birth</td>
			<td width="130px">Working Area </td>
		  </tr>
		  <tr>
			<td><?php echo form_input(array('name' => 'member_name['.$i.']','id' => 'member_name'.$i,'maxlength'=> '50','style'=>'width:100%;','class'=>"LV_valid_field"),set_value('member_name'));?></td>
			<td><?php echo form_input(array('name' => 'cum_admission_no['.$i.']','id' => 'cum_admission_no'.$i,'maxlength'=> '50', 'style'=>'width:100%;','class'=>"LV_valid_field"),set_value('cum_admission_no'));?></td>
			<td><?php $registration_date_attr = array('name'=>'txt_registration_date['.$i.']','id'=>'txt_registration_date'.$i,'maxlength'=> '10', 'style'=>'width:100%;','class'=>"LV_valid_field");
						echo form_input($registration_date_attr,set_value('txt_registration_date'));?><?php echo form_error('txt_registration_date'); ?></td>
			<td><?php echo form_input(array('name' => 'cus_member_id['.$i.']','id' => 'cus_member_id','maxlength'=> '50', 'style'=>'width:100%;','class'=>"LV_valid_field"),set_value('cus_member_id'));?></td>
			<td><?php echo form_input(array('name' => 'txt_date_of_birth['.$i.']','id' => 'txt_date_of_birth'.$i,'maxlength'=> '50','style'=>'width:100%;','class'=>"LV_valid_field"),set_value('txt_date_of_birth'));?></td>
			<td>
				<input type="hidden" name="cbo_working_area[<?php echo $i;?>]" id="cbo_working_area<?php echo $i;?>" value="" />		
				<input type="text" id="working_area<?php echo $i;?>" />
				<script type="text/javascript">
					$(document).ready(function() 
					{
						for($j=0;$j<50;$j++){
							$("#working_area"+$j).autocomplete('<?php echo site_url("po_working_areas/ajax_get_working_area_list_auto/")?>', {
								minChars: 0,
								width: 310,
								matchContains: "word",
								highlightItem: true,
								formatItem: function(row, i, max, term) {
									var tmp;
									tmp=row[0].split(",");
									return "<strong>"+tmp[1]+"</strong>" + "<br/><span style='font-size: 80%;'>Village: " + tmp[2] + "<br/>Thana: " + tmp[3] + "<br/>District: " + tmp[4] + "</span>";
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
								$("#cbo_working_area["+$j+"]").val(tmp[0]);
							});
						}
					});
				</script>
			</td>
		  </tr>
		  <tr>
		  	<td>Post Office</td>
			<td>Area</td>
			<td>Father/Spouse Name</td>
			<td>Educational Qualification</td>
			<td>National ID</td>			
			<td>Nominee Name</td>
		  </tr>
		  <tr>
			<td><?php echo form_input(array('name' => 'post_office['.$i.']','id' => 'post_office','maxlength'=> '200','style'=>'width:100%;'),set_value('post_office'));?><?php echo form_error('post_office'); ?></td>
			<td><?php echo form_input(array('name' => 'area['.$i.']','id' => 'area','maxlength'=> '50','style'=>'width:100%;'),set_value('area'));?></td>
			<td><?php echo form_input(array('name' => 'father_spouse_name['.$i.']','id' => 'father_spouse_name','maxlength'=> '200','style'=>'width:100%;','class'=>"LV_valid_field"),set_value('father_spouse_name'));?><?php echo form_error('father_spouse_name'); ?></td>
			<td><?php echo form_dropdown('educational_qualification['.$i.']',$educational_qualification_options,'','style="width:100%;"');?></td>
			<td><?php echo form_input(array('name' => 'national_id['.$i.']','id' => 'national_id','maxlength'=> '50','style'=>'width:100%;'),set_value('national_id'));?></td>
			<td><?php echo form_input(array('name' => 'nominee_name['.$i.']','id' => 'nominee_name','maxlength'=> '50','style'=>'width:100%;'),set_value('nominee_name'));?></td>
		  </tr>
		  <tr>
			<td>Nominee Relations</td>
			<td>Primary Product</td>			
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td><?php echo form_input(array('name' => 'nominee_relation['.$i.']','id' => 'nominee_relation','maxlength'=> '50','style'=>'width:100%;'),set_value('nominee_relation'));?></td>
			<td><?php echo form_dropdown('cbo_product['.$i.']',$options_product_name,'','style="width:100%;"');?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
		  </tr>
		  <tr>
			<td> Current Loans </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="6"><?php 
						$jj = 0;
						foreach($options_loan_product_name as $loan_product_info)
						{	
							print_r($loan_product_info);
							echo form_input(array('name' => 'loan_products['.$i.']['.$jj.']','id' => 'loan_products','style'=>'width:1em;','type'=>'checkbox','label'=>$loan_product_info,'div'=>false,'value'=>$loan_product_info),set_value($loan_product_info));
							echo '   ';
							$jj++;
						}
				?></td>
		  </tr>
		</table>
	</td>
  </tr>
<?php } ?>
	<tr>
		<td><?php echo form_submit('submit','Submit');?></td>
	</tr>
</table>


