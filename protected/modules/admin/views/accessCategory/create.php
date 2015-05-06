<?php
/* @var $this AccessCategoryController */
/* @var $model AccessCategory */

$this->breadcrumbs=array(
	'Access Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AccessCategory', 'url'=>array('index')),
	array('label'=>'Manage AccessCategory', 'url'=>array('admin')),
);
?>

<h1>Create AccessCategory</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>