<footer class="footer">
  <div class="container">
    <div class="logoPart"> <a href="/"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/footerLogo.png" alt="dayuse"></a>
      <div class="clear"></div>
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
    </div>
    <div class="contact">
      <p class="heading"><?php echo Yii::t('front_end', 'contact-us'); ?></p>
      <a href="tel://<?php echo Yii::app()->params['dayuseFooterContactNumber']; ?>" class="heading2"><?php echo Yii::app()->params['dayuseFooterContactNumber']; ?></a>

      <p><?php echo Yii::t('front_end', 'monday_friday'); ?></p>
    </div>
    <div class="link">
      <p class="heading"><?php echo Yii::t('front_end', 'about_capital'); ?></p>
      <ul>
        <li><a href="<?php echo Yii::app()->createUrl('admin/default/managerlogin'); ?>">Hotel extranet</a></li>
        <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>press"><?php echo Yii::t('front_end', 'press'); ?></a></li>
        <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>help"><?php echo Yii::t('front_end', 'help_capital'); ?></a></li>
        <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>careers">Careers</a></li>
        <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>affiliation">Affiliation</a></li>
        <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>legales"><?php echo Yii::t('front_end', 'legal'); ?></a></li>
        <li><a href="<?php echo Yii::app()->params['blogUrl']; ?>termsprivacy"><?php echo Yii::t('front_end', 'terms_privacy'); ?></a></li>
      </ul>
    </div> 
    <div class="social">
      <p class="heading"><?php echo Yii::t('front_end', 'social'); ?></p>
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/social.png" alt=""> </div>
    <div class="clear"></div>
  </div>
</footer>
<section class="location">
  <div class="container">
    <p><?php echo Yii::t('front_end', 'dayuse_available_country_names'); ?></p>
    <p><?php echo Yii::t('front_end', 'copy_right'); ?></p>
  </div>
</section>