<?php
/* @var $this MoneyTransferController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Money Transfers',
);

$this->menu=array(
	array('label'=>'Create MoneyTransfer', 'url'=>array('create')),
	array('label'=>'Manage MoneyTransfer', 'url'=>array('admin')),
);
?>

<h1>Money Transfers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
