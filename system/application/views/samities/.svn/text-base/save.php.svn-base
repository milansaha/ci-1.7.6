<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#working_area").autocomplete('<?php echo site_url("po_working_areas/ajax_get_working_area_list_auto/")?>', {
			minChars: 0,
			width: 310,
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
			var tmp;
			tmp=item[0].split(",");
			$("#cbo_working_area_id").val(tmp[0]);
		});
});
</script>
<?php	
	$product_options[''] = '--------SELECT--------';
	foreach($product_infos as $product_info)
	{
		$product_options[$product_info->product_id] = $product_info->product_mnemonic . ' - ' .$product_info->funding_org_name;
	}
	//Combo data for Samity Day
	$samity_day_options[''] = '--------SELECT--------';
	foreach($samity_days as $kay=>$value)
	{
		$samity_day_options[$kay]=$value;
	}
	//Combo data for Samity Type
	$samity_type_options[''] = '--------SELECT--------';
	foreach($samity_types as $key => $value)
	{
		$samity_type_options[$key]=$value;
	}	
	//Combo data for Field Officer
	$field_officer_options[''] = '--------SELECT--------';
	if(!empty($field_officer_options))
	{
		//Combo data for Field Officer
		foreach($field_officer_infos as $field_officer_info)
		{
			$field_officer_options[$field_officer_info->field_officer_id]=$field_officer_info->field_officer_name;
		}
	}
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('samity_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("samities/$action",'',$hidden_input);
    if(isset($id_sequence_no))  {
        echo form_hidden('txt_id_sequence_no', $id_sequence_no);
    }elseif(isset($row->id_sequence_no)){
        echo form_hidden('txt_id_sequence_no', $row->id_sequence_no);
    }
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samities')."'"));?>
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
                            <?php echo form_input(array('name'=>'txt_name','id'=>'txt_name','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_name',isset($row->name)?$row->name:""));?><?php echo form_error('txt_name'); ?>
                            </div>
						</li>
						<li>
							<label for="txt_code">Code:<span class="required_field_indicator">*</span></label>
							<?php $readonly = ($samity_code>1)?"'readonly'=>'readonly'":"";
                                if(!empty($samity_code)){
                                    $code_attr = array('name'=>'txt_code','id'=>'txt_code','readonly'=>'readonly','class'=>'input_textbox');
                                }else{
                                    $code_attr = array('name'=>'txt_code','id'=>'txt_code','class'=>'input_textbox');
                                }
							?>
							<?php echo form_input($code_attr,set_value('txt_code',isset($row->code)?$row->code:$samity_code));?>
							<?php echo form_error('txt_code'); ?>
						</li>
						<li>
							<label for="cbo_working_area_id">Working Area:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                            <input type="hidden" name="cbo_working_area_id" id="cbo_working_area_id" value="<?php echo isset($row->working_area_id)?$row->working_area_id:'' ?>"/>
							<input type="text" id="working_area" name="working_area_name" <?php if(isset ($has_member_entry) and $has_member_entry){echo "readonly='readonly'";}?> value="<?php echo isset($row->working_area_id)?$row->working_area_name:'' ?>" />
                            <?php echo form_error('cbo_working_area_id'); ?>
                            </div>
						</li>
						<li>
							<label for="cbo_product_id">Product:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                                <?php if(isset ($has_member_entry) and $has_member_entry):?>
                                <input type="hidden" name="cbo_product_id" id="cbo_product_id" value="<?php echo isset($row->product_id)?$row->product_id:'' ?>"/>
                                <input type="text" id="product_mnemonic" name="product_mnemonic" readonly="readonly" class="input_select" value="<?php echo isset($row->short_name)?$row->short_name:'' ?>" />
                                <?php else:?>
                                <?php echo form_dropdown('cbo_product_id', $product_options, set_value('cbo_product_id', (isset($row->product_id)?$row->product_id:"")),'id="cbo_product_id" class=>"input_select"'); ?>
                                <?php endif;?>
                                <?php echo form_error('cbo_product_id'); ?>
                            </div>
						</li>
						<li>
							<label for="txt_registration_no">Registration No:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_registration_no','readonly'=>'readonly','class'=>'input_textbox','maxlength'=>'100'),set_value('txt_registration_no',isset($row->registration_no)?$row->registration_no:$next_registration_no));?>
							<?php echo form_error('txt_registration_no'); ?>
                            </div>
						</li>
						<li>
							<label for="cbo_field_officer_id">Field Officer:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                                <?php if(isset ($has_member_entry) and $has_member_entry):?>
                                <input type="hidden" name="cbo_field_officer_id" id="cbo_field_officer_id" value="<?php echo isset($row->field_officer_id)?$row->field_officer_id:'' ?>"/>
                                <input type="text" id="field_officer_id" name="field_officer_id" readonly="readonly" class="input_textbox" value="<?php echo isset($row->employee_name)?$row->employee_name:'' ?>" />
                                <?php else:?>
                                <?php echo form_dropdown('cbo_field_officer_id', $field_officer_options, set_value('cbo_field_officer_id', (isset($row->field_officer_id)?$row->field_officer_id:"")),'id="cbo_field_officer_id" class="input_select"'); ?>
                                <?php endif;?>
                                <?php echo form_error('cbo_field_officer_id'); ?>
                            </div>
						</li>
						<li>
							<label for="cbo_samity_day">Samity Day:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                                <?php if(isset ($has_member_entry) and $has_member_entry):?>
                                <input type="hidden" name="cbo_samity_day" id="cbo_samity_day" class="input_select" value="<?php echo isset($row->samity_day)?$row->samity_day:'' ?>"/>
                                <input type="text" id="samity_day_full" name="samity_day_full" class="input_textbox" readonly="readonly" value="<?php echo isset($row->samity_day_full)?$row->samity_day_full:'' ?>" />
                                <?php else:?>
                                <?php echo form_dropdown('cbo_samity_day', $samity_day_options, set_value('cbo_samity_day', (isset($row->samity_day)?$row->samity_day:"")),'id="cbo_samity_day"','class="input_select"'); ?>
                                <?php endif;?>
                                <?php echo form_error('cbo_samity_day'); ?>
                            </div>
						</li>
						<li>
							<label for="cbo_samity_type">Samity Type:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                                <?php if(isset ($has_member_entry) and $has_member_entry):?>
                                <input type="hidden" name="cbo_samity_type" id="cbo_samity_type" value="<?php echo isset($row->samity_type)?$row->samity_type:'' ?>"/>
                                <input type="text" id="samity_type" name="samity_type" readonly="readonly" class="input_textbox" value="<?php if(isset($row->samity_type)){ if($row->samity_type=='M'){ echo 'Male';} else { echo 'Female'; }}?>" />
                                <?php else:?>
                                <?php echo form_dropdown('cbo_samity_type', $samity_type_options, set_value('cbo_samity_type', (isset($row->samity_type)?$row->samity_type:"")),'id="cbo_samity_type"'); ?>
                                <?php endif;?>
                                <?php echo form_error('cbo_samity_type');?>
                            </div>
						</li>
						<li>
							<label for="txt_skt_amount">SKT Amount:</label>
                            <div class="form_input_container">
                                <input type="text" id="txt_skt_amount" name="txt_skt_amount" class="input_textbox" <?php if(isset ($has_member_entry) and $has_member_entry){echo "readonly='readonly'";}?> value="<?php echo isset($row->skt_amount)?$row->skt_amount:'' ?>" />
                                <?php echo form_error('txt_skt_amount'); ?>
                            </div>
						</li>
						<li>
							<label for="txt_opening_date">Opening Date:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                                <input type="text" name="txt_opening_date" class="date_picker" <?php if(isset ($has_member_entry) and $has_member_entry){echo "readonly='readonly' id='datepicker-uneditable'";}else{echo 'id="datepicker"';}?> value="<?php echo isset($row->opening_date)?$row->opening_date:'' ?>" />
                                <div class="hints"> YYYY-MM-DD</div>
                                <?php echo form_error('txt_opening_date'); ?>
                            </div>
						</li>
					</ol>
				</div>
			</td>
			<td valign="top" style="background:url(<?php echo base_url();?>media/images/alpona.gif) no-repeat bottom right;">
				<p class="helper"> 
                    <?php if(isset ($has_member_entry) and $has_member_entry){
                         echo '<span style="color:#529214;">'. 'Since this Samity is being used by some member, You can\'t change any informatin except samity name.' . '</span>';
                    }?>
                </p>
			</td>
		</tr>
		<tr>
			<td class="formBottomBar">
				<div class="buttons" style="margin:0px 0px 0px 20px;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('samities')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
