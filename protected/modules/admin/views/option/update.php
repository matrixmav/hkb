<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	Yii::t('translation','Equipments')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('translation','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('translation','List Equipment'), 'url'=>array('index')),
	array('label'=>Yii::t('translation','Create Equipment'), 'url'=>array('create')),
	array('label'=>Yii::t('translation','View Equipment'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('translation','Manage Equipment'), 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model, 'optionInfo' => $optionInfo)); ?>