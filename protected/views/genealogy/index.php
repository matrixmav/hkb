<?php
/* @var $this GenealogyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Genealogies',
);

$this->menu=array(
	array('label'=>'Create Genealogy', 'url'=>array('create')),
	array('label'=>'Manage Genealogy', 'url'=>array('admin')),
);
?>

<h1>Genealogies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
