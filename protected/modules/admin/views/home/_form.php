<?php
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<!-- END PAGE LEVEL SCRIPTS -->

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
			'id'=>'form_sample_3_city',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form'
			)
		)); 
		?>		
			<div class="form-body">
				<h3 class="form-section"><?php if($model->id){?> <?php echo $curController; ?>:<small><?php echo $model->slug;?></small><?php }?></h3>
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
						<?php echo $model->getAttributeLabel('slug'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'slug',array( 'class'=>'form-control')); ?>
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
								<select id="country_id" name='City[country_id]' class="form-control select2me">
								 <?php 
								 $i=0;
								 foreach($countries as $listctry)
								 { 
								 	if(isset($countryid))
								 	{
								 		if($listctry->id == $countryid){
								 			$selected = "selected";
								 		}else {
								 			$selected= "";
								 		}
								 	}
								 	if($i==0)
								 	{
								 		$setcountryid = $listctry->id;
								 		$i++;
								 	}
								 	?>
								 	<option value="<?php echo $listctry->id; ?>" <?php if(isset($selected)){echo $selected;}?>><?php echo $listctry->slug; ?></option>
								 <?php 
								 }
							}
								 ?>
							  	</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('state_id'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
							<?php 
							
							$criteria = new CDbCriteria;
							$criteria->addCondition("status=1");
							if(isset($model->id)){
								$criteria->addCondition("country_id=".$countryid);
							}else {
								$criteria->addCondition("country_id=".$setcountryid);
							}
							$states=State::model()->findAll($criteria);
							if(isset($model->id)){
								$stateid =  $model->state_id;
							}
							if(!empty($states)){?>
								<select id="state_id" name='City[state_id]' class="form-control select2me">
								 <?php 
								 foreach($states as $liststate)
								 { 
								 	if(isset($stateid))
								 	{
								 		if($liststate->id == $stateid){
								 			$selected = "selected";
								 		}else {
								 			$selected= "";
								 		}
								 	}
								 	?>
								 	<option value="<?php echo $liststate->id; ?>" <?php if(isset($selected)){echo $selected;}?>><?php echo $liststate->slug; ?></option>
								 <?php 
								 }
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
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Submit</button>
					<a class="btn default" href="/admin/city">Cancel</a>
				</div>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/lib/markdown.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="/metronic/assets/scripts/custom/components-dropdowns.js"></script>
<script src="/metronic/custom/form-validation-city.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
jQuery(document).ready(function() {   
   // initiate layout and plugins
   ComponentsDropdowns.init();
   FormValidation.init();
});
$( "#country_id" ).change(function() {
$.ajax({
	type: "POST",
	url: "<?php echo Yii::app()->createUrl('admin/city/changestate'); ?>",
	data: { countryid: $('#country_id :selected').val()},
	success: function(result){
				$('#state_id').html(result);
		}
	});
});
</script>