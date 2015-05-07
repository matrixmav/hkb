<?php
/* @var $this GatewayController */
/* @var $model Gateway */

$this->breadcrumbs=array(
	'Gateways'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Gateway', 'url'=>array('index')),
	array('label'=>'Manage Gateway', 'url'=>array('admin')),
);
?>

<h1>Create Gateway</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>