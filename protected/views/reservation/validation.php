<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/reservation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now"); ?>"></script> 

<section class="wrapper reservationStatus">
    <div class="container2">
        <div class="status">
            <ul>
                <li class="dark" id="reservation_sign">Reservation</li>
                <li class="dark" id="validation_sign">Validation</li>
                <li class="last" id="confirmation_sign">Confirmation</li>
            </ul>
        </div>
    </div>
</section>
<section class="wrapper reservation">
    <div class="container2">
        <div class="formRightPart">
            <p class="heading"><?php echo Yii::t('front_end', 'dayuse_benifit_capital'); ?></p>
            <?php 
            $dayuseBenefitsCondition = array('benefit_img_page'=>'reservation');
            $dayuseBenefitsObject = DayuseBenefits::model()->findByAttributes($dayuseBenefitsCondition,array('order'=>'updated_at DESC'));
            ?>
            <section class="benifits wpRegistrationBenefit">
                <div class="threeBox">
                    <?php if(!empty($dayuseBenefitsObject->benefit_img)) {?>
                  <img src="/<?php echo Yii::app()->params->imagePath['hoteldropzone'].'dayuseBenefits/'.$dayuseBenefitsObject->benefit_img;?>" width="100%" />
                    <?php } else {?>
                      <img src="/images/reservation_benefits.png" width="100%" />
                    <?php } ?>
                    <div class="clear"></div>
                </div>
        </div>
        <div class="formLeftPart" id="validation">
            <div class="client">
                <div class="reservationBox">
                    <p class="Subheading2"><?php echo Yii::t('front_end', 'verifiy_reservation_information'); ?> :</p>
                    <div class="clear15"></div>
                </div>
                <div class="border"></div>
            </div>
            <div class="client">
                <p class="headingLight"><?php echo Yii::t('front_end', 'your_reservation'); ?></p>
                <div class="reservationBox">
                  <!-- <p class="Subheading"><?php echo Yii::t('front_end', 'credit_card_guarantee_only'); ?></p>
                  <div class="clear15"></div> -->
                    <p class="normal"> <span><?php echo $hotelObject->name; ?></span><br>
                        <?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->slug; ?><br>
                        <?php echo $hotelObject->telephone ?></p>
                    <div class="clear25"></div>

                    <p class="normal"> <span><?php echo $roomBookingDate; ?></span><br>
                        <span class="big"><?php echo $roomObject->name; ?><span class="avenirRoman">$ <?php echo number_format($roomObject->default_price,2); ?></span></span> 
                        <em> <?php
                            $timefrom = new DateTime($roomObject->available_from);
                            $timetill = new DateTime($roomObject->available_till);
                            ?>
                        <?php echo Yii::t('front_end', 'available_from_available_till', array('{from}' => $timefrom->format('h:i A'), '{till}' => $timetill->format('h:i A'))); ?>
                        </em> </p>
                    <div class="clear25"></div>
                    <p class="price"> 
                        <?php 
                        $servicesAndRoomPrice = $reservationObject->room_price;
                        if (count($reservationOptionObject) > 0) { ?>
                            <span class="nor"><?php echo Yii::t('front_end', 'aditional_services'); ?></span> 
                            <?php 
                            foreach($reservationOptionObject as $reservationOption){ 
                                $servicesAndRoomPrice+=$reservationOption->equipment_price;?>
                            <span class="width"><?php echo $reservationOption->equipment()->name; ?><span class="amount">$ <?php echo number_format($reservationOption->equipment_price,2);?></span></span>
                        <?php } } ?>
                        <span class="width">
                            <span id="selected_services"></span>
                        </span><br>
                        <span class="width big"><?php echo Yii::t('front_end', 'total_amount'); ?> : <span class="amount"> <?php echo Yii::t('front_end', 'currency'); ?><span id="total_room_reservation_price_12345"> <?php echo number_format($servicesAndRoomPrice,2); ?></span></span></span>
                    </p>
                </div>
                <div class="clear30"></div>
                <div class="border"></div>
            </div>
            <div class="client">
                <p class="headingLight"><?php echo Yii::t('front_end', 'your_information'); ?></p>
                <div class="reservationBox">
                    <p class="price"  id="your_information_varification"> <span class="nor"><?php echo ($customerObject) ? $customerObject->first_name . " " . $customerObject->last_name : ""; ?></span><br>
                        <?php echo ($customerObject) ? $customerObject->email_address : ""; ?><br>
                        <?php if( $customerObject->telephone{0} == 0 ) {
                            $customerObject->telephone = substr($customerObject->telephone, 1);
            }           ?>
                        <?php if($customerObject) { echo "+".$customerObject->country->country_code ." ". $customerObject->telephone; } else { echo ""; } ?> </p>
                    <div class="clear20"></div>
                    <input type="hidden" style="width:155px;" class="textBox" value="<?php echo ($reservationObject->id) ? $reservationObject->id : ""; ?>" id="resend_verification_id" name="resend_verification_id">
                    <?php
                    if(!empty(Yii::app()->session['varification_type'])){ ?>
                    <div id="sms_div" >
                    <p class="normal"><span><?php echo Yii::t('front_end', 'enter_the_code_received_by_text_message'); ?> :</span></p>
                    <div class="clear10"></div>
                    <input type="hidden" name="hidden_varification_code" id="hidden_varification_code" value="<?php echo ($reservationObject) ? $reservationObject->reservation_code:""; ?>"/>
                    <input type="text" style="width:155px;" class="textBox" id="input_verification_code" name="input_verification_code">
                    <!--<a class="modify" id="resend_sms" href="javascript:void(0)"><?php //echo Yii::t('front_end', 'resend'); ?></a>-->
                    <p id="invalid_verification_code" class="error" style="display:none;"><?php echo Yii::t('front_end', 'verification_code'); ?></p>
                    </div>
                    <?php } else { ?>
                    <div id="email_div">
                    <p class="normal"><span><?php echo Yii::t('front_end', 'last_step_to_confirm_via_email'); ?> :
                    <input type="text" style="width:180px;" value="<?php echo ($customerObject) ? $customerObject->email_address : ""; ?>" class="textBox" id="resend_verification_email" name="resend_verification_email">
                    <a class="modify" id="resend_email" href="javascript:void(0)"><?php echo Yii::t('front_end', 'resend'); ?></a></span></p>
                    </div>
                    <?php } ?>
                    <div class="clear20"></div>
                    <!--p class="normal"><span><?php //echo Yii::t('front_end', 'select_how_you_wish_to_receive_your_confirmation'); ?> :</span></p>
                    <label class="message first">
                        <input type="checkbox" id="CheckboxGroup1_0" value="mail" name="CheckboxGroup1" checked="checked">
                    <?php //echo Yii::t('front_end', 'by_email'); ?></label-->
                    <!--label class="message">
                      <input type="checkbox" id="CheckboxGroup1_1" value="sms" name="CheckboxGroup1">
                      By text message</label-->
                </div>

            </div>
        </div>
        <div class="tcenter" id="validation_page_buttons">
        <div class="clear50"></div>
        <?php 
            $roomId = $reservationObject->room_id;
            $rDate = $reservationObject->res_date;
            $rId = $reservationObject->id;
            $modifyUrl = Yii::app()->createUrl('/reservation/create', array(
                'roomId' => $roomId,'date' => $rDate,'hotelId' => $_GET['hId'],'arrtime' => '','rId' => $rId,'orf' => $_GET['orf'])); ?>
            <a class="modify" id="modify_btm" href="<?php echo $modifyUrl; ?>"><?php echo Yii::t('front_end', 'modify'); ?></a>
            <?php if(!empty(Yii::app()->session['varification_type'])){ ?>
            <a class="validate"id="validate_button" href="javascript:void(0)"><?php echo Yii::t('front_end', 'validate'); ?></a>
            <?php } ?>
          </div>
        <div class="clear"></div>
    </div>
</section>