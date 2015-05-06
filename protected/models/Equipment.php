<?php

/**
 * This is the model class for table "{{equipment}}".
 *
 * The followings are the available columns in table '{{equipment}}':
 * @property integer $id
 * @property integer $hotel_id
 * @property string $name
 * @property string $type
 * @property integer $base_type
 * @property integer $option_type_id
 * @property integer $cc_required
 * @property string $ordered_before
 * @property double $default_price
 * @property integer $currency_id
 * @property integer $status
 * @property integer $show_order
 * @property integer $searchable_type
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property OptionType $optionType
 * @property HotelEquipment[] $hotelEquipments
 * @property ReservationOption[] $reservationOptions
 * @property RoomOptionInfo[] $roomOptionInfos
 * @property RoomOptions[] $roomOptions
 */
class Equipment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, updated_at', 'required'),
			array('hotel_id, base_type, option_type_id, cc_required, currency_id, status, show_order, searchable_type', 'numerical', 'integerOnly'=>true),
			array('default_price', 'numerical'),
			array('name', 'length', 'max'=>150),
			array('type', 'length', 'max'=>5),
			array('ordered_before', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id, name, type, base_type, option_type_id, cc_required, ordered_before, default_price, currency_id, status, show_order, searchable_type, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currency_id'),
			'optionType' => array(self::BELONGS_TO, 'OptionType', 'option_type_id'),
			'hotelEquipments' => array(self::HAS_MANY, 'HotelEquipment', 'equipment_id'),
			'reservationOptions' => array(self::HAS_MANY, 'ReservationOption', 'equipment_id'),
			'roomOptionInfos' => array(self::HAS_MANY, 'RoomOptionInfo', 'equipment_id'),
			'roomOptions' => array(self::HAS_MANY, 'RoomOptions', 'equipment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hotel_id' => 'Hotel',
			'name' => 'Name',
			'type' => 'Type',
			'base_type' => 'Base Type',
			'option_type_id' => 'Option Type',
			'cc_required' => 'Cc Required',
			'ordered_before' => 'Ordered Before',
			'default_price' => 'Default Price',
			'currency_id' => 'Currency',
			'status' => 'Status',
			'show_order' => 'Show Order',
			'searchable_type' => 'Searchable Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('base_type',$this->base_type);
		$criteria->compare('option_type_id',$this->option_type_id);
		$criteria->compare('cc_required',$this->cc_required);
		$criteria->compare('ordered_before',$this->ordered_before,true);
		$criteria->compare('default_price',$this->default_price);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('show_order',$this->show_order);
		$criteria->compare('searchable_type',$this->searchable_type);
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
	 * @return Equipment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getAllEquipment($criteria="") {
		return self::model ()->findAll($criteria);
	}
}
