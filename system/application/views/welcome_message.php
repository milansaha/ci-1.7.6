<html>
<head>
<title>Welcome to CodeIgniter Training session</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery.autocomplete.css" />
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.autocomplete.js"></script>
</head>
<body>

<h1>Welcome to training session</h1>

<h2>Auto Complete</h2><br/>

Example 1:<br/>
District Name: <?php echo form_input_autocomplete_text(array('id'=>"searchbox",'name'=>"searchbox", 'maxlength'=>"40" ,'size'=>"40"), site_url('po_districts/ajax_get_district_list_json'),'divisionResultCallback')?>
<script type="text/javascript">
$(document).ready(function() {
	divisionResultCallback = function(data) {
		alert('Selected Item => ID:'+data.id+', Name: '+data.name);
		//alert($("#searchbox").val());
	}
});
</script>
<br/>

Example 2:<br/>
District Name: <input type="text" id="district" />
<div id="district_details">No district selected yet</div>
<script type="text/javascript">
$(document).ready(function() {
	
		

		$("#district").autocomplete('<?php echo site_url("po_districts/ajax_get_district_list/")?>', {
			minChars: 0,
			width: 310,
			matchContains: "word",
			highlightItem: false,
			formatItem: function(row, i, max, term) {
				var tmp;
				tmp=row[0].split(",");
				return "<strong>"+tmp[1]+"</strong>" + "<br><span style='font-size: 80%;'>" + row[0] + "</span>";
			},
			
			formatResult: function(row) {
				var tmp;
				tmp=row[0].split(",");
				return tmp[1];
			}
		}).result(function(e, item) {
			//myCallback();
			var tmp;
			tmp=item[0].split(",");
			$("#district_details").html("<p>Selected District => <b>"+tmp[1]+"</b>, ID: "+tmp[0]+" </p>");
		});
});
</script>



</body>
</html>
