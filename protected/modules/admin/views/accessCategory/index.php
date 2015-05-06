<?php
/* @var $this AccessCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Management Categories',
);
$form_title = ($category_id==0)? "New Category" : "Update Category";
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
<div class="portlet box green">
<div class="portlet-title">
	<div class="caption">
		<i class="fa fa-reorder"></i><?php echo $form_title;?>
	</div>
	<div class="tools">
		<a href="javascript:;" class="collapse">
		</a>
	</div>
</div>
<div class="portlet-body form">
<form class="form-horizontal" role="form" id="form_category" action="/admin/accessCategory/update" method="post">
<input type="hidden" name="country_id" value="1">
<input type="hidden" name="category_id" value="<?php echo $category_id;?>">
<div class="form-body">
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		You have some form errors. Please check below.	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		Your form validation is successful!	</div>
									
        <div class="form-group row">           
            <label class="control-label col-md-1">Name : </label>
		<div class="col-md-3">
                    <input data-validation="required" class="form-control dvalid freesale" name="category" type="text" value="<?php echo $category_name;?>"/>
                </div>
	</div>
        <div class="form-group row">
            <div class="col-md-12">  
                    <?php
                    foreach($rmodel as $ky=>$cat)
                    {
                        $selected = (in_array($cat->id,$secIds))? "checked" : "";
                    ?>   
                <div class="panel-group accordion scrollable rolePanel" id="accordion<?php echo $cat->id;?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <label class="cat_title" style="position: absolute;margin-top:2px;"><input type="checkbox" <?php echo $selected;?> name="<?php echo $cat->id;?>" class="icheck mcheck<?php echo $cat->id;?>" onclick="selectAll(<?php echo $cat->id;?>);" value="<?php echo $cat->id;?>"><?php echo $cat->section_name; ?></label>
                                <a class="accordion-toggle" data-toggle="collapse" style="height:20px" data-parent="#accordion<?php echo $cat->id;?>" href="#collapse_<?php echo $cat->id;?>">
                                    
                                </a>
                            </h4>
                        </div>
                        <?php
                        $child = AdminSection::getchildcategories($cat->id);
                        if(count($child))
                        {
                           
                        ?>
                        <div id="collapse_<?php echo $cat->id;?>" class="panel-collapse in">
                            <div class="panel-body">											
                                <div class="">															
                                    <div class="input-group">
                                        <div class="icheck-inline">
                                            <?php
                                            foreach ($child as $ck=>$smenu)
                                            {
                                                 $selected = (in_array($smenu->id,$secIds))? "checked" : "";
                                                ?>
                                            <label class="rolelist"><div class="overlay"></div><input type="checkbox" <?php echo $selected;?> name="<?php echo $smenu->id;?>" class="icheck check<?php echo $cat->id;?>" value="<?php echo $smenu->id;?>"><?php echo $smenu->section_name; ?></label>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>                
            </div>
        </div>
    
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" name="sub" value="action" class="btn green">Submit</button>	
				<a class="btn default" href="/admin/accessCategory">Cancel</a>			
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
</form>
</div>
</div>
<h4>Category List</h4>
<div class="row">
	<div class="col-md-12">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hotel-grid',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>'Showing {start} to {end} of {count} entries'.
    CHtml::dropDownList(
         'pageSize',
         $pageSize,
         Yii::app()->params['pageSizeOptions'],
         array('class'=>'change-pageSize')) .' rows per page',
	'template'=>'{items} {summary} {pager}',
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width',
	'pager'=>array(
		'header'=>false,
		'firstPageLabel' => "<<",
		'prevPageLabel' => "<",
		'nextPageLabel' => ">",
		'lastPageLabel' => ">>",
	),	
	'columns'=>array(
		//'idJob',
		array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->name',
		),
		//'city.name:text:City',
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/accessCategory", array("catId"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/accessCategory/delete", array("catId"=>$data->id))',
				),
			),
		),
	),
)); ?>
</div>
</div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js?ver=<?php echo strtotime("now");?>"></script>
<script src="/metronic/custom/form-validation-accesscategory.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->

<script>
jQuery(document).ready(function() {   
         FormValidation.init();
 });

/*
$('.panel-collapse').collapse("hide");
$('#collapse_6').collapse("show");
$('#collapse_9').collapse("show");
*/

/*custom checkbox code starts here*/
$('.cat_title').click(function(){
	if($(this).find('input:checkbox').is(':checked'))
	{
		var parent = $(this).closest(".accordion");
		var inputWrap =  parent.find(".rolelist").children(".checker").children("span");
		inputWrap.addClass('checked');
		inputWrap.find("input:checkbox").prop('checked', true);
	}
	else{
		var parent = $(this).closest(".accordion");
		var inputWrap =  parent.find(".rolelist").children(".checker").children("span");
		inputWrap.removeClass('checked');
		inputWrap.find("input:checkbox").prop('checked', false);

	}  
});


$('.rolelist .overlay').click(function(){
	if($(this).next().find('input:checkbox').prop('checked')==false)
	{
		var chkbox_count = 1;
		var parent = $(this).closest(".accordion");
		var no_ofchkbox = parent.find('.rolelist').length;

		parent.find('.rolelist').each(function(){
			if($(this).children(".checker").children("span").hasClass('checked')){
				chkbox_count++; 
			}
		});	 
		if(no_ofchkbox == chkbox_count) 
		{
			console.log(parent);
			parent.find(".cat_title").children(".checker").children("span").addClass("checked");
			parent.find(".cat_title").find("input:checkbox").prop('checked', true);	
		}    
	}
	else if($(this).next().find('input:checkbox').prop('checked')==true)
	{
		var parent = $(this).closest(".accordion");
		parent.find(".cat_title").children(".checker").children("span").removeClass("checked");
		parent.find(".cat_title").find("input:checkbox").prop('checked', false);		
	}	
});
/*custom checkbox code ends here*/
</script>


