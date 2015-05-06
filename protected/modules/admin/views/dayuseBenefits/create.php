<?php
/* @var $this DayuseBenefitsController */
/* @var $model DayuseBenefits */

$this->breadcrumbs=array(
	'Dayuse Benefits'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DayuseBenefits', 'url'=>array('index')),
	array('label'=>'Manage DayuseBenefits', 'url'=>array('admin')),
);
?>

<?php

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
                    <form id="my-dropzone" class="dropzone dz-clickable" action="/admin/DayuseBenefits/dropzoneupload/type/image">
                        <select class="form-control input-small select2me" name="page_name" id="page_name">
                        <?php $dayuseBenifitsPageList = Yii::app()->params['dayuse_benifits_page_list'];
                            foreach($dayuseBenifitsPageList as $key=> $dayuseBenifitsPage) { ?>
                                <option value="<?php echo $key; ?> "><?php echo $dayuseBenifitsPage; ?> </option>
                            <?php } ?>
                        </select>
                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div></form>
            </div>
    </div>
<div class="row">
	<div class="col-md-12 margin-topDefault">
		<div class="col-md-12 margin-topDefault">
			<div class="form-group">
                            <span class="pull-left margin-right15"><?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/dayuseBenefits/create', array("class"=>"btn  green margin-right-20")); ?></span>
                                <a class="btn green pull-left" href="/admin/dayuseBenefits">List</a>
			</div>
		</div>
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
<!--<script src="/metronic/custom/form-validation-hotel.js?ver=<?php // echo strtotime("now");?>"></script>-->
<script src="/metronic/custom/form-dropzone.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" src="/metronic/assets/plugins/dropzone/dropzone.js?ver=<?php echo strtotime("now");?>"></script> 
<!-- END PAGE LEVEL STYLES -->
