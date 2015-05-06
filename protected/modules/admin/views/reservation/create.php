<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/reservation.js?ver=<?php echo strtotime("now");?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/validation.js?ver=<?php echo strtotime("now");?>"></script> 
<?php
/* @var $this ReservationController */
/* @var $model Reservation */
$viewActionName = ($actionMode)? 'Edit' : 'Create';
$action = ($actionMode)? 'edit' : 'create';'';
$this->breadcrumbs = array(
    'Reservations' => array('index'),
    $viewActionName,
);

$this->menu = array(
    array('label' => 'List Reservation', 'url' => array('index')),
    array('label' => 'Manage Reservation', 'url' => array('admin')),
);
?>
<div class="form-body adminCR">
    <div class="row form-group">
        <form class="form-inline" id='form_search_hotel' name="form_search_hotel" method='post' action="/admin/search/create">
        <input type="hidden" name="selectedCityId" value="<?php echo (isset($usersearch['destination']))? $usersearch['destination'] : ""; ?>">
        <input type="hidden" name="Search[area]" value="<?php echo (isset($usersearch['area']))? $usersearch['area'] : ""; ?>">
        <input type="hidden" name="Search[date]" value="<?php echo (isset($usersearch['date']))? $usersearch['date'] : ""; ?>">
        <input type="hidden" name="Search[portal]" value="<?php echo (isset($usersearch['portal']))? $usersearch['portal'] : ""; ?>">
        <input type="hidden" name="Search[min]" value="<?php echo (isset($usersearch['min']))? $usersearch['min'] : ""; ?>">
        <input type="hidden" name="Search[max]" value="<?php echo (isset($usersearch['max']))? $usersearch['max'] : ""; ?>">
        <input type="hidden" name="Search[chk_time]" value="<?php echo (isset($usersearch['chk_time']))? $usersearch['chk_time'] : ""; ?>">
        <?php
        if(isset($usersearch['option']))
        {
            $uopts = array();
            $uopts = explode("-",$usersearch['option']);
            $op=0;
            foreach($uopts as $opval):
            ?>
            <input type="hidden" name="Search[option][<?php echo $op;?>]" value="<?php echo $opval;?>">
            <?php
            $op++;
            endforeach;

        }
        ?>            
        <span  style="width:auto; background:#f2f2f2; border-radius:8px;padding: 8px 10px 10px 10px;">
            <span>
                <b>Reservation Date</b> :: </span><span><b> <?php echo $roomBookingDate ?></b></span> 
            <span style="margin-left:25px;"><input type="submit" name="searchlist" class="btn btn-danger btn-xs" value="Go Back to Search Result"></span> 
        </span>
        </form>
    </div>

