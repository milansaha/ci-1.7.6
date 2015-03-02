<style>
	label {
	    display: block;
	    float: left;
	    height: 20px;
	    width: 35%;
	    font-weight: bold;
	}
	ol li {
		min-height: 20px!important;
	}
</style>
<?php if(isset($config_id)){
	$row=$config_id;
?>
<h2><?php echo $headline?> :</h2>
<fieldset>
<div id="execute_div">
	<div id="execute_link">
		<?php if(isset($config_id)){?>
			<?php echo anchor('/config_customized_ids/edit/'.$config_id->id,'Edit configuration')?>
		<?php } else{?>
			<?php echo anchor('/config_customized_ids/add/','Add Configuration')?>
		<?php }?>
	</div>
</div>	
	<table class="uiInfoTableConfig" width="650px" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr><th colspan="5">Branch (<?php 
								if($row->branch_code_length){
									for($i=0;$i<$row->branch_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
					
						?>)</th></tr>
			<tr>
				<td width="20%" align="center"><label for="txt_name">Is branch code need?<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">Branch code length:<em></em></label></td>
				<td width="20" align="center"><label for="cbo_group">&nbsp;<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_sub_group">&nbsp;<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_sub_group">&nbsp;<em></em></label></td>
			</tr>
			<tr>
				<td align="center">	
					<span><?php if($config_id->is_branch_code_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>				
				<td align="center">	
					<span><?php echo $config_id->branch_code_length;?></span>
				</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr class="spacer"><td colspan="5"></td></tr>
		</tbody>
		
		
		<tbody>
			<tr><th colspan="5">Samity
				(<?php 
								if($row->is_samity_code_need=='1'){
									for($i=0;$i<$row->samity_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
									echo $row->samity_code_separator;
								
								if($row->is_product_code_for_samity=='1'){									
									 echo '102';
									}
									echo $row->samity_code_separator;
								
								if($row->is_samity_product_fundname_need=='1'){									
									 echo 'PKSF';
									 echo $row->samity_code_separator;
									}
									
								if($row->is_include_branch_code_for_samity=='1'){
									for($i=0;$i<$row->branch_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
					
						?>)
			</th></tr>
			<tr>
				<td width="20%" align="center"><label for="cbo_group">Is samity code need?<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_sub_group">Samity code length:<em></em></label></td>
				<td width="20%" align="center"><label for="txt_name">Is include branch code for samity?<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">Samity code separator:<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">Is fund name : <em></em></label></td>
			</tr>
			<tr>
				<td align="center">
					<span><?php if($config_id->is_samity_code_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>
				<td align="center">
					<span><?php echo $config_id->samity_code_length?></span>
				</td>
				<td align="center">	
					<span><?php if($config_id->is_include_branch_code_for_samity=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>				
				<td align="center">	
					<span><?php	echo $config_id->samity_code_separator?></span>
				</td>
				<td align="center"><?php if($config_id->is_samity_product_fundname_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>		
			</tr>
			<tr class="spacer"><td colspan="5"></td></tr>
		</tbody>
		
		
		<tbody>
			<tr><th colspan="5">Member Code(<?php 
								if($row->is_member_code_need=='1'){
									for($i=0;$i<$row->branch_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
									echo $row->member_code_separator;
								
								if($row->is_samity_code_need=='1'){
									for($i=0;$i<$row->samity_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
									echo $row->member_code_separator;									
								
								if($row->is_member_code_need=='1'){
									for($i=0;$i<$row->member_code_length-1;$i++){
											echo '0';
										}
									 echo '1';
									}
					
						?>)</th></tr>
			<tr>
				<td width="20%" align="center"><label for="cbo_group">Is member code need?<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_sub_group">Member code length:<em></em></label></td>
				<td width="20%" align="center"><label for="txt_name">Is include samity code for member:<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">Is include branch code for member:<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_group">Member code separator?<em></em></label></td>
				
			</tr>
			<tr>
				<td align="center">
					<span><?php if($config_id->is_member_code_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>
				<td align="center">
					<span><?php echo $config_id->member_code_length?></span>
				</td>
				<td align="center">	
					<span><?php if($config_id->is_include_samity_code_for_member=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>				
				<td align="center">	
					<span><?php if($config_id->is_include_branch_code_for_member=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>
				<td align="center">
					<span><?php echo $config_id->member_code_separator?></span>
				</td>
			</tr>
			<tr class="spacer"><td colspan="5"></td></tr>
		</tbody>
		
	<tbody>
			<tr><th colspan="5">Savings Id Code(<?php 
								if($row->is_saving_code_need=='1'){
									echo '201';
									echo $row->savings_code_separator;
								
								if($row->is_saving_product_short_name_need=='1'){
									echo 'COM';
									echo $row->savings_code_separator;
								}								
								
								if($row->is_include_member_code_for_savings=='1'){										
										
										if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->branch_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;
											
											if($row->is_samity_code_need=='1'){
												for($i=0;$i<$row->samity_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;									
											
											if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->member_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
									
									}
								}
					
						?>)</th></tr>
			<tr>
				<td width="20%" align="center"><label for="cbo_sub_group">Is product code need:<em></em></label></td>
				<td width="20%" align="center"><label for="txt_name">Is include member code for savings:<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">Savings code separator?<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">&nbsp;<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">&nbsp;<em></em></label></td>
			</tr>
			<tr>
				<td align="center">
					<span><?php if($config_id->is_saving_code_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>
				<td align="center">	
					<span><?php if($config_id->is_include_member_code_for_savings=='1') {echo 'Yes' ;}else{echo 'No';} ?></span>
				</td>				
				<td align="center">	
					<span><?php echo $config_id->savings_code_separator?></span>
				</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr class="spacer"><td colspan="5"></td></tr>
		</tbody>
		
		<tbody>
			<tr><th colspan="5">Loan Id Code(<?php 
								if($row->is_loan_code_need=='1'){
									echo '101';
									echo $row->loan_code_separator;
								
									if($row->is_loan_product_fundname_need=='1'){
									echo 'PKSF';
									echo $row->loan_code_separator;
								}	
								
								if($row->is_loan_product_short_name_need=='1'){
									echo 'RMC';
									echo $row->loan_code_separator;
								}							
								
								if($row->is_include_member_code_for_loan=='1'){										
										
										if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->branch_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;
											
											if($row->is_samity_code_need=='1'){
												for($i=0;$i<$row->samity_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												echo $row->member_code_separator;									
											
											if($row->is_member_code_need=='1'){
												for($i=0;$i<$row->member_code_length-1;$i++){
														echo '0';
													}
												 echo '1';
												}
												
											echo $row->loan_code_separator;
									
									}
									
									if($row->is_cycle_need=='1'){
											echo '1';
											
										}	
								}
					
						?>)</th></tr>
			<tr>
				<td width="20%" align="center"><label for="cbo_group">Is product code need:<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_sub_group">Is include member code for loan:<em></em></label></td>
				<td width="20%" align="center"><label for="txt_name">Is cycle need?<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_samity">Loan code separator:<em></em></label></td>
				<td width="20%" align="center"><label for="cbo_group">&nbsp;<em></em></label></td>
			</tr>
			<tr>
				<td align="center">
					<span><?php if($config_id->is_loan_code_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>
				<td align="center">
					<span><?php if($config_id->is_include_member_code_for_loan=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>
				<td align="center">	
					<span><?php if($config_id->is_cycle_need=='1') {echo 'Yes' ;}else{echo 'No';}?></span>
				</td>				
				<td align="center">	
					<span><?php echo $config_id->loan_code_separator?></span>
				</td>
				<td align="center">&nbsp;</td>
			</tr>
			<tr class="spacer"><td colspan="5"></td></tr>
		</tbody>	
    </table>
</fieldset>
<?php } ?>
