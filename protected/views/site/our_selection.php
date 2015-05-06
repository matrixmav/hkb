<section class="wrapper ourSelection">
  <div class="container">
    <h2 class="heading">OUR SELECTION</h2>
    <div id="ourSelection">
      <ul>
        <li><a href="#tabs-1"><?php echo Yii::t('front_end', 'new_hotels'); ?></a></li>
        <li><a href="#tabs-2"><?php echo Yii::t('front_end', 'top_hotels'); ?></a></li>
        <li><a href="#tabs-3"><?php echo Yii::t('front_end', 'best_deals'); ?></a></li>
      </ul>
      <div id="tabs-1">
        <?php 
        if($featuredHotelObject){
            $this->renderPartial('//site/selection',array(
                    'hotelObject'=>$featuredHotelObject));
        }?>
          
      </div>
        <div id="tabs-2">
            
        <?php
        if($topHotelObject){
            $this->renderPartial('//site/selection',array(
                    'hotelObject'=>$topHotelObject));
        }
        ?>
      </div>
      <div id="tabs-3">
        <?php 
        if($bestDealHotelObject){
            $this->renderPartial('//site/selection',array(
                    'hotelObject'=>$bestDealHotelObject));
        }
        ?>
      </div>
    </div>
    <div class="topCity">
      <p class="heading"><span><?php echo Yii::t('front_end', 'top_cities_capital'); ?></span></p>
      <ul>
          <?php foreach ($cityListObject as $cityObject) { ?>
        <li> <a href="<?php echo $cityObject->getUrl(); ?>">
          <p class="smallHeading"><?php echo $cityObject->name;?></p>
          <p><?php echo $cityObject->hotel_count;?> <?php echo Yii::t('front_end', 'hotel_s'); ?></p>
          </a> </li>
          <?php } ?>
      </ul>
      <!--<a href="#" class="blackBtn">all hotels in usa</a>--> 
    </div>
  </div>
</section>