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
$style = '';
if(empty($showDateFlag)){
    $style = 'style="display:none;"';
}
?>
<div class="expiration margin-topDefault" <?php echo $style; ?>>
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
    <select class="customeSelect howDidYou form-control input-medium select2me" id="ui-id-5" name="res_filter">
                <option value="1" <?php if($statusId == 1){ echo "selected"; } ?> >Confirm</option>
                <option value="3" <?php if($statusId == 3){ echo "selected"; } ?> >Cancel By User</option>
                <option value="4" <?php if($statusId == 4){ echo "selected"; } ?> >Cancel By Admin</option>
                <option value="6" <?php if($statusId == 6){ echo "selected"; } ?> >Cancel By Hotel</option>
                <option value="5" <?php if($statusId == 5){ echo "selected"; } ?> >Enter the no-show</option>
                <option value="7" <?php if($statusId == 7){ echo "selected"; } ?> >Refuse</option>
            </select>
    <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    </form>
</div>
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
                
                array(
                    'name' => 'customer_id',
                    'header' => '<span style="white-space: nowrap;">Customer</span>',
                    'value' => 'isset($data->customer->first_name)?$data->customer->first_name :""',
                ),
                array(
                    'name' => 'id',
                    'header' => '<span style="white-space: nowrap;">Hotel Name &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->room->hotel->name',
                ),
                array(
                    'name' => 'room_id',
                    'header' => '<span style="white-space: nowrap;">Room &nbsp; &nbsp; &nbsp;</span>',
                    'value' => '$data->room->name',
                ),

                array(
                    'name' => 'res_date',
                    'header' => '<span style="white-space: nowrap;">Check In &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getReservationDateAndTime'),
                ),
                array(
                    'name' => 'room_price',
                    'header' => '<span style="white-space: nowrap;">Rates &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'getTotalReservationPrice'),
                ),
                
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{View}',
                    'htmlOptions' => array('width' => '150px'),
                    'buttons' => array(
                        'View' => array(
                            'label' => 'View',
                            'options' => array('class' => 'fa btn default btn-xs black delete'),
                            'url' => 'Yii::app()->createUrl("/admin/reservation/view", array("rid"=>$data->nb_reservation,"portal"=>$data->portal->id,"hotel"=>$data->nb_reservation))',
                        ),
                        
                    ),
                ),
                 array(
                    'name' => 'room_price',
                    'header' => '<span style="white-space: nowrap;">Action &nbsp; &nbsp; &nbsp;</span>',
                    'value' => array($this, 'reservationStatusOption'),
                ),
            ),
        ));
        ?>

    </div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
    