<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/mobile-reservation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<section class="reservationPg">
    <section class="contractSteps">
        <div class="status">
            <ul>
                <li class="dark" id="reservation_sign">Reservation</li>
                <li class="dark" id="validation_sign">Validation</li>
                <li class="dark" id="confirmation_sign">Confirmation</li>
            </ul>
        </div>
    </section> 
    <form id="customer-form" method="post" action="/mobile/reservation/create">
        <section  class="reservationPane">
            <div id="confirmation">
                <section class="validationpg">
                    <p class="pageTitle"><span class="title nopadding">Confirmation</span><span class="infotext">Your reservation is confirmed !</span></p>
                    <div class="reservation">
                        <p class="title">your reservation</p>
                        <p class="normal"> <span class="bold"><?php echo $hotelObject->name; ?></span><br>
                            <?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->slug; ?><br>
                            <?php echo $hotelObject->telephone ?></p>

                        <p class="normal"> <span class="bold"><?php echo $roomBookingDate; ?></span><br>
                            <?php echo $roomObject->name; ?><span class="fright bold">$ <?php echo $roomObject->default_price; ?></span> 
                            <br/> <?php
                                $timefrom = new DateTime($roomObject->available_from);
                                $timetill = new DateTime($roomObject->available_till);
                                ?>
                                <?php echo Yii::t('front_end', 'available_from_available_till', array('{from}' => $timefrom->format('h:i A'), '{till}' => $timetill->format('h:i A'))); ?>
                        </p>
                        <p class="normal">
                            <?php if (count($reservationOptionObject) > 0) { ?>
                                <span class="italic">Additional services</span><br>
                            <?php } ?>
                            <span class="small">
                                <?php 
                                $servicesAndRoomPrice = $reservationObject->room_price;
                                if (count($reservationOptionObject) > 0) { ?>
                                    <?php 
                                    foreach($reservationOptionObject as $reservationOption){ 
                                        $servicesAndRoomPrice+=$reservationOption->equipment_price;?>
                                <span class="width"><?php echo $reservationOption->equipment()->name; ?><span class="fright bold amount">&nbsp;&nbsp;&nbsp;&nbsp;$ <?php echo number_format($reservationOption->equipment_price,2);?></span></span><br>
                                <?php } } ?>
                            </span> 
                        </p>
                        <p class="normal">
                            <span class="bold">TOTAL AMOUNT :<span class="fright bold"><span id="total_room_reservation_price_12345"> $ <?php echo number_format($servicesAndRoomPrice,2); ?></span></span></span>
                            <br/>
                            <span class="small">Payment will be done upon check-in</span> 
                        </p>
                        <div class="seprator"></div>            
                        <div class="clear"></div>
                        <p class="title">your informations</p>
                        <p class="normal" id="your_information_confirmation">
                            <span class="bold"><?php echo ($reservationObject->customer) ? $reservationObject->customer->first_name . " " . $reservationObject->customer->last_name : ""; ?></span><br>
                            <?php echo ($reservationObject->customer) ? $reservationObject->customer->email_address : ""; ?><br>        
                            <?php if($reservationObject) { echo "+".$reservationObject->customer->country_code ." ". $reservationObject->customer->telephone; } else { echo ""; } ?>
                        </p> 
                        <?php if(!empty($reservationObject->arrival_time)) {?>
                        <p class="normal">
                            <span class="bold">Arrival time : </span> <?php echo $reservationObject->arrival_time; ?>      
                        </p>  
                        <?php } ?>
                    </div>
                </section>
            </div>
            <!--  confirmation code end-->
            <div class="clear"></div>
        <!--<p id="selected_services"></p>-->
        </section>
    </form>
</section>
<section class="threeBox">
    <div class="box">
        <div class="pic"><img src="/images/mobile/i1.png" alt=""></div>
        <div class="textPart">
            <p class="heading">best rates guaranteed</p>
            <p class="normal">Negociated rates (30 to 70% off)</p>
        </div>
    </div>
    <div class="box">
        <div class="pic"><img src="/images/mobile/i2.png" alt=""></div>
        <div class="textPart">
            <p class="heading">no credit card required</p>
            <p class="normal">Privacy guarantee</p>
        </div>
    </div>
    <div class="box last">
        <div class="pic"><img src="/images/mobile/i3.png" alt=""></div>
        <div class="textPart">
            <p class="heading">cancellation without charge</p>
            <p class="normal">Easy until the last minute</p>
        </div>
    </div>
</section>
