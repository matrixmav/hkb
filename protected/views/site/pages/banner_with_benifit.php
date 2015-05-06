<section class="wrapper bannerWithBenifit">
  <div class="container">
    <?php $this->renderPartial('//site/breadcrumbs',array('breadcrumbs' => $breadcrumbs));?>
    <a href="#bannerBottom" class="bannerBottom" id="bannerBottom"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/bannerBottom.png" alt=""></a>
    <div class="searchBox">
    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/map.png" alt="" class="mapIcon">
        
        <form name="hotel_search" id="hotel_search" method="post" action="/hotel/search">
        	<input type="text" name="name" class="textBox" value="" placeholder="Hotel, City, District">
            <input type="text" name="date" class="dateBox" value="" placeholder="DATE">
            <div class="arivaltime">
            	<select name="arrival_time" id="arrival_time"> 
                    <option>ARRIVAL TIME</option>
                    <?php
                    $startTime = Yii::app()->params['arrivalTime']['startTime'];
                    $endTime = Yii::app()->params['arrivalTime']['endTime'];
                    $duration = Yii::app()->params['arrivalTime']['duration'];
                    
                    $start = strtotime($startTime);
                    $end = strtotime($endTime);
                    for ($i = $start; $i <= $end; $i = $i + $duration * 60) {
                        echo "<option value=" . date('G:i', $i) . ">" . date('G:i', $i) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="length">
            	<select name="time_length" id="time_length">
                    <option>LENGTH</option>
                    <?php 
                    $timeLengthArray = Yii::app()->params['timeLength'];
                    foreach ($timeLengthArray as $key=>$value) {?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>;
                    <?php } ?>
                </select>
            </div>
            <input type="submit" class="searchBtn" value="Search">
        </form>
    </div>
  </div>
  <div class="ofh">
  <div class="flexslider topBanner">
    <ul class="slides">
        <?php foreach($featuredHotelPhotosObject as $featuredHotelPhoto ) {?>
      <li> <img src="<?php echo Yii::app()->params['imagePath']['homePageSlider']; ?>/city/<?php echo $featuredHotelPhoto->banner; ?>" alt="">
        <div class="container">
          <p>150 000 rooms already booked in 2000 hotels &amp; 320 cities</p>
        </div>
      </li>
        <?php } ?>
    </ul>
  </div>
  <section class="benifits">
    <div class="container">
        
      <p class="heading">DAYUSE BENEFITS</p>
      <div class="threeBox">
      <?php 
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        define('WP_USE_THEMES', false);
        require('blog/wp-blog-header.php');
        $posts = get_post(6); //dayuse benefits?>
        <section class="wpBenefitsBox">
                <?php echo $posts->post_content;?>
        </section><?php
        spl_autoload_register(array('YiiBase', 'autoload'));
         ?>
              
       
        <div class="clear"></div>
      </div>
    </div>
  </section>
  </div>
</section>