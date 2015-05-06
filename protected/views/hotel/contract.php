<style>
.ctrerr{border-color:red !important;}
</style>
<section class="wrapper contentPart contract" id="bullshit">
<div class="container3">
    <div class="contentCont no-paddingBtm">
            <span class="smalllogo"><img src="/images/logo_contract.png" /></span>
            <div>
                    <span class="mainheading">HOTEL CONTRACT</span>
            </div>
            <section class="contractSteps">
                    <div class="status">
                            <ul>
                                    <li class="dark">Step1</li>
                                    <li>Step2</li>
                                    <li class="last">Step3</li>
                            </ul>
                    </div>
            </section>
            <span class="Subheading">Between:</span>
            <div class="normal">DAY STAY, represented by its owner David Lebee, which is a simplified joint-stock company, headquartered at rue Rochechouart - Paris 75009 FRANCE. Company's registration number : 524 948 924 RCS VAR</div>
            <span class="Subheading">And:</span>
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contract-form-id',
		)); ?>
            <input type="hidden" name="hotel_id" value="<?php echo $hotel->id;?>">
<ul class="contractform">
    <li class="floating">
        <label>Hotel owner</label>
        <span>
            <input id="text" type="text" name="HotelAdmin[hotel_ownfirst_name]" value="<?php echo ($hadmin!=NULL)? $hadmin->hotel_ownfirst_name : ''; ?>" placeholder="First Name :"/>
        </span>
        <span></span> 
        <span>
          <input class="fax" id="text" type="text" name="HotelAdmin[hotel_ownlast_name]" value="<?php echo ($hadmin!=NULL)? $hadmin->hotel_ownlast_name : ''; ?>" placeholder="Last Name :"/>
        </span>
    </li>
    <li class="floating">
        <label>Name of Hotel</label>
        <span>
            <input id="text" type="text" name="Hotel[name]" value="<?php echo ($hotel!=NULL)? $hotel->name : ''; ?>" />
        </span> 
        <span></span> 
        <label>Number of stars</label>
        <span>
            <select name="Hotel[star_rating]" id="hotel_star">
            <?php
            $hstar = ($hotel!=NULL)? $hotel->star_rating : 1;
            $hotel_stars = Yii::app()->params['hotel_star'];
            foreach($hotel_stars as $ky=>$star):
                $selected = ($star==$hstar)? "selected" : "";
                ?>
                <option value="<?php echo $star;?>" <?php echo $selected;?>><?php echo $star;?></option>
                <?php
            endforeach;
            ?>
            </select>
        </span>
    </li>
    <li class="floating">
        <label>Full Address</label>
        <span>
            <input id="text" type="text" name="Hotel[address]"  value="<?php echo ($hotel!=NULL)? $hotel->address : ''; ?>" />
        </span>
    </li>
    <li class="floating">
        <label>Country</label>
        <span>
            <select id="country_id" name="Hotel[country_id]">
            <?php
            $setcountryid = ($hotel!=NULL)? $hotel->country_id : Yii::app()->params->default['countryId'];

            $criteria = new CDbCriteria;
            $criteria->addCondition("status=1");
            $countries = Country::getAllCountry($criteria);
            foreach($countries as $country){
                    $selected = ($country->id==$setcountryid)? "selected" : "";
            ?>
                <option <?php echo $selected;?> value="<?php echo $country->id;?>"><?php echo $country->name;?></option> 
            <?php 	
            }					
            ?>		 
            </select>
        </span> 
        <span></span> 
        <label>State</label>
        <span>
            <select id="state_id" name="Hotel[state_id]">  
            <?php
            $setstateid = ($hotel!=NULL && $hotel->state_id!="")? $hotel->state_id : 0;            
            
            $criteria = new CDbCriteria;
            $criteria->addCondition("status=1");
            $criteria->addCondition("country_id=".$setcountryid);

            $states=State::getAllState($criteria);
            foreach($states as $state){
                $selected = ($setstateid!=0 && $state->id==$setstateid)? "selected" : "";
            ?>			
            <option <?php echo $selected; ?> value="<?php echo $state->id;?>"><?php echo $state->name;?></option> 
            <?php 	
            }					
            ?>		 
            </select>
        </span> 
        <span></span>
        <label>City</label>
        <span>
            <select id="city_id" name="Hotel[city_id]">  
		<?php
                $setcityid = ($hotel!=NULL && $hotel->city_id!="")? $hotel->city_id : 0;
                
                $criteria = new CDbCriteria;
                $criteria->addCondition("status=1");
                if($setstateid==0)
                    $criteria->addCondition("country_id=".$setcountryid);
                else
                    $criteria->addCondition("state_id=".$setstateid);
                
                $cities=City::getAllCity($criteria);
                foreach($cities as $city){
                    $selected = ($setcityid!=0 && $city->id==$setcityid)? "selected" : "";
                ?>			
                <option <?php echo $selected;?> value="<?php echo $city->id;?>"><?php echo $city->name;?></option> 
                <?php 	
                }					
                ?>		 
		</select>
        </span>
    </li>
    <li class="floating">
        <label>City Area</label>
        <span>
            <?php
            if($setcityid!=0)
            {
                $criteria = new CDbCriteria;
                $criteria->alias = "a";                
                $criteria->select = "a.*";
                $criteria->addCondition("a.status=1");
                $criteria->addCondition("ac.city_id=".$setcityid);
                $criteria->join=" JOIN tbl_area_city ac on ac.area_id=a.id";


                $area=  Area::model()->findAll($criteria);
            }

            echo "<select id='area_id' name='Hotel[district_id]' class='form-control select2me'>";
            echo "<option value=''>NA</option>";		
            if($setcityid!=0)
            {
                foreach($area as $listarea)
                {
                    $selected = ($listarea->id==$hotel->district_id)? "selected" : "";
                    echo "<option ".$selected." value=".$listarea->id.">".$listarea->name."</option>";
                }
            }
            echo "</select>";
            ?>
        </span> 
        <span></span>
        <label>Zip Code</label>
        <span><input class="cityarea" id="text" type="text" name="Hotel[postal_code]" value="<?php echo ($hotel!=NULL)? $hotel->postal_code : ''; ?>" /></span>
    </li>
    <li class="floating"><label>Telephone</label>
        <span><input id="text" type="text" name="Hotel[telephone]" value="<?php echo ($hotel!=NULL)? $hotel->telephone : ''; ?>"/></span> 
        <span></span> 
        <label>Fax</label>
        <span>
          <input class="fax" id="text" type="text" name="Hotel[fax]" value="<?php echo ($hotel!=NULL)? $hotel->fax : ''; ?>" />
        </span>
    </li>
    <li class="floating">
        <label>Registration number</label>
        <span>
            <input id="text" type="text" name="HotelAdmin[registration_no]" value="<?php echo ($hadmin!=NULL)? $hadmin->registration_no : ''; ?>" />
        </span> 
        <span></span>
        <label>TAX ID</label>
        <span>
            <input class="tax" id="text" type="text" name="HotelAdmin[vat_no]" value="<?php echo ($hadmin!=NULL)? $hadmin->vat_no : ''; ?>" /></span>
    </li>
