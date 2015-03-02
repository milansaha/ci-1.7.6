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
<style>
/*.config_head{background-color: #CDCDCD;border-bottom: 1px dotted #BFBFBF;
    color: #000000;font-family: Verdana,Arial,Helvetica,sans-serif;font-size: 13px;
    font-weight: bold;padding: 5px;text-align: left;}
	.loans{margin:0px; padding:0px;}
.loans li{border:solid 1px red;width:25%;}
.uiInfoTableConfig {
    background-color: #F2F2F2;
    border: 1px solid #DDDDDD;
    width: 950px;
}.uiInfoTableConfig td{padding:3px 0px 0px 5px;margin: 5px 0 0;}
.uiInfoTableConfig th{        background-color: #CDCDCD;
    border-bottom: 1px dotted #BFBFBF;
    color: #000000;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    font-size: 13px;
    font-weight: bold;
    padding: 5px;
    text-align: left;}
.uiInfoTableConfig label{width:100%;    border-bottom:none;
    color: #666666;
    display: block;
    float: left;
    font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
    font-size: 11px;
    font-weight: bold;
    margin: 0 6px 0 0;
    padding: 1px 1px 1px 2px;
    text-align: center;height:auto;}
.uiInfoTableConfig .label {
    color: #666666;
    font-weight: bold;
    padding-right: 10px;
    text-align: right;
    width: 130px;
	
}
.uiInfoTableConfig input {background-color: white;
    border: 1px solid #BDC7D8;
    color: #262626;
    font-family: 'Trebuchet MS',Verdana,Arial,Helvetica,sans-serif;
    font-size: 11px;
    padding: 0;
    width: auto;
}
.uiInfoTableConfig em{color:red;}
.uiInfoTableConfig input[type="file"] {border: 1px solid #BDC7D8;}
.uiInfoTableConfig input[type="submit"] {   
    -moz-border-radius: 0px 0px 0px 0px;
    background: -moz-linear-gradient(center top , #3E779D, #65A9D7) repeat scroll 0 0 transparent;
    border-top: 1px solid #96D1F8;
    border-bottom: 1px solid #2F5975;
    border-right: none;
    border-left: none;
    color: white;
    font-family: Georgia,Serif;
    font-size: 12px;
    padding: 5px 13px;
    text-decoration: none;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
    vertical-align: middle;margin: 0 0 0 0%;
	width:auto;font-family: 'Trebuchet MS',Verdana,Arial,Helvetica,sans-serif;
border-left: 1px solid #DEDEDE;border-right: 1px solid #DEDEDE; width:90px; background:url(../images/submit_button.png) repeat center center transparent; padding:5px 10px 5px 10px;font-family: verdana,arial,tahoma,times New Roman;text-align: left;cursor:pointer;
}
.uiInfoTableConfig select {
    border: 1px solid #BDC7D8;
    color: #262626;
    font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
    font-size: 11px;
    padding: 0;
    width: 100px;
}
.uiInfoTableConfig hr {
    background: none repeat scroll 0 0 #D9D9D9;
    border-width: 0;
    color: #D9D9D9;
    height: 1px;
}
.uiInfoTableConfig .dataRow .label {
    padding-top: 8px;
}
.uiInfoTableConfig .spacer td {
    padding: 5px 0;
}
.aaa { background: none; padding:0px 0px 10px 0px; }
.bbb { background: #9cf; padding:0px 0px 10px 0px; }
.uiInfoTableConfig div.error {
    -moz-border-radius: 0 0 5px 5px;
    background: url("<?php echo base_url();?>media/images/error.png") no-repeat scroll 9px 4px #FFA89B;
    border: 1px solid #911200;
    color: #BE2E17;
    font-family: verdana;
    font-size: 10px;
    margin: 0 0 3px 0;
    padding: 3px 5px 4px 26px;
    text-align: left;
    width: 148px;
}
input[readonly] { background: #ccc; color: #666; }*/
</style>
<?php //print_r($row);
//echo '<br/>';

