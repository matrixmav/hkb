<?php $imageurl = "http://dayuse.itvillage.fr/upload/hotel/33/302_197/2437ac01232a575ff1eef2c1d360dacf.jpg";?>
<?php $baseurl = Yii::app()->getBaseUrl(true);?>
<?php $mapicon = $baseurl.'/images/map-pin-red.png'; ?>
<?php $sun = $baseurl.'/images/map-icon-sun.png'; ?>
<?php $halfsun = $baseurl.'/images/map-icon-halfsun.png'; ?>
<?php $moon = $baseurl.'/images/map-icon-moon.png'; ?>
<style>
    #arrival_time-button{display:none;}
</style>
<section class="wrapper hotelTitle">
  <div class="container2">
      <?php 
     //detail
		if(!empty($detail)){
    	$hotelid = $detail->id;
        /*
        $hdel = Hotel::model()->findByPk($hotelid);
        $room_info = Room::model()->getRoomsforSearch($hdel);
        echo "<pre>";
        print_r($room_info);
        echo "</pre>";
        exit;
        */
        
    	$hotelname = $detail->name;
    	$starrating = $detail->star_rating;
    	$address = $detail->address;
    	$postal = $detail->postal_code;
    	$findcity = City::model()->findByPk($detail->city_id);
    	$findcountry = Country::model()->findByPk($detail->country_id);
    	$latitude = $detail->latitude;
    	$longitude = $detail->longitude;
		}
    ?>
    <ul class="breadCamp">
      <li><a href="<?php echo Yii::app()->getHomeUrl(); ?>"><?php echo Yii::t('front_end','Home');?></a></li>
      <li>&gt;</li>
      <li><a href="#"><?php echo $findcountry->slug;?></a></li>
      <li>&gt;</li>
      <li><a href="#"><?php echo $findcity->slug;?></a></li>
      <li>&gt;</li>
      <li><?php echo $hotelname;?></li>
    </ul>
    <input type="hidden" id="hotelid" value="<?php echo $hotelid = $detail->id;?>">
    <input type="hidden" id="lat" value="<?php echo $latitude;?>">
    <input type="hidden" id="lng" value="<?php echo $longitude ;?>">
    <input type="hidden" id="markername" value="<?php echo $hotelname;?>">
    <input type="hidden" id="dateselected" value="">
    <div class="clear15"></div>
    <a href="#" class="share"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/mail.png" alt=""></a> <a href="#" class="share"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook.png" alt=""></a>
    <div class="textPart">
    <?php if($starrating ==1)
    {
    	$rating = "one";
    }elseif($starrating ==2){
    	$rating = "two";
    }elseif($starrating ==3){
    	$rating = "three";
    }elseif($starrating ==4){
    	$rating = "four";
    }elseif($starrating ==5){
    	$rating = "five";
    }else{
    	$rating = "zero";
    }?>
    
      <div class="heading"><h1 alt="<?php echo Yii::app()->params['sitename'];?> <?php echo $hotelname;?>"><?php echo $hotelname;?></h1><span class="Star <?php echo $rating;?>"></span></div>
      <p class="Subheading"><?php echo $address;?> - <?php echo $postal;?> <?php echo $findcity->name;//echo ucwords($findcity->slug);?></p>
      <p class="phone"><?php echo Yii::app()->params['dayuseFooterContactNumber']; ?></p>
    </div>
    <div class="clear20"></div>
  </div>
</section>
<?php $this->renderPartial('_picmap',array('hotelid'=>$hotelid));
$resDate = '';
if(isset($_GET['date'])){
    $resDate = $_GET['date'];
}
$arrtime = "";
if (isset($_GET['arrtime'])) {
    $arrtime = $_GET['arrtime'];
}
?>
<section class="wrapper filter">
  <div class="container2">
    <h2 class="heading"><?php echo Yii::t('front_end','show_prices');?> <?php echo $hotelname; ?></h2>
    <form>
      <span class="hotel_detail_datepicker"> 
      <input type="text" name="chk_dt" id="chk_dt" class="date" value="<?php echo $resDate;?>" readonly="readonly" placeholder="Date">
      <div class="datepicker" id="datepicker"></div>
      </span>
      <div class="arivaltime" >
        <select name="arrival_time_hotel" id="arrival_time_hotel"> 
            <option><?php echo Yii::t('front_end','ARRIVAL_TIME');?></option>
          <?php
            /*$startTime = Yii::app()->params['arrivalTime']['startTime'];
            $endTime = Yii::app()->params['arrivalTime']['endTime'];
            $duration = Yii::app()->params['arrivalTime']['duration'];

            $start = strtotime($startTime);
            $end = strtotime($endTime);
            for ($i = $start; $i <= $end; $i = $i + $duration * 60) {
                echo "<option value=" . base64_encode(date('G:i', $i)) . ">" . date('G:i', $i) . "</option>";
            }
            */
            $sform = new SearchForm();
            $arrivalTimeArray = $sform->getArrivalTimeArray();
            $selected="";            
            for ($i = $arrivalTimeArray['start']; $i <= $arrivalTimeArray['end']; $i = $i + $arrivalTimeArray['duration'] * 60) {
                    $selected = "";
                if(($arrtime!='') && $arrtime == date('G:i', $i)) { $selected = "selected"; }

                echo "<option $selected value=" . date('G:i', $i) . ">" . date('g A', $i) . "</option>";
                    }            
            ?>
        </select>
      </div>
    </form>
  </div>
