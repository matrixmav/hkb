<?php
/* @var $this MoneyTransferController */
/* @var $model MoneyTransfer */

$this->breadcrumbs=array(
	'Money Transfers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MoneyTransfer', 'url'=>array('index')),
	array('label'=>'Create MoneyTransfer', 'url'=>array('create')),
	array('label'=>'Update MoneyTransfer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MoneyTransfer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MoneyTransfer', 'url'=>array('admin')),
);
?>

<h1>View MoneyTransfer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'to_user_id',
		'from_user_id',
		'fund_type',
		'comment',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
