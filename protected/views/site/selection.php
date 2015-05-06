<div class="selection">
    <div class="bigPart fleft">
        <?php
        	$section1DiscountedRoom = $hotelObject[0]->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));
			$section1FeaturedImage = $hotelObject[0]->hotelPhotos(array('condition' => 'is_featured = 1', 'limit' => 1));
        ?>
		<div class="bigBox">
        	<?php 
        		$imageUrl = "/images/big1.jpg";
        		if ($section1FeaturedImage) {
        			$imageUrl = Yii::app()->params['imagePath']['hotel'] . $hotelObject[0]->id . "/632_422/" . $section1FeaturedImage['0']->name;
        		}
        	?>
        	<a href="<?php echo $hotelObject[0]->getUrl(); ?>" >
				<img src="<?php echo $imageUrl ?>">
               	<div class="overlayWrap">
                	<div class="overlay">
                    	<p class="discountQuote">-<?php echo BaseClass::getPercentage($section1DiscountedRoom[0]->default_discount_price,$section1DiscountedRoom[0]->default_price);?><span>%</span></p>
                    	<p class="bigtext"><?php echo $hotelObject[0]->name; ?><br>
                        <?php echo $hotelObject[0]->postal_code; ?> <?php echo $hotelObject[0]->city()->slug; ?></p>
                    	<div class="box">
                        	<p>
                        		<span class="big"><?php
                        		
                                if ($section1DiscountedRoom) {
                                    echo Yii::t('front_end', 'currency') . floor($section1DiscountedRoom[0]->default_discount_price);
                                } else {
                                    echo Yii::t('front_end', 'no_rooms'); 
                                }
                                ?></span>
                            <?php echo Yii::t('front_end', 'instead_of'); ?>  <span class="line">
                                <?php
                                if ($section1DiscountedRoom) {
                                    echo Yii::t('front_end', 'currency') . floor($section1DiscountedRoom[0]->default_price);
                                } else {
                                    echo Yii::t('front_end', 'no_rooms'); 
                                }
                                ?></span> <?php echo Yii::t('front_end', 'per_night'); ?></p>
                    </div>
                </div>
                </div>
            </a>
        </div>
        </a>
    </div>
        <?php if (count($hotelObject) == 5) { ?>
            <?php $cityAndHotelCountArray = City::model()->getCityAndHotelCountById(1); ?>

        <div class="smallPart fright">
        <?php $this->renderPartial('//site/neighbourhood', array('cityAndHotelCountArray' => $cityAndHotelCountArray)); ?>
            <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[2])); ?>
        </div>
        <div class="clear"></div>
        <div class="smallPart fleft">
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[3])); ?>
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[4])); ?>
        </div>
        <?php } elseif (count($hotelObject) == 4) { ?>
            <?php $cityAndHotelCountArray = City::model()->getCityAndHotelCountById(1); ?>
        <div class="smallPart fright">
    <?php $this->renderPartial('//site/neighbourhood', array('cityAndHotelCountArray' => $cityAndHotelCountArray)); ?>
            <?php $this->renderPartial('//site/neighbourhood', array('cityAndHotelCountArray' => $cityAndHotelCountArray)); ?>
        </div>
        <div class="clear"></div>
        <div class="smallPart fleft">
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[2])); ?>
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[3])); ?>
        </div>
        <?php } elseif (count($hotelObject) == 3) { ?>
            <?php $cityAndHotelCountArray = City::model()->getCityAndHotelCountById(1); ?>
        <div class="smallPart fright">
    <?php $this->renderPartial('//site/neighbourhood', array('cityAndHotelCountArray' => $cityAndHotelCountArray)); ?>
            <?php $this->renderPartial('//site/neighbourhood', array('cityAndHotelCountArray' => $cityAndHotelCountArray)); ?>
        </div>
        <div class="clear"></div>
        <div class="smallPart fleft">
        <?php $this->renderPartial('//site/neighbourhood', array('cityAndHotelCountArray' => $cityAndHotelCountArray)); ?>
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[2])); ?>
        </div>
        <?php } elseif (count($hotelObject) == 6) { ?>
            <?php $cityAndHotelCountArray = City::model()->getCityAndHotelCountById(10); ?>
        <div class="smallPart fright">
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[2])); ?>
            <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[3])); ?>
        </div>
        <div class="clear"></div>
        <div class="smallPart fleft">
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[4])); ?>
        <?php $this->renderPartial('//site/hotel', array('hotelObject' => $hotelObject[5])); ?>
        </div>
            <?php } ?>
    <div class="bigPart fright">
        <a href="<?php echo $hotelObject[1]->getUrl(); ?>" >
            <?php
            $section2DiscountedRoom = $hotelObject[1]->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));

            $section2FeaturedImage = $hotelObject[1]->hotelPhotos(array('condition' => 'is_featured = 1', 'limit' => 1));
            ?>
            <div class="bigBox"> <img src="<?php
                        if ($section2FeaturedImage) {
                            echo Yii::app()->params['imagePath']['hotel'] . $hotelObject[1]->id . "/632_422/" . $section2FeaturedImage['0']->name;
                        } else {
                            ?>/images/big1.jpg
                        <?php } ?>
                                      " alt="">
               <div class="overlayWrap">
                <div class="overlay">
                    <p class="discountQuote">-<?php echo BaseClass::getPercentage($section2DiscountedRoom[0]->default_discount_price,$section2DiscountedRoom[0]->default_price);?><span>%</span></p>
                    <p class="bigtext"><?php echo $hotelObject[1]->name; ?><br>
                                <?php echo $hotelObject[1]->postal_code; ?> <?php echo $hotelObject[1]->city()->slug; ?></p>
                    <div class="box">
                        <p><span class="big"> <?php
                                if ($section2DiscountedRoom) {
                                    echo Yii::t('front_end', 'currency') . floor($section2DiscountedRoom[0]->default_discount_price);
                                } else {
                                    echo Yii::t('front_end', 'no_rooms'); 
                                }
                                ?></span> <?php echo Yii::t('front_end', 'instead_of'); ?>  <span class="line">
                                    <?php
                                    if ($section2DiscountedRoom) {
                                        echo Yii::t('front_end', 'currency') . floor($section2DiscountedRoom[0]->default_price);
                                    } else {
                                        echo Yii::t('front_end', 'no_rooms'); 
                                    }
                                    ?></span> <?php echo Yii::t('front_end', 'per_night'); ?></p>
                    </div>
                </div>
                </div>
            </div>
        </a>
    </div>
    <div class="clear"></div>
</div>