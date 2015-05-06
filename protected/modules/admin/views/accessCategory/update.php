<?php
/* @var $this AccessCategoryController */
/* @var $model AccessCategory */

$this->breadcrumbs=array(
	'Access Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AccessCategory', 'url'=>array('index')),
	array('label'=>'Create AccessCategory', 'url'=>array('create')),
	array('label'=>'View AccessCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AccessCategory', 'url'=>array('admin')),
);
?>

<h1>Update AccessCategory <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>