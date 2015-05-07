<?php
/* @var $this ReferralBannerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Referral Banners',
);

$this->menu=array(
	array('label'=>'Create ReferralBanner', 'url'=>array('create')),
	array('label'=>'Manage ReferralBanner', 'url'=>array('admin')),
);
?>

<h1>Referral Banners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
