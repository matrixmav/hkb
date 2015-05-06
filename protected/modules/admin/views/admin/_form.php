<style>
.addedfields{padding: 0;list-style-type: none;}
.addedfields li input, .addedfields li .removeBtn {display: inline-block;vertical-align: top;}
.addedfields li input.textbox{width: 85%;}
</style>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<?php
$this->breadcrumbs=array(
		'Hotel Managers'=>array('/admin/admin'),
		'Manager'
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
$access = Yii::app()->user->getState('access');
$form_title = ($manager_id == 0) ? "Create Hotel Manager" : "Update Hotel Manager";
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo $form_title;?></div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>

<div class="portlet-body form">
	<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?id=$model->id",
			'id'=>'form_admin_user',
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
			<?php echo $model->getAttributeLabel('first_name'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'first_name',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('last_name'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'last_name',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	

	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('Country code'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<select class='form-control'>
				<?php
					foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                        $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                        echo "<option ".$selected." value='".$cn['country_code']."'>".strtoupper($cn['iso_code'])."(+".$cn['country_code'].")</option>";
                    endforeach;
				?>
			</select>
		</div>
	</div>



	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('telephone'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'telephone',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('email_address'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'email_address',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	<?php 
	$password = "password";
	if($model->id){
		$password = $model->password;
	}?>
		<input type="hidden" name="AdminUser[password]" value="<?php echo $password;?>"/>
		<input type="hidden" name="AdminUser[type]" value="hotel"/>
		
	<div class="form-group">
		<label class="control-label col-md-3">
			Hotel
		</label>
		<div class="col-md-7">
			<ul class="addedfields">
			<?php
			if(isset($model->id)){
				$hotelAccess = HotelAccess::model()->findAll('user_id='.$model->id);
				foreach($hotelAccess as $hotelAcces){
					$readonly = ($access=="manager")?'readonly':"";
					$hotelName = Hotel::getHotelName($hotelAcces->hotel_id);
					echo "<li style='margin-top:5px;''><input type='text' name='HotelAdministrative[email_address][]' $readonly class='form-control textbox' value='$hotelName'/>
					<input type='hidden' name='AdminUser[hotel_id][]' class='form-control hotelid' value='$hotelAcces->hotel_id'/>";
					if($access!="manager")
						echo "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>";
					echo "</li>";
				}
			}
			?>
				
			</ul>
			<?php if($access!="manager"){?>
			<a href='#' class='addbutton btn btn-primary' id='addbutton'>Add <i class='fa fa-plus'></i></a>		<?php }?>	
		</div>
	</div>	
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
				<a class="btn default" href="/admin/admin"><?php echo Yii::t('translation','Cancel');?></a>				
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
<script src="/metronic/custom/form-validation-adminuser.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->