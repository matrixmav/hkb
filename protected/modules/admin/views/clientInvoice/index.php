<?php
$this->breadcrumbs = array(
    'Client Invoices'
);
?>
<?php
/* @var $this ClientController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create ClientInvoice', 'url'=>array('create')),
	array('label'=>'Manage ClientInvoice', 'url'=>array('admin')),
);
if(isset($_REQUEST['clientId'])){
    $clientId = $_REQUEST['clientId'];
} else {
    echo "Invalid Client";exit;
}
?>

<div class="row form-group">
    <div class="col-md-12">
        <?php echo CHtml::link(Yii::t('translation', 'Edit Client') . ' <i class=""></i>', '/admin/client/edit?clientId=' . $clientId, array("class" => "btn btn-success")); ?>
        <?php echo CHtml::link(Yii::t('translation', 'View Invoice') . ' <i class=""></i>', '/admin/ClientInvoice?clientId=' . $clientId, array("class" => "btn btn-success")); ?>
        <?php echo CHtml::link(Yii::t('translation', 'Payment') . ' <i class=""></i>', '/admin/ClientInvoice/payment?clientId=' . $clientId, array("class" => "btn btn-success")); ?>   
    </div>
</div>
<hr/>
<div class="expiration margin-topDefault">
    <p>Client/ Hotel/ Bill : <?php echo $clientObject->name; ?></p>
    <form id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/ClientInvoice" />
    <?php $currentYear = date('Y'); 
    $next10Year = date("Y",strtotime("10 year"));
    ?>
    <input type="hidden" name="clientId" id="clientId" value="<?php echo $clientId;?>" />
    <select class="customeSelect form-control input-small pull-left margin-right15" id="year" name="year">
        <?php for ($year=$currentYear; $year<= $next10Year; $year++) {?>
            <option value="<?php echo $year; ?>" <?php if($currentYear == $year){ echo "selected"; } ?> ><?php echo $year; ?></option>
        <?php } ?>
    </select>

    <select class="customeSelect form-control input-small pull-left margin-right15" id="month" name="month">
        <?php 
        $monthList =  Yii::app()->params['months'];
        $key = 1;
        foreach($monthList as $month){ ?>
            <option value="<?php echo $key; ?>" <?php if($key == $selectedMonth) { echo "selected"; }?>><?php echo $month; ?></option>
        <?php $key++; } ?>
    </select>
    <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    </form>
</div>
<hr/>
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
                    'name' => 'client_inv_no',
                    'header' => '<span style="white-space: nowrap;">Invoice &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->client_inv_no',
                ),

                array(
                    'name' => 'inv_date',
                    'header' => '<span style="white-space: nowrap;">Date &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->inv_date',
                ),
                array(
                    'name' => 'client_id',
                    'header' => '<span style="white-space: nowrap;">Client &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->client->name',
                ),                
                array(
                    'name' => 'client_inv_no',
                    'header' => '<span style="white-space: nowrap;">N Invoice &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->client_inv_no',
                ),
                array(
                    'name' => 'label',
                    'header' => '<span style="white-space: nowrap;">Label &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->label',
                ),
                array(
                    'name' => 'client_inv_no',
                    'header' => '<span style="white-space: nowrap;">Amount &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getTotalWvAmount'),
                ),
                array(
                    'name' => 'client_inv_no',
                    'header' => '<span style="white-space: nowrap;">Vat Amount &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getTotalVatAmount'),
                ),
                array(
                    'name' => 'client_inv_no',
                    'header' => '<span style="white-space: nowrap;">Total &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getTotalAmount'),
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{Download}',
                    'htmlOptions' => array('width' => '150px'),
                    'buttons' => array(
                        'Download' => array(
                            'label' => 'Download',
                            'options' => array('class' => 'fa btn default btn-xs black delete'),
                            'url' => 'Yii::app()->createUrl("/admin/ClientInvoice/downloadclientinvoice", array("invId"=>$data->id))',
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
    