<?php
/** 
 * Sectoral Highlight
 * Copyright 2008-2009, DataSoft Systems Bangladesh Limited (http://www.datasoft-bd.com)
 *
 * Redistributions of files is not allowed without written permission from DataSoft.
 *
 * @filesource    \app\views\reports\sector_highlight.php
 * @copyright     Copyright 2008-2009, DataSoft Systems Bangladesh Limited (http://www.datasoft-bd.com)
 * @link          http://www.datasoft-bd.com
 * @package       mra-mfi-mis
 * @since         mra-mfi-mis v 0.1
 * @version       $Revision: 1167 $
 * @author        $Author: Saroj Roy
 * @modifiedby    $LastChangedBy: Taufiqul Islam
 * @lastmodified  $Date: 2008-12-18 18:16:01 (Thu, 18 Dec 2008) $
 * @license       Commercial License
 */
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<!--  Version: Multiflex-3 Update-2 / Layout-1             -->
<!--  Date:    November 29, 2006                           -->
<!--  Author:  G. Wolfgang                                 -->
<!--  License: Fully open source without restrictions.     -->
<!--  Please keep footer credits with a link to   -->
<!--  G. Wolfgang (www.1-2-3-4.info). Thank you!  -->

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="3600" />
  <meta name="revisit-after" content="2 days" />
  <meta name="robots" content="index,follow" />
  <meta name="publisher" content="notepad++" />
  <meta name="copyright" content="Copyright DataSoft Systems Bangladesh Limited. All right reserved." />
  <meta name="author" content="Design: Saroj Roy , Author: Saroj Roy" />
  <meta name="distribution" content="global" />
  <meta name="description" content="MRA MFI MIS" />
  <meta name="keywords" content="MRA,MFI,MIS" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/layout1_setup.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/layout1_text.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/report.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery-ui-1.8.7.custom.css" />
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>media/images/favicon.ico" />
  <script type="text/javascript" src="<?php echo base_url();?>media/js/jquery-1.3.2.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>media/js/jquery-ui-1.8.7.custom.min.js"></script>
  <title>Microfin 360 <?php  if (!empty($headline)) echo " | ".$headline."";?> </title>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>
  <!-- Main Page Container -->
  <div class="page-container">

   <!-- For alternative headers START PASTE here -->

    <!-- A. HEADER -->      
    <div class="header">
      
      <!-- A.1 HEADER TOP -->
      <div class="header-top">
        
        <!-- Sitelogo and sitename -->
        <a class="sitelogo" href="#" title="Go to Start page"></a>
        <div class="sitename">
          <h1><a href="<?php echo base_url();?>" title="MFI MIS">Microfin360 &bull; V-0.1</a></h1>
          <h2>Microfinance..</h2>
        </div>
        
		<!-- Navigation Level 0 -->
        <div class="nav0">
			<div style="float:right;padding-right:20px; color:#000000; font-size:11px;">
			<?php 
				$user=$this->session->userdata('system.user');
				if (!empty($user)){
					$welcomeMessage= "Welcome <b>".$user['name']."</b>. [ ".date("D, F d, Y")." ".date("h:i a")."]";
					$welcomeMessage="<i>".$welcomeMessage."</i>";
					echo $welcomeMessage;
				}
			?>
			</div>
			<div style="float:right;padding-right:20px; color:#ffffff; font-size:11px;">
			<?php 
				//$selected_mfi=$session->read('SELECTED_MFI'); 
				//if (!empty($selected_mfi)){
				//	echo "<i>Working MFI: <b>".$selected_mfi['Mfi']['name']."</b></i>";
				//}
			?>
			</div>
        </div>		

        <!-- Navigation Level 1 -->
        <div class="nav1">
          <ul>
            <li><a href="<?php echo base_url();?>user_guide/" title="MFI MIS">CI Guide</a></li>
			<li><?php echo anchor('/users/change_password','Change Password');?></li>
			<li><?php echo anchor('/users/logout','Logout');?></li>
          </ul>
        </div>
			
		
      </div>
  
	<!-- A.3 HEADER BOTTOM -->
      <div class="header-bottom">
      
        <!-- Navigation Level 2 (Drop-down menus) -->
        <div class="nav2">
			<?php //echo $this->renderElement('main_menu'); ?>
			<?php $this->load->view('/elements/main_menu');?>			
        </div>
	  </div>

      <!-- A.4 HEADER BREADCRUMBS -->

      <!-- Breadcrumbs -->
	 
      <div class="header-breadcrumbs">
	  </div>
	
    </div>

   <!-- For alternative headers END PASTE here -->

    <!-- B. MAIN -->
    <div class="main">  
      <!-- B.1 MAIN CONTENT -->
      <div class="main-content">        
        <!-- Pagetitle -->
        <?php  if (!empty($headline)) echo "<h1 class='pagetitle'>".$headline."</h1>";?>
		<!-- Site Message -->
		<!-- Modified by Matin(coder.matin@gmail.com)-->
		<?php $message=$this->session->flashdata('message');
			if(!empty($message)):
		?>
			<!-- <div style="color:red; border: 1px solid black; padding:3px;margin-right:10px;background:"> -->
			<div class="message">
				<?php echo $message;?>		
			</div>
		<?php endif;?>	
		<!-- Content -->        
		<?php  if (!empty($content_for_layout)) echo $content_for_layout;?>
        
      </div>
    </div>
      
    <!-- C. FOOTER AREA -->      

    <div class="footer">
      <p>Copyright &copy; 2009 DataSoft Systems Bangladesh Limited | All Rights Reserved</p>
      <p class="credits">Design and Development by <a href="www.datasoft-bd.com" title="DataSoft Systems Bangladesh Limited">DataSoft</a></p>
    </div>      
  </div> 
  
</body>
</html>



