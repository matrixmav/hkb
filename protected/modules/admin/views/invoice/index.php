<?php
$this->breadcrumbs = array('Invoice');
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/invoice.js?ver=<?php echo strtotime("now");?>"></script> 
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
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
?>
<div class="expiration margin-topDefault" <?php echo $style; ?>>
    <form id="reservation_filter_frm" name="reservation_filter_frm" method="get" action="/admin/invoice" />
    <select class="customeSelect form-control input-small select2me pull-left margin-right15" id="year" name="year">
        <?php 
        for($i=Yii::app()->params->daystay_start_year;$i<=date("Y");$i++){
                $selected = ($i==$selectedYear)?"selected='selected'":"";
                echo "<option $selected value='$i'>$i</option>";
        }?>
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
    <div class="form-group">
        <input type="hidden" id="selected_hotel_id" name="selected_hotel_id" value="0"/> 
        <input type="text" maxlength="150" id="search_hotel_name" name="search_res_nb" placeholder="Hotel Name" class="form-control input-medium input-inline" autocomplete="off">			
    <input type="submit" class="btn btn-primary" value="OK" name="submit" id="submit"/>
    <?php //$amount = 1; echo "<p class='inlineBlock'>Mantant a charge HT : <b>" . BaseClass::currencyConvert('USD', 'EUR', $amount)." USD |". BaseClass::currencyConvert('EUR', 'USD', $amount)." EUR |". BaseClass::currencyConvert('CAD', 'USD', $amount)."GBP |". BaseClass::currencyConvert('CAD', 'USD', $amount)." CAD </b></p>"; ?>
    </div>    
    </form>    
</div>
<?php 
$sortUlr = Yii::app()->createUrl("/admin/invoice",array("order"=>"ASC"));
if(!empty($_GET['order'])){
    if($_GET['order'] == "ASC"){
        $sortUlr = Yii::app()->createUrl("/admin/invoice",array("order"=>"DESC"));
    }
}
$userId = Yii::app()->user->getState('user_id');
$adminUserObject = AdminUser::model()->findByPk($userId);
$access = Yii::app()->user->getState('access');
?>
<div class="row"> 
    <div class="col-md-12" >
        <table class="table table-striped table-bordered table-hover table-full-width">
            <thead>
                <tr>
                    <th id="portal-grid_c0" width='40%'><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Description &nbsp;</span></a></th>
                    <th id="portal-grid_c3"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Availed</span></a></th>
                        
                    <th id="portal-grid_c3"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Res Amt &nbsp;</span></a></th>
                    
                    <th id="portal-grid_c5"><a href="<?php echo $sortUlr; ?>" class="sort-link">
                        <span style="white-space: nowrap;">Comm (%) &nbsp;</span></a></th>
                    <th id="portal-grid_c6"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Comm (Amt) &nbsp;</span></a></th>
                    <th id="portal-grid_c7"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Vat (%) &nbsp;</span></a></th>
                    <th id="portal-grid_c8"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Vat (Amt) &nbsp;</span></a></th>
                    <th id="portal-grid_c9"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Invoice Amt &nbsp;</span></a></th>
                    <th id="portal-grid_c9"><a href="" class="sort-link">
                        <span style="white-space: nowrap;">Action &nbsp;</span></a></th>
                </tr>
            </thead>
            <tbody>
 <?php
