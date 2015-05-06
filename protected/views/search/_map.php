<?php $baseurl = Yii::app()->getBaseUrl(true);?>
<?php $mapicon = $baseurl.'/images/map-pin-black-new.png'; ?>
<?php $mapicon1 = $baseurl.'/images/map-pin-red-new.png'; ?>
<?php $sun = $baseurl.'/images/map-icon-sun.png'; ?>
<?php $halfsun = $baseurl.'/images/map-icon-halfsun.png'; ?>
<?php $moon = $baseurl.'/images/map-icon-moon.png'; ?>
<div id="map-canvas" class="searchPageMap"></div>
<div style="position: absolute;z-index: 1;top: 0;margin-left: 37px;margin-top: 65px;"><a id="maprefresh"><img  src="<?php echo $baseurl;?>/images/map-refresh.png"/></a></div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<style> 
	#map-canvas {width: 100%;height: 100%;}
</style>

<script>
	var latitude = <?php echo $latitude; ?>;
	var longitude = <?php echo $longitude; ?>;
	var icon1 = '<?php echo $mapicon; ?>'; 
	var icon2 = '<?php echo $mapicon1; ?>';
	var markers = {};
	var marker;
	var infoContent = [];
	var infoWindow;
var locations = [
	<?php 
    	$counter=0;
        if(count($allHotelData))
        {
                    foreach($allHotelData as $hotel){
        	$hotelimage = HotelPhoto::model()->findByAttributes(array('hotel_id'=>$hotel->id, 'is_featured'=>1));
            if(empty($hotelimage)) {
				$hotelimage = HotelPhoto::model()->findAllByAttributes(array('hotel_id'=>$hotel->id));
                foreach ($hotelimage as $getimage){
                	$imageurl = $baseurl."/upload/hotel/".$hotel->id."/180_120/".$getimage->name;
				}
           	} else {
            	$imageurl = $baseurl."/upload/hotel/".$hotel->id."/302_197/".$hotelimage->name;
			}
	?>
    ["<?php echo trim($hotel->name);?>", <?php echo trim($hotel->latitude);?>, <?php echo trim($hotel->longitude);?>, <?php echo trim($counter);?>,"<?php echo trim($imageurl);?>","<?php echo trim($hotel->address);?>","<?php echo trim($hotel->postal_code);?>","<?php echo $hotel->slug;?>","<?php echo $hotel->id;?>"],
    <?php ++$counter; } 
        }
    ?>
 ];

var map;
function initialize() {
	  var mapOptions = {
			zoom: 12,
		    disableDefaultUI: true,
		    center: new google.maps.LatLng(latitude, longitude),
		    mapTypeId: google.maps.MapTypeId.ROADMAP,
	  };
	  map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

	  var zoomControlDiv = document.createElement('div');
	  var zoomControl = new ZoomControl(zoomControlDiv, map);

	  zoomControlDiv.index = 1;
	  map.controls[google.maps.ControlPosition.TOP_LEFT].push(zoomControlDiv);
}

google.maps.event.addDomListener(window, 'load', initialize);

 function ZoomControl(controlDiv, map) {
 	// Creating divs & styles for custom zoom control
    controlDiv.style.padding = '5px';
    

	// Set CSS for the control wrapper
    var controlWrapper = document.createElement('div');    	  
    controlWrapper.style.cursor = 'pointer';
    controlWrapper.style.width = '28px'; 
    controlWrapper.style.marginTop = '55px';
    controlWrapper.style.height = '54px';
    controlDiv.appendChild(controlWrapper);
    	  
    // Set CSS for the zoomIn
    var zoomInButton = document.createElement('div');
    zoomInButton.style.width = '28px'; 
    zoomInButton.style.height = '27px';
    /* Change this to be the .png image you want to use */
    zoomInButton.style.backgroundImage = 'url("<?php echo $baseurl; ?>/images/map-icon-zoomin.png")';
    controlWrapper.appendChild(zoomInButton);
    	    
	// Set CSS for the zoomOut
    var zoomOutButton = document.createElement('div');
    zoomOutButton.style.width = '28px'; 
    zoomOutButton.style.height = '27px';
    /* Change this to be the .png image you want to use */
    zoomOutButton.style.backgroundImage = 'url("<?php echo $baseurl; ?>/images/map-icon-zoomout.png")';
    controlWrapper.appendChild(zoomOutButton);

	// Setup the click event listener - zoomIn
    google.maps.event.addDomListener(zoomInButton, 'click', function() {
    	map.setZoom(map.getZoom() + 1);
	});
    	    
    // Setup the click event listener - zoomOut
    google.maps.event.addDomListener(zoomOutButton, 'click', function() {
    	map.setZoom(map.getZoom() - 1);
	});  
    	    
 }
  
  $(window).resize(function(){
	map.panTo(new google.maps.LatLng(latitude, longitude));
  });
  
  $(window).load(function() {    	
 	//$('.gmnoprint.gm-style-cc').next	().addClass('customZoomControls'); 
        MapSetting();
    
  });
  function MapSetting()
  {
      $('.mapCont').click(function(){
    	if($('.gm-style-iw:visible')) {
        		$('.gm-style-iw').parent().addClass('mapPopupPane');
		}
	});
    
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < locations.length; i++) { 
        hotelid =  locations[i][8];
    	marker = new google.maps.Marker({
   	    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
   	    map: map,
   	    icon: '<?php echo $mapicon;?>',
   	    animation: google.maps.Animation.DROP
    	});
    	 markers[hotelid] = marker;  
    	 
    	google.maps.event.addListener(marker, 'click', (function(marker, i) {
   	 	return function() {
   	 	$('.mapPopupPane').hide();
   	    	infowindow.setContent('<div class="imageWrap"><a href="<?php echo $baseurl; ?>/hotel/detail?slug='+locations[i][7]+'"><img src="'+locations[i][4]+'" class="hotelImage" /></a><div class="timingsIcons"><span><img src="<?php echo $sun;?>" /></span><span><img src="<?php echo $halfsun;?>" /></span><span><img src="<?php echo $moon;?>" /></span></div><div><div class="address"><a  href="<?php echo $baseurl; ?>/hotel/detail?slug='+locations[i][7]+'"><strong>'+locations[i][0].substring(0,25)+' <span class="Star four"></span></strong></a><br/>'+locations[i][5]+'<br/>'+locations[i][6]+'</div><div class="ratingpart"><div class="discountQuote"><span class="smallText">-</span><span class="bigText">60<span class="persantage">%</span></span></div><div class="from"><span class="text">from</span><span class="currency" style="display:none;">$</span><span class="price">$75</span> </div></div></div></div>');
    	    infowindow.open(map, marker);
	   	     
   		}
   	  
    	})(marker, i));
    	google.maps.event.addListener(map, 'click', (function(marker, i) {
       	 	return function() {
       	    	infowindow.close(map, marker);
    	   	     
       		}
        	})(marker, i));
    	
     }
     window.setTimeout(function() {
    	map.panTo(new google.maps.LatLng(latitude, longitude));
      },3000);
  }
  $(window).on('resize', function() {
 	map.panTo(new google.maps.LatLng(latitude, longitude));
  })
  $(document).ready(function(){
	
 	$('#maprefresh').click(function(){
    	map.setZoom(12);
    	//map.panTo(marker.getPosition());
    	//map.setCenter(map.getPosition());
    	map.panTo(new google.maps.LatLng(latitude, longitude));
    	//$(".mapCont").load(location.href + ".mapCont");
	});
	var initial = "initial";
 	hoverresult(initial);
  });
