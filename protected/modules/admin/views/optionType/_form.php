<?php
$this->breadcrumbs=array(
		'Option Types'=>array('/admin/optionType'),
		'Option Type'
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
			'id'=>'form_option-type',
			'method'=>'post',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form'
			)
		)); 
		?>	
<div class="form-body">
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		<?php echo Yii::t('translation','You have some form errors. Please check below.');?>
	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		<?php echo Yii::t('translation','Your form validation is successful!');?>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'name',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('description'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textArea($model,'description',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('price'); ?><span class="required"> </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'price',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('currency_id'); ?><span class="required"> </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->dropDownList($model,'currency_id', CHtml::listData(Currency::model()->findAll(array('order' => 'id ASC')), 'id', 'code'), array('empty'=>'Select currency', 'class'=>'form-control select2me')); ?>
		</div>
	</div>
		
	<div class="row">
		<div class="">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
				<a class="btn default" href="/admin/optionType"><?php echo Yii::t('translation','Cancel');?></a>				
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-theme.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->