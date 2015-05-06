<?php

/**
 * This is the model class for table "tbl_room_availability".
 *
 * The followings are the available columns in table 'tbl_room_availability':
 * @property string $id
 * @property integer $room_id
 * @property string $availability_date
 * @property integer $nb_rooms
 * @property string $room_status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblRoom $room
 */
class RoomAvailability extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_room_availability';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('availability_date, nb_rooms, room_status, added_at, updated_at', 'required'),
			array('room_id, nb_rooms', 'numerical', 'integerOnly'=>true),
			array('room_status', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, room_id, availability_date, nb_rooms, room_status, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'room' => array(self::BELONGS_TO, 'TblRoom', 'room_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'room_id' => 'Room',
			'availability_date' => 'Availability Date',
			'nb_rooms' => 'Nb Rooms',
			'room_status' => 'Room Status',
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
		$criteria->compare('room_id',$this->room_id);
		$criteria->compare('availability_date',$this->availability_date,true);
		$criteria->compare('nb_rooms',$this->nb_rooms);
		$criteria->compare('room_status',$this->room_status,true);
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
	 * @return RoomAvailability the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
