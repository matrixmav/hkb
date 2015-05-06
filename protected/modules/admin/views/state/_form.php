<?php
$this->breadcrumbs=array(
		'States'=>array('/admin/state'),
		'State'
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($curAction);?> <?php echo $model->slug;?>
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
			'id'=>'form_sample_3_state',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form',
			  'enctype' => 'multipart/form-data'
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
						<?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'name',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('code'); ?>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'code',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('slug'); ?>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'slug',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				<div class="form-group contractUploadbutton">
                    <label class="control-label col-md-3">
							Image
					</label>
					<div class="col-md-7">
						<input type="file" name="State[image]" id="state_image">
					</div>
    			</div>
					<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('country_id'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
							<?php 
							
							$criteria = new CDbCriteria;
							$criteria->addCondition("status=1");
							$countries=Country::model()->findAll($criteria);
							if(isset($model->id)){
								$countryid =  $model->country_id;
							}
							if(!empty($countries)){?>
								<select id="country_id" name='State[country_id]' class="form-control select2me">
								 <?php 
								 $i=0;
								 foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['id']."'>".strtoupper($cn['name'])."</option>";
                                endforeach;
							}
								 ?>
							  	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('latitude'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'latitude',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('longitude'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'longitude',array( 'class'=>'form-control')); ?>
					</div>
				</div>
			<?php if(!empty($countries)){?>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Submit</button>
					<a class="btn default" href="/admin/state">Cancel</a>
				</div>
			</div>
			<?php }else{
				echo "No Countries Available";
			} ?>
		<?php $this->endWidget(); ?>
	</div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-state.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->