<?php
/* @var $this InvoiceController */
/* @var $data Invoice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv_no')); ?>:</b>
	<?php echo CHtml::encode($data->inv_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv_date')); ?>:</b>
	<?php echo CHtml::encode($data->inv_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv_month')); ?>:</b>
	<?php echo CHtml::encode($data->inv_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv_year')); ?>:</b>
	<?php echo CHtml::encode($data->inv_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hotel_id')); ?>:</b>
	<?php echo CHtml::encode($data->hotel_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_no')); ?>:</b>
	<?php echo CHtml::encode($data->account_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('inv_label')); ?>:</b>
	<?php echo CHtml::encode($data->inv_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hotel_inv')); ?>:</b>
	<?php echo CHtml::encode($data->hotel_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vat_amt')); ?>:</b>
	<?php echo CHtml::encode($data->vat_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_inv')); ?>:</b>
	<?php echo CHtml::encode($data->total_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_inv')); ?>:</b>
	<?php echo CHtml::encode($data->paid_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pending_inv')); ?>:</b>
	<?php echo CHtml::encode($data->pending_inv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_at')); ?>:</b>
	<?php echo CHtml::encode($data->added_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>