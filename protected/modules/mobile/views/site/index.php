<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/mobile-hotel.js?ver=<?php echo strtotime("now"); ?>"></script> 
<section class="headingText">
    <p class="heading">150 000 rooms<br>already booked in<br>2000 hotels &amp; 320 cities</p>
</section>
<!-- -->
<?php $this->renderPartial('search'); ?>
<section class="threeBox">
    <!-- 	<div class="box">
            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i1.png" alt=""></div>
            <div class="textPart">
                    <p class="heading">best rates guaranteed</p>
                            <p class="normal">Negociated rates (30 to 70% off)</p>
            </div>
        </div>
        <div class="box">
            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i2.png" alt=""></div>
            <div class="textPart">
                    <p class="heading">no credit card required</p>
                            <p class="normal">Privacy guarantee</p>
            </div>
        </div>
        <div class="box last">
            <div class="pic"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i3.png" alt=""></div>
            <div class="textPart">
                    <p class="heading">cancellation without charge</p>
                            <p class="normal">Easy until the last minute</p>
            </div>
        </div> -->

    <!--  image size 797x486 -->
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/benefits.jpg" class="benefitimage" alt=""/>
</section>
<section class="hotelsHomeCont" id="homePageHotelList">
    <?php
    foreach ($hotelObject as $hotel) {
        
        $roomObject = $hotel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));
        ?>
        <div class="hotelsHome" >
            <div class="hotelTImeIcons">
                <ul>
                    <?php $roomType = Room::model()->getRoomTypes($hotel->id);
                    if (isset($roomType['sun'])) {
                        ?>
                        <li><span class="sun"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i4_bigcircle.png" /></span></li>
                    <?php } if (isset($roomType['halfsun'])) { ?>
                        <li><span class="halfsun"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i5_bigcircle.png" /></span></li>
                    <?php } if (isset($roomType['moon'])) { ?>
                        <li><span class="moon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i6_bigcircle.png" /></span></li>
                <?php } ?>
                </ul>
            </div>
            <a href="<?php echo $hotel->getMobileUrl(); ?>">
                <div class="picPart">
                    <?php 
                    $imagePath = HotelPhoto::model()->getHotelFeaturedPhoto($hotel->id,'797_533');
                    if(empty($imagePath)){
                        $imagePath = Yii::app()->request->baseUrl. "/images/mobile/hoteldemo1.jpg";
                    } ?>
                    <img src="<?php echo $imagePath; ?>" alt="">
                    <p class="discount"><span class="smallText"><?php echo Yii::t('mobile', 'discount'); ?></span><span class="bigText"><?php echo BaseClass::getPercentage($roomObject[0]->default_discount_price,$roomObject[0]->default_price); ?><span class="persantage">%</span></span></p>
                </div>
                <div class="overlaytextPart">
                    <div class="leftPart"><?php echo $hotel->name; ?> 
                        <span class="Star">
                    <?php echo BaseClass::getHotelStars($hotel->id); ?>
                        </span>
                        <span class="location"><?php echo $hotel->address; ?><?php echo $hotel->postal_code; ?> <?php echo $hotel->city()->name; ?></span></div>
                    <div class="rightPart"><span class="fromtext">book from<span class="price">$<?php echo substr($roomObject[0]->default_price, 0, 3); ?></span></span></div>
                </div>
            </a>
        </div>
<?php } ?>

</section>
<section class="hotelsHomeCont">
    <div class="tcenter"><a href="javascript:void(0)" class="loadMore fullLengthBtn" id="loadMoreHotel"><?php echo Yii::t('mobile', 'see_more_hotels'); ?></a></div>
    <input type="hidden" id="lead_more_count" name="lead_more_count" value="3"/>
</section>
<section class="otherCityCont">
    <?php
    foreach ($cityListObject as $cityObject) {
        $cityId = $cityObject->id;
        $hotelCount = 0;
        $hotelCount = City::model()->getCityAndHotelCountById($cityId);
        $hotelDataObject = Hotel::model()->findByAttributes(array('city_id' => $cityId), array('order' => 'best_deal desc', 'limit' => '1'));
        
        $price = 0;
        if (!empty($hotelDataObject->best_deal)) {
            $price = substr($hotelDataObject->best_deal, 0, 3);
        }
        ?>
        <div class="hotelsOther">
            <a href="<?php echo "/mobile?cityName=" . $cityObject->slug; ?>">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/o1.jpg" alt="">
               
                <p class="normal"><span><?php echo $cityObject->name; ?></span>
                    <?php echo Yii::t('mobile', 'hotel_count_room_price', array('{hotelCount}' => $hotelCount['hotelCount'], '{roomPrice}' => $price)); ?>
                    <?php echo Yii::t('mobile', 'currency'); ?>
                </p>
           
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/go.png" class="go" alt="">
            </a>
        </div>
<?php } ?>

</section>

<script type="text/javascript">
$(window).load(function(){
$('.hotelsOther').each(function(){
        var innerTag = $(this).children("a").find("img").next(".normal");
        var innerTagHeight = innerTag.innerHeight();
        innerTag.css('margin-top','-'+innerTagHeight/2+'px');
    });

$('.hotelsHomeCont .hotelsHome .picPart img').each(function(){
    if ($(this).innerHeight() > 50)
    {
        $('.hotelsHomeCont .hotelsHome .picPart img').height($(this).innerHeight());
        return false;
    }
});

});


    
$(window).resize(function(){
    $('.hotelsOther').each(function(){
        var innerTag = $(this).children("a").find("img").next(".normal");
        var innerTagHeight = innerTag.innerHeight();
        innerTag.css('margin-top','-'+innerTagHeight/2+'px');
    });
    
    $('.hotelsHomeCont .hotelsHome .picPart img').each(function(){
    if ($(this).innerHeight() > 50)
    {
        $('.hotelsHomeCont .hotelsHome .picPart img').height($(this).innerHeight());
        return false;
    }
});
});

</script>
