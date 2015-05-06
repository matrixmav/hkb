<?php
/* @var $this ClientInvoiceController */
/* @var $model ClientInvoice */

$this->breadcrumbs=array(
	'Client Invoices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClientInvoice', 'url'=>array('index')),
	array('label'=>'Create ClientInvoice', 'url'=>array('create')),
	array('label'=>'Update ClientInvoice', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClientInvoice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClientInvoice', 'url'=>array('admin')),
);
?>

<h1>View ClientInvoice #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'client_id',
		'client_inv_no',
		'inv_date',
		'label',
		'added_at',
		'updated_at',
	),
)); ?>
