<?php
/* @var $this GenealogyController */
/* @var $model Genealogy */

$this->breadcrumbs=array(
	'Genealogies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Genealogy', 'url'=>array('index')),
	array('label'=>'Manage Genealogy', 'url'=>array('admin')),
);
?>

<h1>Create Genealogy</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>