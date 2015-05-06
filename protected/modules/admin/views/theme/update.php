<?php
/* @var $this ThemeController */
/* @var $model Theme */

$this->breadcrumbs=array(
	Yii::t('translation','Themes')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('translation','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('translation','List Theme'), 'url'=>array('index')),
	array('label'=>Yii::t('translation','Create Theme'), 'url'=>array('create')),
	array('label'=>Yii::t('translation','View Theme'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('translation','Manage Theme'), 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>