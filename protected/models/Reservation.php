<?php

/**
 * This is the model class for table "tbl_reservation".
 *
 * The followings are the available columns in table 'tbl_reservation':
 * @property string $id
 * @property integer $customer_id
 * @property integer $portal_id
 * @property integer $room_id
 * @property string $res_date
 * @property string $res_from
 * @property string $res_to
 * @property double $room_price
 * @property integer $currency_id
 * @property string $comment
 * @property string $arrival_time
 * @property integer $is_secret
 * @property integer $origin_id
 * @property string $reservation_code
 * @property integer $reservation_status
 * @property integer $payment_status
 * @property integer $country_code
 * @property integer $added_by
 * @property integer $updated_by
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblCurrency $currency
 * @property TblCustomer $customer
 * @property TblPortal $portal
 * @property TblRoom $room
 * @property TblReservationOption[] $tblReservationOptions
 */
class Reservation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reservation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('res_date, res_from, res_to, room_price, reservation_code, added_at, updated_at', 'required'),
			array('customer_id, portal_id, origin_id,room_id, currency_id, is_secret, reservation_status,added_by,updated_by,payment_status', 'numerical', 'integerOnly'=>true),
			array('room_price', 'numerical'),
			array('reservation_code', 'length', 'max'=>30),
			array('arrival_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, portal_id, room_id, res_date, res_from, res_to, room_price, currency_id, country_code, comment, arrival_time, is_secret, reservation_code, reservation_status, payment_status, added_by, updated_by, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'countryObj' => array(self::BELONGS_TO, 'Country', 'country_code'),
			'addedBy' => array(self::BELONGS_TO, 'AdminUser', 'added_by'),
			'updatedBy' => array(self::BELONGS_TO, 'AdminUser', 'updated_by'),
			'portal' => array(self::BELONGS_TO, 'Portal', 'portal_id'),
			'room' => array(self::BELONGS_TO, 'Room', 'room_id'),
			'reservationOptions' => array(self::HAS_MANY, 'ReservationOption', 'reservation_id'),
                        'origin' => array(self::BELONGS_TO, 'Origin', 'origin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'portal_id' => 'Portal',
			'room_id' => 'Room',
			'res_date' => 'Res Date',
			'res_from' => 'Res From',
			'res_to' => 'Res To',
			'room_price' => 'Room Price',
			'currency_id' => 'Currency',
			'comment' => 'Comment',
			'arrival_time' => 'Arrival Time',
			'is_secret' => 'Is Secret',
                        'origin_id' => 'Origin Id',
			'reservation_code' => 'Reservation Code',
			'reservation_status' => '0-inprogress 1-confirmed 2-waitingforconfirmation 3-cancelledbyuser 4-cancelledbyhotel 5-noshow',
			'payment_status' => 'Payment Status',
			'added_by' => 'Added By',
            'updated_by' => 'Updated By',
			'added_at' => 'Added At',
			'updated_at' => 'Updated At',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('portal_id',$this->portal_id);
		$criteria->compare('room_id',$this->room_id);
		$criteria->compare('res_date',$this->res_date,true);
		$criteria->compare('res_from',$this->res_from,true);
		$criteria->compare('res_to',$this->res_to,true);
		$criteria->compare('room_price',$this->room_price);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('arrival_time',$this->arrival_time,true);
		$criteria->compare('is_secret',$this->is_secret);
                $criteria->compare('origin_id',$this->origin_id);
		$criteria->compare('reservation_code',$this->reservation_code,true);
		$criteria->compare('reservation_status',$this->reservation_status);
		$criteria->compare('payment_status',$this->payment_status);
		$criteria->compare('added_by',$this->added_by);
        $criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reservation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Create and update reservation data
         * 
         * @param objecty $roomObject
         * @param int $customerId
         * @param array $postData
         * @return objecty
         */
       public function createAndUpdate($roomObject, $customerId, $postData){
           
           if($postData['id']) {
               $reservationModel = Reservation::model()->findByPk($postData['id']);
               $reservationModel->updated_at = new CDbExpression('NOW()');
           } else {
               $reservationModel = new Reservation();
               $reservationModel->added_at = new CDbExpression('NOW()');
           }
            $verificationCode = "12345"; //TODO= need to remove
            if(isset($postData['input_verification_code'])){
                $verificationCode = $postData['input_verification_code'];
            }
            $isSecret = 0;
            if(isset($postData['is_secret'])){
                $isSecret = $postData['is_secret'];
            }
            if(isset($postData['comment'])){
                $comment = $postData['comment'];
            }
            if(!empty($postData['reservation_code'])){
                 $reservationModel->nb_reservation = $postData['reservation_code'];
            }
            $reservationModel->customer_id = $customerId;
           
            $reservationModel->portal_id = 1; //TODO: Need to confirm with team
            $reservationModel->room_id = $roomObject->id;
            if(!empty($postData['booking_date'])){
                $reservationModel->res_date = $postData['booking_date'];
            }
            $reservationModel->res_from = $roomObject->available_from;
            $reservationModel->res_to = $roomObject->available_till;
            $reservationModel->room_price = $roomObject->default_price;
            $reservationModel->currency_id = 1; //TODO: Need to confirm with team
            $reservationModel->comment = $comment;
            if(!empty($postData['arrival_time'])){
                $reservationModel->arrival_time = $postData['arrival_time'];
            }
            $reservationModel->is_secret = $isSecret;
            $reservationModel->reservation_code = $verificationCode;
            if(!empty($postData['onRequestFlag'])){
                $reservationModel->reservation_status = $postData['onRequestFlag'];
            }
            $reservationModel->payment_status = 1; //TODO: Need to confirm with team
            return $reservationModel->save();
       }
}
