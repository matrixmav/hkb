<?php
/* @var $this SummaryController */
/* @var $model Summary */

$this->breadcrumbs=array(
	'Summaries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Summary', 'url'=>array('index')),
	array('label'=>'Manage Summary', 'url'=>array('admin')),
);
?>

<h1>Create Summary</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>