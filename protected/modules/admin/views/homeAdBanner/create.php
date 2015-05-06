<?php
/* @var $this HomeBannerController */
/* @var $model HomeBanner */

$this->breadcrumbs=array(
	'Home Ad Banners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HomeAdBanner', 'url'=>array('index')),
	array('label'=>'Manage HomeAdBanner', 'url'=>array('admin')),
);
$this->renderPartial('_form', array('model'=>$model)); ?>