<?php
/* @var $this AccessCategoryController */
/* @var $model AccessCategory */

$this->breadcrumbs=array(
	'Access Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AccessCategory', 'url'=>array('index')),
	array('label'=>'Create AccessCategory', 'url'=>array('create')),
	array('label'=>'Update AccessCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AccessCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AccessCategory', 'url'=>array('admin')),
);
?>

<h1>View AccessCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'country_id',
		'added_at',
		'updated_at',
	),
)); ?>
