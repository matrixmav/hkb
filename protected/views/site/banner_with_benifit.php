<section class="wrapper bannerWithBenifit">
  <div class="container">
    <?php $this->renderPartial('//site/breadcrumbs',array('breadcrumbs' => $breadcrumbs));?>
<!-- Slider Images -->
  </div>
  <div class="ofh">
  <div class="flexslider topBanner">
    <div class="searchBoxWrap">
    <div class="searchBox">
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/map.png" alt="" class="mapIcon">
        <?php $this->widget('application.widgets.SearchWidget'); ?>        
    </div>
  </div>
    <a href="javascript:void(0)" class="bannerBottom" id="bannerBottom"></a>
    <ul class="slides">
        <?php //echo "<pre>"; print_r($featuredHotelPhotosObject);
        foreach($featuredHotelPhotosObject as $featuredHotelPhoto) { //echo $featuredHotelPhoto->show_order; ?>
      <li> <?php // echo $featuredHotelPhoto->show_order;?>
          <img src="<?php echo Yii::app()->params['imagePath']['homePageSlider']; ?>city/<?php echo $featuredHotelPhoto->banner; ?>" alt="">
        <div class="container">
          <h1><?php echo ($featuredHotelPhoto->banner_text)? $featuredHotelPhoto->banner_text :Yii::t('front_end', 'text_on_home_banner'); ?></h1>
        </div>
      </li>
        <?php } ?>
    </ul>
  </div>
  <section class="benifits">
    <div class="container">
        <?php 
        $dayuseBenefitsCondition = "benefit_img_page = 'home'";
        $dayuseBenefitsObject = DayuseBenefits::model()->findAll($dayuseBenefitsCondition);
        ?>
      <h2 class="heading"><?php echo Yii::t('front_end', 'dayuse_benifit_capital'); ?></h2>  
      <div class="threeBox">
            <div class="flexslider homeBenefitsSlider">
        <ul class="slides">
            <?php foreach($dayuseBenefitsObject as $dayuseBenefits){ 
                ?>
          <li>
              <?php if(!empty($dayuseBenefits['benefit_img'])) {
                  ?>
                <img src="/<?php echo Yii::app()->params->imagePath['hoteldropzone'].'dayuseBenefits/'.$dayuseBenefits['benefit_img'];?>" />
              <?php } else {?>
                <img src="/images/benefits_slide1.jpg" />
              <?php } ?>
          </li>
            <?php } ?>
        </ul>
      </div>
      <!--<?php $this->renderPartial('//site/dayuse_benefits');?> -->
        <div class="clear"></div>
      </div>
    </div>
  </section>
  </div>
</section>
