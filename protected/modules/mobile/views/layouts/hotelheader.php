<div class="mobFullpgloader"></div>
<script type="text/javascript">
  $('.mobFullpgloader').width($(window).width());
  $('.mobFullpgloader').height($(window).height());
</script>
<header>
  <div class="wrapper withsearch">
    <a href="/mobile/" class="logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/logo2.png" alt=""></a>
    <a href="#" class="menu"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/menu.png" alt=""></a>      
    <a href="#" class="phone"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/call.png" alt=""></a>
    <a href="#" class="menu"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/searchIcon.png" alt=""></a>
     
    <ul class="menuList">
    <?php if(isset(Yii::app()->session['userid'])){ $mobile="mobile"; ?>
    	<?php $user = Customer::model()->findByPk(Yii::app()->session['userid']);?>
      <li><a href="<?php echo Yii::app()->createUrl('mobile/customer/myaccount'); ?>"><?php echo Yii::t('front_end','My_Account');?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl('mobile/customer/myhotels'); ?>"><?php echo Yii::t('front_end','My_Favourite_Hotels');?></a></li>
      <li><a href="<?php echo Yii::app()->createUrl('mobile/customer/myreservations'); ?>"><?php echo Yii::t('front_end','My_Reservations');?></a></li>
      <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout',array('mobile'=>$mobile)); ?>">Logout</a></li>
      <?php }else{ ?>
      <li><a href="<?php echo Yii::app()->createAbsoluteUrl('mobile/customer/login'); ?>"><?php echo Yii::t('front_end','LOGIN');?></a></li>
      <?php  } ?>
    </ul>
    <div class="clear"></div>
  </div>
</header>
<section class="searchBox">
    <div class="searchCont">
			<?php $this->widget('application.widgets.SearchWidget',array('type'=>4)); ?>        
	</div>
</section>