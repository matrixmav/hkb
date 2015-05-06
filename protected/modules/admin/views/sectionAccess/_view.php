<?php
/* @var $this SectionAccessController */
/* @var $data SectionAccess */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_id')); ?>:</b>
	<?php echo CHtml::encode($data->section_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('portal_access')); ?>:</b>
	<?php echo CHtml::encode($data->portal_access); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_mode')); ?>:</b>
	<?php echo CHtml::encode($data->access_mode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('added_at')); ?>:</b>
	<?php echo CHtml::encode($data->added_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />


</div>