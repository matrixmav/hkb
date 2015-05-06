<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'searchBanner',
	'method'=>'post',
	'htmlOptions'=>array(
	  'class'=>'form-inline',
	  'role'=>'form'
	)
)); ?>

<div class="row" style="background-color:#f5f5f5;padding:20px 0 20px 0;margin:-20px -15px 20px -15px;height:80px;">
	<div class="col-md-12">
			<div class="form-group">
				<?php echo CHtml::textField("FeaturedHotel[search]",$search,array('class'=>'form-control input-small input-inline','placeholder'=>'Selection')); ?>
			</div>
            <div class="form-group">
				<div class="form-group">
					<div class="col-md-9">
						<select class="form-control" name="FeaturedHotel[selected]">
						<?php 
						$options = array(
								""=>"All",
								'hotel.name'=>'Hotel',
								'city.slug'=>'City',
								'state.slug'=>'State',
								'country.slug'=>'Country'
						);
						foreach($options as $key=>$option){
								$set = "";
							if($key==$selected)
								$set = "selected='selected'";
							echo "<option $set value='$key'>$option</option>";
						}
						?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn green"><i class="fa fa-filter"></i>Filter</button>
				<a href="/admin/ourSelection" class="btn default" id="resetLink"><i class="fa fa-undo"></i></a>
			</div>
			 
	</div>
</div>
<?php $this->endWidget(); ?>