</ul>
<div class="clear25"></div>
<div class="clear10"></div>
<span class="Subheading">Contacts :</span>
    <ul class="contactInfo" id="addemailbox">
        <li class="floating headTitles"><label class="blank"></label> <label
                class="labelName">First Name, Last Name</label> <label
                class="labelPhone">Telephone</label> <label class="labelAddress">Email Address</label>
        </li>
        <?php
        $con_cn = 0;
        foreach(Yii::app()->params->hotel_contact_info as $cky=>$cval):
            
            $con_cn ++;
            $con_req = ($con_cn==1)? '*' : '';
            
            $hotelcontact = HotelContact::model()->find('hotel_id='.$hotel->id.' and contact_type='.$cky);
        ?>
        <li class="floating"><label><?php echo $cval; ?><?php echo $con_req;?></label><span
                class="firstField"><input id="text" type="text"
                        name="HotelContact[<?php echo $cky?>][name]" maxlength="140" value="<?php echo ($hotelcontact!=NULL)? ($hotelcontact->first_name.' '.$hotelcontact->last_name) : "";?>" /></span> <span
                class="secondField"><input id="text" type="text"
                        name="HotelContact[<?php echo $cky?>][telephone]" maxlength="15" value="<?php echo ($hotelcontact!=NULL)? $hotelcontact->telephone : "";?>"/></span> <span
                class="thirdField"><input id="text" type="text"
                        name="HotelContact[<?php echo $cky?>][email_address]" maxlength="140" value="<?php echo ($hotelcontact!=NULL)? $hotelcontact->email_address : "";?>"/></span>
        </li>
        <?php
        endforeach;
        ?>
        <!--<li class="floating email">
              <label>Email to receive the reservations requests</label>
              <span><input id="text" type="text"></span>      
              <div class="addbutton" style="display:block;"><a href="#"><span class="icon">-</span>Remove</a></div>              
        </li>-->
        <ul class="addedfields" id="addedfields">
            <?php 
            $no_email=0;
            if(count($hemail)) {                        
            foreach ($hemail as $ky=>$hEmail):
                //$add_remove = ($no_email==0)? "" : "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>";
                $add_remove = ($no_email==0)? "none" : "block";
                    
                echo '<li class="floating email"><label>Email to receive the reservations requests</label><span><input id="text" type="text" id="email_add'.$no_email.'" name="HotelDetail[email_address]['.$no_email.']" value="'.$hEmail->email_add.'"></span></li>';
                $no_email ++;
            endforeach;
            }
            else{
                echo '<li class="floating email"><label>Email to receive the reservations requests</label><span><input id="text" type="text" id="email_add1" name="HotelDetail[email_address][0]"></span></li>';
                   
            }
            ?>
            </ul>
            <input type="hidden" id="emailinc" name="emailinc" value="<?php echo count($hemail);?>">
            <!-- Dont remove this li-->
            <li class="floating">              
                 <div class="addbutton">
                            <a href="javascript:void(0);" id="addemailbutton"><span class="icon">+</span>Add</a>
                 </div>               
            </li>  
            
            
    </ul>
    <div class="clear10"></div>
    <div class="normal smallnote">(Hereafter reffered to as "The Hotel" *If the hotel is a legal entity property, specify the aforementioned legal entity's name.</div>
    <span class="Subheading">Here to agree as follows : </span>
    <div class="normal">Terms of service agreement : The hotel declares that it received a copy of the terms of service agreement for DAY
        STAY, October 1st, 2010 version (the "terms"). The Hotel confirms it read and approved the aforementioned terms. The terms play an
        integral part of the present agreement (this agreement and its terms are considered together under a unique word, the "Agreement").</div>
    <span class="Subheading">Commission percentage : </span>
    <ul class="commission">
    <li class="detail">In accordance with the clause 8 of the terms,<br />The minimal commission rate is set to</li>
    <li class="parameter">
        <ul>
        <li class="floating"><span><input id="text" type="text" name="Hotel[day_commission]" readonly value="<?php echo ($hotel!=NULL)? $hotel->day_commission : ''; ?>" />% of the
                        DAY STAY room rate, excluding taxes</span></li>
        <li class="floating"><span><input id="text" type="text" name="Hotel[night_commission]" readonly value="<?php echo ($hotel!=NULL)? $hotel->night_commission : ''; ?>"/>% of the
                        room NIGHTS rate, excluding taxes</span></li>
        <li class="floating"><span><input id="text" type="text" name="Hotel[addon_commission]" readonly value="<?php echo ($hotel!=NULL)? $hotel->addon_commission    : ''; ?>" />% of the
                        ADDITIONAL SERVICES (Champagne, spa...)</span></li>
        </ul>
    </li>
    </ul>
    <div class="clear15"></div>
    <span class="Subheading">Rooms for sale on Dayuse-hotels.com : </span>
    <ul class="rooms" id="roomslot">
        <li class="floating headTitles"><label class="blank"></label> <label
                class="labelName">Name</label> <label class="labelTime">Time slot</label>
                <label class="labelRate">DAY STAY rate</label> <label
                class="labelRack">RACK rate</label></li>
                <script>$("roomslotadd").trigger();</script>
        <?php
        
//       $room = array();
        $room_cnt = count($room);
        $room_ids = array();
        ?>
        <input type="hidden" value="<?php echo ($room_cnt=="0")?"1":$room_cnt;?>" id="roomnum" />
        <?php
        $rm_count=0;
        foreach ($room as $rmky => $rm):
            $rm_count++;
            array_push($room_ids, $rm->id);
        ?>
        <input type="hidden" name="Room[<?php echo $rm_count;?>][id]" value="<?php echo $rm->id;?>" />
        <li class="floating">
            <div class="serialno">
                    <span><?php echo ($rm_count=="0")?"1":$rm_count;?></span>
            </div> 
            <span class="firstField">
                <input id="text" type="text" name="Room[<?php echo $rm_count;?>][name]" value="<?php echo $rm->name;?>" />
            </span> 
            <span class="secondField">
                <!--<input id="text" type="text" name="Room[time][1]" value="<?php if(isset(Yii::app()->session['room']['time'][1])){echo Yii::app()->session['room']['time'][1];}?>" />-->
                <select name="Room[<?php echo $rm_count;?>][available_from]" id="availablefrombox" style="display:inline-block;">
                    <?php 
                    $selected = "";
                    for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
                    for($mins=0; $mins<60; $mins+=30){
                    $selected = "";
                            $time = str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                            if(isset($rm->available_from)){
                                    $pieces = explode(":", $time);
                                    if($pieces[0] <10)
                                    {
                                            $maintime = "0".$time.":00";
                                    }else {
                                            $maintime = $time.":00";
                                    }
                                    if($maintime == $rm->available_from)
                                    {
                                            //$selected = ' selected="selected"';
                                        $selected = "selected";
                                    }	
                            }

                            echo '<option value="'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.BaseClass::convertTime(str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT)).'</option>';
                    }
                }					 // the interval for mins is '30'
		?>
                </select>
                <select name="Room[<?php echo $rm_count;?>][available_till]" id="availabletillbox" style="display:inline-block;">
                    <?php 
                    $selected = "";
                    for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
                    for($mins=0; $mins<60; $mins+=30){
                    $selected = "";
                            $time = str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                            if(isset($rm->available_till)){
                                    $pieces = explode(":", $time);
                                    if($pieces[0] <10)
                                    {
                                            $maintime = "0".$time.":00";
                                    }else {
                                            $maintime = $time.":00";
                                    }
                                    if($maintime == $rm->available_till)
                                    {
                                            $selected = ' selected="selected"';
                                    }	
                            }

                            echo '<option value="'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.BaseClass::convertTime(str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT)).'</option>';
                        }
                    }					 // the interval for mins is '30'
                    ?>
                </select>
            </span> 
            <?php
            if($rm->category=='moon')
            {
                $rmprice = $rm->default_discount_night_price;
                $rmrac = $rm->default_night_price;
            }
            else
            {
                $rmprice = $rm->default_discount_price;
                $rmrac = $rm->default_price;
            }
                
            ?>
            <span class="thirdField">
                <input id="text" type="text" name="Room[<?php echo $rm_count;?>][price]" value="<?php echo $rmprice;?>" />
            </span> 
            <span class="fourthField">
                <input id="text" type="text" name="Room[<?php echo $rm_count;?>][rac]" value="<?php echo $rmrac;?>"/>
            </span>
            <!--<span class="removebutton"><a href="#"><span class="icon">-</span></a></span>-->
        </li>
        <?php
        endforeach;
        ?>
    </ul>
    <ul class="rooms">
            <li class="floating">
                    <div class="addbutton">
                            <a href="javascript:void(0);" id="roomslotadd"><span class="icon">+</span>Add</a>
                    </div>
            </li>
    </ul>
    <?php
    $ropts = NULL;
    //Get the options for the roomids
    if(count($room_ids))
    {
        $rmids = implode(",",$room_ids);
        
        $criteria=new CDbCriteria;
        $criteria->distinct = true;
        $criteria->alias = "ro";                
        $criteria->select = "ro.equipment_id";
        $criteria->addCondition("ro.room_id in (".$rmids.")");
        
        $ropts= RoomOptions::model()->findAll($criteria);
    }
    ?>
    <div class="clear25"></div>
    <span class="Subheading">Extra services : </span>
    <ul class="extraServices" id="extraservice">
        <li class="floating headTitles">
            <label class="blank"></label> 
            <label class="labelName">Name</label> 
                <label class="labelPrice">Price</label>
        </li>
        <?php
        $opt_no = ($ropts!=NULL) ? count($ropts) : 1;
        $equip_type = CHtml::listData(OptionType::model()->findAll(array('order' => 'id ASC')), 'id', 'name');
        ?>
        <input type="hidden" value="<?php echo $opt_no;?>" id="extraservhid" />
        <?php
        $opno = 0;
        if($ropts!=NULL){
        foreach ($ropts as $oky=>$opval):
            $opno++;
            $opt_detail = Equipment::model()->find('id='.$opval->equipment_id);
        ?>
        <input type="hidden" name="RoomOpt[<?php echo $opno;?>][equip_id]" value="<?php echo $opval->equipment_id;?>">
        <li class="floating">
            <span class="firstField">
                <select name = "RoomOpt[<?php echo $opno;?>][type]">
                   <?php
                   foreach($equip_type as $tyid=>$tyname):
                       $selected = ($opt_detail->option_type_id == $tyid)? "selected" : "";
                       echo '<option value="'.$tyid.'" '.$selected.'>'.$tyname.'</option>';
                   endforeach;
                   ?>
                </select>
            </span>
            
            <span class="secondField">
                <input id="text" class="servicelabel" type="text" name="RoomOpt[<?php echo $opno;?>][name]" value="<?php echo $opt_detail->name;?>" />
            </span> 
            <span class="thirdField">
                <input id="text" class="serviceprice" type="text" name="RoomOpt[<?php echo $opno;?>][price]" value="<?php echo $opt_detail->default_price;?>"/>
            </span>
        </li>
        <?php
        endforeach;
        }
        ?>
    </ul>
    <ul class="extraServices" >
        <!--<li class="floating">
            <span class="secondField">
                <select name = "RoomOpt[<?php echo $opt_no;?>][type]">
                   <?php
                   foreach($equip_type as $tyid=>$tyname):
                       echo '<option value="'.$tyid.'">'.$tyname.'</option>';
                   endforeach;
                   ?>
                </select>
            </span>
            <span class="secondField">
                <input id="text" class="servicelabel" type="text" name="RoomOpt[<?php echo $opt_no;?>][name]" value="" />
            </span> 
            <span class="thirdField">
                <input id="text" class="serviceprice" type="text" name="RoomOpt[<?php echo $opt_no;?>][price]" value=""/>
            </span>
        </li>-->
        <li class="floating">
            <div class="addbutton">
                <a href="javascript:void(0)" id="extraserviceadd"><span class="icon">+</span>Add</a>
            </div>
        </li>
    </ul>

    <div class="clear25"></div>
    <span class="Subheading">Hotel marketing : </span>
    <div class="normal">The Hotel agrees not to distribute promotional emails or marketing to the clients acquired via DAYSTAY (daystay-hotels.com)</div>
    <span class="Subheading">Implementation : </span> <p class="normal">The present agreement is actually implemented solely on acceptance by DAYSTAY in accordance with the clause 13 of the terms. This acceptance can be granted or denied by DAYSTAY and remains at its own discretion.<br /> <br /> By signing here below, the signatory hereby</p>

    <div class="signature">
        <div class="leftPane">
            <ul>
                <li class="floating"><label class="w80">Date</label> <span
                        class="firstField"><input id="text" type="text" name="Sign[date]" value="" readonly/></span> <label>On</label>
                        <span class="secondField"><input id="text" type="text" name="Sign[on]" value="" readonly/></span>
                </li>
                <li class="floating"><label class="w80">Signatory</label> <span><input
                            id="text" placeholder="(Print name)" type="text" name="Sign[name]" value="" readonly/></span></li>
                <li class="floating"><label class="w80 textareaLabel">Signature</label>
                    <span><textarea readonly></textarea>
                        <div class="signText">
                            Hotel
                    </span></li>
            </ul>
        </div>
        <div class="rightPane">
            <ul>
                <li class="floating"><span><textarea readonly></textarea>
	<div class="signText">DayStay</span></li></ul></div>
    </div>
  

    <div class="clear"></div>
    <div class="withlineWrapper"><p class="withline"><a href="#">General terms</a></p></div>
    <div class="clear30"></div>
    <div class="bottomAddress">LLC with a capital stock of 48.250 &#8364; - headquarters : 5, rue de Rochechouart 75009 Paris FRANCE. - Siret : 524 948 924 00013 - Siren : 524 948 924</div>
    <div class="clear20"></div>
    
    </div>
