<?php
	//Product list
	$product_options = array(""=>"--Select--");
	foreach($products as $product_row)
	{					
		$product_options[$product_row->id]=$product_row->name;
	}
	//Funding organization list
	$funding_organization_options = array(""=>"--Select--");
	foreach($funding_organizations as $funding_organization_row)
	{					
		$funding_organization_options[$funding_organization_row->id]=$funding_organization_row->name;
	}
	//Form Start
	//echo form_open('savings/'.(isset($row->id)?"edit":"add"));
?>
<?php
	$action=$this->uri->segment(2);
	$hidden_input=null;
	$img_name = '/media/images/add_big.png';
	if($action=='edit')
	{
		$hidden_input=array('saving_id'=>$row->id);
		$img_name = '/media/images/edit_big.png';
	}
	echo form_open("savings/$action",'',$hidden_input);
?>
<fieldset>
<table class="uiInfoTableConfig" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr>
				<th>
					<img src="<?php echo base_url();?>/media/images/Config-icon.png" width="20px" align="top" border="0" />&nbsp;&nbsp;
					Savings Detail
				</th>
				<th style="padding:0;margin:0;" align="right" valign="top">
					<div style="float:right;width:145px;border:solid 0px red;">
						<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Back to list page','class'=>'back_button','onclick'=>"window.location.href='".site_url('savings')."'"));?>
					</div>
				</th>
			</tr>
			<tr>
				<td width="40%" align="left" class="field-label">Member:</td>
				<td class="field-items"><?php echo $row->member_name?$row->member_name:'' ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Product:</td>
				<td class="field-items"><?php echo $row->saving_products_name?$row->saving_products_name:''?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Deposite Type:</td>
				<td class="field-items"><?php echo $row->type_of_deposite?$row->type_of_deposite:'' ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Interest Rate:</td>
				<td class="field-items"><?php echo $row->interest_rate?$row->interest_rate:'' ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Funding Organization:</td>
				<td class="field-items"><?php echo $row->funding_organization_name?$row->funding_organization_name:'' ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Code:</td>
				<td class="field-items"><?php echo $row->code?$row->code:'' ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Weekly Savings Amount:</td>
				<td class="field-items"><?php echo $row->weekly_savings?$row->weekly_savings:'' ?></td>
			</tr> 
			<tr>
				<td width="40%" align="left" class="field-label">Opening Date:</td>
				<td class="field-items"><?php echo $row->opening_date?date("d/m/Y",strtotime($row->opening_date)):'' ?></td>
			</tr>
		</tbody>
	</table>
</fieldset>
