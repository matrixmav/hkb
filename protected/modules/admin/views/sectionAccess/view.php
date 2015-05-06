<?php
/* @var $this SectionAccessController */
/* @var $model SectionAccess */

$this->breadcrumbs=array(
	'Section Accesses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SectionAccess', 'url'=>array('index')),
	array('label'=>'Create SectionAccess', 'url'=>array('create')),
	array('label'=>'Update SectionAccess', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SectionAccess', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SectionAccess', 'url'=>array('admin')),
);
?>

<h1>View SectionAccess #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'section_id',
		'portal_access',
		'access_mode',
		'user_id',
		'added_at',
		'updated_at',
	),
)); ?>
