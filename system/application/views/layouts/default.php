<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!-- Redirecting if javascript is not enabled -->
<noscript>
	<?php if($this->uri->segment(2)!='enable_javascript'): ?>
	<meta http-equiv="refresh" content="1; URL=<?php echo site_url('/pages/enable_javascript')?>">
	<?php endif;?>
</noscript>
<!--[if lte IE 6]>
<script type="text/javascript">
function correctPNG() 	// correctly handle PNG transparency in Win IE 5.5 & 6
{
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1])
   if ((version >= 5.5) && (document.body.filters)) 
   {
      for(var i=0; i<document.images.length; i++)
      {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
         {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText 
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }    
}
window.attachEvent("onload", correctPNG);
</script>
<![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MicroFin360 <?php  if (!empty($title)) echo " | ".$title."";?></title>
<base href="<?php echo base_url();?>">
<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>media/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/jquery-ui-1.8.7.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/js/simplemodal/basic.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/live-validation.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/live-validation.css" />
<script type="text/javascript" src="<?php echo base_url();?>media/js/livevalidation_standalone.compressed.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jacs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/simplemodal/jquery.simplemodal.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>media/js/jquery.bgiframe.js"></script>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/css/chromestyle2.css" />-->
<script type='text/javascript'>
var base_url = '<?php echo base_url();?>';
</script>
<!--<script type="text/javascript" src="<?php echo base_url();?>media/js/chrome.js">
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
**********************************************/
</script>-->
<script type="text/javascript" src="<?php echo base_url();?>media/js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script> 
<script type="text/javascript">
$(document).ready(function() 
	{ 
		$('#smoothmenu1').find('ul').bgIframe({opacity:false}); 
	});
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
<!-- For filter  data -->
<script type="text/javascript">
//date time picker function
//author: Saroj Roy
//created on: 29/03/2011
(function( $ ){
	$.fn.datepicker = function() {
		this.click(function() {
			JACS.show(this,this);
		});
	};
})( jQuery );

</script>
<script type="text/javascript">
/**
* For filter the data
* @author Remy Sharp
* @url http://remysharp.com/2007/01/25/jquery-tutorial-text-box-hints/
*/
(function ($) {
$.fn.hint = function (blurClass) {
  if (!blurClass) { 
    blurClass = 'blur';
  }
  return this.each(function () {
    // get jQuery version of 'this'
    var $input = $(this),

    // capture the rest of the variable to allow for reuse
      title = $input.attr('title'),
      $form = $(this.form),
      $win = $(window);
	  
    function remove() {
      if ($input.val() === title && $input.hasClass(blurClass)) {
        $input.val('').removeClass(blurClass);
      }
    }

    // only apply logic if the element has the attribute
    if (title) { 
      // on blur, set value to title attr if text is blank
      $input.blur(function () {
        if (this.value === '') {
          $input.val(title).addClass(blurClass);
        }
      }).focus(remove).blur(); // now change all inputs to title
      
      // clear the pre-defined text when form is submitted
      $form.submit(remove);
      $win.unload(remove); // handles Firefox's autocomplete
    }
  });
};

})(jQuery);

$(function(){ 
			    // find all the input elements with title attributes
				//$('input[title!=""]').hint(); 
				$('.search_input[title!=""]').hint(); 
			});

</script>
<!-- End of filter  data -->

<!-- Floating print menu bar -->
<style>
</style>
<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	//scroll the message box to the top offset of browser's scrool bar
	$(window).scroll(function()
	{
  		$('#global_print_menu').animate({top:($(window).scrollTop() + $(window).height()-$('#global_print_menu').height()-10)+"px" },{queue: false, duration: 350});
  		
	});
});
</script>
<!-- Floating bar -->
</head>
<?php
	//Loading user information from the session
	$user=$this->session->userdata('system.user');
	$current_date=$this->session->userdata('system.software_date');