<form class="form-horizontal" role="form" id="form_admin_reservation" action="/admin/reservation/<?php echo $action; ?>" method="post">
    <input type="hidden" name="reservation_form" value="1">
    <input type="hidden" name="destination" value="<?php echo (isset($usersearch['destination']))? $usersearch['destination'] : ""; ?>">
    <input type="hidden" name="area" value="<?php echo (isset($usersearch['area']))? $usersearch['area'] : ""; ?>">
    <input type="hidden" name="date" value="<?php echo (isset($usersearch['date']))? $usersearch['date'] : ""; ?>">
    <input type="hidden" name="portal" value="<?php echo (isset($usersearch['portal']))? $usersearch['portal'] : ""; ?>">
    <input type="hidden" name="min" value="<?php echo (isset($usersearch['min']))? $usersearch['min'] : ""; ?>">
    <input type="hidden" name="max" value="<?php echo (isset($usersearch['max']))? $usersearch['max'] : ""; ?>">
    <input type="hidden" name="chk_time" value="<?php echo (isset($usersearch['chk_time']))? $usersearch['chk_time'] : ""; ?>">
    <input type="hidden" name="orf" value="<?php echo (isset($usersearch['orf']))? $usersearch['orf'] : 0; ?>">
    <?php
    if(isset($usersearch['option']))
    {
        $uopts = array();
        $uopts = explode("-",$usersearch['option']);
        $op=0;
        foreach($uopts as $opval):
        ?>
        <input type="hidden" name="option[<?php echo $op;?>]" value="<?php echo $opval;?>">
        <?php
        $op++;
        endforeach;

    }
    ?>
    <div class="row" style="margin-top:0px;">
        <div class="col-md-12">
            <label class="col-md-2"><b>Hotel :</b></label>
            <div class="col-md-8"><?php echo $hotelObject->name; ?>,&nbsp;<?php echo $hotelObject->address ?> - <?php echo $hotelObject->postal_code . " , " . $hotelObject->city()->name; ?></div>
        </div>
        <div class="col-md-12">
            <label class="col-md-2"><b>Room :</b></label>
            <div class="col-md-8"><?php echo $roomObject->name; ?> 
                <span class="pull-right">$ <span id="room_price">
                <?php 
                    $bookingDate = "'" . $roomBookingDate . "'" ;
                    $tariffCondition =  'room_id = '. $roomObject->id . ' AND tariff_date = ' . $bookingDate;
                    $roomPriceObject = $roomObject->roomTariffs(array('condition' =>  $tariffCondition, 'limit' => 1));
                    if(!empty($roomPriceObject)){
                    echo number_format($roomPriceObject[0]->price,2); } ?>
                </span></span><br/>
                From <?php echo BaseClass::convertTime($roomObject->available_from);  ?> 
                to <?php echo BaseClass::convertTime($roomObject->available_till); ?></div>
        </div>	
        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-12">
            <label class="col-md-2"><b>Conditions :</b></label>
            <div class="col-md-8"><?php 
            $infoCondition = 'room_id='.$roomObject->id.' and language_id='.YII::app()->params['default']['language_id'];
            $roomInfoObject = $roomObject->roomInfos(array('condition' =>  $infoCondition, 'limit' => 1));
            if($roomInfoObject!=NULL){
                echo "<i>".$roomInfoObject[0]->room_condition."</i>";
            } ?> </div>
        </div>	        	
    </div>
    <?php if(count($roomOptionObject) > 0) { ?>
    <div class="row"><hr></div>
    <div class="row form-group">         
        <div class="col-md-12">
            <label class="col-md-2"><b>Options</b></label>
            <div class="col-md-8"><ul class="roomServices">
                    <?php 
                    $reservationOptionArray = array();
                    $serviceAmount = 0;
                    if($reservationOptionObject){
                        foreach($reservationOptionObject as $reservationOption){
                            $reservationOptionArray[] = $reservationOption->equipment_id;
                        }
                    }
                    foreach ($roomOptionObject as $roomOption) {  ?>
                        <li>
                            <input type="checkbox" value="<?php echo $roomOption->equipment_id . "_" . $roomOption->price; ?>" onclick="getTotalServiceAmount('<?php echo $roomOption->price; ?>', '<?php echo $roomOption->id; ?>','<?php echo $roomOption->equipment()->cc_required; ?>');" id="checkbox_<?php echo $roomOption->id; ?>" name="aditional_services[]_<?php echo $roomOption->id; ?>" <?php echo (in_array($roomOption->equipment_id, $reservationOptionArray)) ? "checked" : "" ?>>
                            <p id="service_name_and_price_<?php echo $roomOption->id; ?>">
                                <?php
                                echo $roomOption->equipment()->name;
                                if ($roomOption->equipment()->cc_required) { ?>
                                    - <span class="bank"><b>bank guarantee card</b></span>
                                <?php } ?>
                                <span class="value">$ <?php echo $roomOption->price; ?></span></p>
                        </li>
                        <?php if(in_array($roomOption->equipment_id, $reservationOptionArray)){
                            $serviceAmount+=$roomOption->price;
                        } } ?>
                    <input type="hidden" id="totalServiceAmount" value="<?php echo number_format((float)$serviceAmount, 2, '.', '');  ?>" />
                    <li class="total">Total : <span>$</span><span class="value" id="value"><?php echo number_format((float)$serviceAmount, 2, '.', ''); ?></span></li>
                </ul></div>
            
        </div>        
    </div>
    <?php } ?>
    
    <?php 
        $arrivalTimeArray = BaseClass::createArrivalArray($roomObject->available_from, $roomObject->available_till);
    ?>
    <div class="row"><hr></div>
    <div class="row form-group">
        <div class="col-md-12 form-group">
        <label class="col-md-2">Arrival Time</label>
        <div class="col-md-8">
            <?php 
                $newArrTime = 0;
                $hotelArrivalTimeArray = Yii::app()->params['hotelArrivalTimeArray'];
                if(!empty($reservationObject->arrival_time)){
                   $newArrTime = strtoupper($reservationObject->arrival_time);
                }
            ?>
            <select class="form-control input-small pull-left select2me" data-placeholder="Select..." name="arrival_time" id="arrival_time">
                <option value=""><?php echo Yii::t('front_end', 'arrival_time'); ?></option>
                <?php
                foreach($arrivalTimeArray as $key=>$arrivalTime){
                ?>
                    <option value="<?php echo $key; ?>" <?php if ($key == $newArrTime) {
                    echo " selected ";
                } ?> > <?php echo $arrivalTime; ?> </option>";
                <?php } ?>
            </select>
            <span class="pull-left margin-topDefault margin-left15">Arrival time is approximate one hour</span>
            </div>
        </div>
        <input type="hidden" name="hotelId" id="hotelId" class="textBox" value="<?php echo ($hotelObject) ? $hotelObject->id : "" ?>" />
        <input type="hidden" name="roomId" id="roomId" class="textBox" value="<?php echo ($roomObject) ? $roomObject->id : "" ?>" />
        <input type="hidden" name="booking_date" id="date" class="textBox" value="<?php echo ($roomBookingDate) ? $roomBookingDate : "" ?>" />
        <input type="hidden" name="reservation_code" id="reservation_code" class="textBox" value="<?php echo ($reservationCode) ? $reservationCode : "" ?>" />
        <input type="hidden" name="onRequestFlag" id="onRequestFlag" class="textBox" value="<?php echo ($onRequestFlag) ? $onRequestFlag : "0"; ?>" />
        <input type="hidden" name="required_card_count" id="required_card_count" class="textBox" value="0" />
        <input type="hidden" name="rid" id="rid" class="textBox" value="<?php echo ($reservationObject) ? $reservationObject->id : "" ?>" />
        <input type="hidden" name="existing_user" id="existing_user" class="textBox" value="<?php echo ($customerObject) ? $customerObject->id : "0" ?>" />
        
        <!--div class="col-md-12 form-group">
            <label class="col-md-2"></label>
            <div class="col-md-8">
            <div class="radio-list">
                <label class="radio-inline">
                    <input type="radio" name="optionsRadios" id="optionsRadios4" value="option1" checked> Male </label>
                <label class="radio-inline">
                    <input type="radio" name="optionsRadios" id="optionsRadios5" value="option2"> Female </label>                
            </div>
            </div>
        </div--> 
         <div class="col-md-12 form-group">
             <label class="col-md-2">First name *</label>
             <div class="col-md-6">
                 <input type="text" class="form-control dvalid" name="first_name" id="first_name" size="60" maxlength="75" value="<?php echo ($customerObject) ? $customerObject->first_name : ""; ?>" />
                 <span class="error" style="color:red"  id="first_name_error"></span>
             </div>
        </div>
         <div class="col-md-12 form-group">
             <label class="col-md-2">Last name *</label>
             <div class="col-md-6">
                 <input type="text" class="form-control dvalid" name="last_name" id="last_name" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->last_name : ""; ?>" />
                 <span class="error" style="color:red" id="last_name_error"></span>
             </div>
        </div>
         <div class="col-md-12 form-group">
             <label class="col-md-2">Email adress *</label>
             <div class="col-md-6">
                 <input type="text" class="form-control dvalid" name="email_address" id="email_address" size="60" maxlength="75" value="<?php echo ($customerObject) ? $customerObject->email_address : ""; ?>" />
                 <span class="error" style="color:red"  id="email_address_error"></span>
             </div>
        </div>
        
        <div class="col-md-12 form-group phoneNo">
            <?php
            $countryObject = BaseClass::getCountryDropdown();
            $countryCode = 2;
            if (!empty($reservationObject->country_code)) {
                $countryCode = $reservationObject->country_code;
            }
            
            ?>
            <label class="col-md-2">Phone number *</label>
            <div class="col-md-6">
                <select class="form-control input-small select2me" name="country_id" id="country_id" data-placeholder="Select...">
                    <?php 
                    foreach($countryObject as $codeObject) { ?>
                    <option value="<?php echo $codeObject['id'];?>" <?php echo($codeObject['id']==$countryCode)?"selected":"";?> ><?php echo strtoupper($codeObject['iso_code']);?> (+ <?php echo $codeObject['country_code']; ?>)</option>
                    <?php } ?>
                </select>
                <input type="text" class="form-control dvalid col-md-3" name="telephone" id="telephone" size="60" maxlength="15" value="<?php echo ($customerObject) ? $customerObject->telephone : ""; ?>" />
                <span class="error" style="color:red"  id="telephone_error"></span>
            </div>
        </div>
     <!-- <div class="col-md-12 form-group">
            <label class="col-md-2">How did you her about us ?</label>
            <div class="col-md-6"><select class="form-control input-small select2me" data-placeholder="Select...">
                    <?php /*foreach($originObject as $origin) { ?>
                            <option value="<?php echo $origin->id; ?>"<?php if(!empty($customerObject) && $origin->id == $customerObject->origin_id ) { echo "selected"; } ?> ><?php echo $origin->name; ?></option>
                        <?php }*/ ?>
                </select></div>
        </div>-->
        <div class="col-md-12 form-group">
             <label class="col-md-2">Comment</label>
             <div class="col-md-6"><textarea class="form-control" rows="3" id="comment" name="comment"><?php echo ($reservationObject) ? $reservationObject->comment : ""; ?></textarea></div>
        </div>
        <div class="col-md-12 form-group">
            <label>Receive your reservation via :</label>                    
            <input type="checkbox" checked="checked" value="text" class="" id="reservation_confirmation_via_text" name="reservation_confirmation_via_text"> Text message
            <input type="checkbox" value="email" class="" id="reservation_confirmation_via_text" name="reservation_confirmation_via_email"> Email
            <span id="telephone_error" class="error"></span>
        </div>
        <div class="col-md-12 form-group">
             <label class="col-md-2"></label>
             <div class="col-md-6">Force CB:<input type="checkbox" onclick="openCreditCard();" class="form-control" rows="3" id="cb" name="cb"></div>
        </div>
     
     
     
     
     
