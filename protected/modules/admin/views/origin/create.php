<?php
/* @var $this OriginController */
/* @var $model Origin */

$this->breadcrumbs=array(
	Yii::t('translation','Origins')=>array('index'),
	Yii::t('translation','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('translation','List Origin'), 'url'=>array('index')),
	array('label'=>Yii::t('translation','Manage Origin'), 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>