?>
<body>
	<div id="wrapper">
		<div id="global_print_menu" style='display:none'>
			<div style="width:400px;height:auto;text-align:center;margin:0 auto;">
			<ul id="float_bar_menu">
				<li id="printer">
					<?php echo anchor('reports/show_print_friendly','Print',array('onclick'=>'show_print_friendly();return false;','class'=>'context-links printer','alt'=>'','title'=>'Print')); ?>
				</li>
				<li id="execlsave">
					<?php echo anchor('reports/export_to_excel','Export to Execl',array('onclick'=>'export_to_excel();return false;','class'=>'context-links execl','alt'=>'','title'=>'Export to Excel')); ?>
				</li>
				<li id="fullscreener">
					<?php echo anchor('#','Full Screen',array('onclick'=>'full_screen();return false;','class'=>'context-links full-screen','id'=>'link_full_screen')); ?>
				</li>
			</ul>				
				<?php echo form_open('reports/show_print_friendly',array('id'=>'print_form','target'=>'_blank'));?>
				<input type="hidden" name="report_data" id="report_data" value="">
				<?php echo form_close(); ?>
			</div>
		</div>
		<div id="header">				
			<div id="headerTop">
				<div id="info">
					<div id="areainfo"><p>Branch: <?php echo empty($user['branch_name'])?'?':$user['branch_name'];?><?php ?></p></div>
					<div id="dateinfo"><p><?php echo date("D, F d, Y",strtotime( $current_date['current_date']));?></p></div>
					<div id="global-ajax-loader" style=" display:none;float: left;
    height: 15px;
    padding: 5px 5px 0;
    width: 50px;"><img src="<?php echo base_url();?>/media/images/ajax-loader-small.gif" border="0" vspace="0px" hspace="0px" /></div>
				</div>
				<div id="rightTopMenu">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td align="right"><div id="welcomeinfo"><p>Welcome <?php echo empty($user)?'?':$user['name'];?></p></div></td>
							<td align="right" width="160px">
								<div id="rigthRightMenu">
									<ul>
										<li><a href="<?php echo base_url();?>user_guide/" target = "_blank" title="Help">Help</a></li>
										<li><?php echo anchor('/users/change_password','Password');?></li>
										<li><?php echo anchor('/auths/logout','Logout');?></li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="headerBottom">
				<div id="logo">
					<div style="float:left;"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>/media/images/microfin_logo.png" width="61" border="0" vspace="0px" hspace="0px" /></a></div>
					<div style="float:left;color:#DFDFDF;font-size:24px;font-weight:bold;margin:15px 0px 0px 0px;padding: 0 0 0 4px;text-align:center;text-shadow: 0px 2px 3px #252525;">Microfin360</div>
				</div>
				<div id="topmenu">
					<div id="smoothmenu1" class="ddsmoothmenu">
						<?php if(!isset($is_menu_disabled)):?>
							<?php $this->load->view('/elements/main_menu');?>
						<?php endif;?>
						<br style="clear: left" />
					</div>
				</div>				
			</div>
		</div>
		
		<div id="mainbody">
			<div id="wrapbody">
				<div id="topBody">
					<div id="breadcam" >
							<div id="locator">
								<ul>
									<li><b>You are here: </b></li>
									<li class="arrow"><a href="<?php echo base_url();?>">Microfin360 home</a></li>
									<li class="arrow"><?php echo empty($title)?'':$title;?></li>
									<li class='arrow'><?php $this->ci =& get_instance();
										echo ($this->ci->is_access_denied?"<b style='color:red;'>Access Denied!</b>":"<b style='color:green;'>Access Granted</b>"); ?></li>
								</ul>
							</div>
							<div id="tabber"> 
								<h3><?php echo empty($title)?'':$title;?></h3>
							</div>
						</div>
				<!-- Pagetitle -->
				<div style="float:left;width:100%;height:auto;margin:20px 0px 0px 0px;padding:0px 0px 0px 0px;">
				<?php  
					//if (!empty($headline)) echo "<h1 class='pagetitle'>".$headline."</h1>";
				?>
				<!-- Site Message -->
				<!-- Modified by Matin(coder.matin@gmail.com)-->
				<?php 
					
					$error = $this->session->flashdata('error');
					if(!empty($error)) echo "<div class='message_head'><div class='error'>$error</div></div>";					
					$warning = $this->session->flashdata('warning');
					if(!empty($warning)) echo "<div class='message_head'><div class='warning'>$warning</div></div>";
					$notice = $this->session->flashdata('notice');
					if(!empty($notice)) echo "<div class='message_head'><div class='notify'>$notice</div></div>";
					$information= $this->session->flashdata('information');
					if(!empty($information)) echo "<div class='message_head'><div class='info'>$information</div></div>";
					$success = $this->session->flashdata('success');
					if(!empty($success)) echo "<div class='message_head'><div class='message'>$success</div></div>";
					$message = $this->session->flashdata('message');
					if(!empty($message)) echo "<div class='message_head'><div class='message'>$message</div></div>";
				?>
				<!-- Content -->
				
				<?php  if (!empty($content_for_layout)) echo $content_for_layout;?>
				
					<!-- modal content -->
					<div id="basic-modal-content">
						<h3>Problem in internet connection</h3>
						<p>The application failed to communicate with the server. Please check your network connectivity</p>
						<p>What can you do:</p>
						<p><code>1) Check your network connection.</code></p>
						<p><code>2) If you are using a modem, you can disconect and reconnect again.</code></p>
					</div>				
				</div>
				</div>
				<!--<div id="bottomBody">
				</div>-->
				
			</div>
			<div id="report_container" style='width:100%;float:left;border-top:solid 1px #d0d0d0;display:none;'></div>
		</div>
		
		<div id="footer">
			<div id="wrapfooter">
				<div id="leftFooter">
					<p>Copyright &copy; 2001-2010 DataSoft. All rights reserved.</p>
				</div>
				<div id="rightFooter">
					<ul id="footer_menu">
						<li><p><a href="#">home</a></p></li>
						<li><p><a href="#">about us</a></p></li>
						<li><p><a href="#">feedback</a></p></li>
						<li><p><a href="#">contact us</a></p></li>
						<li><p><a href="#">help</a></p></li>
					</ul>
				</div>
				<!-- end of rightFooter -->
			</div>
		</div>
	</div>
