<?php
/* @var $this ClientInvoiceController */
/* @var $data ClientInvoice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_inv_no')); ?>:</b>
	<?php echo CHtml::encode($data->client_inv_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inv_date')); ?>:</b>
	<?php echo CHtml::encode($data->inv_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('label')); ?>:</b>
	<?php echo CHtml::encode($data->label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_at')); ?>:</b>
	<?php echo CHtml::encode($data->added_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />


</div>