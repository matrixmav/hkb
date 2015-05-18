 <?php
/* @var $this MoneyTransferController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transactions List',
);

$this->menu=array(
	array('label'=>'Create Money Transfer', 'url'=>array('create')),
	array('label'=>'Manage Money Transfer', 'url'=>array('admin')),
);
?>
    <?php //echo "<pre>"; print_r($orderObject);?>
       <div class="main">
      <div class="container">

        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
         <!-- BEGIN SIDEBAR -->
<!--          <div class="sidebar col-md-3 col-sm-3">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix"><a href="page-reg-page.html"><i class="fa fa-angle-right"></i> Login/Register</a></li>
              <li class="list-group-item clearfix"><a href="profile.html"><i class="fa fa-angle-right"></i> Profile</a></li>
              <li class="list-group-item clearfix"><a href="orderdetail.html"><i class="fa fa-angle-right"></i> Order List</a></li>
              <li class="list-group-item clearfix"><a href="address.html"><i class="fa fa-angle-right"></i> Address</a></li>
              <li class="list-group-item clearfix"><a href="varification.html"><i class="fa fa-angle-right"></i> Verification</a></li>
              <li class="list-group-item clearfix"><a href="testimonials.html"><i class="fa fa-angle-right"></i> Testimonials</a></li>
              <li class="list-group-item clearfix"><a href="invoice.html"><i class="fa fa-angle-right"></i> Invoice</a></li>
              
            </ul>
          </div>-->
          <!-- END SIDEBAR -->
          <!-- BEGIN CONTENT -->
          <div class="col-md-9 col-sm-9">
       
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
                   'name'=>'slug',
                    'header'=>'<span style="white-space: nowrap;">Receiver &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->usertable->full_name',
		),
		array(
                   'name'=>'slug',
                    'header'=>'<span style="white-space: nowrap;">Actual Amount &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->actual_amount',
		),
		array(
                   'name'=>'slug',
                    'header'=>'<span style="white-space: nowrap;">Paid Amount &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->paid_amount',
		),
		
		array(
                   'name'=>'slug',
                    'header'=>'<span style="white-space: nowrap;">Used RP &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->used_rp',
		),
		array(
                   'name'=>'slug',
                    'header'=>'<span style="white-space: nowrap;">Status &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->status',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'23%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("transaction/view", array("id"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Change Status'),
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("transaction/view", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
                    

      </div>
    </div>