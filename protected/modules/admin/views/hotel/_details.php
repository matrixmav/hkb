<style>
.addedfields{padding: 0;list-style-type: none;}
.addedfields li input, .addedfields li .removeBtn {display: inline-block;vertical-align: top;}
.addedfields li input.textbox{width: 85%;}
</style>
<?php
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Details'
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
$access = Yii::app()->user->getState('access');
$readonly = "";$disabled = "";
if($access=="manager"){
	$readonly = "readonly";
	$disabled = "disabled";
}
?>
<div class="row">
<div class="col-md-12">
<div class="portlet box green">

	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php
			if($model->name)
				$modelName = "'".$model->name."'";
			else 
				$modelName ="";
			echo ucwords($curAction);?> <?php echo $modelName." : Details";?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>

<div class="portlet-body form">
	<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?type=details&id=$model->id",
			'id'=>'form_sample_3_hotel',
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
			<?php echo $model->getAttributeLabel('status'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<div data-error-container="#form_2_membership_error" class="radio-list">
				<label>
				<input type="radio" value="1" <?php echo $disabled;?> name="Hotel[status]" <?php echo ($model->status==1)?"checked":"";?>></span>
				Active </label>
				<label>
				<input type="radio" value="0" <?php echo $disabled;?> name="Hotel[status]" <?php echo ($model->status==0)?"checked":"";?>>
				Inactive </label>
                                <label>
				<input type="radio" value="2" <?php echo $disabled;?> name="Hotel[status]" <?php echo ($model->status==2)?"checked":"";?>>
				Closed</label>
			</div>
			<span for="Hotel[status]" class="help-block"></span>
		</div>
            <input type="hidden" name="prev_hotel_status" value="<?php echo $model->status; ?>">
	</div>
	
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('timezone'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<?php  echo $form->dropDownList($model,'timezone', Yii::app()->params->timeZone,array( 'class'=>'form-control select2me','disabled'=>$disabled));?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">Portal
		<span class="required">
			 *
		</span>
		</label>
		<div class="col-md-4">
			<div class="checkbox-list" data-error-container="#form_2_services_error">
			<?php 
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$portals = Portal::getAllPortal($criteria);
			foreach($portals as $portal){
				$criteria = new CDbCriteria;
				$criteria->addCondition("hotel_id=:p1");
				$criteria->addCondition("portal_id=:p2");
				$criteria->params = array(':p1'=>$model->id,':p2'=>$portal->id);
				$hotelPortal = HotelPortal::getAllHotelPortal($criteria);
				$portalSelected ="";
				if($hotelPortal)
					$portalSelected = "checked";
			?>
			<input type="checkbox" <?php echo $portalSelected;?> <?php echo $disabled;?> name="Hotel[portal][]" value="<?php echo $portal->id;?>"><?php echo $portal->name;?><br> 
			<?php 	
				}					
			?>
			</div>
			<span for="Hotel[portal][]" class="help-block"></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'name',array( 'class'=>'form-control','readonly'=>$readonly)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">Group</label>
		<div class="col-md-7">
		<select <?php echo $disabled;?> name="Hotel[group_parent_id]" id="group_id" class="form-control select2me"> 
		<option value=""></option> 
		<?php
			$groupsSelData = Group::model()->findByPk($model->group_id);
			$parentGroupId = 0;
			if(isset($groupsSelData)){
				$parentGroupId = $groupsSelData->parent_id;
			}
			$groupCriteria = new CDbCriteria();
			$groupCriteria->addCondition("parent_id=0");
			$groups = Group::getAllGroup($groupCriteria);
			foreach($groups as $group){
				$groupSelected="";
				if($group->id == $parentGroupId)
					$groupSelected="selected='selected'";
					
			?>			
			<option <?php echo $groupSelected;?> value="<?php echo $group->id;?>"><?php echo $group->name;?></option> 
		<?php 	
			}					
		?>		 
		</select>
		
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">Chain</label>
		<div class="col-md-7">
		<select <?php echo $disabled;?> name="Hotel[group_id]" id="chain_id" class="form-control select2me"> 
		<option value=""></option> 
		<?php 
		if($model->group_id)
		{
			//$groups = Group::getAllGroup();			
			$groupCriteria = new CDbCriteria();
			$groupCriteria->addCondition("parent_id=".$parentGroupId);
			$groups = Group::getAllGroup($groupCriteria);
			
			foreach($groups as $group){
				$groupSelected="";
				if($group->id == $model->group_id)
					$groupSelected="selected='selected'";
					
			?>			
			<option <?php echo $groupSelected;?> value="<?php echo $group->id;?>"><?php echo $group->name;?></option> 
		<?php 	
			}	
		}				
		?>		 
		</select>
		
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('star_rating'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->dropDownList($model, 'star_rating', array('0'=>'0', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5'),array('class'=>'form-control select2me','disabled'=>$disabled)); ?>			
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('address'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textArea($model,'address',array( 'class'=>'form-control','disabled'=>$disabled)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('postal_code'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'postal_code',array( 'class'=>'form-control','disabled'=>$disabled)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Country<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select <?php echo $disabled;?> id="country_id" name="Hotel[country_id]" class="form-control select2me">  
		<?php
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$countries = Country::getAllCountry($criteria);
			$setcountryid = '';
			$i=0;
			foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['id']."'>".strtoupper($cn['name'])."</option>";
                                endforeach;
							
											
		?>		 
		</select>
		
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			State<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select id="state_id" <?php echo $disabled;?> name="Hotel[state_id]" class="form-control select2me">  
		<?php
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$setcountryid = Yii::app()->params['default']['countryId']; 
			if(isset($model->id)){
				$setCountryIdPre = isset($model->state_id)?$model->country_id: Yii::app()->params['default']['countryId'];
				$criteria->addCondition("country_id=".$setCountryIdPre);
			}else {
				$setcountryid = isset($setcountryid)?$setcountryid:Yii::app()->params['default']['countryId'];
				$criteria->addCondition("country_id=".$setcountryid);//$setcountryid
			}
			$states=State::getAllState($criteria);
			$s=0;
			foreach($states as $state){
				$stateSelected="";
				if($state->id == $model->state_id) {
					$stateSelected="selected='selected'";
				} else {
					$stateSelected="";
				}
					
				if($s==0)
				{
					$setstateid = $state->id;
					$s++;
				}
			?>			
			<option <?php echo $stateSelected?> value="<?php echo $state->id;?>"><?php echo $state->name;?></option> 
		<?php 	
			}					
		?>		 
		</select>
		
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			City<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select <?php echo $disabled;?> id="city_id" name="Hotel[city_id]" class="form-control select2me">  
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
			$cities=City::getAllCity($criteria);
			foreach($cities as $city){
				$citySelected="";
				if($city->id == $model->city_id) {
					$citySelected = "selected='selected'";
				} else {
					$citySelected = "";
				}
			?>			
			<option <?php echo $citySelected;?> value="<?php echo $city->id;?>"><?php echo $city->name;?></option> 
		<?php 	
			}					
		?>		 
		</select>
                <input type="hidden" name="Hotel[city_before]" id="city_before" value="<?php echo $model->city_id;?>">
                <input type="hidden" name="Hotel[longitude]" id="Hotel_longitude" value="<?php echo ($model->longitude)?$model->longitude:""; ?>">
                <input type="hidden" name="Hotel[latitude]" id="Hotel_latitude" value="<?php echo ($model->latitude)?$model->latitude:""; ?>">
		</div>
	</div>		
	<div id="map" class="row form-group">
		<label class="control-label col-md-3">
			<?php echo "Map"; ?>
		</label>
		<div id="map-canvas" class="col-md-7 margin-left15"></div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Currency
		<span class="required">
			 *
		</span>
		</label>
		<div class="col-md-4">
			<div class="checkbox-list" data-error-container="#form_2_services_error">
			<?php 
			$currencies = Currency::getAllCurrency();
			foreach($currencies as $currency){
				$criteria = new CDbCriteria;
				$criteria->addCondition("hotel_id=:p1");
				$criteria->addCondition("currency_id=:p2");
				$criteria->params = array(':p1'=>$model->id,':p2'=>$currency->id);
				$hotelCurrency = HotelCurrency::getAllHotelCurrency($criteria);
				$currencySelected ="";
				if($hotelCurrency || ($model->default_currency_id == $currency->id))
					$currencySelected = "checked";
			?>
			<input type="checkbox" <?php echo $disabled;?> <?php echo $currencySelected?> name="Hotel[currency][]" value="<?php echo $currency->id;?>"><?php echo $currency->name;?><br> 
			<?php 	
				}					
			?>
			</div>
			<span for="Hotel[currency][]" class="help-block"></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Language<span class="required"> * </span>
		</label>
		<div class="col-md-7">
		<select <?php echo $disabled;?> name="Hotel[language_id]" class="form-control select2me">  
		<?php 
			$languages = Language::getAllLanguage();
			foreach($languages as $language){
			?>			
			<option value="<?php echo $language->id;?>"><?php echo $language->name;?></option> 
		<?php 	
			}					
		?>		 
		</select>
		
		</div>
	</div>	
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('website'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'website',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Email<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<ul class="addedfields">
			<?php 
			$hotelEmail = HotelEmail::findAllByHotel($model->id);
                        $no_email=0;
                        if(count($hotelEmail)) {                        
			foreach ($hotelEmail as $ky=>$hEmail):
                                $add_remove = ($no_email==0)? "" : "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>";
				echo "<li style='margin-top:5px;'><input type='text' id='email_add".$no_email."' name='HotelDetail[email_address][".$no_email."]' class='form-control textbox' value='".$hEmail->email_add."'/>".$add_remove."</li>";
                                        $no_email ++;
			endforeach;
                        }
			else{
				echo "<li style='margin-top:5px;'>"
                            . "<input type='text' id='email_add1' name='HotelDetail[email_address][0]' class='form-control textbox' value=''/>"
                                        . "</li>";
                        }
			?>
			</ul>
			<a href='#' class='addbutton btn btn-primary' id='addbutton'>Add <i class='fa fa-plus'></i></a>			
		</div>
	</div>	
				
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('telephone'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'telephone',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('fax'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'fax',array( 'class'=>'form-control')); ?>
		</div>
	</div>
            <div class="row form-group">                
                <div class="col-md-12"><br/></div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"></label>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-4"><small>Firstname Lastname</small></div>
                        <div class="col-md-3"><small>Telephone</small></div>
                        <div class="col-md-5"><small>Email Address</small></div>
                    </div>
                    </div>
            </div>
        <?php
        $con_cn = 0;
        $hotelcontact = NULL;
        foreach(Yii::app()->params->hotel_contact_info as $cky=>$cval):
            if($model->id!='')
                $hotelcontact = HotelContact::model()->find('hotel_id='.$model->id.' and contact_type='.$cky);
        $con_cn ++;
        $con_req = ($con_cn==1)? '<span class="required"> * </span>' : '';            
        ?>
        <div class="form-group">
		<label class="control-label col-md-3"><?php echo $cval; ?><?php echo $con_req;?></label>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control dvalid freesale" name="HotelContact[<?php echo $cky?>][name]" type="text" maxlength="140" value="<?php echo ($hotelcontact!=NULL)? ($hotelcontact->first_name.' '.$hotelcontact->last_name) : "";?>"/>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control dvalid freesale" name="HotelContact[<?php echo $cky?>][telephone]" type="text" maxlength="15" value="<?php echo ($hotelcontact!=NULL)? $hotelcontact->telephone : "";?>"/>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control dvalid freesale" name="HotelContact[<?php echo $cky?>][email_address]" type="text" maxlength="140" value="<?php echo ($hotelcontact!=NULL)? $hotelcontact->email_address : "";?>"/>
                        </div>
                    </div>
                </div>
	</div>
        <?php
        endforeach;
        ?>
            <div class="row form-group">                
                <div class="col-md-12"><br/></div>
            </div>
	<!--<div class="form-group">
		<label class="control-label col-md-3">
			Commercial Contact Information<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textArea($model,'com_con_info',array( 'class'=>'form-control','disabled'=>$disabled)); ?>
		</div>
	</div>-->
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('day_commission'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'day_commission',array( 'class'=>'form-control','readonly'=>$readonly)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('night_commission'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'night_commission',array( 'class'=>'form-control','readonly'=>$readonly)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('addon_commission'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'addon_commission',array( 'class'=>'form-control','readonly'=>$readonly)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Auth Decrease Days
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'auth_dec',array( 'class'=>'form-control','readonly'=>$readonly)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('is_new'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<div data-error-container="#form_2_membership_error" class="radio-list">
				<label>
				<input <?php echo $disabled;?> type="radio" value="1" name="Hotel[is_new]" <?php echo ($model->is_new==1)?"checked":"";?>></span>
				New </label>
				<label>
				<input <?php echo $disabled;?> type="radio" value="0" name="Hotel[is_new]" <?php echo ($model->is_new==0)?"checked":"";?>>
				Old </label>
			</div>
			<span for="Hotel[is_new]" class="help-block"></span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('is_feature'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<div data-error-container="#form_2_membership_error" class="radio-list">
				<label>
				<input <?php echo $disabled;?> type="radio" value="1" name="Hotel[is_feature]" <?php echo ($model->is_feature==1)?"checked":"";?>></span>
				Yes </label>
				<label>
				<input <?php echo $disabled;?> type="radio" value="0" name="Hotel[is_feature]" <?php echo ($model->is_feature==0)?"checked":"";?>>
				No </label>
			</div>
			<span for="Hotel[is_feature]" class="help-block"></span>
		</div>
	</div>
	
	<div id="feature_till" class="form-group">
		<label class="control-label col-md-3">
			Feature till date
		</label>
		<div class="col-md-7">
			<?php
			$date = new DateTime(); // Todays date
			$interval = new DateInterval('P15D'); // Period of 15 days
			$date->add($interval); // $date interval added in current date
			//echo $date->format('Y-m-d');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'name'=>'feature_till_date',
					'attribute' => 'feature_till_date',
					'model'=>$model,
					// additional javascript options for the date picker plugin
					'options'=>array(
							'showAnim'=>'fold',
							'dateFormat' => 'yy-mm-dd',
							'defaultDate'=>isset($model->feature_till_date)?$model->feature_till_date:$date->format('Y-m-d'),
					),
					'htmlOptions'=>array(
							'class'=>'form-control',
							'disabled'=>$disabled,
							'value'=>isset($model->feature_till_date)?$model->feature_till_date:$date->format('Y-m-d'),
								
					),
			));			
			?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Theme
		</label>
		<div class="col-md-7">
		<?php 
			$themes = Theme::getAllTheme();
			foreach($themes as $theme){
				$criteria = new CDbCriteria;
				$criteria->addCondition("hotel_id=:p1");
				$criteria->addCondition("theme_id=:p2");
				$criteria->params = array(':p1'=>$model->id,':p2'=>$theme->id);
				$hotelTheme = HotelTheme::getAllHotelTheme($criteria);
				$themeSelected ="";
				if($hotelTheme)
					$themeSelected = "checked";
			?>
			<input <?php echo $themeSelected;?> type="checkbox" class="form-control" name="Hotel[theme][]" value="<?php echo $theme->id;?>"><?php echo $theme->name;?><br> 
		<?php 	
			}					
		?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">
			Equipment
		</label>
		<div class="col-md-7">
		<table>
		<tr>
		    <td>Hotel</td>
		    <td>Room</td>
		</tr>
		<tr>
		<td>
		<?php 
				$criteria = new CDbCriteria;
				$criteria->addCondition("type='hotel'");
				$criteria->addCondition("hotel_id=0");
				$criteria->addCondition("base_type=0");
				$equipments = Equipment::getAllEquipment($criteria);
				foreach($equipments as $equipment){
				$criteria = new CDbCriteria;
					$criteria->addCondition("t.hotel_id=:p1");
					$criteria->with = array("equipment");				
					$criteria->addCondition("equipment.type='hotel'");
					$criteria->addCondition("equipment.hotel_id=0");
					$criteria->addCondition("t.equipment_id=:p2");
	                                $criteria->order = "equipment.show_order ASC";
					$criteria->params = array(':p1'=>$model->id,':p2'=>$equipment->id);
					$hotelEquipment = HotelEquipment::getAllHotelEquipment($criteria);
					$equipmentSelected ="";
					if($hotelEquipment)
						$equipmentSelected = "checked";
				?>
					<input <?php echo $equipmentSelected;?> type="checkbox" class="form-control" name="Hotel[equipment][]" value="<?php echo $equipment->id;?>"><?php echo $equipment->name;?><br> 
			<?php } ?>
		</td>
		<td  style="vertical-align: top;">
		<?php 
				$criteria = new CDbCriteria;
				$criteria->addCondition("type='room'");
				$criteria->addCondition("hotel_id=0");
				$criteria->addCondition("base_type=0");
				$equipments = Equipment::getAllEquipment($criteria);
				foreach($equipments as $equipment){
					$criteria = new CDbCriteria;
					$criteria->addCondition("t.hotel_id=:p1");
					$criteria->with = array("equipment");				
					$criteria->addCondition("equipment.type='room'");
					$criteria->addCondition("equipment.hotel_id=0");
					$criteria->addCondition("t.equipment_id=:p2");
					$criteria->params = array(':p1'=>$model->id,':p2'=>$equipment->id);
					$hotelEquipment = HotelEquipment::getAllHotelEquipment($criteria);
					$equipmentSelected ="";
					if($hotelEquipment)
						$equipmentSelected = "checked";
			?>
			<input <?php echo $equipmentSelected;?> type="checkbox" class="form-control" name="Hotel[equipment][]" value="<?php echo $equipment->id;?>"><?php echo $equipment->name;?><br> 
		<?php 	
			}					
		?>
		</td>
		</tr>
		</table>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green">Submit</button>	
				<a class="btn default" href="/admin/hotel">Cancel</a>			
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
<?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
<style>
      #map-canvas {
        width: 300px;
        height: 200px;
      }
</style>
  
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-hotel.js?ver=<?php echo strtotime("now"); ?>"></script>
<!--<script src="http://maps.googleapis.com/maps/api/js"></script>-->

<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
var stateUrl = "<?php echo Yii::app()->createUrl('admin/hotel/changestate'); ?>";
var cityUrl = "<?php echo Yii::app()->createUrl('admin/hotel/changecity'); ?>";
var chainUrl = "<?php echo Yii::app()->createUrl('admin/hotel/changegroupchain'); ?>";
var action = "<?php echo $curAction; ?>";
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) { 
  geocoder.geocode({
    latLng: pos
  }, function(responses) { 
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) { 
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) { 
    $("#Hotel_longitude").val(latLng.lng());
    $("#Hotel_latitude").val(latLng.lat());
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

function updateMarkerAddress(str) { 
  document.getElementById('address').innerHTML = str;
}

//function initialize() { alert("6");
//
//    var longitude = $("#Hotel_longitude").val();
//    var latitude = $("#Hotel_latitude").val();
//    alert(longitude);
//    alert(latitude);
//  var latLng = new google.maps.LatLng(longitude, latitude);
//  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
//    zoom: 8,
//    center: latLng,
//    mapTypeId: google.maps.MapTypeId.ROADMAP
//  });
//  var marker = new google.maps.Marker({
//    position: latLng,
//    title: 'Point A',
//    map: map,
//    draggable: true
//  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);

  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });

  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });

  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });

// Onload handler to fire off the app.
/*google.maps.event.addDomListener(window, 'load', initialize);*/
</script> 
<div id="mapCanvas" style="display:none;"></div>
<div id="infoPanel" style="display:none;">
    <b>Marker status:</b>
    <div id="markerStatus"><i>Click and drag the marker.</i></div>
    <b>Current position:</b>
    <div id="info"></div>
    <b>Closest matching address:</b>
    <div id="address"></div>
</div>