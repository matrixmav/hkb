<?php
$this->breadcrumbs=array(
		'Change Password'
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
			'id'=>'form_admin_profile',
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
					You have some form errors. Please check below.
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					Your form validation is successful!
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
					Old Password	
					</label>
					<div class="col-md-7">
						<input type="text" name="AdminUser[passwordOrig]" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
					New Password	
					</label>
					<div class="col-md-7">
						<input type="text" name="AdminUser[password]" id="password" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
					Confirm Password	
					</label>
					<div class="col-md-7">
						<input type="text" name="AdminUser[passwordSecond]" class="form-control">
					</div>
				</div>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Submit</button>
					<a class="btn default" href="/admin/city">Cancel</a>
				</div>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<script src="/metronic/custom/form-validation-adminprofile.js?ver=<?php echo strtotime("now");?>"></script>
</div>