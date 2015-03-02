<?php
//This defines the header type - Excel File
//Change the file name if you want
header("Content-Disposition: attachment; filename=ExcelExport.xls;");
header("Content-Type: application/ms-excel");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=windows-1252">
		<meta name=ProgId content=Excel.Sheet>
		<meta name=Generator content="Microsoft Excel 9">
		<!--[if gte mso 9]>
		<xml>
		<x:ExcelWorkbook>
		<x:ExcelWorksheets>
		<x:ExcelWorksheet>
		<?php //this line names the worksheet ?>
		<x:Name>Sheet1</x:Name>
		<x:WorksheetOptions>
		<?php //these 2 lines are what works the magic - the grid lines ?>
		<x:Panes>
		</x:Panes>
		</x:WorksheetOptions>
		</x:ExcelWorksheet>
		</x:ExcelWorksheets>
		</x:ExcelWorkbook>
		</xml>
		<![endif]-->
		<style><!--
			table{
				border: 1px solid;
				width:0%;
				width:auto;
			}

			table th{
				color: white;
				font-face:bold;
				background-color:gray;
			}
			table td{
			}
		-->
		</style>
	</head>
	<body>
		<div>
			<?php 
				//Displaying the content of the page
				echo $data; 
			?>
		</div>
	</body>
</html>
