<?php
/* @var $this PortalController */
/* @var $model Portal */

$this->breadcrumbs=array(
	'Portals'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Portal', 'url'=>array('index')),
	array('label'=>'Create Portal', 'url'=>array('create')),
	array('label'=>'Update Portal', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Portal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Portal', 'url'=>array('admin')),
);
?>

<h1>View Portal #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'slug',
		'url',
		'headtitle',
		'contact_email',
		'booking_email',
		'telephone_std',
		'status',
		'added_at',
		'updated_at',
	),
)); ?>
