<?php
$this->breadcrumbs=array(
		'Customer'=>array('/admin/customer'),
		'Customer'
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($curAction);?> <?php echo ucwords($curController);?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>
	<div class="portlet-body form">
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?id=$model->id&type=active",
			'id'=>'form_sample_3_customer',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form',
			  'data-type'=>'index'
			)
		)); 
		?>				
			<div class="form-body">
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					You have some form errors. Please check below.
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					Your form validation is successful!
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('first_name'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'first_name',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('last_name'); ?>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'last_name',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('email_address'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'email_address',array( 'class'=>'form-control')); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('country_id'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->dropDownList($model, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'iso_code'),array( 'class'=>'form-control')); ?>
					</div>
				</div>

				
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('telephone'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'telephone',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('password'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->passwordField($model,'password',array( 'class'=>'form-control')); ?>
					</div>
				 </div>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Submit</button>
					<a class="btn default" href="/admin/customer">Cancel</a>
				</div>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<script src="/metronic/custom/form-validation-customer.js?ver=<?php echo strtotime("now");?>"></script>