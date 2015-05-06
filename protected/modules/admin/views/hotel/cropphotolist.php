<?php //$photoid = $_GET['pid'];
$photoid = $_GET['photo_id'];
$today = time();
$getphotoname = HotelPhoto::model()->findByPk($photoid);
?>
<input type="hidden" id="photoid" value="<?php echo $photoid;?>" />
<input type="hidden" id="hotelid" value ="<?php echo $getphotoname->hotel_id; ?>"; />
<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			
			<th>Photo</th>
			<th>Resolution</th>
		</tr>
	</thead>
	<tbody>
	<?php  $resolutions =  Yii::app()->params['thumbnails']['cropresolution']; ?>
	<?php foreach($resolutions as $key=>$value){
		clearstatcache();
		$filepath = Yii::getPathOfAlias('webroot')."/upload/hotel/".$getphotoname->hotel_id."/".$key."/".$getphotoname->name;
		$fileexists = file_exists($filepath);
		if($fileexists == 1){
			$file = '<a data-toggle="modal" href="#zoom_'.$key.'"><img height="39" width="64" src="/upload/hotel/'.$getphotoname->hotel_id.'/'.$key.'/'.$getphotoname->name.'?mypic='.$today.'" />';
			$cropbutton = '<a class="btn purple fa fa-edit margin-right15" title="Crop" href="/admin/hotel/editphoto?type=photos&id='.$getphotoname->hotel_id.'&photo_id='.$photoid.'&res='.$key.'">Crop</a>';
		}else {
			$file = "Image not available";
			$cropbutton = ' ';
		}
		?>
		<tr class="portlet">
			<td><a href="#" data-toggle="modal"><?php echo $file; ?></a></td>
			<td><?php echo $value; ?></td>
			<td width="23%" class="button-column"><?php echo $cropbutton; ?></td>
		</tr>
		<?php echo '<div class="modal fade" id="zoom_'.$key.'" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog" style="width:675px">
						<div class="modal-content">
							<div class="modal-body">
								 <img width="640" src="/upload/hotel/'.$getphotoname->hotel_id.'/'.$key.'/'.$getphotoname->name.'?mypic='.$today.'">
											 </div>
						</div>
					</div>
				</div>';
		?>
		<?php } ?>
	</tbody>
</table>
  
<script>
$(document).ready(function(){
	var hid = $('#hotelid').val();
	var pid = $('#photoid').val();
	
	$('.page-breadcrumb li').html("<a class='btn  green margin-right-20' style='color:#fff' href='/admin/hotel/update?id="+hid+"&type=photos'> << Back </a>");
});
</script>