<div class="mapCont"><div id="map-canvas"></div></div>
 <style> 
	#map-canvas {
         width: 100%;
         height: 100%;
      }
</style>
<?php  $baseurl = Yii::app()->getBaseUrl(true); ?>
<?php $mapicon = $baseurl.'/images/map-pin-black-new.png'; ?>
<?php $sun = $baseurl.'/images/map-icon-sun.png'; ?>
<?php $halfsun = $baseurl.'/images/map-icon-halfsun.png'; ?>
<?php $moon = $baseurl.'/images/map-icon-moon.png'; ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
var latitude = <?php echo $latitude; ?>;
var longitude = <?php echo $longitude; ?>;
//console.log(latitude+" "+longitude);
var myLatlng = new google.maps.LatLng(latitude,longitude);

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
["<?php echo $hotel->name;?>", <?php echo $hotel->latitude;?>, <?php echo $hotel->longitude;?>, <?php echo $counter;?>,"<?php echo $imageurl;?>","<?php echo $hotel->address?>",<?php echo $hotel->postal_code;?>],
<?php ++$counter; }
        }?>
];

var map;
function initialize() {
	  var mapOptions = {
			zoom: 11,
		    disableDefaultUI: true,
		    center: new google.maps.LatLng(latitude, longitude),
		    mapTypeId: google.maps.MapTypeId.ROADMAP,
	  };
	  map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

	  var zoomControlDiv = document.createElement('div');
	  var zoomControl = new ZoomControl(zoomControlDiv, map);

	  zoomControlDiv.index = 1;
	  map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(zoomControlDiv);
}

google.maps.event.addDomListener(window, 'load', initialize);

function ZoomControl(controlDiv, map) {
 	// Creating divs & styles for custom zoom control
    controlDiv.style.padding = '5px';

	// Set CSS for the control wrapper
    var controlWrapper = document.createElement('div');    	  
    controlWrapper.style.cursor = 'pointer';
    controlWrapper.style.width = '28px'; 
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
function mapmarker(){
var infowindow = new google.maps.InfoWindow();
var marker, i;
for (i = 0; i < locations.length; i++) {
	//alert(locations[i][1]);
	marker = new google.maps.Marker({
	    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	    map: map,
	    icon: '<?php echo $mapicon;?>',
	    animation: google.maps.Animation.DROP
	});
                   
	google.maps.event.addListener(marker, 'click', (function(marker, i) {
	 	return function() {
	    	infowindow.setContent(locations[i][0]);
	        infowindow.open(map, marker);
		}
	})(marker, i));
 }

}
$(document).ready(function(){
	var map;
	var checkmap= false;
	$('.maptab').click(function(){
			$('#footsection').hide();
			$('body').css('overflow', 'hidden');
			if(!checkmap)
			{	
				initialize();
				mapmarker();
				checkmap= true;	
			}
		
	});
	$('#tabresult').click(function(){
		$('#footsection').show();
		$('body').css('overflow', 'auto');
	});
	$('#tabfilter').click(function(){
		$('#footsection').show();
		$('body').css('overflow', 'auto');
	});
	
	
	});

//Set Map Dimensions starts here
function setmapheight(){
	//map height Calculation
	var mapreducedHeight = $('header').height() + $('.hDetailTabs .ui-tabs-nav').height();
	var wHeight = $(window).height();
	$('.mapCont').height(wHeight - mapreducedHeight);
	map.setCenter(myLatlng);	
}
//Set Map Dimensions ends here

$(window).load(function(){
	setmapheight();	
});
$(window).resize(function(){
	setmapheight();	
	
});
</script>