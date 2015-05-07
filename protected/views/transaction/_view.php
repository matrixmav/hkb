<?php
/* @var $this TransactionController */
/* @var $data Transaction */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mode')); ?>:</b>
	<?php echo CHtml::encode($data->mode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gateway_id')); ?>:</b>
	<?php echo CHtml::encode($data->gateway_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actual_amount')); ?>:</b>
	<?php echo CHtml::encode($data->actual_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_amount')); ?>:</b>
	<?php echo CHtml::encode($data->paid_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_rp')); ?>:</b>
	<?php echo CHtml::encode($data->total_rp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('used_rp')); ?>:</b>
	<?php echo CHtml::encode($data->used_rp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>