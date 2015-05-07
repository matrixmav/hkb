<div class="row form-group">
	<div class="col-md-12">
		<a class="btn green <?php echo ($type=="details")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel/update', array('id' => $model->id,'type'=>'details'))?>">Details</a>
		<?php if($access!="manager"){?>
			<a class="btn green <?php echo ($type=="photos")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel/update', array('id' => $model->id,'type'=>'photos'))?>">Photos</a>
			<a class="btn green <?php echo ($type=="textes")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel/update', array('id' => $model->id,'type'=>'textes'))?>">Texts</a>			
			<a class="btn green <?php echo ($type=="administratif")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel/update', array('id' => $model->id,'type'=>'administratif'))?>">Administrative</a>
		<?php }?>
		<a class="btn green <?php echo ($type=="room")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/room/index', array('hotel_id' => $model->id,'type'=>'room'))?>">Room</a>
		<a class="btn green <?php echo ($type=="option")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/room/options', array('id' => $model->id,'type'=>'option'))?>">Option</a>
		<a class="btn green <?php echo ($type=="availability")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/room/availability', array('id' => $model->id,'type'=>'availability'))?>">Availability</a>
		<a class="btn green <?php echo ($type=="tariff")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/room/tariff', array('id' => $model->id,'type'=>'tariff'))?>">Price</a>
		<a class="btn green <?php echo ($type=="bills")? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/invoice/bills', array('id' => $model->id,'type'=>'bills'))?>">Bills</a>
	</div>
</div>