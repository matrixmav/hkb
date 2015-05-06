<?php
/* @var $this ReservationController */
/* @var $model Reservation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reservation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'portal_id'); ?>
		<?php echo $form->textField($model,'portal_id'); ?>
		<?php echo $form->error($model,'portal_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_id'); ?>
		<?php echo $form->textField($model,'room_id'); ?>
		<?php echo $form->error($model,'room_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'res_date'); ?>
		<?php echo $form->textField($model,'res_date'); ?>
		<?php echo $form->error($model,'res_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'res_from'); ?>
		<?php echo $form->textField($model,'res_from'); ?>
		<?php echo $form->error($model,'res_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'res_to'); ?>
		<?php echo $form->textField($model,'res_to'); ?>
		<?php echo $form->error($model,'res_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_price'); ?>
		<?php echo $form->textField($model,'room_price'); ?>
		<?php echo $form->error($model,'room_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_id'); ?>
		<?php echo $form->textField($model,'currency_id'); ?>
		<?php echo $form->error($model,'currency_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'arrival_time'); ?>
		<?php echo $form->textField($model,'arrival_time',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'arrival_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_secret'); ?>
		<?php echo $form->textField($model,'is_secret'); ?>
		<?php echo $form->error($model,'is_secret'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reservation_code'); ?>
		<?php echo $form->textField($model,'reservation_code',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'reservation_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reservation_status'); ?>
		<?php echo $form->textField($model,'reservation_status'); ?>
		<?php echo $form->error($model,'reservation_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_status'); ?>
		<?php echo $form->textField($model,'payment_status'); ?>
		<?php echo $form->error($model,'payment_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added_at'); ?>
		<?php echo $form->textField($model,'added_at'); ?>
		<?php echo $form->error($model,'added_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->