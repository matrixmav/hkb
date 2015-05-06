<?php
/* @var $this DayuseBenefitsController */
/* @var $model DayuseBenefits */

$this->breadcrumbs=array(
	'Dayuse Benefits'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DayuseBenefits', 'url'=>array('index')),
	array('label'=>'Create DayuseBenefits', 'url'=>array('create')),
	array('label'=>'Update DayuseBenefits', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DayuseBenefits', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DayuseBenefits', 'url'=>array('admin')),
);
?>

<h1>View DayuseBenefits #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'benefit_img',
		'city_id',
		'state_id',
		'country_id',
		'benefit_img_page',
		'created_at',
		'updated_at',
	),
)); ?>
