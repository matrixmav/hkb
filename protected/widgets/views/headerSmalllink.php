<ul class="headerSmallLink">
     	<?php if(isset(Yii::app()->session['userid'])){?>
    	<?php $user = Customer::model()->findByPk(Yii::app()->session['userid']);?>
    	<li>
      	<a href="javascript:void(0)"><?php echo $user->first_name;?></a>
      	<ul class="submenu">
            <li><a href="<?php echo Yii::app()->createUrl('customer/myaccount'); ?>"><?php echo Yii::t('front_end','My_Account');?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl('customer/myhotels'); ?>"><?php echo Yii::t('front_end','My_Favourite_Hotels');?></a></li>
            <li><a href="<?php echo Yii::app()->createUrl('customer/myreservations'); ?>"><?php echo Yii::t('front_end','My_Reservations');?></a></li>
            <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>" class="bold logout"><?php echo Yii::t('front_end','Logout');?></a></li>
        </ul>
      </li>
    	<?php  }else{
        //Check if manager is logged in or not
            if(Yii::app()->user->getstate('user_id'))
                {
                ?>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>" class="bold logout"><?php echo Yii::t('front_end','Logout');?></a></li>
                <?php
            }
            else
            {
        ?>
      <li><a class="inlineFancybox bold" href="#loginForm" href="javascript:void(0);" rel="nofollow" ><?php echo Yii::t('front_end','LOGIN');?></a></li>
      <?php } 
        }?>
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
    </ul>