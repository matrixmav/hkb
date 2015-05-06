<section class="wrapper contentPart">
  <div class="container3">
    <div class="contentCont" style="padding: 50px 160px 60px;">
      <p class="heading">MY FAVORITE hotels</p>
      <div class="borderDiv"></div>
      <div class="favHotel">
        <ul class="contbox">
        <?php foreach($models as $model): 
        		$hotel = Hotel::model()->findByPk($model->hotel_id);
        		$city = $hotel->city()->name;
        		$getallrooms = $hotel->rooms(array('condition'=>'hotel_id =' . $hotel->id));
        		
        ?>
        <?php $rating = Hotel::model()->getHotelRating($hotel->id);?>
          <li>
            <div class="eachResult">
              <div class="PicPart"> <a href="#" class="fav"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/feveritSel.png" alt=""></a>
                <div class="flexslider imageSlide">
                  <div class="slides">
                    <div class="slide-group"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/h0.jpg" alt=""></div>
                    <div class="slide-group"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/h1.jpg" alt=""></div>
                    <div class="slide-group"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/h2.jpg" alt=""></div>
                    <div class="slide-group"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/h3.jpg" alt=""></div>
                  </div>
                </div>
                <div class="discountQuote"> <span class="smallText"></span> <span class="bigText">-44<span class="persantage">%</span></span>  </div>
              </div>
              <div class="textPart">
                <p class="hotelName"><?php echo $hotel->name;?> <span class="Star <?php echo $rating;?>"></span> </p>
                <p class="hotelAddress"><?php echo $hotel->address;?><br>
                  <?php echo $hotel->postal_code;?> <?php echo $city;?></p>
                <div class="posi_global"> 
                <?php
					$i=1;
                 foreach ($getallrooms as $rooms)
				  	{
				  		if($i<=3){
				  		 ?>
				  	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $image = Room::model()->getRoomTypeImage($rooms->id);?>" class="time<?php echo $i;?>" alt="">
				  		<?php 	}?>
				  	<?php $i++; } ?>
				  	</div>
                <div class="hotelTime">
                  <div>
                <?php   $i=0;
    			$image_time ="";
    			//echo date("Y-m-d");
				  	foreach ($getallrooms as $rooms)
				  	{
				  		$hasroom = "one";
				  				if($rooms->category == "sun"){$defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "halfsun"){$defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "moon"){$defaultprice = $rooms->default_discount_night_price;}?>
						  		<p class="favroomm"><?php echo $rooms->name;?> <br>
				                      from</p>
				                    <p class="from2"><span>$<?php echo $fromprice = Room::model()->getRoomTariff($rooms->id,$datetoday);?></span> <del>$<?php echo $defaultprice;?></del> per night</p>
				  		  <?php	
                                                 
				 }
				 if(!isset($hasroom))
				 {
				 	echo "No Rooms Available";
				 }
				 ?>            
                  </div>
                </div>
                <a href="<?php echo Yii::app()->createUrl('hotel/detail',array('slug'=>$hotel->slug))?>" class="book">book now</a> </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
        
      </div>
      <div class="pagination resultPagination">
      <?php $this->widget('MyLinkPager', array(
			    'pages' => $pages,
	      		'header' => '',
	      		'nextPageLabel' => 'Next >>',
	      		'prevPageLabel' => '<< Prev',
	      		'selectedPageCssClass' => 'active',
	      		'hiddenPageCssClass' => 'disabled',
	      		'htmlOptions' => array(
	      				'class' => '',
	      		),
          		//'maxButtonCount'=>2,
      ));
      ?></div>
    </div>
  </div>
</section>
<script>
$(document).ready(function(){
	$( ".first" ).remove();
    $( ".last" ).remove();
});
</script>