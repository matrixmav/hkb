<?php $this->breadcrumbs=array(
	'Reservation',
);?>
<div class="row noMargin">
	<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model,'search'=>$search,'selected'=>$selected)); ?>
	</div>
</div>
<h4><?php echo Yii::t('translation','Reservation');?></h4>
<div class="row">
	<div class="col-md-12">
	<?php //echo "----".$model->status;?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'portal-grid',
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
		array(
			'name'=>Yii::t('translation', 'Name'),
			'value'=>'$data->customer["first_name"]." ".$data->customer["last_name"]',
		),
		array(
				'name'=>Yii::t('translation', 'Contact Info'),
				'value'=>'$data->customer["email_address"].(($data->customer["email_address"])?"/":"").$data->customer["telephone"]',
		),
		array(
				'name'=>Yii::t('translation', 'Number'),
				'value'=>'$data->nb_reservation',
		),
		array(
				'name'=>Yii::t('translation', 'Hotel Name'),
				'value'=>'$data->room->hotel->name',
		),
		array(
				'name'=>Yii::t('translation', 'Room Name'),
				'value'=>'$data->room->name',
		),
		array(
				'name'=>Yii::t('translation', 'Res Date'),
				'value'=>'$data->res_date',
		),
		array(
				'name'=>Yii::t('translation', 'Res Status'),
				'value'=>array($this,'gridDataColumn'),
		),
		array(
				'class'=>'CButtonColumn',
				'template'=>'{Detail}',
				'buttons'=>array(
						'Detail' => array(
								'label'=>Yii::t('translation', 'Detail'),
								'options'=>array('class'=>'fa fa-edit btn default btn-xs purple'),
								'url'=>'Yii::app()->createUrl("admin/search/")',
						)
				),
		),
	),
)); ?>
	</div>
</div>