<section class="wrapper header">
  <div class="container resarch">
    <a class="logo" href="<?php echo Yii::app()->getHomeUrl(); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_header.png" alt="Dayuse hotels"></a>
    <?php 
        // here the type 3 define the searchbox.
        $this->widget('application.widgets.SearchWidget', array("type"=>3)); 
    ?>
    <!--<p class="phoneNo"><img src="<?php // echo Yii::app()->request->baseUrl; ?>/images/header_ph_icon.png" alt="ph.">855 378 5969</p-->
    <a href="tel://<?php echo Yii::app()->params['dayuseContactNumber']; ?>" class="phoneNo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/header_ph_icon.png" alt=""><?php echo Yii::app()->params['dayuseContactNumber']; ?></a>
    <?php    
    //this is use to show the user login and all     
      $this->widget('application.widgets.HeaderUsersection');
    ?>    
      <div class="courency">
        <select>
          <option>$</option>
        </select>
      </div>
      <div class="language">
        <select>
          <option>EN</option>
        </select>
      </div>
    <div class="clear"></div>
  </div>
</section>
<?php 
    $this->widget('application.widgets.SearchWidget', array("type"=>2)); 
    
    $model = new Customer;
    $this->renderpartial('//customer/login',array('model'=>$model));
?>