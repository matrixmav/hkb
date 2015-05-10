<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $sponsor_id
 * @property string $name
 * @property string $password
 * @property string $position
 * @property string $full_name
 * @property string $email
 * @property integer $country_id
 * @property string $country_code
 * @property integer $phone
 * @property string $data_of_birth
 * @property string $skype_id
 * @property string $facebook_id
 * @property string $twitter_id
 * @property integer $master_pin
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class DummyData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dummydata';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sponsor_id, name, password, position, full_name, email, country_id, country_code, phone, data_of_birth, skype_id, facebook_id, twitter_id, master_pin, status, created_at, updated_at', 'required'),
			array('country_id, phone, master_pin, status', 'numerical', 'integerOnly'=>true),
			array('sponsor_id, password, email, skype_id, facebook_id, twitter_id', 'length', 'max'=>100),
			array('name, position', 'length', 'max'=>30),
			array('full_name', 'length', 'max'=>50),
			array('country_code', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sponsor_id, name, password, position, full_name, email, country_id, country_code, phone, data_of_birth, skype_id, facebook_id, twitter_id, master_pin, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'sponsor_id' => 'Sponsor',
			'name' => 'Name',
			'password' => 'Password',
			'position' => 'Position',
			'full_name' => 'Full Name',
			'email' => 'Email',
			'country_id' => 'Country',
			'country_code' => 'Country Code',
			'phone' => 'Phone',
			'data_of_birth' => 'Data Of Birth',
			'skype_id' => 'Skype',
			'facebook_id' => 'Facebook',
			'twitter_id' => 'Twitter',
			'master_pin' => 'Master Pin',
			'status' => 'Status',
			'created_at' => 'Created At',
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
		$criteria->compare('sponsor_id',$this->sponsor_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('data_of_birth',$this->data_of_birth,true);
		$criteria->compare('skype_id',$this->skype_id,true);
		$criteria->compare('facebook_id',$this->facebook_id,true);
		$criteria->compare('twitter_id',$this->twitter_id,true);
		$criteria->compare('master_pin',$this->master_pin);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
