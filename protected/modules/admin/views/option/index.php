<?php 
$this->breadcrumbs=array(Yii::t('translation','options_label')); ?>

<div class="row noMargin">
<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model)); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/option/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
		<div class="form-group pull-left margin-left15">
                <button type="button" onclick="saveOrder()" class="btn green"><?php echo Yii::t('translation','Save Display Order');?></button>	
            </div>
	</div>
</div>

<h4><?php echo Yii::t('translation','options_label'); ?></h4>

<form action="/admin/option/orderupdate" id="formsortable" name="form1">
<input type="hidden" name="Option[position]" id="position" value="">
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sortable_portlets',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>Yii::t('translation', 'Showing {start} to {end} of {count} entries'),
	'template'=>'{items} {summary} {pager}',
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width',
	'rowCssClassExpression' => '($data->id==0)?"":"portlet"',
	'rowHtmlOptionsExpression' => 'array("id"=>$data->id)',
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
			'name'=> 'Name',
			'value'=> '$data->name',
		),
		array(
			'name'=> 'Option Type',
			'value'=>'$data->option_type_id ? $data->optionType->name : "-"',
		),
		array(
			'name'=> 'CC Required',
			'value'=>'$data->cc_required ? "Yes" : "No"',
		),
		array(
			'name'=> 'Price',
			'value'=>'$data->default_price && $data->default_price > 0 ? $data->currency ? $data->default_price.html_entity_decode($data->currency->symbol) : $data->default_price : "-"',
		),
		/* array(
			'name'=> 'Status',
			'value'=>'$data->status ? "Active" : "InActive"',
		), */
		array(
			'name'=>Yii::t('translation', 'Updated At'),
			'value'=>'$data->updated_at',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>Yii::t('translation', 'Edit'),
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/option/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-success btn default black delete removeLink'),
					'url'=>'Yii::app()->createUrl("admin/option/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
	</div>
</div>
</form>
<script src="/metronic/assets/scripts/custom/portlet-draggable.js"></script>
<script>
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
		data: "orderId="+$("#position").val(),
		success:function(result) {
			if(result.status=="SUCCESS"){ 
				window.location.href = "/admin/option";
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

jQuery(document).ready(function() { 
	PortletDraggable.init();

	jQuery('body').delegate(".removeLink","click",function(){
		//$(this).closest('tr').prev().children('td').last().find('a').remove();
		var r=confirm("Are you sure, you want to remove this Option?");
		if (r==true){
			$(this).closest('tr').remove();
			return true
		}
	
		return false;
	});
});
</script>