<?php 
spl_autoload_unregister(array('YiiBase', 'autoload'));
define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
$mainArticalPosts = get_posts('numberposts=3&order=DESC&category=4'); //dayuse benefits
$latestPublicationsPosts = get_posts('numberposts=3&order=DESC&category=27'); //dayuse benefits
$advoicePosts = get_posts('numberposts=3&order=DESC&category=7'); //dayuse benefits
 ?> 

<section class="wrapper blogSection">
  <div class="container">
    <div id="blogSection">
      <ul>
        <li><a href="#tab-1"><?php echo Yii::t('front_end', 'main_articles'); ?></a></li>
        <li><a href="#tab-2"><?php echo Yii::t('front_end', 'latest_publications'); ?></a></li>
        <li><a href="#tab-3"><?php echo Yii::t('front_end', 'advice'); ?></a></li>
      </ul>
      <div id="tab-1">
        <div class="threeBox wpBlogSection">
        <?php foreach($mainArticalPosts as $mainArticalPost) { ?>
            <div class="box">
            <a href="<?php echo Yii::app()->createUrl('blog/articale', array("articleId"=>$mainArticalPost->ID)); ?>" >
            <p class="heading2"><?php echo $mainArticalPost->post_title; ?></p></a>
            <p><?php 
            if($mainArticalPost->post_excerpt){
                echo $mainArticalPost->post_excerpt;
            } else {
                echo $mainArticalPost->post_content; 
            }
            ?></p>
            
          </div>
            
            <?php  } ?>
          <div class="clear"></div>
          <a href="<?php echo Yii::app()->params['blogUrl']; ?>allarticles" class="blackBtn"><?php echo Yii::t('front_end', 'see_all_articles'); ?></a> </div>
      </div>
      <div id="tab-2">
        <div class="threeBox  wpBlogSection">
        <?php foreach($latestPublicationsPosts as $latestPublicationsPost) { ?>
          <div class="box">
              <a href="<?php echo Yii::app()->createUrl('blog/article', array("articleId"=>$latestPublicationsPost->ID)); ?>" >
            <p class="heading2"><?php echo $latestPublicationsPost->post_title; ?></p></a>
            <p><?php 
            if($latestPublicationsPost->post_excerpt){
                echo $latestPublicationsPost->post_excerpt;
            } else {
                echo $latestPublicationsPost->post_content; 
            }
            ?></p>
          </div>
             
            <?php  } ?>
          <div class="clear"></div>
          <a href="<?php echo Yii::app()->params['blogUrl']; ?>allarticles" class="blackBtn"><?php echo Yii::t('front_end', 'see_all_articles'); ?></a> 
        </div>
      </div>
      <div id="tab-3">
        <div class="threeBox wpBlogSection">
        <?php foreach($advoicePosts as $advoicePost) { ?>
            
          <div class="box">
              <a href="<?php echo Yii::app()->createUrl('blog/articale', array("articleId"=>$advoicePost->ID)); ?>" >
            <p class="heading2"><?php echo $advoicePost->post_title; ?></p></a>
            <p><?php 
            if($advoicePost->post_excerpt){
                echo $advoicePost->post_excerpt;
            } else {
                echo $advoicePost->post_content; 
            }
            ?></p>
          </div>
                
            <?php  } ?>
          <div class="clear"></div>
          <a href="<?php echo Yii::app()->params['blogUrl']; ?>allarticles" class="blackBtn"><?php echo Yii::t('front_end', 'see_all_articles'); ?></a> 
        </div>
      </div>
    </div>
  </div>
</section>

<?php
spl_autoload_register(array('YiiBase', 'autoload'));

?>