<?php 
	//echo '<pre>';print_r($row);
?>
<fieldset>
	<table width="100%" border="0" cellspacing="0px" cellpadding="0px" style="background:url(<?php echo base_url()?>/media/images/gray_gradiant.gif) repeat top left;border:solid 1px #CFCFCF;">
		<tr>
			<td rowspan="2" width="150px" align="center" style="border:2px solid #595959;">
				<?php 
					if(!empty($row->member_picture))
					{
						echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->member_picture,'border'=>'0','alt'=>$row->name?$row->name:'','width'=>'150'));
					}else{
						if($row->gender == 'M'){
							echo img(array('src'=>base_url().'media/images/members_pic/male_pic.jpg','border'=>'0','alt'=>$row->name?$row->name:'','width'=>'150'));
						}
						elseif($row->gender=='F'){
							echo img(array('src'=>base_url().'media/images/members_pic/female_pic.jpg','border'=>'0','alt'=>$row->name?$row->name:'','width'=>'150'));
						}
					}
					?>
			</td>
			<td width="700px" valign="top" align="left">
				<h2><?php echo $row->name?$row->name:''?></h2>
				<br/>
				<h4 style="padding:0px 0px 0px 10px;margin:0;color:#6D6D6D;"><?php echo $row->samity_name?$row->samity_name:''?></h4>
			</td>
			<td style="padding:0;margin:0;" align="right" valign="top">
				<div style="float:right;width:145px;border:solid 0px red;">
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Back to list page','class'=>'back_button','onclick'=>"window.location.href='".site_url('members')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
				<p style="padding:0px 0px 5px 10px;color:#828282;"><i>Code:&nbsp;<?php echo $row->code?$row->code:''?></i><br/>
				<b>Status:&nbsp;<?php echo $row->member_status?$row->member_status:''?></b><br/></p>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<br/>
	<table class="uiInfoTableConfig" width="650px" border="0" cellspacing="0px" cellpadding="0px">
	<tbody>
			<tr>
				<th colspan="2">
					<img src="<?php echo base_url();?>/media/images/member-info.png" width="20px" align="top" border="0" />&nbsp;&nbsp;<?php echo $headline;?>
				</th>
			</tr>
			<tr>
				<td align="left" class="field-label">Code:</td>
				<td class="field-items"><?php if(!empty($row->code)){echo $row->code;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Name:</td>
				<td class="field-items"><?php if(!empty($row->name)){echo $row->name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Branch Name:</td>
				<td class="field-items"><?php if(!empty($row->branch_name)){echo $row->branch_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Samity Name:</td>
				<td class="field-items"><?php if(!empty($row->samity_name)){echo $row->samity_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Group Name:</td>
				<td class="field-items"><?php if(!empty($row->samity_group_name)){echo $row->samity_group_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Sub Group Name:</td>
				<td class="field-items"><?php if(!empty($row->samity_subgroup_name)){echo $row->samity_subgroup_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Working Area:</td>
				<td class="field-items"><?php if(!empty($row->working_area_name)){echo $row->working_area_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Member Type:</td>
				<td class="field-items"><?php if(!empty($row->member_type)){echo $row->member_type;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Primary Product:</td>
				<td class="field-items"><?php if((!empty($row->product_name))&&(!empty($row->product_mnemonic))){echo $row->product_mnemonic.'-'.$row->product_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Member Status:</td>
				<td class="field-items"><?php if(!empty($row->member_status)){echo $row->member_status;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Registration No:</td>
				<td class="field-items"><?php if(!empty($row->registration_no)){echo $row->registration_no;}?></td>
			</tr>
			<!--<tr>
				<td align="left" class="field-label">Member Picture:</td>
				<td class="field-items"><?php echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->member_picture,'border'=>'0','alt'=>'View','width'=>'150'))?></td>
			</tr>-->
			<tr>
				<td align="left" class="field-label">Registration Date:</td>
				<td class="field-items"><?php if(!empty($row->registration_date)){echo date("d/m/Y",strtotime($row->registration_date));}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Form Application No:</td>
				<td class="field-items"><?php if(!empty($row->form_application_no)){echo $row->form_application_no;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Gender:</td>
				<td class="field-items"><?php if(!empty($row->gender)){if($row->gender == 'M'){echo 'Male';}elseif($row->gender=='F'){echo 'Female';}}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Father's/Spouse Name:</td>
				<td class="field-items"><?php if(!empty($row->fathers_spouse_name)){echo $row->fathers_spouse_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Mother's Name:</td>
				<td class="field-items"><?php if(!empty($row->mothers_name)){echo $row->mothers_name;}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Date of Birth:</td>
				<td class="field-items"><?php if(!empty($row->date_of_birth)){echo date("d/m/Y",strtotime($row->date_of_birth));}?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Present Address:</td>
				<td class="field-items">				
					<?php 
					
					echo $row->villagename?$row->villagename:''.',';
					echo $row->unionname?$row->unionname:''.',';
					echo $row->thananame?$row->thananame:''.',';
					echo $row->districtname?$row->districtname:''.'.';
					?>
				</td>
			</tr>
			<tr>
				<td align="left" class="field-label">Permanent Address:</td>
				<td class="field-items">				
					<?php 
					echo $row->villagename?$row->villagename:''.',';
					echo $row->villagename?$row->villagename:''.',';
					echo $row->thananame?$row->thananame:''.',';
					echo $row->districtname?$row->districtname:''.'.';
					?>
				</td>
			</tr>
			<tr>
				<td align="left" class="field-label">Present Contact Number:</td>
				<td class="field-items"><?php echo $row->present_contact_no?$row->present_contact_no:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Permanent Contact Number:</td>
				<td class="field-items"><?php echo $row->permanent_contact_no?$row->permanent_contact_no:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Achieved Degree:</td>
				<td class="field-items"><?php echo $row->educational_qualifications_name?$row->educational_qualifications_name:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">No of Family Member:</td>
				<td class="field-items"><?php echo $row->no_of_family_member?$row->no_of_family_member:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Yearly Income:</td>
				<td class="field-items"><?php echo $row->yearly_income?$row->yearly_income:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">National Id:</td>
				<td class="field-items"><?php echo $row->national_id?$row->national_id:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Remarks:</td>
				<td class="field-items"><?php echo $row->remarks?$row->remarks:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Date of death:</td>
				<td class="field-items"><?php echo $row->date_of_death?$row->date_of_death:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Reason of death:</td>
				<td class="field-items"><?php echo $row->reason_of_death?$row->reason_of_death:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Cancel Date:</td>
				<td class="field-items"><?php echo $row->cancel_date?$row->cancel_date:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Cancel Reason:</td>
				<td class="field-items"><?php echo $row->cancel_reason?$row->cancel_reason:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Cancel Registration No:</td>
				<td class="field-items"><?php echo $row->cancel_registration_no?$row->cancel_registration_no:''?></td>
			</tr>
			<tr>
				<td align="left" colspan="2" style="background-color:#E8E8E8;border-bottom:1px solid #C5C5C5;font-weight:bold;">Nominee Detials</td>
			</tr>
			<tr>
				<td align="left" class="field-label">Nominee Name:</td>
				<td class="field-items"><?php echo $row->nominee_name?$row->nominee_name:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Nominee Relation:</td>
				<td class="field-items"><?php echo $row->nominee_relation?$row->nominee_relation:''?></td>
			</tr>
			<tr>
				<td align="left" class="field-label">Nominee Picture:</td>
				<td class="field-items"><?php echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->nominee_picture,'border'=>'0','alt'=>'View','width'=>'150'))?></td>
			</tr>
		</tbody>
	</table>
</fieldset>
