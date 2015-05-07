<?php
/* @var $this TransactionController */
/* @var $model Transaction */
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
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mode'); ?>
		<?php echo $form->textField($model,'mode',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gateway_id'); ?>
		<?php echo $form->textField($model,'gateway_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'actual_amount'); ?>
		<?php echo $form->textField($model,'actual_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'paid_amount'); ?>
		<?php echo $form->textField($model,'paid_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_rp'); ?>
		<?php echo $form->textField($model,'total_rp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'used_rp'); ?>
		<?php echo $form->textField($model,'used_rp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
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