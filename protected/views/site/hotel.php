<?php
$discountedRoom = $hotelObject->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));
$section1FeaturedImage = $hotelObject->hotelPhotos(array('condition' => 'is_featured = 1', 'limit' => 1));
?> 

<div class="smallBox"> 
    <a href="<?php echo $hotelObject->getUrl(); ?>" >
    <img alt="" src="<?php
    if ($section1FeaturedImage) {
        echo Yii::app()->params['imagePath']['hotel'].$hotelObject->id."/302_197/".$section1FeaturedImage['0']->name;
    } else {
        echo Yii::app()->request->baseUrl;
        ?>/images/small4.jpg
            <?php } ?>">
            <div class="overlayWrap2">
    <div class="overlay2">
        <p class="discountQuote">-<?php echo BaseClass::getPercentage($discountedRoom[0]->default_discount_price,$discountedRoom[0]->default_price);?><span>%</span></p>
        <p class="bigtext"><?php echo $hotelObject->name; ?><br>
            <?php echo $hotelObject->postal_code; ?> <?php echo $hotelObject->city()->slug; ?></p>
        <div class="box">
            <p><span class="big"> <?php
                    if ($discountedRoom) {
                        echo Yii::t('front_end', 'currency') . floor($discountedRoom[0]->default_discount_price);
                    } else {
                        echo Yii::t('front_end', 'no_rooms'); 
                    }
                    ?></span> <?php echo Yii::t('front_end', 'instead_of'); ?> 
                <span class="line">
                    <?php
                    if ($discountedRoom) {
                        echo Yii::t('front_end', 'currency') . floor($discountedRoom[0]->default_price);
                    } else {
                        echo Yii::t('front_end', 'no_rooms'); 
                    }
                    ?></span> <?php echo Yii::t('front_end', 'per_night'); ?></p>
        </div>
    </div>
    </div>
    </a>
</div>
