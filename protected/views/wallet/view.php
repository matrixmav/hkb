<?php
/* @var $this WalletController */
/* @var $model Wallet */

$this->breadcrumbs=array(
	'Wallets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Create Wallet', 'url'=>array('create')),
	array('label'=>'Update Wallet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Wallet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Wallet', 'url'=>array('admin')),
);
?>

<h1>View Wallet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'fund',
		'type',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
