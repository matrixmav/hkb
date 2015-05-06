<div id="footsection">
<section class="contactUs tcenter">
	<p class="normal"><?php echo Yii::t('mobile', 'contact_us'); ?></p>
    <a class="call" href="tel://<?php echo Yii::app()->params['dayuseContactNumber']; ?>"><?php echo Yii::app()->params['dayuseContactNumber']; ?></a>
</section>
<section class="socialAndApp">
	<ul>
    	<li><a href="<?php echo Yii::app()->params['facebookPageUrl']; ?>" target="_blank" ><img alt="" src="/images/mobile/facebook.png"></a></li>
        <li><a href="<?php echo Yii::app()->params['twitterPageUrl']; ?>" target="_blank" ><img alt="" src="/images/mobile/tweet.png"></a></li>
        <li><a href="<?php echo Yii::app()->params['instagramPageUrl']; ?>" target="_blank" ><img alt="" src="/images/mobile/insta.png"></a></li>
    </ul>
    <div class="AppCont">
        <a class="apple fleft" href="#"><img alt="" src="/images/mobile/apple.png"></a>
        <a class="android fright" href="#"><img alt="" src="/images/mobile/android.png"></a>
        <div class="clear"></div>
    </div>
</section>
<footer>
	<ul>
    	<li><a href="#"><?php echo Yii::t('mobile', 'help'); ?></a></li>
        <li> - </li>
        <li><a href="#"><?php echo Yii::t('mobile', 'terms_privacy'); ?></a></li>
        <li> - </li>
        <li><a href="#"><?php echo Yii::t('mobile', 'legal'); ?></a></li>
    </ul>
    <p class="normal"><?php echo Yii::t('mobile', 'copy_right'); ?></p>
</footer>
</div>