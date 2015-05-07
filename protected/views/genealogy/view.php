<?php
/* @var $this GenealogyController */
/* @var $model Genealogy */

$this->breadcrumbs=array(
	'Genealogies'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Genealogy', 'url'=>array('index')),
	array('label'=>'Create Genealogy', 'url'=>array('create')),
	array('label'=>'Update Genealogy', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Genealogy', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Genealogy', 'url'=>array('admin')),
);
?>

<h1>View Genealogy #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'placement',
		'user_id',
		'sponsor_user_id',
		'position',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
