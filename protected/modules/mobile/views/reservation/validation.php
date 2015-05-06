<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/mobile-reservation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<section class="reservationPg">
    <section class="contractSteps">
        <div class="status">
            <ul>
                <li class="dark" id="reservation_sign">Reservation</li>
                <li class="dark" id="validation_sign">Validation</li>
                <li class="last" id="confirmation_sign">Confirmation</li>
            </ul>
        </div>
    </section> 
    <?php  
     $roomId = $reservationObject->room_id;
    $rDate = $reservationObject->res_date;
    $rId = $reservationObject->id;
    $modifyUrl = Yii::app()->createUrl('/mobile/reservation/edit', array(
                    'roomId' => $roomId,'date' => $rDate,'hotelId' => $_GET['hId'],'arrtime' => '','resId' => $rId,'orf'=>'')); ?>
    <form id="customer-form" method="post" action="/mobile/reservation/create">
        <section  class="reservationPane">
            <div id="reservation" style="display: block;">
                
            <!--  validation code start-->
            <div id="validation">

                <section class="validationpg">
                    <p class="pageTitle"><span class="title nopadding">Validation </span>
                        <span class="infotext fleft">Please verify your information <br>
                            and validate your reservation :</span> 
                        <span class="clear dBlock"></span></p>
                    <div class="reservation">
                        <p class="title">your reservation</p>
                        <p class="normal"> <span class="bold"><?php echo $hotelObject->name; ?></span><br>
                            <?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->slug; ?><br>
                            <?php echo $hotelObject->telephone ?></p>

                        <p class="normal"> <span class="bold"><?php echo $roomBookingDate; ?></span><br>
                            <?php echo $roomObject->name; ?><span class="fright bold">$ <?php echo number_format($roomObject->default_price,2); ?></span> 
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
                        <p class="normal"  id="your_information_varification"> 
                            <span class="bold"><?php echo ($customerObject) ? $customerObject->first_name . " " . $customerObject->last_name : ""; ?></span><br>
                            <?php echo ($customerObject) ? $customerObject->email_address : ""; ?><br>
                            <?php if($customerObject) { echo "+".$customerObject->country_code ." ". $customerObject->telephone; } else { echo ""; } ?></p> 
                        
                        <input type="hidden" style="width:155px;" class="textBox" value="<?php echo ($reservationObject->id) ? $reservationObject->id : ""; ?>" id="resend_verification_id" name="resend_verification_id">
                        <?php
                        if(!empty(Yii::app()->session['varification_type'])){ ?>
                        <div id="sms_div" >
                            <p class="normal">
                                <span class="bold"><?php echo Yii::t('front_end', 'enter_the_code_received_by_text_message'); ?> :</span>

                            <div class="clear10"></div>
                            <input type="hidden" name="hidden_varification_code" id="hidden_varification_code" value="<?php echo ($reservationObject) ? $reservationObject->reservation_code:""; ?>"/>
                            <input type="text" style="width:155px;" class="textBox" id="input_verification_code" name="input_verification_code">
                            <!--<a class="modify" id="resend_sms" href="javascript:void(0)"><?php //echo Yii::t('front_end', 'resend'); ?></a>-->
                            <p id="invalid_verification_code" class="error" style="display:none;"><?php echo Yii::t('front_end', 'verification_code'); ?></p></p>
                        </div>
                        <p class="tcenter normal">
                            <a class="submitBtn white" id="modify_btm" href="<?php echo $modifyUrl; ?>"><?php echo Yii::t('front_end', 'modify'); ?></a>
                            <a class="submitBtn fright"id="validate_button" href="javascript:void(0)"><?php echo Yii::t('front_end', 'validate'); ?></a>
                        </p>
                        <?php } else { ?>
                        <div id="email_div">
                         <!--p class="normal">
                            <span class="bold">LAST STEP, YOU MUST CONFIRM YOUR RESERVATION. CLICL ON THE LINK SENT TO YOU VIA EMAIL AT:</span>  
                            <input type="text" name="email_address" id="email_address" placeholder="Email adress*" size="60" maxlength="75" class="textBox noborderrad" value="eugenie@dayuse.com" readonly="">     
                            <a class="resendBtn white fright" id="" href="javascript:void(0)">RESEND</a>
                            <div class="clear"></div>
                        </p-->   
                        <p class="normal">
                            <span class="bold"><?php echo Yii::t('front_end', 'last_step_to_confirm_via_email'); ?> :</span>
                            <input type="text" style="width:180px;" value="<?php echo ($customerObject) ? $customerObject->email_address : ""; ?>" class="textBox" id="resend_verification_email" name="resend_verification_email">
                            <a class="resendBtn white fright" id="resend_email" href="javascript:void(0)"><?php echo Yii::t('front_end', 'resend'); ?></a></span></p>
                        </div>
                        <?php } ?>
                        

                    </div>
                </section>
            </div>
            <!--  validation code end-->
            
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
