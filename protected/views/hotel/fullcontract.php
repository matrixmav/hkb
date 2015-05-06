<div id="printpage">
	<span class="wrapper contentPart contract">
		<div class="container3">
			<div class="contentCont no-paddingBtm" style="min-height: 1200px;">
				<span class="smalllogo"> <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo_contract.png" />
				</span>
				<div>
					<span class="mainheading">HOTEL CONTRACT</span>
				</div>
				<span class="Subheading">Between:</span>
				<div class="normal">DAY STAY, represented by its owner David Lebee,
					wich is a simplified joint-stock company, headquartered at rue
					Rochechouart - Paris 75009 FRANCE. Company's registration number :
					524 948 924 RCS VAR</div>
				<span class="Subheading">And:</span>
				<form>
					<ul class="contractform">
						<li class="floating"><label>Hotel owner</label> <span> <input
								id="text" readonly type="text"
								name="HotelAdmin[hotel_ownfirst_name]"
								value="<?php echo ($hadmin!=NULL)? $hadmin->hotel_ownfirst_name : ''; ?>"
								placeholder="First Name :" />
						</span> <span></span> <span> <input class="fax" readonly id="text"
								type="text" name="HotelAdmin[hotel_ownlast_name]"
								value="<?php echo ($hadmin!=NULL)? $hadmin->hotel_ownlast_name : ''; ?>"
								placeholder="Last Name :" />
						</span></li>
						<li class="floating"><label>Name of Hotel</label> <span> <input
								id="text" type="text" readonly name="Hotel[name]"
								value="<?php echo ($hotel!=NULL)? $hotel->name : ''; ?>" />
						</span> <span></span> <label>Number of stars</label> <span>
            <?php
												$hstar = ($hotel != NULL) ? $hotel->star_rating : 1;
												?>
            <input class="star" id="" readonly type="text"
								value="<?php echo $hstar;?>">

						</span></li>
						<li class="floating"><label>Full Address</label> <span> <input
								id="text" type="text" readonly name="Hotel[address]"
								value="<?php echo ($hotel!=NULL)? $hotel->address : ''; ?>" />
						</span></li>
						<li class="floating"><label>Country</label> <span>
            <?php
												$setcountryid = ($hotel != NULL) ? $hotel->country_id : Yii::app ()->params->default ['countryId'];
												
												$criteria = new CDbCriteria ();
												$criteria->addCondition ( "status=1" );
												$country = Country::model ()->find ( 'id=' . $setcountryid );
												?>	
            <input readonly type="text"
								value="<?php echo $country->name;?>">
						</span> <span></span> <label>State</label> <span>
            <?php
												$setstateid = ($hotel != NULL) ? $hotel->state_id : 0;
												$state = State::model ()->find ( 'id=' . $setstateid );
												?>		
            <input readonly type="text" class="city"
								value="<?php echo $state->name;?>">
						</span> <span></span> <label>City</label> <span>
            <?php
												$setcityid = ($hotel != NULL) ? $hotel->city_id : 0;
												$city = City::model ()->find ( 'id=' . $setcityid );
												?>
            <input readonly type="text" class="country"
								value="<?php echo $city->name;?>">
						</span></li>
						<li class="floating"><label>City Area</label> <span>
            <?php
												$area_name = "";
												if ($hotel->district_id != "") {
													$area = Area::model ()->find ( 'id=' . $hotel->district_id );
													$area_name = ($area != NULL) ? $area->name : "";
												}
												?>
            <input readonly type="text" value="<?php echo $area_name;?>">
						</span> <span></span> <label>Zip Code</label> <span><input
								class="cityarea" readonly id="text" type="text"
								name="Hotel[postal_code]"
								value="<?php echo ($hotel!=NULL)? $hotel->postal_code : ''; ?>" /></span>
						</li>
						<li class="floating"><label>Telephone</label> <span><input
								id="text" readonly type="text" name="Hotel[telephone]"
								value="<?php echo ($hotel!=NULL)? $hotel->telephone : ''; ?>" /></span>
							<span></span> <label>Fax</label> <span> <input class="fax"
								readonly id="text" type="text" name="Hotel[fax]"
								value="<?php echo ($hotel!=NULL)? $hotel->fax : ''; ?>" />
						</span></li>
						<li class="floating"><label>Registration number</label> <span> <input
								id="text" readonly type="text"
								name="HotelAdmin[registration_no]"
								value="<?php echo ($hadmin!=NULL)? $hadmin->registration_no : ''; ?>" />
						</span> <span></span> <label>TAX ID</label> <span> <input
								class="tax" readonly id="text" type="text"
								name="HotelAdmin[vat_no]"
								value="<?php echo ($hadmin!=NULL)? $hadmin->vat_no : ''; ?>" /></span>
						</li>
					</ul>
					<div class="clear25"></div>
					<div class="clear10"></div>
					<span class="Subheading">Contacts :</span>
					<ul class="contactInfo" id="addemailbox">
						<li class="floating headTitles"><label class="blank"></label> <label
							class="labelName">First Name, Last Name</label> <label
							class="labelPhone">Telephone</label> <label class="labelAddress">Email
								Address</label></li>
        <?php
								$con_cn = 0;
								foreach ( Yii::app ()->params->hotel_contact_info as $cky => $cval ) :
									
									$con_cn ++;
									$con_req = ($con_cn == 1) ? '*' : '';
									
									$hotelcontact = HotelContact::model ()->find ( 'hotel_id=' . $hotel->id . ' and contact_type=' . $cky );
									?>
        <li class="floating"><label><?php echo $cval; ?><?php echo $con_req;?></label><span
							class="firstField"><input readonly id="text" type="text"
								name="HotelContact[<?php echo $cky?>][name]" maxlength="140"
								value="<?php echo ($hotelcontact!=NULL)? ($hotelcontact->first_name.' '.$hotelcontact->last_name) : "";?>" /></span>
							<span class="secondField"><input readonly id="text" type="text"
								name="HotelContact[<?php echo $cky?>][telephone]" maxlength="15"
								value="<?php echo ($hotelcontact!=NULL)? $hotelcontact->telephone : "";?>" /></span>
							<span class="thirdField"><input readonly id="text" type="text"
								name="HotelContact[<?php echo $cky?>][email_address]"
								maxlength="140"
								value="<?php echo ($hotelcontact!=NULL)? $hotelcontact->email_address : "";?>" /></span>
						</li>
        <?php
								endforeach
								;
								?>
        <ul class="addedfields" id="addedfields">
            <?php
												$no_email = 0;
												if (count ( $hemail )) {
													foreach ( $hemail as $ky => $hEmail ) :
														// $add_remove = ($no_email==0)? "" : "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a>";
														$add_remove = ($no_email == 0) ? "none" : "block";
														
														echo '<li class="floating email"><label>Email to receive the reservations requests</label><span><input readonly id="text" type="text" id="email_add' . $no_email . '" name="HotelDetail[email_address][' . $no_email . ']" value="' . $hEmail->email_add . '"></span></li>';
														$no_email ++;
													endforeach
													;
												} else {
													echo '<li class="floating email"><label>Email to receive the reservations requests</label><span><input readonly id="text" type="text" id="email_add1" name="HotelDetail[email_address][0]"></span></li>';
												}
												?>
            </ul>
						<input type="hidden" id="emailinc" name="emailinc"
							value="<?php echo count($hemail);?>">

					</ul>
					<div class="clear10"></div>
					<div class="normal smallnote">(Hereafter reffered to as "The Hotel"
						*If the hotel is a legal entity property, specify the
						aforementioned legal entity's name.</div>
					<span class="Subheading">Here to agree as follows : </span>
					<div class="normal">Terms of service agreement : The hotel declares
						that it received a copy of the terms of service agreement for DAY
						STAY, October 1st, 2010 version (the "terms"). The Hotel confirms
						it read and approved the aforementioned terms. The terms play an
						integral part of the present agreement (this agreement and its
						terms are considered together under a unique word, the
						"Agreement").</div>
					<span class="Subheading">Commission percentage : </span>
					<ul class="commission">
						<li class="detail">In accordance with the clause 8 of the terms,<br />The
							minimal commission rate is set to
						</li>
						<li class="parameter">
							<ul>
								<li class="floating"><span><input id="text" type="text"
										name="Hotel[day_commission]" readonly
										value="<?php echo ($hotel!=NULL)? $hotel->day_commission : ''; ?>" />%
										of the DAY STAY room rate, excluding taxes</span></li>
								<li class="floating"><span><input id="text" type="text"
										name="Hotel[night_commission]" readonly
										value="<?php echo ($hotel!=NULL)? $hotel->night_commission : ''; ?>" />%
										of the room NIGHTS rate, excluding taxes</span></li>
								<li class="floating"><span><input id="text" type="text"
										name="Hotel[addon_commission]" readonly
										value="<?php echo ($hotel!=NULL)? $hotel->addon_commission    : ''; ?>" />%
										of the ADDITIONAL SERVICES (Champagne, spa...)</span></li>
							</ul>
						</li>
					</ul>
					<div class="clear"></div>
				</form>
			</div>
		</div>
	</span>


	<span class="wrapper contentPart contract">
		<div class="container3">
			<div class="contentCont no-paddingBtm" style="min-height: 1200px;">
				<span class="smalllogo"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo_contract.png" /></span>
				<div>
					<span class="mainheading">HOTEL CONTRACT</span>
				</div>
				<div class="clear50"></div>
				<span class="Subheading">Rooms for sale on Dayuse-hotels.com : </span>
				<ul class="rooms" id="roomslot">
					<li class="floating headTitles"><label class="blank"></label> <label
						class="labelName">Name</label> <label class="labelTime">Time slot</label>
						<label class="labelRate">DAY STAY rate</label> <label
						class="labelRack">RACK rate</label></li>
        <?php
								$room_cnt = count ( $room );
								$room_ids = array ();
								?>
        <input type="hidden" value="<?php echo $room_cnt;?>"
						id="roomnum" />
        <?php
								$rm_count = 0;
								foreach ( $room as $rmky => $rm ) :
									$rm_count ++;
									array_push ( $room_ids, $rm->id );
									?>
        <input type="hidden" name="Room[<?php echo $rm_count;?>][id]"
						value="<?php echo $rm->id;?>" />
					<li class="floating">
						<div class="serialno">
							<span><?php echo $rm_count;?></span>
						</div> <span class="firstField"> <input readonly id="text"
							type="text" name="Room[<?php echo $rm_count;?>][name]"
							value="<?php echo $rm->name;?>" />
					</span> <span class="secondField"> <input readonly=""
							id="availablefrombox-button" type="text" name=""
							value="<?php echo $rm->available_from; ?>"> <input readonly=""
							id="availabletillbox-button" type="text" name=""
							value="<?php echo $rm->available_till; ?>">
					</span> 
            <?php
									if ($rm->category == 'moon') {
										$rmprice = $rm->default_discount_night_price;
										$rmrac = $rm->default_night_price;
									} else {
										$rmprice = $rm->default_discount_price;
										$rmrac = $rm->default_price;
									}
									
									?>
            <span class="thirdField"> <input readonly id="text"
							type="text" name="Room[<?php echo $rm_count;?>][price]"
							value="<?php echo $rmprice;?>" />
					</span> <span class="fourthField"> <input readonly id="text"
							type="text" name="Room[<?php echo $rm_count;?>][rac]"
							value="<?php echo $rmrac;?>" />
					</span>
					</li>
        <?php
								endforeach
								;
								?>
    </ul>
        <?php
								$ropts = NULL;
								// Get the options for the roomids
								if (count ( $room_ids )) {
									$rmids = implode ( ",", $room_ids );
									
									$criteria = new CDbCriteria ();
									$criteria->distinct = true;
									$criteria->alias = "ro";
									$criteria->select = "ro.equipment_id";
									$criteria->addCondition ( "ro.room_id in (" . $rmids . ")" );
									
									$ropts = RoomOptions::model ()->findAll ( $criteria );
								}
								?>
                        
			    <div class="clear25"></div>
				<span class="Subheading">Extra services : </span>
				<ul class="extraServices" id="extraservice">
					<li class="floating headTitles"><label class="blank"></label> <label
						class="labelName">Name</label> <label class="labelPrice">Price</label>
					</li>
        <?php
								$opt_no = ($ropts != NULL) ? count ( $ropts ) : 1;
								$equip_type = CHtml::listData ( OptionType::model ()->findAll ( array (
										'order' => 'id ASC' 
								) ), 'id', 'name' );
								?>
        <input type="hidden" value="<?php echo $opt_no;?>"
						id="extraservhid" />
        <?php
								$opno = 0;
								foreach ( $ropts as $oky => $opval ) :
									$opno ++;
									$opt_detail = Equipment::model ()->find ( 'id=' . $opval->equipment_id );
									?>
        <input type="hidden"
						name="RoomOpt[<?php echo $opno;?>][equip_id]"
						value="<?php echo $opval->equipment_id;?>">
					<li class="floating"><span class="firstField">
                <?php
									foreach ( $equip_type as $tyid => $tyname ) :
										if ($opt_detail->option_type_id == $tyid) {
											?>
                     <input readonly id="text" type="text"
							name="extra[]" value="<?php echo $tyname;?>" />
                     <?php
										}
									endforeach
									;
									?>
            </span> <span class="secondField"> <input readonly id="text"
							class="servicelabel" type="text"
							name="RoomOpt[<?php echo $opno;?>][name]"
							value="<?php echo $opt_detail->name;?>" />
					</span> <span class="thirdField"> <input readonly id="text"
							class="serviceprice" type="text"
							name="RoomOpt[<?php echo $opno;?>][price]"
							value="<?php echo $opt_detail->default_price;?>" />
					</span></li>
        <?php
								endforeach
								;
								?>
    </ul>


				<div class="clear25"></div>
				<span class="Subheading">Hotel marketing : </span>
				<div class="normal">The Hotel agrees not to distribute promotional
					emails or marketing to the clients acquired via DAYSTAY
					(daystay-hotels.com)</div>
				<span class="Subheading">Implementation : </span>
				<p class="normal">
					The present agreement is actually implemented solely on acceptance
					by DAYSTAY in accordance with the clause 13 of the terms. This
					acceptance can be granted or denied by DAYSTAY and remains at its
					own discretion.<br /> <br /> By signing here below, the signatory
					hereby
				</p>

				<div class="signature">
					<div class="leftPane">
						<ul>
							<li class="floating"><label class="w80">Date</label> <span
								class="firstField"><input id="text" type="text"
									name="Sign[date]" value="" readonly /></span> <label>On</label>
								<span class="secondField"><input id="text" type="text"
									name="Sign[on]" value="" readonly /></span></li>
							<li class="floating"><label class="w80">Signatory</label> <span><input
									id="text" placeholder="(Print name)" type="text"
									name="Sign[name]" value="" readonly /></span></li>
							<li class="floating"><label class="w80 textareaLabel">Signature</label>
								<span><textarea readonly></textarea>
									<div class="signText">Hotel</div></span></li>
						</ul>
					</div>
					<div class="rightPane">
						<ul>
							<li class="floating"><span><textarea readonly></textarea>
									<div class="signText">DayStay</div></span></li>
						</ul>
					</div>
				</div>


				<div class="clear"></div>
				<div class="withlineWrapper">
					<p class="withline">
						<a href="#">General terms</a>
					</p>
				</div>
				<div class="clear30"></div>
				<div class="bottomAddress">LLC with a capital stock of 48.250
					&#8364; - headquarters : 5, rue de Rochechouart 75009 Paris FRANCE.
					- Siret : 524 948 924 00013 - Siren : 524 948 924</div>
				<div class="clear20"></div>

			</div>
		</div>
	</span>


	<!-- ---------------------Page Two Start  -->
	<span class="wrapper contentPart contract">
		<div class="container3">
			<div class="contentCont no-paddingBtm" style="min-height: 1050px;">
				<span class="smalllogo"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/logo_contract.png" /></span>
				<div>
					<span class="mainheading">HOTEL CONTRACT</span>
				</div>
				<div class="clear50"></div>
				<span class="Subheading">Amenities : </span>
				<ul class="featurelist">
            <?php
												foreach ( $equipments as $eky => $equipment ) :
													$selected = (in_array ( $equipment->id, $hotelequip )) ? "checked" : "";
													?>
                <li><div class="CustomCheckbox">
							<span><input type="checkbox"
								value="<?php echo $equipment->id; ?>" name="Hotel[equip][]"
								class="checkboxItemCustom"
								label="<?php echo $equipment->name; ?>" <?php echo $selected;?>></span>
						</div></li>
                <?php
												endforeach
												;
												?>
          </ul>
				<div class="clear50"></div>
				<span class="Subheading">Category : </span>
				<ul class="featurelist">
            <?php
												foreach ( $themes as $thky => $theme ) :
													$selected = (in_array ( $theme->id, $hotelthemes )) ? "checked" : "";
													?>
                <li><div class="CustomCheckbox">
							<span><input type="checkbox" value="<?php echo $theme->id; ?>"
								name="Hotel[theme][]" class="checkboxItemCustom"
								label="<?php echo $theme->name; ?>" <?php echo $selected;?>></span>
						</div></li>
            <?php
												endforeach
												;
												?>
           </ul>
				<!--<div class="clear25"></div>
          <ul class="featurelist">
            <li><div class="CustomCheckbox"><span><input type="checkbox" value="Independant" name="Category[]" class="checkboxItemCustom" label="Independant"></span></div></li>
            <li class="withinput"><div class="CustomCheckbox"><span><input type="checkbox" value="Chain" name="Category[]" class="checkboxItemCustom" label="Chain"></span></div><span><input class="inputField" id="text" type="text" name="Chain[detail]" value="<?php if(isset(Yii::app()->session['chain']['detail'])){echo Yii::app()->session['chain']['detail'];} ?>" /></span>
            </li>
          </ul>-->
				<div class="clear25"></div>
				<ul class="detailForm" style="display: inline-block; width: 100%;">
            <?php
												foreach ( $content as $cnky => $cont ) :
													$htcontent = HotelContent::model ()->find ( 'hotel_id=' . $hotel_id . ' and type="' . $cnky . '" and portal_id=' . Yii::app ()->params->default ['portalId'] );
													$added_content = ($htcontent != NULL) ? $htcontent->content : "";
													if ($cnky == 'description') {
														?>
                <li class="floating"><label><b><?php echo $cont;?> :</b>
						<p class="small">(15 lines)</p></label><span><textarea
								name="Hotel[content][<?php echo $cnky;?>]"><?php echo strip_tags($added_content);?></textarea></span>
					</li>
                <?php
													} else {
														?>
                <li class="floating"><label><b><?php echo $cont;?> :</b>
					</label><span><input id="text" type="text"
							name="Hotel[content][<?php echo $cnky;?>]"
							value="<?php echo strip_tags($added_content);?>" /></span></li>
                <?php
													}
												endforeach
												;
												?>
          </ul>

				<div class="clear30"></div>
				<div class="bottomAddress">LLC with a capital stock of 48.250
					&#8364; - headquarters : 5, rue de Rochechouart 75009 Paris FRANCE.
					- Siret : 524 948 924 00013 - Siren : 524 948 924</div>
				<div class="clear20"></div>
			</div>
		</div>
	</span>
</div>