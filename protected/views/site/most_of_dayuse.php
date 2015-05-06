<section class="wrapper mostOf wpMostof">
  <div class="container">
 <h2 class="heading"><?php echo Yii::t('front_end', 'make_the_most_of_your_dayuse'); ?></h2>
<?php 
spl_autoload_unregister(array('YiiBase', 'autoload'));
        define('WP_USE_THEMES', false);
        require('blog/wp-blog-header.php');
        $posts = get_post(8); //dayuse benefits
        echo $posts->post_content;
        spl_autoload_register(array('YiiBase', 'autoload'));

?>
</div>
</section>