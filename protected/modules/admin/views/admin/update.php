<?php
/* @var $this AdminController */
/* @var $model AdminUser */

$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdminUser', 'url'=>array('index')),
	array('label'=>'Create AdminUser', 'url'=>array('create')),
	array('label'=>'View AdminUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AdminUser', 'url'=>array('admin')),
);
 $this->renderPartial('_form', array('model'=>$model,'manager_id'=>$model->id)); ?>