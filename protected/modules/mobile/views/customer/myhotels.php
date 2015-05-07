<section class="Hotelfav">
	<p class="favoris"><?php echo Yii::t('front_end','MY_FAVORITE_hotels');?></p>
	<div class="favHotel">
        <ul>
        <?php if(!empty($models)){?>
        <?php foreach($models as $model): 
        		$hotel = Hotel::model()->findByPk($model->hotel_id);
        		$city = $hotel->city()->name;
        		$getallrooms = $hotel->rooms(array('condition'=>'hotel_id =' . $hotel->id));
        		
        ?>
        <?php $rating = Hotel::model()->getHotelRating($hotel->id);?>
          <li>
            <div class="eachResult">
              <div class="PicPart"> <a href="#" class="fav"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/feveritSel.png" alt=""></a>
                <div class="flexslider imageSlide">
                  <div class="slides">
                  <?php $getimages = HotelPhoto::model()->findAllByAttributes(array('hotel_id'=>$hotel->id));?>
                  <?php if(empty($getimages)){ ?>
                  	<div class="slide-group"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/h0.jpg" alt=""></div>
                  <?php }else{
                  	foreach ($getimages as $himages){
                  	?>
                    <div class="slide-group"><img src="<?php  echo Yii::app()->params['imagePath']['hotel'].$hotel->id; ?>/310_206/<?php echo $himages->name;?>" alt=""></div>
                    <?php } } ?>
                  </div>
                </div>
                <div class="discountQuote"> <span class="smallText"></span> <span class="bigText">-44</span> <span class="persantage">%</span> </div>
              </div>
              <div class="textPart">
                <p class="hotelName"> <?php echo $hotel->name;?> <span class="Star <?php echo $rating;?>"></span> </p>
                <p class="hotelAddress"><?php echo $hotel->address;?><br>
                  <?php echo $hotel->postal_code;?> <?php echo $city;?></p>
                <div class="posi_global"> <?php
					$i=3;
                 foreach ($getallrooms as $rooms)
				  	{
				  		if($i>=1){
				  		 ?>
				  	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/<?php echo $image = Room::model()->getRoomTypeImagemobile($rooms->id);?>" class="time<?php echo $i;?>" alt="">
				  		<?php 	}?>
				  	<?php $i--; } ?></div>
                <div class="hotelTime">
                  <div>
                  <?php   $i=0;
    			$image_time ="";
    			//echo date("Y-m-d");
				  	foreach ($getallrooms as $rooms)
				  	{
				  		$hasroom = "one";
				  				if($rooms->category == "sun"){$defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "halfsun"){$defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "moon"){$defaultprice = $rooms->default_discount_night_price;}?>
						  		<p class="favroomm"><?php echo $rooms->name;?> <br>
				                      <?php echo Yii::t('front_end','from');?></p>
				                    <p class="from2"><span>$<?php echo $fromprice = Room::model()->getRoomTariff($rooms->id,$datetoday);?></span> <del>$<?php echo $defaultprice;?></del> per night</p>
				  		  <?php	
				 }
				 if(!isset($hasroom))
				 {
				 	echo Yii::t('front_end','No_Rooms_Available');
				 }
				 ?>
                  </div>
                </div>
                <a href="<?php echo Yii::app()->createUrl('mobile/hotel/detail',array('slug'=>$hotel->slug))?>" class="book">book now</a> </div>
            </div>
          </li>
          <?php endforeach; ?>
          <?php }else{
          	echo "<p style='text-align: center;'>".Yii::t('front_end','No_fav').'</p>';
          }?>
        </ul>
        <div class="clear"></div>
      </div>
</section>