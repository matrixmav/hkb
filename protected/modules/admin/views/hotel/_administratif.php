<style>
.contractUploadbutton .btn-file{padding-left:0px;padding-bottom: 0px; height:42px;}
.contractRemoveButton{padding-left:0px;padding-bottom:0px; }
 #uploadContractFile .qq-upload-list{display: none;}
.addedfields{padding: 0;list-style-type: none;}
.addedfields li input, .addedfields li .removeBtn {display: inline-block;vertical-align: top;}
.addedfields li input.textbox{width: 85%;}
</style>
<?php
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Administrative'
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
if(isset($_GET['id']))
{
	$hotelid = $_GET['id'];
	$hoteldets = Hotel::model()->findByPk($hotelid);
	$coutnrycode = Country::model()->findByPk($hoteldets->country_id);
	$codes =  Yii::app()->params['countrycode'];
	foreach($codes as $key=>$value){
		
		if($value == $coutnrycode->iso_code)
		{
			$code = $key;
			
		}
		
	}
	$accountno = Yii::app()->params['accountno'];
	$autocode = $accountno.$code;
}
?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($curAction);?> <?php echo "'".$model->name."' : Administrative";?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>

<div class="portlet-body form">
	<?php 
		$id = isset($model->id)?$model->id:null;
	
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?id=$id&type=administratif",
			'id'=>'form_sample_3_hoteladmin',
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
			<?php echo $adminModel->getAttributeLabel('account_no'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php $random = substr(number_format(time() * mt_rand(),0,'',''),0,5);
				  $random = $autocode.$random;
			 echo $form->textField($adminModel,'account_no',array( 'class'=>'form-control','value'=>($adminModel->account_no)?$adminModel->account_no:$random)); 
			?>
		</div>
	</div>
        <div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $adminModel->getAttributeLabel('hotel_ownfirst_name'); ?>
		</label>
		<div class="col-md-7">
			<?php
			 echo $form->textField($adminModel,'hotel_ownfirst_name',array( 'class'=>'form-control','value'=>($adminModel->hotel_ownfirst_name)?$adminModel->hotel_ownfirst_name:'')); 
			?>
		</div>
	</div>
        <div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $adminModel->getAttributeLabel('hotel_ownlast_name'); ?>
		</label>
		<div class="col-md-7">
			<?php 
			 echo $form->textField($adminModel,'hotel_ownlast_name',array( 'class'=>'form-control','value'=>($adminModel->hotel_ownlast_name)?$adminModel->hotel_ownlast_name:'')); 
			?>
		</div>
	</div>
	<div class="form-group contractUploadbutton">
                    <label class="control-label col-md-3">
							<?php echo $adminModel->getAttributeLabel('contract_file'); ?>
					</label>
                    <div class="fileinput fileinput-exists col-md-7" >
                           <div style=" vertical-align:text-top">                          
                           <span class="btn btn-file" style="max-width:116px">
                               <span>
                                   <!--<input type="file" id="uploadContractFile" name="file" style=""/>-->
                                   <?php $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                                                    'id'=>'uploadContractFile',
                                                    'config'=>array(
                                                           'action'=>Yii::app()->createUrl('admin/hotel/dropzoneupload?id='.$model->id.'&type=pdf'),
                                                           'allowedExtensions'=>array("pdf"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                                           'sizeLimit'=>10000000000,// maximum file size in bytes
                                                           'minSizeLimit'=>.0001*1024*1024,// minimum file size in bytes
                                                           'onComplete'=>"js:function(id, fileName, responseJSON){ fileUpload(responseJSON,fileName); }",
                                                           'messages'=>array(
                                                                            'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                                                            'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                                                            'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                                                            'emptyError'=>"{file} is empty, please select files again without it.",
                                                                            'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                                                           ),
                                                           'showMessage'=>"js:function(message){ alert(message); }"
                                                          )
                                            )); ?>
                               </span>
                       </span>                       
                       <span id="likViFl" class="btn contractRemoveButton">
                           <a id="removeImage" class="btn default fileinput-exists" href="javascript:void(0);" onclick="resetFile();">
                               Reset
                           </a>
                       </span> 
                        <?php if($adminModel->contract_file) { ?>
                        <span id="likViFl" class="btn contractRemoveButton">
                           <a id="removeImage" class="btn default fileinput-exists" href="<?php echo "/admin/hotel/download?hotelId=".$adminModel->hotel_id."&name=" .$adminModel->contract_file; ?>">
                               Download
                           </a>
                       </span>
                        <?php } ?>
                       <span id="fileUploadMessage" style="display:block;"></span>
                    <?php echo $form->hiddenField($adminModel, 'contract_file', array('id'=>'contract_file')); ?>
                                                                                                               <!--<span class="help-block fileinput-exists">Taille : 1920x400</span>-->
               </div>
               </div>
    </div>
    <div class="form-group">
		<label class="control-label col-md-3">
			Contract Anniversary Date<span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'name' => 'contract_start_date',
					'attribute' => 'contract_start_date',
					'model'=>$adminModel,
					'options'=>array(
							'showAnim'=>'fold',
							'dateFormat' => 'yy-mm-dd',
							
					),
					'htmlOptions'=>array(
							'class'=>'form-control'
					),
			));			
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $adminModel->getAttributeLabel('registration_no'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($adminModel,'registration_no',array('class'=>'form-control')); 
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('vat_no'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($adminModel,'vat_no',array('class'=>'form-control')); 
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $adminModel->getAttributeLabel('billing_address'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textArea($adminModel,'billing_address',array('class'=>'form-control','value'=>(($adminModel->billing_address)?$adminModel->billing_address : $model->address))); 
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $adminModel->getAttributeLabel('accounting_info'); ?>
		</label>
		<div class="col-md-7">
			<?php echo $form->textArea($adminModel,'accounting_info',array('class'=>'form-control')); 
			?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			Accounting Email
		</label>
		<div class="col-md-7">
			<ul class="addedfields">
			<?php 
			if(isset($adminModel->id))
			{
				$adminEmails = HotelAdministrativeEmail::model()->findAll('administrative_id='.$adminModel->id);
				
				if(!count($adminEmails))
				{
					$hotelEmail = HotelEmail::findAllByHotel($model->id);
					foreach ($hotelEmail as $ky=>$hEmail):
					echo "<li style='margin-top:5px;'><input type='text' name='HotelAdministrative[email_address][]' class='form-control textbox' value='".$hEmail->email_add."'/>
						<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>
						</li>";
					endforeach;
					
					if(!count($hotelEmail))
						echo "<li style='margin-top:5px;'><input type='text' name='HotelAdministrative[email_address][]' class='form-control textbox' value=''/>
						<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>
						</li>";
				}
				else 
				{
					foreach($adminEmails as $adminEmail){
						echo "<li style='margin-top:5px;'><input type='text' name='HotelAdministrative[email_address][]' class='form-control textbox' value='$adminEmail->email_add'/>
							<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a> 					
						</li>";
					}
				}
			}
			else 
			{
				$hotelEmail = HotelEmail::findAllByHotel($model->id);
				foreach ($hotelEmail as $ky=>$hEmail):
				echo "<li style='margin-top:5px;'><input type='text' name='HotelAdministrative[email_address][]' class='form-control textbox' value='".$hEmail->email_add."'/>
					<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>
					</li>";
				endforeach;
				
				if(!count($hotelEmail))
					echo "<li style='margin-top:5px;'><input type='text' name='HotelAdministrative[email_address][]' class='form-control textbox' value=''/>
					<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>
					</li>";
			
			}
			?>
				
			</ul>
			<a href='#' class='addbutton btn btn-primary' id='addbutton'>Add <i class='fa fa-plus'></i></a>			
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-3"></div>
			<div class="col-md-7"><button type="submit" class="btn green">Submit</button>	
				<a class="btn default" href="/admin/hotel">Cancel</a>		
		</div>	
	</div>
	
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script src="/metronic/custom/form-validation-hoteladmin.js?ver=<?php echo strtotime("now");?>"></script>