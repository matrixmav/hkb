<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0
Version: 1.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta name="robots" content="noindex, nofollow" />
   <meta charset="utf-8" />
   <title>HK-Base | Admin</title>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta name="MobileOptimized" content="320">
   <!-- BEGIN GLOBAL MANDATORY STYLES -->          
<link href="/metronic/custom/google-css.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
   <!-- END GLOBAL MANDATORY STYLES -->

   <!-- BEGIN THEME STYLES --> 
<link href="/metronic/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/metronic/assets/css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
<link href="/metronic/assets/css/custom.css" rel="stylesheet" type="text/css"/>
   <!-- END THEME STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/jquery-notific8/jquery.notific8.min.css"/>
   
   
   <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
   <!-- BEGIN LOGO -->
   <div class="logo">
       <!--HK-Base Admin-->
      <!--<img src="/metronic/assets/img/logo.png" alt="" />--> 
   </div>
   <!-- END LOGO -->
   <!-- BEGIN LOGIN -->
   <?php echo $content;?>
   <!-- END LOGIN -->
   <!-- BEGIN COPYRIGHT -->
   <div class="copyright">
      <?php echo date('Y');?> &copy; HK-Base
   </div>
   <!-- END COPYRIGHT -->
   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
   <script src="/metronic/assets/plugins/respond.min.js"></script>
   <script src="/metronic/assets/plugins/excanvas.min.js"></script> 
   <![endif]-->
<script src="/metronic/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="/metronic/assets/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>

<script src="/metronic/assets/plugins/jquery-notific8/jquery.notific8.min.js"></script>
<script src="/metronic/assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
function showError(msg){
	bootbox.alert(msg, function() {
		//alert("Hello world callback");
	});  
}

function showSucessMsg(msg, heading){
	var settings = {
			theme: 'teal',
		   // sticky: $('#notific8_sticky').is(':checked'),
			horizontalEdge: 'top',
			verticalEdge: 'right',
			heading : heading, 
			life : 5000
	};
	$.notific8('zindex', 11500);
	$.notific8($.trim(msg), settings);
}
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
