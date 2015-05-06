<?php 
$this->breadcrumbs=array(Yii::t('translation','option_type_label')); ?>

<div class="row noMargin">
<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model)); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>

<h4><?php echo Yii::t('translation','option_type_label'); ?></h4>

<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'option-type-grid',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>Yii::t('translation', 'Showing {start} to {end} of {count} entries'),
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
			'name'=> 'Name',
			'value'=> '$data->name',
		),
		array(
			'name'=> 'Description',
			'value'=>'$data->description',
		),
		array(
			'name'=> 'Price',
			'value'=>'$data->price ? $data->price.html_entity_decode($data->currency->symbol) : "-"',
		),
		array(
			'name'=>Yii::t('translation', 'Updated'),
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
					'url'=>'Yii::app()->createUrl("admin/optionType/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-success btn default black delete removeLink'),
					'url'=>'Yii::app()->createUrl("admin/optionType/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
	</div>
</div>

<script>

$(document).ready(function() { 
	
$('body').delegate(".removeLink","click",function(){
	//$(this).closest('tr').prev().children('td').last().find('a').remove();
	var r=confirm("Are you sure, you want to remove this Option Type?");
	if (r==true){
		$(this).closest('tr').remove();
		return true
	}

	return false;
});
});
</script>