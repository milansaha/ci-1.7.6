<?php 
	//Samity list	
	$samity_options = array(''=>"--Select--");	
	foreach($samities as $samity_row)
	{					
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$session_data = $this->session->userdata('members.index');
	?>
<div id="status" style="position:absolute;top:50%;left:45%;"></div>
<h3><?php //echo $headline;?></h3>
<?php echo form_open('members/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
                <?php $attribute = 'class="search_input" title="Search by name "'; ?>
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
		<?php echo anchor('members/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Member')).'Add',array('class'=>'addbutton','title'=>'Add Member'));  ?>
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
                foreach ($members as $row):
                $i++;
        ?>
        <tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
                <td class="serial"><?php echo $i;?></td>
                <td><?php echo $row->code;?></td>
                <td><?php echo anchor('members/view/'.$row->id,$row->name);?></td>
                <td><?php echo $row->fathers_spouse_name;?></td>
                <td><?php if($row->gender=='F'):echo "Female"; else: echo "Male"; endif?></td>
                <td><?php echo $row->branch_name;?></td>
                <td><acronym title="<?php echo $row->samity_name?>"><?php echo character_limiter($row->samity_name,20)?></acronym></td>
                <td><?php echo anchor('members/view/'.$row->id,img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'View')),array('class'=>'imglink','title'=>'View'));   ?>
					<?php echo anchor('members/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
					<?php echo anchor('members/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
					array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
        </tr>
        <?php endforeach;?>
</table>
<div align="center" id="paging"> <?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
