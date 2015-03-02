<script type="text/javascript">
$(document).ready(function()
	{			
		<?php 
		$is_branch = ($rdo_category == 'Branch' || $rdo_category == 'Samity')?"show":"hide";
		$is_samity = ($rdo_category == 'Samity')?"show":"hide";
		if($is_samity === "show") {
			?>
			$("#rdo_samity").attr("checked",true);
			<?php
		} elseif($is_branch === "show") {
			?>
			$("#rdo_branch").attr("checked",true);
			<?php
		}else{
			?>
			$("#rdo_organization").attr("checked",true);
			<?php
		}
		?>
		$("#branch").<?php echo $is_branch?>();
		$("#samity").<?php echo $is_samity?>();
		$("#rdo_organization").click(function()				
		{
			$("#branch").hide();
			$("#samity").hide();							
		});
		$("#rdo_branch").click(function()				
		{
			$("#branch").show();
			$("#samity").hide();						
		});
		$("#rdo_samity").click(function()				
		{
			$("#branch").show();
			$("#samity").show();							
		});
		
		//$('#cbo_samity').empty();
		// branch
		$("#cbo_branch").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			
			var selected_from_branch = $("#cbo_branch").val();
			
			$.post("<?php echo site_url('config_holidays/ajax_method_for_get_branch_list') ?>", { branch_id: selected_from_branch },
			function(data)
			{
				$('#status').html("");
				$('#cbo_samity').empty();
				if( data.status == 'failure' )
				{
					alert(data.status);
					$('#from_samity_row').css({"display":"none"});
				}
				else
				{
					//alert(data.status);
					//$('#from_samity_row').removeAttr('style');
					for(var i = 0; i < data.samity_id.length; i++)
					{
						$('#cbo_samity').append('<option value = \"' + data.samity_id[i] + '\">' + data.samity_name[i] + '</option>');
					
					}
				}
			}, "json");
		});
		
	});	
	
	//datepicker
	$(function(){
	$("#txt_holiday_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php
$options_branch_name[''] = "---Select---";
foreach($branch_infos as $branch_info)
{					
	$options_branch_name[$branch_info->branch_id]=$branch_info->branch_name;
}
$options_samity_name[''] = "---Select---";
foreach($samity_infos as $samity_info)
{                                       
        $options_samity_name[$samity_info->samity_id]=$samity_info->samity_name;
} 
foreach($holiday_types as $holiday_type)
{
		$options[$holiday_type]=$holiday_type;
} 
//print_r($samity_infos);                                      
//echo form_open('config_holidays/'.(isset($row->id)?"edit":"add"));
//echo form_hidden('config_holiday_id',isset($row->id)?$row->id:"");
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('config_holiday_id'=>isset($row->id)?$row->id:"");
		$img_name = '/media/images/edit_big.png';
	}
	echo form_open("config_holidays/$action",'',$hidden_input);
	//print_r($row);die;
?>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
<fieldset style="">
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div>
					<img src="<?php echo base_url() . $img_name;?>" border="0" width="24" class="" />
					<h2><?php echo $headline?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('config_holidays')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
                    <ol>
                        <li id="category">
							<label for="cbo_applicable">Applicable For:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
								<table border="0" cellpadding="0" cellspacing="0" style="padding:0px;margin:0px;">
									<tr>
										<td><input id="rdo_organization" style="width:10px;border:none;width:20px;color:#444;" type="radio" name="rdo_category" value="Organization"  <?php echo set_radio('rdo_category', 'Organization', TRUE); ?> >Organization</td>
										<td><input id="rdo_branch" style="width:10px;border:none;width:20px;color:#444;" type="radio" name="rdo_category" value="Branch"  <?php echo set_radio('rdo_category', 'Branch', TRUE); ?> >Branch</td>
										<td><input id="rdo_samity" style="width:10px;border:none;width:20px;color:#444;" type="radio" name="rdo_category" value="Samity"  <?php echo set_radio('rdo_category', 'Samity', TRUE); ?> >Samity</td>
									</tr>
								</table>
							</div>
                        </li>
                        <li id="branch">
                            <label for="cbo_branch">Branch Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                            <?php
                           
                                $branch_html_attributes = 'id="cbo_branch" class="input_select"';
                                echo form_dropdown('cbo_branch',$options_branch_name,set_value('cbo_branch',isset($row->branch_id)?$row->branch_id:""),$branch_html_attributes);
                            ?><?php echo form_error('cbo_branch'); ?>
                           </div>
                        </li>
                        <li id="samity">
                            <label for="cbo_samity">Samity Name:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                            <?php echo form_dropdown('cbo_samity', $options_samity_name,set_value('cbo_samity',isset($row->samity_id)?$row->samity_id:""),'id="cbo_samity" class="input_select"');?>
                            <?php echo form_error('cbo_samity'); ?>
                            </div>
                        </li>
                        <li>
                            <label for="txt_holiday_date">Holiday Date:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                            <?php
                            $attr = array('name'=>'txt_holiday_date','id'=>'txt_holiday_date','class'=>"date_picker");
                            echo form_input($attr,set_value('txt_holiday_date',isset($row->holiday_date)?$row->holiday_date:""));?><?php echo form_error('txt_holiday_date'); ?>
                            <div class="hints"> YYYY-MM-DD</div>
                            </div>
                            
                        </li>
                        <li>
                            <label for="cbo_holiday_type">Type:<span class="required_field_indicator">*</span></label>
                            <div class="form_input_container">
                            <?php echo form_dropdown('cbo_holiday_type', $holiday_types,set_value('cbo_holiday_type',isset($row->holiday_type)?$row->holiday_type:""),'id="cbo_holiday_type" class="input_select"');?>
                            </div>
                        </li>
                        <li>
                            <label for="txt_description">Description:</label>
                            <div class="form_input_container">
                            <?php echo form_textarea(array('name'=>'txt_description','rows'=>2,'cols'=>50),set_value('txt_description',isset($row->description)?$row->description:""));?><?php echo form_error('txt_description'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('config_holidays')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php echo form_close(); ?>
