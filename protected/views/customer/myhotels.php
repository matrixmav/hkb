<?php 
//$hotelphoto =  HotelPhoto::model()->findByAttributes(array('hotel_id'=>$hotelid, 'is_featured'=>1));
$criteria = new CDbCriteria;
$criteria->addCondition("is_featured = 0");
//$criteria->addCondition("hotel_id =".$hotelid);
$criteria->order='position DESC';
$hotelphotoall =  HotelPhoto::model()->findAll($criteria);
$userid = Yii::app()->user->id; 
//$hotelContent = HotelContent::model()->find("portal_id=1 and type='guide' and language_id=1 and hotel_id=".$hotelid);

?>
<section class="wrapper contentPart"> 
    <div class="container3">
        <div class="contentCont" style="padding: 50px 160px 60px;">
            <p class="heading"><?php echo Yii::t('front_end', 'MY_FAVORITE_hotels'); ?></p>
            <div class="borderDiv"></div>
            <div class="favHotel">
                <ul class="contbox">
                    <?php if (!empty($models)) { ?>
                        <?php
                        foreach ($models as $model):
                            $hotel = Hotel::model()->findByPk($model->hotel_id);                            
                            $hotelid = $hotel->id;
                            $city = $hotel->city()->name;
                            $getallrooms = $hotel->rooms(array('condition' => 'hotel_id =' . $hotel->id));
                            ?>
                            <?php $rating = Hotel::model()->getHotelRating($hotel->id); ?>
                            <li>
                                <div class="eachResult">
                                    <div class="PicPart"> <a href="#" class="fav">
                                        <img class="fevimg_un" id='getMyImage' uid="<?php echo $userid;?>" hid="<?php echo $hotelid; ?>" src="/images/feveritSel.png" alt="" onclick='myFunction()'></a>
                                        <div class="flexslider imageSlide">
                                            <div class="slides">
                                                <?php $getimages = HotelPhoto::model()->findAllByAttributes(array('hotel_id' => $hotel->id)); ?>
                                                <?php if (empty($getimages)) { ?>
                                                    <div class="slide-group"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/h0.jpg" alt=""></div>
                                                <?php
                                                } else {
                                                    foreach ($getimages as $himages)
                                                        
                                                        ?>
                                                    <div class="slide-group"><img src="<?php echo Yii::app()->params['imagePath']['hotel'] . $hotel->id; ?>/310_206/<?php echo $himages->name; ?>" alt=""></div>
        <?php } ?>
                                            </div>
                                        </div>                
                                    </div>
                                    <div class="textPart">
                                        <?php
                                        $section1DiscountedRoom = $hotel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));
                                        ?>
                                        <div class="discountQuote"> <span class="smallText"></span> <span class="bigText">-<?php echo BaseClass::getPercentage($section1DiscountedRoom[0]->default_discount_price, $section1DiscountedRoom[0]->default_price); ?><span class="persantage">%</span></span>  </div>
                                        <p class="hotelName"><?php echo $hotel->name; ?> <span class="Star <?php echo $rating; ?>"></span> </p>
                                        <p class="hotelAddress"><?php echo $hotel->address; ?><br>
                                            <?php echo $hotel->postal_code; ?> <?php echo $city; ?></p>
                                        <div class="posi_global"> 
                                            <?php
                                            $i = 1;
                                            foreach ($getallrooms as $rooms) {
                                                if ($i <= 3) {
                                                    ?>
                                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image = Room::model()->getRoomTypeImage($rooms->id); ?>" class="time<?php echo $i; ?>" alt="">
                                                <?php } ?>
                                                <?php $i++;
                                            }
                                            ?>
                                        </div>
                                        <div class="hotelTime">
                                            <div>
                                                <?php
                                                $i = 0;
                                                $image_time = "";
                                                //echo date("Y-m-d");
                                                foreach ($getallrooms as $rooms) {
                                                    $hasroom = "one";
                                                    if ($rooms->category == "sun") {
                                                        $defaultprice = $rooms->default_discount_price;
                                                    } elseif ($rooms->category == "halfsun") {
                                                        $defaultprice = $rooms->default_discount_price;
                                                    } elseif ($rooms->category == "moon") {
                                                        $defaultprice = $rooms->default_discount_night_price;
                                                    }
                                                    ?>
                                                    <p class="favroomm"><?php echo $rooms->name; ?>
                                                    <?php //echo Yii::t('front_end','from') <br> ;?></p>
                                                    <p class="from2"><span>$<?php echo $fromprice = Room::model()->getRoomTariff($rooms->id, $datetoday); ?></span> <del>$<?php echo $defaultprice; ?></del> per night</p>
            <?php
            break;
        }
        if (!isset($hasroom)) {
            echo Yii::t('front_end', 'No_Rooms_Available');
        }
        ?>            
                                            </div>
                                        </div>
                                        <a href="<?php echo Yii::app()->createUrl('hotel/detail', array('slug' => $hotel->slug)) ?>" class="book"><?php echo Yii::t('front_end', 'book_now'); ?></a> </div>
                                </div>
                            </li>
    <?php endforeach; ?>
                <?php
                } else {
                    echo Yii::t('front_end', 'No_fav');
                }
                ?>
                </ul>
                <div class="clear"></div>

            </div>
            <div class="pagination resultPagination">
                <?php
                $this->widget('MyLinkPager', array(
                    'pages' => $pages,
                    'header' => '',
                    'nextPageLabel' => 'Next >>',
                    'prevPageLabel' => '<< Prev',
                    'selectedPageCssClass' => 'active',
                    'hiddenPageCssClass' => 'disabled',
                    'htmlOptions' => array(
                        'class' => '',
                    ),
                        //'maxButtonCount'=>2,
                ));
                ?></div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $(".first").remove();
        $(".last").remove();     
    });
</script>
<script>
    $(window).load(function () {
        var handlerReservation3 = $('.contbox > li');
        handlerReservation3.wookmark({
            // Prepare layout options.
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $('.favHotel'), // Optional, used for some extra CSS styling
            align: "left",
            offset: 10, // Optional, the distance between grid items
            outerOffset: 30, // Optional, the distance to the containers border
            itemWidth: 310 // Optional, the width of a grid item
        });
    });
</script>