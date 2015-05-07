<?php
/* @var $this MailController */
/* @var $model Mail */

$this->breadcrumbs=array(
	'Mails'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mail', 'url'=>array('index')),
	array('label'=>'Create Mail', 'url'=>array('create')),
	array('label'=>'View Mail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mail', 'url'=>array('admin')),
);
?>

<h1>Update Mail <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>