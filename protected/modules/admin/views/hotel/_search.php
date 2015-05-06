<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'searchHotel',
	'method'=>'post',
	'htmlOptions'=>array(
	  'class'=>'form-inline',
	  'role'=>'form'
	)
)); ?>

<div class="row" style="background-color:#f5f5f5;padding:20px 0 20px 0;margin:-20px -15px 20px -15px;height:80px;">
	<div class="col-md-12">
			<div class="form-group">
				<?php echo $form->textField($model,'name',array('class'=>'form-control input-medium input-inline searchCity','placeholder'=>'Hotel')); ?>
			</div>
            
			<div class="form-group">
				<button type="submit" class="btn green"><i class="fa fa-filter"></i>Filter</button>
				<a href="/admin/hotel" class="btn default" id="resetLink"><i class="fa fa-undo"></i></a>
			</div>
                        <!--
                        <?php if($access!="manager"){?>
                        <div class="form-group">
                                <?php echo CHtml::link('<i class="fa fa-star"></i> Add New Hotel <i class="fa fa-star"></i>', '/admin/'.  get_class($model) .'/create/type/details', array("class"=>"btn  green margin-right-20")); ?>
                        </div>
                        <?php }?>-->
	</div>
</div>
<?php $this->endWidget(); ?>