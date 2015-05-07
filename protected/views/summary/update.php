<?php
/* @var $this SummaryController */
/* @var $model Summary */

$this->breadcrumbs=array(
	'Summaries'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Summary', 'url'=>array('index')),
	array('label'=>'Create Summary', 'url'=>array('create')),
	array('label'=>'View Summary', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Summary', 'url'=>array('admin')),
);
?>

<h1>Update Summary <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>