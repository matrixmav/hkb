<?php
/* @var $this OriginController */
/* @var $model Origin */

$this->breadcrumbs=array(
	Yii::t('translation','Origins')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('translation','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('translation','List Origin'), 'url'=>array('index')),
	array('label'=>Yii::t('translation','Create Origin'), 'url'=>array('create')),
	array('label'=>Yii::t('translation','View Origin'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('translation','Manage Origin'), 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>