<?php
/* @var $this ReferralBannerController */
/* @var $model ReferralBanner */

$this->breadcrumbs=array(
	'Referral Banners'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ReferralBanner', 'url'=>array('index')),
	array('label'=>'Create ReferralBanner', 'url'=>array('create')),
	array('label'=>'View ReferralBanner', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ReferralBanner', 'url'=>array('admin')),
);
?>

<h1>Update ReferralBanner <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>