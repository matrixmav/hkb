<?php 
$hotelphoto =  HotelPhoto::model()->findByAttributes(array('hotel_id'=>$hotelid, 'is_featured'=>1), array('order'=>'position ASC'));
$criteria = new CDbCriteria;
$criteria->addCondition("is_featured = 0");
$criteria->addCondition("hotel_id =".$hotelid);
$criteria->order="position ASC";
$hotelphotoall =  HotelPhoto::model()->findAll($criteria);
$userid = Yii::app()->user->id; 
$hotelContent = HotelContent::model()->find("portal_id=1 and type='guide' and language_id=1 and hotel_id=".$hotelid);

?>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>

function myFunction() {
        if(document.getElementById("getMyImage").getAttribute('src') == '/images/feveritSel_50x50.png'){
            document.getElementById("getMyImage").src = '/images/feveritNor_50x50.png';
            var uid =document.getElementById("getMyImage").getAttribute('uid');
            var hid =document.getElementById("getMyImage").getAttribute('hid');      
        }
}//onclick='myFunction()'
</script>
<section class="wrapper hotelPicMap">
  <div class="container2">
    <div class="picCont" style="position: relative;">
          <div class="contentloader1" style="display:block"></div>
    	<div id="showcase" class="showcase" style="visibility: hidden;">
            <div class="favPic">
             <a href="javascript:void(0);" class="fav">
                            <?php
                            $imgSrc = Yii::app()->request->baseUrl . '/images/feveritNor_50x50.png';
                            $fbclass = 'fevimg';
                            if ($userid > 0) {
                                $checkduplication = CustomerFav::model()->findByAttributes(array('customer_id' => $userid, 'hotel_id' => $hotelid));
                            if (empty($checkduplication)) {
                                    $febhotel = FALSE;
                                    $fbclass = 'fevimg';
                                    $imgSrc = Yii::app()->request->baseUrl . '/images/feveritNor_50x50.png';
                                } else {
                                    $febhotel = TRUE;
                                    $fbclass = '';
                                    $imgSrc = Yii::app()->request->baseUrl . '/images/feveritSel_50x50.png';
                                }
                            }
                            ?>
                   <img class="fevimg" id='getMyImage' uid="<?php echo $userid;?>" hid="<?php echo $hotelid; ?>" src="<?php echo $imgSrc; ?>" alt="" onclick='myFunction()'>         
                  </a>
            </div>
    	<?php if(!empty($hotelphoto)){?>
            <div class="showcase-slide">
                <div class="showcase-content">  
                    <img src="<?php echo Yii::app()->params['imagePath']['hotel'] . $hotelid; ?>/727_472/<?php echo $hotelphoto->name; ?>" alt=""/>
                </div>
                <div class="showcase-thumbnail">
                    <img src="<?php  echo Yii::app()->params['imagePath']['hotel'].$hotelid; ?>/64_39/<?php echo $hotelphoto->name;?>" alt=""/>
                </div>
            </div>
            <?php } ?>
            <?php foreach($hotelphotoall as $sliderpics) {?>
            <div class="showcase-slide">
                <div class="showcase-content">
                    <img src="<?php  echo Yii::app()->params['imagePath']['hotel'].$hotelid; ?>/727_472/<?php echo $sliderpics->name;?>" alt=""/>
                </div>
                <div class="showcase-thumbnail">
                    <img src="<?php  echo Yii::app()->params['imagePath']['hotel'].$hotelid; ?>/64_39/<?php echo $sliderpics->name;?>" alt=""/>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script>
		$(window).bind('load', function(){
				$('.contentloader1').hide();
				$('#showcase').css('visibility','visible');
			});
    </script>
    <div class="route">
      <div class="details default-skin">
        <p class="heading"><?php echo Yii::t('front_end','HOW_TO_GET_THERE');?></p>    
        <span style="text-align: center">   
        <p class="text"><?php echo isset($hotelContent->content)?$hotelContent->content:""?></p>
        </span> 
      </div>
      <div class="mapCont"> <div id="map-canvas"></div>
      </div>
    </div>
  </div>
</section>
