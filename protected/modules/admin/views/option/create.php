<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	Yii::t('translation','Options')=>array('index'),
	Yii::t('translation','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('translation','List Equipment'), 'url'=>array('index')),
	array('label'=>Yii::t('translation','Manage Equipment'), 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model, 'optionInfo'=>$optionInfo)); ?>