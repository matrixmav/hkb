<?php
/* @var $this SectionAccessController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Section Accesses',
);

$this->menu=array(
	array('label'=>'Create SectionAccess', 'url'=>array('create')),
	array('label'=>'Manage SectionAccess', 'url'=>array('admin')),
);
?>

<h1>Section Accesses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
