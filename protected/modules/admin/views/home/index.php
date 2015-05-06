<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link('Ajouter <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'city-grid',
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
			'name'=>'slug',
			'header'=>'<span style="white-space: nowrap;">Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->slug',
		),
		'slug',
		'latitude',
		'longitude',
		array(
			'name'=>'updated_at',
			//'value'=>'date("d/m/Y H:i", $data->updated_at)',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}',
			'buttons'=>array(
				'Edit' => array(
					'label'=>'<i class="fa fa-edit"></i> Edit',
					'options'=>array('class'=>'btn default btn-xs purple'),
					'url'=>'Yii::app()->createUrl("admin/city/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>'<i class="fa fa-trash-o"></i> Delete',
					'options'=>array('class'=>'btn default btn-xs black delete'),
					'url'=>'Yii::app()->createUrl("admin/city/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
			</div>