if($row[0]['old_value'] !=''){
	$oldvalue = json_decode($row[0]['old_value']);  
	//print_r($oldvalue);
}
//echo '<br/>';

if($row[0]['new_value']!=''){	
	$newvalue = json_decode($row[0]['new_value']); 
	//print_r($newvalue);	
}

?>
<fieldset>
	<h3><?php echo $title?> :</h3>
	<table class="uiInfoTableConfig" width="650px" border="0" cellspacing="0px" cellpadding="0px">
		<tbody>
			<tr><th colspan="2">Action : <?php echo strtoupper($row[0]['action']);?></th></tr>
			<tr>
				<td width="20%" align="left" class="field-label"><b>By:</b></td>
				<td class="field-items"><?php echo $row[0]['user_name'];?></td>
			</tr> 
			<tr>
				<td width="20%" align="left" class="field-label"><b>Date:</label></td>
				<td class="field-items"><?php echo date('d/m/Y- h:i:s A',$row[0]['time_stamp']);?></td>
			</tr>	
			<tr>
				<td width="20%" align="left" class="field-label"><b>Branch Name:</label></td>
				<td class="field-items"><?php echo get_formated_table_name($row[0]['branch_name']);?></td>	
			</tr>
			<tr>
				<td width="20%" align="left"class="field-label" ><b>Entity:</label></td>
				<td class="field-items"><?php echo get_formated_table_name($row[0]['table_name']);?></td>	
			</tr>
				
			<tr>
				<td width="20%" align="left" valign="top"><b>
				<?php 
				if($row[0]['action']=='delete'){
								echo "Old Value :";
					}
					else if($row[0]['action']=='insert'){
								echo "New Value :";						
					}
				?>
					</b></td>
				<td><?php 
				if($row[0]['action']=='delete' && isset($oldvalue)){							
							foreach($oldvalue as $okey){				
								foreach($okey as $oldarr=>$oldarrval){
									echo '<b>'.$oldarr.'</b>:'.$oldarrval.'<br/>' ;
								}		
							}

					}
					else if($row[0]['action']=='insert' && isset($newvalue)){							
							foreach($newvalue as $key=>$val){
									echo '<b>'.$key.'</b>:'.$val.'<br/>' ;
								}
						
						}
					?>
							
				</td>
			</tr>
			<?php 
				if($row[0]['action']=='update'){	
					if(isset($oldvalue) && isset($newvalue)){				
						foreach($oldvalue as $okey){				
								foreach($okey as $oldarrkey=>$oldarrval){									
									$oldarr[$oldarrkey]=$oldarrval;
								}		
						}

						foreach($newvalue as $nkey=>$nval){							
								$newarr[$nkey]=$nval;
							}
					
						//print_r($oldarr);
						//echo '<br/>';
						//print_r($newarr);
						$result = array_diff($oldarr, $newarr);
					
				}
			?>
			<tr>
				<td width="20%" align="left" valign="top"><b>Change:</b></td>
				<td align="left">
				<?php 
					if(isset($result)){
				?>
					<table border='0' style="width:650px;" cellspacing="0" cellpadding="0" class="uiInfoTableConfig">
						<tr>
							<td class="field-title"><b>Column</b></td>
							<td class="field-title"><b>Old Value</b></td>
							<td class="field-title"><b>New value</b></td>
						</tr>
					<?php 						
							foreach($result as $rkey=>$rval){
								
					?>
					<tr>
						<td class="field-values"><?php echo $rkey;?></td>
						<td class="field-values"><?php echo isset($oldarr[$rkey])?$oldarr[$rkey]:'&nbsp;';?></td>
						<td class="field-values"><?php echo isset($newarr[$rkey])?$newarr[$rkey]:'&nbsp;';?></td>			
					</tr>								
					<?php 
							}
						
					?>
					</table>
					<?php 
					}else{
							echo 'No change!!!';
						}						
					?>
					</td>
			</tr>
				<?php }?>
		</tbody>	
				
    </table>
</fieldset>
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

