<?php
/* @var $this InvoiceController */
/* @var $model Invoice */
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
		<?php echo $form->label($model,'inv_no'); ?>
		<?php echo $form->textField($model,'inv_no',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inv_date'); ?>
		<?php echo $form->textField($model,'inv_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inv_month'); ?>
		<?php echo $form->textField($model,'inv_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inv_year'); ?>
		<?php echo $form->textField($model,'inv_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hotel_id'); ?>
		<?php echo $form->textField($model,'hotel_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_no'); ?>
		<?php echo $form->textField($model,'account_no',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inv_label'); ?>
		<?php echo $form->textField($model,'inv_label',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hotel_inv'); ?>
		<?php echo $form->textField($model,'hotel_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vat_amt'); ?>
		<?php echo $form->textField($model,'vat_amt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_inv'); ?>
		<?php echo $form->textField($model,'total_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid_inv'); ?>
		<?php echo $form->textField($model,'paid_inv'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pending_inv'); ?>
		<?php echo $form->textField($model,'pending_inv'); ?>
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