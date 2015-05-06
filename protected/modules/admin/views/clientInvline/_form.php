<?php
/* @var $this ClientInvlineController */
/* @var $model ClientInvline */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'client-invline-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'client_inv_no'); ?>
		<?php echo $form->textField($model,'client_inv_no',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'client_inv_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_price'); ?>
		<?php echo $form->textField($model,'unit_price'); ?>
		<?php echo $form->error($model,'unit_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wv_amt'); ?>
		<?php echo $form->textField($model,'wv_amt'); ?>
		<?php echo $form->error($model,'wv_amt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vat'); ?>
		<?php echo $form->textField($model,'vat'); ?>
		<?php echo $form->error($model,'vat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vat_amt'); ?>
		<?php echo $form->textField($model,'vat_amt'); ?>
		<?php echo $form->error($model,'vat_amt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tot_amt'); ?>
		<?php echo $form->textField($model,'tot_amt'); ?>
		<?php echo $form->error($model,'tot_amt'); ?>
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