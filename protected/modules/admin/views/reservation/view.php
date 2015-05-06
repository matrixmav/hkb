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
<style>
    .adminCR{}
    .adminCR .hightlighedNote{font-weight: bold;color:#BB4E00;line-height: 30px;margin-bottom:10px;display: block;}
    .adminCR .roomServices{margin:0; padding:0; list-style-type:none;}
    .adminCR .roomServices .checker{display: inline-block;}
    .adminCR .roomServices .checker+p{display: inline-block;width: 95%;}
    .adminCR .roomServices .checker+p .value{float: right;} 
    .adminCR .roomServices li.total{display: block; margin-top:10px;color:#f00; border-top:1px solid #ccc; text-align: right;padding-top:10px;font-weight:bold;}
    .adminCR .roomServices li.total span.text{margin-right:20px;color:#000;}
    .adminCR .phoneNo .select2-container, .adminCR .phoneNo #telephone{display: inline-block;float:left;}
    .adminCR .phoneNo #telephone{margin-left:11px;width: 72%;}
</style>
<?php 
$resDate = $reservationObject->res_date;
$today = date('Y-m-d');
?>
<div class="form-body adminCR">
    <div class="row form-group">
        <label class="text-right col-md-2">Reservation Number:</label>
        <form id="reservation_search" name="reservation_search" method="get" action="/admin/reservation/view">
        <div class="col-md-6">
            <input type="text" name="rid" class="form-control" id="search_reservation_text" />
        </div>
            <div class="col-md-1"><input  type="submit" name="search_reservation" class="btn btn-primary" id="search_reservation_submit" value="OK"/></div>
            <?php 
            if($resDate >= $today) {?>
                <div class="col-md-1"><a  href="/admin/reservation/edit?roomId=<?php echo $roomObject->id; ?>&date=<?php echo $reservationObject->res_date;?>&hotelId=<?php echo $hotelObject->id;?>&rid=<?php echo $reservationObject->id;?>&portal=<?php echo $portalObject->id; ?>&orf=<?php echo $reservationObject->reservation_status;?>" name="search_reservation_edit" class="btn btn-primary" id="search_reservation_edit" />EDIT</a></div>
            <?php } ?>
        </form>
    </div>
    <form id="admin_edit_reservation" name="admin_edit_reservation" method="post" action="/admin/reservation/reservationstatus">
        <input type="hidden" name="reservation_id" class="form-control" id="reservation_id" value="<?php echo $reservationObject->id; ?>" />
        <input type="hidden" name="customer_id" class="form-control" id="customer_id" value="<?php echo $customerObject->id; ?>" />
    
        
    <div class="row form-group">
        <label class="text-right col-md-2">Reservation :</label>
        <div class="col-md-8"><strong><?php echo $reservationObject->nb_reservation . "</strong> ( Date : " . $reservationObject->res_date . " ) "; ?>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Portal :</label>
        <div class="col-md-8"><?php echo $portalObject->name;?></div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Status :</label>
        <div class="col-md-8"><b><?php echo CommonHelper::getReservationStatus($reservationObject->reservation_status); ?></b>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Client :</label>
        <div class="col-md-3">
            <!--<input type="text" name="customer_first_name" class="form-control" id="customer_first_name" value="<?php echo $customerObject->first_name; ?>"/>-->
            <?php echo $customerObject->first_name; ?> <?php echo $customerObject->last_name; ?>
            <span class="error" style="color:red"  id="first_name_error"></span>
        </div>
<!--        <div class="col-md-3">            
            <input type="text" name="customer_last_name" class="form-control" id="customer_last_name" value="<?php echo $customerObject->last_name; ?>"/>
            
            <span class="error" style="color:red"  id="last_name_error"></span>
        </div>-->
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Email :</label>
        <div class="col-md-6">
            <!--<input type="text" name="customer_email_address" class="form-control" id="customer_email_address" value=""/>-->
            <?php echo $customerObject->email_address; ?>
            <span class="error" style="color:red"  id="email_address_error"></span>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Telephone :</label>
        <div class="col-md-6">
            <!--<input type="text" name="customer_telephone" class="form-control" id="customer_telephone" value="<?php echo $customerObject->telephone; ?>"7777777777777777777/>-->
            <?php echo $customerObject->telephone; ?>
            <span class="error" style="color:red"  id="telephone_error"></span>
        </div>
    </div>
    <!--hotel details started-->
    <hr/>
    <div class="row form-group">
        <label class="text-right col-md-2">Hotel :</label>
        <div class="col-md-6"><?php echo $hotelObject->name . ", " . $hotelObject->address . ", " . $hotelObject->telephone; ?>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Date :</label>
        <div class="col-md-6"><?php echo $reservationObject->res_date; ?>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Time :</label>
        <div class="col-md-6">
            <?php
                $timefrom = new DateTime($reservationObject->res_from);
            ?>
            <?php echo $timefrom->format('h:i A'); ?>
            <span class="error" style="color:red"  id="arrival_time_error"></span>
        </div>
    </div>
    
    <div class="row form-group">
        <label class="text-right col-md-2">Arrival Time :</label>
        <div class="col-md-6">
            <?php if(!empty($reservationObject->arrival_time)) {?>
            <?php echo $reservationObject->arrival_time; ?>
            <span class="error" style="color:red"  id="arrival_time_error"></span>
            <?php } else { ?>
                <span class="error" style="color:red">No arrival time set</span>
            <?php } ?>
        </div>
    </div>
    
    <div class="row form-group">
        <label class="text-right col-md-2">Room Details :</label>
        <div class="col-md-6">
            <?php echo $roomObject->name; ?> <span class="pull-right">$ <?php echo $roomObject->default_price; ?>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Services :</label>
        <div class="col-md-6">
            <ul class="nopadding">
            <?php 
            $serviceTotal = 0;
            if(count($reservationOptionObject) > 0){
                foreach($reservationOptionObject as $reservationOption){ ?>
                    <p class="noMargin"> <?php echo $reservationOption->equipment()->name; ?>
                    <span class="value pull-right">$ <?php echo $reservationOption->equipment_price; ?></span></p>
                    <?php $serviceTotal+=$reservationOption->equipment_price;?>
                <?php } } ?>
            </ul>
        </div>
    </div>
    <div class="row form-group">
        <label class="text-right col-md-2">Comment :</label>
        <div class="col-md-6">
            <!--<textarea class="form-control" rows="3"></textarea>-->
            <?php echo $reservationObject->comment; ?>
            <span class="error" style="color:red"  id="comment_error"></span>
        </div>
    </div>
    <hr/>
    <div class="row form-group">
        <label class="text-right col-md-2">Booking amount :</label>
        <div class="col-md-6">
            <span class="pull-right color-red"><strong>$ <?php echo ($reservationObject->room_price + $serviceTotal) .".00"; ?></strong></span>
        </div>
    </div>
    <?php 
    
    if(!isset($_GET['hotel'])){
        if($resDate >= $today) {?>
        <div class="row form-group">
            <label class="text-right col-md-2">Admin Actions :</label>
            <div class="col-md-8">
                <select class="customeSelect howDidYou form-control input-medium select2me" id="ui-id-5"name="admin_action">
                    <?php if($reservationObject->reservation_status == 1){ ?>
                    <option value="1">Resend SMS or email reservation confirmation</option>
                    <option value="2"> Pass resa as no show</option>
                    <option value="3">Cancel the reservation (pass reservation flag to cancelled)</option>
                    <option value="7">Resend email to hotel for reservation</option>
                    <option value="4">Add to blacklist</option>
                    <?php } if($reservationObject->reservation_status != 1){ ?>
                    <option value="5">Confirm</option>
                    <?php } if($reservationObject->reservation_status != 7){ ?>
                    <option value="6">Refuse</option>
                    <?php } ?>

                    <!--option>Send info resa the customer by SMS to +33669775087</option-->
                    <!--option>Send email Hotelier</option-->
                    <!--option>Send CB information</option-->


                </select>
            </div>
        </div>
        <input type="hidden" name="portal" class="form-control" id="portal" value="<?php echo ($portalObject) ? $portalObject->id : "1" ?>" />            

        <div class="row form-group">
            <label class="text-right col-md-2"></label>
            <div class="col-md-8">
                <input class="btn green" type="submit" name="admin_reservation_modify" id="admin_reservation_modify" value="Submit">
            </div>
        </div>
        <?php } } ?>
    </form>

</div>


<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        // initiate layout and plugins
        ComponentsDropdowns.init();
    });
</script>
