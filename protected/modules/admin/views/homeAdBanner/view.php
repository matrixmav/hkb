<?php
/* @var $this HomeAdBannerController */
/* @var $model HomeAdBanner */

$this->breadcrumbs=array(
	'Home Ad Banners'=>array('index'),
	'Ad Banner',
);
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
			'id'=>'form_sample_3_banner',
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
			<?php echo $model->getAttributeLabel('ad_page'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->dropDownList($model, 'ad_page', array('home'=>'Home', 'other'=>'Other'),array('class'=>'form-control select2me')); ?>			
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('ad_pos'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->dropDownList($model, 'ad_pos', array('top'=>'Top', 'bottom'=>'Bottom'),array('class'=>'form-control select2me')); ?>			
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Country<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="country_id" name="HomeAdBanner[country_id]" class="form-control select2me"> 
		<option value"">NA</option> 
		<?php 
			$countries = Country::model()->findAll();
			$i=0;
			foreach($countries as $country){
				$countrySelected="";
				if($country->id == $model->country_id)
					$countrySelected="selected='selected'";
				if($i==0)
				{
					$setcountryid = $country->id;
					$i++;
				}
			?>			
			<option <?php echo $countrySelected?> value="<?php echo $country->id;?>"><?php echo $country->slug;?></option> 
		<?php 	
			}					
		?>		 
		</select>
		<input type="checkbox" name="selectCountry" value="1">
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			State<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="state_id" name="HomeAdBanner[state_id]" class="form-control select2me">  
		<option value"">NA</option>
		
		<?php
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			if(isset($model->id)){
				if(!$model->country_id)
					$model->country_id = $setcountryid;
				$criteria->addCondition("country_id=".$model->country_id);
			}else {
				$criteria->addCondition("country_id=".$setcountryid);
			}
			$states=State::model()->findAll($criteria);
			$s=0;
			foreach($states as $state){
				$stateSelected="";
				if($state->id == $model->state_id)
					$stateSelected="selected='selected'";
				if($s==0)
				{
					$setstateid = $state->id;
					$s++;
				}
			?>			
			<option <?php echo $stateSelected?> value="<?php echo $state->id;?>"><?php echo $state->slug;?></option> 
		<?php 	
			}					
		?>		 
		</select>
		<input type="checkbox" name="selectState" value="1">
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			City<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="city_id" name="HomeAdBanner[city_id]" class="form-control select2me">  
		<option value"">NA</option>
		<?php
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			if(isset($model->id)){
				$setModelstateid = isset($model->state_id)?$model->state_id:1;
				$criteria->addCondition("state_id=".$setModelstateid);
			}else {
				$setstateid = isset($setstateid)?$setstateid:1;
				$criteria->addCondition("state_id=".$setstateid);
			}
			$cities=City::model()->findAll($criteria);
			foreach($cities as $city){
				$citySelected="";
				if($city->id == $model->city_id)
					$citySelected="selected='selected'";
			?>			
			<option <?php echo $citySelected;?> value="<?php echo $city->id;?>"><?php echo $city->slug;?></option> 
		<?php 	
			}					
		?>		 
		</select>
		<input type="checkbox" name="selectCity" value="1">
		</div>
	</div>	
	
	
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
				<a class="btn default" href="/admin/HomeAdBanner"><?php echo Yii::t('translation','Cancel');?></a>				
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
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/lib/markdown.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="/metronic/assets/scripts/custom/components-dropdowns.js"></script>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
jQuery(document).ready(function() {   
   // initiate layout and plugins
   ComponentsDropdowns.init();
});

$("#form_sample_3_banner").submit(function(e){
	e.preventDefault();
    var checked = $("#form_sample_3_banner input:checked").length > 0;
    if (!checked){
        alert("Please check at least one checkbox");
        return false;
    }else{
       if($('input[name=selectCountry]').is(':checked') && ($("#country_id").val()=="" || $("#country_id").val()=="NA")){
      	    alert("Please select country");
   		 	return false;
       }
       if($("input[name=selectState]").is(':checked') && ($("#state_id").val()=="" || $("#state_id").val()=="NA")){
   	    	alert("Please select state");
		 	return false;
       }
       if($("input[name=selectCity]").is(':checked') && ($("#city_id").val()=="" || $("#city_id").val()=="NA")){
   	    	alert("Please select city");
		 	return false;
       }
       var url = $("#form_sample_3_banner").attr("action");
       $.post( url, $("#form_sample_3_banner").serialize())
       .done(function( result ) {
    	   var obj = jQuery.parseJSON(result);
			if(obj.status=="SUCCESS"){
				showSucessMsg("Record saved successfully", "Save Home Banner");
				var currentUrl  = (window.location.pathname);
				if(currentUrl.indexOf("view") > -1){
					// redirect to update Job page
					showSucessMsg("Please wait while we redirecting.", "Page redirection");
					window.location.href = "/admin/homeAdBanner";
					return;
				}		
			}
       }); 	
    }
});


$( "#country_id" ).change(function() {
	$.ajax({
		type: "GET",
		url: "<?php echo Yii::app()->createUrl('admin/hotel/changestate'); ?>",
		data: { country_id: $('#country_id :selected').val(),'selectName':'HomeAdBanner[state_id]'},
		success: function(result){
					$('#state_id').html(result);
			}
		});
});

$( "#state_id" ).change(function() {
	$.ajax({
		type: "GET",
		url: "<?php echo Yii::app()->createUrl('admin/hotel/changecity'); ?>",
		data: { state_id: $('#state_id :selected').val(),'selectName':'HomeAdBanner[city_id]'},
		success: function(result){
					$('#city_id').html(result);
			}
		});
});
</script>
