<?php

/**
 * This is the model class for table "{{room_status_def}}".
 *
 * The followings are the available columns in table '{{room_status_def}}':
 * @property string $id
 * @property integer $room_id
 * @property string $dyname
 * @property string $room_status
 * @property integer $room_no
 */
class RoomStatusDef extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{room_status_def}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_id, dyname, room_status, room_no', 'required'),
			array('room_id, room_no', 'numerical', 'integerOnly'=>true),
			array('dyname', 'length', 'max'=>5),
			array('room_status', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, room_id, dyname, room_status, room_no', 'safe', 'on'=>'search'),
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
			'dyname' => 'Dyname',
			'room_status' => 'Room Status',
			'room_no' => 'Room No',
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
		$criteria->compare('dyname',$this->dyname,true);
		$criteria->compare('room_status',$this->room_status,true);
		$criteria->compare('room_no',$this->room_no);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RoomStatusDef the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
