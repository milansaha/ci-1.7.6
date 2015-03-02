<?php
$browser='';
$version='';
$browsers = array("firefox", "msie", "opera", "chrome", "safari", "mozilla", "seamonkey", "konqueror", "netscape",
                  "gecko", "navigator", "mosaic", "lynx", "amaya","omniweb", "avant", "camino", "flock", "aol");

foreach($browsers as $browser)
{
	if (preg_match("#($browser)[/ ]?([0-9.]*)#", strtolower($_SERVER['HTTP_USER_AGENT']), $match))
	{
		$browser = $match[1] ;
		$version = $match[2] ;
		break ;
	}
}
?>
<style>
	#jsenable{-moz-border-radius: 4px 4px 4px 4px;width:700px;border:1px solid #F0F015;height:auto;margin:0 auto;}
	#jsenable_title{text-align:left;border:1px solid #E7E616;height:auto;padding:8px 15px 8px 70px;margin:0px;background:url(http://localhost/microfin//media/images/dashboard_images/errormsgicon28_128.gif) no-repeat 20px 5px #FFFFC1;font-size: 16px;}
	#jsenable_body{border-bottom: 1px solid #E7E616;border-left: 1px solid #E7E616;border-right: 1px solid #E7E616;height:auto;padding:3px 20px 5px 25px;margin:0px;background:url(http://localhost/microfin//media/images/dashboard_images/javaScriptIcon.gif) no-repeat left center;font-family:'Trebuchet MS',Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:normal;line-height:1.75em;text-align: left;}
	#jsenable_body div{padding:20px 0px 20px 10px;margin: 0 0 0 130px;}
	#jsenable_body h4{padding:0px 0px 12px 0px;margin:0px;font-size:14px;}
	#jsenable_body p{padding:5px 12px 5px 0px; margin:0px;}
	#jsenable_body a{color:#4e4e4e;text-decoration:underline;}
	#jsenable_body a:hover{color:#000;text-decoration:none;}
	#jsenable_body ul{ margin:0px; padding:0px 0px 22px 14px;}
	#jsenable_body ul li{list-style-type: square; text-decoration:none;color:#3B5998;float: left;margin: 0 30px 0 0;}
	#jsenable_body ul li a{text-decoration:none;color:#3B5998;cursor: pointer;}	
</style>
<div style="margin-top:35px;">
<div id="jsenable">
<div style="/*background:url(http://localhost/microfin//media/images/dashboard_images/ui-bg_diagonals-thick_18_b81900_40x40.png) repeat 12px 5px*/">
<h2 id="jsenable_title">JavaScript Disable</h2>
</div>
<div id="jsenable_body">
	<div>
		<h4>JavaScript is required for this site to work correctly but is either disabled or not supported by your browser.</h4>
		<p>
		Have you disabled JavaScript? If you have disabled JavaScript, you must re-enable JavaScript to use this page. <a href='http://cappuccino.org/noscript/'>Show me how to enable JavaScript</a>
		</p>
		<p><?php if(!empty($browser)) echo "Your are currently using <strong>$browser $version</strong>.";?>
		You may want to upgrade to a newer browser while you're at it:<br/>
			<ul>
				<li><a href="http://www.apple.com/safari/download/" target="_blank">Safari</a></li>
				<li><a href="http://www.mozilla.com/" target="_blank">Firefox</a></li>
				<li><a href="http://www.google.com/chrome" target="_blank">Chrome</a></li>
			</ul>
		</p>
	</div>
</div>
</div>
</div>
