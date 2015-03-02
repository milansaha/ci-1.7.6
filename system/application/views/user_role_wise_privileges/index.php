<script type="text/javascript" src="<?php echo base_url();?>media/js/checkBoxLogic.js"></script>
	<table class="addForm" border="0" cellspacing="0px" cellpadding="0px" width="100%">
		<tr>
			<td class="formTitleBar">
			<?php $class_name = 'class="formTitleBar_edit"'; ?>
				<div <?php echo $class_name?>>
					<div style="float:left;margin: 0 0 0 20px;">
					<h2 style="margin: 2px 0 0 0;">Modify User Role wise privileges</h2>
                    <br>
                    <br>
                    <strong>Role Name:&nbsp;<?php echo $role_name['0']['role_name']; ?></strong></div>
				</div>
			</td>
			<td class="formTitleBar">
				<div style="float:right;">
					<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
					<?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('user_roles')."'"));?>
				</div>
			</td>
		</tr>
    </table>
<style>
.bluetableborder{
    border-left: 1px solid #CDCDCD;
    border-right: 1px solid #CDCDCD;
    border-top: 1px solid #CDCDCD;
    margin: 0 0 0 0;
    width: 100%;
}
.bluetablehead{padding-left:5px;padding-top:3px;padding-bottom:3px;border:1px solid #D7DEEE;padding-right:3px;}
.bluetablehead05 {    background-color: #CDCDCD;
    color: #2E2E2E;
    padding-bottom: 4px;
    padding-left: 10px;
    padding-top: 3px;}
.paddingleft05BottomBorder {
    border-bottom: 1px solid #CDCDCD;
    font-family: Arial;
    padding-left: 5px;
    padding-top: 3px;
}

</style>
<script type="text/javascript"> 
function CheckAll(fmobj)
{
	for (var i=0;i<fmobj.elements.length;i++)
	{
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled))
		{
			e.checked = fmobj.allbox.checked;
		}
	}
}
function CheckCheckAll(fmobj)
{
	var TotalBoxes = 0;
	var TotalOn = 0;
	for (var i=0;i<fmobj.elements.length;i++)
	{
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox'))
		{
			TotalBoxes++;
			if (e.checked)
			{
				TotalOn++;
			}
		}
	}
	if (TotalBoxes==TotalOn)
	{
		fmobj.allbox.checked=true;
	}
	else
	{
		fmobj.allbox.checked=false;
	}
}
</script>
<?php echo form_open('user_role_wise_privileges/'.(isset($row->id)?"edit":"add")); ?>

<table cellspacing="0" cellpadding="2" border="0" width="95%" class="bluetableborder">
		<?php 	echo form_hidden('role_id', $role_id);
				echo form_hidden('role_name', $role_name['0']['role_name']); ?>
<?php
	$run = array();
	for($j=0;$j<count($role_privilege_resources);$j++)
	{
		$run[$role_privilege_resources[$j]['resource_id']] = '';
	}
	$previous_group = "";
	$parent = 0; //initialize parent counting
	$child = 0; //initialize child counting
	foreach($user_resources as $resource)
	{
		//echo $form->form_hidden(array('name'=>'action['.$parent.']','value'=>$resource->action)); //action name
		//echo $form->form_hidden(array('name'=>'action['.$parent.']','value'=>$resource->action)); //action name
		if($previous_group != $resource->resource_group_name)
		{
			$parent++;
			$previous_group = $resource->resource_group_name;
			if(array_key_exists($resource->id, $run))
			{
				$checked = 'checked="checked"';
				echo "<tr class='bluetablehead05'>
					<td class='paddingleft05BottomBorder' width='3%'>".
					'<input name="activity['.$parent.']" id="'.$parent.'" value="'.$resource->user_resource_group_id.'" '.$checked.' onClick="doCheck(this)" type="checkbox" style="width:auto;">'.
					form_hidden('controller['.$parent.']', $resource->controller).
					form_hidden('action['.$parent.']', $resource->action).
					"</td>
					<td class='paddingleft05BottomBorder' colspan=3><b>$resource->resource_group_name</b></td>
				 </tr>";	
			}else{
				$checked = '';
				echo "<tr class='bluetablehead05'>
					<td class='paddingleft05BottomBorder' width='3%'>".
					'<input name="activity['.$parent.']" id="'.$parent.'" value="'.$resource->user_resource_group_id.'" '.$checked.' onClick="doCheck(this)" type="checkbox" style="width:auto;">'.
					form_hidden('controller['.$parent.']', $resource->controller).
					form_hidden('action['.$parent.']', $resource->action).
					"</td>
					<td class='paddingleft05BottomBorder' colspan=3><b>$resource->resource_group_name</b></td>
				 </tr>";
			}
			//incremented parent counting
			$child = 0; //resetting the child counting to 0(zero) again
		}
		if(array_key_exists($resource->id, $run))
		{	
			$checked = 'checked="checked"';
			echo "<tr>	
						<td class='paddingleft05BottomBorder'></td>
						<td  class='paddingleft05BottomBorder' width='3%'>".
						'<input name="activity['.$parent.']['.$child.']" id="'.$parent.'_'.$child.'" value="'.$resource->id.'" '.$checked.' onClick="doCheck(this)" type="checkbox" style="width:auto;">'.
						form_hidden('controller['.$parent.']['.$child.']', $resource->controller).
						form_hidden('action['.$parent.']['.$child.']', $resource->action)."</td>
						<td class='paddingleft05BottomBorder'>$resource->title</td>
						<td class='paddingleft05BottomBorder'>$resource->controller -> $resource->action</td>
				  </tr>";
		}else{
			$checked = '';
			echo "<tr>	
						<td class='paddingleft05BottomBorder'></td>
						<td  class='paddingleft05BottomBorder' width='3%'>".
						'<input name="activity['.$parent.']['.$child.']" id="'.$parent.'_'.$child.'" value="'.$resource->id.'" '.$checked.' onClick="doCheck(this)" type="checkbox" style="width:auto;">'.
						form_hidden('controller['.$parent.']['.$child.']', $resource->controller).
						form_hidden('action['.$parent.']['.$child.']', $resource->action)."</td>
						<td class='paddingleft05BottomBorder'>$resource->title</td>
						<td class='paddingleft05BottomBorder'>$resource->controller -> $resource->action</td>
				  </tr>";
		}
		$child++; //incremented child counting
	}
?>
</table>
<br/>
<style>

</style>

<div class="buttons" style="margin:0px 0px 0px 20px;">
    <?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'submit_buttons positive'),'Save');?>
    <?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Reset','class'=>'reset_buttons'));?>
    <?php echo form_button(array('name'=>'button','id'=>'button','value'=>'true','type'=>'reset','content'=>'Cancel','class'=>'cancel_buttons','onclick'=>"window.location.href='".site_url('user_roles')."'"));?>
</div>

<?php /*echo form_submit(array('type'=>'submit','name'=>'submit','value'=>'Submit','style'=>'margin:0px 0px 0px 30px;
display:block;
color:#555555;
font-weight:bold;
height:30px;
line-height:29px;
margin-bottom:14px;
text-decoration:none;
width:auto;background:url('.base_url().'media/images/process.png) no-repeat 10px 8px;
text-indent:30px;    background-color:#f5f5f5;
    border:1px solid #dedede;
    border-top:1px solid #eee;
    border-left:1px solid #eee;

display:block;','class'=>'abutton'));*/?>
<!--<a href="#" class="button">
<span class="add">Cancel</span>
</a>-->
<?php echo form_close(); ?>
