<fieldset>
<table class="uiInfoTableConfig" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr>
				<th>
					<img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;
					<?php echo $headline?>
				</th>
                <th style="padding:0;margin:0;" align="right" valign="top">
                    <div style="float:right;width:145px;border:solid 0px red;">
                        <?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Back to list page','class'=>'back_button','onclick'=>"window.location.href='".site_url('samities')."'"));?>
                    </div>
                </th>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Name:</td>
				<td class="field-items"><?php echo $row->name?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Code:</td>
				<td class="field-items"><?php echo $row->code?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Working Area:</td>
				<td class="field-items"><?php echo isset($row->working_area_id)?$row->working_area_name:''?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Product:</td>
				<td class="field-items"><?php echo isset($row->short_name)?$row->short_name:''?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Registration No:</td>
				<td class="field-items"><?php echo $row->registration_no;?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Field Officer:</td>
				<td class="field-items"><?php echo isset($row->employee_name)?$row->employee_name:''?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Samity Day:</td>
				<td class="field-items"><?php echo isset($row->samity_day_full)?$row->samity_day_full:'' ?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Samity Type:</td>
				<td class="field-items"><?php if(isset($row->samity_type)){ if($row->samity_type=='M'){ echo 'Male';} else { echo 'Female'; }}?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">SKT Amount:</td>
				<td class="field-items"><?php echo $row->skt_amount?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Opening Date:</td>
				<td class="field-items"><?php echo $row->opening_date;?></td>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Status:</td>
				<td class="field-items"><?php if(isset($row->status)){ if($row->status=='1'){ echo 'Active';} else { echo 'Inactive'; }}?></td>
			</tr>
		</tbody>
	</table>
</fieldset>
