<?php
/* @var $this OptionTypeController */
/* @var $model OptionType */

$this->breadcrumbs=array(
	'Option Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List OptionType', 'url'=>array('index')),
	array('label'=>'Create OptionType', 'url'=>array('create')),
	array('label'=>'Update OptionType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OptionType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OptionType', 'url'=>array('admin')),
);
?>

<h1>View OptionType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'price',
		'added_at',
		'updated_at',
	),
)); ?>
