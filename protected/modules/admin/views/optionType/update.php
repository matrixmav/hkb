<?php
/* @var $this OptionTypeController */
/* @var $model OptionType */

$this->breadcrumbs=array(
	'Option Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OptionType', 'url'=>array('index')),
	array('label'=>'Create OptionType', 'url'=>array('create')),
	array('label'=>'View OptionType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OptionType', 'url'=>array('admin')),
);
?>

<h1>Update OptionType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>