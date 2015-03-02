<h3><?php //echo $headline?></h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$current_status_options = array(''=>"---Loan Status---");
	foreach($current_status as $key=>$current_status_row)
	{					
		$current_status_options[$key]=$current_status_row;
	}
	$session_data=$this->session->userdata('loans.index');
	$attribute = 'class="search_input" title="Loan Id or Name or Code"'; 
	?>
<?php echo form_open('loans/index',array('id'=>'search_form','name'=>'search_form')); ?>
<div id="filter">
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>		
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>
			<td>
				<?php  echo form_dropdown('cbo_loan_status', $current_status_options, isset($session_data['cbo_loan_status'])?$session_data['cbo_loan_status']:""); ?>
			</td>			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>
	<div style="border:solid 0px red;float:right;width:auto;" class="buttons">
		<?php echo anchor('one_time_loan_accounts/add',img(array('src'=>base_url().'/media/images/add.png','border'=>'0','alt'=>'Add Loans')).'Add',array('class'=>'addbutton','title'=>'Add Loans'));  ?>
	</div>	
</div>

<table class="sortable" cellspacing="0px" cellpadding="0px">
<tr>
	<th width="5%">#</th>	
	<th width="10%">Loan Reg No</th>	
	<th width="5%">Member Code</th>	
	<th width="18%">Member Name</th>	
	<th width="5%">Loan Amount</th>
	<th width="5%">Total Repay Amount</th>
	<th width="8%">Int. Rate</th>
	<th width="5%">Disburse Date</th>
	<th width="5%">Repay Date</th>	
	<th width="5%">Status</th>
	<th width="7%">Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($one_time_loan_accounts as $row):
	$i++;
	$authorized = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
	$unauthorized = img(array('src'=>base_url().'media/images/dimed_ok.png','border'=>'0','alt'=>'OK'));	
?>
<tr <?php if($i % 2 == 0){ echo 'class="evenrow";'; echo ' bgcolor="#fff"';}else{echo 'class="oddrow"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td><?php echo $row->customized_loan_no;?></td>	
	<td><?php echo $row->member_code;?></td>	
	<td><?php echo $row->member_name;?></td>	
	<td align="right"><?php echo number_format($row->loan_amount,'2','.',',');?></td>
	<td align="right"><?php echo number_format($row->total_payable_amount,'2','.',',');?></td>
	<td align="center">
        <?php echo number_format($row->interest_rate,'2','.',',')." % ";
            if($row->interest_calculation_method == 'FLAT'){echo "F";}
            elseif($row->interest_calculation_method == 'DECLINING_METHOD'){echo "D";}
            else{echo $row->interest_calculation_method;}?>
    </td>
	<td align="center"><?php echo date('d/m/y', strtotime($row->disburse_date));?></td>
	<td align="center"><?php echo date('d/m/y', strtotime($row->first_repayment_date));?></td>	
	<td><?php if($row->is_authorized==0): echo $unauthorized; else: echo $authorized; endif;?></td>
	<td><?php echo anchor('loan_schedules/index/'.$row->id, img(array('src'=>base_url().'media/images/view.gif','border'=>'0','alt'=>'View Loan Schedule')),array('class'=>'imglink','title'=>'View loan with loan schedule'));?>
        <?php if($row->is_authorized==0): echo anchor('one_time_loan_accounts/edit/'.$row->id,img(array('src'=>base_url().'media/images/edit.gif','border'=>'0','alt'=>'edit')),array('class'=>'imglink','title'=>'Edit'));   ?>
        <?php echo anchor('one_time_loan_accounts/delete/'.$row->id, img(array('src'=>base_url().'media/images/delete.gif','border'=>'0','alt'=>'edit')),
              array('title'=>'Delete','class'=>'delete','onclick'=>"return confirm('" . DELETE_CONFIRMATION_MESSAGE . "')"));
         endif;
        ?></td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>