function hoverresult(checkstat){
	
	$('.eachResult').mouseover(function(){
	 	
		
		var htllat = $(this).find('.hotelName').attr("htl-lat");
		var htlong = $(this).find('.hotelName').attr("htl-long");
		var icids = $(this).find('.hotelName').attr("htl-id");
	
		markers[icids].setMap(null);
		marker = new google.maps.Marker({
	   	    position: new google.maps.LatLng(htllat, htlong),
	   	    map: map,
	   	    icon: icon2,
	    });
		//var markerId = getMarkerUniqueId(htllat, htlong); // get marker id by using clicked point's coordinate
	
		markers[icids] = marker;  
		
});
$('.eachResult').mouseout(function(){
	var htllat = $(this).find('.hotelName').attr("htl-lat");
	var htlong = $(this).find('.hotelName').attr("htl-long");
	var hotelname = $(this).find('.hotelName').text();
	var slug = $(this).find('.hotelName').attr("htl-slug");
	var postal = $(this).find('.hotelName').attr("htl-postal");
	var htlimage = $(this).find('.hotelName').attr("htl-image");
	var htladdr = $(this).find('.hotelName').attr("htl-address");
	var htlpostal = $(this).find('.hotelName').attr("htl-postal");
	var icids = $(this).find('.hotelName').attr("htl-id");

	markers[icids].setMap(null);
	marker = new google.maps.Marker({
   	    position: new google.maps.LatLng(htllat, htlong),
   	    map: map,
   	    icon: icon1,
    });

	 markers[icids] = marker; 
	for (i=0 ; i < markers.length ; i++)
	{
		alert(markers[i][0]);
	}
	 var infowindow = new google.maps.InfoWindow();

	
	 google.maps.event.addListener(marker, 'click', (function(marker, icids) {
	
	   	 	return function() {
	   	 	$('.mapPopupPane').hide();
	   	 	 infowindow.setContent('<div class="imageWrap"><a href="<?php echo $baseurl; ?>/hotel/detail?slug='+slug+'"><img src="'+htlimage+'" class="hotelImage" /></a><div class="timingsIcons"><span><img src="<?php echo $sun;?>" /></span><span><img src="<?php echo $halfsun;?>" /></span><span><img src="<?php echo $moon;?>" /></span></div><div><div class="address"><a  href="<?php echo $baseurl; ?>/hotel/detail?slug='+slug+'"><strong>'+hotelname+' <span class="Star four"></span></strong></a><br/>'+htladdr+'<br/>'+htlpostal+'</div><div class="ratingpart"><div class="discountQuote"><span class="smallText">-</span><span class="bigText">60<span class="persantage">%</span></span></div><div class="from"><span class="text">from</span><span class="currency" style="display:none;">$</span><span class="price">$75</span> </div></div></div></div>');
	   	 		
	   	        infowindow.open(map, marker); 
	   		}
	    	})(marker, icids));

	 google.maps.event.addListener(map, 'click', (function(marker, icids) {
    	 	return function() {
    	    	infowindow.close(map, marker);
    		}
    	  
     	})(marker, icids));
	
});
}
</script>