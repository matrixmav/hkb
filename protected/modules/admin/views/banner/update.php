<?php
/* @var $this BannerController */
/* @var $model HomeBanner */

$this->breadcrumbs=array(
	'Home Banners'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HomeBanner', 'url'=>array('index')),
	array('label'=>'Create HomeBanner', 'url'=>array('create')),
	array('label'=>'View HomeBanner', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HomeBanner', 'url'=>array('admin')),
);
?>

<h1>Update HomeBanner <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>