<?php
/* @var $this OptionTypeController */
/* @var $model OptionType */

$this->breadcrumbs=array(
	'Option Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OptionType', 'url'=>array('index')),
	array('label'=>'Manage OptionType', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>