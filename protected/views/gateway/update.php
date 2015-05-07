<?php
/* @var $this GatewayController */
/* @var $model Gateway */

$this->breadcrumbs=array(
	'Gateways'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Gateway', 'url'=>array('index')),
	array('label'=>'Create Gateway', 'url'=>array('create')),
	array('label'=>'View Gateway', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Gateway', 'url'=>array('admin')),
);
?>

<h1>Update Gateway <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>