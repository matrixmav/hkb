<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'searchOption',
	'method'=>'post',
	'htmlOptions'=>array(
	'class'=>'form-inline',
	'role'=>'form'
	)
)); ?>

<div class="row" style="background-color:#f5f5f5;padding:20px 0 20px 0;margin:-20px -15px 20px -15px;height:80px;">
	<div class="col-md-12">
			<div class="form-group">
				<?php echo CHtml::textField("Option[name]",$model->name ,array('class'=>'form-control input-small input-inline','placeholder'=>Yii::t('translation','options_label'))); ?>
			</div>
            <div class="form-group">
				<button type="submit" class="btn green"><i class="fa fa-filter"></i>Filter</button>
				<a href="/admin/option" class="btn default" id="resetLink"><i class="fa fa-undo"></i></a>
			</div>
			 
	</div>
</div>
<?php $this->endWidget(); ?>