<!-- there are other 2 header they are contract_header.php, headerSmalllink.php -->
<section class="wrapper header">
  <div class="container">
    <a class="logo" href="/"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_header.png" alt="Dayuse hotels"></a>
    <form>
      <div class="language">
        <select>
          <option><?php echo Yii::t('front_end', 'language'); ?></option>
        </select>
      </div>
      <div class="courency">
        <select>
          <option><?php echo Yii::t('front_end', 'currency'); ?></option>
        </select>
      </div>
    </form>
    <a href="tel://<?php echo Yii::app()->params['dayuseContactNumber']; ?>" class="phoneNo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/header_ph_icon.png" alt=""><?php echo Yii::app()->params['dayuseContactNumber']; ?></a>

    <ul class="headerSmallLink">
    	<?php if(isset(Yii::app()->session['userid'])){?>
    	<?php $user = Customer::model()->findByPk(Yii::app()->session['userid']);?>
    	<li>
      	<a href="#"><?php echo $user->first_name;?></a>
      	<ul class="submenu accountsubmenu">
            <li><a href="<?php echo Yii::app()->createUrl('customer/myaccount'); ?>"><?php echo Yii::t('front_end','My_Account');?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl('customer/myhotels'); ?>"><?php echo Yii::t('front_end','My_Favourite_Hotels');?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl('customer/myreservations'); ?>"><?php echo Yii::t('front_end','My_Reservations');?></a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>" class="bold logout"><?php echo Yii::t('front_end','Logout');?></a></li>
        </ul>
      </li>
    	<?php  
        }else{
            //Check if manager is logged in or not
            if(Yii::app()->user->getstate('user_id'))
            {
                ?>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>" class="bold"><?php echo Yii::t('front_end','Logout');?></a></li>
                <?php
            }
            else
            {
           ?>
      <li id="mainLoginLink"><a class="inlineFancybox bold" href="#loginForm" id="main_login" rel="nofollow" ><?php echo Yii::t('front_end','LOGIN');?></a></li>
      <?php } 
        }      
      ?>
      <li class="devider">|</li>
      <li>
      	<a href="<?php echo Yii::app()->params['blogUrl']; ?>help"><?php echo Yii::t('front_end', 'help_capital'); ?></a>
      	<ul class="submenu helpList">
            <!--<a href="echo Yii::app()->params['blogUrl']; ?>faq">echo Yii::t('front_end', 'faq_capital'); ?></a></li>-->
            <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>help">contact us</a></li>
            <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>press"><?php echo Yii::t('front_end', 'press'); ?></a></li>
            <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>careers">careers</a></li>
            <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>legales"><?php echo Yii::t('front_end', 'legal'); ?></a></li>
            <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>termsprivacy"><?php echo Yii::t('front_end', 'terms_privacy'); ?></a></li>
        </ul>
      </li>
      <li class="devider">|</li>
      <li><a href="<?php echo Yii::app()->createUrl('admin/default/managerlogin'); ?>" rel="nofollow"><?php echo Yii::t('front_end', 'hotel_extranet'); ?></a></li>
      <li class="devider">|</li>
      <li><a href="<?php echo Yii::app()->params['facebookPageUrl']; ?>" target="_blank" class="social"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/header_fb.png" alt="f"></a></li>
      <li><a href="<?php echo Yii::app()->params['googlePageUrl']; ?>" target="_blank" class="social"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/header_google.png" alt="g"></a></li>
      <li><a href="<?php echo Yii::app()->params['twitterPageUrl']; ?>" target="_blank" class="social"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/header_tweet.png" alt="t"></a></li>
    </ul> 
    <div class="clear"></div>
  </div>
</section>
<?php 
$model = new Customer;
$this->renderpartial('//customer/login',array('model'=>$model));?>