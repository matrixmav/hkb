<?php
spl_autoload_unregister(array('YiiBase', 'autoload'));

define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
$legalesPost = get_post(180); ?>
<section class="wrapper contentPart">
<div class="container3">
  	<div class="contentCont">
    	<p class="heading">Affiliation</p>
        <p class="withline"><a href="#">Contact us</a></p>
        <div class="clear50"></div>
        <p> <?php echo $legalesPost->post_content; ?></p>
    </div>
  </div>
</section>
<?php 
spl_autoload_register(array('YiiBase', 'autoload'));
?>