<?php 
$this->breadcrumbs=array(
		'Hotel Managers'
);
$access = Yii::app()->user->getState('access');
if($access!="manager"){
?>
<div class="row noMargin">
	<div class="col-md-12">
		<?php  //$this->renderPartial('_search',array('model'=>$model,'search'=>$search,'selected'=>$selected)); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/admin/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<?php }?>
<h4><?php echo Yii::t('translation','Hotel Managers');?></h4>

<div class="row">
	<div class="col-md-12">
<?php 
	$actions = ($access=="manager")?'{Edit}':"{Edit}{Delete}";
	$width = ($access=="manager")?'10%':"20%";
	$this->widget('zii.widgets.grid.CGridView', array(
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
		//'idJob',
		array(
			'name'=>Yii::t('translation', 'Name'),
			'value'=>'$data->first_name',
		),
		array(
				'name'=>Yii::t('translation', 'Telephone'),
				'value'=>'$data->telephone',
		),
		array(
				'name'=>Yii::t('translation', 'Email'),
				'value'=>'$data->email_address',
		),
		array(
			'name'=>Yii::t('translation', 'Updated'),
			'value'=>'$data->updated_at',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>$actions,
			'htmlOptions'=>array('width'=>$width),
			'buttons'=>array(
				'Edit' => array(
					'label'=>Yii::t('translation', 'Edit'),
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/admin/update", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/admin/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
	</div>
</div>