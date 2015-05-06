<?php
/* @var $this InvoiceController */
/* @var $model Invoice */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'inv_no'); ?>
		<?php echo $form->textField($model,'inv_no',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'inv_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv_date'); ?>
		<?php echo $form->textField($model,'inv_date'); ?>
		<?php echo $form->error($model,'inv_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv_month'); ?>
		<?php echo $form->textField($model,'inv_month'); ?>
		<?php echo $form->error($model,'inv_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv_year'); ?>
		<?php echo $form->textField($model,'inv_year'); ?>
		<?php echo $form->error($model,'inv_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hotel_id'); ?>
		<?php echo $form->textField($model,'hotel_id'); ?>
		<?php echo $form->error($model,'hotel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_no'); ?>
		<?php echo $form->textField($model,'account_no',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'account_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inv_label'); ?>
		<?php echo $form->textField($model,'inv_label',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'inv_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hotel_inv'); ?>
		<?php echo $form->textField($model,'hotel_inv'); ?>
		<?php echo $form->error($model,'hotel_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vat_amt'); ?>
		<?php echo $form->textField($model,'vat_amt'); ?>
		<?php echo $form->error($model,'vat_amt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_inv'); ?>
		<?php echo $form->textField($model,'total_inv'); ?>
		<?php echo $form->error($model,'total_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paid_inv'); ?>
		<?php echo $form->textField($model,'paid_inv'); ?>
		<?php echo $form->error($model,'paid_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pending_inv'); ?>
		<?php echo $form->textField($model,'pending_inv'); ?>
		<?php echo $form->error($model,'pending_inv'); ?>
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