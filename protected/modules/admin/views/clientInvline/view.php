<?php
/* @var $this ClientInvlineController */
/* @var $model ClientInvline */

$this->breadcrumbs=array(
	'Client Invlines'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List ClientInvline', 'url'=>array('index')),
	array('label'=>'Create ClientInvline', 'url'=>array('create')),
	array('label'=>'Update ClientInvline', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClientInvline', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClientInvline', 'url'=>array('admin')),
);
?>

<h1>View ClientInvline #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'client_inv_no',
		'title',
		'unit_price',
		'qty',
		'wv_amt',
		'vat',
		'vat_amt',
		'tot_amt',
		'added_at',
		'updated_at',
	),
)); ?>
