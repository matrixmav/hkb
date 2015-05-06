<?php
/* @var $this ClientInvlineController */
/* @var $data ClientInvline */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_inv_no')); ?>:</b>
	<?php echo CHtml::encode($data->client_inv_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->unit_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wv_amt')); ?>:</b>
	<?php echo CHtml::encode($data->wv_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vat')); ?>:</b>
	<?php echo CHtml::encode($data->vat); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('vat_amt')); ?>:</b>
	<?php echo CHtml::encode($data->vat_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tot_amt')); ?>:</b>
	<?php echo CHtml::encode($data->tot_amt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_at')); ?>:</b>
	<?php echo CHtml::encode($data->added_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>