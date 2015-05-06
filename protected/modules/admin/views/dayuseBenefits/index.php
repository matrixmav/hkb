<?php
/* @var $this DayuseBenefitsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Dayuse Benefits',
);

$this->menu=array(
	array('label'=>'Create DayuseBenefits', 'url'=>array('create')),
	array('label'=>'Manage DayuseBenefits', 'url'=>array('admin')),
);
?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/dayuseBenefits/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'state-grid',
	'dataProvider'=>$dataProvider,
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
                array(
			'name'=>'benefit_img_page',
			'header'=>'<span style="white-space: nowrap;">Page Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->benefit_img_page',
		),
                array(
			'name'=>'benefit_img',
			'header'=>'<span style="white-space: nowrap;">Image Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->benefit_img',
		),
                array(
			'name'=>'updated_at',
			'header'=>'<span style="white-space: nowrap;">updated And Time &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->updated_at',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Delete' => array(
					'label'=>'Delete',
					'options'=>array('class'=>'fa fa-trash-o fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("/admin/DayuseBenefits/deletebenifit", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
			</div>