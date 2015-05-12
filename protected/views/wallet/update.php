<?php
/* @var $this WalletController */
/* @var $model Wallet */

$this->breadcrumbs=array(
	'Wallets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Create Wallet', 'url'=>array('create')),
	array('label'=>'View Wallet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Wallet', 'url'=>array('admin')),
);
?>

<h1>Update Wallet <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>