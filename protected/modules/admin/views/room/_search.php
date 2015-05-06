<?php
/* @var $this RoomController */
/* @var $model Room */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_status'); ?>
		<?php echo $form->textField($model,'room_status',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_id'); ?>
		<?php echo $form->textField($model,'currency_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'default_price'); ?>
		<?php echo $form->textField($model,'default_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'default_night_price'); ?>
		<?php echo $form->textField($model,'default_night_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'available_from'); ?>
		<?php echo $form->textField($model,'available_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'available_till'); ?>
		<?php echo $form->textField($model,'available_till'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exhausted_status'); ?>
		<?php echo $form->textField($model,'exhausted_status',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cc_required'); ?>
		<?php echo $form->textField($model,'cc_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'added_at'); ?>
		<?php echo $form->textField($model,'added_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->