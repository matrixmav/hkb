<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mobile/mobile-reservation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<section class="reservationPg">
    <section class="contractSteps">
        <div class="status">
            <ul>
                <li class="dark" id="reservation_sign">Reservation</li>
                <li class="middle" id="validation_sign">Validation</li>
                <li class="last" id="confirmation_sign">Confirmation</li>
            </ul>
        </div>
    </section> 
    <form id="customer-form" method="post" action="/mobile/reservation/create">
        <section  class="reservationPane">
            <div id="reservation" style="display: block;">
                <section class="hotelInfoPane">
                    <p class="pageTitle"><span class="title">Reservation</span></p>
                    <section class="hotelInfo">
                        <span><p class="name"><?php echo $hotelObject->name; ?></p>
                            <span class="Star">
                                <?php echo BaseClass::getHotelStars($hotelObject->id); ?>
                            </span>
                        </span>
                        <p class="address"><?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->name ?></p>
                        <p class="mobile"><?php echo $hotelObject->telephone ?></p>
                    </section>	
                    <section class="reservationResult">
                        <p class="date"><?php echo $roomBookingDate; ?></p>
                        <p class="service"><span><?php echo $roomObject->name; ?></span><span class="fright"> $ <span id="room_price"><?php 
                            $bookingDate = "'" . $roomBookingDate . "'" ;
                            $tariffCondition =  'room_id = '. $roomObject->id . ' AND tariff_date = ' . $bookingDate;
                            $roomPriceObject = $roomObject->roomTariffs(array('condition' =>  $tariffCondition, 'limit' => 1));
                            if(!empty($roomPriceObject)){
                            echo $roomPriceObject[0]->price; } ?></span></span></p>
                        <p class="time">From <?php
                            $timefrom = new DateTime($roomObject->available_from);
                            echo $timefrom->format('h:i A');
                            ?> to <?php
                            $timetill = new DateTime($roomObject->available_till);
                            echo $timetill->format('h:i A');
                            ?></p>
                    </section>
                    <div class="clear"></div>
                    <?php 
                    $newDate = date("m/d/Y", strtotime($roomBookingDate));
                    $modifyUrl = Yii::app()->createUrl('/hotel/detail', array('slug' => $hotelObject->slug,'date'=>$newDate)); ?>
                    <a href="<?php echo $modifyUrl; ?>" class="submitBtn grey fleft" id="modify_btn_step_one" > <?php echo Yii::t('front_end', 'modify_capital'); ?></a>
                    <div class="clear"></div>
                </section>
                <div>
                    <?php if (count($roomOptionObject) > 0) { ?>
                        <section class="moreService">
                            <p class="heading"><?php echo Yii::t('front_end', 'choose_your_additional_services'); ?></p>
                            <ul class="checkbox">
                                <?php
                                $reservationOptionArray = array();
                                $serviceAmount = 0;
                                if (count($reservationOptionObject) > 0) {
                                    foreach ($reservationOptionObject as $reservationOption) {
                                        $reservationOptionArray[] = $reservationOption->equipment_id;
                                    }
                                }
//                                echo "<pre>"; print_r($reservationOptionArray);exit;
                                foreach ($roomOptionObject as $roomOption) {
                                    ?>
                                    <li>
                                        <div class="CustomCheckbox">
                                            <span onclick="getTotalServiceAmount('<?php echo $roomOption->price; ?>', '<?php echo $roomOption->id; ?>', '<?php echo $roomOption->equipment()->cc_required; ?>');">
                                                <a class="checkboxItem">
                                                    <input type="checkbox" value="<?php echo $roomOption->equipment_id . "_" . $roomOption->price; ?>" id="checkbox_<?php echo $roomOption->id; ?>" name="aditional_services[]_<?php echo $roomOption->id; ?>" <?php echo (in_array($roomOption->equipment_id, $reservationOptionArray)) ? "checked" : "" ?> >
                                                    <div id="service_name_and_price_<?php echo $roomOption->id; ?>">   
                                                        <div  id="name_and_price_<?php echo $roomOption->id; ?>">
                                                            <?php
                                                            echo $roomOption->equipment()->name;
                                                            if ($roomOption->equipment()->cc_required) {
                                                                ?>
                                                                - <span class="bank"><?php echo Yii::t('front_end', 'bank_guarantee_card'); ?></span>
                                                            <?php } ?>                            
                                                            <span class="price">$ <?php echo $roomOption->price; ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>
                                    </li>

                                    <?php
                                    if (in_array($roomOption->equipment_id, $reservationOptionArray)) {
                                        $serviceAmount+=$roomOption->price;
                                    }
                                }
                                ?>
                                <input type="hidden" id="totalServiceAmount" value="<?php echo number_format((float) $serviceAmount, 2, '.', ''); ?>" />
                            </ul>
                            <div class="sumtotal">Total : $<span class="value" id="value"><?php echo number_format((float) $serviceAmount, 2, '.', ''); ?></span></div>

                        </section>
                    <?php } ?>
                    <p id="selected_id_collection" name="selected_id_collection" style="display:none;"></p>
                    <input type="hidden" id="selected_service_id" name="selected_service_id" value=""/>
                    <input type="hidden" name="id" id="id" class="textBox" value="<?php echo ($customerObject) ? $customerObject->id : "" ?>" />
                    <input type="hidden" name="hotelId" id="hotelId" class="textBox" value="<?php echo ($hotelObject) ? $hotelObject->id : "" ?>" />
                    <input type="hidden" name="roomId" id="roomId" class="textBox" value="<?php echo ($roomObject) ? $roomObject->id : "" ?>" />
                    <input type="hidden" name="booking_date" id="date" class="textBox" value="<?php echo ($roomBookingDate) ? $roomBookingDate : "" ?>" />
                    <input type="hidden" name="reservation_code" id="reservation_code" class="textBox" value="<?php echo ($reservationCode) ? $reservationCode : "" ?>" />
                    <input type="hidden" name="action_mode" id="action_mode" class="textBox" value="<?php echo ($reservationObject) ? "edit" : "create" ?>" />
                    <input type="hidden" name="reservation_id" id="reservation_id" class="textBox" value="<?php echo ($reservationObject) ? $reservationObject->id : "" ?>" />
                    <input type="hidden" name="required_card_count" id="required_card_count" class="textBox" value="0" />
                    <input type="hidden" name="orf" id="onRequestFlag" class="textBox" value="<?php echo ($onRequestFlag) ? "2" : "1" ?>" />
                    <input type="hidden" name="existing_user" id="existing_user" class="textBox" value="<?php echo ($customerObject) ? $customerObject->id : "0" ?>" />
                    <input type="hidden" name="varification_code" id="varification_code" class="textBox" value="<?php echo ($varificationCode) ? $varificationCode : "" ?>" />

                    <p class="headingTitle"><?php echo Yii::t('front_end', 'client_capital'); ?></p>
                    <?php $readonly = "";
                    if (empty($isLoggedIn)) {
                        ?>
                        <div class="fromBox red" id="already_member">
                            <p class="heading"><?php echo Yii::t('front_end', 'already_a_member'); ?></p>
                            <input type="text"  placeholder="Cell phone number*" id="existing_customer_phone_no" name="existing_customer_phone_no" class="textBox">
                            <span class="error" id="existing_customer_phone_no_error"></span>

                            <input type="password" placeholder="Password*" id="existing_customer_password" name="existing_customer_password" class="textBox">
                            <span class="error" id="existing_customer_password_error"></span>
                            <input type="hidden" id="existing_customer_flag" name="existing_customer_flag" value="" />
                            <a href="javascript:void(0)" class="submitBtn" id="existing_customer_submit"><?php echo Yii::t('front_end', 'sign_in'); ?></a>
                            <div class="clear"></div>
                        </div>
                    <?php
                    } elseif (empty($reservationObject)) {
                        $readonly = 'readonly';
                    }
                    ?>
                    <div class="fromBox noborder nopadding">
                        <?php if (empty($isLoggedIn)) { ?>
                            <p class="heading" id="your_not_a_member_txt">You are not a member ? <br/>Complete your reservation :</p>
                    <?php } ?>
                            <input type="text" name="first_name" id="first_name" placeholder="First name*" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->first_name : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="first_name_error"></span>

                            <input type="text" name="last_name" id="last_name" placeholder="Last name*" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->last_name : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="last_name_error"></span>

                            <input type="text" name="email_address" id="email_address" placeholder="Email adress*" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->email_address : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="email_address_error"></span>
                            <?php if (empty($customerObject)) { ?>
                                <input type="text" name="confirm_email_address" placeholder="Confirm email adress*" id="confirm_email_address" size="60" maxlength="75" class="textBox" value="" />
                                <span class="error" id="confirm_email_address_error"></span>
                        <?php } ?>
                            <select class="customeSelect" id="ui-id-4" style="display: none;" name="country_id" id="country_id" width="width: 111px">
                                 <?php 
                                    $countryObject = BaseClass::getCountryCode();
                                    foreach($countryObject as $codeObject) {?>
                                    <option value="<?php echo $codeObject->country_code;?>"><?php echo strtoupper($codeObject->iso_code);?> (+<?php echo $codeObject->country_code;?>)</option>
                                    <?php } ?>
                            </select>

                            <input type="text" name="telephone" id="telephone_no" placeholder="Cell phone number*" size="15" maxlength="15" class="textBox cellPhone" value="<?php echo ($customerObject) ? $customerObject->telephone : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="telephone_error"></span>
                            <div class="clear"></div>
                            <select class="customeSelect arrivalTime" style="width:43%" id="ui-id-4" style="display: none;" name="arrival_time" id="arrival_time">
                                <option value=""><?php echo Yii::t('front_end', 'arrival_time'); ?></option>
                                <?php
                                $startTime = Yii::app()->params['arrivalTime']['startTime'];
                                $endTime = Yii::app()->params['arrivalTime']['endTime'];
                                $duration = Yii::app()->params['arrivalTime']['duration'];

                                $start = strtotime($startTime);
                                $end = strtotime($endTime);
                                for ($year = $start; $year <= $end; $year = $year + $duration * 60) {
                                    $arriaval = date('G:i', $year);
                                    ?>
                                    <option value="<?php echo $arriaval; ?>" <?php
                                        if ($arrtime == $arriaval) {
                                            echo " selected ";
                                        }
                                        ?> > <?php echo $arriaval; ?> </option>";
                                <?php } ?>
                            </select>
                            <div class="clear"></div>
                                <section class="confirmType">
                                   <p class="title">Recieve a confirmation code via :
                                   <ul class="CustomRadioButton">
                                    <li>
                                        <span>
                                            <input type="radio" class="radioItemCustom"  name="confirmation_via" id="confirmation_via_text" value="sms" label='Text message' checked="checked">
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <input type="radio" class="radioItemCustom"  name="confirmation_via" id="confirmation_via_text" value="email" label='Email'>
                                        </span>
                                    </li>
                                </ul>
                                <p class="title">Recieve a reservation via :
                                   <ul class="CustomCheckbox">
                                    <li>
                                        <span>
                                            <input type="checkbox"class="checkboxItemCustom" label='Text message' name="reservation_confirmation_via_text" id="reservation_confirmation_via_text" value="text" checked="checked">
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <input type="checkbox" class="checkboxItemCustom" label='Email' name="reservation_confirmation_via_email" id="reservation_confirmation_via_text" value="email">
                                        </span>
                                    </li>
                                </ul>
                            </section>
                            <div class="clear"></div>
                            <textarea placeholder="Comment for the hotel reception (optional)"  name="comment" id="comment"></textarea>
                            <div class="clear"></div>
                            <select class="customeSelect findus" id="ui-id-5" style="display: none;" name="come_accross">
                            <?php foreach ($originObject as $origin) { ?>
                                    <option value="<?php echo $origin->id; ?>"><?php echo $origin->name; ?></option>
                            <?php } ?>
                            </select>
                            <div class="clear"></div>
                            <?php if (empty($isLoggedIn)) { ?>
                                <section class="bookfaster" id="password_div">
                                    <p class="heading">Book faster next time by signing up :</p>
                                    <input type="password" name="password" id="password" placeholder="Password" size="60" maxlength="150" class="textBox" value="" />
                                    <span class="error" id="password_error"></span>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" size="60" maxlength="150" class="textBox" value="" />
                                    <span class="error" id="confirm_password_error"></span>
                                </section>
                            <?php } ?>
                            <div  id="credit_card_payment_div" style="display:none;">
                                <p class="headingTitle"><?php echo Yii::t('front_end', 'credit_card_capital'); ?></p>
                                <p><?php echo Yii::t('front_end', 'credit_card_guarantee_only'); ?></p>
                                <ul class="CustomRadioButton cardspayment">
                                    <li>
                                        <span>
                                            <input type="radio" value="Budget hotel" checked="checked" name="Category" class="radioItemCustom" label='<img src="/images/mobile/visacard.png" />'>
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <input type="radio" value="Budget hotel" name="Category" class="radioItemCustom" label='<img src="/images/mobile/marstercard.png" />'>
                                        </span>
                                    </li>
                                    <li>
                                        <span>
                                            <input type="radio" value="Budget hotel" name="Category" class="radioItemCustom" label='<img src="/images/mobile/americanexpress.png" />'>
                                        </span>
                                    </li>
                                </ul>

                                <div class="clear"></div>
                                <input type="text" class="textBox" id="card_number" name="card_number" placeholder="Credit card number*" maxlength="16">
                                <span class="error" id="card_number_error"></span>

                                <input type="text" class="textBox" id="card_holder_name" name="card_holder_name" placeholder="Card holder*" maxlength="30">
                                <span class="error" id="card_holder_name_error"></span>
                                <div class="clear"></div>
                                    <?php
                                    $currentYear = date('Y');
                                    $next10Year = date("Y", strtotime("10 year"));
                                    $currentMonth = date('m');
                                    ?>
                                <select class="customeSelect month" id="card_year" name="card_year">
                                        <?php for ($year = $currentYear; $year <= $next10Year; $year++) { ?>
                                        <option value="<?php echo $year; ?>" <?php
                                        if ($currentYear == $year) {
                                            echo "selected";
                                        }
                                        ?> ><?php echo $year; ?></option>
                                    <?php } ?>
                                </select>
                                <select class="customeSelect year" id="card_month" name="card_month">
                                    <?php 
                                        $monthWithIntArray = Yii::app()->params['monthWithInt'];
                                        foreach($monthWithIntArray as $key=>$monthWithInt){ ?>
                                        <option value="<?php echo $key; ?>" <?php if($currentMonth == $key){ echo "selected"; } ?> ><?php echo $monthWithInt; ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" class="textBox cardnmber"  placeholder="Security Code*" id="card_security_code" name="card_security_code" maxlength="4">
                                <span class="error" id="card_security_code_error"></span>
                            </div>

                            <div class="clear"></div>
                            <p class="headingTitle">IMPORTANT INFORMATION</p>
                            <p><?php echo Yii::t('front_end', 'reservation_page_text'); ?></p>
                            <div class="overlayPane" id="reservation_next_btn">
                                <a class="submitBtn nextstep" href="javascript:void(0)" id="reservation_step"><?php echo Yii::t('front_end', 'next_step_capital'); ?> &gt; &gt;</a>
                            </div>
                    </div>
                </div>
            </div>
            <!--reservation code ends-->
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
