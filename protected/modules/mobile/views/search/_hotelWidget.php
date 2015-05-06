<!-- 	<div class="eachResult">
          <div class="leftPart">
          	<div class="flexslider imageSlide">
            	<div class="slides">
                	<?php foreach ($hdel->hotelPhotos as $hpic) { ?> 
						<div class="slide-group"><img src="<?php  echo Yii::app()->params['imagePath']['hotel'].$hdel->id; ?>/310_206/<?php echo $hpic->name;?>" alt=""></div>
					<?php } ?>
				</div>
			</div>
			<?php $section1DiscountedRoom = $hdel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1)); ?>
			<p class="discount"><span></span>-<?php echo BaseClass::getPercentage($section1DiscountedRoom[0]->default_discount_price,$section1DiscountedRoom[0]->default_price);?><sup>%</sup></p>
          </div>
          <div class="rightPart">
          	<?php $classStar ="";
                      switch ($hdel->star_rating) {
                      	case 1:
                        	$classStar = '*';
                           	break;
						case 2:
                        	$classStar = '**';
                            break;
						case 3:
                        	$classStar = '***';
                            break;
						case 4:
                        	$classStar = '****';
                            break;
						case 5:
                        	$classStar = '*****';
                            break;
						}                      
					?>
            <p class="heading"><a href="<?php echo Yii::app()->createUrl('mobile/hotel/detail',array('slug'=>$hdel->slug)); ?>">
            <?php echo $hdel->name;?><?php echo $classStar; ?></a><span><?php echo $hdel->address; ?></span><span><?php echo $hdel->postal_code.' '.$hdel->city->name; ?></span></p>
            <div class="hotelTime">
              <?php foreach($hdel->rooms as $hdelroom){
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
						
						
						$timefrom = ($hdelroom->available_from!='')? BaseClass::convertDateFormate($hdelroom->available_from) : '';
						$timetill = ($hdelroom->available_till!='')? BaseClass::convertDateFormate($hdelroom->available_till) : '';						
				?>
                	<div><p class="timeing <?php echo $class_cat;?>"><?php echo $timefrom. ' to '.$timetill; ?></p><p class="from">from <span><?php echo '$'.number_format($hdelroom->default_discount_price);?></span> </p></div>
				<?php }?>
            </div>
            <a href="<?php echo Yii::app()->createUrl('mobile/hotel/detail',array('slug'=>$hdel->slug)); ?>" class="button">book now</a>
            </div>
          <div class="clear"></div>
        </div> -->
        

        <!-- Search Page results New Layout  -->        
            <section class="hotelSearchCont" id="">                
                <div class="hotelSearch" >
                        <div class="hotelTImeIcons">
                    <ul>
                        <?php 
                        $cn =0;
                        foreach($hdel->rooms as $hdelroom)
                        {
                            $cn ++;
                            if($cn>3)
                                continue;
                            
                            $timefrom = ($hdelroom->available_from!='')? BaseClass::convertDateFormate($hdelroom->available_from) : '';
                            $timetill = ($hdelroom->available_till!='')? BaseClass::convertDateFormate($hdelroom->available_till) : '';
                            
                	    switch ($hdelroom->category) 
                            {
                        	case "sun":
                                    $class_cat = 'sun';
                                    $cat_circle = Yii::app()->request->baseUrl."/images/mobile/i4_bigcircle.png";
                                    $cat_title = '<div class="timings">'.$timefrom.'-'.$timetill.'</div>';
                                    break;
				case "halfsun":
                                    $class_cat = 'halfsun';  
                                    $cat_circle = Yii::app()->request->baseUrl."/images/mobile/i5_bigcircle.png";
                                    $cat_title = '<div class="timings">'.$timefrom.'-'.$timetill.'</div>';
                                    break;
				case "moon":
                                    $class_cat = 'moon';  
                                    $cat_circle = Yii::app()->request->baseUrl."/images/mobile/i6_bigcircle.png";
                                    $cat_title = '<div class="timings">NIGHT</div>';
                                    break;                                              
                            }
                            
                            ?>
                            <li><span class="<?php echo $class_cat;?>"><img src="<?php echo $cat_circle; ?>" /></span><?php echo $cat_title;?></li>
                            <?php
                        }
			?>
                        <!--<li><span class="sun"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i4_bigcircle.png" /></span><div class="timings">11<sup>30</sup>am-12<sup>30</sup>pm</div></li>
                        <li><span class="halfsun"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i5_bigcircle.png" /></span><div class="timings">12<sup>30</sup>am-12<sup>30</sup>pm</div></li>
                        <li><span class="moon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i6_bigcircle.png" /></span><div class="timings">NIGHT</div></li>-->
                    </ul>
                </div>
                    <a href="<?php echo Yii::app()->createUrl('mobile/hotel/detail',array('slug'=>$hdel->slug)); ?>">
                        <div class="picPart">       
                            
                            <?php
                            //$imagePath = HotelPhoto::model()->getHotelFeaturedPhoto($hdel->id,'797_533');
                            $imagePath = HotelPhoto::model()->getHotelFeaturedPhoto($hdel->id,'797_533');
                            if(empty($imagePath)){
                                $imagePath = Yii::app()->request->baseUrl. "/images/mobile/hoteldemo1.jpg";
                            } 
                            ?>
                            <img src="<?php echo $imagePath; ?>" alt="">
                            
                            <?php $section1DiscountedRoom = $hdel->rooms(array('order' => 'default_discount_price desc', 'limit' => 1)); ?>
                            
                            <p class="discount"><span class="smallText"><?php echo Yii::t('mobile', 'discount'); ?></span><span class="bigText"><?php echo BaseClass::getPercentage($section1DiscountedRoom[0]->default_discount_price,$section1DiscountedRoom[0]->default_price); ?><span class="persantage">%</span></span></p>
                        </div>
                        <div class="overlaytextPart">
                            <div class="leftPart"><?php echo $hdel->name;?> 
                                <span class="Star">
                                    <?php echo BaseClass::getHotelStars($hdel->id);?>
                                    <!--<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/ratingstar_small.png" alt="">-->
                                </span>
                                <span class="location"><?php echo $hdel->address; ?></span></div>
                                <div class="rightPart"><span class="fromtext">book from<span class="price">$170</span></span></div>
                            </div>
                    </a>
                </div>
            </section>        