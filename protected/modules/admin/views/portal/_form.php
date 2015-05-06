<?php
$this->breadcrumbs=array(
		'Portals'=>array('/admin/portal'),
		'Portal'
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
			'id'=>'form_sample_3_portal',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form'
			)
		)); 
		?>		
			<div class="form-body">
				<h3 class="form-section"><?php if($model->id){?> <?php echo $curController; ?>:<small><?php echo $model->name;?></small><?php }?></h3>
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
						<?php echo $model->getAttributeLabel('slug'); ?>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'slug',array( 'class'=>'form-control')); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('url'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'url',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('headtitle'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php
						//$users = CHtml::listData(User::model()->findAll(),'idios','idios');
						//echo $form->dropDownList($model, 'idUser',$users, array("class"=>"form-control select2me",  'empty'=>"(Select User)"));
						echo $form->textField($model,'headtitle',array( 'class'=>'form-control'));
						?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('contact_email'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'contact_email',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('booking_email'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'booking_email',array( 'class'=>'form-control')); ?>
					</div>
				</div>
		

				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('telephone_std'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'telephone_std',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				<div id="addcontact">
				</div>
				<div class="form-group" id="addtelfeilds">
					<label class="control-label col-md-3">
						Portal Contacts
					</label> 
					<div class="col-md-5">

						<div id="addtxboxes">
						<?php 
						$countryIdArray = array();
						if($model->id){
							$criteria = new CDbCriteria;
							$criteria->addCondition("portal_id='$model->id'");
							$portalContacts = PortalContact::model()->findAll($criteria);
							foreach($portalContacts as $portalContact){
								$iso = @$portalContact->country->iso_code;
								$country_id = @$portalContact->country_id;
								$telephone = @$portalContact->telephone;
								$countryIdArray[] = $country_id;?>
								<span class="pull-left" style='text-transform: uppercase;width:20%;' >Tel_<?php echo $iso;?>:</span> <input  class="form-control pull-left" style="width:80%" type='text' name='PortalContact[<?php echo $country_id;?>]' value="<?php echo $telephone;?>" /> <br /><br /><br />
							<?php 
							}
						}	?>
						</div>
						<div>
							<?php 
							$criteria = new CDbCriteria;
							$criteria->addNotInCondition("id",$countryIdArray);
							$criteria->addCondition("status=1");
							$countries=Country::model()->findAll($criteria);
							if(!empty($countries)){?>
							<div class="form-group">
					<div class="col-md-12">
								<select id="country_id" class="form-control select2me">
								 <?php 
								 foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['id']."'>".strtoupper($cn['name'])."</option>";
                                endforeach;
								 ?>
							  	</select>
							  	</div>
							  	</div>
							  	<div class="form-group" id="countrybox">
								<div class="col-md-12" id="countrytext">
							  	<input type="text" id="countryval" class="form-control" value=""/></div>
								<a class="btn green margin-topDefault margin-left15" id="addvalue" >Add</a>
								</div>
								<div id="errmsgfp" style="color:red;"></div>
						  	<?php 
							}?>
							
						</div>
					</div>
				</div>						
			</div>
			
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Submit</button>
					<a class="btn default" href="/admin/portal">Cancel</a>
				</div>
			</div>
		<?php $this->endWidget(); ?>
	</div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-portal.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
var transDigits = "<?php echo Yii::t('translation','Digits Only');?>";
</script>