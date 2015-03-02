<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/test.css" />-->
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
$(function(){
	$("#txt_transfer_date").datepicker({dateFormat: 'yy-mm-dd'});
});
</script>	
<script type="text/javascript">
$(document).ready(function() {
		$("#member_info").autocomplete('<?php echo site_url("members/ajax_get_member_list_auto/")?>', {
			minChars: 0,
			width: 310,
			matchContains: "word",
			highlightItem: true,
			formatItem: function(row, i, max, term) {
				var tmp;
				tmp=row[0].split(",");
				return "<strong>"+tmp[1]+"</strong>" + "<br><span style='font-size: 80%;'>Branch: " + tmp[2] + "<br>Samity: " + tmp[3] + "<br>Working area: " + tmp[4] + "</span>";
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
			// JSON part
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_member_id = tmp[0];
			//alert(selected_member_id);
			$.post("<?php echo site_url('members/ajax_for_get_member_info_by_id') ?>", { member_id: selected_member_id },
			function(data)
			{
				$('#status').html("");
				$('#test').empty();
				$('#current_saving_info').empty();
				$('#member_info1').empty();
				//$('#new_samity').empty();
				if( data.status == 'failure' )
				{
					alert(data.message);
					//$('#cbo_samity').append('<option value = "">--Select--</option>');
				}
				else
				{
					//alert(data.status);				
					$('#member_id').attr('value',data.member.id);
					$('#member_info1').append("<p>Member Name (Code): <b>" + data.member.name + " (" + data.member.code + ")</b><br> Samity Name (Code) : <b>" + data.samity.name + " (" + data.samity.code + ")</b><br> Current Primary Product : <b>" + data.product.name + " ("+ data.product.mnemonic +")</b> </p>");							
				}
			}, "json");
		});
		// end member info		
});
</script>

<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('member_product_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
	}
	echo form_open("member_products/$action",'',$hidden_input);
?>
<fieldset>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
				<div>
					<img src="<?php echo base_url()?>media/images/add_big.png" border="0" width="24" class="" />
					<h2><?php echo $headline;?></h2>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('member_products')."'"));?>
				</div>
			</td>
		</tr>
		<tr>
			<td width="60%">
				<div class="formContainer">
					<ol>  
						<li>	
							<label for="cbo_member">Member Name:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">	
							<input type="hidden" name="member_id" id="member_id" value="<?php echo isset($row->member_id)?$row->member_id:'' ?>" />			
							<input type="text" id="member_info" value="<?php echo isset($member_information->member_name)?$member_information->member_name:'' ?>" maxlength='100' class='input_textbox'/>
							<?php //echo anchor('members/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Member')),array('class'=>'addimglink','alt'=>'Add Member','title'=>'Add Member')); ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Member','width'=>'12px')), 'add_member', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Member','onclick'=>"window.location.href='".site_url('members/add')."'"));?></div>
							<?php echo form_error('member_id'); ?>			
							<div><div id="member_info1">
							<?php if(isset($member_information->member_name)) { ?>
							<p>Member Name (Code): <b><?php echo "{$member_information->member_name}({$member_information->member_code})"  ?></b><br> Samity Name (Code) : <b><?php echo "{$member_information->samity_code}({$member_information->samity_name})"  ?></b>
							<?php if(isset($member_information->old_product->name)){ ?>
							<br> Old Primary Product : <b><?php echo "{$member_information->old_product->name}({$member_information->old_product->mnemonic})"  ?></b><?php }?>
							<br> Current Primary Product : <b><?php echo "{$member_information->product_mnemonic}({$member_information->funding_org_name})"  ?></b> </p>
							<?php } ?>
							</div>
							</div>
							</div>
						</li> 
						<li>
							<label for="cbo_product">New Primary Product:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">		
							<?php echo form_dropdown('cbo_product', $product_infos,isset($row->new_primary_product_id)?$row->new_primary_product_id:'');?>
							<?php //echo anchor('loan_products/add',img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Primary Product')),array('class'=>'addimglink','alt'=>'Add Primary Product','title'=>'Add Primary Product')); ?>
							<div class="label_adder"><?php echo form_label(img(array('src'=>base_url().'media/images/add.png','border'=>'0','alt'=>'Add Primary Product','width'=>'12px')), 'add_primary_product', array('class'=>'addimglink','style'=>'border:none;','title'=>'Add Primary Product','onclick'=>"window.location.href='".site_url('loan_products/add')."'"));?></div>
							<?php echo form_error('cbo_product'); ?>
							</div>
							</li> 
						<li>
							<label for="txt_transfer_date">Transfer Date:<span class="required_field_indicator">*</span></label>
							<div class="form_input_container">
							<?php echo form_input(array('name'=>'txt_transfer_date','id'=>'txt_transfer_date','maxlength'=>'100','class'=>'input_textbox'),set_value('txt_transfer_date',isset($row->transfer_date)?$row->transfer_date:''));?>
							<?php echo form_error('txt_transfer_date'); ?>
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
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('member_products')."'"));?>
				</div>
			</td>
			<td class="formBottomBar"></td>
		</tr>
	</table>
</fieldset>
<?php 
echo form_close();
?>
