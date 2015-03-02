<?php
$options_branch_name = "";
        foreach($branch_infos as $branch_info)
        {
                $options_branch_name[$branch_info->branch_id]=$branch_info->branch_name;
        }
$options_product_name = "";
        foreach($product_infos as $product_info)
        {
                $options_product_name[$product_info->product_id]=$product_info->product_name;
        }
$options_member_name = "";
        foreach($member_infos as $member_info)
        {
                $options_member_name[$member_info->member_id]=$member_info->member_name;
        }
$options_samity_name="";
        foreach($samity_infos as $samity_info)
        {
                $options_samity_name[$samity_info->samity_id]=$samity_info->samity_name;
        }

echo form_open('saving_advance_registers/add');
?>
<fieldset>
	<legend>
		Add Saving Advance Register
	</legend>
	<ol>  
		<li>
			<label for="cbo_branch">Branch Name:<em>&nbsp;</em></label>			
			<?php 
				//print_r($pos);
				echo form_dropdown('cbo_branch', $options_branch_name);  
			?>
		</li>
		<li>
			<label for="cbo_product">Product Name:<em>&nbsp;</em></label>			
			<?php	
				//print_r($pos);
				echo form_dropdown('cbo_product', $options_product_name); 
			?>			
		</li>
		<li> 
			<label for="cbo_member">Member Name:<em>&nbsp;</em></label>			
			<?php	
				//print_r($pos);
				echo form_dropdown('cbo_member', $options_member_name); 
			?>			
		</li>
		<li> 
			<label for="cbo_samity">Samity Name:<em>&nbsp;</em></label>			
			<?php	
				//print_r($pos);
				echo form_dropdown('cbo_samity', $options_samity_name); 
			?>			
		</li> 
		<li>
			<label for="txt_amount">Amount:<em>&nbsp;</em></label>
			<?php echo form_input('txt_amount',set_value('txt_amount'));?><?php echo form_error('txt_amount'); ?>
		</li>  
		<li>
			<label for="txt_amount_type">Amount Type:<em>&nbsp;</em></label>
		<?php
			foreach($amount_types as $amount_type)
                                {
                                        $options[$amount_type]=$amount_type;
                                }
			 echo form_dropdown('cbo_amount_type', $amount_types);	
	        ?>
		</li>  
		<li>
			<label for="txt_date">Date:<em>&nbsp;</em></label>
			<?php echo form_input('txt_date',set_value('txt_date'));?><?php echo form_error('txt_date'); ?>
		</li>  
		<li>			
			<?php echo form_submit('submit','Save');?>
		</li>
	</ol>
</fieldset>
<?php 
echo form_close();
?>
