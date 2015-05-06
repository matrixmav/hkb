<?php
/* @var $this BannerController */
/* @var $model HomeBanner */

$this->breadcrumbs=array(
	'Home Banners'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List HomeBanner', 'url'=>array('index')),
	array('label'=>'Create HomeBanner', 'url'=>array('create')),
	array('label'=>'Update HomeBanner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HomeBanner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HomeBanner', 'url'=>array('admin')),
);
?>

<h1>View HomeBanner #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'banner',
		'city_id',
		'state_id',
		'country_id',
		'created_at',
		'updated_at',
	),
)); ?>
