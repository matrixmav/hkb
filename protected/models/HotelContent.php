<?php

/**
 * This is the model class for table "tbl_hotel_content".
 *
 * The followings are the available columns in table 'tbl_hotel_content':
 * @property integer $id
 * @property integer $portal_id
 * @property integer $hotel_id
 * @property string $content
 * @property string $type
 * @property integer $language_id
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property Portal $portal
 * @property Hotel $hotel
 */
class HotelContent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_hotel_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, type', 'required'),
			array('portal_id, hotel_id, language_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>11),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
					
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, portal_id, hotel_id, content, type, language_id, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
			'portal' => array(self::BELONGS_TO, 'Portal', 'portal_id'),
			'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'portal_id' => 'Portal',
			'hotel_id' => 'Hotel',
			'content' => 'Content',
			'type' => 'Type',
			'language_id' => 'Language',
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
		$criteria->compare('portal_id',$this->portal_id);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('language_id',$this->language_id);
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
	 * @return HotelContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getAllHotelContent($criteria="") {
		return self::model ()->findAll($criteria);
	}
}
