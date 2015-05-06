<?php 
$adimg = ($banner_type=='top')? 'add2.jpg' : 'add1.jpg';
$imagePath = Yii::app()->request->baseUrl."/images/".$adimg;
if(!empty($bannerObject->banner)){
    $imagePath = Yii::app()->params->imagePath['homeAdBanner']."960_133/".$bannerObject->banner;
}
?>

<section class="wrapper ADD">
  <div class="container"> <img src="<?php echo $imagePath;?>" alt="advertise"> </div>
</section>