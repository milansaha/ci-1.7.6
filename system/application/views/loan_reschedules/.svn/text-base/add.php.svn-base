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

<h3><?php //echo $headline?></h3>
<?php 
	$samity_options = array(''=>"---Samity---");
	foreach($samities as $samity_row)
	{	
		$samity_options[$samity_row->id]=$samity_row->name;
	}
	$current_status_options = array(''=>"---Loan Status---");
	//foreach($current_status as $key=>$current_status_row)
	//{					
		//$current_status_options[$key]=$current_status_row;
	//}
	$session_data=$this->session->userdata('loan_reschedules.add');
	$attribute = 'class="search_input" title="Loan Id or Name or Code"'; 
	?>
<?php echo form_open('loan_reschedules/add',array('id'=>'search_form','name'=>'search_form')); ?>
	<table style="padding:0px;" cellspacing="0px" cellpadding="0px" border="0" class="filter">
		<tr>
			<td>
				<?php echo form_input('txt_name',set_value('txt_name',isset($session_data['name'])?$session_data['name']:""),$attribute);?>
			</td>		
			<td>
				<?php  echo form_dropdown('cbo_samity', $samity_options, isset($session_data['cbo_samity'])?$session_data['cbo_samity']:""); ?>
			</td>
			<!---
			<td>
				<?php  //echo form_dropdown('cbo_loan_status', $current_status_options, isset($session_data['cbo_loan_status'])?$session_data['cbo_loan_status']:""); ?>
			</td>
			-->			
			<td>
				<?php echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'filter_search_buttons'),'Search');?>
			</td>
		</tr>
	</table>

<?php if(!empty($loans)):?>
<br>
<br>
<table class="bluetableborder" cellspacing="0px" cellpadding="0px">
<tr class="bluetablehead05">
	<th width="5%" class="paddingleft05BottomBorder">#</th>	
	<th width="25%">Loan Reg No</th>	
	<th width="13%">Member Code</th>	
	<th width="19%">Member Name</th>	
	<th width="12%">Loan Amount</th>
	<th width="12%">Total Repay Amount</th>
	<!--<th width="8%">Int. Rate</th>-->
	<!--<th width="5%">Disburse Date</th>-->
	<!--<th width="5%">First Repay Date</th>-->
	<!--<th width="5%">Repay Freq.</th>-->
	<!--<th width="4%">No. Of Inst.</th>-->
	<!--<th width="5%">Status</th>-->
	<th width="14%">Action</th>
</tr>
<?php 
	$i=$counter;
	foreach ($loans as $row):
	$i++;
	$authorized = img(array('src'=>base_url().'media/images/button_ok.png','border'=>'0','alt'=>'OK'));
	$unauthorized = img(array('src'=>base_url().'media/images/button_fewer.png','border'=>'0','alt'=>'OK'));	
?>
<tr <?php if($i % 2 == 0){ echo 'class="paddingleft05BottomBorder";';}else{echo 'class="paddingleft05BottomBorder"';}?> >
	<td class="serial"><?php echo $i;?></td>
	<td class="paddingleft05BottomBorder" align="center"><?php echo $row->customized_loan_no;?></td>	
	<td class="paddingleft05BottomBorder" align="center"><?php echo $row->member_code;?></td>	
	<td class="paddingleft05BottomBorder" align="center"><?php echo $row->member_name;?></td>	
	<td class="paddingleft05BottomBorder" align="center"><?php echo number_format($row->loan_amount,'2','.',',');?></td>
	<td class="paddingleft05BottomBorder" align="center"><?php echo number_format($row->total_payable_amount,'2','.',',');?></td>
	<!--<td align="center"><?php echo number_format($row->interest_rate,'2','.',',')." % ".$row->interest_calculation_method;?></td>-->
	<!--<td align="center"><?php echo date('d/m/y', strtotime($row->disburse_date));?></td>-->
	<!--<td align="center"><?php echo date('d/m/y', strtotime($row->first_repayment_date));?></td>	-->
	<!--<td align="center"><?php echo $row->repayment_frequency;?></td>-->
	<!--<td align="center"><?php echo $row->number_of_installment;?></td>-->
	<!--<td><?php //if($row->is_authorized==0): echo $unauthorized; else: echo $authorized; endif;?></td>-->
	<td class="paddingleft05BottomBorder">
		<!--<?php //echo anchor('loan_reschedules/reschedules/'.$row->id, img(array('src'=>base_url().'media/images/view.png','border'=>'0','alt'=>'View Loan For Reschedule')),array('class'=>'imglink','title'=>'View loan For Reschedule'));?>-->
        <?php echo anchor('loan_reschedules/reschedules/'.$row->id,'Reschedule');?>
	</td>
</tr>
<?php endforeach;?>
</table>
<div align="center" id="paging"><?php echo $this->pagination->create_links(); ?></div>
<?php echo form_close(); ?>
<?php endif;?>
