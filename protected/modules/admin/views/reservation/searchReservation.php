<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/reservation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now"); ?>"></script> 
<?php
/* @var $this ReservationController */
/* @var $model Reservation */

$this->breadcrumbs = array('Reservations' => array('index'), 'View',);

$this->menu = array(
    array('label' => 'List Reservation', 'url' => array('index')),
    array('label' => 'Manage Reservation', 'url' => array('admin')),
);
?>
<div class="row">
    <div class="col-md-12">
        <h4>View Reservation</h4>
        <hr style="margin:10px 0">
    </div>
</div>

<div class="form-body adminCR">
    <div class="row form-group">
        <label class="text-right col-md-2">Reservation Number:</label>
        <form id="reservation_search" name="reservation_search" method="get" action="/admin/reservation/view">
            <div class="col-md-6">
                <input type="text" name="rid" class="form-control" id="search_reservation_text" />

            </div>
            <div class="col-md-1"><input  type="submit" name="search_reservation" class="btn btn-primary" id="search_reservation_submit" value="OK"/></div>
        </form>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2"></label>
        <div class="col-md-6">
            <p class="color-red"><?php echo $errorMessage; ?></p>

        </div>

    </div>


    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            // initiate layout and plugins
            ComponentsDropdowns.init();
        });
    </script>
