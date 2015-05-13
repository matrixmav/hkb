<?php
/* @var $this ReferralBannerController */
/* @var $model ReferralBanner */

$this->breadcrumbs=array(
	'Referral Banners'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ReferralBanner', 'url'=>array('index')),
	array('label'=>'Create ReferralBanner', 'url'=>array('create')),
	array('label'=>'Update ReferralBanner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ReferralBanner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ReferralBanner', 'url'=>array('admin')),
);
?>

<h1>View ReferralBanner #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'url',
		'size',
		'status',
		'created_at',
		'updated_at',
	),
)); ?>
