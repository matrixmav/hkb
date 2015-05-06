<section class="wrapper header type2">
  <div class="container2"> <a class="logo" href="<?php echo Yii::app()->getHomeUrl(); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_header.png" alt="Dayuse hotels"></a>
      <!--<form action="/search/index">
      <input type="text" class="searchBox searchBoxcity" value="<?php echo Yii::app()->request->getQuery('name', '');  ?>"  name="term" id="term" placeholder="Hotel, City, District">
      <input type="button" class="searchBtn">      
    </form>-->
      <?php
       $this->widget('application.widgets.SearchWidget', array("type"=>3));
      ?>
    <a href="tel://<?php echo Yii::app()->params['dayuseContactNumber']; ?>" class="phoneNo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/header_ph_icon.png" alt=""><?php echo Yii::app()->params['dayuseContactNumber']; ?></a>
   <?php
    //this is use to show the user login and all 
      $this->widget('application.widgets.HeaderUsersection');
    ?>
    <div class="clear"></div>
  </div>
</section>
<?php 
$model = new Customer;
$this->renderpartial('//customer/login',array('model'=>$model));?>