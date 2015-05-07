<?php
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
			'id'=>'form_sample_3_ourselection',
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
			Country<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="country_id" name="FeaturedHotel[country_id]" class="form-control select2me">  
		<?php 
                $countryObject = BaseClass::getCountryCode();
                foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['id']."'>".strtoupper($cn['name'])."</option>";
                                endforeach;?>
		</select>
		<input type="checkbox" name="selectCountry" value="1">
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			State<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="state_id" name="FeaturedHotel[state_id]" class="form-control select2me">  
		<option value="">NA</option>
		
		<?php
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$setcountryid = Yii::app()->params['default']['countryId'];
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
		<select id="city_id" name="FeaturedHotel[city_id]" class="form-control select2me">  
		<option value="">NA</option>
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
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Hotel<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="city_id" name="FeaturedHotel[hotel_id]" class="form-control select2me">  
		<option value="">NA</option>
		<?php
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$hotels=Hotel::model()->findAll($criteria);
			foreach($hotels as $hotel){
				$hotelSelected="";
				if($hotel->id == $model->hotel_id)
					$hotelSelected="selected='selected'";
			?>			
			<option <?php echo $hotelSelected;?> value="<?php echo $hotel->id;?>"><?php echo $hotel->name;?></option> 
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
				<a class="btn default" href="/admin/ourSelection"><?php echo Yii::t('translation','Cancel');?></a>				
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<script>
$("#form_sample_3_ourselection").submit(function(e){
	e.defaultPrevented;
    var checked = $("#form_sample_3_ourselection input:checked").length > 0;
    if (!checked){
        alert("Please check at least one checkbox");
        return false;
    }else{
       if($('input[name=selectCountry]').is(':checked') && !($("#country_id").val())){
      	    alert("Please select country");
   		 	return false;
       }
       if($("input[name=selectState]").is(':checked') && !($("#state_id").val())){
   	    	alert("Please select state");
		 	return false;
       }
       if($("input[name=selectCity]").is(':checked') && !($("#city_id").val())){
   	    	alert("Please select city");
		 	return false;
       }
       $("#form_sample_3_ourselection").submit();     	
    }
});

$( "#country_id" ).change(function() {
	$.ajax({
		type: "GET",
		url: "<?php echo Yii::app()->createUrl('admin/hotel/changestate'); ?>",
		data: { country_id: $('#country_id :selected').val(),'selectName':'FeaturedHotel[state_id]'},
		success: function(result){
					$('#state_id').html(result);
			}
		});
});

$( "#state_id" ).change(function() {
	$.ajax({
		type: "GET",
		url: "<?php echo Yii::app()->createUrl('admin/hotel/changecity'); ?>",
		data: { state_id: $('#state_id :selected').val(),'selectName':'FeaturedHotel[city_id]'},
		success: function(result){
					$('#city_id').html(result);
			}
		});
});
</script>