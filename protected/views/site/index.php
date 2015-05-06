<!-- home banner-->
<?php 
$this->renderPartial('//site/banner_with_benifit',
        array('featuredHotelPhotosObject'=>$featuredHotelPhotoObject,
        'breadcrumbs' => $breadcrumbs));?>

<!-- ads -->
<?php 
if(!empty($topAdBannerObject)){
    $this->renderPartial('//site/ads',array('bannerObject'=>$topAdBannerObject));
}
?>

<!-- OUR SELECTION -->
<?php $this->renderPartial('//site/our_selection',array(
    'featuredHotelObject'=>$featuredHotelObject,
    'topHotelObject'=>$topHotelObject,
    'bestDealHotelObject'=>$bestDealHotelObject,
    'cityListObject' => $cityListObject,));?>

<!-- mid banner -->
<?php $this->renderPartial('//site/mid_banner',array(
    'featuredHotelObject'=>$featuredHotelObject));?>

<!-- make the most of your dayuse -->
<?php $this->renderPartial('//site/most_of_dayuse');?>

<!-- ads -->
<?php 
if(!empty($bottomAdBannerObject)){
    $this->renderPartial('//site/ads',array('bannerObject'=>$bottomAdBannerObject));
}
?>

<!-- Blogs -->
<?php //$this->renderPartial('//site/blog');?>

<?php $this->renderPartial('//site/press_release');?>   
