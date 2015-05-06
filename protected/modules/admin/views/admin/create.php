<?php
/* @var $this AdminController */
/* @var $model AdminUser */

$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AdminUser', 'url'=>array('index')),
	array('label'=>'Manage AdminUser', 'url'=>array('admin')),
);
$this->renderPartial('_form', array('model'=>$model,'manager_id'=>0)); ?>