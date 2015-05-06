<?php
/* @var $this SectionAccessController */
/* @var $model SectionAccess */

$this->breadcrumbs=array(
	'Section Accesses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SectionAccess', 'url'=>array('index')),
	array('label'=>'Create SectionAccess', 'url'=>array('create')),
	array('label'=>'View SectionAccess', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SectionAccess', 'url'=>array('admin')),
);
?>

<h1>Update SectionAccess <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>