if (count($invReservationListObject) > 0) 
{
    foreach ($invReservationListObject as $invReservationObject) 
    {
        $invReservation = InvReservation::model()->findAll('hotel_id = ' . $invReservationObject->hotel_id.$resv_condition." order by id ASC");
        
        //Show the list of hotels
        ?>
        <tr>
            <td colspan="8" class="color-brown"><b><?php echo $invReservationObject->hotel->name; ?></b></td>
            <td><!--
            <?php
            $hotelId = $invReservationObject->hotel_id;
            $sendMail = "<div onclick='sendBill(" . $hotelId . ")'>Send Bill</div>";
            ?>
            <a href="javascript:void(0)" data-html="true" data-placement="left" data-toggle="popover" data-content="<?php echo $sendMail; ?>"><i title="Add / Edit" class="fa fa-external-link-square"></i></a> &nbsp;&nbsp;
            -->&nbsp;</td>
        </tr>
        <?php   
        foreach($invReservation as $reservation) 
        { 
            $firstName = $reservation->reservation->customer->first_name;
            $lastName = $reservation->reservation->customer->last_name;
            
            //Define of the modal box for Add and Edit OD
            $nbReservation =  $reservation->id;
            
            $modalTitle = "<b>Res Date : </b>". date("d/m/y", strtotime($reservation['res_date']));
            $modalTitle .= " <b>Res Num : </b>".$reservation['nb_reservation'];
            $modalTitle .= " <b>Cust Name : </b>".$firstName . " " .$lastName;
            ?>
            <style>
                .invoivebill ul{list-style-type: none;padding: 0;margin: 0;border-collapse: collapse;margin-top: -1px;}
                .invoivebill ul li{border: 1px solid #DBDBDB;text-align: center; margin-left:-1px;vertical-align: middle;display: table-cell;padding: 5px;margin: 0;width: 90px;position: relative;border-collapse: collapse;border-spacing: 0;}                
                .invoivebill ul li:nth-child(1){width: 307px;text-align: left;}
            </style>
            
            <!---Add Invoice Section Modal --->
            <div class="modal fade" id="add_invoice_<?php echo $reservation->id; ?>" tabindex="-2" role="basic" aria-hidden="true">
            <div class="modal-dialog" style="width:800px">
                <div class="modal-content">
                    <div class="modal-body">
                        <a class="btn btn-primary close_btn" data-dismiss="modal"><i class="fa fa-times-circle closeButton"></i></a> <!-- carousel starts here -->
                        <div class="invoivebill">
                            <div style="padding:10px 5px;box-sizing:border-box;border:1px solid #DBDBDB; border-bottom:0; background: #FFDB4B;">  
                                <?php echo $modalTitle; ?>
                                <input type="hidden" value="<?php echo $reservation['nb_reservation']; ?>" name="nb_reservation" id="nb_reservation_<?php echo $nbReservation; ?>"/>
                            </div>
                            <ul>
                                <li>Equipment</li>
                                <li>Price</li>
                                <li>Comm %</li>
                                <li>Comm Amt</li>
                                <li>Vat %</li>
                                <li>Invoice Amt</li>
                            </ul>
                            <ul>
                                <li><input type="text" class="form-control" value="" name="add_equipment_name" id="add_equipment_name_<?php echo $nbReservation; ?>"/></li>
                                <li><input type="text" class="form-control" value="0" onkeyup="caluculatePer(<?php echo $nbReservation; ?>);" name="add_opt_price" id="add_opt_price_<?php echo $nbReservation; ?>"/></li>
                                <li><input type="text" class="form-control" value="0" onkeyup="caluculatePer(<?php echo $nbReservation; ?>);" name="add_comm_perc" id="add_comm_perc_<?php echo $nbReservation; ?>"/></li>
                                <li><input type="text" class="form-control" value="0" name="add_comm_amt" id="add_comm_amt_<?php echo $nbReservation; ?>" readonly="true"/></li>
                                <li><input type="text" class="form-control" value="0" name="add_vat_perc" id="add_vat_perc_<?php echo $nbReservation; ?>" readonly="true"/></li>
                                <li><input type="text" class="form-control" value="0" name="add_total_comm_amt" id="add_total_comm_amt_<?php echo $nbReservation; ?>" readonly="true"/></li>
                            </ul>
                            <div style="margin-top:10px; text-align: right;">
                                <input type="submit" class="btn btn-success" value="Save" name="Save" id="add_save_new_equipment" onclick="addNewEquipment(<?php echo $nbReservation; ?>);">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!---End of Add Invoice Section Modal --->            
            
            <?php
            //End of definition for the modal box for Add and Edit OD
            
            if($reservation['opt_type']=='room')
            {
               $menuTitle = ($reservation['status'] == 5) ? "Make Show":"No Show";
               $status = ($reservation['status'] == 5) ? 2 : 5;
               $room_actionList = "<a data-toggle='modal' onclick='changeStatus(".$reservation->id.",".$status.");' id='noshow_".$reservation->id."' href='javascript:void(0)'>".$menuTitle."</a>";
               
               //Options for edit OD only available for dayuse not for manager
                if($access!='manager')
                    $room_actionList .="<br><a data-toggle='modal' href='#add_invoice_".$reservation->id."'>Add OD</a><br>";
            ?>
                <!-- Room Section --->
                <tr class="odd">
                    <td class='lightgreen'>
                    <?php 
                    $start_tag = ($reservation['status'] == 5)? "<del>" : "";
                    $end_tag = ($reservation['status'] == 5)? "</del>" : "";

                    echo $start_tag.date("d/m/y", strtotime($reservation['res_date']))." - ".$reservation['nb_reservation']. " - " . $firstName . " " .$lastName.$end_tag;
                    ?>
                    </td>
                    <td class='lightgreen'>&nbsp;</td>
                    <td class='lightgreen'><?php echo $reservation['opt_price']; ?></td>
                    <td class='lightgreen'><?php echo $reservation['comm_perc']; ?></td>
                    <td class='lightgreen'><?php echo $reservation['comm_amt']; ?></td>
                    <td class='lightgreen'><?php echo $reservation['vat_perc']; ?></td>
                    <td class='lightgreen'><?php echo "0.00"; ?></td>
                    <td class='lightgreen'><?php echo $reservation['total_comm_amt']; ?></td>
                    <td class='lightgreen' width="150px">
                        <a href='javascript:void(0)' data-html='true' data-placement='left' data-toggle='popover' data-html='true'  data-content="<?php echo $room_actionList; ?>" > <i title='Choose Options' class="fa fa-external-link-square"></i></a>
                    </td>
                </tr>    
            <?php
            }
            else {
                ?>
                <!-- Edit Invoice Section Modal --->
                <div class="modal fade" id="invoice_<?php echo $reservation->id; ?>" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog" style="width:800px">
                    <div class="modal-content">
                        <div class="modal-body">
                           <a class="btn btn-primary close_btn" data-dismiss="modal"><i class="fa fa-times-circle closeButton"></i></a> <!-- carousel starts here -->
                           <div class="invoivebill">
                               <div style="padding:10px 5px;box-sizing:border-box;border:1px solid #DBDBDB; border-bottom:0; background: #FFDB4B;">  
                                <input type="hidden" value="<?php echo $reservation['id']; ?>" name="invoice_id" id="invoice_id_<?php echo $nbReservation; ?>"/>
                                <?php echo $modalTitle; ?>
                               </div>
                               <ul>
                                    <li>Equipment</li>
                                    <li>Price</li>
                                    <li>Comm %</li>
                                    <li>Comm Amt</li>
                                    <li>Vat %</li>
                                    <li>Invoice Amt</li>
                                </ul>
                                <ul>
                                    <li>                                        
                                        <input type="text" class="form-control" style="width:250px;" value="<?php echo $reservation['opt_title']; ?>" name="equipment_name" id="edit_equipment_name_<?php echo $nbReservation; ?>" readonly="true"/>
                                    </li>
                                    <li><input type="text" class="form-control" value="<?php echo $reservation['opt_price']; ?>" onkeyup="caluculateUpdatePer(<?php echo $nbReservation; ?>);" name="opt_price" id="opt_price_<?php echo $nbReservation; ?>"/></li>
                                    <li><input type="text" class="form-control" value="<?php echo $reservation['comm_perc']; ?>" onkeyup="caluculateUpdatePer(<?php echo $nbReservation; ?>);"name="comm_perc" id="comm_perc_<?php echo $nbReservation; ?>"/></li>
                                    <li><input type="text" class="form-control" value="<?php echo $reservation['comm_amt']; ?>" name="comm_amt" id="comm_amt_<?php echo $nbReservation; ?>" readonly="true"/></li>
                                    <li><input type="text" class="form-control" value="<?php echo $reservation['vat_perc']; ?>" name="vat_perc" id="vat_perc_<?php echo $nbReservation; ?>" readonly="true"/></li>
                                    <li><input type="text" class="form-control" value="<?php echo $reservation['total_comm_amt']; ?>" name="total_comm_amt" id="total_comm_amt_<?php echo $nbReservation; ?>" readonly="true"/></li>
                                </ul>
                                <div style="margin-top:10px ;text-align: right;">
                                <input type="submit" class="btn btn-success" value="Save" name="Save" id="save_equipment" onclick="updateEquipment(<?php echo $nbReservation; ?>);">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- End of Edit Invoice Section Modal --->    
                <?php
                
                // Room options
                $roomOpt_actionList = "";
                
                //Option for availed
                $menuTitle = ($reservation->availed == 'yes') ? "Not Availed":"Availed";
                $status = ($reservation->availed == 'yes') ? 1 : 0;
                $roomOpt_actionList = "<a data-toggle='modal' onclick='isAvailed(".$reservation->id.",".$status.");'  href='javascript:void(0)'>".$menuTitle."</a>";
                
                //Options for edit OD will come only if it has been availed
                //Options for edit OD only available for dayuse not for manager
                if($reservation->availed == 'yes' && $access!='manager')
                    $roomOpt_actionList .="<br><a data-toggle='modal' href='#invoice_".$reservation->id."'>Edit</a>";
                ?>
                <tr class="odd">
                    <td>
                    <?php 
                    $start_tag = ($reservation['availed'] == 'no')? "<del>" : "";
                    $end_tag = ($reservation['availed'] == 'no')? "</del>" : "";

                    echo $start_tag.$reservation['opt_title'].$end_tag;
                    ?>
                    </td>
                    <td><?php echo $reservation['availed']; ?></td>
                    <td><?php echo $reservation['opt_price']; ?></td>
                    <?php
                    $tdclass = ($reservation['comm_perc'] == '0.00') ? 'class="color-red"' : '';
                    ?>
                    <td <?php echo $tdclass;?>><?php echo $reservation['comm_perc']; ?></td>
                    <td><?php echo $reservation['comm_amt']; ?></td>
                    <td><?php echo $reservation['vat_perc']; ?></td>
                    <td><?php echo "0.00"; ?></td>
                    <td><?php echo $reservation['total_comm_amt']; ?></td>
                    <td width="150px">
                        <a href='javascript:void(0)' data-html='true' data-placement='left' data-toggle='popover' data-html='true'  data-content="<?php echo $roomOpt_actionList; ?>" > <i title='Choose Options' class="fa fa-external-link-square"></i></a>
                    </td>
                </tr>                    
                <?php                
            }
        }
    }
} else {
?>
<tr>        
    <td colspan="10" align="center">
        No Record found!.
    </td>
</tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>
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

jQuery(function($) {
        function split( val ) {
	      return val.split( /,\s*/ );
	    }
        function extractLast( term ) {
          return split( term ).pop();
        }
            
	$( "#search_hotel_name" )
	   .bind( "keydown", function( event ) {
	   	if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
	   		event.preventDefault();
	   	}
	   })
	   .autocomplete({source: function( request, response ) {
	   	$.getJSON("/admin/search/hotellist", {
	   		term: extractLast( request.term )
	   	}, response );
	   },
	   search: function() {
	   // custom minLength
	   	var term = extractLast( this.value );
	   	if ( term.length < 2 ) {
	   		return false;
	   	}
	   },
	   focus: function() {
	   	// prevent value inserted on focus
	   	return false;
	   },
	   select: function( event, ui ) {
	   	var terms = split( this.value );
	   	// remove the current input
	   	terms.pop();
	   	// add the selected item
                $("#selected_hotel_id").val(ui.item.id);
	   	terms.push( ui.item.value );
	   	// add placeholder to get the comma-and-space at the end
	   	//terms.push( "" );
	   	//this.value = terms.join( ", " );
	   	this.value = terms;
	   	return false;
	   }
	   });
});
</script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
