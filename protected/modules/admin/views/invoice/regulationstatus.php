<?php
$this->breadcrumbs = array(
    'Reservation'
);
?>
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>

<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<div class="row noMargin">
    <div class="col-md-12">
        <?php //$this->renderPartial('_search',array('model'=>$model,'search'=>$search,'selected'=>$selected)); ?>
    </div>
</div>
<?php 
$style = '';
if(empty($showDateFlag)){
    $style = 'style="display:none;"';
}
$showSearchFlag  ='';
if(empty($showSearch)){
    $showSearchFlag = 'style="display:none;"';
}
$pendingSearchFlag = '';
if(empty($pendingFlag)){
    $pendingSearchFlag = 'style="display:none;"';
}
$refusedSearchFlag = '';
if(empty($refusedFlag)){
    $refusedSearchFlag = 'style="display:none;"';
}
?>
<div class="expiration margin-topDefault" <?php echo $style; ?> >
    <form id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/invoice/regulationstatus" />
    <?php $currentYear = date('Y'); 
    $next10Year = date("Y",strtotime("10 year"));
    ?>
    <select class="customeSelect form-control input-small select2me pull-left margin-right15" id="year" name="year">
        <?php for ($year=$currentYear; $year<= $next10Year; $year++) {?>
            <option value="<?php echo $year; ?>" <?php if($currentYear == $year){ echo "selected"; } ?> ><?php echo $year; ?></option>
        <?php } ?>
    </select>

    <select class="customeSelect form-control input-small select2me pull-left margin-right15" id="month" name="month">
        <?php 
        $monthList =  Yii::app()->params['months'];
        $key = 1;
        foreach($monthList as $month){ ?>
            <option value="<?php echo $key; ?>" <?php if($key == $selectedMonth) { echo "selected"; }?>><?php echo $month; ?></option>
        <?php $key++; } ?>
    </select>
    <?php 
    $statusId =   1;
    if(isset($_REQUEST['res_filter'])){
      $statusId =   $_REQUEST['res_filter'];
    } ?>
   
    <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    <a  class="btn btn-primary" target="_blank"  name="download" onclick="generatecsv();">Export</a>
    </form>
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
                    'name' => 'payment_date',
                    'header' => '<span style="white-space: nowrap;">Invoice Date &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->invoice->inv_due_date',
                ),

                array(
                    'name' => 'inv_no',
                    'header' => '<span style="white-space: nowrap;">Invoice &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->inv_no',
                ),
                array(
                    'name' => 'id',
                    'header' => '<span style="white-space: nowrap;">Client &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->hotel->name',
                ),
                array(
                    'name' => 'paid_inv',
                    'header' => '<span style="white-space: nowrap;">Amount &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->paid_inv',
                ),
                array(
                    'name' => 'inv_no',
                    'header' => '<span style="white-space: nowrap;">Means &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '($data->payment_type == 1)?"Cheque":"Cash"',
                ),
                array(
                    'name' => 'payment_ref',
                    'header' => '<span style="white-space: nowrap;">Reference &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->payment_ref',
                ),
                array(
                    'name' => 'payment_ref',
                    'header' => '<span style="white-space: nowrap;">Bank Code &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->bank->code',
                ),
                array(
                    'name' => 'payment_date',
                    'header' => '<span style="white-space: nowrap;">Payment Date &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->payment_date',
                ),
            ),
        ));
        ?>

    </div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script>
function generatecsv()
{
    var yr = $("#year").val();
    var mn = $("#month").val();
    window.open("/admin/invoice/createregulationstatuscsv?month="+mn+"&year="+yr);
}
</script>