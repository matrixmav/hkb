 <?php 
spl_autoload_unregister(array('YiiBase', 'autoload'));
define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
$posts = get_post(6); //dayuse benefits?>
<section class="wpBenefitsBox">
        <?php echo $posts->post_content;?>
</section><?php
spl_autoload_register(array('YiiBase', 'autoload'));
 ?>