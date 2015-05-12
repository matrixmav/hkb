<?php
/* @var $this WalletController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Wallets',
);

$this->menu=array(
	array('label'=>'Create Wallet', 'url'=>array('create')),
	array('label'=>'Manage Wallet', 'url'=>array('admin')),
);
?>

<h1>Wallets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
