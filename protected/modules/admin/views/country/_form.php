<?php
$this->breadcrumbs=array(
		'Countries'=>array('/admin/country'),
		'Country'
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
		<?php echo CHtml::beginForm();?>
			<div class="form-body">
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					You have some form errors. Please check below.
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					Your form validation is successful!
				</div>
												
				<div class="row form-group">
					<label class="control-label col-md-3">
						Name<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->name;?>' name='name' required>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Slug<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->slug;?>' name='slug' required>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Iso code<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->iso_code;?>' name='iso_code' required>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Country code<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->country_code;?>'name='country_code' required>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Flage name<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->flag_name;?>' name='flag_name' required>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Staus<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->status;?>' name='status'>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Added at<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->added_at;?>' name='added_at'>	
					</div>
				</div>

				<div class="row form-group">
					<label class="control-label col-md-3">
						Updated at<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" value='<?php echo $model->updated_at;?>' name='updated_at'>	
					</div>
				</div>




				<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Submit</button>
					<a class="btn default" href="/admin/country">Cancel</a>
				</div>
			</div>

		<?php echo CHtml::endForm(); ?>
	</div>
</div>
<script src="/metronic/custom/form-validation-country.js?ver=<?php echo strtotime("now");?>"></script>