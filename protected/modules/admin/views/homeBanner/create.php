<?php
/* @var $this HomeBannerController */
/* @var $model HomeBanner */

$this->breadcrumbs=array(
	'Home Banners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HomeBanner', 'url'=>array('index')),
	array('label'=>'Manage HomeBanner', 'url'=>array('admin')),
);
$this->renderPartial('_form', array('model'=>$model)); ?>