<script type="text/javascript">
	$(function(){
	$("#datepicker_start").datepicker({dateFormat: 'yy-mm-dd'});
        $("#datepicker_end").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#cbo_type_of_deposit").change(
            function()
            {
                var selected_type_id = $("#cbo_type_of_deposit").val();
                if(selected_type_id == 'VOLUNTARY'){
                    $('#txt_mandatory_amount_for_deposit').val(0);
                    $('#txt_mandatory_amount_for_deposit').attr('readonly',"readonly");
                }else{
                      $('#txt_mandatory_amount_for_deposit').val(null);
                      $('#txt_mandatory_amount_for_deposit').attr('readonly',"");
                }
        });
   });
</script>
<?php
$types_of_deposit_options = array(''=>'----Select----');
	foreach($types_of_deposits as $types_of_deposit_row)
	{
		$types_of_deposit_options[$types_of_deposit_row]=$types_of_deposit_row;
	}
    
	$action=$this->uri->segment(2);
	$hidden_input=null;
	if($action=='edit')
	{
		$hidden_input=array('saving_product_id'=>$row->id);
		$class_name = 'class="formTitleBar_edit"';
	}else{$class_name = 'class="formTitleBar_add"';}
	echo form_open("saving_products/$action",'',$hidden_input);
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('saving_products')."'"));?>
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
							<label for="txt_short_name">Short Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
                            <?php echo form_input(array('name'=>'txt_short_name','id'=>'txt_name','class'=>'input_textbox','maxlength'=>'20'),set_value('txt_short_name',isset($row->short_name)?$row->short_name:""));?><?php echo form_error('txt_short_name'); ?>
							</div>
						</li>
						<li>
							<label for="txt_start_date">Start Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_input(array('name' => 'txt_start_date','id' => 'datepicker_start','class'=> 'date_picker'),set_value('txt_start_date',  isset ($row->start_date)?$row->start_date:""));?>
								<div class="hints"> YYYY-MM-DD</div>
								<?php echo form_error('txt_start_date'); ?>
							</div>
						</li>
						<li>
							<label for="txt_end_date">End Date:</label>
							<div class="form_input_container">
								<?php echo form_input(array('name' => 'txt_end_date','id' => 'datepicker_end','class'=> 'date_picker'),set_value('txt_end_date', (isset($row->end_date) and $row->end_date!='0000-00-00')?$row->end_date:""));?>
								<div class="hints"> YYYY-MM-DD</div>
                                <?php echo form_error('txt_end_date'); ?>
							</div>
						</li>
						<li>
							<label for="cbo_type_of_deposit">Type of Deposit:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_dropdown('cbo_type_of_deposit',$types_of_deposit_options,set_value('cbo_type_of_deposit',(isset($row->type_of_deposit)?$row->type_of_deposit:"")),'id="cbo_type_of_deposit" class="input_select"');?>
								<?php echo form_error('cbo_type_of_deposit'); ?>
							</div>
						</li>
						<li>
							<label for="txt_mandatory_amount_for_deposit">Mandatory Amount for Deposit:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
                                <?php if(isset($row->type_of_deposit) and $row->type_of_deposit=='VOLUNTARY'): ?>
								<?php echo form_input(array('name'=>'txt_mandatory_amount_for_deposit','class'=>'input_textbox','maxlength'=>'20','id'=>'txt_mandatory_amount_for_deposit','readonly'=>'readonly'),set_value('txt_mandatory_amount_for_deposit',  isset($row->mandatory_amount_for_deposit)?$row->mandatory_amount_for_deposit:0));?>
                                <?php else:?>
                                <?php echo form_input(array('name'=>'txt_mandatory_amount_for_deposit','class'=>'input_textbox','maxlength'=>'20','id'=>'txt_mandatory_amount_for_deposit'),set_value('txt_mandatory_amount_for_deposit',  isset($row->mandatory_amount_for_deposit)?$row->mandatory_amount_for_deposit:0));?>
                                <?php endif;?>
								<?php echo form_error('txt_mandatory_amount_for_deposit'); ?>
							</div>
						</li>
						<li>
							<label for="txt_interest_rate">Interest Rate:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<?php echo form_input(array('name'=>'txt_interest_rate','class'=>'input_textbox','maxlength'=>'5'),set_value('txt_interest_rate',  (isset($row->interest_rate))?$row->interest_rate:""));?><?php echo '(0-100)%'?>
								<?php echo form_error('txt_interest_rate'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('saving_products')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php
echo form_close();
?>
