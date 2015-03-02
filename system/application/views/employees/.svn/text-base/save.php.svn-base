<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	$("#joining_datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	$("#discontinue_datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
    $user=$this->session->userdata('system.user');
	//Combo data for Designation
	$designation_options = array(''=>"----Select----");
	foreach($employee_designation_infos as $employee_designation_info)
	{					
		$designation_options[$employee_designation_info->designation_id]=$employee_designation_info->designation_name;
	}
	//Combo data for Status
	$status_options = "";
	foreach($status_info as $key => $value)
	{					
		$status_options[$key]=$value;
	}	
	//Educational Qualification list
	$educational_qualification_options = array(''=>"----Select----");
	foreach($educational_qualification as $educational_qualification_row)
	{
		$educational_qualification_options[$educational_qualification_row->id]=$educational_qualification_row->name;
	}
    
    $branch_options = array(''=>"----Select----");
	foreach($branch_infos as $branch_info)
	{
		$branch_options[$branch_info->branch_id] = $branch_info->branch_code . ' - ' . $branch_info->branch_name;
	}

?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('employee_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open_multipart("employees/$action",'',$hidden_input);
?>
<fieldset>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employees')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>
							<label for="txt_name">Name:<span class="required_field_indicator">*</span></label>
                             <div class="form_input_container">
							<?php echo form_input(array('name' => 'txt_name','id' => 'txt_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_name', (isset($row->name)?$row->name:"")));?>
							<?php echo form_error('txt_name'); ?>		
                            </div>
                        </li>
						<li>
							<label for="txt_code">Code:<span class="required_field_indicator">*</span></label>
                             <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_code','id'=>'txt_code','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_code', (isset($row->code)?$row->code:"")));?><?php echo form_error('txt_code'); ?>			
                            </div>
                        </li>
						<li>
							<label for="cbo_branch">Branch:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_dropdown('cbo_branch', $branch_options, set_value('cbo_branch', (isset($row->branch_id)?$row->branch_id:$user['branch_id']))); ?><?php echo form_error('cbo_branch'); ?>
                            </div>
                        </li>
						<li>
							<label for="cbo_employee_designation">Designation:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_dropdown('cbo_employee_designation', $designation_options, set_value('cbo_employee_designation', (isset($row->designation_id)?$row->designation_id:""))); ?><?php echo form_error('cbo_employee_designation'); ?>
                            </div>
                        </li>						
						<li>
							<label for="txt_fathers_name">Father's Name:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_fathers_name','id'=>'txt_fathers_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_fathers_name', (isset($row->fathers_name)?$row->fathers_name:"")));?><?php echo form_error('txt_fathers_name'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_mothers_name">Mother's Name:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_mothers_name','id'=>'txt_mothers_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_mothers_name', (isset($row->mothers_name)?$row->mothers_name:"")));?><?php echo form_error('txt_mothers_name'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_spouse_name">Spouse Name:<em>&nbsp;</em></label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_spouse_name','id'=>'txt_spouse_name','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_spouse_name', (isset($row->spouse_name)?$row->spouse_name:"")));?>
                            </div>
                        </li>
						<li>
							<label for="txt_permanent_address">Permanent Address:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_textarea(array('name' => 'txt_permanent_address','rows'=>2,'cols'=>50),set_value('txt_permanent_address',(isset($row->permanent_address)?$row->permanent_address:"")));?><?php echo form_error('txt_permanent_address'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_present_address">Present Address:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_textarea(array('name' => 'txt_present_address','rows'=>2,'cols'=>50),set_value('txt_present_address',(isset($row->present_address)?$row->present_address:"")));?><?php echo form_error('txt_present_address'); ?>
                            </div>
                        </li>
						<li>
							<label for="cbo_last_achieved_degree">Last Achieved Degree:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_dropdown('cbo_last_achieved_degree', $educational_qualification_options, set_value('cbo_last_achieved_degree',(isset($row->last_achieved_degree)?$row->last_achieved_degree:""))); ?><?php echo form_error('cbo_last_achieved_degree'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_date_of_birth">Date of Birth:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name' => 'txt_date_of_birth', 'id' => 'datepicker','class'=>'date_picker input_textbox','maxlength'=>'100'),set_value('txt_date_of_birth',(isset($row->date_of_birth)?$row->date_of_birth:"")));?> <div class="hints"> YYYY-MM-DD</div><?php echo form_error('txt_date_of_birth'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_date_of_joining">Date of Joining:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name' => 'txt_date_of_joining', 'id' => 'joining_datepicker','class'=>'date_picker input_textbox','maxlength'=>'100'),set_value('txt_date_of_joining',(isset($row->date_of_joining)?$row->date_of_joining:"")));?> <div class="hints"> YYYY-MM-DD</div><?php echo form_error('txt_date_of_joining'); ?>
                            </div>
                        </li>
						<li>
							<label for="cbo_is_field_officer">Can manage loan?:<span class="required_field_indicator">*</span></label>
							 <div class="form_input_container">
                            <?php $field_officer_options = array(''=>"--Select--", '1'=>'Yes', '0'=>'No');?>
							<?php echo form_dropdown('cbo_is_field_officer', $field_officer_options,set_value('cbo_is_field_officer',(isset($row->is_field_officer)?$row->is_field_officer:""))); ?>	<?php echo form_error('cbo_is_field_officer'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_secuirity_money">Security Money:</label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_secuirity_money','id'=>'txt_secuirity_money','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_secuirity_money', (isset($row->secuirity_money)?$row->secuirity_money:"")));?><?php echo form_error('txt_secuirity_money'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_starting_salary">Starting Salary:</label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_starting_salary','id'=>'txt_starting_salary','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_starting_salary', (isset($row->starting_salary)?$row->starting_salary:"")));?><?php echo form_error('txt_starting_salary'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_current_salary">Current Salary:</label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_current_salary','id'=>'txt_current_salary','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_current_salary', (isset($row->starting_salary)?$row->starting_salary:"")));?><?php echo form_error('txt_current_salary'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_national_id">National ID:</label>
							 <div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_national_id','id'=>'txt_national_id','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_national_id', (isset($row->national_id)?$row->national_id:"")));?><?php echo form_error('txt_national_id'); ?>
                            </div>
                        </li>
						<li>
							<label for="cbo_status">Status:</label>
							<div class="form_input_container">
                            <?php echo form_dropdown('cbo_status', $status_options, set_value('cbo_status', (isset($row->status)?$row->status:"")));?><?php echo form_error('cbo_status'); ?>
                            </div>
                        </li>
						<li>
							<label for="txt_member_picture">Employee Picture:</label>
							<div class="form_input_container">
                            <?php echo form_hidden('txt_employee_picture_edit',isset($row->employee_picture)?$row->employee_picture:"");?>
                            <input type="file" name="txt_employee_picture" size="20" />
                            <div style="float:right;"><?php if (isset($row->employee_picture)) echo img(array('src'=>base_url().IMAGE_UPLOAD_PATH.$row->employee_picture,'border'=>'0','alt'=>'','width'=>'40','height'=>'40'))?></div>
							<span class="explain" id="explain">File must be .jpg, .gif or .png</span>                            
                            <?php echo form_error('txt_employee_picture');?>	
                            </div>
                        </li>
						<li>
							<label for="txt_refence_info_1">Reference Info 1:</label>
							<div class="form_input_container">
                            <?php echo form_textarea(array('name' => 'txt_refence_info_1','rows'=>2,'cols'=>50),set_value('txt_refence_info_1', (isset($row->refence_info_1)?$row->refence_info_1:"")));?><?php echo form_error('txt_refence_info_1');?>
                            </div>
                        </li>
						<li>
							<label for="txt_refence_info_2">Reference Info 2:</label>
							 <div class="form_input_container">
                            <?php echo form_textarea(array('name' => 'txt_refence_info_2','rows'=>2,'cols'=>50),set_value('txt_refence_info_2',(isset($row->refence_info_2)?$row->refence_info_2:"")));?><?php echo form_error('txt_refence_info_2'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('employees')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php 
echo form_close();
?>
