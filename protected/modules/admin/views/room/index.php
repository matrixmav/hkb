<?php
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Rooms'
);


?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    <?php if(isset($_GET['hotel_id'])){
	$hotel_id = $_GET['hotel_id'];
        $hotelObject = Hotel::model()->findByPk($hotel_id);
        echo "Hotel Name : <b>" . $hotelObject->name . "</b>";
}?>
</div>

<?php $access = Yii::app()->user->getState('access'); ?>
<?php $this->renderPartial('/hotel/_hotel_menu', array('model'=>$hotelObject, 'access'=>$access, 'type' => $type)); ?>

<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/create?hid='.$hotel_id, array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'room-grid',
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
			'header'=>'<span style="white-space: nowrap;">Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->name',
		),
		array(
					'name'=>Yii::t('translation', 'Category'),
					'header'=>'<span style=" color:#1F92FF;white-space: nowrap;">Category&nbsp;</span>',
					'value'=>array($this, 'getCategoryName'),
			),
		array(
			'name'=>'updated_at',
			//'value'=>'date("d/m/Y H:i", $data->updated_at)',
		),
		array(
					'name'=>Yii::t('translation', 'Status'),
					'value'=>'($data->status == 1) ? Yii::t(\'translation\', \'Active\') : Yii::t(\'translation\', \'Inactive\')',
			),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/room/update", array("id"=>$data->id,"hid"=>$data->hotel_id))',
				),
				'Delete' => array(
					'label'=>'Change Status',
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/room/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
			</div>