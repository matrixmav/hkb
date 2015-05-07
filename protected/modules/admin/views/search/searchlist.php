<?php
/* @var $this SearchController */

$this->breadcrumbs = array(
    'Reservation' => array('/admin/search/create'),
    'Book'
);
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-'.$key.'">'.$message."</div>\n";
}
Yii::app()->clientScript->registerScript(
        'myHideEffect', '$(".alert-danger").animate({opacity: 1.0}, 3000).fadeOut("slow");', CClientScript::POS_READY
);
?>
<div class="row" style="margin-top: -18px;">
    <div class="col-md-12">
        <h4>Hotel List</h4>
        <hr style="margin:10px 0">
    </div>
</div>
<link rel="stylesheet" href="/css/jquery.fancybox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/metronic/custom/custom.css" type="text/css" media="screen" />
<div class="portlet-body form">
    <div class="form-body">
        <div class="row form-group">
            <span  style="width:auto; background:#f2f2f2; border-radius:8px;padding: 8px 10px 10px 10px;">
                <span>
                    <?php
                    $areatitle = ($areaname!="")? '&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;<span><b>'.$areaname.'</b></span>&nbsp;' : '';
                    ?>
                    <b>Search Criteria</b> :: <b><?php
                    $port = Portal::model()->findByPk($portal);
                    echo $port->name
                            ?></b>
                </span>&nbsp; <i class="fa fa-angle-double-right"></i> &nbsp;
                <span><b><?php echo $city_name ?></b></span><?php echo $areatitle;?>&nbsp; <i class="fa fa-angle-double-right"></i> &nbsp;
                <span><b> <?php echo $date ?></b></span> 
                <span style="margin-left:25px;"><a class="btn btn-danger btn-xs" href="/admin/search/create">Reset</a></span> 
            </span>
        </div>
        
        
        <!-- 	<div class="row">
                        <div class="col-md-12">
                                <hr style="margin:10px 0">
                                <h4>DISPONIBILITES POUR LE <?php //echo $date  ?></h4>
                                <hr style="margin:10px 0">
                        </div>
                </div> -->


        <div class="row" style="background-color:#ffcccc;">
            <div class="col-md-12">
                <div class="row" >
                    <div class="col-md-12">					
                        <b>Filters</b>						
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">	
                        <?php
                        $areaId = (isset($usersearch['area']))? $usersearch['area'] : 0;
                        ?>
                        <form class="form-inline" id='form_search_hotel' name="form_search_hotel" method='post' action="/admin/search/create">
                            <input type="hidden" name="selectedCityId" value="<?php echo $selectedCityId; ?>">
                            <input type="hidden" name="Search[area]" value="<?php echo $areaId; ?>">
                            <input type="hidden" name="Search[date]" value="<?php echo $date ?>">
                            <input type="hidden" name="Search[portal]" value="<?php echo $portal ?>">
                            <!--<input type="hidden" name="searchlist" value="1">-->
                            <div class="row form-group">
                                <div class="form-group col-md-12">
                                    <label class="margin-topDefault margin-right15">Price Min</label>								
                                    <input type="text" class='form-control margin-right15' style="width:100px;" name="Search[min]" value="<?php echo isset($min) ? $min : "" ?>">								

                                    <label class="margin-right15">Price Max</label>								
                                    <input type="text" class='form-control margin-right15' style="width:100px;" name="Search[max]" value="<?php echo isset($max) ? $max : "" ?>">								
                                    <?php //$equipmentListObject = Equipment::model()->findAll();  ?>
                                    <ul name="Search[select_options]" id="select_options" class="multiselect select_options"> 
                                        <li>
                                            <a href="javascript:void(0)" class="chk_ratingTrigger">Amenities</a>
                                            <ul class="childPop" style="display:none;">
                                                <li>
                                                    <div class="form-group">															
                                                        <div class="checkbox-list">
                                                            <?php
                                                            $selected = "";
                                                            $sform = new SearchForm();
                                                            $equipmentListObject = $sform->getEquipmentOptions();
                                                            foreach ($equipmentListObject as $equipmentObject):
                                                                if (isset($usersearch['option']) && !empty($usersearch['option'])) {
                                                                    $selected = (in_array($equipmentObject->id, $usersearch['option'])) ? " checked" : "";
                                                                }
                                                                ?>
                                                                <label><input type="checkbox" <?php echo $selected; ?> name="Search[option][]" value="<?php echo $equipmentObject->id; ?>"><?php echo $equipmentObject->name; ?></label>    
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <select class="form-control select2me margin-right15" name="Search[chk_time]" id="chk_time"> 
                                        <option>ARRIVAL TIME</option>
                                        <?php
                                        $sform = new SearchForm();
                                        $arrivalTimeArray = $sform->getArrivalTimeArray();
                                        $selected = "";
                                        for ($i = $arrivalTimeArray['start']; $i <= $arrivalTimeArray['end']; $i = $i + $arrivalTimeArray['duration'] * 60) {
                                            $selected = "";
                                            if (($chkTime != '') && $chkTime == date('G:i', $i)) {
                                                $selected = "selected";
                                            }

                                            echo "<option $selected value=" . date('G:i', $i) . ">" . date('g A', $i) . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <!--<label class="margin-right15">Night</label>	
                                    <input type="checkbox" name="moon" id="moon" value="moon" <?php
                                    if (!empty($nightFlag)) {
                                        echo "checked";
                                    }
                                    ?>/>-->
                                    <button type="submit" class="btn green" name="submitac">Search</button>	
                                    <!--<a class="btn default" href="/admin/reservation">Cancel</a>	-->

                                </div>
                            </div>


                        </form>					
                    </div>
                </div> 

            </div>
        </div>
    </div>
</div>
<style type="text/css" media="screen">
    .reservationResults {width: 75%;}
    .reservationResults .stars{font-family:verdana;font-size:13px; margin-right:2px;}
    .reservationResults tr.coloredTd td{padding:7px 5px; box-sizing: border-box;}
    .reservationResults tr.coloredTd td:nth-child(1){width:50%}
    .reservationResults tr.coloredTd td:nth-child(2){width:20%;}
    .reservationResults tr.coloredTd td:nth-child(3){width:10%;}
    .reservationResults tr.coloredTd td:nth-child(4){width:20%;}
    .reservationResults td a.mapIcon{color:#000;font-size:11x;}
    .reservationResults tr{border-top:1px solid #ccc;display:table;border-bottom:1px solid #ccc;width: 100%;border-collapse: collapse;}
    .reservationResults tr:nth-child(1), .reservationResults tr:nth-child(2){border:0;}
    .reservationResults tr:nth-child(2) td{padding-bottom: 10px;}
    .reservationResults td b.subnote{display: inline-block; color:#f00; font-weight: bold; font-size: 13px;}
    .reservationResults td b.subnoteOpt{display: inline-block;margin-left:30px;}
    .reservationResults tr.notAvailable:before {display: table;width: 100%;background: transparent;height: 54px;content: '';position: absolute;}
</style>
<?php
$searchstring = "";
foreach ($usersearch as $ky=>$val):
    if($ky=='option')
        $searchstring .=$ky."=".implode("-", $val)."&";
    else
        $searchstring .=$ky."=".$val."&";
endforeach;
$noresult = TRUE;
if(isset($model)) {
    foreach ($model as $k => $m) {
        
        $noresult = FALSE;
        $star = "";
        for ($i = 0; $i < $m->star_rating; $i++)
            $star .= "*";
        
        $cityName = ", " . $m->city()->name;
        echo "<div class='row' style='border-top: 1px dashed #000;margin:10px 0;padding:10px 0;'>
                <div class='col-md-12' ><table class='reservationResults'<tr><td colspan='2'><b><span class='stars'>$star</span><a  target='_blank' href='/hotel/detail?slug=" . $m->slug . "'>" . $m->name . "</a></b></td><td colspan='2'><a data-long='$m->longitude' data-lat='$m->latitude' class='mapIcon inlineFancybox' href='#searchFormMap'><i class='fa fa-map-marker'></i> map</a>&nbsp;<a href='#' class='link' data-placement='top' data-original-title='comment'><i class='fa fa-info-circle'></i></a></td></tr>";
        echo "<tr><td colspan='4'>$m->address $cityName &nbsp; $m->telephone</td></tr>";
        
        $criteria = new CDbCriteria();
        $criteria->condition = "t.hotel_id=" . $m->id . " and roomAvailabilities.availability_date='".$date."' and roomTariffs.tariff_date='".$date."'";
        
        $arrtime1="";
        if(isset($usersearch['chk_time']) && !empty($usersearch['chk_time'])) {
            if($usersearch['chk_time']!="ARRIVAL TIME")
            {
                $isToday = ($date == date('Y-m-d'))? 1 : 0;
                
                // The room should be avaialable before or on the arrival time
                $arrtime1 = $usersearch['chk_time'];
                $reqFrom = date("H:i:s",strtotime($usersearch['chk_time']));
                $criteria->addCondition("t.available_from <='".$reqFrom."'");
                $criteria->addCondition("t.available_till >'".$reqFrom."'");

                if($isToday)
                    $criteria->addCondition("TIMEDIFF(t.available_till, DATE_FORMAT(NOW(),'%H:%i:%s'))>2");
            }
        }
        

        //Max and Min should be in between the price range selected
        if (isset($min) && $min != "" && isset($max) && $max != "") {
            $criteria->addCondition("roomTariffs.price BETWEEN $min AND $max");
        }
        if ((isset($min) && $min != "") && !(isset($max) && $max != "")) {
            $criteria->addCondition("roomTariffs.price >= $min");
        }
        if ((isset($max) && $max != "") && !(isset($min) && $min != "")) {
            $criteria->addCondition("roomTariffs.price <= $max");
        }
        //$criteria->with = array('roomTariffs','roomAvailabilities','roomOptions.equipment','roomInfos');
        $criteria->with = array('roomTariffs','roomAvailabilities');
        
        $rooms = Room::model()->findAll($criteria);
        
        $orf = 0;
        $newDate = date("Y-m-d", strtotime($date));
        foreach ($rooms as $room) {
            if (!empty($nightFlag) && $nightFlag == 'moon') {
                if ($nightFlag != $room->category) {
                    continue;
                }
            }
            $roomAvailablityObject = $room['roomAvailabilities'][0];
            if(empty($roomAvailablityObject)){
                continue;
            }
            
            
            $condition ='';
            $infoCondition = 'room_id='.$room->id.' and language_id='.YII::app()->params['default']['language_id'];
            $roomInfoObject = $room->roomInfos(array('condition' =>  $infoCondition, 'limit' => 1));
            
            if($roomInfoObject!=NULL){
                $condition ="<i>".$roomInfoObject[0]->room_condition."</i>";
            }
            
            $optionURL = '';
            if (isset($room->roomOptions)) {
                $option = "";
                $opav = FALSE;
                foreach ($room->roomOptions as $roomOptions) {
                	$currencySymbol = $roomOptions->currency_id ? $roomOptions->currency->symbol : "";
                    $option .= "<p>" . $roomOptions->equipment->name . " (".$roomOptions->price." ". $currencySymbol .")</p>";
                    $opav = TRUE;                    
                }
                if($opav)
                    $optionURL = "<a href='javascript:void(0)' data-html='true' data-placement='right' data-toggle='popover' data-content='$option'>Options</a>";
            }
            
                    
            $availabilityTime = BaseClass::convertDateFormate($room['available_from']) . " to " . BaseClass::convertDateFormate($room['available_till']); 
            
            
            $rmstat = BaseClass::getRoomReservation($room->id, $room->hotel_id, $arrtime1, $date,1);
            $roomclass = $rmstat['admin_roomclass'];
            $roombutton = $rmstat['admin_roombutton'];
            $rowColor = $rmstat['admin_rowColor'];
            $rmstatus = $rmstat['room_status'];
            $room_no_stat = $rmstat['room_no_stat'];
            $orf = $rmstat['orf'];
            $buttontype = $rmstat['buttontype'];
                    
            $roomCategory = isset($room->category) ? $room->category : "";
            $roomIcon = "";
            if ($roomCategory == "sun") {
                $roomIcon = '/images/i1.png';
            } elseif ($roomCategory == "halfsun") {
                $roomIcon = '/images/i2.png';
            } elseif ($roomCategory == "moon") {
                $roomIcon = '/images/i3.png';
            }
            $roomPr = RoomTariff::model()->find("room_id=".$room->id." and tariff_date = '".$date."'");
            
            
            $form ="";
            $form .="<form id='form_book_".$room->id."' method='post' action='/admin/reservation/create'>";
            foreach ($usersearch as $ky=>$val):
                if($ky=='option')
                    $value = implode("-", $val);
                else
                    $value = $val;                
                $form .="<input type='hidden' name='".$ky."' value='".$value."'>";
            endforeach;
            $form .="<input type='hidden' name='destination' value='".$selectedCityId."'>";
            $form .="<input type='hidden' name='hotelId' value='".$m->id."'>";
            $form .="<input type='hidden' name='roomId' value='".$room->id."'>";
            $form .="<input type='hidden' name='orf' value='".$orf."'>";
            
            if($buttontype)
                $button = "<input type='submit' class='btn $roomclass' id='roomSubmit_".$room->id."' value='".$roombutton."'>";
            else
                $button = "<a href='javascript:void(0)' title='Book' class='btn $roomclass'>".$roombutton."</a>";
            
            echo $form;      
            echo "<tr class='coloredTd $roomclass $rowColor'>"
                    . "<td><img src='$roomIcon'>&nbsp;$room->name<br/>"
                    . "<b class='subnote' title='$condition'>"
                    . "<a href='javascript:void(0)' data-html='true' data-placement='right' data-toggle='popover' data-content='$condition'>Condition</a>"
                    . "</b><b class='subnote subnoteOpt' title=''>".$optionURL
                    . "</b><span style='padding: 0 2px 1px;font-size: 11px;margin-left: 10px;border: 1px solid #0D638F;color: #003854;background: #DFF2FF;'> $room_no_stat Status: $rmstatus </span></td>"
                    . "<td>$availabilityTime</td><td>$roomPr->price</td><td width='15%' class='button-column'>".$button."</td></tr>";
            echo "</form>";
        }
        echo "</table></div></div>";
    }
}
if($noresult)
{
    echo "<div class='row' style='border-top: 1px dashed #000;margin:10px 0;padding:10px 0;'>";
    echo "<i><b>No result found. Please try with different criteria.</b></i>";
    echo "</div>";
}
?>
<style>
    #searchFormMap {
        width: 500px;
        height: 400px;
    }
    .subnote a{color:#f00;}
    .subnote a:hover{text-decoration:none;}
    .subnote .popover-content{color:#000 !important;font-weight:normal !important;}
</style>

<div style="display: none;" id="searchFormMap"></div>
<script type="text/javascript" src="/js/jquery.fancybox.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
<script>

    $(document).ready(function () {    
        /* This is basic - uses default settings */
        $(".inlineFancybox").click(function () {
            var latitude = $(this).data("lat");
            var longitude = $(this).data("long");            
            initialize(latitude, longitude); 
            
        });
    });
    function initialize(latitude, longitude) {
        var mapOptions = {
            zoom: 14,
            center: new google.maps.LatLng(latitude, longitude)
        }
        var map = new google.maps.Map(document.getElementById('searchFormMap'),
                mapOptions);
        //var image = 'http://dayuse.dev/upload/hotel/1/64_39/4753558.jpg';
        var myLatLng = new google.maps.LatLng(latitude, longitude);
        var beachMarker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });
        $(".inlineFancybox").fancybox({
            'hideOnContentClick': true,
            'afterShow':function() {
                initialize(latitude, longitude); 
                google.maps.event.trigger(map, 'resize'); 
                map.setZoom(14);
                
                } 
        });
    }
</script>
<script>
    $('[data-toggle="popover"]').popover({
        trigger: 'click'

    });

    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
//the 'is' for buttons that trigger popups
//the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
    $('.link').tooltip();

    $('.multiselect>li>a').click(function (e) {
        $(this).next(".childPop").slideToggle(100);
        ;
    });

    $(document).mouseup(function (e)
    {
        var container = $(".multiselect");

        if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.find(".childPop").hide();
        }
    });
</script>