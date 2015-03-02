<script type="text/javascript">
	$(function(){	
	$("#txt_from_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#txt_to_date").datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<?php 
	//Combo data for User
	$user_arr[-1] = "---Select User Name---";
	foreach($user_lists as $user_list_info)
	{					
		$user_arr[$user_list_info->id] = $user_list_info->full_name;
	}
	//Combo data for Branches
	$branches_options[-1] = "---Select Branch---";
	foreach($user_branches as $user_branch_info)
	{					
		$branches_options[$user_branch_info->id] = $user_branch_info->name;
	}
	//status_info
	$session_data = $this->session->userdata('user_audit_trails.index');
	if(isset($session_data['from_date']) and $session_data['from_date']!='')
	{
		$sess_fromdate = date('Y-m-d',$session_data['from_date']);
	}
	else
	{
		$sess_fromdate = '';
	}
	if(isset($session_data['to_date']) and $session_data['to_date'] != '')
	{
			$sess_todate = date('Y-m-d',$session_data['to_date']);
	}
	else
	{
				$sess_todate = '';
	}
?>
<?php echo form_open('user_audit_trails/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php 
					$attribute = 'class="search_input" title="From Date "'; 
				?>
				<?php   $from_date_attr = array('name'=>'txt_from_date','id'=>'txt_from_date','maxlength'=> '10');
						echo form_input($from_date_attr,set_value('txt_from_date',isset($session_data['from_date'])?$sess_fromdate:""),$attribute);?>
				<?php echo form_error('txt_from_date'); ?>		
			</td>
			<td>
				<?php 
						$attribute = 'class="search_input" title="To Date "'; 
						$to_date_attr = array('name'=>'txt_to_date','id'=>'txt_to_date','maxlength'=> '10');
						echo form_input($to_date_attr,set_value('txt_to_date',isset($session_data['to_date'])?$sess_todate:""),$attribute);?>
				<?php echo form_error('txt_to_date'); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_user', $user_arr,isset($session_data['user'])?$session_data['user']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_user_branch', $branches_options,isset($session_data['user_branch'])?$session_data['user_branch']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_action_type', $action_info,isset($session_data['action_type'])?$session_data['action_type']:""); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Timestamp</th>
	<th>User</th>	
	<th>Branch</th>
    <th>IP Address</th>
	<th>Entity</th>
	<th>User Action</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($audit_trails as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo date('d/m/Y- h:i:s A',$row->time_stamp);?></td>
	<td><?php echo $row->user_name;?></td>
	<td><?php echo $row->branch_name;?></td>
    <td><?php echo $row->ip_address;?></td>
	<td><?php echo get_formated_table_name($row->table_name);?></td>
	<td><?php echo $row->action;?></td>
	<td>
	<?php echo anchor('user_audit_trails/view/'.$row->id,img(array('src'=>base_url().'media/images/view.png','border'=>'0','alt'=>'view')),array('class'=>'imglink')); ?>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php
function get_formated_table_name($str)
{
	$tmp=explode('_',$str);
	switch ($tmp[0]) {
		case 'po':
			$tmp[0]="Organization:";
			break;
		case 'acc':
			$tmp[0]="Accounting:";
			break;
		case 'config':
			$tmp[0]="Configuration:";
			break;
		case 'user':
			$tmp[0]="Security: ".$tmp[0];
			break;
		case 'users':
			$tmp[0]="Security: ".$tmp[0];
			break;
		default:
			$tmp[0]= ucfirst($tmp[0]);
			break;
	}
	$str=implode(" ",$tmp);
	return $str;
}
?>
<?php echo form_close(); ?>
