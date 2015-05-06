<?php
/* @var $this HomeBannerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Home Banners',
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
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/HomeBanner/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'homebanner-grid',
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
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','Banner').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>array($this,'gridImagePopup'),
		),
                array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">Banner Text &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->banner_text)?ucwords($data->banner_text):""',
		),
                array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">Show Order &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->show_order)?ucwords($data->show_order):""',
		),
		array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','City').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->city->slug)?ucwords($data->city->slug):""',
		),
		array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','State').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->state->slug)?ucwords($data->state->slug):""',
		),
		array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','Country').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->country->name)?ucwords($data->country->name):""',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>Yii::t('translation', 'Edit'),
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/homeBanner/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-trash-o fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/homeBanner/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
</div>