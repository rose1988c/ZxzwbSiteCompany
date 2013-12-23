<?php
    //bootstrap
    include (DOC_ROOT . '/templates/manage/scaffolds/bootstrap.inc.php');
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta name="title" content="<?php echo $titleseo;?>" />
<meta name="description"	content="<?php echo $head_description?>" />
<meta name="keywords"  content="<?php echo $head_keywords;?>" />
<meta name="robots" 	content="<?php echo $robots; ?>" />
<link rel="shortcut icon" href="<?php echo $media_root;?>/favicon.ico"	type="image/x-icon" />
<?php if (isset($head_links)) echo $head_links; ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta name="MobileOptimized" content="320">
<!-- BEGIN GLOBAL MANDATORY STYLES -->          
<link href="/../../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES --> 
<link rel="stylesheet" type="text/css" href="/../../assets/plugins/select2/select2_metro.css" />
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES --> 
<link href="/../../assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/../../assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
<link href="/../../assets/css/custom.css" rel="stylesheet" type="text/css"/>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<!-- END THEME STYLES -->

<title><?php echo $titleseo;?></title>
</head>
<body>
<?php echo $body;?>
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->   
	<!--[if lt IE 9]>
	<script src="../../assets/plugins/respond.min.js"></script>
	<script src="../../assets/plugins/excanvas.min.js"></script> 
	<![endif]-->   
	<script src="../../assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="../../assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="../../assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<script src="../../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../../assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="../../assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="../../assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="../../assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	
	<script type="text/javascript" src="../../assets/plugins/select2/select2.min.js"></script>     
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="../../assets/scripts/app.js" type="text/javascript"></script>
	<script src="../../assets/scripts/login.js" type="text/javascript"></script> 
	<!-- END PAGE LEVEL SCRIPTS --> 
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
	
	<!-- BEGIN COPYRIGHT -->
        <div class="copyright">2013 &copy; Metronic. Admin Dashboard Template.</div>
    <!-- END COPYRIGHT -->

</body>
</html>
