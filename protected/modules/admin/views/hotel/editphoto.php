<style>
.header.navbar, .page-sidebar-wrapper {
	display: none;
}

.page-container {
	margin-top: 0px !important;
}
.page-content {
	margin-left: 0px;
	margin-top: 0px;
	padding: 5px;
}
</style>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="/metronic/assets/plugins/jcrop/css/jquery.Jcrop.min.css"
	rel="stylesheet" />
<link href="/metronic/assets/css/pages/image-crop.css" rel="stylesheet" />
<!-- END PAGE LEVEL SCRIPTS -->
<?php
$today = time();
$type = "photos";
$hotel_id = $_GET ['id'];
$resl = $_GET['res'];
$hotel = Hotel::model ()->findByPk ( $hotel_id );
$getphotoname = HotelPhoto::model ()->findByPk ( $_GET ['photo_id'] );
?>
<input type="hidden" id="photoid" value="<?php echo $_GET ['photo_id'];?>" />
<div class="tab-pane" id="tab_8">
	<div class="row">
		<div class="col-md-2 responsive-1024">
			<!-- This is the image we're attaching Jcrop to -->
			<img id="CropSource"
				src="/upload/hotel/<?php echo $hotel_id;?>/<?php echo $getphotoname->name;?>?mypic=<?php echo $today;?>"
				id="demo8" alt="Jcrop Example" />
		</div>
		<div class="col-md-10 responsive-1024 form-group" style="position: relative;margin-top:-67px;">
			<!-- This is the form that our event handler fills -->
			<form action="" method="post" id="demo8_form">
			<input type="hidden" id="resolution" name="resolution" value="<?php echo $resl; ?>" />
				<input type="hidden" id="hotelid" name="hotelid" value="<?php echo $hotel_id; ?>" /> 
				<input type="hidden" id="hotelid" name="photoid" value="<?php echo $_GET ['photo_id']; ?>" /> 
				<input type="hidden" name="imagename" value="<?php echo $getphotoname->name; ?>" /> 
				<input type="hidden" id="crop_x" name="x" /> <input type="hidden" id="crop_y" name="y" /> 
				<input type="hidden" id="crop_w" name="w" />
				<input type="hidden" id="crop_h" name="h" /> 
				<input type="submit" value="Crop Image" class="btn btn-large green pull-right margin-right15" id="corpsubmit" />
			</form>
										<?php  //$resolutions =  Yii::app()->params['thumbnails']['cropresolution']; ?>										
										<!-- <select id="windowsize" class="form-control input-large select2me pull-right margin-right15"> 
										<?php // foreach($resolutions as $key=>$value){
										//if($key != "1280_548"){
											?>
										<option value="<?php //echo $key; ?>"><?php // echo $value; ?></option>
										<?php // } }?>
										</select>
										<label class="pull-right margin-right15 margin-topDefault">Set Crop Window Size:</label> --> 
		</div>
	</div>
</div>

<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="/metronic/assets/plugins/jquery-1.10.2.min.js"
	type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery-migrate-1.2.1.min.js"
	type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script
	src="/metronic/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"
	type="text/javascript"></script>
<script src="/metronic/assets/plugins/bootstrap/js/bootstrap.min.js"
	type="text/javascript"></script>
<script
	src="/metronic/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
	type="text/javascript"></script>
<script
	src="/metronic/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
	type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery.blockui.min.js"
	type="text/javascript"></script>
<script src="/metronic/assets/plugins/jquery.cokie.min.js"
	type="text/javascript"></script>
<script src="/metronic/assets/plugins/uniform/jquery.uniform.min.js"
	type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/assets/plugins/jcrop/js/jquery.color.js"></script>
<script src="/metronic/assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/metronic/assets/scripts/core/app.js"></script>
<script src="/metronic/assets/scripts/custom/form-image-crop.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script>
jQuery(document).ready(function() {
	
var hid = $('#hotelid').val();
var pid = $('#photoid').val();
$('.page-breadcrumb li').html("<a class='btn  green margin-right-20' style='color:#fff' href='/admin/hotel/cropphotolist?id="+hid+"&type=photos&photo_id="+pid+"' > << Back </a> ");
	
// initiate layout and plugins
/* $('#windowsize').change(function(){
	$("#CropSource").Jcrop({
        onSelect: storeCoords,
        onChange: storeCoords,
    });
}); */
$("#CropSource").Jcrop({
        onSelect: storeCoords,
        onChange: storeCoords,
    });
function storeCoords(c) {
    jQuery('#crop_x').val(c.x);
    jQuery('#crop_y').val(c.y);
    jQuery('#crop_w').val(c.w);
    jQuery('#crop_h').val(c.h);
    };        
    
App.init();
FormImageCrop.init();
});
</script>