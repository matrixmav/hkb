<?php
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Texts'=>array('/admin/hotel/update?type=textes&id='.$model->id),
		'Text'
);
?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    Hotel Name : <b><?php echo $model->name; ?></b>
</div>
<?php 
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
?>
<div class="portlet box green">

	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($curAction);?> <?php echo $model->name;?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>

<div class="portlet-body form">
	<?php 
	$id = isset($model->id)?$model->id:null;
	$contentID = isset($_REQUEST['content_id'])?"content_id=".$_REQUEST['content_id']."&":null;
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?$contentID id=$id&type=textes",
			'id'=>'form_sample_3_hotel',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form',
			  'data-model_id'=>$id
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
			Portal<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select name="HotelContent[portal_id]" class="form-control select2me">  
		<?php 
			$portals = Portal::model()->findAll();
			foreach($portals as $portal){
			?>			
			<option value="<?php echo $portal->id;?>"><?php echo $portal->name;?></option> 
		<?php 	
			}					
		?>	
		</select>
			 
		</div>
	</div>	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('type'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<?php  echo $form->dropDownList($contentModel,'type', Yii::app()->params->hotelContentType,array( 'class'=>'form-control select2me'));?>
		</div>
	</div>
	<?php 
		$languages = Language::model()->findAll();
		
		foreach($languages as $language){
	
			if(($language->id ==$contentModel->language_id) && !empty($contentModel->content)){
			?>
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $language->code; ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			 <textarea id="HotelContent_content_<?php echo $language->id?>" name="HotelContent[content][<?php echo $language->id?>]" class="ckeditor form-control" rows="6"><?php echo $contentModel->content;?></textarea>			
		</div>
	</div>
	<?php }else{ 
	if(!isset($_REQUEST['content_id'])){
	?>
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $language->code; ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			 <textarea id="HotelContent_content_<?php echo $language->id?>" name="HotelContent[content][<?php echo $language->id?>]" class="ckeditor form-control" rows="6"></textarea>			
		</div>
		<span class="help-block"></span>
	</div>
		
	<?php }}}?>
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green">Submit</button>	
				<a class="btn default" href="/admin/hotel/update?id=<?php echo $id;?>&type=textes">Cancel</a>			
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/ckeditor/ckeditor.js"></script>
<script src="/metronic/custom/form-validation-hoteltextes.js?ver=<?php echo strtotime("now");?>"></script>