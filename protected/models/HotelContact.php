<?php

/**
 * This is the model class for table "{{hotel_contact}}".
 *
 * The followings are the available columns in table '{{hotel_contact}}':
 * @property string $id
 * @property integer $hotel_id
 * @property integer $contact_type
 * @property string $first_name
 * @property string $last_name
 * @property string $telephone
 * @property string $email_address
 * @property string $added_at
 * @property string $updated_at
 */
class HotelContact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_hotel_contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hotel_id, contact_type, added_at, updated_at', 'required'),
			array('hotel_id, contact_type', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>75),
			array('telephone', 'length', 'max'=>15),
			array('email_address', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id, contact_type, first_name, last_name, telephone, email_address, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'contact_type' => '1-General manager,2-Day to day contact,3-Reception contact,4-Accounting contact,5-Email to receive the reservations requests',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'telephone' => 'Telephone',
			'email_address' => 'Email Address',
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
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('contact_type',$this->contact_type);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('email_address',$this->email_address,true);
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
	 * @return HotelContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
