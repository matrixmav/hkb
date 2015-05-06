<?php
/* @var $this ReservationController */
/* @var $model Reservation */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'portal_id'); ?>
		<?php echo $form->textField($model,'portal_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_id'); ?>
		<?php echo $form->textField($model,'room_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'res_date'); ?>
		<?php echo $form->textField($model,'res_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'res_from'); ?>
		<?php echo $form->textField($model,'res_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'res_to'); ?>
		<?php echo $form->textField($model,'res_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_price'); ?>
		<?php echo $form->textField($model,'room_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_id'); ?>
		<?php echo $form->textField($model,'currency_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'arrival_time'); ?>
		<?php echo $form->textField($model,'arrival_time',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_secret'); ?>
		<?php echo $form->textField($model,'is_secret'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reservation_code'); ?>
		<?php echo $form->textField($model,'reservation_code',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reservation_status'); ?>
		<?php echo $form->textField($model,'reservation_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_status'); ?>
		<?php echo $form->textField($model,'payment_status'); ?>
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