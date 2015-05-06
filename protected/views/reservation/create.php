<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/reservation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<section class="wrapper reservationStatus">
    <div class="container2">
        <div class="status">
            <ul>
                <li class="dark" id="reservation_sign">Reservation</li>
                <li id="validation_sign">Validation</li>
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
        <?php $newDate = date("m/d/Y", strtotime($roomBookingDate));
                $modifyUrl = Yii::app()->createUrl('/hotel/detail', array('slug' => $hotelObject->slug, 'date' => $newDate));
                ?> 
        <!-- Reservation Start -->
        <div class="formLeftPart" id="reservation">
            <div class="hotelDetails">
                <div class="brief">
                    <p class="selection"><?php echo Yii::t('front_end', 'your_selection'); ?> :</p>
                    <p class="heading2" id="hotel_name" ><?php echo $hotelObject->name; ?><span class="Star three"></span></p>
                    <p class="Subheading"><?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->name ?>
                    </p>
                    <p class="Subheading"><?php echo $hotelObject->telephone ?></p>
                </div>
                <div class="controlButton">
                    <a class="button edit" href="<?php echo $modifyUrl; ?>"id="modify_btn_step_one" ><?php echo Yii::t('front_end', 'modify_capital'); ?></a>
                  <!--<a class="button details" href="javascript:void(0)" ><?php echo Yii::t('front_end', 'details'); ?></a>-->
                </div>
                <div class="clear"></div>
                <p class="date"><?php echo $roomBookingDate; ?></p>
                <p class="rate fullwidth" id="room"><?php echo $roomObject->name; ?><span>$ <span id="room_price">
                            <?php
                            $room_price = 0;
                            $bookingDate = "'" . $roomBookingDate . "'";
                            $tariffCondition = 'room_id = ' . $roomObject->id . ' AND tariff_date = ' . $bookingDate;
                            $roomPriceObject = $roomObject->roomTariffs(array('condition' => $tariffCondition, 'limit' => 1));
                            if (!empty($roomPriceObject)) {
                                echo number_format($roomPriceObject[0]->price, 2);
                                $room_price = number_format($roomPriceObject[0]->price, 2);
                            }
                            ?></span></span></p>
                <p class="time">From <?php
                    $timefrom = new DateTime($roomObject->available_from);
                    echo $timefrom->format('h:i A');
                    ?> to <?php
                $timetill = new DateTime($roomObject->available_till);
                echo $timetill->format('h:i A');
                ?></p>
                

                <div class="border"></div>
            </div>
            <form id="customer-form">
                <p id="varification_code" style="display:none;"><?php echo $varificationCode; ?> </p>
                        <?php if (count($roomOptionObject) > 0) { ?>
                    <div class="addService">

                        <p class="heading"><?php echo Yii::t('front_end', 'choose_your_additional_services'); ?></p>

                        <ul>
                            <?php
                            $reservationOptionArray = array();
                            $serviceAmount = 0;
                            if (count($reservationOptionObject) > 0) {
                                foreach ($reservationOptionObject as $reservationOption) {
                                    array_push($reservationOptionArray,$reservationOption->equipment_id);
                                }
                            }
                            foreach ($roomOptionObject as $roomOption) {
                                ?>
                                <li>
                                    <input type="checkbox" value="<?php echo $roomOption->equipment_id . "_" . $roomOption->price; ?>" onclick="getTotalServiceAmount('<?php echo $roomOption->price; ?>', '<?php echo $roomOption->id; ?>', '<?php echo $roomOption->equipment()->cc_required; ?>');" id="checkbox_<?php echo $roomOption->id; ?>" name="aditional_services[]_<?php echo $roomOption->id; ?>" <?php echo (in_array($roomOption->equipment_id, $reservationOptionArray)) ? "checked" : "" ?> >
                                    <div style="margin-bottom:1px;" id="service_name_and_price_<?php echo $roomOption->id; ?>">   
                                        <div id="name_and_price_<?php echo $roomOption->id; ?>" style="color:#000;">
                                <?php echo $roomOption->equipment()->name;
                                if ($roomOption->equipment()->cc_required) {
                                    ?>
                                                - <span class="bank"><?php echo Yii::t('front_end', 'bank_guarantee_card'); ?></span>
                                    <?php } ?>                            
                                            <span class="value fright"><?php echo number_format($roomOption->price, 2); ?></span><span class="fright">$</span>
                                        </div></div>
                                </li>
                        <?php
                        if (in_array($roomOption->equipment_id, $reservationOptionArray)) {
                            $serviceAmount+=$roomOption->price;
                        }
                    }
                    $totalcost = $serviceAmount + $room_price;
                    ?>
                            <input type="hidden" id="totalServiceAmount" value="<?php echo number_format($serviceAmount, 2); ?>" />
                            <li class="total">Total<span class="value" id="value"><?php echo number_format($totalcost, 2); ?></span><span>$</span></li>
                        </ul>
                        <div class="border"></div>
                    </div>
                <?php } 
                $subscription = ($customerObject)? $customerObject->is_subscribed : 0;
                ?>
                <p id="selected_id_collection" name="selected_id_collection" style="display:none;"></p>
                <input type="hidden" id="selected_service_id" name="selected_service_id" value=""/>
                <input type="hidden" name="id" id="id" class="textBox" value="<?php echo ($customerObject) ? $customerObject->id : "" ?>" />
                <input type="hidden" name="hotelId" id="hotelId" class="textBox" value="<?php echo ($hotelObject) ? $hotelObject->id : "" ?>" />
                <input type="hidden" name="roomId" id="roomId" class="textBox" value="<?php echo ($roomObject) ? $roomObject->id : "" ?>" />
                <input type="hidden" name="booking_date" id="date" class="textBox" value="<?php echo ($roomBookingDate) ? $roomBookingDate : "" ?>" />
                <input type="hidden" name="reservation_code" id="reservation_code" class="textBox" value="<?php echo ($reservationCode) ? $reservationCode : "" ?>" />
                <input type="hidden" name="action_mode" id="action_mode" class="textBox" value="<?php echo (!empty($reservationObject)) ? "edit" : "create" ?>" />
                <input type="hidden" name="rId" id="rId" class="textBox" value="<?php echo (!empty($reservationObject)) ? $reservationObject->id : 0; ?>" />
                <input type="hidden" name="required_card_count" id="required_card_count" class="textBox" value="0" />
                <input type="hidden" name="orf" id="orf" class="textBox" value="<?php echo $onRequestFlag;?>" />
                <input type="hidden" name="existing_user" id="existing_user" class="textBox" value="<?php echo ($customerObject) ? $customerObject->id : 0; ?>" />
                <input type="hidden" name="varification_code" id="varification_code" class="textBox" value="<?php echo ($varificationCode) ? $varificationCode : "" ?>" />



                <div class="client">
                    <div class="error" id="access_info"  style="position: relative;top: 18px;width: 100%;font-size: 19px;text-align: center;color: #00992B; display: none;"><?php echo $message; ?></div>
                    <p class="heading"><?php echo Yii::t('front_end', 'client'); ?></p>
                    <?php $readonly = '';
                    if (empty($customerObject->id)) {
                        ?>
                        <div class="redBox" id="already_member">
                            <p class="heading2"><?php echo Yii::t('front_end', 'already_a_member'); ?></p>
                            <div class="fleft box">
                                <label><?php echo Yii::t('front_end', 'phone_number'); ?> *</label>
                                <input type="text" id="existing_customer_phone_no" name="existing_customer_phone_no" class="textBox">
                                <span class="error" id="existing_customer_phone_no_error"></span>
                            </div>
                            <div class="fright box">
                                <label><?php echo Yii::t('front_end', 'password'); ?> *</label>
                                <input type="password" id="existing_customer_password" name="existing_customer_password" class="textBox">
                                <span class="error" id="existing_customer_password_error"></span>
                            </div>
                            <input type="hidden" id="existing_customer_flag" name="existing_customer_flag" value="" />
                            <a href="javascript:void(0)" class="button" id="existing_customer_submit"><?php echo Yii::t('front_end', 'sign_in'); ?></a>
                            <div class="clear"></div>
                        </div>
                    <?php } elseif (empty($reservationObject)) {
                        $readonly = 'readonly';
                    } ?>
                    <div class="reservationBox">
                        <?php if (empty($customerObject->id)) {?>
                            <p class="Subheading" id="you_are_not_member"><?php echo Yii::t('front_end', 'your_not_a_member'); ?> :</p>
                        <?php } ?>
                        <div class="box fleft">
                            <label><?php echo Yii::t('front_end', 'first_name'); ?> *</label>
                            <input type="text" name="first_name" id="first_name" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->first_name : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="first_name_error"></span>
                        </div>
                        <div class="fright box">
                            <label><?php echo Yii::t('front_end', 'last_name'); ?> *</label>
                            <input type="text" name="last_name" id="last_name" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->last_name : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="last_name_error"></span>
                        </div>
                        <div class="clear"></div>
                        <div class="box fleft">
                            <label><?php echo Yii::t('front_end', 'email'); ?> *</label>
                            <input type="text" name="email_address" id="email_address" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->email_address : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="email_address_error"></span>
                        </div>
                        <?php
                        if(!$customerObject){
                        ?>
                        <div class="fright box" id="confirmation_email">
                            <label><?php echo Yii::t('front_end', 'confirm_email'); ?> *</label>
                            <input type="text" name="confirm_email_address" id="confirm_email_address" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->email_address : ""; ?>" <?php echo $readonly; ?>/>
                            <span class="error" id="confirm_email_address_error"></span>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="clear"></div>
                        <div class="box fleft">
                            <label><?php echo Yii::t('front_end', 'phone_number'); ?> *</label>
                            <div class="clear"></div>
                            <?php 
                                $countryObject = BaseClass::getCountryDropdown();
                                $countryCode = 2;
                                if (!empty($reservationObject->country_code)) {
                                    $countryCode = $reservationObject->country_code;
                                }
                            ?>
                            <input type="text" name="telephone" id="telephone_no" size="15" maxlength="15" class="textBox cellPhone" value="<?php echo ($customerObject) ? $customerObject->telephone : ""; ?>" <?php echo $readonly; ?>/>
                            <select class="customeSelect phoneNoPrefix" name="country_id" id="country_id" style="display: none;" width="width: 111px">
                                <?php 
                                foreach($countryObject as $codeObject) { ?>
                                <option value="<?php echo $codeObject['id'];?>" <?php echo($codeObject['id']==$countryCode)?"selected":"";?> ><?php echo strtoupper($codeObject['iso_code']);?> (+ <?php echo $codeObject['country_code']; ?>)</option>
                                <?php } ?>
                            </select>
                            <span class="error" id="telephone_error"></span>
                        </div>
                        <div class="fright box">
                            <label><?php echo Yii::t('front_end', 'arrival_time'); ?> </label>
                            <div class="clear"></div>
                            <select class="customeSelect arrivalTime" id="ui-id-4" style="display: none;" name="arrival_time" id="arrival_time">
                                <option value=""><?php echo Yii::t('front_end', 'arrival_time'); ?></option>
                                <?php
                                $newArrTime = 0;
                                $hotelArrivalTimeArray = Yii::app()->params['hotelArrivalTimeArray'];
                                $newArrTime = BaseClass::getSelectedArrTime($arrtime);
                                if(!empty($reservationObject->arrival_time)){
                                    $newArrTime = strtoupper($reservationObject->arrival_time);
                                 }

                                $arrivalTimeArray = BaseClass::createArrivalArray($roomObject->available_from, $roomObject->available_till);
                                    foreach($arrivalTimeArray as $key=>$arrivalTime){
                                    ?>
                                        <option value="<?php echo $key; ?>" <?php if ($key == $newArrTime) {
                                        echo " selected ";
                                    } ?> > <?php echo $arrivalTime; ?> </option>";
                                <?php } ?>
                            </select>
                        </div>
                        <div class="box fleft" style="width: 500px">
                            <label><?php echo Yii::t('front_end', 'confirmation_code_via'); ?></label>                    
                            <input type="radio" name="confirmation_via" id="confirmation_via_text" class="" value="sms" checked="checked"/> Text message
                            <input type="radio" name="confirmation_via" id="confirmation_via_text" class="" value="email"/> Email
                            <span class="error" id="telephone_error"></span>
                        </div>
                        <div class="box fleft" style="width: 500px">
                            <label><?php echo Yii::t('front_end', 'your_reservation_via'); ?></label>  
                            <?php
                            $smsconfirm = "";
                            $emailconfirm = "";
                            if(!empty($reservationObject)) 
                            { 
                                switch($reservationObject->confirmation_type){
                                    case 0:
                                        $smsconfirm = "checked='checked'";
                                        $emailconfirm = "checked='checked'";
                                        break;
                                    case 1:
                                        $smsconfirm = "checked='checked'";
                                        $emailconfirm = "";
                                        break;
                                    case 2:
                                        $smsconfirm = "";
                                        $emailconfirm = "checked='checked'";
                                        break;
                                }
                            }
                            ?>
                            <input type="checkbox" name="reservation_confirmation_via_text" id="reservation_confirmation_via_text" class="" value="text" <?php echo $smsconfirm;?>/> Text message
                            <input type="checkbox" name="reservation_confirmation_via_email" id="reservation_confirmation_via_text" class="" value="email" <?php echo $emailconfirm;?>/> Email
                            <span class="error" id="telephone_error"></span>
                        </div>
                        <div class="clear25"></div>
                        <label><?php echo Yii::t('front_end', 'comment_optional'); ?></label>
                        <div class="clear"></div>
                        <textarea class="textArea" name="comment" id="comment" ><?php if (!empty($reservationObject)) {
                                echo $reservationObject->comment;
                            } ?></textarea>
                        <div class="clear10"></div>
                        <?php
                        $checked = "";
                        if(!empty($reservationObject)) { $checked = ($reservationObject->is_secret==1)? "checked" : "" ;}
                        ?>
                        <label><input type="checkbox" value="1" name="is_secret" id="is_secret" <?php echo $checked;?>/>I wish this reservation to remain secret</label>
                        <div class="clear20"></div>
                        <label><?php echo Yii::t('front_end', 'how_did_you_her_about_us'); ?></label>
                        <div class="clear"></div>
                        <select class="customeSelect howDidYou" id="ui-id-5" style="display: none;" name="come_accross">
                        <?php foreach ($originObject as $origin) { 
                                   //origin_id
                                $origin_id = 1;
                                if (!empty($reservationObject->country_code)) {
                                    $origin_id = $reservationObject->origin_id;
                                }
                                ?>
                                <option value="<?php echo $origin->id; ?>" <?php echo($origin->id==$origin_id)?"selected":"";?>><?php echo $origin->name; ?></option>
                        <?php } ?>
                        </select>
                        <div class="clear30"></div>
                        <?php
                        if(!$subscription) { ?>
                            <p class="Subheading" id="subheading_bookfaster"><?php echo Yii::t('front_end', 'book_faster_next_time_by_signing_up'); ?> :</p>
                            <div class="box fleft" id="password_ext">
                                <label><?php echo Yii::t('front_end', 'password'); ?> *</label>
                                <input type="password" name="password" id="password" size="60" maxlength="150" class="textBox" value="" />
                                <span class="error" id="password_error"></span>
                            </div>
                            <div class="fright box" id="confirm_password_ext">
                                <label><?php echo Yii::t('front_end', 'confirm_password'); ?> *</label>
                                <input type="password" name="confirm_password" id="confirm_password" size="60" maxlength="150" class="textBox" value="" />
                                <span class="error" id="confirm_password_error"></span>
                            </div>
                            <div class="clear30"></div>
                    <?php } ?>

                    </div><br/> 
                    <div class="border"></div><br/>
                    <div class="client" id="credit_card_payment_div" style="display:none;">
                        <div class="heading"><?php echo Yii::t('front_end', 'credit_card_capital'); ?></div>
                        <div class="reservationBox">
                            <p class="Subheading"><?php echo Yii::t('front_end', 'credit_card_guarantee_only'); ?></p>
                            <!-- <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cc.jpg" alt=""> -->
                            <div class="cardsBlock">
                                <div class="radio"><span class="checked"><input type="radio" checked="checked" name="credit_card"></span></div><span class="visa highlighted"></span>
                                <div class="radio"><span><input type="radio" name="credit_card"></span></div><span class="master highlighted"></span>
                                <div class="radio"><span><input type="radio" name="credit_card"></span></div><span class="diners highlighted"></span>
                            </div>
                            <div class="box fleft">
                                <label><?php echo Yii::t('front_end', 'credit_card_number'); ?> *	</label>
                                <input type="text" class="textBox" id="card_number" name="card_number" maxlength="16">
                                <span class="error" id="card_number_error"></span>
                                <span class="error" id="card_number_not_valid_error"></span>
                            </div>
                            <div class="fright box">
                                <label class="expiration"><?php echo Yii::t('front_end', 'expiration'); ?> <?php echo Yii::t('front_end', 'date'); ?> *</label><label class="date">Month *</label><label class="security"><?php echo Yii::t('front_end', 'security_code'); ?> *</label>
                                <div class="clear"></div>
                                <div class="expiration">
                                    <?php
                                    $currentYear = date('Y');
                                    $next10Year = date("Y", strtotime("10 year"));
                                    $currentMonth = date('m');
                                    ?>
                                    <select class="customeSelect" id="card_year" name="card_year">
                                    <?php for ($year = $currentYear; $year <= $next10Year; $year++) { ?>
                                                                                <option value="<?php echo $year; ?>" <?php if ($currentYear == $year) {
                                            echo "selected";
                                        } ?> ><?php echo $year; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="expiration">
                                    <select class="customeSelect" id="card_month" name="card_month">
                                    <?php
                                    $monthWithIntArray = Yii::app()->params['monthWithInt'];
                                    foreach ($monthWithIntArray as $key => $monthWithInt) {
                                        ?>
                                                                                <option value="<?php echo $key; ?>" <?php if ($currentMonth == $key) {
                                            echo "selected";
                                        } ?> ><?php echo $monthWithInt; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <input type="password" class="textBox security"  id="card_security_code" name="card_security_code" maxlength="4">
                                <span class="error" id="card_security_code_error"></span>
                                <a href="#" class="ccSecurity"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ccSec.jpg" alt=""></a>
                            </div>
                            <div class="clear"></div>
                            <div class="box fleft">
                                <label><?php echo Yii::t('front_end', 'card_holder'); ?> *</label>
                                <input type="text" class="textBox" id="card_holder_name" name="card_holder_name" maxlength="30">
                                <span class="error" id="card_holder_name_error"></span>
                            </div>
                        </div>
                        <div class="clear50"></div>
                        <div class="border"></div>
                    </div>
                </div>
                <div class="info">
                    <p class="heading"><?php echo Yii::t('front_end', 'important_information'); ?></p>
                    <p class="normal"><?php echo Yii::t('front_end', 'reservation_page_text'); ?></p>
                    <div class="clear50"></div>
                    <a class="button" href="javascript:void(0)" id="reservation_step"><?php echo Yii::t('front_end', 'next_step_capital'); ?> &gt; &gt;</a>
                </div>
        </div>
        <!-- Reservation End -->
        </form>
        <div class="clear"></div>
        <!--<div class="clear"></div>-->
    </div>
</section>
<script>
    var loginLinkDiv = "<ul class='submenu accountsubmenu'>\n\
            <li><a href=<?php echo Yii::app()->createUrl('customer/myaccount'); ?><?php echo Yii::t('front_end', 'My_Account'); ?></a></li>\n\
            <li><a href='<?php echo Yii::app()->createUrl('customer/myhotels'); ?>'><?php echo Yii::t('front_end', 'My_Favourite_Hotels'); ?></a></li>\n\
            <li><a href='<?php echo Yii::app()->createUrl('customer/myreservations'); ?>'><?php echo Yii::t('front_end', 'My_Reservations'); ?></a></li>\n\
            <li><a href='<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>' class='bold'><?php echo Yii::t('front_end', 'Logout'); ?></a></li>\n\
        </ul>\n\
    </li>";
</script>