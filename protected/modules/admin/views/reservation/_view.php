<?php
/* @var $this ReservationController */
/* @var $data Reservation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portal_id')); ?>:</b>
	<?php echo CHtml::encode($data->portal_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('room_id')); ?>:</b>
	<?php echo CHtml::encode($data->room_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('res_date')); ?>:</b>
	<?php echo CHtml::encode($data->res_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('res_from')); ?>:</b>
	<?php echo CHtml::encode($data->res_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('res_to')); ?>:</b>
	<?php echo CHtml::encode($data->res_to); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('room_price')); ?>:</b>
	<?php echo CHtml::encode($data->room_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_id')); ?>:</b>
	<?php echo CHtml::encode($data->currency_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arrival_time')); ?>:</b>
	<?php echo CHtml::encode($data->arrival_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_secret')); ?>:</b>
	<?php echo CHtml::encode($data->is_secret); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reservation_code')); ?>:</b>
	<?php echo CHtml::encode($data->reservation_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reservation_status')); ?>:</b>
	<?php echo CHtml::encode($data->reservation_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_status')); ?>:</b>
	<?php echo CHtml::encode($data->payment_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_at')); ?>:</b>
	<?php echo CHtml::encode($data->added_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>