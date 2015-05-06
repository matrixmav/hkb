<?php
/* @var $this ClientInvoiceController */
/* @var $model ClientInvoice */

$this->breadcrumbs=array(
	'Client Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClientInvoice', 'url'=>array('index')),
	array('label'=>'Manage ClientInvoice', 'url'=>array('admin')),
);
?>

<h1>Create ClientInvoice</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>