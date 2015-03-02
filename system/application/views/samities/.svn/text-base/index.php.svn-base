<?php 
    //Combo data for Branches
    $branches_options[-1] = "---Select Branch---";
    foreach($branch_infos as $user_branch_info)
    {

        $branches_options[$user_branch_info->branch_id]=$user_branch_info->branch_name;
    }

    $session_data=$this->session->userdata('samities.index');		
    echo form_open('samities/index',array('id'=>'search_form','name'=>'search_form'));
    $active = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'Active'));
	$inactive = img(array('src'=>base_url().'media/images/dimed_ok.png','border'=>'0','alt'=>'Inactive'));
?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php  
					$attribute = 'class="search_input" title="By Name or Code "'; 
                    echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>	
			<td>
				<?php  echo form_dropdown('cbo_branch', $branches_options,isset($session_data['branchname'])?$session_data['branchname']:""); ?>
			</td>		
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('samities/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Samity')).'Add',array('class'=>'addbutton','title'=>'Add Samity'));  ?>
	</div>
</div>
<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th>#</th>
	<th>Name</th>
	<th>Code</th>
    <th>Field Officer</th>
    <th>Samity Day</th>
    <th>Samity Type</th>
    <th>Opening Date</th>
    <th width="5%" align="center">Status</th>
	<th>Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($samities as $row):
	$i++;
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	 <td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->name;?></td>
	<td><?php echo $row->code;?></td>
    <td><?php echo $row->field_officer_name;?></td>
    <td><?php //if(!empty($row->samity_day)){/*echo $samity_days[$row->samity_day];*/echo $row->samity_day;}
        $sday = ucfirst(strtolower($row->samity_day));
        if(array_key_exists($sday, $samity_days)){echo $samity_days[$sday];}?></td>
    <td>
        <?php if($row->samity_type=='F')
                {
                    echo "Female";
                } 
               elseif($row->samity_type=='M') {
                    echo "Male";
                }
        ?>
    </td>
    <td><?php echo date('d/m/Y', strtotime($row->opening_date));?></td>
    <td width="5%" align="center"><?php echo ($row->current_status == 0)?$inactive:$active; ?></td>
	<td>
	<?php echo anchor('samities/view/'.$row->id,img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'View')),array('class'=>'imglink','title'=>'View'));   ?>
	<?php echo anchor('samities/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
	<?php echo anchor('samities/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'Delete')),
					array('class'=>'delete','title'=>'Delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?>	
	</td>	
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
