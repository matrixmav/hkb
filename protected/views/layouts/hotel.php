<!DOCTYPE HTML>
<html class="no-js"  prefix="og: http://ogp.me/ns#" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta property="og:url" content="<?php echo Yii::app()->getBaseUrl(true);?>" /><meta property="og:site_name" content="Daystay" /><link rel="canonical" href="<?php echo Yii::app()->getBaseUrl(true);?>" /><meta http-equiv="content-language" content="en" /><meta name="country" content="en" />
<?php if(!empty($this->fbOgTags)){
 foreach($this->fbOgTags as $name=>$value){
  if(trim($value) != "") { ?>
	<meta property="og:<?php echo $name; ?>" content="<?php echo substr(strip_tags($value),0,200); ?>"/>
  <?php }
 }
}?>
<title><?php if(isset($this->pageTitle))
{
	echo $this->pageTitle;
}else {
	echo "Daystay";
} ?></title>
<!--style sheet goes here-->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.structure.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.theme.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/flexslider.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.custom-scrollbar.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox.css" type="text/css" media="all">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.1.min.js?ver=<?php echo strtotime("now");?>"></script>
<!--HTML5 javascript goes here-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.js" type="text/javascript">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.1.min.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/customer.js?ver=<?php echo strtotime("now");?>">"></script>
</head>

<body>
<?php $this->renderPartial('//layouts/hotelhead');?>
    
<?php echo $content; ?>
    
<?php $this->renderPartial('//layouts/footer');?>
<!--javascript goes here--> 

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" id="flexslider12" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.flexslider.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.custom-scrollbar.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.aw-showcase.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/placeholders.min.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.wookmark.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-scrolltofixed.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/spritespin.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/spritespin_custom.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/dayuse.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/search.js"></script>
</body>
</html>		