<?php 
$userid = Yii::app()->user->id; 
?>
<?php 
                    // getting the stars for the hotel 
                    $hotelObject = Hotel::model()->findByPk($hoteldetails->id);
                    $starRatingCount = $hotelObject->star_rating;
                    $stars = array();
                    if(!empty($starRatingCount)) {
                        for($i=1;$i<=$starRatingCount;$i++ ){
                            $stars[] = "*";
                        }                        
                    }                    
                    ?>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<section class="searchBox" id="searchbox">
    <div class="searchCont">
        <form>       
            <input type="text" placeholder="date" class="textBox date nomargin" id="">
            <button class="searchButton" type="button">Search <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/searchButtonIcon.png"></button>
            <div class="clear"></div>      
        </form>
    </div>
</section>
<div id="tabs" class="hDetailTabs">
    <ul class = "hDetailTabsUL">
        <li class="detailtab"><a href="#tabs-1">Information</a></li>
        <li class="maptab"><a href="#tabs-2 ">Map</a></li>
    </ul>
    <div id="tabs-1" aria-labelledby="uihotelid-id-13" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false">

        <section class="hotelInfoWrap">
            <section class="hotelInfo">
                <p class="name"><?php echo $hoteldetails->name; ?><?php echo "<span style='display:inline-block;'>".implode($stars, "")."</span>"; ?></p>
                <p class="address"><?php echo $hoteldetails->address; ?>, <?php echo $hoteldetails->postal_code; ?> <?php echo $hoteldetails->city()->name; ?></p>
                <p class="mobile"><?php echo Yii::app()->params['dayuseContactNumber']; ?></p>
            </section>
            <section class="banner">
                <?php
                $imagePath = HotelPhoto::model()->getHotelFeaturedPhoto($hoteldetails->id, '727_472');
                if (!file_exists($imagePath)) {
                    //$imagePath = Yii::app()->request->baseUrl . "/images/mobile/h2.jpg";
                }
                ?>
                <div class="flexslider hotelDetialFlexslider">
                  <ul class="slides">
                    <li class="slide-group">
                        <img src="<?php echo $imagePath; ?>" class="bannerImg">
                    </li>
                     <li class="slide-group">
                        <img src="<?php echo $imagePath; ?>" class="bannerImg">
                    </li>
                     <li class="slide-group">
                        <img src="<?php echo $imagePath; ?>" class="bannerImg">
                    </li>
                     <li class="slide-group">
                       <img src="<?php echo $imagePath; ?>" class="bannerImg">
                    </li>
                  </ul>
                </div>
                <a class="facebook" target="_blank" href="<?php echo Yii::app()->params['facebookPageUrl']; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/fb-icon2.png"></a>
                <a class="email" href="mailto:admin@dayuse.com"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/email-icon2.png"></a>
                <a class="mobile" href="tel://<?php echo Yii::app()->params['dayuseContactNumber']; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/mobile-icon2.png"></a>
                <a class="heartIcon" href="javascript:void(0)"> <img class='fevimg' src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/feveritSel2.png" uid="<?php echo $userid;?>" hid="<?php echo $hoteldetails->id; ?>"></a>
            </section>

            <div id="availableroomblock">
                <?php
                $i = 0;
                $image_time = "";
                //echo date("Y-m-d");

                foreach ($getallrooms as $rooms) {
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
                    if (($rooms->room_status == "open") || ($rooms->room_status == "free_sale")) {
                        $roomclass = "";
                        $roombutton = "book now";
                    } elseif ($rooms->room_status == "closed") {
                        $roomclass = "notAvailable";
                        $roombutton = "sur demande";
                    } elseif ($rooms->room_status == "request") {
                        $roomclass = "onRequest";
                        $roombutton = "on request";
                    }
                    ?>
                    <?php
                    $fromtime = BaseClass::breakDateFormate($rooms->available_from);
                    $tilltime = BaseClass::breakDateFormate($rooms->available_till);
                    $explodefrom = explode(":", $fromtime);
                    $explodetill = explode(":", $tilltime);
                    ?>
    <?php
    if ($rooms->category == "sun") {
        $fname = "DAY USE";
    } elseif ($rooms->category == "halfsun") {
        $fname = "LATE BREAK";
    } else {
        $fname = "NIGHT";
    }
    ?>
    <?php
    if ($rooms->category == "sun") {
        $image_time = "hotelsun.png";
    } elseif ($rooms->category == "halfsun") {
        $image_time = "hotelhalfsun.png";
    } elseif ($rooms->category == "moon") {
        $image_time = "hotelmoon.png";
    }
    ?>
                    <!--  version 2 layout code starts here	 -->
                    <div class="searchResult" >
                        <div class="priceTimeWrap">        
                            <span class="time">
                                <img class="htype sun" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/<?php echo $image_time; ?>" />
                                <span><?php echo $explodefrom[0]; ?><sup><?php if ($explodefrom[1] != "00") {
                                        echo $explodefrom[1];
                                    } ?></sup><?php echo $explodefrom[2]; ?> - <?php echo $explodetill[0]; ?><sup><?php if ($explodetill[1] != "00") {
                                        echo $explodetill[1];
                                    } ?></sup><?php echo $explodetill[2]; ?></span>
                            </span>
                            <div class="price">
                                <span class="amount">$<?php echo $defaultprice = number_format($rooms->default_discount_price); ?></span>
                                <span style="display:none;">$200 per night</span><br />
                            </div>
                        </div>
                        <div class="clear"></div>
                        <!-- version 2 layout code stops  here   -->




                        <div class="eachResult">
                            <div class="leftPart">
                                <p class="discount">
                                    <span class="price"><?php
                                        if ($rooms->default_price != 0) {
                                            if ($rooms->category == "sun" || $rooms->category == "halfsun") {
                                                //$nightprice = $rooms->default_price;
                                                //$dayprice = $rooms->default_discount_price;
                                                $negative = (($rooms->default_price - $rooms->default_discount_price) / $rooms->default_price) * 100;
                                                $negative = number_format($negative);
                                                if ($negative >= 100) {
                                                    $negative = 99;
                                                }
                                                if ($negative < 10) {
                                                    $negative = "0" . $negative;
                                                }
                                            } else {
                                                $negative = (($rooms->default_night_price - $rooms->default_discount_night_price) / $rooms->default_night_price) * 100;
                                                $negative = number_format($negative);
                                                if ($negative >= 100) {
                                                    $negative = 99;
                                                }
                                                if ($negative < 10) {
                                                    $negative = "0" . $negative;
                                                }
                                            }
                                        } else {
                                            $negative = 0;
                                        }
                                        echo "-" . $negative."<sup>%</sup>";
                                        ?>

                                        </span></p>
                                <!--  <ul>
                                   <li class="icon1"></li>
                                 </ul> -->
                            </div>
                            <div class="rightPart">            
                                <div class="hotelDetails">
                                   <p class="title"><!-- <span class="time"><?php echo $fromtime; ?> - <?php echo $tilltime; ?></span> -->
                                        <span class="name"><?php echo $fname; ?></span><span class="service"><?php echo $rooms->name; ?><br></span></p>
                                    <!-- <p class="price"><span class="from"><?php echo Yii::t('front_end', 'from'); ?></span><span>$<?php echo $defaultprice = number_format($rooms->default_discount_price); ?></span></p>  -->

                                </div>
                                <div class="clear"></div>
                                <a class="button grey" href="#">SEE PRICE</a>
                            </div>
                            <div class="clear"></div>
                        </div>      
                                    <?php $condition = RoomInfo::model()->findByAttributes(array('room_id' => $rooms->id)); ?>
                                    <?php $roomoptions = RoomOptions::model()->findAllByAttributes(array('room_id' => $rooms->id)); ?> 
                                <?php if ((!empty($condition)) || (!empty($roomoptions))) { ?>

                            <section id="accordion" class="moreInfo">
                                <h3>options & conditions</h3>
                                <div class="content">
                            <?php if (!empty($condition)) { ?>  
                                        <p class="heading">CONDITIONS OF THE ROOM</p>
                                        <p>Schedules of rooms can not be changed. All rooms are for 1 or 2 people. Cancellation must be registered on our website.</p>
                        <?php } ?>
                        <?php if (!empty($roomoptions)) { ?>
                                        <p class="heading option">Options with the room</p>
                                        <ul>
                            <?php foreach ($roomoptions as $options) { ?>
                <?php $equipment = Equipment::model()->findByPk($options->equipment_id); ?>
                                                <li><span class="text"><?php echo $equipment->name; ?></span> <span class="price"><?php echo number_format($options->price); ?> <?php $getcurrenctsymbol = Currency::model()->findByPk($equipment->currency_id); ?><?php echo $getcurrenctsymbol->symbol; ?></span></li>

            <?php } ?>
                                        </ul>
        <?php } ?>
                                </div>
                                <!--  <span class="shadowLine"></span> -->
                            </section> 
    <?php } ?>
                    </div>

<?php
}
if (!isset($hasroom)) {
    echo Yii::t('front_end', 'No_Rooms_Available');
}
?>
            </div>
        </section>
        <section id="accordion" class="moreDetails">
            <h3>DESCRIPTION</h3>
            <div class="content">
                <div class="header">
                    <div class="hotelname">
                        <div class="name"><?php echo $hoteldetails->name; ?><?php echo BaseClass::getHotelStars($hoteldetails->id); ?></div>
                        <div class="address"><?php echo $hoteldetails->address; ?>, <?php echo $hoteldetails->postal_code; ?> <?php echo $hoteldetails->city()->name; ?></div>
                        <div class="mobile"><?php echo Yii::app()->params['dayuseContactNumber']; ?></div>
                    </div>
                    <div class="languages">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/languageFrench.png">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/languageUs.png" class="languageUK">
                    </div>
                </div>
                <?php
                $getportalid = HotelPortal::model()->findByAttributes(array("hotel_id" => $hoteldetails->id));
                $portalid = $getportalid->portal_id;
                $content = HotelContent::model()->findByAttributes(array("hotel_id" => $hoteldetails->id, "portal_id" => $portalid, "type" => "description"));
                ?>
                    <?php if (!empty($content)) { ?>
                    <div class="fleft">
                        <p>
                        <?php
                        echo $content->content;
                        ?>
                        </p>
                    </div>
            <?php } ?>
            </div>
        </section>
        <section id="accordion" class="moreDetails">
            <h3>AMENITIES</h3>
            <div class="content">
