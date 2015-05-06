<?php
$this->breadcrumbs = array(
    'Reservation'
);
?>
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<div class="row noMargin form-group pull-right" style="margin-top: -59px">
    <div class="col-md-12">
        <span style="display: inline-block;"><select id="select_portel"class="form-control input-small select2me" name="select_portel">
            <?php foreach ($originObject as $origin) { ?>
                <option value="<?php echo $origin->id; ?>"><?php echo $origin->name; ?></option>
            <?php } ?>
        </select></span>
        <span><a class="btn btn-primary" href="#">OK</a></span>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<div class="row noMargin">
    <div class="col-md-12">
        <?php //$this->renderPartial('_search',array('model'=>$model,'search'=>$search,'selected'=>$selected)); ?>
    </div>
</div>
<?php
$class1 = ($step==1) ? "btn btn-primary margin-right15" : "btn  green margin-right15";
$class2 = ($step==2) ? "btn btn-primary margin-right15" : "btn  green margin-right15";
$class3 = ($step==3) ? "btn btn-primary margin-right15" : "btn  green margin-right15";
$class4 = ($step==4) ? "btn btn-primary margin-right15" : "btn  green margin-right15";
?>
<div class="row">
    <div class="col-md-12">
       <div class="form-group">
                <?php echo CHtml::link(Yii::t('translation', 'Upcoming Reservation'), '/admin/' . get_class($model) . '', array("class" => $class1)); ?>
                <?php echo CHtml::link(Yii::t('translation', 'Reservation By Date') , '/admin/' . get_class($model) . '/reservationbydate', array("class" => $class2)); ?>
                <?php echo CHtml::link(Yii::t('translation', 'Pending Requests') , '/admin/' . get_class($model) . '/pendingreservation', array("class" => $class3)); ?>
                <?php echo CHtml::link(Yii::t('translation', 'Refused Requests') , '/admin/' . get_class($model) . '/refusedreservation', array("class" => $class4)); ?>
           <b style="font-size: 14px"> (<?php echo $reservationCount; ?> Reservations)</b>
        </div>
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
    <form id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/reservation/reservationbydate" />
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
    <select class="customeSelect howDidYou form-control pull-left input-medium select2me margin-right15" id="ui-id-5" name="res_filter">
                <option value="1" <?php if($statusId == 1){ echo "selected"; } ?> >Confirm</option>
                <option value="3" <?php if($statusId == 3){ echo "selected"; } ?> >Cancel By User</option>
                <option value="4" <?php if($statusId == 4){ echo "selected"; } ?> >Cancel By Admin</option>
                <option value="6" <?php if($statusId == 6){ echo "selected"; } ?> >Cancel By Hotel</option>
                <option value="5" <?php if($statusId == 5){ echo "selected"; } ?> >Enter the no-show</option>
                <option value="7" <?php if($statusId == 7){ echo "selected"; } ?> >Refuse</option>
                <option value="8" <?php if($statusId == 8){ echo "selected"; } ?> >All</option>
            </select>
    <div class="nopadding col-md-1">
        <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    </div>
    </form>
    <form class="form-horizontal" id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/reservation/reservationbydate">
    <div class="row form-group">
        <div class="col-md-3">        
            <input type="text" class="form-control dvalid" name="res_search_filter" id="res_search_filter" size="60" maxlength="75" value="" />
            <span class="error" style="color:red"  id="first_name_error"></span>        
        </div>
        <div class="nopadding col-md-1">
            <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
        </div>
    </div>
    </form>
</div>
<!--Reservation by date search start-->
<form class="form-horizontal" id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/reservation">
<div class="row form-group" <?php echo $showSearchFlag; ?>>
    <div class="col-md-3">        
        <input type="text" class="form-control dvalid" name="res_search_filter" id="res_search_filter" size="60" maxlength="75" value="" />
        <span class="error" style="color:red"  id="first_name_error"></span>        
    </div>
    <div class="nopadding col-md-1">
        <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    </div>
