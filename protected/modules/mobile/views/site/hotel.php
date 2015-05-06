<?php 
foreach($hotelObject as $hotel) { 
$roomObject = $hotel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1)); ?>
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
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/hoteldemo1.jpg" alt="">
                    <p class="discount"><span class="smallText"><?php echo Yii::t('mobile', 'discount'); ?></span><span class="bigText"><?php echo ($hotel->best_deal) ? substr($hotel->best_deal, 0, 2) : '0'; ?><span class="persantage">%</span></span></p>
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