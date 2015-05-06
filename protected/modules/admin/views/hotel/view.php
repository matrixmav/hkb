<?php
/* @var $this HotelController */
/* @var $model Hotel */

$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	$model->name,
); ?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    Hotel Name : <b><?php echo $model->name; ?></b>
</div>
<?php $this->menu=array(
	array('label'=>'List Hotel', 'url'=>array('index')),
	array('label'=>'Create Hotel', 'url'=>array('create')),
	array('label'=>'Update Hotel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Hotel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hotel', 'url'=>array('admin')),
);
?>

<h1>View Hotel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'slug',
		'timezone',
		'group_id',
		'star_rating',
		'address',
		'postal_code',
		'city_id',
		'district_id',
		'state_id',
		'country_id',
		'longitude',
		'latitude',
		'language_id',
		'website',
		'telephone',
		'fax',
		'com_con_info',
		'default_currency_id',
		'day_commission',
		'night_commission',
		'addon_commission',
		'is_new',
		'is_feature',
		'feature_till_date',
		'comment',
		'added_at',
		'updated_at',
	),
)); ?>
