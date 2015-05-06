<section class="mesReservation">
	<p class="reservations">my reservations</p>
	<div id="tabs" class="reservationTabs">
      <ul>
        <li><a href="#tabs-1">future reservations</a></li>
        <li><a href="#tabs-2">previous reservations</a></li>
      </ul>
      <div id="tabs-1">
      <?php 
          if(empty($futurereservations)){
          	echo Yii::t('translation','There Are No Future Reservations');
          }else{
          foreach($futurereservations as $futurereserve){
          	$roomdetails = Room::model()->findByPk($futurereserve->room_id);
          	$hoteldetails = Hotel::model()->findByPk($roomdetails->hotel_id);
          	$totalprice = 0; 
          	?>
      	<div class="reservation">
        	<p class="normal">
            	<span class="bold"><?php echo $hoteldetails->name;?></span><br>
                <?php echo $hoteldetails->address;?><br>
                <?php echo $hoteldetails->postal_code;?> <?php echo $hoteldetails->city()->name;?>, France<br>
                 <?php  echo Yii::app()->params['dayuseContactNumber']; ?>
            </p>
            <p class="normal">
            	<spaqn class="bold"><?php $originalDate = $futurereserve->res_date;
					$resDate = date("d M. Y", strtotime($originalDate));
					echo $resDate;
					?></spaqn><br>
					<?php echo $roomdetails->name;?>			 
					<span class="fright">$<?php echo $futurereserve->room_price;?></span><br>
					<?php $fromTime = $futurereserve->res_from; $totime=$futurereserve->res_to; $from = date('h:i A', strtotime($fromTime)); echo $from;?> to <?php echo $to = date('h:i A', strtotime($totime)); ?>
            </p>
            <?php 
              $getreservationoptions = ReservationOption::model()->findAllByAttributes(array('reservation_id'=>$futurereserve->id));
              ?>
            <p class="normal">
            <span class="bold"><?php echo Yii::t('front_end','Aditional_services');?></span><br>
            <span class="small">
             <?php if(empty($getreservationoptions)){
              	echo "<span class='width'>".Yii::t('translation','No Additional Services Added')."</span>";
              }else{
              	foreach ($getreservationoptions as $reservationoption){
              		$equipment = Equipment::model()->findByPk($reservationoption->equipment_id);
              	?>
				<?php echo $equipment->name;?> 	 	  <span class="fright">$<?php echo $reservationoption->equipment_price;?></span><br>
				<?php $totalprice = $totalprice+$reservationoption->equipment_price;?>
				<?php } }?>
				</span>
            </p>
            <p class="normal">
            	<span class="bold"><?php echo Yii::t('front_end','TOTAL_amount');?> :     					<span class="fright">$<?php echo $totalprice+$futurereserve->room_price;?></span></span>
            </p>
            <?php if($futurereserve->arrival_time != NULL){?>
            <p class="normal"><?php echo Yii::t('front_end','EXPECTED_ARRIVAL_TIME');?> &nbsp;: &nbsp;<?php $arrival = date('h:i A', strtotime($futurereserve->arrival_time)); echo $arrival;?></p>
           <?php } ?>
            <?php $reservationid = base64_encode($futurereserve->id);
              		$reservationnb = base64_encode($futurereserve->nb_reservation);
              ?>
            <a href="<?php echo Yii::app()->createUrl('mobile/reservation/edit',array('hotelId'=>$roomdetails->hotel_id,'roomId'=>$roomdetails->id,'date'=>$originalDate,'resnb'=>$reservationid,'orf'=>$futurereserve->reservation_status));?>" class="grayButton fleft"><?php echo Yii::t('front_end','MODIFY');?></a>
            <a href="<?php echo Yii::app()->createUrl('mobile/customer/cancelreservation',array('rid'=> $reservationid));?>" class="grayButton fright"><?php echo Yii::t('front_end','CANCEL');?></a>
            <div class="clear"></div>
        </div>
     <?php } }?>
     </div>
      <div id="tabs-2">
     <?php 
          if(empty($previousreservations)){
          	echo Yii::t('translation','There Are No Past Reservations');
          }else{
          foreach($previousreservations as $pastreserve){
          	$roomdetails = Room::model()->findByPk($pastreserve->room_id);
          	$hoteldetails = Hotel::model()->findByPk($roomdetails->hotel_id);
          	$totalprice = 0; 
          	?>
      	<div class="reservation">
        	<p class="normal">
            	<span class="bold"><?php echo $hoteldetails->name;?></span><br>
                <?php echo $hoteldetails->address;?><br>
                <?php echo $hoteldetails->postal_code;?> <?php echo $hoteldetails->city()->name;?>, France<br>
                <?php  echo Yii::app()->params['dayuseContactNumber']; ?>
            </p>
            <p class="normal">
            	<spaqn class="bold"><?php $originalDate = $pastreserve->res_date;
					$resDate = date("d M. Y", strtotime($originalDate));
					echo $resDate;
					?></spaqn><br>
					<?php echo $roomdetails->name;?>			 
					<span class="fright">$<?php echo $pastreserve->room_price;?></span><br>
					<?php $fromTime = $pastreserve->res_from; $totime=$pastreserve->res_to; $from = date('h:i A', strtotime($fromTime)); echo $from;?> to <?php echo $to = date('h:i A', strtotime($totime)); ?>
            </p>
            <?php 
              $getreservationoptions = ReservationOption::model()->findAllByAttributes(array('reservation_id'=>$pastreserve->id));
              ?>
            <p class="normal">
            <span class="bold"><?php echo Yii::t('front_end','Aditional_services');?></span><br>
            <span class="small">
             <?php if(empty($getreservationoptions)){
              	echo "<span class='width'>".Yii::t('translation','No Additional Services Added')."</span>";
              }else{
              	foreach ($getreservationoptions as $reservationoption){
              		$equipment = Equipment::model()->findByPk($reservationoption->equipment_id);
              	?>
				<?php echo $equipment->name;?> 	 	  <span class="fright">$<?php echo $reservationoption->equipment_price;?></span><br>
				<?php $totalprice = $totalprice+$reservationoption->equipment_price;?>
				<?php } }?>
				</span>
            </p>
            <p class="normal">
            	<span class="bold"><?php echo Yii::t('front_end','TOTAL_amount');?> :     					<span class="fright">$<?php echo $totalprice+$pastreserve->room_price;?></span></span>
            </p>
            <p class="normal"><?php echo Yii::t('front_end','EXPECTED_ARRIVAL_TIME');?> &nbsp;: &nbsp;<?php $arrival = date('h:i A', strtotime($pastreserve->arrival_time)); echo $arrival;?></p>
            <?php $reservationid = base64_encode($pastreserve->id);
              		$reservationnb = base64_encode($pastreserve->nb_reservation);
              ?>
            <div class="clear"></div>
        </div>
     <?php } }?>
    
      </div>
    </div>
</section>