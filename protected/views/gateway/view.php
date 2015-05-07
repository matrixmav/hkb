<?php
/* @var $this GatewayController */
/* @var $model Gateway */

$this->breadcrumbs=array(
	'Gateways'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Gateway', 'url'=>array('index')),
	array('label'=>'Create Gateway', 'url'=>array('create')),
	array('label'=>'Update Gateway', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Gateway', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Gateway', 'url'=>array('admin')),
);
?>

<h1>View Gateway #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'request_url',
		'response_url',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
