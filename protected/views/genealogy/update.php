<?php
/* @var $this GenealogyController */
/* @var $model Genealogy */

$this->breadcrumbs=array(
	'Genealogies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Genealogy', 'url'=>array('index')),
	array('label'=>'Create Genealogy', 'url'=>array('create')),
	array('label'=>'View Genealogy', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Genealogy', 'url'=>array('admin')),
);
?>

<h1>Update Genealogy <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>