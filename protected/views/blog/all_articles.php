<?php
spl_autoload_unregister(array('YiiBase', 'autoload'));

define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
$headlinesList = get_posts('order=DESC&category=8'); 
$latestNewsList = get_posts('order=DESC&category=9');
$popularArticalList = get_posts('order=DESC&category=17'); 
$ourAdvicelList = get_posts('order=DESC&category=7');
$destinationList = get_posts('order=DESC&category=10');
?>

<section class="wrapper contentPart listArticle">
  <div class="container3">
    <div class="contentCont">
      <p class="heading">ALL ARTICLES</p>
      <div id="ourSelection" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
          <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">HEADLINES</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">LATEST NEWS</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">POPULAR ARTICLES</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false"><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">OUR ADVICES</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-5" aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false"><a href="#tabs-5" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5">DESTINATION</a></li>
        </ul>
        <div id="tabs-1" class="help ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
          <?php foreach ($headlinesList as $headlines) { ?>
            <a href="<?php echo Yii::app()->createUrl('blog/article', array("articleId"=>$headlines->ID)); ?>" >
            <p class="heading2"><?php echo $headlines->post_title; ?></p>
            </a>
            <p><?php echo $headlines->post_date; ?></p>
            
            <?php } ?>	
        </div>
        <div id="tabs-2" class="help ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-2" role="tabpanel" aria-hidden="true" style="display: none;">
          <?php foreach ($latestNewsList as $latestNews) { ?>
            <a href="<?php echo Yii::app()->createUrl('blog/article', array("articleId"=>$latestNews->ID)); ?>" >
            <p class="heading2"><?php echo $latestNews->post_title; ?></p>
            </a>
            <p><?php echo $latestNews->post_date; ?></p>
            <?php } ?>
        </div>
        <div id="tabs-3" class="help ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
          <?php foreach ($popularArticalList as $popularArtical) { ?>
            <a href="<?php echo Yii::app()->createUrl('blog/article', array("articleId"=>$popularArtical->ID)); ?>" >
            <p class="heading2"><?php echo $popularArtical->post_title; ?></p>
            </a>
            <p><?php echo $popularArtical->post_date; ?></p>
            <?php } ?>
        </div>
        <div id="tabs-4" class="help ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-4" role="tabpanel" aria-hidden="true" style="display: none;">
          <?php foreach ($ourAdvicelList as $ourAdvicel) { ?>
            <a href="<?php echo Yii::app()->createUrl('blog/article', array("articleId"=>$ourAdvicel->ID)); ?>" >
            <p class="heading2"><?php echo $ourAdvicel->post_title; ?></p>
            </a>
            <p><?php echo $ourAdvicel->post_date; ?></p>
            <?php } ?>
        </div>
        <div id="tabs-5" class="help ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-4" role="tabpanel" aria-hidden="true" style="display: none;">
          <?php foreach ($destinationList as $destination) { ?>
            <a href="<?php echo Yii::app()->createUrl('blog/article', array("articleId"=>$destination->ID)); ?>" >
            <p class="heading2"><?php echo $destination->post_title; ?></p>
            </a>
            <p><?php echo $destination->post_date; ?></p>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php 
spl_autoload_register(array('YiiBase', 'autoload'));
?>
<?php $this->renderPartial('//site/most_of_dayuse');?>