<!-- credit card section -->

     <div class="client" id="credit_card_payment_div" style="display:none;">

                <div class="heading"><h4 class="inlineBlock"><?php echo Yii::t('front_end', 'credit_card_capital'); ?></h4>
                        <div class="cardsBlock">
                            <input type="radio" name="credit_card" checked="checked"><span class="visa highlighted"></span>
                            <input type="radio" name="credit_card" ><span class="master highlighted"></span>
                            <input type="radio" name="credit_card" ><span class="diners highlighted"></span>
                        </div>
                </div>
                <div class="reservationBox">
                    <p class="Subheading"><?php echo Yii::t('front_end', 'credit_card_guarantee_only'); ?></p>
                    
                    <div class="col-md-12 form-group">
                        <label class="col-md-2"></label>
                        <div class="col-md-6"> </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-2"><?php echo Yii::t('front_end', 'credit_card_number'); ?>*</label>
                        <div class="col-md-6"><input type="text" class="form-control dvalid" id="card_number" name="card_number" maxlength="16">
                            <span class="error" style="color:red" id="card_number_error"></span>
                            <span class="error" style="color:red" id="card_number_not_valid_error"></span></div>
                    </div>                  
                   
                    <div class="col-md-12 form-group">
                        <label class="col-md-2"><?php echo Yii::t('front_end', 'card_holder'); ?> *</label>
                        <div class="col-md-6">
                            <input type="text" class="textBox form-control" id="card_holder_name" name="card_holder_name" maxlength="30">
                            <span class="error" style="color:red" id="card_holder_name_error"></span>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-2"><?php echo Yii::t('front_end', 'expiration'); ?>*</label>
                        <div class="col-md-6"><?php $currentYear = date('Y'); 
                            $next10Year = date("Y",strtotime("10 year"));
                            $currentMonth = date('m');
                            ?>
                            <select class="customeSelect form-control input-medium select2me" id="card_year" name="card_year">
                                <?php for ($year=$currentYear; $year<= $next10Year; $year++) {?>
                                    <option value="<?php echo $year; ?>" <?php if($currentYear == $year){ echo "selected"; } ?> ><?php echo $year; ?></option>
                                <?php } ?>
                            </select></div>
                    </div>
                    
                    <div class="col-md-12 form-group">
                        <label class="col-md-2"><?php echo Yii::t('front_end', 'date'); ?> *</label>
                        <div class="col-md-6">
                             <select class="customeSelect form-control input-medium select2me" id="card_month" name="card_month">
                                <?php 
                                for ($month=1; $month<= 12; $month++) {  if($currentMonth == 12){"selet"; }?>
                                    <option value="<?php echo $month; ?>" <?php if($currentMonth == $month){ echo "selected"; } ?> ><?php echo $month; ?></option>
                                <?php } ?>
                            </select>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-12 form-group">
                        <label class="col-md-2"><?php echo Yii::t('front_end', 'security_code'); ?> *</label>
                        <div class="col-md-3">
                           <input type="password" class="textBox security form-control"  id="card_security_code" name="card_security_code" maxlength="4">
                        <span class="error" style="color:red" id="card_security_code_error"></span>                        
                        </div>
                    </div>
                    
                    
                    
                </div>
                <div class="clear50"></div>
                
            </div>

