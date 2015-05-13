<?php
/* @var $this CommissionController */
/* @var $model Commission */

$this->breadcrumbs=array(
	'Commissions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Commission', 'url'=>array('index')),
	array('label'=>'Create Commission', 'url'=>array('create')),
	array('label'=>'View Commission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Commission', 'url'=>array('admin')),
);
?>

<h1>Update Commission <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>