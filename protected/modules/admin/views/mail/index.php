<?php
$this->breadcrumbs=array(
		'Email'=>array('/admin/email'),
		'inbox'
);


?>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/mail/compose', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'room-grid',
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
		//'idJob',
		array(
			'name'=>'from_user_id',
			'header'=>'<span style="white-space: nowrap;">Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->user->full_name',
		),
		array(
                        'name'=>'$data->message',
                        'header'=>'<span style=" color:#1F92FF;white-space: nowrap;">Message&nbsp;</span>',
                        'value'=>'$data->message',
                    ),
		array(
			'name'=>'$data->updated_at',
                        'header'=>'<span style=" color:#1F92FF;white-space: nowrap;">Date & Time&nbsp;</span>',
			'value'=>array($this, 'convertDate'),
		),
		array(
                        'name'=>Yii::t('translation', 'Status'),
                        'value'=>'($data->status == 1) ? Yii::t(\'translation\', \'Red\') : Yii::t(\'translation\', \'Unred\')',
			),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Replay}{Read}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Replay' => array(
					'label'=>'Replay',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/mail/replay", array("id"=>$data->from_user_id))',
				),
				'Read' => array(
					'label'=>'Read',
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/mail/read", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
			</div>