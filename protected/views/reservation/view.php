<?php
/* @var $this ReservationController */
/* @var $model Reservation */

$this->breadcrumbs=array(
	'Reservations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Reservation', 'url'=>array('index')),
	array('label'=>'Create Reservation', 'url'=>array('create')),
	array('label'=>'Update Reservation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Reservation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Reservation', 'url'=>array('admin')),
);
?>

<h1>View Reservation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'customer_id',
		'portal_id',
		'room_id',
		'res_date',
		'res_from',
		'res_to',
		'room_price',
		'currency_id',
		'comment',
		'arrival_time',
		'is_secret',
		'reservation_code',
		'reservation_status',
		'payment_status',
		'added_at',
		'updated_at',
	),
)); ?>