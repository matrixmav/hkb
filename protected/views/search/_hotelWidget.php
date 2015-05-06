<?php 
$baseurl = Yii::app()->getBaseUrl(true);
$room_info = Room::model()->getRoomsforSearch($hdel);
?>
<li>
	<div class="eachResult">
    	<div class="PicPart">
        	<a href="javascript:void(0);" class="fav">
	            <?php
	            	$imgSrc = Yii::app()->request->baseUrl.'/images/feveritNor.png';
	                $fbclass = 'fevimg';
	                if($userid > 0){
	                	$checkduplication = CustomerFav::model()->findByAttributes(array('customer_id'=>$userid, 'hotel_id'=>$hdel->id)); 
	                    if(empty($checkduplication)){
	                    	$febhotel = FALSE;
	                        $fbclass = 'fevimg';
	                        $imgSrc = Yii::app()->request->baseUrl.'/images/feveritNor.png';
						} else {
							$febhotel = TRUE;
	                        $fbclass = '';
	                        $imgSrc = Yii::app()->request->baseUrl.'/images/feveritSel.png';
						}
					}
				?>
	            <img class="fevimg" id='getMyImage' uid="<?php echo $userid;?>" hid="<?php echo $hdel->id; ?>" src="<?php echo $imgSrc; ?>" alt="" onclick='myFunction()'>
			</a>
            <div class="flexslider imageSlide">
            	<div class="slides">
                	<?php foreach ($hdel->hotelPhotos as $hpic) { ?> 
						<div class="slide-group"><img src="<?php  echo Yii::app()->params['imagePath']['hotel'].$hdel->id; ?>/310_206/<?php echo $hpic->name;?>" alt=""></div>
					<?php } ?>
				</div>
			</div>
		</div>
            <?php
            $date = '';
            if (isset($_GET['SearchForm']['date'])) {
                $date = $_GET['SearchForm']['date'];
            }
            $arrtime = "";
            if (isset($_GET['SearchForm']['arrival_time'])) {
                $arrtime = $_GET['SearchForm']['arrival_time'];
            }
            ?>
		
        <div class="textPart">
        	<a href="<?php echo Yii::app()->createUrl('hotel/detail',array('slug'=>$hdel->slug,'date'=>$date,'arrtime'=>$arrtime)); ?>">
        	<div class="discountQuote">
            	<span class="smallText"></span>
            	<?php 
                    //$section1DiscountedRoom = $hdel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1)); ?>
                    <span class="bigText">-<?php echo $room_info['maxdiscount'];?><span class="persantage">%</span></span>                
                </div>
                    
                <?php $hotelimg = HotelPhoto::model()->findByAttributes(array('hotel_id'=>$hdel->id, 'is_featured'=>1)); 
                if(empty($hotelimg)) {
                        $hotelimg = HotelPhoto::model()->findAllByAttributes(array('hotel_id'=>$hdel->id));
                        foreach ($hotelimg as $getimg){
                                $imgurl = $baseurl."/upload/hotel/".$hdel->id."/180_120/".$getimg->name;
                        }
                } else {
                        $imgurl = $baseurl."/upload/hotel/".$hdel->id."/302_197/".$hotelimg->name;
                }
                ?>
		
                <p class="hotelName" alt="<?php echo Yii::app()->params['sitename'];?>  <?php echo $hdel->latitude;?>" htl-lat ="<?php echo $hdel->latitude;?>" htl-long ="<?php echo $hdel->longitude;?>" htl-slug="<?php echo $hdel->slug;?>" htl-address="<?php echo $hdel->address;?>" htl-postal="<?php echo $hdel->slug;?>" htl-id="<?php echo $hdel->id;?>" htl-image="<?php echo $imgurl;?>" htl-icids="<?php echo $hids;?>" >            	
                
                <?php $classStar ="";
                      $strlen = strlen($hdel->name);
                      if($strlen>34)
                          $hotel_name = substr ($hdel->name,0,34)." ...";
                      else
                          $hotel_name = $hdel->name;
                      
                      echo $hotel_name;
                      switch ($hdel->star_rating) {
                      	case 1:
                        	$classStar = 'one';
                           	break;
						case 2:
                        	$classStar = 'two';
                            break;
						case 3:
                        	$classStar = 'three';
                            break;
						case 4:
                        	$classStar = 'four';
                            break;
						case 5:
                        	$classStar = 'five';
                            break;
						}                      
					?>
                    <span class="Star <?php echo $classStar; ?>"></span>				
			</p>
				<p class="hotelAddress"><?php echo $hdel->address; ?><br><?php echo $hdel->postal_code.' '.$hdel->city->slug; ?></p>
                <div class="hotelTime">
                <!--<?php foreach($hdel->rooms as $hdelroom){
                		switch ($hdelroom->category) {
                        	case "sun":
                                    $class_cat = 'icon1';  
                                    break;
                                case "halfsun":
                                    $class_cat = 'icon2';  
                                break;
				case "moon":
                                    $class_cat = 'icon3';  
                                break;                                              
						}
				?>
                	<div><p class="timeing <?php echo $class_cat;?>"><?php echo date("g:i a", strtotime($hdelroom->available_from)). ' to '.date("g:i a", strtotime($hdelroom->available_till)); ?></p><p class="from">from <span><?php echo '$'.$hdelroom->default_discount_price ?></span> </p></div>
				<?php }?>-->
                <?php
                foreach($room_info['show_rooms'] as $ky):
                ?>
                    <div><p class="timeing <?php echo $room_info['room'][$ky]['roomIcon'];?>"><?php echo $room_info['room'][$ky]['avfrom']. ' to '.$room_info['room'][$ky]['avtill']; ?></p><p class="from">from <span><?php echo '$'.$room_info['room'][$ky]['price'];?></span> </p></div>
                <?php
                endforeach;
                ?>
                </div>
            <span class="book">book now</span>
				</a>
			</div>
	</div>
</li>
<script>
$('.fevimg').click(function(){
	if($(this).attr('src')=='/images/feveritSel.png'){
		$(this).attr('src','/images/feveritNor.png');
	}
});
</script>