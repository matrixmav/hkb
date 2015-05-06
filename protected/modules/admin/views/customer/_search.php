<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'searchCustomer',
	'method'=>'post',
	'htmlOptions'=>array(
	  'class'=>'form-inline',
	  'role'=>'form'
	)
)); ?>

<div class="row" style="background-color:#f5f5f5;padding:20px 0 20px 0;margin:-20px -15px 20px -15px;height:80px;">
	<div class="col-md-12">
			<div class="form-group">
				<?php echo $form->textField($model,'first_name',array('class'=>'form-control input-small input-inline','placeholder'=>'Customer')); ?>
			</div>
            
			<div class="form-group">
				<button type="submit" class="btn green"><i class="fa fa-filter"></i>Filter</button>
				<a href="/admin/country" class="btn default" id="resetLink"><i class="fa fa-undo"></i></a>
			</div>
			 
	</div>
</div>
<?php $this->endWidget(); ?>