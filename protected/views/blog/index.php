<!-- home banner-->
<?php 
$this->renderPartial('//site/banner_with_benifit',
        array('featuredHotelPhotosObject'=>$featuredHotelPhotoObject,
        'breadcrumbs' => $breadcrumbs));?>

<!-- ads -->
<?php $this->renderPartial('//site/ads');?>

<!-- OUR SELECTION -->
<?php $this->renderPartial('//site/our_selection',array(
    'hotelObject'=>$hotelObject,
    'cityListObject' => $cityListObject,));?>

<!-- mid banner -->
<?php $this->renderPartial('//site/mid_banner',array(
    'featuredHotelObject'=>$featuredHotelObject));?>

<!-- make the most of your dayuse -->
<?php $this->renderPartial('//site/most_of');?>

<!-- ads -->
<?php $this->renderPartial('//site/ads');?>

<!-- Blogs -->
<?php $this->renderPartial('//site/blog');?>

<?php $this->renderPartial('//site/press_release');?>   
