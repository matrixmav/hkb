<div class="fullpgloader" style="display:block"></div>
<section class="wrapper contentPart">
  <div class="container3" id="reservdiv" style="visibility: hidden;">
    <div class="contentCont">
      <p class="heading"><?php echo Yii::t('front_end','my_reservations');?></p>
      <div id="ourSelection">
        <ul>
          <li><a href="#tabs-1"><?php echo Yii::t('front_end','future_reservations');?></a></li>
          <li><a href="#tabs-2"><?php echo Yii::t('front_end','previous_reservations');?></a></li>
        </ul>
        <div id="tabs-1" class="reservationLIst reservationLIstTab1">
          <ul class="tilesTab1">
          
          <?php 
          if(empty($futurereservations)){
            
          	echo "<p style='text-align:center'>".Yii::t('translation','There Are No Future Reservations')."</p>";
            
          }else{
          foreach ($futurereservations as $futurereserve){
          	$roomdetails = Room::model()->findByPk($futurereserve->room_id);
          	$hoteldetails = Hotel::model()->findByPk($roomdetails->hotel_id);
          	$totalprice = 0;
          	?>
            <li>
              <p class="normal"> <span><?php echo $hoteldetails->name;?></span><br>
                <?php echo $hoteldetails->address;?><br>
                855 378 5969 </p>
              <div class="clear"></div>
              <p class="normal"> <span>
              <?php $originalDate = $futurereserve->res_date;
					$resDate = date("d M. Y", strtotime($originalDate));
					echo $resDate;
					?>
              </span><br>
                <span class="big"><?php echo $roomdetails->name;?><span><?php echo $futurereserve->room_price;?></span></span> <em><?php $fromTime = $futurereserve->res_from; $totime=$futurereserve->res_to;
						$from = date('h:i A', strtotime($fromTime)); echo $from;?> to <?php echo $to = date('h:i A', strtotime($totime)); ?></em> </p>
              <div class="clear"></div>
              <?php 
              $getreservationoptions = ReservationOption::model()->findAllByAttributes(array('reservation_id'=>$futurereserve->id));
              ?>
              <p class="price"> 
              <span class="nor"><?php echo Yii::t('front_end','Aditional_services');?></span> 
              <?php if(empty($getreservationoptions)){
              	echo "<span class='width'>".Yii::t('translation','No Additional Services Added')."</span>";
              }else{
              	foreach ($getreservationoptions as $reservationoption){
              		$equipment = Equipment::model()->findByPk($reservationoption->equipment_id);
              	?>
              <span class="width"> <?php echo $equipment->name;?> 
              <span class="amount">$<?php echo $reservationoption->equipment_price;?></span>
              </span>
              <?php $totalprice = $totalprice+$reservationoption->equipment_price;?>
  			  <?php } } ?>  
              <br>
                <span class="width big"><?php echo Yii::t('front_end','TOTAL_amount');?> : <span class="amount">$ <?php echo $totalprice+$futurereserve->room_price;?></span></span> </p>
              <div class="clear35"></div>
              <p class="normal"><?php echo Yii::t('front_end','EXPECTED_ARRIVAL_TIME');?> : <?php $arrival = date('h:i A', strtotime($futurereserve->arrival_time)); echo $arrival;?></p>
              <?php $reservationid = base64_encode($futurereserve->id);
              		$reservationnb = base64_encode($futurereserve->nb_reservation);
              $orf = ($futurereserve->reservation_status==1)? 0 : 1;
              ?>
              <a class="button edit" href="<?php echo Yii::app()->createUrl('reservation/create',
                      array('hotelId'=>$roomdetails->hotel_id,
                          'roomId'=>$roomdetails->id,
                          'date'=>$originalDate,
                          'rId'=>$futurereserve->id,
                          'arrtime'=>'',
                          'orf'=>$orf));?>"><?php echo Yii::t('front_end','MODIFY');?></a> 
              <a class="button cancel" href="<?php echo Yii::app()->createUrl('customer/cancelreservation',array('rid'=> $reservationid));?>"><?php echo Yii::t('front_end','CANCEL');?></a>
            </li>
            <?php } }?>
          </ul>
          <div class="clear"></div>
        </div>
        <div id="tabs-2" class="reservationLIst reservationLIstTab2">
          <ul class="tilesTab2">
           <?php 
          if(empty($previousreservations)){
          	echo "<p style='text-align:center'>". Yii::t('translation','There Are No Past Reservations') ."</p>";
          }else{
          foreach ($previousreservations as $pastreserve){
          	$roomdetails = Room::model()->findByPk($pastreserve->room_id);
          	$hoteldetails = Hotel::model()->findByPk($roomdetails->hotel_id);
          	$totalprice = 0;
          	?>
            <li>
              <p class="normal"> <span><?php echo $hoteldetails->name;?></span><br>
                <?php echo $hoteldetails->address;?><br>
                855 378 5969 </p>
              <div class="clear"></div>
              <p class="normal"> <span>
              <?php $originalDate = $pastreserve->res_date;
					$resDate = date("d M. Y", strtotime($originalDate));
					echo $resDate;
					?>
              </span><br>
                <span class="big"><?php echo $roomdetails->name;?><span><?php echo $pastreserve->room_price;?></span></span> <em><?php $fromTime = $pastreserve->res_from; $totime=$pastreserve->res_to;
						$from = date('h:i A', strtotime($fromTime)); echo $from;?> to <?php echo $to = date('h:i A', strtotime($totime)); ?></em> </p>
              <div class="clear"></div>
              <?php 
              $getreservationoptions = ReservationOption::model()->findAllByAttributes(array('reservation_id'=>$pastreserve->id));
              ?>
              <p class="price"> 
              <span class="nor"><?php echo Yii::t('translation','Aditional services');?></span> 
              <?php if(empty($getreservationoptions)){
              	echo "<span class='width'>".Yii::t('translation','No Additional Services Added')."</span>";
              }else{
              	foreach ($getreservationoptions as $reservationoption){
              		$equipment = Equipment::model()->findByPk($reservationoption->equipment_id);
              	?>
              <span class="width"> <?php echo $equipment->name; ?> 
              <?php
              $getcurrenctsymbol = Currency::model()->findByPk($equipment->currency_id);
              $curSymbol = ($getcurrenctsymbol!=NULL)? $getcurrenctsymbol->symbol : "";
              $curCode = "";
              ?>
              <span class="amount"><?php echo $curSymbol; ?><?php echo $reservationoption->equipment_price;?></span>
              </span>
              <?php $totalprice = $totalprice+$reservationoption->equipment_price;?>
  			  <?php } } ?>  
              <br>
                <span class="width big"><?php echo Yii::t('translation','TOTAL amount');?> : <span class="amount"><?php //echo $curCode; ?> <?php echo $totalprice+$pastreserve->room_price;?></span></span> </p>
              <div class="clear35"></div>
              <p class="normal"><?php echo Yii::t('translation','EXPECTED ARRIVAL TIME');?> : <?php $arrival = date('h:i A', strtotime($pastreserve->arrival_time)); echo $arrival;?></p>
             <!--  <a class="button edit" href="#">MODIFY</a> <a class="button cancel" href="#">CANCEL</a> -->
            </li>
            <?php } }?>
          </ul>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
              	$(window).bind("load", function(){
						$('.fullpgloader').hide();
						$('#reservdiv').css('visibility','visible');
                  	});
              	
</script>