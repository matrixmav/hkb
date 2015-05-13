<?php
/* @var $this MailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mails',
);

$this->menu=array(
	array('label'=>'Create Mail', 'url'=>array('create')),
	array('label'=>'Manage Mail', 'url'=>array('admin')),
);
?>

<h1>Mails</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
