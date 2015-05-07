<?php
/* @var $this MoneyTransferController */
/* @var $model MoneyTransfer */

$this->breadcrumbs=array(
	'Money Transfers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MoneyTransfer', 'url'=>array('index')),
	array('label'=>'Create MoneyTransfer', 'url'=>array('create')),
	array('label'=>'View MoneyTransfer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MoneyTransfer', 'url'=>array('admin')),
);
?>

<h1>Update MoneyTransfer <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>