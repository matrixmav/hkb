<?php
if (isset ( $_GET ['type'] )) {
	$type = $_GET ['type'];
}
if (isset ( $_GET ['id'] )) {
	$hotel_id = $_GET ['id'];
}
$this->breadcrumbs = array (
		'Hotel' => array (
				'/admin/hotel' 
		),
		'Options' 
);
?>
<?php

if (isset ( $hotel_id )) {
	$hotelObject = Hotel::model ()->findByPk ( $hotel_id );
}
?>
				
<?php $access = Yii::app()->user->getState('access'); ?>
<?php $this->renderPartial('/hotel/_hotel_menu', array('model'=>$hotelObject, 'access'=>$access, 'type' => $type)); ?>

<?php $hotel = Hotel::model()->findByPk($_GET['id']);?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i>Options for room associated with <?php echo "'".$hotel->name."'";?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body form">
<?php
$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => '/admin/room/options',
		'id' => 'default_option_create',
		'method' => 'POST',
		'htmlOptions' => array (
				'class' => 'form-horizontal',
				'role' => 'form' 
		) 
) );
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
			<?php echo $model->getAttributeLabel('name'); ?><span
					class="required"> * </span>
				</label>
				<div class="col-md-7">
				<?php echo $form->hiddenField($model,'id'); ?>
				<?php echo $form->hiddenField($model,'hotel_id'); ?>
			<?php echo $form->textField($model,'name',array( 'class'=>'form-control')); ?>
		</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('option_type_id'); ?><span
					class="required"> * </span>
				</label>
				<div class="col-md-7">
			<?php echo $form->dropDownList($model,'option_type_id', CHtml::listData(OptionType::model()->findAll(array('order' => 'id ASC')), 'id', 'name'), array('class'=>'form-control select2me')); ?>
		</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">
			<?php
			$ccRequiredArr [1] = "Yes";
			$ccRequiredArr [0] = "No";
			?>
			<?php echo $model->getAttributeLabel('cc_required'); ?><span class="required"></span>
				</label>
				<div class="col-md-7">
			<?php echo CHtml::dropDownList('Equipment[cc_required]', $model->cc_required, $ccRequiredArr, array('class'=>'form-control select2me')); ?>
		</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('default_price'); ?><span
					class="required"></span>
				</label>
				<div class="col-md-7">
			<?php echo $form->textField($model,'default_price',array( 'class'=>'form-control')); ?>
		</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('currency_id'); ?><span
					class="required"></span>
				</label>
				<div class="col-md-7">
			<?php echo $form->dropDownList($model,'currency_id', CHtml::listData(Currency::model()->findAll(array('order' => 'id ASC')), 'id', 'code'), array('empty'=>'Select currency', 'class'=>'form-control select2me')); ?>
		</div>
			</div>
	
	<?php $getlanguage = Language::model()->findall();?>
	<?php foreach($getlanguage as $language){?>
		<h4 style="margin-left: 135px;"><?php echo $language->code. " : ";?></h4>
			<div class="form-group">
				<label class="control-label col-md-3"><?php echo Yii::t('translation','Description');?></label>
				<div class="col-md-7">
					<textarea
						name="Equipment[OptionInfo][<?php echo $language->id; ?>][description]"
						class="form-control"><?php if(!empty($optionInfo[$language->id]['description'])){echo $optionInfo[$language->id]['description'];}?></textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-3"><?php echo Yii::t('translation','Terms');?></label>
				<div class="col-md-7">
					<textarea
						name="Equipment[OptionInfo][<?php echo $language->id; ?>][term]"
						class="form-control"><?php if(!empty($optionInfo[$language->id]['term_condition'])){echo $optionInfo[$language->id]['term_condition'];}?></textarea>
				</div>
			</div>
	<?php } ?>
	
	<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
					<a class="btn default"
						href="/admin/room/options?id=<?php echo $hotel_id;?>&type=option"><?php echo Yii::t('translation','Cancel');?></a>
				</div>
			</div>
		</div>
<?php $this->endWidget(); ?>

</div>
</div>
<?php $hoteloptions = Equipment::model()->findAllByAttributes(array('hotel_id'=>$hotel_id, 'type'=>'room', 'base_type' => 1));?>
<div class="row">
	<div class="col-md-12">
		<div class="grid-view" id="room-grid">
			<table
				class="table table-striped table-bordered table-hover table-full-width">
				<thead>
					<tr>
						<th id="option-grid_c0"><span style="white-space: nowrap;">Name</span></th>
						<th id="room-grid_c1">Option Type</th>
						<th id="room-grid_c1">CC Required</th>
						<th id="room-grid_c1">Price</th>
						<th id="room-grid_c2" class="button-column">Action</th>
					</tr>
				</thead>
				<tbody>
<?php foreach ($hoteloptions as $hOption){?>
<tr class="odd">
						<td><?php echo $hOption->name;?></td>
						<td><?php echo $hOption->optionType->name;?></td>
						<td><?php echo $hOption->cc_required && $hOption->cc_required == 1 ? "Yes" : "No";?></td>
						<td><?php echo $hOption->default_price && $hOption->default_price > 0 ? $hOption->default_price.$hOption->currency->symbol : "-";?></td>
						<td class="button-column"><a
							href="<?php echo Yii::app()->createUrl('admin/room/options',array('id'=>$hotel_id,'type'=>'option','optionid'=>$hOption->id));?>" title="Edit" class="btn purple fa fa-edit margin-right15"> Edit</a>
							<a id="<?php echo $hOption->id;?>" class="fa fa-success btn default black delete removeLink" href="/admin/room/deleteoption?id=<?php echo $hOption->id ?>" title="Delete">Delete</a>
						</td>
					</tr>
<?php } ?>
</tbody>
			</table>
		</div>
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
								// redirect to update Job page
								showSucessMsg("Please wait while we redirecting.", "Page redirection");
								window.location.href = "/admin/room/options?id=<?php echo $hotel_id; ?>&type=option";
								return;
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

jQuery(document).ready(function() {    
	  FormValidation.init();

	  jQuery('body').delegate(".removeLink","click",function(){
    		//$(this).closest('tr').prev().children('td').last().find('a').remove();
    		var r=confirm("Are you sure, you want to remove this Option?");
    		if (r==true){
    			$(this).closest('tr').remove();
    			return true
    		}
    	
    		return false;
    	});
});
</script>