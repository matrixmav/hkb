<!DOCTYPE HTML>
<html class="no-js">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo Yii::t('mobile', 'home_page'); ?></title>
<!--style sheet goes here-->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/jquery-ui.structure.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/jquery-ui.theme.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/flexslider.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/screen.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile/screen2_ui.css" type="text/css" media="all">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.1.min.js?ver=<?php echo strtotime("now");?>"></script>

<!--HTML5 javascript goes here-->
<!--javascript goes here--> 
</head>

<body class="fullLoad">
<?php $this->renderPartial('/layouts/hotelheader'); ?>
    
<?php echo $content; ?>
    
<?php $this->renderPartial('/layouts/footer');?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/jquery.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/jquery-ui.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/jquery.flexslider.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/dayuse.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/search.js?ver=<?php echo strtotime("now");?>"></script>
</body>
</html>