<?php $availableamenities = HotelEquipment::model()->findAllByAttributes(array('hotel_id' => $hoteldetails->id)); ?>
                <ul class="amenitiesList">
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
            </div>
<?php
$getportalid1 = HotelPortal::model()->findByAttributes(array("hotel_id" => $hoteldetails->id));
$portalid1 = $getportalid1->portal_id;
$content1 = HotelContent::model()->findByAttributes(array("hotel_id" => $hoteldetails->id, "portal_id" => $portalid, "type" => "guide"));
?>

<?php if (!empty($content1)) { ?>
                <h3>HOW TO  GET THERE ?</h3>
                <div class="content">
                    <ul class="amenitiesList">
                        <p><?php echo $content->content; ?></p>
                    </ul>
                </div>
<?php } ?>
        </section>
        <section class="hotelsHomeCont borderbottom">
            <div class="heading withline"><span class="line"></span><span class="text">similar hotels</span></div>

<?php
foreach ($similarhotels as $hoteldets) {
    $hotelphoto1 = HotelPhoto::model()->findByAttributes(array('hotel_id' => $hoteldets->id, 'is_featured' => 1));
    $roomObject = $hoteldets->rooms(array('order' => 'default_discount_price desc', 'limit' => 1));
    ?>
                <div class="hotelsHome">
                    <div class="hotelTImeIcons dp_room_type">
                        <ul>
                            <?php $roomType = Room::model()->getRoomTypes($hoteldets->id);
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
                    <?php 
                    $imagePath = HotelPhoto::model()->getHotelFeaturedPhoto($hoteldets->id,'727_472');
                    if(empty($imagePath)){
                        $imagePath = Yii::app()->request->baseUrl. "/images/mobile/hoteldemo1.jpg";
                    } ?>
                    <a href="<?php echo Yii::app()->createUrl('mobile/hotel/detail', array('slug' => $hoteldets->slug)) ?>">
                        <div class="picPart"><img alt="" src="<?php echo $imagePath; ?>">
                            <p class="discount"><span class="smallText">-</span><span class="bigText"><?php echo BaseClass::getPercentage($roomObject[0]->default_discount_price,$roomObject[0]->default_price); ?><span class="persantage">%</span></span></p>
                        </div>
                        <div class="overlaytextPart">
                            <div class="leftPart"><?php echo $hoteldets->name; ?> 
                                <span class="Star">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/ratingstar_small.png" alt="">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/ratingstar_small.png" alt="">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/ratingstar_small.png" alt="">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/ratingstar_small.png" alt="">

                                </span>
                                <span class="location"><?php echo $hoteldets->address;?>, <?php echo $hoteldets->postal_code; ?> <?php echo $hoteldets->city()->name; ?></span></div>
                            <div class="rightPart"><span class="fromtext">book from<span class="price">$<?php echo ($hoteldets->best_deal)? substr($hoteldets->best_deal, 0, 3): 0; ?></span></span></div>
                        </div>
                    </a>
                </div> 
<?php } ?>

   <!-- <div class="tcenter"><a class="loadMore" href="#"><img class="prevIcon" src="<?php //echo Yii::app()->request->baseUrl;  ?>/images/mobile/previousCircle.png"> BACK TO RESULTS</a></div> -->
        </section>
        <section class="threeBox">
            <div class="box">
                <div class="pic"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i1.png"></div>
                <div class="textPart">
                    <p class="heading">best rates guaranteed</p>
                    <p class="normal">Negociated rates (30 to 70% off)</p>
                </div>
            </div>
            <div class="box">
                <div class="pic"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i2.png"></div>
                <div class="textPart">
                    <p class="heading">no credit card required</p>
                    <p class="normal">Privacy guarantee</p>
                </div>
            </div>
            <div class="box last">
                <div class="pic"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i3.png"></div>
                <div class="textPart">
                    <p class="heading">cancellation without charge</p>
                    <p class="normal">Easy until the last minute</p>
                </div>
            </div>
        </section>
    </div>
    <!-- Tab 1 is stop here -->
    <!-- Tab 2 is starts here -->
    <style>
        #map-canvas2 {
            width: 100%;
            height: 100%;
        }
    </style>
    <div id="tabs-2" aria-labelledby="ui-id-14" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" style="display: none;" aria-hidden="true">
        <div class="mapCont">
            <div class="mapBanner">
                <div id="maparrowBtn" class="lefttext"></div>
                    
                <div class="righttext"><span class="headingTitle"><?php echo $hoteldetails->name; ?> <span class="star"><?php echo "<span style='display:inline-block;'>".implode($stars, "")."</span>"; ?></span></span><span class="normaltext"><?php echo $hoteldetails->address; ?>, <?php echo $hoteldetails->postal_code; ?>  <?php echo $hoteldetails->city()->name; ?>, <?php echo $hoteldetails->country()->name; ?></span></div>
            </div>
            <div id="map-canvas2"></div></div>
    </div>
    <!-- Tab 2 is stop here -->
