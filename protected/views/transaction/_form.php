<?php
/* @var $this TransactionController */
/* @var $model Transaction */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mode'); ?>
		<?php echo $form->textField($model,'mode',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'mode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gateway_id'); ?>
		<?php echo $form->textField($model,'gateway_id'); ?>
		<?php echo $form->error($model,'gateway_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'actual_amount'); ?>
		<?php echo $form->textField($model,'actual_amount'); ?>
		<?php echo $form->error($model,'actual_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid_amount'); ?>
		<?php echo $form->textField($model,'paid_amount'); ?>
		<?php echo $form->error($model,'paid_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_rp'); ?>
		<?php echo $form->textField($model,'total_rp'); ?>
		<?php echo $form->error($model,'total_rp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'used_rp'); ?>
		<?php echo $form->textField($model,'used_rp'); ?>
		<?php echo $form->error($model,'used_rp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
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