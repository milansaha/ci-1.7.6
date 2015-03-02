<?php
echo form_open('po_zone_area_details/edit');
echo form_hidden('po_zone_area_detail_id',$row->id);
//print_r($row);die;
?>
<fieldset>
	<legend>
		Edit PO Zone Area Details
	</legend>
	<ol>  
		<li>
			<label for="cbo_zones">Zone:<em>&nbsp;</em></label>			
			<?php 
				//print_r($pos);
				$options = "";
				foreach($po_zone_infos as $po_zone_info)
				{					
					$options[$po_zone_info->po_zone_id]=$po_zone_info->po_zone_name;
				}
				echo form_dropdown('cbo_zones', $options, $row->zone_id); 
			?>			
		</li> 
		<li>
			<label for="cbo_areas">Area:<em>&nbsp;</em></label>			
			<?php 
				//print_r($pos);
				$options = "";
				foreach($po_area_infos as $po_area_info)
				{					
					$options[$po_area_info->po_area_id]=$po_area_info->po_area_name;
				}
				echo form_dropdown('cbo_areas', $options, $row->area_id); 
			?>			
		</li> 		
		<li>			
			<?php echo form_submit('submit','Save');?>
		</li>
	</ol>
</fieldset>
<?php 
echo form_close();
?>
