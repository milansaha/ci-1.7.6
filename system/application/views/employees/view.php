<fieldset>
<table width="100%" border="0" cellspacing="0px" cellpadding="0px" style="background:url(<?php echo base_url()?>/media/images/gray_gradiant.gif) repeat top left;border:solid 1px #CFCFCF;">
		<tr>
			<td rowspan="2" width="150px" align="center" style="border:2px solid #595959;">
				<?php 
					if(!empty($row->employee_picture))
					{
						echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->employee_picture,'border'=>'0','alt'=>$row->name,'width'=>'150'));
					}else{
						echo img(array('src'=>base_url().'media/images/members_pic/male_pic.jpg','border'=>'0','alt'=>$row->name,'width'=>'150'));
					}
					?>
			</td>
			<td width="700px" valign="top" align="left">
				<h2><?php if(!empty($row->name)){echo $row->name;}?></h2>
				<br/>
				<h4 style="padding:0px 0px 0px 10px;margin:0;color:#6D6D6D;">Branch:&nbsp;<?php if(!empty($row->branch_name)){echo $row->branch_name;} if(!empty($row->branch_code)){echo " - " . $row->branch_code;}?></h4>
			</td>
			<td style="padding:0;margin:0;" align="right" valign="top">
				<div style="float:right;width:145px;border:solid 0px red;">
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Back to list page','class'=>'back_button','onclick'=>"window.location.href='".site_url('employees')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
				<p style="padding:0px 0px 5px 10px;color:#828282;"><i>Code:&nbsp;<?php if(!empty($row->code)){echo $row->code;}?></i><br/>
				<b>Status:&nbsp;<?php if($row->status == 1){echo 'Active';}elseif($row->status==0){echo 'Inactive';}?></b><br/></p>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<br/>
	<table class="uiInfoTableConfig" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr>
				<th colspan="2">
					<img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;
					<?php echo $headline?>
				</th>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Name:</td>
				<td class="field-items"><?php if(!empty($row->name)){ echo $row->name;} ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Code:</td>
				<td class="field-items"><?php if(!empty($row->code)){echo $row->code;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Branch:</td>
				<td class="field-items"><?php if(!empty($row->branch_name)){echo $row->branch_name;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Designation:</td>
				<td class="field-items"><?php if(!empty($row->emp_designation)){echo $row->emp_designation;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Father's Name:</td>
				<td class="field-items"><?php if(!empty($row->fathers_name)){echo $row->fathers_name;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Mother's Name:</td>
				<td class="field-items"><?php if(!empty($row->mothers_name)){echo $row->mothers_name;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Spouse Name:</td>
				<td class="field-items"><?php if(!empty($row->spouse_name)){echo $row->spouse_name;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Permanent Address:</td>
				<td class="field-items"><?php if(!empty($row->permanent_address)){echo $row->permanent_address;}?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Present Address:</td>
				<td class="field-items"><?php if(!empty($row->present_address)){echo $row->present_address;}?></td>
			</tr> 
			
			<tr>
				<td width="40%" align="left" class="field-label">Last Achieved Degree:</td>
				<td class="field-items"><?php if(!empty($row->edu_qualification)){echo $row->edu_qualification;}?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Date of Birth:</td>
				<td class="field-items"><?php if(!empty($row->date_of_birth)){echo date("d/m/Y",strtotime($row->date_of_birth));}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Date of Joining:</td>
				<td class="field-items"><?php echo date("d/m/Y",strtotime($row->date_of_joining));?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Can manage loan?:</td>
				<td class="field-items"><?php if($row->is_field_officer==0){echo 'No';}elseif($row->is_field_officer==1){echo 'Yes';}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Security Money:</td>
				<td class="field-items"><?php if(!empty($row->secuirity_money)){echo number_format($row->secuirity_money,2,'.',',');}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Starting Salary:</td>
				<td class="field-items"><?php if(!empty($row->starting_salary)){echo number_format($row->starting_salary,2,'.',',');}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Current Salary:</td>
				<td class="field-items"><?php if(!empty($row->current_salary)){echo number_format($row->current_salary,2,'.',',');}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">National ID:</td>
				<td class="field-items"><?php if(!empty($row->national_id)){echo $row->national_id;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Reference Info 1:</td>
				<td class="field-items"><?php if(!empty($row->refence_info_1)){echo $row->refence_info_1;}?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Reference Info 2:</td>
				<td class="field-items"><?php if(!empty($row->refence_info_2)){echo $row->refence_info_2;}?></td>
			</tr>
		</tbody>
	</table>
</fieldset>
