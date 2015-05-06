<?php
/* @var $this ClientInvlineController */
/* @var $model ClientInvline */

$this->breadcrumbs=array(
	'Client Invlines'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClientInvline', 'url'=>array('index')),
	array('label'=>'Create ClientInvline', 'url'=>array('create')),
	array('label'=>'View ClientInvline', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClientInvline', 'url'=>array('admin')),
);
?>

<h1>Update ClientInvline <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>