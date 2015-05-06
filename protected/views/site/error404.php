<section class="wrapper accNotFound">
  <div class="container3">
    <div class="grayBox error404">
    	<div class="whiteCircle"><p class="oups"><span><?php echo Yii::t('front_end', 'error404'); ?></span>404</p></div>
        <p class="Subheading2"><?php echo Yii::t('front_end', 'error404_message'); ?></p>
        <p class="normal"><?php echo Yii::t('front_end', 'error404_message_text'); ?></p>
        <div class="fleft">
            <a href="/" class="squareBtn"><?php echo Yii::t('front_end', 'home_capital'); ?></a>
            <a href="/" class="squareBtn"><?php echo Yii::t('front_end', 'search_capital'); ?></a>
            <div class="clear"></div>
            <a href="<?php echo Yii::app()->baseUrl; ?>/blog/help" class="squareBtn"><?php echo Yii::t('front_end', 'help_capital'); ?></a>
            <a href="<?php echo Yii::app()->baseUrl; ?>/contact" class="squareBtn"><?php echo Yii::t('front_end', 'contact_capital'); ?></a>
        </div>
        <div class="clear"></div>
    </div>
  </div>
</section>