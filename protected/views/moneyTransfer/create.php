<?php
/* @var $this MoneyTransferController */
/* @var $model MoneyTransfer */

$this->breadcrumbs=array(
	'Money Transfers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MoneyTransfer', 'url'=>array('index')),
	array('label'=>'Manage MoneyTransfer', 'url'=>array('admin')),
);
?>

<h1>Create MoneyTransfer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>