</div>
<input type="hidden" id="hotelid" value="<?php echo $hoteldetails->id; ?>" />
<?php $baseurl =  Yii::app()->request->baseUrl; ?>
<script>

    var myLatlng = new google.maps.LatLng(<?php echo $hoteldetails->latitude; ?>,<?php echo $hoteldetails->longitude; ?>);
    var map;
    function initialize() {
        var mapOptions = {
            zoom: 9,
            disableDefaultUI: true,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        }
        map = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '<?php echo $hoteldetails->name; ?>'
        });

        var infoWindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', function () {
            var markerContent = '<?php echo $hoteldetails->name; ?>';
            infoWindow.setContent(markerContent);
            infoWindow.open(map, this);
        });

        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, map);

        zoomControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(zoomControlDiv);
    }



    function ZoomControl(controlDiv, map) {
        // Creating divs & styles for custom zoom control
        controlDiv.style.padding = '5px';

        // Set CSS for the control wrapper
        var controlWrapper = document.createElement('div');
        controlWrapper.style.cursor = 'pointer';
        controlWrapper.style.width = '28px';
        controlWrapper.style.height = '54px';
        controlDiv.appendChild(controlWrapper);

        // Set CSS for the zoomIn
        var zoomInButton = document.createElement('div');
        zoomInButton.style.width = '28px';
        zoomInButton.style.height = '27px';
        /* Change this to be the .png image you want to use */
        zoomInButton.style.backgroundImage = 'url("<?php echo $baseurl; ?>/images/map-icon-zoomin.png")';
        controlWrapper.appendChild(zoomInButton);

        // Set CSS for the zoomOut
        var zoomOutButton = document.createElement('div');
        zoomOutButton.style.width = '28px';
        zoomOutButton.style.height = '27px';
        /* Change this to be the .png image you want to use */
        zoomOutButton.style.backgroundImage = 'url("<?php echo $baseurl; ?>/images/map-icon-zoomout.png")';
        controlWrapper.appendChild(zoomOutButton);

        // Setup the click event listener - zoomIn
        google.maps.event.addDomListener(zoomInButton, 'click', function () {
            map.setZoom(map.getZoom() + 1);
        });

        // Setup the click event listener - zoomOut
        google.maps.event.addDomListener(zoomOutButton, 'click', function () {
            map.setZoom(map.getZoom() - 1);
        });

    }
