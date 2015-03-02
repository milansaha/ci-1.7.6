<?php echo anchor('saving_attendance_registers/add', 'Add Saving Attendance Register');?>
<table>
<tr>
        <th>S/N</th>
        <th>Branch Name</th>
        <th>Samity Name</th>
        <th>Product Name</th>
        <th>Member Name</th>
        <th>Attendance Status</th>
        <th>Date</th>
        <th>Action</th>
</tr>
<?php
        $i=$counter;
        foreach ($saving_attendance_register as $row):
        $i++;
?>
<tr>
        <td><?php echo $i;?></td>
	
        <td><?php echo $row->branch_name;?></td>
        <td><?php echo $row->samity_name;?></td>
        <td><?php echo $row->product_name;?></td>
        <td><?php echo $row->member_name;?></td>
        <td><?php echo $row->attendance_status;?></td>
        <td><?php echo $row->date;?></td>
        <td><?php echo anchor('saving_attendance_registers/edit/'.$row->id, 'Edit');?> <?php echo anchor('saving_attendance_registers/delete/'.$row->id, 'Delete',array('class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));?></td>
</tr>
<?php endforeach;?>
</table>
<br/><br/>
<div align="center"><?php echo $this->pagination->create_links(); ?></div>
