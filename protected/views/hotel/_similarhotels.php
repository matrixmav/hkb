<section class="wrapper ourSelection detailPageBg">
  <div class="container">
    <p class="heading"><?php echo Yii::t('front_end','similar_hotels');?></p>
    <div id="ourSelection">
      <ul>
        <li><a href="#tabs-1" data-tab="near"><?php echo Yii::t('front_end','nearby');?></a></li>
        <li><a href="#tabs-2" data-tab="price"><?php echo Yii::t('front_end','by_price');?></a></li>
        <li><a href="#tabs-3" data-tab="rating"><?php echo Yii::t('front_end','by_star_rating');?></a></li>
        <li><a href="#tabs-4" data-tab="deals"><?php echo Yii::t('front_end','best_deals');?></a></li>
      </ul>
      <div id="tabs-1">
        <div id="changeselection">
        <?php //echo $findcity->id; exit();?>
        <?php 
            $starRatingCondition = 'status = 1 order by star_rating DESC limit 6';
            $hotelsnearby = Hotel::model()->findAll($starRatingCondition);
            $this->renderPartial('//site/selection',array('hotelObject'=>$hotelsnearby));
        ?>
          <div class="clear"></div>
        
        </div>
      </div>
      <div id="tabs-2">
      	<div id ="price">
      	<?php 
            $priceCondition = 'status = 1 order by room_leastprice DESC limit 6';
            $hotelsbyprice = Hotel::model()->findAll($priceCondition); 
            $this->renderPartial('//site/selection',array('hotelObject'=>$hotelsbyprice));
        ?>
      	</div>
      </div>
      <div id="tabs-3">
      	<div id ="rating">
        <?php 
            $star_ratingCondition = 'status = 1 order by star_rating DESC limit 6';
            $hotelsbyrating = Hotel::model()->findAll($star_ratingCondition); 
            $this->renderPartial('//site/selection',array('hotelObject'=>$hotelsbyrating));
        ?>
      	</div>
      </div>
      <div id="tabs-4">
      	<div id ="deals">
        <?php 
            $best_dealCondition = 'status = 1 order by best_deal DESC limit 6';
            $hotelsbyprice = Hotel::model()->findAll($best_dealCondition); 
            $this->renderPartial('//site/selection',array(
            'hotelObject'=>$hotelsbyprice));
        ?>
      	</div>
      </div>
    </div>
  </div>
</section>