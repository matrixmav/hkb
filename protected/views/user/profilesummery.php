<?php
$this->breadcrumbs = array(
    'Account' => array('profile/summery'),
    'Summery',
);

?>
<?php //echo "<pre>"; print_r($orderObject);?>
       <div class="main">
      <div class="container">

        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
         <!-- BEGIN SIDEBAR -->
          <!-- END SIDEBAR -->
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-9">
       
        <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'city-grid',
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
                    'name'=>'package_id',
                    'header'=>'<span style="white-space: nowrap;">Package Name &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'isset($data->moneytransferObject->fund_type)?$data->moneytransferObject->fund_type:""',
		),
                array(
                    'name'=>'domain',
                    'header'=>'<span style="white-space: nowrap;">Domain &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->domain',
		),
                array(
                    'name'=>'start_date',
                    'header'=>'<span style="white-space: nowrap;">Start Date &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->start_date',
		),
                array(
                    'name'=>'end_date',
                    'header'=>'<span style="white-space: nowrap;">End Date &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->end_date',
		),
		array(
			'name'=>'status',
			'value'=>'($data->status == 1) ? Yii::t(\'translation\', \'Completed\') : Yii::t(\'translation\', \'Pending\')',
		),
             
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Builder}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Builder' => array(
					'label'=>'Builder',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'($data->status == 1) ? Yii::app()->createUrl("/order/redirect/", array("id"=>$data->id)): ""',
				),
			),
		),
	),
)); ?>
                    

      </div>
    </div>
