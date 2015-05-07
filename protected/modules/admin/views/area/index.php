<?php 
$this->breadcrumbs=array(
		'Area'
);
?>
<div class="row noMargin">
	<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model,'search'=>$search,'selected'=>$selected)); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/area/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'portal-grid',
	'dataProvider'=>$model->search(),
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>'Showing {start} to {end} of {count} entries',
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
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','Name').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>array($this, 'getarea'),
		),
		array(
			'name'=>'City',
			'value'=>array($this, 'getcity1'),
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/area/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/area/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
			</div>