//google.maps.event.addDomListener(window, 'load', initialize);




    $(document).ready(function () {

        var checkmap = false;
        $('.maptab').click(function () {
            $('#searchbox').hide();
            $('#footsection').hide();
            $('.hDetailTabsUL').hide();
            $('header').hide();
            $('body').css('overflow', 'hidden');            
            if (!checkmap)
            {                
                initialize();
                checkmap = true;
            }

        });


        $('#maparrowBtn').click(function () {
            $('.detailtab a').trigger('click');
        });
        $('.detailtab').click(function () {
            $('#searchbox').show();
            $('#footsection').show();
            $('.hDetailTabsUL').show();
            $('header').show();
            $('body').css('overflow', 'auto');
        });
        var dateToday = new Date();
        $('.date').datepicker({
            minDate: dateToday,
            onSelect: function (dateText, inst) {
                var date = $(this).val();
                $('#dateselected').val(date);
                $(this).prev('#chk_dt').val(date);
                var hotelid = $('#hotelid').val();
                // var arrtime = $('#arrival_time').find(":selected").val();
                var arrtime = "";
                //$('.contentloader').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('mobile/hotel/roomavailability'); ?>",
                    data: {hotelid: hotelid, date: date, arrtime: arrtime},
                    success: function (result) {
                        //$('.contentloader').hide();
                        $('#availableroomblock').html(result);
                        $(".moreInfo").accordion({
                            heightStyle: "content",
                            collapsible: true,
                            active: false
                        });
                    }
                });
            }
        });
        $('.button').click(function () {
            $('.date').datepicker("show");
        });

        $('.fevimg').click(function(){
            if($(this).attr('src') == '/images/mobile/feveritSel2-active.png'){
                $(this).attr('src', '/images/mobile/feveritSel2.png');
            }
        });

    });

//Set Map Dimensions starts here
    function setmapheight() {
        //map height Calculation
        var mapreducedHeight = $('header').height() + $('.hDetailTabs .ui-tabs-nav').height();
        var wHeight = $(window).height();
        //$('.mapCont').height(wHeight - mapreducedHeight);
        $('.mapCont').height(wHeight);
        map.setCenter(myLatlng);
    }
//Set Map Dimensions ends here

    $(window).load(function () {
        setmapheight();
    });
    $(window).resize(function () {
        setmapheight();

    });

</script>