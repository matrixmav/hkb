<?php

/**
 * This is the model class for table "{{inv_reservation}}".
 *
 * The followings are the available columns in table '{{inv_reservation}}':
 * @property string $id
 * @property string $nb_reservation
 * @property string $opt_type
 * @property integer $opt_id
 * @property string $opt_title
 * @property double $opt_price
 * @property integer $opt_curr_id
 * @property double $comm_perc
 * @property double $comm_amt
 * @property double $vat_perc
 * @property double $total_comm_amt
 * @property string $added_at
 * @property string $updated_at
 */
class InvReservation extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_invoice_reservation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nb_reservation, hotel_id, res_date, opt_type, added_at, updated_at', 'required'),
            array('hotel_id, opt_id, opt_curr_id, status', 'numerical', 'integerOnly' => true),
            array('opt_price, comm_perc, comm_amt, vat_perc, vat_amt, total_comm_amt', 'numerical'),
            array('nb_reservation', 'length', 'max' => 20),
            array('opt_type', 'length', 'max' => 6),
            array('opt_title', 'length', 'max' => 100),
            array('availed', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nb_reservation, hotel_id, res_date, opt_type, opt_id, opt_title, opt_price, opt_curr_id, comm_perc, comm_amt, vat_perc, vat_amt, total_comm_amt, status, availed, added_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                    'reservation' => array(self::BELONGS_TO, 'Reservation', 'nb_reservation'),
                    'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nb_reservation' => 'Nb Reservation',
            'hotel_id' => 'Hotel',
            'res_date' => 'Res Date',
            'opt_type' => 'Opt Type',
            'opt_id' => 'Opt',
            'opt_title' => 'Opt Title',
            'opt_price' => 'Opt Price',
            'opt_curr_id' => 'Opt Curr',
            'comm_perc' => 'Comm Perc',
            'comm_amt' => 'Comm Amt',
            'vat_perc' => 'Vat Perc',
            'vat_amt' => 'Vat Amt',
            'total_comm_amt' => 'Total Comm Amt',
            'status' => '0:Deleted,1:pending,2:confirmed,5:noshow',
            'availed' => 'Availed',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('nb_reservation', $this->nb_reservation, true);
        $criteria->compare('hotel_id', $this->hotel_id);
        $criteria->compare('res_date', $this->res_date, true);
        $criteria->compare('opt_type', $this->opt_type, true);
        $criteria->compare('opt_id', $this->opt_id);
        $criteria->compare('opt_title', $this->opt_title, true);
        $criteria->compare('opt_price', $this->opt_price);
        $criteria->compare('opt_curr_id', $this->opt_curr_id);
        $criteria->compare('comm_perc', $this->comm_perc);
        $criteria->compare('comm_amt', $this->comm_amt);
        $criteria->compare('vat_perc', $this->vat_perc);
        $criteria->compare('vat_amt', $this->vat_amt);
        $criteria->compare('total_comm_amt', $this->total_comm_amt);
        $criteria->compare('status', $this->status);
        $criteria->compare('availed', $this->availed, true);
        $criteria->compare('added_at', $this->added_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InvReservation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createInvoiceReservation($postDataArray, $reservation_status = 1) {

        $invoiceModel = new InvReservation;
        $roomObjecct = Room::model()->findByPk($postDataArray['roomId']);
        /*$invoiceStatus = 1; //1: inprogress
        if ($adminFlag) {
            $invoiceStatus = 2; //2: completed    
        }*/
        $invoiceStatus = ($reservation_status==2)? 1 : 2;
        
        $roomTariffCondition = array('room_id' => $postDataArray['roomId'], 'tariff_date' => $postDataArray['booking_date']);
        $roomTrriffObjecct = RoomTariff::model()->findByAttributes($roomTariffCondition);
        if ($roomObjecct) {
            $hotelObject = Hotel::model()->findByPk($roomObjecct->hotel_id);
            $hotelPercentage = $hotelObject->day_commission;
            if ($roomObjecct->category == 'moon') {
                $hotelPercentage = $hotelObject->night_commission;
            }
            $commAmount = BaseClass::getPercentage($roomTrriffObjecct->price, $hotelPercentage, 1);
            $invoiceModel->nb_reservation = $postDataArray['reservation_code'];
            $invoiceModel->hotel_id = $postDataArray['hotelId'];
            $invoiceModel->res_date = $postDataArray['booking_date'];
            $invoiceModel->opt_type = 'room';
            $invoiceModel->opt_id = 0;
            $invoiceModel->opt_title = $roomObjecct->name;
            $invoiceModel->opt_price = $roomTrriffObjecct->price;
            $invoiceModel->opt_curr_id = 1; //TODO: need to change 
            $invoiceModel->comm_perc = $hotelPercentage;
            $invoiceModel->comm_amt = $commAmount;
            $invoiceModel->vat_perc = 0.00; //TODO: need to change 
            $invoiceModel->vat_amt = 0.00; //TODO: need to change 
            $invoiceModel->status = $invoiceStatus; //In-progress
            $invoiceModel->total_comm_amt = ($commAmount + $roomTrriffObjecct->price);
            $invoiceModel->added_at = new CDbExpression('NOW()');
            $invoiceModel->updated_at = new CDbExpression('NOW()');
            $invoiceModel->save();
            if (!$invoiceModel->save()) {
                echo "<pre>";
                print_r($invoiceModel->getErrors());
                exit;
            }
            if (!empty($postDataArray['aditional_services'])) {
                foreach ($postDataArray['aditional_services'] as $services) {
                    $invoiceOptionModel = new InvReservation;
                    $serviceAndPrice = explode("_", $services); //$services

                    $hotelOptionPercentage = $hotelObject->addon_commission;
                    $equipmentObject = Equipment::model()->findByPk($serviceAndPrice['0']);
                    $commOptAmount = BaseClass::getPercentage($serviceAndPrice['1'], $hotelOptionPercentage, 1);
                    $invoiceOptionModel->nb_reservation = $postDataArray['reservation_code'];
                    $invoiceOptionModel->hotel_id = $postDataArray['hotelId'];
                    $invoiceOptionModel->res_date = $postDataArray['booking_date'];
                    $invoiceOptionModel->opt_type = 'opt';
                    $invoiceOptionModel->opt_id = $serviceAndPrice['0'];
                    $invoiceOptionModel->opt_title = $equipmentObject->name;
                    $invoiceOptionModel->opt_price = $serviceAndPrice['1'];
                    $invoiceOptionModel->opt_curr_id = 1; //TODO: changed after 
                    $invoiceOptionModel->comm_perc = $hotelOptionPercentage;
                    $invoiceOptionModel->comm_amt = $commAmount;
                    $invoiceOptionModel->vat_perc = 0.00; //TODO: need to change 
                    $invoiceOptionModel->vat_amt = 0.00; //TODO: need to change 
                    $invoiceOptionModel->status = $invoiceStatus; //In-progress
                    $invoiceOptionModel->total_comm_amt = ($commOptAmount + $serviceAndPrice['1']);
                    $invoiceOptionModel->added_at = new CDbExpression('NOW()');
                    $invoiceOptionModel->updated_at = new CDbExpression('NOW()');
                    $invoiceOptionModel->save();
                    if (!$invoiceOptionModel->save()) {
                        echo "<pre>";
                        print_r($invoiceOptionModel->getErrors());
                        exit;
                    }
                }
            }
            return $invoiceModel;
        }
    }

    /**
     * delete invoice reservation
     * 
     * @param int $nbReservationId - nb reservation
     * @return true
     */
    public function deleteInvoiceReservationOption($nbReservationId, $changeStatus = "") {
        if (!empty($changeStatus)) {
            // Update invoice table status to 2. 
            $invoiceReservationListObject = InvReservation::model()->findAll('nb_reservation = ' . $nbReservationId);
            if (count($invoiceReservationListObject) > 0) {
                foreach ($invoiceReservationListObject as $invoiceReservationObject) {
                    $invoiceReservationObject->status = 0; //0: Deleted
                    $invoiceReservationObject->save(); //update invoice table entry
                }
            }
        } else {
            $invoiceReservationOptionListObject = self::model()->findAll('nb_reservation = ' . $nbReservationId);
            foreach ($invoiceReservationOptionListObject as $invoiceReservationObject) {
                $invoiceReservationObject->delete();
            }
        }
        return true;
    }

}
