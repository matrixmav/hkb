<?php
/* @var $this ClientInvoiceController */
/* @var $model ClientInvoice */

$this->breadcrumbs=array(
	'Client Invoices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClientInvoice', 'url'=>array('index')),
	array('label'=>'Create ClientInvoice', 'url'=>array('create')),
	array('label'=>'View ClientInvoice', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClientInvoice', 'url'=>array('admin')),
);
?>

<h1>Update ClientInvoice <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>