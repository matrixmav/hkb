<?php
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Photos'=>array('/admin/hotel/update?type=photos&id='.$model->id),
		'Add Photo'
);

$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/dropzone/css/dropzone.css"/>
<!-- END PAGE LEVEL SCRIPTS -->		

			<div class="row">
				<div class="col-md-12">					
					<form id="my-dropzone" class="dropzone dz-clickable" action="/admin/hotel/dropzoneupload/type/image/id/<?php echo $model->id?>">
					<div class="dz-default dz-message"><span>Drop files here to upload</span></div></form>
				</div>
			</div>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<a class="btn green" href="/admin/hotel/update/type/photos/id/<?php echo $model->id?>">Done</a>
				</div>
			</div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/lib/markdown.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="/metronic/assets/scripts/custom/components-dropdowns.js"></script>
<script src="/metronic/custom/form-validation-hotel.js?ver=<?php echo strtotime("now");?>"></script>
<script src="/metronic/custom/form-dropzone.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" src="/metronic/assets/plugins/dropzone/dropzone.js?ver=<?php echo strtotime("now");?>"></script> 
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
jQuery(document).ready(function() {   
   // initiate layout and plugins
   ComponentsDropdowns.init();
   FormValidation.init();
});
</script>