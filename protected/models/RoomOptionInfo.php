<?php

/**
 * This is the model class for table "tbl_room_option_info".
 *
 * The followings are the available columns in table 'tbl_room_option_info':
 * @property integer $id
 * @property integer $equipment_id
 * @property integer $language_id
 * @property string $description
 * @property string $term_condition
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblRoomOptions $roomOption
 * @property TblLanguage $language
 */
class RoomOptionInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_room_option_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('added_at, updated_at', 'required'),
			array('equipment_id, language_id', 'numerical', 'integerOnly'=>true),
			array('description, term_condition', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, equipment_id, language_id, description, term_condition, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'roomOption' => array(self::BELONGS_TO, 'Equipment', 'equipment_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'equipment_id' => 'Equipment Id',
			'language_id' => 'Language',
			'description' => 'Description',
			'term_condition' => 'Term Condition',
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
		$criteria->compare('equipment_id',$this->equipment_id);
		$criteria->compare('language_id',$this->language_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('term_condition',$this->term_condition,true);
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
	 * @return RoomOptionInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}