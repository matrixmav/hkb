  <style>
  .carousel-inner > .item{margin: 0;}
  .modal .btn-primary.close_btn{display: block;width: 40px;height: 40px;background: none;border: none;position: absolute;top: -24px;right: -8px;color: #333;}
  .modal .btn-primary.close_btn:hover{color:#000;}
  .modal .btn-primary.close_btn .closeButton{background: #fff;border-radius: 50%;height: 32px;width: 32px;line-height: 33px;box-shadow: 1px 2px 1px rgba(0,0,0,0.3);text-indent: 0px;font-size: 28px;}  
  </style>

<?php 
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Photos'
);
?>
<?php $hotelid = $_GET['id']; $hotelname = Hotel::model()->findByPk($hotelid);?>
<!-- BEGIN CONTAINER -->
	<!-- BEGIN CONTENT -->
	<div class="row form-group">
		<div class="col-md-12">
		<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/update/type/photoadd/id/'.$model->id, array("class"=>"btn  green margin-right-20")); 
		$hotelPhotos = HotelPhoto::model()->findAll('hotel_id=:p1 order by position',array(':p1'=>$model->id));
		if($hotelPhotos){
		?>
		<button type="button" onclick="saveOrder()" class="btn green"><?php echo Yii::t('translation','Submit');?></button>	
		<button class="btn green" id="deleteselected" type="button">Delete Selected</button>
		<?php }?>
		</div>
	</div>
		<div class="row">
		<div class="col-md-12">
	<form action="<?php echo Yii::app()->createUrl($this->route).'?type=photos&id='.$model->id;?>" id="formsortable" name="form1">
	<input type="hidden" name="HotelPhoto[position]" id="position" value="">
			<!-- BEGIN PAGE CONTENT-->
			<div class="" id="sortable_portlets">
				<div class="sortable">
				<!-- BEGIN Portlet PORTLET-->
				<span style="display: none; color:red;" id="photoerr">Please select atleast one photo</span>
				<?php if($hotelPhotos){
		?>
				<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th width="11%"><input type="checkbox" name="selectall" class="selectall" > Select All</th>
			<?php 
			$portals = Portal::model()->findAll();
			foreach($portals as $portal){
				echo "<th>".$portal->name."</th>";
			}?>
			<th></th>
		</tr>
		</thead>								
		<tbody>
		<?php 
		foreach($hotelPhotos as $hotelPhoto){
			$folder=Yii::app()->params->imagePath['hotel'].$model->id."/64_39/";// folder with uploaded files
			$bigImagefolder=Yii::app()->params->imagePath['hotel'].$model->id."/632_422/";// folder with uploaded files
				
			echo "<tr id=$hotelPhoto->id class='portlet'><td><input type='checkbox' name='HotelPhotos[]' class='deletevalues' value='".$hotelPhoto->id."' /></td><td><a data-toggle='modal' href='#zoom_$hotelPhoto->id'><img src='$folder$hotelPhoto->name'></a></td>";
			echo '<div class="modal fade" id="zoom_'.$hotelPhoto->id.'" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog" style="width:675px">
						<div class="modal-content">
							<div class="modal-body">
							<a class="btn btn-primary close_btn" data-dismiss="modal"><i class="fa fa-times-circle closeButton"></i></a>

								<!-- carousel starts here -->

								<div id="carousel-example-generic'.$hotelPhoto->id.'" class="carousel slide" data-ride="carousel">
								  <!-- Wrapper for slides -->
								  <div class="carousel-inner" role="listbox">
								    <div class="item active">
								      <img src="'.$bigImagefolder.$hotelPhoto->name.'">
								    </div>
								    <div class="item">
								     <img src="'.$bigImagefolder.$hotelPhoto->name.'">
								    </div>
								  </div>

								  <!-- Controls -->
								  <a class="left carousel-control" href="#carousel-example-generic'.$hotelPhoto->id.'" role="button" data-slide="prev">
								    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>    
								  </a>
								  <a class="right carousel-control" href="#carousel-example-generic'.$hotelPhoto->id.'" role="button" data-slide="next">
								    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>    
								  </a>
								</div>

								<!-- carousel endss here -->
								 
							</div>
						</div>
					</div>
				</div>';
			foreach($portals as $portKey=>$portal){
				$selected = '';$feselected ='';
				if(array_key_exists($hotelPhoto->id, $photoPort)){
					$tempArry  = $photoPort[$hotelPhoto->id];
					if(in_array($portal->id, $tempArry)){
						$selected = 'checked="checked"';
					}																	
				}
				if($hotelPhoto->is_featured==$portal['id']){
						$feselected = 'checked="checked"';
				}		
				echo "<td><input type='checkbox' $selected name='PhotoPortal[".$portal['id']."][]' value='".$hotelPhoto->id."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input $feselected class='radio-nolabelyii' type='radio' name='HotelPhoto[".$portal['id']."]' value='".$hotelPhoto->id."'></td>";
			}
				$fPath = "/admin/hotel/delete?type=photos&id=$model->id&photo_id=".$hotelPhoto->id;
				$fUrl="javascript:confirmDelete('$fPath')";
				$editUrl = "/admin/hotel/cropphotolist?type=photos&id=$model->id&photo_id=".$hotelPhoto->id;
			if($hotelPhoto->is_featured){
				$fUrl = "javascript: alert('You can not delete a featured image')";
			}
				echo '<td width="23%" class="button-column"><a href="'.$fUrl.'" title="Delete" class="fa fa-success btn default black delete">'.Yii::t('translation','Delete').'</a>&nbsp;<a href="'.$editUrl.'" title="Crop" class="btn purple fa fa-edit margin-right15">'.Yii::t('translation','Crop Selection').'</a></td>';
					
			echo "</tr>";
		}
		?>
		</tbody>
		</table>
		<?php } ?>
		</div>
	</div>
	<!-- END CONTENT -->
	</form>
</div>
<script src="/metronic/assets/scripts/custom/portlet-draggable.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   // initiate layout and plugins
   //App.init();
   PortletDraggable.init();
	$('.selectall').click(function(){
		$('.deletevalues').each(function(){
			   
			   var selectedcls = $(this).parent().attr("class");
			   if(selectedcls == "checked")
			   {
				   $(this).prop('checked', false);
				   $(this).parent().attr("class","");
			   }else{
				   $(this).prop('checked', true);
				   $(this).parent().attr("class","checked");
			   }
			   
		});
	});
   $('#deleteselected').click(function(){
		var i=0;
		$('.deletevalues').each(function(){
			var selectedcls = $(this).parent().attr("class");
			if(selectedcls == "checked")
			   {
				   i++;
			   }
		});
		if(i == 0)
		{
			$('#photoerr').show();
		}else{
			 var shoeArray = [];
			$('input:checkbox.deletevalues').each(function () {
			       var sThisVal = (this.checked ? $(this).val() : "");
			       if(sThisVal != ""){
			    	   shoeArray.push(sThisVal) ;
				       }
			       
			  });
		
			 $.ajax({
	                url: '<?php echo Yii::app()->createUrl('admin/hotel/hotelPhotosDelete')?>',
	                type: 'post',
	                data: { ids: shoeArray },
	                success:function(data){
	                	window.location.reload();
	                }
	            });
		}
   });
  
});
function saveOrder() {

    var imageorder="";
    $("#sortable_portlets .portlet").each(function(i) {
        if (imageorder=='')
        	imageorder = $(this).attr('id');
        else
        	imageorder += "," + $(this).attr('id');
    });
	$("#position").val(imageorder);
    $form=$('#formsortable'); 
	$.ajax({
		dataType:'json',
		type: "get",
		url:$form.attr("action"),
		beforeSend:function(){
			App.blockUI();
		},
		data: $form.serialize(),
		success:function(result) {
			if(result.status=="SUCCESS"){
				window.location.href = "/admin/hotel/update?type=photos&id="+result.id;
			}else {
				showError("Error in saving record");
			}
			App.unblockUI();
		},
		error:function(status, respone, error) {
			showError("Unable to process the request");
			App.unblockUI();
		}
	});       
}
function confirmDelete(url){
	 var x;
	    if (confirm("Are you sure") == true) {
		    window.location.href = url;
	    	 return true;
	    }	
}
</script>