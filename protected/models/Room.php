<?php

/**
 * This is the model class for table "tbl_room".
 *
 * The followings are the available columns in table 'tbl_room':
 * @property integer $id
 * @property string $name
 * @property integer $hotel_id
 * @property string $category
 * @property string $room_status
 * @property integer $quantity
 * @property integer $currency_id
 * @property double $default_price
 * @property double $default_discount_price
 * @property double $default_night_price
 * @property double $default_discount_night_price
 * @property string $available_from
 * @property string $available_till
 * @property string $exhausted_status
 * @property integer $cc_required
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Reservation[] $reservations
 * @property Hotel $hotel
 * @property Currency $currency
 * @property RoomAvailability[] $roomAvailabilities
 * @property RoomInfo[] $roomInfos
 * @property RoomOptions[] $roomOptions
 * @property RoomTariff[] $roomTariffs
 */
class Room extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_room';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category, room_status, quantity, default_price, default_night_price, available_from, available_till, exhausted_status', 'required'),
			array('hotel_id, quantity, currency_id, cc_required', 'numerical', 'integerOnly'=>true),
			array('default_price, default_discount_price, default_night_price, default_discount_night_price', 'numerical'),
			array('name', 'length', 'max'=>150),
			array('category, exhausted_status', 'length', 'max'=>7),
			array('room_status', 'length', 'max'=>9),
		    array('status','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, hotel_id, category, room_status, quantity, currency_id, default_price, default_discount_price, default_night_price, default_discount_night_price, available_from, available_till, exhausted_status, cc_required, status, added_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'reservations' => array(self::HAS_MANY, 'Reservation', 'room_id'),
			'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'roomAvailabilities' => array(self::HAS_MANY, 'RoomAvailability', 'room_id'),
			'roomInfos' => array(self::HAS_MANY, 'RoomInfo', 'room_id'),
			'roomOptions' => array(self::HAS_MANY, 'RoomOptions', 'room_id'),
			'roomTariffs' => array(self::HAS_MANY, 'RoomTariff', 'room_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'hotel_id' => 'Hotel',
			'category' => 'Category',
			'room_status' => 'Room Status',
			'quantity' => 'Quantity',
			'currency_id' => 'Currency',
			'default_price' => 'Default Price',
			'default_discount_price' => 'Default Discount Price',
			'default_night_price' => 'Default Night Price',
			'default_discount_night_price' => 'Default Discount Night Price',
			'available_from' => 'Available From',
			'available_till' => 'Available Till',
			'exhausted_status' => 'Exhausted Status',
			'cc_required' => 'Cc Required',
			'added_at' => 'Added At',
			'updated_at' => 'Updated At',
			'status' => 'Status',	
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('room_status',$this->room_status,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('default_price',$this->default_price);
		$criteria->compare('default_discount_price',$this->default_discount_price);
		$criteria->compare('default_night_price',$this->default_night_price);
		$criteria->compare('default_discount_night_price',$this->default_discount_night_price);
		$criteria->compare('available_from',$this->available_from,true);
		$criteria->compare('available_till',$this->available_till,true);
		$criteria->compare('exhausted_status',$this->exhausted_status,true);
		$criteria->compare('cc_required',$this->cc_required);
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('status',$this->status,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getRoomTariff($roomid,$date)
	{
		$newDate = date("Y-m-d", strtotime($date));
		$criteria=new CDbCriteria();
		$criteria->condition = "tariff_date >= '".$newDate."' AND room_id=".$roomid;
		$criteria->order='price ASC';
		$criteria->limit=1;
		$roomtarrif = RoomTariff::model()->findAll($criteria);
		if(!empty($roomtarrif))
		{
			foreach ($roomtarrif as $getleastprice){
				$fromprice = number_format($getleastprice->price);
			}
		}else {
			//$getallrooms = Room::model()->findAllByAttributes(array("hotel_id"=>$hotelid));
			$room = Room::model()->findByPk(array($roomid));
			$fromprice = number_format($room->default_discount_price);
		}
		return $fromprice;
	}
	public function getRoomTypeImage($roomid)
	{
		$rooms = Room::model()->findByPk($roomid);
		if($rooms->category == "sun"){$image_time = "i1.png"; $defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "halfsun"){$image_time = "i2.png";$defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "moon"){$image_time = "i3.png";$defaultprice = $rooms->default_discount_night_price;}
		return $image_time;
	}
	public function getRoomTypeImagemobile($roomid)
	{
		$rooms = Room::model()->findByPk($roomid);
		if($rooms->category == "sun"){$image_time = "i4.png"; $defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "halfsun"){$image_time = "i5.png";$defaultprice = $rooms->default_discount_price;}elseif($rooms->category == "moon"){$image_time = "i6.png";$defaultprice = $rooms->default_discount_night_price;}
		return $image_time;
	}
	
	public function getRoommainprice($roomid,$date)
	{
            $roomtarrif = RoomTariff::model()->findByAttributes(array('tariff_date'=>$date, 'room_id'=>$roomid));
            if(empty($roomtarrif)){
                return 0;
            }
            if($roomtarrif->price == 0)
            {
                    $newDate = date("Y-m-d", strtotime($date));
                    $criteria=new CDbCriteria();
                    $criteria->condition = "tariff_date >= '".$newDate."' AND room_id=".$roomid;
                    $criteria->order='price ASC';
                    $criteria->limit=1;
                    $roomtarrif = RoomTariff::model()->findAll($criteria);
                    if(!empty($roomtarrif))
                    {
                            foreach ($roomtarrif as $getleastprice){
                                    $roomprice = number_format($getleastprice->price);
                            }
                    }else {
                            //$getallrooms = Room::model()->findAllByAttributes(array("hotel_id"=>$hotelid));
                            $room = Room::model()->findByPk(array($roomid));
                            if($room->category=="sun" || $room->category=="halfsun" )
                            {
                            $roomprice = number_format($room->default_discount_price);
                            }else {
                                    $roomprice = number_format($room->default_discount_night_price);
                            }
                    }
            }else{
                    $roomprice =  $roomtarrif->price;
            }
            return $roomprice;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Room the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getRoomTypes($hotelId) {
            $roomListObject = self::model()->findAll('hotel_id = ' . $hotelId);
            $sun = 0;
            $halfSun = 0;
            $moon = 0;
            $roomCategory = '';
            foreach ($roomListObject as $roomObject) {
                if ($roomObject->category == 'sun') {
                    $roomCategory['sun'] = 1;
                }
                if ($roomObject->category == 'halfsun') {
                    $roomCategory['halfsun'] = 1;
                }
                if ($roomObject->category == 'moon') {
                    $roomCategory['moon'] = 1;
                }
            }
            return $roomCategory;
    }
    public function getroomDiscount($room)
    {
        $price = $racprice = "";
        switch ($room->category) 
        {
            case "sun":
                $racprice = $room->default_price;
                $price = $room->default_discount_price;
                break;
            case "halfsun":
                $racprice = $room->default_price;
                $price = $room->default_discount_price;
                break;
            case "moon":
                $racprice = $room->default_night_price;
                $price = $room->default_discount_night_price;
                break;                                              
        }
        $discount = BaseClass::getPercentage($price,$racprice);
        
        return $discount;
    }
    public function getRoomsforSearch($mhotel)
    {
        $return = $sun = $half_sun = $moon = $show_rooms = array();
        
        $maxdiscount = 0;
        //Only take the active rooms
        $rooms = $mhotel->rooms(array('condition'=>'status=1','order' => 'category desc'));
        $room_nos = count($rooms);
        if($room_nos)
        {
            $rm=0;
            foreach ($rooms as $room):
                $return['room'][$rm]['roomType'] = $room->category;
                switch ($room->category) 
                {
                    case "sun":
                        $class_cat = 'icon1';  
                        $racprice = $room->default_price;
                        $price = $room->default_discount_price;
                        array_push($sun,$rm.'-'.$price);
                        break;
                    case "halfsun":
                        $class_cat = 'icon2';  
                        $racprice = $room->default_price;
                        $price = $room->default_discount_price;
                        array_push($half_sun,$rm.'-'.$price);
                    break;
                    case "moon":
                        $class_cat = 'icon3';
                        $racprice = $room->default_night_price;
                        $price = $room->default_discount_night_price;
                        array_push($moon,$rm.'-'.$price);
                    break;                                              
                }     
                $return['room'][$rm]['id'] = $room->id;
                $return['room'][$rm]['name'] = $room->name;
                $return['room'][$rm]['roomIcon'] = $class_cat;
                $return['room'][$rm]['avfrom'] = date("g:i a", strtotime($room->available_from));
                $return['room'][$rm]['avtill'] = date("g:i a", strtotime($room->available_till));
                $return['room'][$rm]['price'] = $price;
                $return['room'][$rm]['racprice'] = $racprice;
                $discount = BaseClass::getPercentage($price,$racprice);
                $return['room'][$rm]['discount'] = $discount;  
                
                if($discount > $maxdiscount)
                {
                    $maxdiscount = $discount;
                }
                                
                $rm++;
            endforeach;
            
            //Display first Dayuse, second LAtebreak, night. If several of same category display only the one which
            //has lesser price
            
            $show_rooms = array();
            if(count($sun)!=0)
            {
                $ky = $this->getlowestrange($sun, $return);
                array_push($show_rooms,$ky);
            }
            
            
            if(count($half_sun)!=0)
            {
                $ky = $this->getlowestrange($half_sun, $return);
                array_push($show_rooms,$ky);
            }
            
            if(count($moon)!=0)
            {
                $ky = $this->getlowestrange($moon, $return);
                array_push($show_rooms,$ky);
            }
            
        }
        
        $return['maxdiscount'] = $maxdiscount;        
        $return['show_rooms'] = $show_rooms;        
        return $return;        
    }
    public function getlowestrange($type,$return)
    {
        $prev = 1000000000;
        $reqId = 0;
        
        //Get the lowest price one    
        foreach ($type as $val):
            $ex = explode("-", $val);
            $kyval = $ex[0];
            $price = $return['room'][$kyval]['price'];
            if($price < $prev)
            {
                $reqId = $kyval;
                $prev = $price;
            }
        endforeach;
        
        return $reqId;
    }
    
    public function hotelRoomDetails($hotelid,$date,$arrtime)
    {
        $str_detail="";
        
        $isToday = 0;
        $isToday = ($date == date('d/m/Y')) ? 1 : 0;

        if ($arrtime == "ARRIVAL TIME") {
            $arrtime = "";
            $arrtime1 = "";
        } else {
            $arrtime1 = base64_encode($arrtime);
        }
        $newDate = date("Y-m-d", strtotime($date));
        $image_time = "";

        $criteriaall = new CDbCriteria();
        $criteriaall->addCondition("hotel_id=" . $hotelid);
        $criteriaall->addCondition("status=1");

        if ($isToday)
            $criteriaall->addCondition("TIMEDIFF(available_till, DATE_FORMAT(NOW(),'%H:%i:%s'))>2");
        else {
            if ($arrtime != "") {
                $criteriaall->addCondition("available_from <='" . $arrtime . "'");
                $criteriaall->addCondition("available_till >'" . $arrtime . "'");
            }
        }

        $getallrooms = Room::model()->findAll($criteriaall);

        $roomavailability = RoomAvailability::model()->findAllByAttributes(array("availability_date" => $newDate));
        $i = 0;
        if (empty($getallrooms)) {
            $str_detail.="No Rooms Available";
        } else {
            foreach ($getallrooms as $rooms) {
                foreach ($roomavailability as $availabilityroom) {
                    if (($rooms->id == $availabilityroom->room_id)) {

                        $hasroom = "one";

                        if ($rooms->category == "sun") {
                            $image_time = "i1.png";
                            $racprice = $rooms->default_price;
                            $price = $rooms->default_discount_price;
                        } elseif ($rooms->category == "halfsun") {
                            $image_time = "i2.png";
                            $racprice = $rooms->default_price;
                            $price = $rooms->default_discount_price;
                        } elseif ($rooms->category == "moon") {
                            $image_time = "i3.png";
                            $racprice = $rooms->default_night_price;
                            $price = $rooms->default_discount_night_price;
                        }

                        $stat_info = array();   
                        $stat_info = BaseClass::getRoomReservation($availabilityroom->room_id,$rooms->hotel_id, $arrtime1, $newDate);
                        $roomcount = $stat_info['roomcount'];
                        $roomclass = $stat_info['roomclass'];
                        $roombutton = $stat_info['roombutton'];
                        $href = $stat_info['href'];

                        $timefrom = new DateTime($rooms->available_from);
                        $timetill = new DateTime($rooms->available_till);
                        $numberofrooms = RoomAvailability::model()->findByAttributes(array('room_id' => $availabilityroom->room_id, 'availability_date' => $newDate));
                        $str_detail.="<div class='room " . $roomclass . "'>";
                        if (($numberofrooms->nb_rooms == 1) || ($roomcount == 1)) {
                            $str_detail.="<p class='available'>1 room left</p>";
                        }

                        $discount = "-".BaseClass::getPercentage($price,$racprice);

                        $str_detail.="<img src='" . Yii::app()->request->baseUrl . "/images/" . $image_time . "' class='timeIcon' alt=''>";
                        
                        $opav = FALSE;
                        if (isset($rooms->roomOptions)) {
                            $option = "";
                            $opav = FALSE;
                            foreach ($rooms->roomOptions as $roomOptions) {
                                    $currencySymbol = $roomOptions->currency_id ? $roomOptions->currency->symbol : "";
                                $option .= "<li>" . $roomOptions->equipment->name . " (".$roomOptions->price." ". $currencySymbol .")<li>";
                                $opav = TRUE;                    
                            }
                        }
                        if($opav)
                        {
                            $str_detail.="<div class='information'>";
                            $str_detail.="<img src='" . Yii::app()->request->baseUrl . "/images/i4.png' alt=''>";
                            $str_detail.="<div class='infopopup'>";
                            $str_detail.="<ul><li>".$option."</li></ul>";
                            $str_detail.="</div></div>";
                        }
                        
                        $str_detail.="<div class='discountQuote'><span class='bigText'>";
                        $str_detail.=$discount. "<span class='persantage'>%</span></span>";
                        $str_detail.="</div><div class='price'>";
                        $str_detail.="<p class='bigtext'><sup>$</sup>" . number_format($price) . "</p>";
                        $str_detail.="<p class='oldPrice'><del>" . number_format($racprice). "</del> per night</p></div><div class='timing'>";
                        $str_detail.="<p>" . $timefrom->format('h:i A') . "<br>" . $timetill->format('h:i A') . "</p></div><div class='details'>";
                        $str_detail.="<p>" . $rooms->name . "</p></div>";
                        $str_detail.="<a href='" . $href . "' class='book statbook'>" . $roombutton . "</a></div>";
                    }
                }
            }
            if (!isset($hasroom)) {
                foreach ($getallrooms as $rooms) {
                    $timefrom = new DateTime($rooms->available_from);
                    $timetill = new DateTime($rooms->available_till);
                    if ($rooms->category == "sun") {
                        $image_time = "i1.png";
                        $racprice = $rooms->default_price;
                        $price = $rooms->default_discount_price;
                    } elseif ($rooms->category == "halfsun") {
                        $image_time = "i2.png";
                        $racprice = $rooms->default_price;
                        $price = $rooms->default_discount_price;
                    } elseif ($rooms->category == "moon") {
                        $image_time = "i3.png";
                        $racprice = $rooms->default_night_price;
                        $price = $rooms->default_discount_night_price;
                    }
                    $str_detail.="<div class='room notAvailable'>";
                    $str_detail.="<img src='" . Yii::app()->request->baseUrl . "/images/" . $image_time . "' class='timeIcon' alt=''>";
                    $str_detail.="<img src='" . Yii::app()->request->baseUrl . "/images/i4.png' class='information' alt=''>";
                    $str_detail.="<div class='discountQuote'><span class='smallText'>up to</span><span class='bigText'>";

                    $discount = "-".BaseClass::getPercentage($price,$racprice);

                    $str_detail.=$discount . "<span class='persantage'>%</span></span>";
                    $str_detail.="</div><div class='price'>";
                    $str_detail.="<p class='bigtext'><sup>$</sup>" . number_format($price) . "</p>";
                    $str_detail.="<p class='oldPrice'><del>" . intval($racprice) . "</del> per night</p></div><div class='timing'>";
                    $str_detail.="<p>" . $timefrom->format('h:i A') . "<br>" . $timetill->format('h:i A') . "</p></div><div class='details'>";
                    $str_detail.="<p>" . $rooms->name . "</p></div>";
                    $str_detail.="<a href='#' class='book'>Closed</a></div>";
                }
            }
        }
        
        return $str_detail;
    }

}
