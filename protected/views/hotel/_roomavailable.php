<section class="wrapper roomavailable">  
    <div class="container2">
        <div class="leftPart" id="roomsblock">
            <div class="contentloader" style="display:none"></div>
            <div id="availableroomblock">
                <?php
                //$hotelid and arrtime comes in the request
                $date = ($resDate != '') ? $resDate : '';
                if ($date == '') {
                    $criteria = new CDbCriteria;
                    $criteria->order = 'category DESC';
                    $getallrooms = Room::model()->findAllByAttributes(array("hotel_id" => $hotelid, "status" => 1));
                    $i = 0;
                    $image_time = "";
                    foreach ($getallrooms as $rooms) { //   echo "<pre>";print_r($rooms);
                        $hasroom = "one";
                        if ($rooms->category == "sun") {
                            $image_time = "i1.png";
                            $defaultprice = $rooms->default_discount_price;
                        } elseif ($rooms->category == "halfsun") {
                            $image_time = "i2.png";
                            $defaultprice = $rooms->default_discount_price;
                        } elseif ($rooms->category == "moon") {
                            $image_time = "i3.png";
                            $defaultprice = $rooms->default_discount_night_price;
                        }
                        ?>
                        <div class="room onRequest">
                     
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image_time; ?>" class="timeIcon" alt="">
                            <?php
                            $opav = FALSE;
                            if (isset($rooms->roomOptions)) {
                                $option = "";
                                $opav = FALSE;
                                foreach ($rooms->roomOptions as $roomOptions) {
                                        $currencySymbol = $roomOptions->currency_id ? $roomOptions->currency->symbol : "";
                                    $option .= "<li>" . $roomOptions->equipment->name . " (".$roomOptions->price." ". $currencySymbol .")</li>";
                                    $opav = TRUE;                    
                                }
                            }
                            if($opav)
                            {
                            ?>
                                <div class="information">
                                <img src="<?php echo Yii::app()->request->baseUrl;?>/images/i4.png"  alt="">
                                <div class="infopopup">
                                    <ul><li><?php echo $option;?></li></ul>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="discountQuote">
                                <span class="bigText"><?php
                                    $discount = Room::model()->getroomDiscount($rooms);
                                    echo "-".$discount;
                                    ?><span class="persantage">%</span></span>

                            </div>
                            <div class="price">
                                <span><?php echo Yii::t('front_end', 'from'); ?></span>
                                <p class="bigtext"><sup>$</sup><?php echo number_format($defaultprice); ?></p>
                            </div>
                            <div class="timing">
                                <?php
                                $timefrom = new DateTime($rooms->available_from);
                                $timetill = new DateTime($rooms->available_till);
                                //echo $dateObject->format('h:i A');
                                ?>
                                <p><?php echo $timefrom->format('h:i A'); ?><br><?php echo $timetill->format('h:i A'); ?></p>
                            </div>
                            <div class="details">
                                <p><?php echo $rooms->name; ?></p>
                            </div>
                            <a href="javascript:void(0)" class="book showprice"><?php echo Yii::t('front_end', 'Show_Price'); ?></a>
                        </div>
                        <?php
                    }
                    if (!isset($hasroom)) {
                        echo Yii::t('front_end', 'No_Rooms_Available');
                    }
                } 
                else {                    
                    echo Room::model()->hotelRoomDetails($hotelid, $date, $arrtime);
                }
                ?>
            </div>
            <div class="description">
                <h2 class="heading"><?php echo Yii::t('front_end', 'DESCRIPTION'); ?> <?php echo $hotelname; ?><span class="Star <?php echo $rating; ?>"></span></h2>
                <div class="clear20"></div>
                <p class="heading2"><?php echo $hotelname; ?><span class="Star <?php echo $rating; ?>"></span></p>
                <p class="Subheading"><?php echo $address; ?> - <?php echo $postal; ?> <?php echo $findcity->name; ?></p>
                <p class="phone"><?php echo Yii::app()->params['dayuseFooterContactNumber']; ?></p>
                <div class="clear20"></div>
                <p class="normal" itemprop="description">
                <?php
                $getportalid = HotelPortal::model()->findByAttributes(array("hotel_id" => $hotelid));
                $portalid = $getportalid->portal_id;
                $room_content = "";
                $content = HotelContent::model()->findByAttributes(array("hotel_id" => $hotelid, "portal_id" => $portalid, "type" => "description"));
                if ($content != NULL)
                    $room_content = $content->content;
                ?>
                    <?php echo $room_content; ?>
                </p> 
                <div class="clear50"></div>
                <h2 class="heading"><?php echo Yii::t('front_end', 'amenities'); ?> <?php echo $hotelname; ?></h2>
                <div class="clear15"></div>
                <?php $availableamenities = HotelEquipment::model()->findAllByAttributes(array('hotel_id' => $hotelid)); ?>
                                <ul class="amenities">
                <?php
                if (empty($availableamenities)) {
                    echo "No Amenities";
                } else {
                    ?>
                    <?php foreach ($availableamenities as $amenities) {
                        $equipment = Equipment::model()->findByPk($amenities->equipment_id);
                        ?>
                            <li><?php echo $equipment->name; ?></li>
    <?php }
} ?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <?php 
        $dayuseBenefitsCondition = array('benefit_img_page'=>'hotelDetail');
        $dayuseBenefitsObject = DayuseBenefits::model()->findByAttributes($dayuseBenefitsCondition,array('order'=>'updated_at DESC'));
        ?>
        <div class="rightPartCont">
            <div class="rightPart detailBenefits">
                <p class="heading" style="margin-bottom:10px;"><?php echo Yii::t('front_end', 'DAYUSE_BENEFITS'); ?></p>
                <div class="redline"></div>
                <?php
                //$this->renderPartial('//site/dayuse_benefits');
                ?>    
                <?php if(!empty($dayuseBenefitsObject->benefit_img)) {?>
                  <img src="/<?php echo Yii::app()->params->imagePath['hoteldropzone'].'dayuseBenefits/'.$dayuseBenefitsObject->benefit_img;?>" width="100%" />
                <?php } else {?>
                  <img src="/images/hoteldetail_benefits.png" width="100%" />
                <?php } ?>
                <!--<img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/hoteldetail_benefits.png">-->  
            </div>
            <?php
            $adObject = HomeAdBanner::model()->findByAttributes(array('ad_page' => 'detail'), array('order' => 'id DESC'));
            if (!empty($adObject->banner)) {
                $adImage = "/" . Yii::app()->params['imagePath']['homeAdBanner'] . "277_700/" . $adObject->banner;
            } else {
                $adImage = Yii::app()->request->baseUrl . "/images/blank_ad_banner.jpg";
            }
            ?>
            <div class="fright detailAd">
                <img alt="" width="100%" src="<?php echo $adImage; ?>">
            </div>
        </div>    
        <div class="clear"></div>
    </div>
</section>