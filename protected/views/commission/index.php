<?php
/* @var $this CommissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Commissions',
);

$this->menu=array(
	array('label'=>'Create Commission', 'url'=>array('create')),
	array('label'=>'Manage Commission', 'url'=>array('admin')),
);
?>

<h1>Commissions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
