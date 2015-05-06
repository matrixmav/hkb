<?php 
$this->breadcrumbs=array(
		'Equipments'=>array('/admin/equipment/index/type/room'),
		'Room'
);
?>
<div class="row noMargin">
	<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model,'type'=>'room')); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">		
			<div class="form-group pull-right">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
			<div class="form-group pull-left">
				<?php echo CHtml::link(Yii::t('translation','Rooms'), '/admin/'.  get_class($model) .'/index/type/room', array("class"=>"btn  green margin-right-20")); ?>
			</div>
			<div class="form-group pull-left margin-left15">
				<?php echo CHtml::link(Yii::t('translation','Hotels'), '/admin/'.  get_class($model) .'/index/type/hotel', array("class"=>"btn  green margin-right-20")); ?>
			</div>
			<div class="form-group pull-left margin-left15">
                <button type="button" onclick="saveOrder()" class="btn green"><?php echo Yii::t('translation','Submit');?></button>	
            </div>
		
	</div>
</div>
<h4><?php echo Yii::t('translation','Rooms'); ?></h4>
<form action="/admin/equipment/orderupdate" id="formsortable" name="form1">
<input type="hidden" name="HotelPhoto[position]" id="position" value="">
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sortable_portlets',
	'dataProvider'=>$dataRoom,
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
			'name'=>Yii::t('translation', 'Name'),
			'value'=>'$data->name',
			'htmlOptions'=>array('width'=>'40%'),
		),
		array(
				'name'=>Yii::t('translation', 'Status'),
				'value'=>'($data->status == 1) ? Yii::t(\'translation\', \'Active\') : Yii::t(\'translation\', \'Inactive\')',
		),
		array(
			'name'=>Yii::t('translation', 'Type'),
			'value'=>'$data->type',
		),
		array(
			'name'=>Yii::t('translation', 'Searchable'),
			'value' => array($this,'searchCheckbox'),
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>Yii::t('translation', 'Edit'),
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/equipment/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Change Status'),
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/equipment/delete", array("id"=>$data->id,"type"=>"room"))',
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
    jQuery(document).ready(function() {       
   // initiate layout and plugins
   //App.init();
   PortletDraggable.init();
    });
    function saveOrder() {
        var checkBox="";
        $('input[name="searchable_type"]:checked').each(function() {
        	   if (checkBox=='')
        		   checkBox = this.value;
               else
            	   checkBox += "," + this.value;
        });
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
		data: "type=room&orderId="+$("#position").val()+"&searchId="+checkBox,
		success:function(result) {
			if(result.status=="SUCCESS"){ 
				window.location.href = "/admin/equipment/index/type/room";
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
    </script>