</div>
</form>
<!--Reservation by date search end-->
<!--pending search start-->
<form class="form-horizontal" id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/reservation/pendingreservation">
<div class="row form-group" <?php echo $pendingSearchFlag; ?>>
    <div class="col-md-3">        
        <input type="text" class="form-control dvalid" name="res_search_filter" id="res_search_filter" size="60" maxlength="75" value="" />
        <span class="error" style="color:red"  id="first_name_error"></span>        
    </div>
    <div class="nopadding col-md-1">
        <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    </div>
</div>
</form>
<!--pending search endi-->
<!--refused search start-->
<form class="form-horizontal" id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/reservation/refusedreservation">
<div class="row form-group" <?php echo $refusedSearchFlag; ?>>
    <div class="col-md-3">        
        <input type="text" class="form-control dvalid" name="res_search_filter" id="res_search_filter" size="60" maxlength="75" value="" />
        <span class="error" style="color:red"  id="first_name_error"></span>        
    </div>
    <div class="nopadding col-md-1">
        <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    </div>
</div>
</form>
<!--refused search endi-->

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
                    'name' => 'customer_id',
                    'header' => '<span style="white-space: nowrap;">C Name &nbsp; &nbsp; &nbsp;</span>',
                    'value' => 'isset($data->customer->first_name)?$data->customer->first_name:"" ',
                ),
                array(
                    'name' => 'nb_reservation',
                    'header' => '<span style="white-space: nowrap;">Res No &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->nb_reservation',
                ),
                array(
                    'name' => 'id',
                    'header' => '<span style="white-space: nowrap;">Phone &nbsp; &nbsp; &nbsp;</span>',
                    //'value' => 'isset($data->customer->telephone)?$data->customer->telephone:""',                    
                    'value' => array($this, 'getformattedPhoneNumber'),
                ),
                array(
                    'name' => 'id',
                    'header' => '<span style="white-space: nowrap;">Htl Name &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->room->hotel->name',
                ),
                array(
                    'name' => 'room_id',
                    'header' => '<span style="white-space: nowrap;">Room &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->room->name',
                ),

                array(
                    'name' => 'res_date',
                    'header' => '<span style="white-space: nowrap;">Arr Date &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getReservationDateAndTime'),
                ),
                array(
                    'name' => 'room_price',
                    'header' => '<span style="white-space: nowrap;">RP &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->room_price',
                ),
                array(
                    'name' => 'room_price',
                    'header' => '<span style="white-space: nowrap;">OP &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getReservationOptionPriceCount'),
                ),
                array(
                    'name' => 'room_price',
                    'header' => '<span style="white-space: nowrap;">TP &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getTotalReservationPrice'),
                ),
                array(
                    'name' => 'reservation_status',
                    'header' => '<span style="white-space: nowrap;">Status &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getReservationStatus'),
                ),
            	array(
            		'name' => 'added_by',
            		'header' => '<span style="white-space: nowrap;">Res By</span>',
            		'value' => '$data->addedBy ? $data->addedBy->getFullName() : "-"',
            	),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{Edit}{Delete}',
                    'htmlOptions' => array('width' => '150px'),
                    'buttons' => array(
                        'Edit' => array(
                            'label' => 'Edit',
                            'options' => array('class' => 'btn default btn-xs purple fa fa-edit'),
                            'url' => 'Yii::app()->createUrl("/admin/reservation/edit", '
                            . 'array("roomId"=>$data->room_id,"date"=>$data->res_date'
                            . ',"hotelId"=>$data->room->hotel->id,"rid"=>$data->id,"portal"=>$data->portal->id,"orf"=>$data->reservation_status))',
                        ),
                        'Delete' => array(
                            'label' => 'View',
                            'options' => array('class' => 'fa btn default btn-xs black delete'),
                            'url' => 'Yii::app()->createUrl("/admin/reservation/view", array("rid"=>$data->nb_reservation,"portal"=>$data->portal->id))',
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
    