</div>
<section class="nextstepPane">
        <input type="submit" class="nextStep" value="NEXT STEP >>">
</section>
   <?php $this->endWidget(); ?>
</section>
<style>
    .ui-selectmenu-menu{max-height:200px;overflow: hidden; overflow-y: auto;}
    </style>
<script>
var stateUrl = "<?php echo Yii::app()->createUrl('admin/hotel/changestate'); ?>";
var cityUrl = "<?php echo Yii::app()->createUrl('admin/hotel/changecity'); ?>";
var areaUrl = "<?php echo Yii::app()->createUrl('admin/hotel/changearea'); ?>";
$(document).ready(function(){ 
     var roomCount = "<?php echo $room_cnt; ?>";
     if(roomCount=="0"){
     var incval =  parseInt($('#roomnum').val());
        $('#roomnum').val(incval);
        var tslot = "";
        <?php
        for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
            for($mins=0; $mins<60; $mins+=30){
            $selected = "";
            $time = str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
            ?>
               tslot += '<?php echo '<option value="'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.BaseClass::convertTime(str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT)).'</option>';?>';
            <?php   
            }
        }
        ?>
        //$('#roomslot').append('<li class="floating"><div class="serialno"><span>'+incval+'</span></div><span class="firstField"><input id="text" type="text" name="Room[name]['+incval+']" /></span><span class="secondField"><input id="text" type="text" name="Room[time]['+incval+']" /></span><span class="thirdField"><input id="text" type="text" name="Room[dayuserate]['+incval+']" /></span><span class="fourthField"><input id="text" type="text" name="Room[rackrate]['+incval+']" /></span></li>');
        $('#roomslot').append('<li class="floating"><div class="serialno"><span>'+incval+'</span></div><input type="hidden" name="Room['+incval+'][id]" value="0"><span class="firstField"><input id="text" type="text" name="Room['+incval+'][name]" value="" /></span><span class="secondField"><select name="Room['+incval+'][available_from]" id="availablefrombox">'+tslot+'</select><select name="Room['+incval+'][available_till]" id="availabletillbox">'+tslot+'</select></span><span class="thirdField"><input id="text" type="text" name="Room['+incval+'][price]" value="" /></span><span class="fourthField"><input id="text" type="text" name="Room['+incval+'][rac]" value=""/></span></li>');
        $('select').selectmenu();
    }
            
$('#roomslotadd').trigger('click'); 
        $('select').selectmenu();
        $("#country_id").selectmenu({
            change: function( event, ui ) {
                 $.ajax({
                    type: "GET",
                    url: stateUrl,
                    data: { country_id: $('#country_id :selected').val(),'selectName':'Hotel[state_id]'},
                    success: function(result){
                                $('#state_id').html(result);                                
                                $('#state_id').selectmenu('refresh', true);
                                
                            }
                    });
            }
          });
        $("#state_id").selectmenu({
            change: function( event, ui ) {
                $.ajax({
                        type: "GET",
                        url: cityUrl,
                        data: { state_id: $('#state_id :selected').val(),'selectName':'Hotel[city_id]'},
                        success: function(result){
                                    $('#city_id').html(result);
                                    $('#city_id').selectmenu('refresh', true);
                                }
                    });
            }
          });
          
        $("#city_id").selectmenu({
            change: function( event, ui ) {
                $.ajax({
                        type: "GET",
                        url: areaUrl,
                        data: { city_id: $('#city_id :selected').val(),'selectName':'Hotel[area_id]'},
                        success: function(result){
                                    $('#area_id').html(result);
                                    $('#area_id').selectmenu('refresh', true);
                                }
                        });
            }
          });
          
          $('#addbutton').click(function(e){
		     if($(".addedfields").length < 10){		    
		       $(".addedfields").append(
		    		   "<li style='margin-top:5px;'><input type='text' name='HotelDetail[email_address][]' class='form-control textbox'/>"+
					   "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a></li>"
		       );
		       e.preventDefault();
		     }
		     $(".removeBtn").on("click",function(e){
				   $(this).parent().remove();
				   e.preventDefault();
			   });
		});
	   $(".removeBtn").on("click",function(e){
		   $(this).parent().remove();
		   e.preventDefault();
	   });
       
           
	$('.nextStep').click(function(){
		var flag = "";
		$('.contractform input').each(function(){
			if($(this).val() == "")
			{
				$(this).addClass("ctrerr");
				flag = "flagged"
			}
		});
		if(flag == "flagged")
		{
			$('html, body').animate({
		        'scrollTop' : $(".contractform").position().top
		    });
			return false;
		}
	});
        
        
        $('#addemailbutton').click(function(){
            var incval =  parseInt($('#emailinc').val()) + 1;
            $('#emailinc').val(incval);
            $('#addedfields').append('<li class="floating email"><label>Email to receive the reservations requests</label><span><input id="text" type="text" id="email_add1" name="HotelDetail[email_address]['+incval+']"></span></li>');
            });
	
	$('#addemail').click(function(){
			if($('#emailval').val() == ""){
				alert("Enter email");
			}else{
				sEmail = $('#emailval').val();
				if (validateEmail(sEmail)) {
					var incval =  parseInt($('#emailinc').val()) + 1;
					//$('#emailinc').val(incval);
					//var email = $('#emailval').val();	
					//$('#addemailbox').append('<li class="floating email"><label>Email to receive the reservations requests</label><span><input id="text" type="text" name="HotelEmail['+incval+']" value="'+email+'" /></span></li>');
                                        
					//$('#emailval').val("");
					}
					else {
						alert("Invalid Email");
					}
				
			
			}
	});
	$('#roomslotadd').click(function(){ 
		var incval =  parseInt($('#roomnum').val()) + 1;
		$('#roomnum').val(incval);
                var tslot = "";
                <?php
                for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
                    for($mins=0; $mins<60; $mins+=30){
                    $selected = "";
                    $time = str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                    ?>
                       tslot += '<?php echo '<option value="'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';?>';
                    <?php   
                    }
                }
                ?>
		//$('#roomslot').append('<li class="floating"><div class="serialno"><span>'+incval+'</span></div><span class="firstField"><input id="text" type="text" name="Room[name]['+incval+']" /></span><span class="secondField"><input id="text" type="text" name="Room[time]['+incval+']" /></span><span class="thirdField"><input id="text" type="text" name="Room[dayuserate]['+incval+']" /></span><span class="fourthField"><input id="text" type="text" name="Room[rackrate]['+incval+']" /></span></li>');
                $('#roomslot').append('<li class="floating"><div class="serialno"><span>'+incval+'</span></div><input type="hidden" name="Room['+incval+'][id]" value="0"><span class="firstField"><input id="text" type="text" name="Room['+incval+'][name]" value="" /></span><span class="secondField"><select name="Room['+incval+'][available_from]" id="availablefrombox">'+tslot+'</select><select name="Room['+incval+'][available_till]" id="availabletillbox">'+tslot+'</select></span><span class="thirdField"><input id="text" type="text" name="Room['+incval+'][price]" value="" /></span><span class="fourthField"><input id="text" type="text" name="Room['+incval+'][rac]" value=""/></span></li>');
                $('select').selectmenu();
        });
	$('#extraserviceadd').click(function(){
                var tslot = "";
                <?php
                foreach($equip_type as $tyid=>$tyname):
                    ?>
                       tslot += '<?php echo '<option value="'.$tyid.'">'.$tyname.'</option>'; ?>';
                    <?php  
                endforeach;
                ?>
            
		/*if($('#servicelabel').val()==""){
			alert("Please enter the service name");
			}else{*/
				var incval =  parseInt($('#extraservhid').val()) + 1;
				$('#extraservhid').val(incval);
				//var label = $('#servicelabel').val();
				//var name = $('#servicename').val();
				//var price = $('#serviceprice').val();
                                $('#extraservice').append('<li class="floating"><input type="hidden" name="RoomOpt['+incval+'][equip_id]" value="0"><span class="firstField"><select name = "RoomOpt['+incval+'][type]">'+tslot+'</select></span><span class="secondField"><input id="text" class="servicelabel" type="text" name="RoomOpt['+incval+'][name]" value="" /></span><span class="thirdField"><input id="text" class="serviceprice" type="text" name="RoomOpt['+incval+'][price]" value=""/></span></li>');
                                
				//$('#extraservice').append('<li class="floating"><div class="CustomCheckbox"><span><input name="Service[check]['+incval+']" class="checkboxItemCustom" type="checkbox" label="" value=""><div></div></span></div><label><input name="Services[label]['+incval+']" type="text" value="'+label+'" class="disappered" readonly /></label><span class="secondField"><input name="Services[name]['+incval+']" type="text" value="'+name+'" /></span><span class="thirdField"><input name="Services[price]['+incval+']" type="text" value="'+price+'" /></span></li>');
				//var label = $('#servicelabel').val("");
				//var name = $('#servicename').val("");
				//var price = $('#serviceprice').val("");
				//customcheckboxes();
				//}	
               $('select').selectmenu();
        });
	function validateEmail(sEmail) {
	    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	    if (filter.test(sEmail)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
	function customcheckboxes(){

		//for custom checkbox code starts here
		$('.checkboxItemCustom').each(function(i){
			var $this = $(this);
			if($this.parent().hasClass("checkboxItem")){
			}else{
			$this.parent().html('<a class="checkboxItem runtime">'+this.outerHTML+'<div>'+$this.attr('label')+'</div></a>');
			
			}
			});

		// indivisual click on checkbox 
		
		$('.checkboxItem.runtime').on('click', function(){       
			$checkbox = $(this).children('input:checkbox');
			if ($checkbox.is(':checked'))
			{
				$(this).removeClass('active');
				$checkbox.prop('checked', false);				
			}
			else{
				$(this).addClass('active');
				$checkbox.prop('checked', true);				
			} 
			$(this).removeClass("runtime");     
		});
		
	//for custom checkbox code ends here
		}
});
</script>