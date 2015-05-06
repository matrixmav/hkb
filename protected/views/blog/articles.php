<?php 
spl_autoload_unregister(array('YiiBase', 'autoload'));

define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
$article = get_post($articleId); 

?>

<section class="wrapper contentPart">
  <div class="container3">
    <div class="contentCont">
      <h1 class="heading">ARTICLE</h1>
      <b itemprop="name" ><?php echo $article->post_title; ?></b><br>
      <?php echo $article->post_content; ?>
      </div>
    </div>
  </div>
</section>
<?php 
spl_autoload_register(array('YiiBase', 'autoload'));
?>