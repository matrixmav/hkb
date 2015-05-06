<?php
/* @var $this OurSelectionController */
/* @var $model FeaturedHotel */

$this->breadcrumbs=array(
	'Featured Hotels'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FeaturedHotel', 'url'=>array('index')),
	array('label'=>'Create FeaturedHotel', 'url'=>array('create')),
	array('label'=>'Update FeaturedHotel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FeaturedHotel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FeaturedHotel', 'url'=>array('admin')),
);
?>

<h1>View FeaturedHotel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'hotel_id',
		'city_id',
		'state_id',
		'country_id',
		'created_at',
		'updated_at',
	),
)); ?>
