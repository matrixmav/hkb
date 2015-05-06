<section class="wrapper midBanner">
  <div class="flexslider midBannerCont">
    <ul class="slides">
        <?php foreach($featuredHotelObject as $featuredHotel) { 
            $discountedRoom = $featuredHotel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));
            
            $featuredImage = $featuredHotel->hotelPhotos(array('condition' => 'is_featured = 1', 'limit' => 1));
            ?>
      <li> 
        <a href="<?php echo $featuredHotel->getUrl(); ?>" >
        <img src="<?php 
        if($featuredImage){
            echo Yii::app()->params['imagePath']['hotel'].$featuredHotel->id."/1280_548/".$featuredImage['0']->name;
        } else {
            echo Yii::app()->request->baseUrl; ?>/images/MidBanner1.jpg
        <?php } ?>
         " alt="">
        <div class="container">
        <div class="overlayWrap">
          <div class="overlay">
            <p class="discountQuote">
                <?php
                if ($discountedRoom) {
                		echo "-".BaseClass::getPercentage($discountedRoom[0]->default_discount_price,$discountedRoom[0]->default_price)."<span>%</span>";
                		 //echo "-".substr($discountedRoom[0]->default_discount_price,0,2);
                    } else { echo "0<span>%</span>"; }
                    ?>
                </p>
            <p class="bigtext"><?php echo $featuredHotel->name; ?><br>
              <?php echo $featuredHotel->postal_code; ?> <?php echo $featuredHotel->city()->name; ?></p>
            <div class="box">
              <p><?php echo Yii::t('front_end', 'day_use_room_available_from'); ?> <?php echo "-".BaseClass::convertDateFormate($discountedRoom[0]->available_from	); ?></p>
            </div>
            <p class="big">
                <?php 
                    if ($discountedRoom) {
                        echo Yii::t('front_end', 'currency') . floor($discountedRoom[0]->default_discount_price);
                    } else {
                        echo Yii::t('front_end', 'no_rooms');
                    }
                    ?></p>
                <p class="price">instead of <span class="line">
                <?php
                    if ($discountedRoom) {
                        echo Yii::t('front_end', 'currency') . floor($discountedRoom[0]->default_price);
                    } else {
                        echo Yii::t('front_end', 'no_rooms');
                    }
                    ?></span> (per night)</p>
          </div>
          </div>
        </div>
        </a>
      </li>
        <?php } ?>
    </ul>
  </div>
</section>