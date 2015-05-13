<?php
/* @var $this ReferralBannerController */
/* @var $model ReferralBanner */

$this->breadcrumbs=array(
	'Referral Banners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ReferralBanner', 'url'=>array('index')),
	array('label'=>'Manage ReferralBanner', 'url'=>array('admin')),
);
?>

<h1>Create ReferralBanner</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>