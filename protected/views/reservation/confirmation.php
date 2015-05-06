<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/reservation.js?ver=<?php echo strtotime("now");?>"></script> 

<section class="wrapper reservationStatus">
  <div class="container2">
    <div class="status">
      <ul>
        <li class="dark" id="reservation_sign">Reservation</li>
        <li class="dark" id="validation_sign">Validation</li>
        <li class="dark last" id="confirmation_sign">Confirmation</li>
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
    
      <!-- Confirmation Start -->
      <div class="formLeftPart" id="confirmation">
      <div class="client">
        <div class="reservationBox">
        	<p class="heading"><?php echo Yii::t('front_end', 'congratulations'); ?></p>
          <p class="Subheading">
        <?php 
        if($reservationObject->reservation_status == 2)
            $msg = Yii::t('front_end', 'mail_your_reservation_is_pending');
        else
            $msg = Yii::t('front_end', 'mail_your_reservation_is_confirmed');

        echo $msg;
        ?></p>
          <div class="clear15"></div>
        </div>
        <div class="border"></div>
      </div>
      <div class="client">
        <p class="heading"><?php echo Yii::t('front_end', 'your_reservation'); ?></p>
        <div class="reservationBox">
            
          <p class="Subheading"><?php echo Yii::t('front_end', 'credit_card_guarantee_only'); ?></p>
          <div class="clear15"></div>
          <p class="normal"> <span><?php echo $hotelObject->name; ?></span><br>
            <?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " " . $hotelObject->city()->slug; ?><br>
            <?php echo $hotelObject->telephone ?></p>
          <div class="clear25"></div>
          
          <p class="normal"> <span><?php echo $roomBookingDate; ?></span><br>
            <span class="big"><?php echo $roomObject->name; ?> <span>$ <?php echo number_format($roomObject->default_price,2); ?></span></span> 
            <em><?php 
                $timefrom = new DateTime($roomObject->available_from);
                $timetill = new DateTime($roomObject->available_till); ?>
            <?php echo Yii::t('front_end', 'available_from_available_till',array('{from}'=>$timefrom->format('h:i A'),'{till}'=>$timetill->format('h:i A'))); ?></em> </p>
          <div class="clear25"></div>
          <p class="price"> 
                        <?php 
                        $servicesAndRoomPrice = $roomObject->default_price;
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
        <p class="heading"><?php echo Yii::t('front_end', 'your_information'); ?></p>
        <div class="reservationBox">
          <p class="price"  id="your_information_varification"> <span class="nor"><?php echo ($reservationObject) ? $reservationObject->customer->first_name . " " . $reservationObject->customer->last_name : ""; ?></span><br>
            <?php echo ($reservationObject) ? $reservationObject->customer->email_address : ""; ?><br>
            <?php if($reservationObject) { echo "+".$reservationObject->customer->country->country_code ." ". $reservationObject->customer->telephone; } else { echo ""; } ?> </p>
        </div>
      </div>
    </div>
      <!-- Confirmation End -->
      
      
      <!-- Vadlidation completed -->
    <div class="clear50"></div>
    <div class="tcenter" id="validation_buttons" style="display:none">
      <a class="modify" href="javascript:void(0)"><?php echo Yii::t('front_end', 'modify'); ?></a>
      <a class="validate" href="javascript:void(0)"><?php echo Yii::t('front_end', 'validate'); ?></a>
    </div>
    <!--<div class="clear"></div>-->
    
  </div>
</section>
