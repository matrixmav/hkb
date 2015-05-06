<?php
$this->breadcrumbs=array(
		'Options'=>array('/admin/option'),
		'Option'
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
			'id'=>'default_option_create',
			'method'=>'POST',
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
			<?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'name',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('option_type_id'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
			<?php echo $form->dropDownList($model,'option_type_id', CHtml::listData(OptionType::model()->findAll(array('order' => 'id ASC')), 'id', 'name'), array('class'=>'form-control select2me')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php 
				$ccRequiredArr[1] = "Yes";
				$ccRequiredArr[0] = "No"; ?>
			<?php echo $model->getAttributeLabel('cc_required'); ?><span class="required"></span>
		</label>
		<div class="col-md-7">
			<?php echo CHtml::dropDownList('Equipment[cc_required]', $model->cc_required, $ccRequiredArr, array('class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('default_price'); ?><span class="required"></span>
		</label>
		<div class="col-md-7">
			<?php echo $form->textField($model,'default_price',array( 'class'=>'form-control')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('currency_id'); ?><span class="required"></span>
		</label>
		<div class="col-md-7">
			<?php echo $form->dropDownList($model,'currency_id', CHtml::listData(Currency::model()->findAll(array('order' => 'id ASC')), 'id', 'code'), array('empty'=>'Select currency', 'class'=>'form-control select2me')); ?>
		</div>
	</div>
	
	<?php $getlanguage = Language::model()->findall();?>
	<?php foreach($getlanguage as $language){?>
		<h4 style="margin-left:135px;"><?php echo $language->code. " : ";?></h4>
		<div class="form-group">
			<label class="control-label col-md-3"><?php echo Yii::t('translation','Description');?></label>
			<div class="col-md-7">
				<textarea  name="Equipment[OptionInfo][<?php echo $language->id; ?>][description]" class = "form-control" ><?php if(!empty($optionInfo[$language->id]['description'])){echo $optionInfo[$language->id]['description'];}?></textarea>
			</div>
		</div>
	
		<div class="form-group">
			<label class="control-label col-md-3"><?php echo Yii::t('translation','Terms');?></label>
			<div class="col-md-7">
				<textarea name="Equipment[OptionInfo][<?php echo $language->id; ?>][term]" class = "form-control"><?php if(!empty($optionInfo[$language->id]['term_condition'])){echo $optionInfo[$language->id]['term_condition'];}?></textarea>
			</div>
		</div>
	<?php } ?>
	
	<div class="row">
		<div class="">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>	
				<a class="btn default" href="/admin/equipment"><?php echo Yii::t('translation','Cancel');?></a>			
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
var FormValidation = function () {
	  var handleValidation1 = function() {
      // for more info visit the official plugin documentation: 
          // http://docs.jquery.com/Plugins/Validation

          var form1 = $('#default_option_create');
          var error1 = $('.alert-danger', form1);
          var success1 = $('.alert-success', form1);

          form1.validate({
              errorElement: 'span', //default input error message container
              errorClass: 'help-block', // default input error message class
              focusInvalid: false, // do not focus the last invalid input
              ignore: "",
              rules: {
              	'Option[name]': {
                      required: true
                  },
                  'Option[option_type_id]': {
                      required: true
                  },
                  'Option[cc_required]': {
                      required: true
                  },
                  'Option[default_price]': {
                      required: true
                  },
                  'Option[currency_id]': {
                      required: true
                  },
              },

              invalidHandler: function (event, validator) { //display error alert on form submit              
                  success1.hide();
                  error1.show();
                  App.scrollTo(error1, -200);
              },

              highlight: function (element) { // hightlight error inputs
                  $(element)
                      .closest('.form-group').addClass('has-error'); // set error class to the control group
              },

              unhighlight: function (element) { // revert the change done by hightlight
                  $(element)
                      .closest('.form-group').removeClass('has-error'); // set error class to the control group
              },

              success: function (label) {
                  label
                      .closest('.form-group').removeClass('has-error'); // set success class to the control group
              },

              submitHandler: function (form) {
                  //success1.show();
                  error1.hide();                    
					$form=$("#default_option_create");
					var values = {};
					$.each($form.serializeArray(), function (i, field) {
					    values[field.name] = field.value;
					});
					//Value Retrieval Function
					var getValue = function (valueName) {
					    return values[valueName];
					};
					//Retrieve the Values
					var type = getValue("Option[type]");
					
					$.ajax({
						dataType:'json',
						type: "get",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) {
							if(result.status=="SUCCESS"){
								showSucessMsg("Record saved successfully", "Save Equipment");
								var currentUrl  = (window.location.pathname);
								if(currentUrl.indexOf("create") > -1 || currentUrl.indexOf("update") > -1){
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting.", "Page redirection");
									window.location.href = "/admin/option";
									return;
								}	
							}else if(result.status=="NAME-ERROR"){
								showError("Name already exists");
							}else {
								showError("Error in saving record");
							}
							App.unblockUI();
						},
						error:function(status, respone, error) {
							showError("Unable to process the request");
							App.unblockUI();
						}
					});
              }
          });

  }


  return {
      //main function to initiate the module
      init: function () {
          handleValidation1();
      }

  };

}();
</script>