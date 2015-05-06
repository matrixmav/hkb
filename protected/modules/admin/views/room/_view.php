<?php
/* @var $this RoomController */
/* @var $data Room */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('room_status')); ?>:</b>
	<?php echo CHtml::encode($data->room_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currency_id')); ?>:</b>
	<?php echo CHtml::encode($data->currency_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_price')); ?>:</b>
	<?php echo CHtml::encode($data->default_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('default_night_price')); ?>:</b>
	<?php echo CHtml::encode($data->default_night_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('available_from')); ?>:</b>
	<?php echo CHtml::encode($data->available_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('available_till')); ?>:</b>
	<?php echo CHtml::encode($data->available_till); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exhausted_status')); ?>:</b>
	<?php echo CHtml::encode($data->exhausted_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cc_required')); ?>:</b>
	<?php echo CHtml::encode($data->cc_required); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_at')); ?>:</b>
	<?php echo CHtml::encode($data->added_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>