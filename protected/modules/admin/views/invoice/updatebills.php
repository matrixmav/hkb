<?php
$hotel_id = $_GET['hotel_id'];
$this->breadcrumbs=array(
		'Invoices'=>array('/admin/invoice/bills?id='.$hotel_id.'&type=bills'),
		'Invoice'
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
			'action'=>Yii::app()->createUrl($this->route)."?id=$model->id",
			'id'=>'form_invoice',
			'method'=>'get',
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
			<?php echo $model->getAttributeLabel('inv_no'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'inv_no',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('inv_date'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'inv_date',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Hotel Name<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model->hotel,'name',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Account No<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model->hotelAdministratives,'account_no',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Label<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'inv_label',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			HT<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'hotel_inv',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			TVA<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'vat_amt',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			TVA<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'total_inv',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			SOLDE<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'paid_inv',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
				<a class="btn default" href="/admin/invoice"><?php echo Yii::t('translation','Cancel');?></a>				
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<script src="/metronic/custom/form-validation-invoice.js?ver=<?php echo strtotime("now");?>"></script>