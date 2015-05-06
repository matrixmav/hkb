<?php
/* @var $this ClientInvlineController */
/* @var $model ClientInvline */

$this->breadcrumbs=array(
	'Client Invlines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClientInvline', 'url'=>array('index')),
	array('label'=>'Manage ClientInvline', 'url'=>array('admin')),
);
?>

<h1>Create ClientInvline</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>