<!--        <div class="col-md-12 form-group">
             <label class="col-md-2"></label>
             <div class="col-md-6"><input type="checkbox" value="Forcer la cb" /> Forcer la cb</div>
        </div>-->
    <?php 
    $resDate = date('Y-m-d');
    if($reservationObject){
        $resDate = $reservationObject->res_date;
    }
    $today = date('Y-m-d');
    if($resDate >= $today) { ?>
<?php 

if($viewActionName == "Edit"){
    if(!isset($_GET['hotel'])) {
        if($resDate >= $today) {?>
        <div class="row form-group">
            <label class="text-right col-md-2">Admin Actions :</label>
            <div class="col-md-8">
                <select class="customeSelect howDidYou form-control input-medium select2me" id="ui-id-5" name="admin_action">
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
        <!--<input type="hidden" name="portal" class="form-control" id="portal" value="<?php echo (!empty($portalObject)) ? $portalObject->id : "1" ?>" />-->

        <!--<div class="row form-group">
            <label class="text-right col-md-2"></label>
            <div class="col-md-8">
                <input class="btn green" type="submit" name="admin_reservation_modify" id="admin_reservation_modify" value="Submit">
            </div>
        </div>-->
<?php } } }?>
        <div class="col-md-12 form-group">
             <label class="col-md-2"></label>
             <div class="col-md-6"><button class="btn green" value="action" name="sub" id="admin_reservation">Submit</button></div>
        </div>
    <?php } ?>
    </div>
    
</form>
</div>

    
    <!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript">
jQuery(document).ready(function() {   
   // initiate layout and plugins
  // ComponentsDropdowns.init();
 });
    </script>