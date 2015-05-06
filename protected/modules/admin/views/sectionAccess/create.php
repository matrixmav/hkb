<?php
/* @var $this SectionAccessController */
/* @var $model SectionAccess */

$this->breadcrumbs=array(
	'Section Accesses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SectionAccess', 'url'=>array('index')),
	array('label'=>'Manage SectionAccess', 'url'=>array('admin')),
);
?>

<h1>Create SectionAccess</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>