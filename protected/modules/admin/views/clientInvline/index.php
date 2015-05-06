<?php
/* @var $this ClientInvlineController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Client Invlines',
);

$this->menu=array(
	array('label'=>'Create ClientInvline', 'url'=>array('create')),
	array('label'=>'Manage ClientInvline', 'url'=>array('admin')),
);
?>

<h1>Client Invlines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
