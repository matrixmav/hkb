<?php
/* @var $this CommissionController */
/* @var $model Commission */

$this->breadcrumbs=array(
	'Commissions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Commission', 'url'=>array('index')),
	array('label'=>'Manage Commission', 'url'=>array('admin')),
);
?>

<h1>Create Commission</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>