</section> 
<?php $this->renderPartial('_roomavailable', array('resDate'=>$resDate,'arrtime'=>$arrtime,'hotelid'=>$hotelid, 'hotelname'=>$hotelname, 'rating'=>$rating, 'address'=>$address, 'postal'=>$postal, 'findcity'=>$findcity));?>
<?php $this->renderPartial('_similarhotels', array('hotelid'=>$hotelid, 'hotelname'=>$hotelname, 'rating'=>$rating, 'address'=>$address, 'postal'=>$postal, 'findcity'=>$findcity, 'latitude'=>$latitude, 'longitude'=>$longitude));?>

<section class="wrapper ADD2">
  <div class="container"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/add2.jpg" alt="advertise"> </div>
</section>
<?php $this->renderPartial('//site/press_release');?>   
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js?ver=<?php echo strtotime("now");?>"></script>
<script>     
var filterdata = 1;
var filtersubmit = 1;
var curr_pos_submit = 1;

        $(document).ready(function(){
        	var dateToday = new Date();
          $('.datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dayNamesMin: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
            minDate: dateToday,
            onSelect: function(dateText, inst) {
              var date = $(this).val(); 
              $('#dateselected').val(date);
              $(this).prev('#chk_dt').val(date);
              var hotelid = $('#hotelid').val();
              var arrtime = $('#arrival_time_hotel').find(":selected").val();
              $('.contentloader').show();
              $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('hotel/roomavailability'); ?>",
                data: { hotelid: hotelid,date :date, arrtime :arrtime },
                success: function(result){
                	$('.contentloader').hide();
                  $('#availableroomblock').html(result);
                }
              });
            }   
          });
				$('.showprice').click(function(){			 
					  $('.datepicker').datepicker().show();					 
					});
				 $("#arrival_time_hotel").selectmenu({ change: function( event, ui ) { 
                                        //alert("test");
					 /*var newdate = $(this).val(); 
					 $('.statbook').each(function(){
							var oldhref = $(this).attr("href");
					 		var res = oldhref.split("arrtime="); 
					 		var newhref = res[0]+"arrtime="+newdate;
					 		$(this).attr("href",newhref);
						 });*/
					 var hotelid = $('#hotelid').val();
					 var date = $('#chk_dt').val();
					 var arrtime = $(this).val();
                                         //alert(date);
					 if(date != "")
					 {
                                            $('.contentloader').show();
                                            $.ajax({
                                              type: "POST",
                                              url: "<?php echo Yii::app()->createUrl('hotel/roomavailability'); ?>",
                                              data: { hotelid: hotelid,date :date, arrtime :arrtime },
                                              success: function(result){
                                                      $('.contentloader').hide();
                                                $('#availableroomblock').html(result);
                                              }
                                            });
				 	 }
					 }});
            });
            
            $(".ui-autocomplete li").on("click", function(){
            alert("asdfsdfsd");
            });
            
</script>
<style>
      #map-canvas {
        width: 300px;
        height: 350px;
      }
    </style>
    <script>
    var locations = [['<?php echo $hotelname;?>', <?php echo $latitude;?>, <?php echo $longitude;?>, 1,'<?php echo $imageurl;?>','<?php echo $address;?>',<?php echo $postal;?>]];
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 10,
        disableDefaultUI: true,
        center: new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
     	 position: new google.maps.LatLng(locations[i][1], locations[i][2]),
     	    map: map,
     	    icon: '<?php echo $mapicon;?>',
     	    animation: google.maps.Animation.DROP
      });
     
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent('<?php echo $hotelname;?>');
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
    </script>