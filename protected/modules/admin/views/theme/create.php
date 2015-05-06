<?php
/* @var $this ThemeController */
/* @var $model Theme */

$this->breadcrumbs=array(
	Yii::t('translation','Themes')=>array('index'),
	Yii::t('translation','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('translation','List Theme'), 'url'=>array('index')),
	array('label'=>Yii::t('translation','Manage Theme'), 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>