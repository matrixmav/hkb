<?php

/**
 * This is the model class for table "tbl_reservation_option".
 *
 * The followings are the available columns in table 'tbl_reservation_option':
 * @property string $id
 * @property string $reservation_id
 * @property integer $equipment_id
 * @property double $equipment_price
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblEquipment $equipment
 * @property TblReservation $reservation
 */
class ReservationOption extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_reservation_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipment_price, added_at, updated_at', 'required'),
			array('equipment_id', 'numerical', 'integerOnly'=>true),
			array('equipment_price', 'numerical'),
			array('reservation_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, reservation_id, equipment_id, equipment_price, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'equipment' => array(self::BELONGS_TO, 'Equipment', 'equipment_id'),
			'reservation' => array(self::BELONGS_TO, 'Reservation', 'reservation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'reservation_id' => 'Reservation',
			'equipment_id' => 'Equipment',
			'equipment_price' => 'Equipment Price',
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
		$criteria->compare('reservation_id',$this->reservation_id,true);
		$criteria->compare('equipment_id',$this->equipment_id);
		$criteria->compare('equipment_price',$this->equipment_price);
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
	 * @return ReservationOption the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    /**
     * Save services in to db
     * 
     * @param type $postDataArray
     */
    public function create($postDataArray, $reservationId){
        foreach ($postDataArray as $services) {
            $reservationOptionModel = new ReservationOption;
            $serviceAndPrice = explode("_", $services); //$services
            $reservationOptionModel->reservation_id = $reservationId;
            $reservationOptionModel->equipment_id = $serviceAndPrice['0'];
            $reservationOptionModel->equipment_price = $serviceAndPrice['1'];
            $reservationOptionModel->added_at = new CDbExpression('NOW()');
            $reservationOptionModel->updated_at = new CDbExpression('NOW()');
            //Inserte in reservation option table
            $reservationOptionModel->save();
        }
    }
}
