<?php
/* @var $this DayuseBenefitsController */
/* @var $model DayuseBenefits */

$this->breadcrumbs=array(
	'Dayuse Benefits'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DayuseBenefits', 'url'=>array('index')),
	array('label'=>'Create DayuseBenefits', 'url'=>array('create')),
	array('label'=>'View DayuseBenefits', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DayuseBenefits', 'url'=>array('admin')),
);
?>

<h1>Update DayuseBenefits <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>