</div>
	
</body>
</html>

<script>

	function show_print_toolbar()
	{
		if($('#report_container').find('table').length)
		{
			$('#global_print_menu').fadeIn();
			$('#global_print_menu').css('top',($(window).scrollTop() + $(window).height()-$('#global_print_menu').height()-10)+"px");
			
		}
	}
	function show_print_friendly()
	{
		$('#report_data').val($('#report_container').html());
		$("#print_form").attr("action", "<?php echo site_url('/reports/show_print_friendly');?>");
		$('#print_form').submit();
	}	
	function export_to_excel()
	{
		$('#report_data').val($('#report_container').html());
		$("#print_form").attr("action", "<?php echo site_url('/reports/export_to_excel');?>");
		$('#print_form').submit();
	}
	function full_screen()
	{
		if($('#link_full_screen').text()=='Full Screen')
		{
			show_full_screen();
			$('#link_full_screen').text('Exit Full Screen');
		}else
		{
			exit_full_screen();
			$('#link_full_screen').text('Full Screen');
		}
	}
	$(document).keyup(function(e) 
	{
		if (e.keyCode == 27) 
		{
			exit_full_screen();
		}
	});

	function show_full_screen()
	{
		$('#header').slideUp();
		$('#breadcam').slideUp();		
	}

	function exit_full_screen()
	{
		$('#header').slideDown();
		$('#breadcam').slideDown();
	}
</script>

<script type="text/javascript">
/**
 *	Author: Saroj Roy
 *	Last Modified: 2011-03-09
 **/

//adding effect ot the content
$(document).ready(function() {
	$('#topBody').hide();
	$('#topBody').fadeIn('slow');
});

//Checking internet connectivity on every 20 seconds
window.setInterval(check_connectivity, 15000);
//Function to check connectivity by a server request to fetch a image file
function check_connectivity()
{
	$.ajax({
	type: 'GET',
	url: '<?php echo base_url();?>media/images/microfin_logo.png',
	timeout: 5000,
	cache: false,
	success: function(data) {
			$.modal.close();
			if (window.console && window.console.error) {
				//writing to error console for debugging
				console.error("Connection Check: Success");
			}
		},
	error: function(XMLHttpRequest, textStatus, errorThrown) {
		show_modal();
		if (window.console && window.console.error) {
				//writing to error console for debugging
				console.error("Connection Check: Failed");
			}
		}
	})
}
//Action on global ajax error - pointing out a connectivity issue
$(document).ajaxError(function(){	
	//alert("The appication could not connect to the server. Please check your internet connectivity.");
    if (window.console && window.console.error) {
        console.error(arguments);
    }
});


function show_modal()
{
	$('#basic-modal-content').modal(
					{onOpen: function (dialog) {
						dialog.overlay.fadeIn('slow', function () {
							dialog.container.slideDown('slow', function () {
								dialog.data.fadeIn('slow');
							});
						});
					}});
}

// Ajax activity indicator bound to ajax start/stop document events
$(document).ajaxStart(function(){
  $('#global-ajax-loader').show();
}).ajaxStop(function(){
  $('#global-ajax-loader').hide();
});

/*
window.onbeforeunload = function() {
            return '';
        }
*/

</script>

