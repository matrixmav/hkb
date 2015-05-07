<?php
/* @var $this HomeBannerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Home Ad Banners',
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
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/HomeAdBanner/create', array("class"=>"btn  green margin-right-20")); ?>
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
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','Ad Page').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->ad_page)?ucwords($data->ad_page):""',
		),
                array(
			'name'=>'name',
			'header'=>'<span style="white-space: nowrap;">'.Yii::t('translation','Ad Position').' &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'isset($data->ad_pos)?ucwords($data->ad_pos):""',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>Yii::t('translation', 'Edit'),
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/homeAdBanner/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-trash-o fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/homeAdBanner/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
</div>