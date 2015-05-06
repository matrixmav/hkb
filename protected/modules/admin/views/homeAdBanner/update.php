<?php
/* @var $this HomeBannerController */
/* @var $model HomeBanner */

$this->breadcrumbs=array(
	'Home Ad Banners'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
$this->renderPartial('_form', array('model'=>$model)); ?>