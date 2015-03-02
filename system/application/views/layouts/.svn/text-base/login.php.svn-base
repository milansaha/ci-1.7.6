<?php
/**
 * Lumad CMS
 * Copyright (c)	2007, Jason A. Banico
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource		/systems/application/views/layouts/login.php
 * @copyright		Copyright (c) 2007, Jason A. Banico
 * @link			http://cakeforge.org/projects/lumad-cms/
 * @package			lumad-cms
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MicroFin360 <?php  if (!empty($title)) echo " | ".$title."";?></title>
<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>media/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery-ui-1.8.7.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/ddsmoothmenu-v.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/livevalidation_standalone.compressed.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script> 


<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

<title>User Authentication | Microfin360</title>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="headerTop">
				<div id="info">
					<!--<div id="areainfo"><p>Branch: <?php echo empty($user)?'?':$user['branch_name'];?><?php ?></p></div>
					<div id="dateinfo"><p><?php echo date("D, F d, Y");?></p></div>-->
				</div>
				<div id="rightTopMenu">
					<!--<div id="welcomeinfo"><p>Welcome <?php echo empty($user)?'?':$user['name'];?></p></div>
					<div id="rigthRightMenu"><ul><li><a href="<?php echo base_url();?>user_guide/" title="MFI MIS">Guide</a></li><li><?php echo anchor('/auths/logout','Password');?></li><li><?php echo anchor('/auths/logout','Logout');?></li></ul></div>-->
				</div>
			</div>
			<div id="headerBottom">
				
				
			</div>
		</div>
		<div id="">
			<div id="login_wrapbody" style="">
				<div id="topBody">
				
					<!-- Site Message -->
					<?php
						/*$error = $this->session->flashdata('error');
						if(!empty($error)) echo "<div class='message_head'><div class='error'>$error</div></div>";
						$warning = $this->session->flashdata('warning');
						if(!empty($warning)) echo "<div class='message_head'><div class='warning'>$warning</div></div>";
						$notice = $this->session->flashdata('notice');
						if(!empty($notice)) echo "<div class='message_head'><div class='notify'>$notice</div></div>";
						$information= $this->session->flashdata('information');
						if(!empty($information)) echo "<div class='message_head'><div class='info'>$information</div></div>";
						$success = $this->session->flashdata('success');
						if(!empty($success)) echo "<div class='message_head'><div class='message'>$success</div></div>";*/
						$message = $this->session->flashdata('message');
						if(!empty($message)) echo '<div style="border:solid 0px red;margin:0 auto;height:45px;width:500px;margin-top:5px;"><div class="message_head"><div class="login_message">'.$message.'</div></div></div>';
					?>
				
				<!-- Content -->
				<?php  if (!empty($content_for_layout)) echo $content_for_layout;?>
				</div>
			</div>
		</div>
		<div id="login_footer">
			<div id="wrapfooter">
				<div id="midFooter">
					<p>Copyright &copy; 2001-2010 <a href="http://www.datasoft-bd.com" target="_blank">DataSoft</a>. All rights reserved.</p>
				</div>
				<!-- end of rightFooter -->
			</div>
		</div>
	</div>
</body>
</html>