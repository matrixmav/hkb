<?php
$this->breadcrumbs = array(
    'Client'
);
?>
<?php
/* @var $this ClientController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create Client', 'url'=>array('create')),
	array('label'=>'Manage Client', 'url'=>array('admin')),
);
?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/client/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<!--pendingFlag-->
<div class="row">
    <div class="col-md-12" >
        <?php
        
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'portal-grid',
            'dataProvider' => $dataProvider,
            'enableSorting' => 'true',
            'ajaxUpdate' => true,
            'summaryText' => 'Showing {start} to {end} of {count} entries',
            'template' => '{items} {summary} {pager}',
            'itemsCssClass' => 'table table-striped table-bordered table-hover table-full-width',
            'pager' => array(
                'header' => false,
                'firstPageLabel' => "<<",
                'prevPageLabel' => "<",
                'nextPageLabel' => ">",
                'lastPageLabel' => ">>",
            ),
            'columns' => array(
                //'idJob',
                array(
                    'name' => 'name',
                    'header' => '<span style="white-space: nowrap;">Name &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->name',
                ),

                array(
                    'name' => 'client_no',
                    'header' => '<span style="white-space: nowrap;">Client No &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->client_no',
                ),
                array(
                    'name' => 'email_add',
                    'header' => '<span style="white-space: nowrap;">Email &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->email_add',
                ),                
                array(
                    'name' => 'city',
                    'header' => '<span style="white-space: nowrap;">City &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->city',
                ),

                array(
                    'name' => 'vat_no',
                    'header' => '<span style="white-space: nowrap;">Vat No &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->vat_no',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{Edit}{Delete}',
                    'htmlOptions' => array('width' => '170px'),
                    'buttons' => array(
                        'Edit' => array(
                            'label' => 'Edit',
                            'options' => array('class' => 'btn purple btn-sm fa fa-edit inlineBlock margin-right15'),
                            'url' => 'Yii::app()->createUrl("/admin/client/edit",'
                            . 'array("clientId"=>$data->id))',
                        ),
                        'Delete' => array(
                            'label' => 'Delete',
                            'options' => array('class' => 'fa fa-success btn default black delete'),
                            'url' => 'Yii::app()->createUrl("/admin/client/deleteclient",'
                            . 'array("clientId"=>$data->id))',
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
    