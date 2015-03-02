<script type="text/javascript">
$(document).ready(function()
	{
		// branch
		$("#cbo_branch").change(function()
		{
			$("#status").html("<img border='0' src='<?php echo base_url();?>/media/images/loading.gif' />");
			var selected_from_branch = $("#cbo_branch").val();
			$.post("<?php echo site_url('config_holidays/ajaxmethod_for_get_branch_list') ?>", { branch_id: selected_from_branch },
			function(data)
			{
				$('#status').html("");
				$('#cbo_samity').empty();
				if( data.status == 'failure' )
				{
					alert(data.message);
					$('#cbo_samity').append('<option value = "">--Select--</option>');
				}
				else
				{
					for(var i = 0; i < data.samity_id.length; i++)
					{
						$('#cbo_samity').append('<option value = \"' + data.samity_id[i] + '\">' + data.samity_name[i] + '</option>');
					}
				}
			}, "json");
		});
		
	});	
</script>
<?php 
	//Samity list	
	$samity_options = array(''=>"--Select--");	
	foreach($samities as $samity_row)
	{					
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$session_data = $this->session->userdata('member_closings.index');	
	?>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
<h3><?php //echo $headline;?></h3>
<?php echo form_open('member_closings/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="By Name or Code"'; ?>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options,isset($session_data['cbo_samity'])?$session_data['cbo_samity']:"",'id="cbo_samity"'); ?>
			</td>
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('member_closings/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Union Ward')).'Add',array('class'=>'addbutton','title'=>'Add Union Ward'));  ?>
	</div>
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
        <tr>
               <th width='5%'>#</th>
                <th>Code</th>
                <th>Member Name</th>
                <th>Spouse/Father Name</th>
                <th>Gender</th>
                <th>Branch</th>
                <th>Samity</th>
                <th width='10%'>Action</th>
        </tr>
        <?php
                $i=$counter;
                //print_r($members);
                foreach ($members as $row):
                $i++;
        ?>
        <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
                <td class="serial"><?php echo $i;?></td>
                <td><?php echo $row->code;?></td>
                <td><?php echo anchor('members/view/'.$row->id,$row->name);?></td>
                <td><?php echo $row->fathers_spouse_name;?></td>
                <td><?php if($row->gender=='F'):echo "Female"; else: echo "Male"; endif;?></td>
                <td><?php echo $row->branch_name;?></td>
                <td><?php echo $row->samity_name;?></td>
                <td><?php //echo anchor('members/view/'.$row->id,img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'View')),array('class'=>'imglink','title'=>'View'));   ?>
					<?php echo anchor('member_closings/edit/'.$row->member_closing_id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
					<?php echo anchor('member_closings/delete/'.$row->member_closing_id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
        </tr>
        <?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
